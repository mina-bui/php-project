<!--
    - Displays a blank form for Student data to be input.

    Delete later, just a self-note:
    - Home (index.php) => Add Student (prepare_query.php) => (process_query.php) => back to Home (index.php)
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
    <h2>Add a Student</h2>

<?php

    session_start();

    //check for errors. if so, display and clear after display
    if( isset($_SESSION['errorMessages']) ){
        echo $_SESSION['errorMessages'];
        unset($_SESSION['errorMessages']);
    }

?>

        <!-- Display Student Table -->
        <form method="POST" action="scripts.php">
            <fieldset>
                <legend>Add a Record</legend>

                <!--                 
                <input  type="hidden" 
                        name="add" 
                        value="add"> 
                -->

                <!-- student number -->
                <br />
                <label  for="studentnumber">
                    Student #:
                </label>
                <br />
                <input  type="text" 
                        name="studentnumber" 
                        id="studentnumber" 
                        required />

                <br />
                <br />
                <!-- first name -->
                <label  for="firstname">
                    First Name:
                </label>
                <br />
                <input  type="text" 
                        name="firstname" 
                        id="firstname" 
                        required />
                <br />
                <br />
                <!-- last name -->
                <label  for="lastname">
                    Last Name:
                </label>
                <br />
                <input  type="text" 
                        name="lastname" 
                        id="lastname"  
                        required/>
                <br>
                <!-- submit button -->
                <input  type="submit" 
                        value="Submit" 
                        class="button"/>
            </fieldset>
        </form>
        <p>
            <a href="index.php">Go Back</a>
        </p>
</body>

</html>
