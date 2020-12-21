<?php

// Authorize Add

session_start();

$isValid = true;
$isSuccess = false;

$successMessages = array();
$errorMessages = array();

// Checking for set & empty
//--- Studentnumber
if(!isset($_POST['studentnumber']) || $_POST['studentnumber'] == "") {
	$errorMessages[] = "<p>Please enter Student number field...</p>";
	$isValid = false;
}
//--- Firstname
if(!isset($_POST['firstname']) || $_POST['firstname'] == "") {
	$errorMessages[] = "<p>Please enter Firstname field...</p>";
	$isValid = false;
}
//--- Lastname
if(!isset($_POST['lastname']) || $_POST['lastname'] == "") {
	$errorMessages[] = "<p>Please enter Lastname field...</p>";
	$isValid = false;
}
 
 // test student number format
$pattern = "/^a0[0-9]{7}$/i";
if( preg_match($pattern, trim($_POST['studentnumber'])) != 1) {
	$errorMessages[] = "<p>Error: Please enter correct Student number format...</p>";
	$isValid = false;
}

// Test to only allow letters in name fields 
$numbererror = "/[0-9]/";
if(preg_match($numbererror, trim($_POST['firstname'])))  {
	$errorMessages[] = "<p>Error: Please enter letters only in the firstname field...</p>";
	$isValid = false;
}
if(preg_match($numbererror, trim($_POST['lastname'])))  {
	$errorMessages[] = "<p>Error: Please enter letters only in the lastname field...</p>";
	$isValid = false;
}

// Display error message if any of these are incorrect
if($isValid == false) {
	session_start();
	// display error messages
	$_SESSION['errorMessages'] = $errorMessages;

	header("Location: index.php");
	die();
}


 // Check database
require_once("dbinfo.php");

$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(mysqli_connect_errno() !=0 ){
	die("<p>Uh oh... could not connect to database.</p>");
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
	echo "<p>YAY correct return</p>";

}else{
	echo "<p>Could not add student</p>";
}

 // Keep stored data for what the user inputted
 $recordsInserted = $database->affected_rows;

if($recordsInserted > 0){
	// List names of stored data
	$successMessages[] = "<p>$studentnumber $firstname $lastname record inserted</p>";
	$isSuccess = true;
}else{
	$errorMessages[] = "<p>$studentnumber $firstname $lastname record not inserted</p>";
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

// finish and close database
$database->close();

?>