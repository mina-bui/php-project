<!DOCTYPE html>
<html lang="en">
<head>
	<title>Example Login / Registration System | BCIT TWD PHP</title>
	<meta 	charset="utf-8" />
	<meta 	name="viewport" 
			content="width=device-width,initial-scale=1">			
	<link 	rel="stylesheet" 
			href="http://bcitcomp.ca/twd/css/simplestyles.css" />

	<style>label{ background-color:#eee;width:150px; display:inline-block;}</style>

</head>
<body>
<h1>Example Login / Registration System</h1>
<h2>Login</h2>
<?php

	session_start();

	//check to see if there are any errors
	if( isset($_SESSION['errorMessages']) ){
		//if so, display the error messages
		echo $_SESSION['errorMessages'];
		//clear the error message after we display it,
		//so that we dont later on read the same error and think its new 
		unset($_SESSION['errorMessages']);
	}
?>
	<form method="POST" action="authorize.php">
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" /><br />
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" /><br />
		<input type="submit" /><br />
	</form>
	<p>Not a member of our <strong>exclusive</strong> club? <a href="register.php">Register now</a>!</p>
</body>
</html>
