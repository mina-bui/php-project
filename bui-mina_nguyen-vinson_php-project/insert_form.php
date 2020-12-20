<!--
    - form w/ inputs for id, firstname, last name, submit button
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
    <h2>Add a Student</h2>

    <?php

    session_start();
    //--- ERROR AND SUCCESS MESSAGES TO DISPLAY
    $messages = "";
    $successMessages = "";

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
        
		foreach($successMessages as $successMessage){
			// should only require 1, so no need for 
			echo "<p>".$successMessage."</p>";
		}
        
        // must unset messages
		unset($_SESSION['successMessages']);
    }
    ?>


    <!-- Display Student Table -->
    <form method="POST" action="insert_info.php">
        <fieldset>
            <legend>Add a Record</legend><br />
            <input type="hidden" name="add" value="add">
            <!-- student number -->
            <label for="studentnumber">Student #: </label><br />
            <input type="text" name="studentnumber" id="studentnumber" /><br /><br />
            <!-- first name -->
            <label for="firstname">First Name: </label><br />
            <input type="text" name="firstname" id="firstname" /><br /><br />
            <!-- last name -->
            <label for="lastname">Last Name: </label><br />
            <input type="text" name="lastname" id="lastname" /><br>
            <!-- submit button -->
            <input type="submit" value="Submit" class="button"/>
        </fieldset>
    </form>
    <p><a href="index.php">Go Back</a></p>
</body>

</html>