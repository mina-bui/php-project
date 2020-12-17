<?php 
/* we'll be using sessions on this page,
	so we must create/assign a unique id for this user
*/
session_start();

/* prepare some variables for later use*/
$username = "";
$password = "";

/* validate the form fields: ensure form data is set */
if(!isset($_POST['username']) || !isset($_POST['password']) ){
	$_SESSION['errorMessages'] = "<p class='error'>Please login...</p>";
	header("Location: login.php");
	die();
}
/* validate the form fields: ensure form fields contain data */
if( trim($_POST['username'])=="" ||  trim($_POST['password'])=="" ){
	$_SESSION['errorMessages'] = "<p class='error'>Please fill in the form...</p>";
	header("Location: login.php");
	die();
}

/* store form field data in variables*/
$username = trim($_POST['username']);
$password = trim($_POST['password']);

/* check the database for this individual */
require_once("dbinfo.php");
/* attempt a connection to MySQL */
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
/* determine if connection was successful */
if(mysqli_connect_errno() !=0 ){
	$_SESSION['errorMessages'] = "<p class='error'>Uh oh... could not connect to database to log you in. Please try again later.</p>";
	header("Location: login.php");
	die();
}

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
IMPORTANT: the password_verify() function requires the hashedPasswordpassword before it can be run.
this means we will need to get it from the database before we can see if it is a match

password_verify( $userProvidedPassword, $hashedPassword)

alter this query to SELECT the password field for any records 
that match the username provided by the HTML form
*/
$query = "SELECT password FROM users WHERE BINARY username='$username';";
$result = $database->query($query);

/* process query results */
/* if no records matched the provided username/password, 
	then this user is not in our database, and so are unauthorized
*/
if($result->num_rows != 1){
	$_SESSION['errorMessages'] = "<p class='error'>Invalid username. Try again...</p>";
	header("Location: login.php");
	die();
}
/*
if the username is in the database, 
get the first (and only) record from the $result using fetch_row(),
fetch_row() returns a record as an array
*/
$record = $result->fetch_row();
//get the first field of the record array
$passwordFieldFromDatabase = $record[0];
/*
password_verify( $providedPassword, $hashedPassword ) 
returns true of the two passwords match, false if no match
*/
if(password_verify( $password, $passwordFieldFromDatabase) == false ){
	$_SESSION['errorMessages'] = "<p class='error'>Invalid password. Try again...</p>";
	header("Location: login.php");
	die();	
}

/* close MySQL connection */
$database->close();

/* if the script gets this far without die()ing or forwarding to the form,
	then this user is one of those listed in the 'users' database table
	log this user in, forward them to the content page 
*/
//remember who they are
//format the name also
$_SESSION['username'] = ucfirst(strtolower($username));

header("Location: content.php");
die();

?>

