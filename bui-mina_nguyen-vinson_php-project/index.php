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

	session_start();

	//--- ERROR AND SUCCESS MESSAGES 
    $messages 			= "";
    $successMessages 	= "";

	// Determine if any errors were found 
	if(isset($_SESSION['errorMessages'])) {
		// store created messages in array
		$messages = $_SESSION['errorMessages'];
		
        // create UL to display the errors that the user may have encountered
		echo "<ul>";
		foreach($messages as $message) {
			echo "<li>".$message."</li>";
		}
		echo "</ul>";
        
        // must unset error messages to allow user to try again
		unset($_SESSION['errorMessages']);
    }
    
    // Determine if any processes were completed correctly 
    if(isset($_SESSION['successMessages'])) {
		// store completeed messages in array
		$successMessages = $_SESSION['successMessages'];
        
		foreach($successMessages as $successMessage) {
			// should only require 1, so no need for 
			echo "<p>".$successMessage."</p>";
		}
        // must unset messages
		unset($_SESSION['successMessages']);
    }
	
	$sortOrder = "id";
	
	if(isset($_GET['sortby'])) {
		$sortOrder = $_GET['sortby'];
	}
	
	// load dbinfo.php to connect to db
	require_once("dbinfo.php");											

	// attempt db connection. if errors, send error message and end
	$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);			
	if ( mysqli_connect_errno() != 0  ) {
		die("<p>Sorry, we could not connect to the database.</p>");	
	}

	// use real_escape_string() to prevent sql attacks
	$sortOrder = $database->real_escape_string($sortOrder);

	// --------------------------------------
	// IF USER SORTED CORRECTLY, THEN SORT TABLE BY ID / FIRSTNAME / LASTNAME

	echo "<h2>Students</h2>";
	// link to form.php to add a student to the database 
	echo "<p><a href='insert_form.php'>Add a Student</a></p>";							

	// select a way to sort the table, and then sort the table by that choice
	$query  = "SELECT id, firstname, lastname FROM students ORDER BY $sortOrder;";	
	$result = $database->query($query);
	// display student table
	echo "<table id='db-table'>";														

	// --------------------------------------
	// SORT OPTIONS AS HYPERLINKS IN TABLE HEADINGS

	// query strings attached to hrefs => sends data from one request to another
	$fieldObjects = $result->fetch_fields();
	echo "<tr>";
	foreach ($fieldObjects as $fieldObject) {
		echo "<th><a href='index.php?sortby=$fieldObject->name'>" .$fieldObject->name. "</a></th>" ;
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
		echo "<td><a href='delete_form.php?delete=" . $record["id"] . "'>Delete</a></td>";
		// Used to make sure the update forms populate the data
		echo "<td><a href='update_form.php?update=" . $record["id"] . "'>Update</a></td>";
		echo "</tr>";		
	}

	echo "</table>";

	$database->close();
	
?>

</body>
</html>