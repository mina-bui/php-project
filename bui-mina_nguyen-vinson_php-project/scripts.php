<?php

// BASICS
/* session_start();

$studentnumber = "";
$firstname = "";
$lastname = ""; */


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

// use real_escape_string() to prevent sql attacks
$sortOrder = $database->real_escape_string($sortOrder);

// order by field => default search
$query = "SELECT id, firstname, lastname FROM students ORDER BY ".$sortOrder.";";
$result = $database->query($query);
echo "<table>";

// echoing hyperlinked table headings before displaying table data
// add query string to hrefs, to send data from one request to another
$fieldObjects = $result->fetch_fields();
echo "<tr>";
foreach($fieldObjects as $fieldObject){
	echo "<th><a href='07_db_sort_records_after.php?choice=$fieldObject->name'>" .$fieldObject->name. "</a></th>" ;
}
echo "</tr>";

// -------------------------
// create a clickable link for the student number
// which will request this page when clicked
// and include a query string to identify which id was clicked.
while(   $record = $result->fetch_assoc() ){
	echo "<tr>";
	echo "<td><a href='07_db_sort_records_after.php?id=".$record["id"]."'>" . $record["id"] . "</a></td>" ;
	echo "<td>" . $record["firstname"] . "</td>" ;
	echo "<td>" . $record["lastname"] . "</td>" ;
	echo "</tr>";		
}
echo "</table>";

// -------------------------
// if id was sent to GET query string,
// use id value to retrieve a record from the database
// put id/firstname/lastname info on the "update_form.php"?
if( isset($_GET['id']) ){
	$id = $database->real_escape_string($_GET['id']);
	$query = "SELECT id, firstname, lastname FROM students WHERE id='".$id."';";
	$result = $database->query($query);
	while(   $record = $result->fetch_assoc() ){
		echo "<fieldset>";
		echo "<legend>Student number " . $record["id"] . " was selected</legend>" ;
		echo "<p>Hello, " . $record["firstname"] . " " . $record["lastname"] . "!</p>" ;
		echo "</fieldset>";
	}	
}
$database->close();


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