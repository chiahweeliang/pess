<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>Log Call</title>
	
	
<style type="text/css">
</style>
</head>

<body>
	<script>
	
	function validateForm()
	
		{
			alert("Validated!")
			
			var a = document.forms["frmLogCall"] ["callerName"].value;
			if (a == "")
				{
					alert("Name must be filled out");
					return false;
				}
			
			var b = document.forms["frmLogCall"] ["contactNo"].value;
			if (b == "")
				{
					alert("Contact Number must be filled out");
					return false;
				}
			
			var c = document.forms["frmLogCall"] ["location"].value;
			if (c == "")
				{
					alert("Location must be filled out");
					return false;
				}
			
			var d = document.forms["frmLogCall"] ["incidentDesc"].value;
			if (d == "")
				{
					alert("Description must be filled out");
					return false;
				}
			
		}
	
	</script>
<?php
	
include 'header.php';
	//localhost, accountname, accountpassword
	

$con = mysql_connect("localhost", "chiahweeliang", "chiahweeliang"); // connects to database with login credentials
if(!$con)
	die('Cannot connect to database: '.mysql_error()); // error input 

//databasename, $con
mysql_select_db("20_chiahweeliang_pessdb", $con); // goes to said database
	
	
/*
$sql ="INSERT INTO incident(callerName, PhoneNumber, incidentTypeId, incidentLocation, incidentDesc, incidentStatusId) 
VALUES('$_POST[callerName]', '$_POST[contactNo]', '$_POST[location]','$_POST[incidentLocation]', '$_POST[incidentDesc]', '1')";

*/	
	
	$result = mysql_query("SELECT * FROM incident_type"); // selects from incident_type
	
	$incidentType;
		
while($row = mysql_fetch_array($result)){
	$incidentType[$row['incidentTypeId']] = $row['incidentTypeDesc']; }
	
	
	if(isset($_POST['btnProcessCall'])){ // submission, 
		$sql ="INSERT INTO incident(callerName, PhoneNumber, incidentTypeId, incidentLocation, incidentDesc, incidentStatusId) 
VALUES('$_POST[callerName]', '$_POST[contactNo]', '$_POST[incidentType]','$_POST[location]', '$_POST[incidentDesc]', '1')";
		
	
	//echo $sql;
	

	if(!mysql_query($sql,$con))
	{
		die('Error: ' .mysql_error());
		
	}
	}
	
	
//VALUES('$_POST[callerName]', '$_POST[contactNo]', '$_POST[location]','$_POST[incidentLocation]', '$_POST[incidentDesc]', '1')";



mysql_close($con);
		

	
?>
	
	<fieldset><legend>Log Call</legend>
	<form name="frmLogCall" method="POST" onSubmit="return validateForm()" action="dispatch.php">
		
	
		
		
<table align="center">
<tr>
	<td align="center">Caller Name:</td>
	<td align="left"><input type="text" name="callerName" /></td>

</tr>

<tr>
	<td align="center">Contact No:</td>
	<td align="left"><p><input type="text" name="contactNo" /></p></td>
</tr>

<tr>
	<td align="center">Location:</td>
	<td align="left"><p><input type="text" name="location" /></p></td>
<tr>
	<tr>
		<td class="td_label" align="left">Incident Type: </td>
		<td align="left" ="td_Date">
			<p>
			<select name="incidentType" id="incidentType">
				<?php foreach($incidentType as $key => $value) {?>
					<option value="<?php echo $key ?>"><?php echo $value ?></option>
				<?php }?>
			</select>
			</p>
		</td>
	</tr>	
	

<tr>
	<td align="center">Description:</td>
	<td align="left"><p><textarea name="incidentDesc" row="5" col="50"></textarea></p></td>
</tr>
<tr>
	<td align="center"><input type="reset" /></p></td> 
		<td align="center"><input name="btnProcessCall" type="submit" value="Process Call" /></p></td>
</tr>	

		
		
</table>
</form>

<?php 
// CHIA HWEE LIANG
// CHIA HWEE LIANG
// CHIA HWEE LIANG
session_start();


if(isset($_SESSION["UserID"])) //detects if user is logged in or not
	echo "POLICE EMERGENCY SERVICE SYSTEM | LOGGED IN USER: " . $_SESSION["UserID"];
else
{
	header("Location: login.php");
}
?>

</body>
</html>