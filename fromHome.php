<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	Helpler function for the home and search page

	05/07/2017 original
	
	-->
<?php
	session_start();
	$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");
	
	date_default_timezone_set("America/New_York");
	$dtime = date('Y-m-d H:i:s ', time());
	
	$keyword = mysqli_real_escape_string($connect, $_POST['keyword']);
	$projname = mysqli_real_escape_string($connect, $_POST['projname']);
	$uid = mysqli_real_escape_string($connect, $_POST['uname']);
	$tag = mysqli_real_escape_string($connect, $_POST['tag']);
	
	$_SESSION["keyword"] = $keyword;
	$_SESSION["projname"] = $projname;
	$_SESSION["uname"] = $uid;
	$_SESSION["tag"] = $tag;
	
	$query0 = "SELECT projid FROM allproj WHERE projname = '{$_SESSION["projname"]}'";
	mysqli_query($connect, $query0) or die('Error querying database.');
	$result0 = mysqli_query($connect, $query0);
	while ($row = mysqli_fetch_array($result0)) {
		$_SESSION["projid"] = $row['projid'];
	}
	
	//Insert queries for the user log files
	$insertProj = "INSERT INTO userlogproj(uid,projid,lpdate)
	VALUES('{$_SESSION["loginUsername"]}', '{$_SESSION["projid"]}', '{$dtime}')";
	$insertkey = "INSERT INTO userlogkeys(uid,keyword,lpdate)
	VALUES('{$_SESSION["loginUsername"]}', '{$_SESSION["keyword"]}', '{$dtime}')";
	$inserttag = "INSERT INTO userlogtags(uid,tag,lpdate)
	VALUES('{$_SESSION["loginUsername"]}', '{$_SESSION["tag"]}', '{$dtime}')";
	
	if (!($_SESSION["projname"] == NULL))
	{
		if (mysqli_query($connect, $insertProj)){
			header("Location: projPage.php");		
		}
		else { 
			echo "Error: " . $sql . "<br>" . mysqli_error($connect); 
		}
		
		//mysqli_query($connect, $insertProj) or die('Error querying database.1');
		
	}
	elseif (!($_SESSION["uname"] == NULL))
	{
		header("Location: userPage.php");
	}
	else
	{
		if (!($_SESSION["tag"] == NULL))
		{
			mysqli_query($connect, $inserttag) or die('Error querying database.2');
		}
		if (!($_SESSION["keyword"]) == NULL)
		{
			mysqli_query($connect, $insertkey) or die('Error querying database.3');
		}
		header("Location: SearchResults.php");
	}
	mysqli_close($connect);
	
	
?>