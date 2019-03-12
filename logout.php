<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>Update</title>
	
	
<style type="text/css">
</style>
</head>
	<script>
	 var box = document.getElementById("Logout");

		
	</script>

<body>
	

	
<?php
	include 'header.php';
	

	session_start();

if(isset($_SESSION["UserID"])) //detects if user is logged in or not
	echo "POLICE EMERGENCY SERVICE SYSTEM | LOGGED IN USER: " . $_SESSION["UserID"];
else
{
	header("Location: login.php"); // redirects guest-users to login site.
	//echo '<script>window.location.href = "welcome.php";</script>';
}
	?>
<?php
// CHIA HWEE LIANG
// CHIA HWEE LIANG
if(isset($_POST['Logout'])) {
  //Unset cookies and other things you want to
  unset($_SESSION['UserID']);	
  header('Location: login.php'); //Dont forget to redirect
  exit;
}
?>

<form method="POST">
  <input type="submit" name="Logout" id="Sign out" value="Sign out"/>
</form>
								 
	
	
</body>
</html>