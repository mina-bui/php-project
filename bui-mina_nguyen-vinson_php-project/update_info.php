<?php

@session_start();

$isValid = true;
$isSuccess = false;

//--- ERROR AND SUCCESS MESSAGES 
$successMessages = array();
$errorMessages = array();

// Checking for set & empty
//--- Studentnumber
if(!isset($_POST['studentnumber']) || $_POST['studentnumber'] == "") {
	$errorMessages[] = "<p>Please enter a student number in the field.</p>";
	$isValid = false;
}
//--- Firstname
if(!isset($_POST['firstname']) || $_POST['firstname'] == "") {
	$errorMessages[] = "<p>Please enter a first name in the field.</p>";
	$isValid = false;
}
//--- Lastname
if(!isset($_POST['lastname']) || $_POST['lastname'] == "") {
	$errorMessages[] = "<p>Please enter a last name in the field.</p>";
	$isValid = false;
}
 
 // test student number format
$pattern = "/^a0[0-9]{7}$/i";
if(preg_match($pattern, trim($_POST['studentnumber'])) != 1) {
	$errorMessages[] = "<p>Please enter a valid student number format.</p>";
	$isValid = false;
}

// Test to only allow letters in name fields 
$numbererror = "/[0-9]/";
if(preg_match($numbererror, trim($_POST['firstname'])))  {
	$errorMessages[] = "<p>Please enter letters only in the 'first name' field.</p>";
	$isValid = false;
}
if(preg_match($numbererror, trim($_POST['lastname'])))  {
	$errorMessages[] = "<p>Please enter letters only in the 'last name' field.</p>";
	$isValid = false;
}
 
// Display error message if any of these are incorrect
if(!$isValid) {
	@session_start();
	// display error messages
	$_SESSION['errorMessages'] = $errorMessages;

	header("Location: index.php");
	die();
}

// load dbinfo.php to connect to db
 require_once("dbinfo.php");
// attempt db connection
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 
if(mysqli_connect_errno() !=0 ){
	die("<p>Sorry, we could not connect to the database.</p>");
}

// Variables & Sql injection
if( isset($_POST["studentnumber"])) {
	$studentnumber = $database->real_escape_string( trim($_POST["studentnumber"]) );
}

if( isset($_POST["firstname"])) {
	$firstname = $database->real_escape_string( trim($_POST["firstname"]) );
}

if( isset($_POST["lastname"])) {
	$lastname = $database->real_escape_string( trim($_POST["lastname"]) );
}
if( isset($_POST["target"])){
	$target = $database->real_escape_string( trim($_POST["target"]) );
}

// Query
$sql 	= "UPDATE students SET id='$studentnumber', firstname='$firstname', lastname='$lastname' WHERE id='$target';";

$result = $database->query($sql);

if( $result == true){
	echo "<p>Query was returned.</p>";

}else{
	echo "<p>Sorry, we could not update the student information.</p>";
}

// Keep stored data for what the user inputted
$recordsUpdated = $database->affected_rows;

if($recordsUpdated > 0) {
	$successMessages[] = "<p>$studentnumber $firstname $lastname record updated successfully.</p>";
	$isSuccess = true;

}else{
	$errorMessages[] = "<p>$target $firstname $lastname record not updated.</p>";
	$isValid = false;
}

if(!$isValid){
	session_start();
	$_SESSION['errorMessages'] = $errorMessages;
	header("Location: index.php");
	die();
}

if($isSuccess = true){
	$_SESSION['successMessages'] = $successMessages;
	header("Location: index.php");
	die();
}

?>