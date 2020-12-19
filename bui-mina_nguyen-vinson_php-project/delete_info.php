<?php
// note: use "02_php_mysql_results_after.php" as reference for insert/delete/update queries

// does not work :( i just copied and pasted the insert_info.php code fyi

// ------------------------- THE BASICS ---------------------------

session_start();

// Determine if the given information is already in the database 
require_once("dbinfo.php");
// attempt a connection to MySQL
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// determine if connection was successful
if(mysqli_connect_errno() !=0 ){
	$_SESSION['errorMessages'] = "<p class='error'>Uh oh... could not connect to database. Please try again later.</p>";
	header("Location: delete_form.php");
	die();
}
// variables for gathering typed in info
$studentnumber = "";
$firstname     = "";
$lastname      = "";

// ---------------------- FORM VALIDATION -------------------------
// - was the form filled out correctly?
// - if not, show error message & send back to index.php

// Validate the form fields; to make sure that form data is set
if (!isset($_POST['studentnumber']) ||
	!isset($_POST['firstname'])     ||
	!isset($_POST['lastname'])) {
	
	$_SESSION['errorMessages'] = "<p class='error'>Please register the student information...</p>";
	header("Location: index.php");
	die();
}

// Validate the form fields; to make sure that the form actually contains data
if (trim($_POST['studentnumber']) == "" ||
	trim($_POST['firstname'])     == "" ||
	trim($_POST['lastname'])      == "" ) {
	
	$_SESSION['errorMessages'] = "<p class='error'>Please register the student information and type into the given fields...</p>";
	header("Location: index.php");
	die();
}

// Store form field data in variables
$studentnumber = trim($_POST['studentnumber']);
$firstname	   = trim($_POST['firstname']);
$lastname      = trim($_POST['lastname']);

// Ensure that the student has typed in the correct Student Number Format!
/*
 if($formIsValid){
	$pattern = "/^a00[0-9]{6}$/i";
	if( preg_match($pattern, trim($_POST['studentnumber'])) != 1){
		$validationMessages .= "An invalid studentnumber.<br />";
		$formIsValid = false;
	}
}
*/

//IMPORTANT: use real_escape_string() to protect against SQL injection
$studentnumber = $database->real_escape_string($studentnumber);
$firstname     = $database->real_escape_string($firstname);
$lastname      = $database->real_escape_string($lastname);

// ----------------------
// IS IT ALREADY IN THE TABLE?

// Determine if the given information is already in the database 
//--- Student Number
$query  = "SELECT * FROM students WHERE BINARY id ='$studentnumber';";
$result = $database->query( $query );
//if a record matches the student number, then this student number is already in use and cannot be duplicated
if($result->num_rows > 0){

	$_SESSION['errorMessages'] = "<p class='error'>The studentnumber: '$studentnumber' is already in use, please choose a different one...</p>";
	header("Location: delete_form.php");
	die();
}

//--- Firstname (probably don't need...?)
//$query = "SELECT * FROM students WHERE BINARY firstname ='$firstname';";
//$result = $database->query( $query );
//if a record matches the student number, then this student number is already in use and cannot be duplicated
//if($result->num_rows > 0){
//
//	$_SESSION['errorMessages'] = "<p class='error'>The firstname '$firstname' is already in use, please choose a different one...</p>";
//	header("Location: delete_form.php");/
//	die();
//}

// ---------------------- DELETION QUERY -------------------------

// Delete From Database!
//$query = "INSERT INTO students (id, firstname, lastname) VALUES('$studentnumber','$firstname','$lastname');";
$query = "DELETE FROM students WHERE id='$studentnumber';";
$result = $database->query( $query );
//ensure our attempt to delete was a success
if ($results == true) {
    if( $database->affected_rows == 0){
		$_SESSION['errorMessages'] = "<p>There was a problem deleting the user from our database.</p>";
		header("Location: index.php");
		die();
    }
}

// --------------------------------------------------------------
// THE FOLLOWING CODE IS FROM ANOTHER LAB. just for reference 
// DELETE query, using ->affected_rows
// delete query returns false if query was unsuccessful (sql malformed), true if query was successful (sql accepted)
// true =/= deletion
// ->affected_rows determines how many records were altered by the query run

/* $query = "DELETE FROM students WHERE id='S00123456';";
//capturing the results of the query wont be as useful this time...
$results = $database->query($query);
if($results == true){
	echo "<p>Running a DELETE query returned 'true'. The most recently run query was accepted by the database</p>";
}else{
	echo "<p>Running a DELETE query returned 'false'.</p>";
} */

// ---------------------------------------------------------------

// close MySQL connection
$database->close();

// if the script gets this far, this user was successfully removed from our database
$_SESSION['errorMessages'] = "<p>User successfully removed from database. </p>";
header("Location: index.php");
die();

?>