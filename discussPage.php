<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	Page called from the project page
	Used by users who wish to discuss a project
	calls discuss.php 

	05/07/2017 original
	-->
<!DOCTYPE html>

<html>
<head>
  <title>Discuss this project</title>
</head>
<body>
<h1> Discuss this project </h1>
<form method="POST" action="discuss.php">
<textarea name = "discuss" rows="4" cols="50"> </textarea>
<p><input type="submit" value="discuss">
</form>
</body>
</html>
<!-- 
<?php
session_start();
$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");
$checkRowquery = "SELECT * FROM discuss";
mysqli_query($connect, $checkRowquery) or die('Error querying database.1');
$checkRow = mysqli_query($connect, $checkRowquery);
$pid = mysqli_num_rows($checkRow);

echo $pid;
?>
-->