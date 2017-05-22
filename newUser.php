<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	called from the newUserPage
	updates the users table in the database
	makes sure the userid and name are unique

	05/07/2017 original
-->
<?php
session_start();
$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");

$uid = mysqli_real_escape_string($connect, $_POST['uid']);
$uname = mysqli_real_escape_string($connect, $_POST['name']);
$city = mysqli_real_escape_string($connect, $_POST['city']);
$state = mysqli_real_escape_string($connect, $_POST['state']);
$interests = mysqli_real_escape_string($connect, $_POST['interests']);
$creditCard = mysqli_real_escape_string($connect, $_POST['creditCard']);
$loginpassword = mysqli_real_escape_string($connect, $_POST['loginPassword']);

//Check name unique
$checkNamequery = "SELECT * FROM users WHERE uname = '{$uname}'";
mysqli_query($connect, $checkNamequery) or die('Error querying database.3');
$checkName = mysqli_query($connect, $checkNamequery);
//Check uid unique
$checkIDquery = "SELECT * FROM users WHERE uid = '{$uid}'";
mysqli_query($connect, $checkIDquery) or die('Error querying database.3');
$checkID = mysqli_query($connect, $checkIDquery);

$insert = "INSERT INTO users(uid, uname, upass, creditcard, city, state, interests) 
VALUES('{$uid}', '{$uname}', '{$loginpassword}', '{$creditCard}', '{$city}', '{$state}', '{$interests}')";

if (mysqli_num_rows($checkName) == 1)
{
	$_SESSION["userMsg"] = "Please choose a unique name.";
	header("Location: newUserPage.php");
}
else if (mysqli_num_rows($checkID) == 1)
{
	$_SESSION["userMsg"] = "An account related to this email already exists";
	header("Location: newUserPage.php");
}
else
{
	if (mysqli_query($connect, $insert)){
		$_SESSION["loginUsername"] = $uid;
		header("Location: home.php");
	}
	else { 
		echo "Error: " . $sql . "<br>" . mysqli_error($connect); 
	}
}
mysqli_close($connect);
?>