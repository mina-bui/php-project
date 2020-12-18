<!--
    - Display the record information of the record they chose to delete.
    - Give them one last chance to change their mind, 
        - eg: ask the user if they are sure they want to delete the record,
        - and display a form with a radio button option of ‘yes’ and ‘no’.
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
    <h2>Delete a Student</h2>

<?php
    session_start();

    //check for errors. if so, display and clear after display
    if( isset($_SESSION['errorMessages']) ){
        echo $_SESSION['errorMessages'];
        unset($_SESSION['errorMessages']);
    }
?>

        <!-- Display Student Table -->
        <form method="POST" action="addinfo.php">
            <fieldset>
                <legend>Delete a Record</legend>
                <!-- placeholder text -->
                <p>'Student Number, Firstname Lastname</p>
                <p>Are you sure? </p>
                <!-- yes or no? -->
                <input  type="radio" 
                        name="yes-or-no" 
                        id="yes"  
                        value="yes"
                        required />
                <label  for="yes">Yes</label>
                <br>
                <input  type="radio" 
                        name="yes-or-no" 
                        id="no"  
                        value="no"/>
                <label  for="no"
                        required >No</label>
                <br>
                <!-- submit button -->
                <input  type="submit" 
                        value="Submit" 
                        class="button"/>    <!-- NOTE: doesn't work yet -->
            </fieldset>
        </form>
        <p>
            <a href="index.php">Go Back</a>
        </p>
</body>

</html>
