<!DOCTYPE html>
<html lang="en">
<head>
	<title>Example Login / Registration System | BCIT TWD PHP</title>
	<meta 	charset="utf-8" />
	<meta 	name="viewport" 
			content="width=device-width,initial-scale=1">			
	<link 	rel="stylesheet" 
			href="http://bcitcomp.ca/twd/css/simplestyles.css" />
</head>
<body>
<h1>Example Login / Registration System</h1>
<h2>Logout</h2>
<?php
/*
they want to log out,
erase any session related information for this user
*/

//resume session
session_start();

//clear session array variables
$_SESSSION = array();
//end session tracking
session_destroy();

?>
<p>You have been logged out</p>
<p><a href="login.php">Login</a></p>
</body>
</html>
