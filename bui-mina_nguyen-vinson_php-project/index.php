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
			href    ="http://bcitcomp.ca/twd/css/style.css" />
	<style>
		table, tbody, tr, td, th { border: 1px solid black; }
		tr, td, th { padding: 5px 15px; }
	</style>
</head>
<body>
<header>
	<h1>Administering DB From a Form</h1>
</header>

<!-- ------------------- -->
<?php

	session_start();

	// check for errors. if so, display and clear after display
	if( isset($_SESSION['errorMessages']) ){
		echo $_SESSION['errorMessages'];
		unset($_SESSION['errorMessages']);
	}
	// ------------------------------------------------------------------------
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

	/*
	a SELECT returns a result_set Object.
	the object contains zero or more arrays,
	one array for each record 

	each record is an array with field values
	assigned to each index

		$result is an Object
		$result->fetch_row()
		returns an array of record data
		each field assigned an index
		
		$record is an array
	*/

	echo "<h2>Students:</h2>";
	// link to form.php to add a student to the database 
	echo "<p><a href='form.php'>Add a Student</a></p>";

	// Display Student Table
	echo "<table>";
	echo "<tbody>";	
	// Sort by: ID, First Name, Last Name
	echo "<tr>";
	echo "<th><a href='#0'>Id</a></th>";
	echo "<th><a href='#0'>First Name</a></th>";
	echo "<th><a href='#0'>Last Name</a></th>";
	echo "</tr>";
	echo "</tbody>";
	
	while( $record = $result->fetch_row()  ){
		//loop through the $record array
		echo "<tr>";
		// note: record = row, field = column
		foreach( $record as $field ){
			echo "<td>" . $field . "</td>";
		}
		echo "</tr>";	
	}
	echo "</table>";

	// close the database connection
	$database->close();

?>

<!--
	<tr>
		<td>A00000001</td>
		<td>John</td>
		<td>Smith</td>
		<td><a href="#0">Delete</a></td>
		<td><a href="#0">Update</a></td>
	</tr>
-->

</body>
</html>
