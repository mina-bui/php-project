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

	$_SESSION['errorMessages'] = "<p class='error'>The firstname '$firstname' is already in use, please choose a different one...</p>";
	header("Location: insert_form.php");
	die();
}


//--- Firstname
$query = "SELECT * FROM students WHERE BINARY id ='$studentnumber';";
$result = $database->query( $query );

//if a record matches the student number, then this student number is already in use and cannot be duplicated
if($result->num_rows > 0){

	$_SESSION['errorMessages'] = "<p class='error'>The firstname '$firstname' is already in use, please choose a different one...</p>";
	header("Location: insert_form.php");
	die();
}


// -------------------------
// random notes to self:
    // the following sort queries *might* be moved to the index.php page...
    // ****     REMEMBER TO NOT FORGET TO ADD $_GET query string!!! tomorrow....
    // sort by ___ section obtained from _session11 => 07_db_sort_records_after.php (note to self)
// -------------------------

require_once("dbinfo.php");
// default sort settings
$sortOrder = "lastname";
// choices to sort by...
$validChoices = array("id", "firstname", "lastname");

//attempt db connection
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// if no errors, good. if errors, send error message and end
if( mysqli_connect_errno() != 0  ){
	die("<p>Could not connect to the database.</p>");	
}



//

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