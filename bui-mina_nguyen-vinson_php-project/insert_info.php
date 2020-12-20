<?php
ob_start();
?>
<?php
// note: use "02_php_mysql_results_after.php" as reference for insert/delete/update queries

// this works!!! just needs to make sure fields are in the correct format, and send errors if not

// ------------------------- THE BASICS ---------------------------

session_start();

// Determine if the given information is already in the database 
require_once("dbinfo.php");
// attempt a connection to MySQL
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// determine if connection was successful
if(mysqli_connect_errno() !=0 ){
	$_SESSION['errorMessages'] = "<p class='error'>Uh oh... could not connect to database. Please try again later.</p>";
	header("Location: insert_form.php");
	die();
}
// variables for gathering added info
$studentnumber = "";
$firstname     = "";
$lastname      = ""; 

// ---------------------- FORM VALIDATION -------------------------
// - was the form filled out correctly?
// - if not, show error message & send back to index.php
/*
// METHOD 1
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
*/
/*
//--- METHOD 2
// Flag to determine if any problems are encountered
$isValid = true;

//Array for error messages
$errorMessages = array();

// Pattern used for student number format
$pattern = "/^a00[0-9]{6}$/i";

// Form fields are set and have values
//--- Student Number
if(!isset($_POST['studentnumber']) || $_POST['studentnumber'] == ""){
	$errorMessages[] = "Student number must be filled out<br />";
}
//--- Firstname
if(!isset($_POST['firstname']) || $_POST['firstname'] == ""){
	$errorMessages[] = "Firstname must be filled out<br />";
	$isValid = false;
}
//--- Lastname
if(!isset($_POST['lastname']) || $_POST['lastname'] == ""){
	$errorMessages[] = "Lastname must be filled out<br />";
	$isValid = false;
}

// Test for correct student number format
if(preg_match($pattern, trim($_POST['studentnumber'])) != 1){
	$errorMessages[] = "Student Number is not in correct format<br />";
	$isValid = false;
}

// Output the stored error messages in the array
if(!$isValid){
	@session_start();
	$_SESSION['errorMessages'] = $errorMessages;
	
	header("Location: insert_form.php");
	die();
}
*/
//--- METHOD 3
// const to determine the correct format of the student number!
$pattern = "/^a00[0-9]{6}$/i";

// const to determine the minimum length of the 
const MINIMUM_NAME_LENGTH = 2;

// validate the form fields: ensure form data is set 
if(!isset($_POST['studentnumber']) || !isset($_POST['firstname']) || !isset($_POST['lastname']) ){
	$_SESSION['errorMessages'] = "<p>Please fill in the student information or go back</p>";
	header("Location: insert_form.php");
	die();
}

// Store form field data in variables and normalize
$studentnumber = trim($_POST['studentnumber']);
$firstname	   = ucfirst(strtolower(trim($_POST['firstname'])));
$lastname      = ucfirst(strtolower(trim($_POST['lastname'])));

//--- Student number
// ensure student number field wasn't left empty
if( trim($_POST['studentnumber']) ==""){
	$_SESSION['errorMessages'] = "<p>Please fill in the student number field...</p>";
	header("Location: insert_form.php");
	die();
}
// ensure student number format was correct
if (preg_match($pattern, trim($_POST['studentnumber'])) != 1){
	$_SESSION['errorMessages'] = "<p>Please adhere to the correct student number format...</p>";
	header("Location: insert_form.php");
	die();
}

//--- Firstname
// ensure firstname field wasn't left empty
if( trim($_POST['firstname']) =="" ){
	$_SESSION['errorMessages'] = "<p>Please fill in the firstname field...</p>";
	header("Location: insert_form.php");
	die();
}
// ensure firstname field was at least 2 characters in length
if( strlen($firstname) < MINIMUM_NAME_LENGTH ){
	$_SESSION['errorMessages'] = "<p>Uh oh, the firstname field requires at least ".MINIMUM_FNAME_LENGTH." characters.</p>";
	header("Location: insert_form.php");
	die();	
}

//--- Lastname
// ensure firstname field wasn't left empty
if( trim($_POST['lastname']) =="" ){
	$_SESSION['errorMessages'] = "<p>Please fill in the lastname field...</p>";
	header("Location: insert_form.php");
	die();
}
// ensure lasttname field was at least 2 characters in length
if( strlen($lasttname) < MINIMUM_NAME_LENGTH ){
	$_SESSION['errorMessages'] = "<p>Uh oh, the lastname field requires at least ".MINIMUM_FNAME_LENGTH." characters.</p>";
	header("Location: insert_form.php");
	die();	
}


@session_start();
    require_once("dbinfo.php");

    $database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);			// attempt db connection
    if ( mysqli_connect_errno() != 0  ) {								// if errors, send error message and end
        die("<p>Sorry, we could not connect to the database.</p>");	
    }


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
	header("Location: insert_form.php");
	die();
}

//--- Firstname (probably don't need...?)
//$query = "SELECT * FROM students WHERE BINARY firstname ='$firstname';";
//$result = $database->query( $query );
//if a record matches the student number, then this student number is already in use and cannot be duplicated
//if($result->num_rows > 0){
//
//	$_SESSION['errorMessages'] = "<p class='error'>The firstname '$firstname' is already in use, please choose a different one...</p>";
//	header("Location: insert_form.php");/
//	die();
//}

// ---------------------- INSERTION QUERY -------------------------

// Store into Database!
$query = "INSERT INTO students (id, firstname, lastname) VALUES('$studentnumber','$firstname','$lastname');";
$result = $database->query( $query );
//ensure our attempt to insert was a success
if( $database->affected_rows == 0){
		$_SESSION['errorMessages'] = "<p>There was a problem adding the user to our database.</p>";
		header("Location: index.php");
		die();
}

// close MySQL connection
$database->close();

// if the script gets this far, this user was successfully added to our database
$_SESSION['errorMessages'] = "<p>$firstname $lastname successfully added to database. </p>";
header("Location: index.php");
die();

?>