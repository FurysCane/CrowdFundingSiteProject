<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	login check from php examples
	also checks if any active project has timed out

	04/27/2017 original
	05/08/2017 checks if any project has timed out and inserts that
	project to the appropriate tables
-->
<!DOCTYPE html>
<html>
<body>

<?php

	require 'authentication.inc';
	
	$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");
	// Clean data inputs from userpass
	$loginUsername = mysqli_real_escape_string($connect, $_POST['loginUsername']);
	$loginPassword = mysqli_real_escape_string($connect, $_POST['loginPassword']);
	//if (!mysqli_select_db("fundme", $connect)) sould only be used if changing the default database 
		//mysqli_error();
	
	
	// Check if any projects have timed out and moves them to their
	// appropriate tables
	date_default_timezone_set("America/New_York");
	$dtime = date('Y-m-d H:i:s ', time());
	
	$projquery = "SELECT * FROM activeproj";
	mysqli_query($connect, $projquery) or die(mysqli_error($connect));
	$projects = mysqli_query($connect, $projquery);	
	while($row = mysqli_fetch_array($projects))
	{
		$projid = mysqli_real_escape_string($connect,$row["projid"]);
		$projname = mysqli_real_escape_string($connect,$row["projname"]);
		$body = mysqli_real_escape_string($connect,$row["description"]);
		$startDate = mysqli_real_escape_string($connect,$row["startDate"]);
		$endDate = mysqli_real_escape_string($connect,$row["endDate"]);
		$completeDate = mysqli_real_escape_string($connect,$row["completeDate"]);
		$total = mysqli_real_escape_string($connect,$row["totalFund"]);
		$minG = mysqli_real_escape_string($connect,$row["minGoal"]);
		$maxG = mysqli_real_escape_string($connect,$row["maxGoal"]);
		$tag = mysqli_real_escape_string($connect,$row["tag"]);
		
		$insertfunded = "INSERT INTO fundedproj(projid, projname, description, startDate, endDate, 
		completeDate, minGoal, maxGoal, totalFund, tag)
		VALUES('{$projid}', '{$projname}', '{$body}', '{$startDate}', 
		'{$endDate}', '{$completeDate}', '{$minG}', '{$maxG}', '{$total}', '{$tag}')";
		$insertfailed = "INSERT INTO failedproj(projid, projname, description, startDate, endDate, 
		completeDate, minGoal, maxGoal, totalFund, tag)
		VALUES('{$projid}', '{$projname}', '{$body}', '{$startDate}', 
		'{$endDate}', '{$completeDate}', '{$minG}', '{$maxG}', '{$total}', '{$tag}')";
		
		if ($endDate >= $dtime and $total >= $minG) //funded 
		{
			//charge sponsors
			$getsponsors = "SELECT * FROM sponsor WHERE projid = '{$projid}'";
			mysqli_query($connect, $getsponsors) or die(mysqli_error($connect));
			$sponsors = mysqli_query($connect, $getsponsors);
		
			while ($row = mysqli_fetch_array($sponsors)) {
				$insertcharge = "INSERT INTO charges(uid, projid, charged) 
				VALUES('{$row[uid]}', '{$row['projid']}', '{$row['pledge']}')";
				mysqli_query($connect, $insertcharge) or die(mysqli_error($connect));
			}
			//insert into funded table
			mysqli_query($connect, $insertfunded) or die(mysqli_error($connect));
		}
		if ($endDate >= $dtime and $total < minG) //failed
		{
			mysqli_query($connect, $insertfailed) or die(mysqli_error($connect));
		}
	}
	
	session_start();
	
	//Authenticate the user
	if (authenticateUser($connect, $loginUsername, $loginPassword))
	{// Register the loginUsername
		$_SESSION["loginUsername"] = $loginUsername;
		// Register the IP address that started the session
		$_SESSION["loginIP"] = $_SERVER["REMOTE_ADDR"];
		
		// Relocate back to the first page of the application
		header("Location: home.php");		
		exit;
	}
	else
	{//Authentication failed: set up a logout message
		$_SESSION["message"] = "Could not connect to the application as '{$loginUsername}'";
		// Relocate to the logout page header
		header("Location: logout.php");
		exit;
	}
	
	?>
</body>
</html>
