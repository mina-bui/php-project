<?php

// Authorize Add

session_start();

$isValid 	= true;
$isSuccess 	= false;

//--- ERROR AND SUCCESS MESSAGES 
$successMessages 	= array();
$errorMessages 		= array();

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
	$errorMessages[] = "<p>Please enter a last name in the field</p>";
	$isValid = false;
}
 
 // test Studentnumber format
$pattern = "/^a0[0-9]{7}$/i";
if( preg_match($pattern, trim($_POST['studentnumber'])) != 1) {
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
if($isValid == false) {
	session_start();
	$_SESSION['errorMessages'] = $errorMessages;
	header("Location: index.php");
	die();
}

// load dbinfo.php to connect to db
require_once("dbinfo.php");

// attempt db connection. if errors, send error message and end
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

// Insert Query
$sql 	= "INSERT INTO students (id, firstname, lastname) VALUES ('$studentnumber','$firstname','$lastname');";
$result = $database->query($sql);

if( $result == true){
	echo "<p>Query was returned.</p>";

}else{
	echo "<p>Sorry, we could not update the student information</p>";
}

// Keep stored data for what the user inputted
$recordsInserted = $database->affected_rows;

if($recordsInserted > 0){
	// List names of stored data
	$successMessages[] = "<p>$studentnumber $firstname $lastname record added successfully.</p>";
	$isSuccess = true;
}else{
	$errorMessages[] = "<p>$studentnumber $firstname $lastname record was not added.</p>";
	$isValid = false;
}

if($isValid == false){
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

$database->close();

?>