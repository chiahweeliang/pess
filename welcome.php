<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>Update</title>
	
	
<style type="text/css">
</style>
</head>

<body>
<?php

// CHIA HWEE LIANG
// CHIA HWEE LIANG

	include 'header.php';
	

	session_start();

if(isset($_SESSION["UserID"])) //detects if user is logged in or not
	echo "POLICE EMERGENCY SERVICE SYSTEM | Welcome, user_" . $_SESSION["UserID"] . ".";
else
{
	header("Location: login.php"); // redirects guest-users to login site.
	//echo '<script>window.location.href = "welcome.php";</script>';
}
		
?>
	


</body>
</html>