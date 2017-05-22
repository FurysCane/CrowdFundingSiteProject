<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	Page for creating a new project called when the create new project button 
	is pressed in the home pages
	calls the createProj.php file to make the changes

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
	if (isset($_SESSION["createMsg"]))
	{	
		echo $_SESSION["createMsg"];
		unset($_SESSION["createMsg"]);
	}
	mysqli_close($connect);
?>
<form method="POST" action="createProj.php" enctype="multipart/form-data" >
	<table>
	<tr>
		<td>Project Name</td>
		<td><input type="text" size="10" name="projname"></td>
	</tr>
	<tr>
		<td>Multimedia</td>
		<td><input type="file" name="media" id = "media"></td>
	</tr>
	<tr>
		<td>End Date</td>
		<td><input type="text" size="10" name="endDate"></td>
	</tr>
	<tr>
		<td>Estimated Completion Date</td>
		<td><input type="text" size="10" name="completeDate"></td>
	</tr>
	<tr>
		<td>Minimum Goal</td>
		<td><input type="text" size="10" name="minGoal"></td>
	</tr>
	<tr>
		<td>Maximum Goal</td>
		<td><input type="text" size="10" name="maxGoal"></td>
	</tr>
	<tr>
		<td>Tag</td>
		<td><input type="text" size="10" name="tag"></td>
	</tr>
	</table>
	<tr>
		<td>Descrition</td>
		<textarea name = "description" rows="4" cols="50"> </textarea>
	</tr>
	<p><input type="submit" name="upload" value="Create"></p>
	</form>
</body>

</html>