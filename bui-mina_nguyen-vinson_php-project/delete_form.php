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

    <form method="POST" action="delete_info.php">

    <?php
    
    @session_start();
    require_once("dbinfo.php");

    $database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);			// attempt db connection
    if ( mysqli_connect_errno() != 0  ) {								// if errors, send error message and end
        die("<p>Sorry, we could not connect to the database.</p>");	
    }

    if ( isset($_SESSION['errorMessages']) ) {                          // check for errors. if so, display & then clear
            echo $_SESSION['errorMessages'];
            unset($_SESSION['errorMessages']);
    }
    // selecting an id => => use id value to retrieve the record from the db
    if ( isset($_GET['id']) ) {
        $id     = $database->real_escape_string($_GET['id']);
        $query  = "SELECT id, firstname, lastname FROM students WHERE id='".$id."';";
        $result = $database->query($query);
        while ( $record = $result->fetch_assoc() ) {
            // echo student info
            echo "<fieldset>";
            echo "<legend>Delete a Record</legend>";
            echo "You are deleting: ";
            echo "<p>" . $record["id"] . ", " . $record["firstname"] . " " . $record["lastname"] . "</p>" ;
            // yes or no?
            echo "<p>Are you sure? </p>";
            echo "<input type='radio' name='confirm' id='yes' value='yes' checked='checked' />";
            echo "<label for='yes'>Yes</label><br>";
            echo "<input type='radio' name='confirm' id='no' value='no'/>";
            echo "<label for='no'>No</label><br>";
            // submit button
            echo "<input type='submit' value='Submit' class='button'/>";
            echo "</fieldset>";
        }	
    }
    ?>

    </form>
    <p><a href="index.php">Go Back</a></p>
</body>

</html>