<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	page can be called from user profile pages when the follow me button 
	is clicked
	this page inserts a new tuple into the follows table of the database

	05/07/2017 original
	-->
<?php
session_start();
$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");
	
$checkquery = "SELECT * FROM follow WHERE uid = '{$_SESSION["loginUsername"]}' and fuid = '{$_SESSION["uid"]}'";
$insertquery = "INSERT into follow(uid, fuid) values('{$_SESSION["loginUsername"]}', '{$_SESSION["uid"]}')";
mysqli_query($connect, $checkquery) or die('Error querying database.');
$check = mysqli_query($connect, $checkquery);
if (mysqli_num_rows($check) == 1)
{
	$_SESSION["followMsg"] = "You are already following {$_SESSION["uname"]}.";
}
else
{
	mysqli_query($connect, $insertquery) or die ('Error querying database.');
	$_SESSION["followMsg"] = "You are now following {$_SESSION["uname"]}.";
}

header("Location: userPage.php");
mysqli_close($connect);
?>