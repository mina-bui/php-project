<?php
// ------------------------- THE BASICS ---------------------------

@session_start();

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
	$errorMessages[] = "<p>$studentname $firstname $lastname record not deleted. Please select 'yes' or 'no' button.</p>";
	$isValid = false;
}

if(!$isValid){
	session_start();
	$_SESSION['errorMessages'] = $errorMessages;
   
	header("Location: index.php");
	
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
		$successMessages[] = "<p>$studentnumber $firstname $lastname record deleted</p>";
		$isSuccess = true;
	}

}else{
	$successMessages[] = "<p>The 'no' button was selected. $studentnumber $firstname $lastname record not deleted.</p>";
	$isSuccess = true;
}

if($isSuccess = true){
	session_start();
	$_SESSION['successMessages'] = $successMessages;
   
	header("Location: index.php");
	
	die();

}

// close database

$database->close();





?>
