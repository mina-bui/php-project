<?php 
/* we'll be using sessions on this page,
	so we must create/assign a unique id for this user
*/
session_start();

/* prepare some variables for later use */
$username				= "";
$password				= "";
$passwordRetyped		= "";

/* validate the form fields: ensure form data is set */
if(	!isset($_POST['username']) || 
	!isset($_POST['password']) || 
	!isset($_POST['passwordRetyped'])){
		
	$_SESSION['errorMessages'] = "<p class='error'>Please register, its real easy to do...</p>";
	header("Location: register.php");
	die();
}

/* validate the form fields: ensure form fields contain data */
if( trim($_POST['username'])=="" ||  trim($_POST['password'])=="" ){
	$_SESSION['errorMessages'] = "<p class='error'>Please fill in the registration form...</p>";
	header("Location: register.php");
	die();
}

/* store form field data in varaibles*/
$username				= trim($_POST['username']);
$password				= trim($_POST['password']);
$passwordRetyped		= trim($_POST['passwordRetyped']);

/* ensure the user has correctly typed thier chosesn password */
if( $password	 != $passwordRetyped	){
	$_SESSION['errorMessages'] = "<p class='error'>Sorry, passwords do not match...</p>";
	header("Location: register.php");
	die();
}

/* check the database to see if this individual username already exists */
require_once("dbinfo.php");
/* attempt a connection to MySQL */
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
/* determine if connection was successful */
if(mysqli_connect_errno() !=0 ){
	$_SESSION['errorMessages'] = "<p class='error'>Uh oh... could not connect to database to register you. Please try again later.</p>";
	header("Location: register.php");
	die();
}
/* 
determine if we can add this username to our table...
run a query, capture results in variable 
make sure this is a case sensitive query,
so use BINARY before each comparison
*/
/*
-----------------------------------------------------------------------------------------------
IMPORTANT: use real_escape_string() to protect against SQL injection
do this for ALL data that comes from an HTML form
before including the data into an SQL query
*/
$username = $database->real_escape_string($username);
$password = $database->real_escape_string($password);
/*
-----------------------------------------------------------------------------------------------
*/
$query = "SELECT * FROM users WHERE BINARY username='$username';";
$result = $database->query( $query );
/* if a record matches the username,
	then this username is already in use and cannot be duplicated
*/
if($result->num_rows > 0){
	$_SESSION['errorMessages'] = "<p class='error'>The username '$username' is already in use, please choose a different one...</p>";
	header("Location: register.php");
	die();
}
/*
-----------------------------------------------------------------------------------------------
IMPORTANT: use a hashing algorithm to the password before storing in DB
$hashedPassword = password_hash($unhashedPassword , PASSWORD_BCRYPT)
*/
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);


$query = "INSERT INTO users (username, password) VALUES('$username','$hashedPassword');";
$result = $database->query( $query );
//ensure our attempt to insert was a success
if( $database->affected_rows == 0){
		$_SESSION['errorMessages'] = "<p>There was a problem adding you to our database. Please try again.</p>";
		header("Location: register.php");
		die();
}
/* close MySQL connection */
$database->close();
/* if the script gets this far,
	this user was successfully added to our database
*/
$_SESSION['errorMessages'] = "<p>You have been registered as awesome with us. Feel free to login whenever you like.</p>";
header("Location: login.php");
die();

?>
