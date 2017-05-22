<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	called from project page so user can input the updates to the project
	and database
	calls update.php to make the updates to the database

	05/07/2017 original
-->

<!DOCTYPE html>
<html>
<head>
  <title>New Project</title>
</head>
<?php
	session_start();
	$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");
?>
<body>
<h1>New Project Details</h1>
<?php

	$checkOwn = "select * FROM own 
	WHERE uid = '{$_SESSION["loginUsername"]}' and projid = '{$_SESSION["projid"]}'";
	$check = mysqli_query($connect, $checkOwn);
	if (mysqli_num_rows($check) != 1)
	{		
		$_SESSION["updateMsg"] = "you can't do that.";
		header("Location: projPage.php");
	}
	//echo testing;
//	echo $_SESSION["updateMsg"];
	//mysqli_close($connect);
?>
<form method="POST" action="update.php" enctype="multipart/form-data" >
	<table>
	<tr>
		<td>Update title</td>
		<td><input type="text" size="10" name="title"></td>
	</tr>
	<tr>
		<td>Multimedia</td>
		<td><input type="file" size="10" name="media"></td>
	</tr>
	</table>
	<tr>
		<td>Update Body</td>
		<textarea name = "ubody" rows="4" cols="50"> </textarea>
	</tr>
	<p><input type="submit" name="upload" value="Update"></p>
	</form>
</body>

</html>	
	