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
<h2>Register</h2>
<?php
	$errorMessages	= "";
	session_start();
	if( isset($_SESSION['errorMessages']) ){
		$errorMessages = $_SESSION['errorMessages'];
	}
	echo $errorMessages;
	//clear the error message after we display it,
	//so that we dont later on read the same error and think its new 
	unset($_SESSION['errorMessages']);
?>
	<form method="POST" action="adduser.php">
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" /><br />
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" /><br />
		<label for="passwordRetyped">Re type password:</label>
		<input type="password" name="passwordRetyped" id="passwordRetyped" /><br />
		<input type="submit" /><br />
	</form>
	<p>Already one of us? <a href="login.php">Login</a></p>

</body>
</html>
