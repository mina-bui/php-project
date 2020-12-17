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
<h2>Secure content page</h2>
<?php
/*  */
session_start();

/* only allow logged in users to see this page */
if(  !isset($_SESSION["username"]) ){
	$_SESSION['errorMessages'] = "<p>You need to log in to see the content...</p>";
	header("Location: login.php");
	die();	
}

?>
<p>Hello <?php echo $_SESSION['username']; ?>, you have been successfully logged in!</p>
<p>Only authorized users can view this page.</p>

<p><a href="logout.php">Logout</a></p>
</body>
</html>
