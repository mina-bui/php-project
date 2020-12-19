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
    /*
    // Method 1
    $errorMessages = "";
    session_start();
    if( isset($_SESSION['errorMessages']) ){                            // check for errors. if so, display & then clear
        $errorMessages =  $_SESSION['errorMessages'];
        unset($_SESSION['errorMessages']);
    }
    */
    @session_start();
    
    $errorMessages	= "";
	
	if( isset($_SESSION['errorMessages']) ){
		$errorMessages = "<div class='error'>Error:".$_SESSION['errorMessages']."</div>";
	}
	echo $errorMessages;
	unset($_SESSION['errorMessages']);

    ?>

    <!-- Display Student Table -->
    <form method="POST" action="insert_info.php">
        <fieldset>
            <legend>Add a Record</legend><br />
            <!-- <input type="hidden" name="add" value="add"> -->
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