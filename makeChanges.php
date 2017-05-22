<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	called from the edit.php page
	updates the user table with the new given info

	05/06/2017 original
-->
<?php
session_start();
$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");

$city = mysqli_real_escape_string($connect, $_POST['city']);
$state = mysqli_real_escape_string($connect, $_POST['state']);
$interests = mysqli_real_escape_string($connect, $_POST['interests']);
$creditCard = mysqli_real_escape_string($connect, $_POST['creditCard']);
$loginpassword = mysqli_real_escape_string($connect, $_POST['loginPassword']);

if (!($city == NULL))
{
	$query0 = "UPDATE users set city = '{$city}' WHERE uid = '{$_SESSION["loginUsername"]}'";
	mysqli_query($connect, $query0) or die ('Error querying database1.');
}
if (!($state == NULL))
{
	$query0 = "UPDATE users set state = '{$state}' WHERE uid = '{$_SESSION["loginUsername"]}'";
	mysqli_query($connect, $query0) or die ('Error querying database2.');
}
if (!($interests == NULL))
{
	$query0 = "UPDATE users set interests = '{$interests}' WHERE uid = '{$_SESSION["loginUsername"]}'";
	mysqli_query($connect, $query0) or die ('Error querying database3.');
}
if (!($creditCard == NULL))
{
	$query0 = "UPDATE users set creditcard = '{$creditCard}' WHERE uid = '{$_SESSION["loginUsername"]}'";
	mysqli_query($connect, $query0) or die ('Error querying database4.');
}
if (!($loginpassword == NULL))
{
	$query0 = "UPDATE users set upass = '{$loginpassword}' WHERE uid = '{$_SESSION["loginUsername"]}'";
	mysqli_query($connect, $query0) or die ('Error querying database5.');
}
header("Location: home.php");
mysqli_close($connect);
?>