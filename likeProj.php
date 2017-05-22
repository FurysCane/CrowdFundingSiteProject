<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	page is called when the like button is clicked on the project page
	it inserts a tuple into the likes table of the database

	05/07/2017 original
-->
<?php
session_start();
$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");

$checkquery = "SELECT * FROM likes WHERE uid = '{$_SESSION["loginUsername"]}' and projid = '{$_SESSION["projid"]}'";
$insertquery = "INSERT into likes(uid, projid) values('{$_SESSION["loginUsername"]}', '{$_SESSION["projid"]}')";
mysqli_query($connect, $checkquery) or die('Error querying database.');
$check = mysqli_query($connect, $checkquery);
if (mysqli_num_rows($check) == 1)
{
	$_SESSION["likeMsg"] = "You are already following this Project.";
}
else
{
	mysqli_query($connect, $insertquery) or die ('Error querying database.');
	$_SESSION["likeMsg"] = "Thank you for liking this Project.";
}
header("Location: projPage.php");
mysqli_close($connect);
?>