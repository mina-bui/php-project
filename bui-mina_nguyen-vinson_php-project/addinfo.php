<?php
// Scripts used to take in info from the insert_form
session_start();

// Prepare variables for gathering adding information
$studentnumber = "";
$firstname     = "";
$lastname      = ""; 


// Validate the form fields; to make sure that form data is set
if (!isset($_POST['studentnumber']) ||
	!isset($_POST['firstname'])     ||
	!isset($_POST['lastname'])) {
	
	$_SESSION['errorMessages'] = "<p class='error'>Please register the student information...</p>";
	header("Location: insert_form.php");
	die();
}


// Validate the form fields; to make sure that the form actually contains data
if (trim($_POST['studentnumber']) == "" ||
	trim($_POST['firstname'])     == "" ||
	trim($_POST['lastname'])      == "" ) {
	
	$_SESSION['errorMessages'] = "<p class='error'>Please register the student information and type into the given fields...</p>";
	header("Location: insert_form.php");
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


// Determine if the given information is already in the database 
require_once("dbinfo.php");
/* attempt a connection to MySQL */
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
/* determine if connection was successful */
if(mysqli_connect_errno() !=0 ){
	$_SESSION['errorMessages'] = "<p class='error'>Uh oh... could not connect to database to register you. Please try again later.</p>";
	header("Location: insert_form.php");
	die();
}


//IMPORTANT: use real_escape_string() to protect against SQL injection
$studentnumber = $database->real_escape_string($studentnumber);
$firstname     = $database->real_escape_string($firstname);
$lastname      = $database->real_escape_string($lastname);


// Determine if the given information is already in the database 
//--- Student Number
$query  = "SELECT * FROM students WHERE BINARY id ='$studentnumber';";
$result = $database->query( $query );
//if a record matches the student number, then this student number is already in use and cannot be duplicated
if($result->num_rows > 0){

	$_SESSION['errorMessages'] = "<p class='error'>The studentnumber: '$studentnumber' is already in use, please choose a different one...</p>";
	header("Location: insert_form.php");
	die();
}
/*
//--- Firstname (probably don't need...?)
$query = "SELECT * FROM students WHERE BINARY firstname ='$firstname';";
$result = $database->query( $query );
//if a record matches the student number, then this student number is already in use and cannot be duplicated
if($result->num_rows > 0){

	$_SESSION['errorMessages'] = "<p class='error'>The firstname '$firstname' is already in use, please choose a different one...</p>";
	header("Location: insert_form.php");
	die();
}
*/

// Store into Database!
//--- Student Number
$query = "INSERT INTO students (id, firstname, lastname) VALUES('$studentnumber','$firstname','$lastname');";
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

// ------------------------- SORT BY ID ---------------------------
// sql queries go here

// ---------------------- SORT BY FIRST NAME ----------------------
// sql queries go here

// ---------------------- SORT BY LAST NAME -----------------------
// sql queries go here



// ////////////////////////////////////////////////////////////////////////////////////////////////
// note: use "02_php_mysql_results_after.php" as reference for the following 3 queries


// ---------------------- 1. *INSERTION QUERY* -------------------------

// WAS FORM FILLED OUT CORRECTLY?

// was the form filled out correctly?
// !!! protect against SQL injection attacks !!!
// if not, send back to index.php
// if so, run INSERT query

// INSERT QUERY



// did the INSERTION succeed or not? (use session to remember)
// if so, display positive feedback, such as: “A new record has been added to the table”
// if so, send back to index.php

// if not, display messages, eg: “The record could not be added as requested.”

// ---------------------- 2. *DELETION QUERY* -------------------------

// -------------------------
// WAS FORM FILLED OUT CORRECTLY?

// was the form filled out correctly?
// !!! protect against SQL injection attacks !!!
// if not, send back to index.php
// if so, run DELETE query




// -------------------------
// DELETE QUERY

// did the DELETION succeed or not? (use session to remember)
// if so, display feedback, such as: “A record has been deleted from the table”
// if so, send back to index.php

// if not, display messages, eg: “The record could not be deleted as requested.”





// ---------------------- 3. *UPDATE QUERY* -------------------------

// -------------------------
// WAS FORM FILLED OUT CORRECTLY?

// was the form filled out correctly?
// !!! protect against SQL injection attacks !!!
// if not, send back to index.php
// if so, run UPDATE query



// -------------------------
// UPDATE QUERY

// did the UPDATE succeed or not? (use session to remember)
// if so, display feedback, such as: “A record has been updated in the table”
// if so, send back to index.php

// if not, display messages, eg: “The record could not be updated as requested.”




?>