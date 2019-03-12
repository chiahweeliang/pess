<?php session_start();
// CHIA HWEE LIANG
// CHIA HWEE LIANG
if (isset($_POST["submit"])) {
	if ($_POST['UserID'] != "") {
		$_SESSION["UserID"] = $_POST["UserID"];
		header("Location: welcome.php");
		
	} else {
		echo "<h1 style='color:red;'>You are not signed in!</h1>";
	}
} 

if(isset($_SESSION["UserID"])) //detects if user is logged in or not
	header("Location: welcome.php");

?>







<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>Login</title>
	
	
<style type="text/css">
</style>
</head>

<body align="center";><?php include 'header.php'; ?>
<h1>Sign in</h1>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"method ="post">
  <p>User ID: <input type="text" name="UserID"></p>
	<p>Password: <input type="password" name="password"></p>
	<p><input type="submit" name="submit" value="Sign in"></p>
	 <p></p>
        <p>
			<label for="credits"></label>
			<label type ="text" name="credits" id="credits" readonly/>
				   </p>

</form>
</body>
</html>