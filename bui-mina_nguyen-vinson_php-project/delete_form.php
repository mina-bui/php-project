<!--
    - display record data chosen to be deleted (ask if user is sure)
    - form w/ radio option (yes or no)
-->
<!DOCTYPE html>
<html lang="en">

<head>
	<title>TWD PHP Project | BCIT TWD PHP</title>
	<meta charset = "utf-8" />
	<meta name = "viewport" content = "width=device-width,initial-scale=1">			
	<link rel = "stylesheet" href = "style.css" />
</head>

<body>
    <header><h1>Administering DB From a Form</h1></header>
    <h2>Delete a Student</h2>

    <?php
    @session_start();

    require_once("dbinfo.php");

    $database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);			// attempt db connection

    // protect from sql injections
    if( isset($_GET["delete"])){
		$id = $database->real_escape_string( trim($_GET["delete"]) );
    }
    
    
    // selecting an id => => use id value to retrieve the record from the db
    $query = "SELECT id, firstname, lastname FROM students WHERE id='$id';";
	$result = $database->query($query);

    $record = $result->fetch_assoc();
    
    // finish and close the database
    $database->close();
    ?>


<fieldset>
    <legend>Delete a record</legend>
    
	<form method="POST" action="delete_info.php">
    
        <p>You are deleting:<p>
        <!-- Corresponding Name from Database -->
        <p><?php echo $record["id"], ' ' , $record["firstname"], ' ' , $record["lastname"]?></p>
        
         <!-- Stored values to delete -->
        <input type="hidden" name="delete" value="delete" />
		<input 	type="hidden"
				value="<?php echo $record["id"] ?>"
				name="studentnumber" 
				  />
		<input 	type="hidden"
				value="<?php echo $record["firstname"] ?>"
				name="firstname"
				  />
		<input 	type="hidden"
				value="<?php echo $record["lastname"] ?>"
				name="lastname" 
                  />
        <!-- Radio Buttons -->          
		<input 	type="radio" 
				name="confirm" 
				id="yes" 
				value="yes"
				/>
		<label for="yes">Yes</label><br />
		<input 	type="radio" 
				name="confirm" 
				id="no" 
				value="no" />
		<label for="no">No</label><br />	
        <input type="submit" value="Submit" />
        
	</form>
</fieldset>

    <p><a href="index.php">Go Back</a></p>
</body>

</html>