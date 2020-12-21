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

// Variables
if( isset($_POST["studentnumber"])){
	$studentnumber = $database->real_escape_string( trim($_POST["studentnumber"]) );
}

$firstname = trim($_POST['firstname']);
$lastname  = trim($_POST['lastname']);


$isValid = true;
$isSuccess = false;
$successMessages = array();
$errorMessages = array();

if( !isset($_POST['confirm']) ){
	$errorMessages[] = "<p style='color:red;'>$studentname $firstname $lastname record not deleted. Please select 'yes' or 'no' button.</p>";
	$isValid = false;
}

if(!$isValid){
	session_start();
	$_SESSION['errorMessages'] = $errorMessages;
   
	header("Location: index.php");
	//die after header forwarding,
	//to ensure this script does not
	//continue to run
	die();
}


// Delete

if($_POST["confirm"] == "yes"){

	$sql 	= "DELETE FROM students WHERE id='$studentnumber';";
	$result = $database->query($sql);

	if( $result == true){
		echo "<p>DELETE query returned true</p>";
	}else{
		echo "<p>DELETE query returned false</p>";
	}
	//see how many records changed with last query
	$recordsDeleted = $database->affected_rows;
	if($recordsDeleted > 0){
		$successMessages[] = "<p style='color:green;'>$studentnumber $firstname $lastname record deleted</p>";
		$isSuccess = true;
	}

}else{
	$successMessages[] = "<p style='color:green;'>The 'no' button was selected. $studentnumber $firstname $lastname record not deleted.</p>";
	$isSuccess = true;
}

if($isSuccess = true){
	session_start();
	$_SESSION['successMessages'] = $successMessages;
   
	header("Location: index.php");
	//die after header forwarding,
	//to ensure this script does not
	//continue to run
	die();

}

// close database

$database->close();


/*
if(!isset($_POST['confirm']) ){
	$_SESSION['errorMessages'] = "<p>Please choose yes or no</p>";
	header("Location: delete_form.php");
	die();
}

// if they choose Yes or No
if( trim($_POST['confirm']) == "no" ){
	$_SESSION['errorMessages'] = "<p>OK, please make your way back to the student list...</p>";
	header("Location: delete_form.php");
	die(); 
} 


$studentnumber = $database->real_escape_string($studentnumber);
$firstname     = $database->real_escape_string($firstname);
$lastname      = $database->real_escape_string($lastname);


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


// close MySQL connection
$database->close();

// if the script gets this far, this user was successfully removed from our database
$_SESSION['errorMessages'] = "<p>User successfully removed from database. </p>";
header("Location: index.php");
die();
*/




?>
