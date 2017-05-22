<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	can be called from a user page when the Browse Projects button is clicked
	This searches the database for relevant projects and displays them for the
	user

	05/07/2017 original
	-->
<!DOCTYPE html>
<html>
<head>
  <title>Search Results</title>
</head>
<body>
<h1>Search Results <button onclick = "home();">Home</button> <button onclick = "logout();">Log out</button></h1>
<form method="POST" action="fromHome.php">
	<?php
	session_start();
	$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");
	if (!($_SESSION["tag"] == NULL))
	{
		$tagquery = "SELECT projname FROM allproj WHERE tag LIKE '%%{$_SESSION["tag"]}%%'";
		mysqli_query($connect, $tagquery) or die('Error querying database.');
		$tagresult = mysqli_query($connect, $tagquery);
		while ($row = mysqli_fetch_array($tagresult))
		{
			echo '<input type="submit" name="projname" value="' . $row['projname'] . '">'. "<br>";
		} 
		unset($_SESSION["tag"]);
	}
	else
	{
		$query0 = "SELECT projname FROM allproj WHERE projname LIKE '%%{$_SESSION["keyword"]}%%' OR description LIKE '%%{$_SESSION["keyword"]}%%' OR tag LIKE '%%{$_SESSION["keyword"]}%%'";
		mysqli_query($connect, $query0) or die('Error querying database.');
		$result0 = mysqli_query($connect, $query0);
		while ($row = mysqli_fetch_array($result0)){
			echo '<input type="submit" name="projname" value="' . $row['projname'] . '">'. "<br>";
		} 
	}
	//Close connection 
	mysqli_close($connect);
	?>
	</form>
</body>
<script>
    function logout()
    {
		window.location.href='http://localhost:8080/fundme/logout.php';
    }
	function home()
	{
		window.location.href='http://localhost:8080/fundme/home.php';
	}
</script>
</html>