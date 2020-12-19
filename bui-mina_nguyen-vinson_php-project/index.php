<!--
    Display:
		- Student Table
		- Information about most recent user interaction
		- Options to ADD, DELETE, and UPDATE records
-->

<!DOCTYPE html>
<html lang="en">
<head>
	<title>TWD PHP Project | BCIT TWD PHP</title>
	<meta 	charset ="utf-8" />
	<meta 	name    ="viewport" 
			content ="width=device-width,initial-scale=1">			
	<link 	rel     ="stylesheet" 
			href    ="style.css" />
</head>
<body>
<header>
	<h1>Administering DB From a Form</h1>
</header>

<?php
	// --------------------------------------
	// THE BASICS -  DB, ERRORS, ETC

	@session_start();
	require_once("dbinfo.php");											// load dbinfo.php to connect to db

	$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);			// attempt db connection
	if ( mysqli_connect_errno() != 0  ) {								// if errors, send error message and end
		die("<p>Sorry, we could not connect to the database.</p>");	
	}

	if( isset($_SESSION['errorMessages']) ){				// check for errors. if so, display and clear after display
		echo $_SESSION['errorMessages'];
		unset($_SESSION['errorMessages']);
	}

	$sortOrder = "id";										// default sorting is by id
	$validChoices = array("id","firstname","lastname");		// choices to sort by...

	// --------------------------------------
	// DID USER USE "SORT BY" OPTIONS CORRECTLY?

	// check if the url ".../index.php?choice=id" contains choices other than $validChoices
	if ( isset($_GET['choice'] ) ) {
		if ( in_array($_GET['choice'], $validChoices) ) {
			$sortOrder = $_GET['choice'];	
		}
		else {
			echo "<p><code>'".$_GET['choice']."'</code> is NOT a valid sort choice. You may only sort by <code>'ID'</code>, <code>'first name'</code>, and <code>'last name'</code>.</p>";
		}
	}
		
	$sortOrder = $database->real_escape_string($sortOrder);				// use real_escape_string() to prevent sql attacks

	// --------------------------------------
	// IF USER SORTED CORRECTLY, THEN SORT TABLE BY ID / FIRSTNAME / LASTNAME

	echo "<h2>Students</h2>";
	echo "<p><a href='insert_form.php'>Add a Student</a></p>";							// link to form.php to add a student to the database 

	$query = "SELECT id, firstname, lastname FROM students ORDER BY ".$sortOrder.";";	// select a way to sort the table, and then sort the table by that choice
	$result = $database->query($query);
	echo "<table id='db-table'>";														// display student table

	// --------------------------------------
	// SORT OPTIONS AS HYPERLINKS IN TABLE HEADINGS

	// query strings attached to hrefs => sends data from one request to another
	$fieldObjects = $result->fetch_fields();
	echo "<tr>";
	foreach ($fieldObjects as $fieldObject) {
		echo "<th><a href='index.php?choice=$fieldObject->name'>" .$fieldObject->name. "</a></th>" ;
	}
	echo "</tr>";

	// --------------------------------------
	// CREATING LINKS TO DELETE/UPDATE USERS

	// => link requests this page => includes a query string to identify which student was clicked
	while ( $record = $result->fetch_assoc() ) {
		echo "<tr>";
		echo "<td>" . $record["id"] . "</td>" ;
		echo "<td>" . $record["firstname"] . "</td>" ;
		echo "<td>" . $record["lastname"] . "</td>" ;
		echo "<td><a href='delete_form.php?id=".$record["id"]."'>delete</a></td>";
		echo "<td><a href='update_form.php?id=".$record["id"]."'>update</a></td>";
		echo "</tr>";		
	}
	echo "</table>";

	$database->close();		// close the database connection
	
?>

</body>
</html>