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
	include 'header.php';
	
	if(!isset($_POST["btnSearch"])){
	
		

?>

<!--- create a form to search for patrol car based on id-->
<form name="form1" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?> ">
	

	
<fieldset><legend>Update</legend>	
			<?php 
	
			$hostname = "localhost";
			$username = "T0118013J";
			$password = "chiahweeliang";
			$databasename = "20_chiahweeliang_pessdb";
		
			$connect = mysqli_connect($hostname, $username, $password, $databasename);
			$query = "SELECT patrolcarId FROM patrolcar";
			
			$result1 = mysqli_query($connect, $query);
		
	?>
<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
	
<tr>
	<td width="25%" class="td_label">Patrol Car ID:</td>
	<td width="25%" class="td_Data"><select name="patrolCarId" id="patrolCarId">
	<?php while($row1 = mysqli_fetch_array($result1)):;?> 
	<option><?php echo $row1[0];?></option>
	<?php endwhile;?>
		</select>
	
	<!-- MUST VALIDATE FOR NO EMPTY ENTRT CLIENT SIDE, HOW????? -->
	<td class="td_Data"><input type="submit" name="btnSearch" id="btnSearch" value="Search"></td>
	
	</tr>
	</table>
	</form>
	
		<?php 
		} else {
			//echo $_POST["patrolCarId"];
			//retrieve patrol car status and patrolcarstatus
			// connect to a database
			$con=mysql_connect("localhost", "T0118013J", "chiahweeliang");
			if(!$con)
			{
				die('Cannot connect to database: ' . mysql_error());
			}
		// select a table in the database
			mysql_select_db('20_chiahweeliang_pessdb', $con);

		// retrieve patrol car status
		$sql="SELECT * FROM patrolcar WHERE patrolcarId='".$_POST['patrolCarId']."'";

		$result=mysql_query($sql,$con);

		$patrolCarId;
		$patrolCarStatusId;

			while($row =mysql_fetch_array($result))
			{
				//patrolcarId, patrolcarStatusId

				$patrolCarId=$row['patrolcarId'];
				$patrolCarStatusId=$row['patrolcarStatusId'];
			}
		//retrive patrolcarstatus master table
		$sql = "SELECT * FROM patrolcar_status";
		$result=mysql_query($sql,$con);
		$patrolCarStatusMaster;

		while($row = mysql_fetch_array($result))
		{
			//statusId, statusDesc
			//create an associative array of patrol car status master type

			$patrolCarStatusMaster[$row['statusId']] = $row['statusDesc'];
		}
		mysql_close($con);
	?>
<!-- display a form to update patrol car status
also update incident status when patrol car status is free-->


<form name="form2" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
	
	
<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
<tr>
<td width="25%" class="td_label">Patrol Car ID:</td>
<td width="25%" class="td_Data"><?php echo $_POST["patrolCarId"]?><input type="hidden" name="patrolCarId" id="patrolcarId" value="<?php echo $_POST["patrolCarId"]?>"></td>
</tr>

<tr>
<td class="td_label">Status:</td>
<td class="td_Data"><select name="patrolCarStatus" id="$patrolCarStatus">

<?php foreach( $patrolCarStatusMaster as $key => $value) {?>
	<option value="<?php echo $key ?>"
	<?php if($key==$patrolCarStatusId) {?>selected="selected"
	<?php }?>>
	<?php echo $value ?>
	</option>
<?php }?>
	</select></td>
	</tr>
	</table>
	</br>
	<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
	<tr>
	<td width="46%" class="td_label"><input type="reset" name="btnCancel" id="btnCancel" value="Reset"></td>
		
	<td width="54%" class="td_Data">&nbsp;<input type="submit" name="btnUpdate" id="btnUpdate" value="Update"></td>
		
		
		</tr>
	</table>
	</form>
	<?php }?>
	

	
	

<?php
	
if(isset($_POST["btnUpdate"])){
	$con=mysql_connect("localhost", "T0118013J", "chiahweeliang");
	if(!$con)
	{
		die('Cannot connect to database:'.mysql_error());
	}
	
	//select a table in the database
	mysql_select_db("20_chiahweeliang_pessdb", $con);

	//update patrol car status
	$sql = "UPDATE patrolcar SET patrolcarStatusId='".$_POST["patrolCarStatus"]."' WHERE patrolcarId='".$_POST["patrolCarId"]."'";
	
	if(!mysql_query($sql,$con))
	{
		die('Error4:' .mysql_error());
	}
	// if patrol car status is on-site (4) then capture the time of arrival
	if($_POST["patrolCarStatus"]=='4'){
	
	$sql="UPDATE dispatch SET timeArrived=NOW() WHERE timeArrived is NULL AND patrolcarId='" .$_POST["patrolCarId"]."'";

	if(!mysql_query($sql,$con))
	{
		die('Error4:' .mysql_error());
	}
	} elseif ($_POST["patrolCarStatus"]=='3'){ //else if patrol car status is FREE then capture the time of completion

	//first retrieve the incident id from dispatch tale handled by the patrol car
	$sql = "SELECT incidentid FROM dispatch WHERE timeCompleted IS NULL AND patrolcarId='".$_POST["patrolCarId"]."'";
	
	
	$result = mysql_query($sql,$con);
	$incidentId ;
	while($row=mysql_fetch_array($result))
	{

	//patrolcarId,patrolcarStatusId
		$incidentId = $row['incidentid'];
	}

	//echo $incidentId;

	//Now then can update dispatch
	$sql = "UPDATE dispatch SET timeCompleted=NOW() WHERE timeCompleted is NULL AND patrolcarId='".$_POST["patrolCarId"]."'";

	if(!mysql_query($sql,$con))
	{
		die('Error4: '.mysql_error());
	}

	//Last but not least, update incident in incident table to completed (3) all all patrol car attended to it are FREE now
	$sql = "UPDATE incident SET incidentStatusId='3' WHERE incidentid='$incidentId' AND incidentid NOT IN (SELECT incidentid FROM dispatch WHERE timeCompleted IS NULL)";

	if(!mysql_query($sql,$con))
	{
		die('Error5: '.mysql_error());
	}
}

mysql_close($con);

?>

<script typr="text/javascript">window.location="./logcall.php";</script>

<?php } ?>
	
<?php 

session_start();

// CHIA HWEE LIANG
// CHIA HWEE LIANG
// CHIA HWEE LIANG
if(isset($_SESSION["UserID"])) //detects if user is logged in or not
	echo "POLICE EMERGENCY SERVICE SYSTEM | LOGGED IN USER: " . $_SESSION["UserID"];
else
{
	header("Location: login.php");
}
?>
	
</body>
</html>