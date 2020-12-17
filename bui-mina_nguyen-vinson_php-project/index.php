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
		table,
		tbody,
		tr,
		td,
		th {
			border: 1px solid black;
		}
		tr,
		td,
		th {
			padding: 5px 15px;
		}
	</style>
</head>
<body>
<h1>Administering DB From a Form</h1>
<?php

	session_start();

	//check for errors. if so, display and clear after display
	if( isset($_SESSION['errorMessages']) ){
		echo $_SESSION['errorMessages'];
		unset($_SESSION['errorMessages']);
	}
?>
	<div id="dbtable">
		<h2>Students:</h2>
		<!-- link to prepare_query.php to add a student to db -->
		<p><a href="prepare_query.php?add">Add a Student</a></p>
		<!-- Display Student Table -->
		<table>
			<tbody>
				<!-- sort by id, first name, last name options -->
				<tr>
					<th><a href="/index.php/?sortby=id">Id</a></th>
					<th><a href="/index.php/?sortby=firstname">First Name</a></th>
					<th><a href="/index.php/?sortby=lastname">Last Name</a></th>
				</tr>
				<!-- students (id, firstname, lastname, delete, update options) -->
				<tr>
					<td>A00000001</td>
					<td>John</td>
					<td>Smith</td>
					<td><a href="#0">Delete</a></td>
					<td><a href="#0">Update</a></td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>
