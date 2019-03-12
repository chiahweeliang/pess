<?php
if(!isset($_POST['btnProcessCall']) && !isset($_POST['btnDispatch']))
header("Location: logcall.php");

// CHIA HWEE LIANG
// CHIA HWEE LIANG
// CHIA HWEE LIANG
// CHIA HWEE LIANG



//$con = mysql_connect("localhost", "chiahweeliang", "chiahweeliang"); // connects to database with login credentials
//if(!$con)
	//die('Cannot connect to database: '.mysql_error()); // error input 

//databasename, $con
//mysql_select_db("20_chiahweeliang_pessdb", $con); // goes to said database


	if(isset($_POST['btnProcessCall'])){ // submission, 
		
		$con = mysql_connect("localhost", "chiahweeliang", "chiahweeliang"); // connects to database with login credentials
if(!$con)
	die('Cannot connect to database: '.mysql_error()); // error input 

//databasename, $con
mysql_select_db("20_chiahweeliang_pessdb", $con); // goes to said database
		
		
		$sql ="INSERT INTO incident(callerName, PhoneNumber, incidentTypeId, incidentLocation, incidentDesc, incidentStatusId) 
VALUES('$_POST[callerName]', '$_POST[contactNo]', '$_POST[incidentType]','$_POST[location]', '$_POST[incidentDesc]', '1')";
		
//$sql= "INSERT INTO incident(callerName, phoneNumber, incidentTypeId, incidentLocation, incidentDesc, incidentStatusId) VALUES('" .$_POST['callerName']. "', '".$_POST['contactNo']."', '".$_POST['incidentType']. "', '" .$_POST['location']. "', '".$_POST['incidentDesc']. "', '$status')";
	
	//echo $sql;

	if(!mysql_query($sql,$con))
	{
		die('Error: ' .mysql_error());
		
	}
	}
	
	?>


<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>Log Call</title>
	
	
<style type="text/css">
</style>
</head>

<body>
<?php	
	include 'header.php';
/* Search and retrieve similar pending incidents and populate a table */

// connect to a database
$con = mysql_connect("localhost", "T0118013J", "chiahweeliang");
if(!$con)
{
	die("Cannot connect to database : " . mysql_error());
}

// select a table in the database
mysql_select_db("20_chiahweeliang_pessdb", $con);
	
$sql="SELECT patrolcarId, statusDesc FROM patrolcar JOIN patrolcar_status ON patrolcar.patrolcarStatusId=patrolcar_status.statusId WHERE patrolcar.patrolcarStatusId='2' OR patrolcar.patrolcarStatusId='3'";

$result = mysql_query($sql, $con);
$incidentArray;
$count=0;

while($row = mysql_fetch_array($result))
{
	$patrolcarArray[$count]=$row;
	$count++;
}

if(!mysql_query($sql,$con))
{
	die("Error: " . mysql_error());
}

mysql_close($con);
?>
<?php /** part 2 | page 4 project guide 6 **/
if(isset($_POST['btnSubmit']))
{
	//connect to database
	$con=mysql_connect("localhost", "T0118013J", "chiahweeliang");

	
if(!$con)
{
	die('Cannot connect to database: ' . mysql_error());
}
	
mysql_select_db("20_chiahweeliang_pessdb", $con);
	
//update patrolcar status table and dispatch table
$patrolcarDispatched = $_POST["chkPatrolcar"];

$c = count($patrolcarDispatched);

//insert new incident
$status;
if($c > 0){
	$status="2";
}else {
	$status="1";
}

			$sql ="INSERT INTO incident(callerName, PhoneNumber, incidentTypeId, incidentLocation, incidentDesc, incidentStatusId) 
VALUES('$_POST[callerName]', '$_POST[contactNo]', '$_POST[incidentType]','$_POST[location]', '$_POST[incidentDesc]', '1')";
//$sql= "INSERT INTO incident(callerName, phoneNumber, incidentTypeId, incidentLocation, incidentDesc, incidentStatusId) VALUES('" .$_POST['callerName']. "', '".$_POST['contactNo']."', '".$_POST['incidentType']. "', '" .$_POST['location']. "', '".$_POST['incidentDesc']. "', '$status')";

	//echo $sql;
	if(!mysql_query($sql, $con))
	{
		die("Error1: " . mysql_error());
	}
	// retrieve new incremental key for incidentId
	$incidentId=mysql_insert_id($con);;
	
for($i=0; $i < $c; $i++)
{
		$sql ="UPDATE patrolcar SET patrolcarStatusId='1' WHERE patrolcarId='$patrolcarDispatched[$i]'";
		
		if(!mysql_query($sql, $con))
		{
			die("Error2: " . mysql_error());
		}
	
$sql="INSERT INTO dispatch(incidentid, patrolcarId, timeDispatched) VALUES('$incidentId', '$patrolcarDispatched[$i]', NOW())"; //echo $sql;
	
	if(!mysql_query($sql,$con))
	{
		die("Error3: " . mysql_error());
	}
}

	mysql_close($con);
}
?>
	
	<fieldset><legend>Dispatch</legend>
<form name="DispatchForm" method="POST" onSubmit="return validateForm()" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
	
		
		
<table align="center">
<tr>
	<td align="center">Caller Name:</td>
	<td align="left"><input type="hidden" name="callerName" />
	<?php echo $_POST['callerName']; ?></td>

</tr>

<tr>
	<td align="center">Contact No:</td>
	<td align="left"><input type="hidden" name="contactNo" /><?php echo $_POST['contactNo']; ?></td>
</tr>

<tr>
	<td align="center">Location:</td>
	<td align="left"><input type="hidden" name="location" /><?php echo $_POST['location']; ?></td>
<tr>
	<tr>
		<td class="td_label" align="left">Incident Type: </td>
		<td align="left"><input type="hidden" name="incidentType" /><?php echo $_POST['incidentType']; ?></td>
		</td>
	</tr>	
	

<tr>
	<td align="center">Description:</td>
	<td align="left"><p><textarea name="incidentDesc" row="5" col="50"><?php echo $_POST['incidentDesc']; ?></textarea></p></td>
</tr>
</tr>


<br>	
		
</table>
<table width="40%" border="1" align="center" cellpadding="4" cellspacing="8">
<tr>
<td width="20%">&nbsp;</td>
<td width="51%">Patrol Car ID</td>
<td width="29%">Status</td>	
	</tr>
	<?php
	$i=0;
while($i<$count){
	?>

	<tr>
	<td class="td_label"><input type="checkbox" name="chkPatrolcar[]" value="<?php echo $patrolcarArray[$i]['patrolcarId']?>"></td>	
	<td><?php echo $patrolcarArray[$i]['patrolcarId']?></td>
	<td><?php echo $patrolcarArray[$i]['statusDesc']?></td>
    </tr>


	<?php $i++; 
} ?>
	

</table>
	<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
	<td width = "46%" class="td_label" align="right"><input type="reset" name="btnCancel" id="btnCancel" value="Reset"></td>
	<td width="54%" class="td_Data" align="left"><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit"></td>
	</table>
</form>

<?php 

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