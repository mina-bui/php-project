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
	// BASICS

	session_start();

	// check for errors. if so, display and clear after display
	if( isset($_SESSION['errorMessages']) ){
		echo $_SESSION['errorMessages'];
		unset($_SESSION['errorMessages']);
	}
	// ------------------------------------------------------------------------
	// CONNECTING TO DB AND PREPARING SQL QUERY

	// load dbinfo.php to connect to db
	require_once("dbinfo.php");
	// connect to db
	$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	// if connection unsuccessful, show error message and end.
	if( mysqli_connect_errno() != 0  ){
		die("<p>Could not connect to the SQL database.</p>");	
	}
	// if connection successful, prepare an SQL query
	$query 	= "SELECT id, firstname, lastname FROM students ORDER BY id;";
	// run query and put results in variable
	$result = $database->query( $query );

	// ------------------------------------------------------------------------
	// DISPLAYING THE TABLE

	echo "<h2>Students</h2>";
	// link to form.php to add a student to the database 
	echo "<p><a href='insert_form.php'>Add a Student</a></p>";				// NOTE: doesn't work yet

	// Display Student Table
	echo "<table id='db-table'>";
	echo "<tbody>";	
	// Sort by: ID, First Name, Last Name
	echo "<tr>";
	echo "<th><a href='index.php?sortby=id'>ID</a></th>"; 					// NOTE: doesn't work yet
	echo "<th><a href='index.php?sortby=firstname'>First Name</a></th>"; 	// NOTE: doesn't work yet
	echo "<th><a href='index.php?sortby=lastname'>Last Name</a></th>"; 		// NOTE: doesn't work yet
	echo "</tr>";
	echo "</tbody>";
	
	// get get the rows in $record
	while( $record = $result->fetch_row()  ){
		echo "<tr>";
		echo "<td>" . $record[0] . "</td>";		
		echo "<td>" . $record[1] . "</td>";	
		echo "<td>" . $record[2] . "</td>";		
		// delete and update => this needs work!
		echo "<td><a href='delete_form.php'>delete</a></td>"; 				// NOTE: doesn't work yet
		echo "<td><a href='update_form.php'>update</a></td>"; 				// NOTE: doesn't work yet
/*
		// how we did it in class => loop through the $record array
		// note: record = row, field = column
 		foreach( $record as $field ){
			echo "<td>" . $field . "</td>";
		} 
*/
		echo "</tr>";	
	}
	echo "</table>";

	// close the database connection
	$database->close();

?>

</body>
</html>