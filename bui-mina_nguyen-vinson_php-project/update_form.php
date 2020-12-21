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
    <h2>Update a Student</h2>

    <?php
    @session_start();

    // load dbinfo.php to connect to db
    require_once("dbinfo.php");

    // attempt db connection
    $database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);			
    
    // protect from sql injections
    if ( isset($_GET["update"])) {
      $id = $database->real_escape_string( trim($_GET["update"]) );
    }
    
    // selecting an id => => use id value to retrieve the record from the db
    $query  = "SELECT id, firstname, lastname FROM students WHERE id='$id';";
    $result = $database->query($query);
	  $record = $result->fetch_assoc();

    $database->close();
    ?>
    
    <fieldset>
    <legend>Update a Record</legend>
    <form method="POST" action="update_info.php">
		
		<input type="hidden" name="update" value="update" />
        
        <label for='studentnumber'>Student #:</label>
        <input type='text' 
               name='studentnumber' 
               id='studentnumber' 
               value="<?php echo $record["id"] ?>" />

        <label for='firstname'>First Name:</label>
        <input type='text' 
               name='firstname' 
               id='firstname' 
               value="<?php echo $record['firstname'] ?>" />

        <label for='lastname'>Last Name:</label>
        <input type='text' 
               name='lastname' 
               id='lastname' 
               value="<?php echo $record['lastname'] ?>" />

        <input type='submit' value='Submit' class='button'/>
        </form>
    </fieldset>

    <p><a href="index.php">Go Back</a> </p>
</body>

</html>