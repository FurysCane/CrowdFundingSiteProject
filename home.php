<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	Start Page for a crowd funding website
	http://localhost:8080/fundme/loginPage.php

	05/06/2017 original
	05/07/2017 added buttons: projects and users directors, and create new project, 
		tag functionality and buttons
	-->
<!DOCTYPE html>

<html>
<head>
  <title>Home Page</title>
</head>
<body>
	<h1>Home Page <button onclick = "edit();">Edit Profile</button> 
	<button onclick = "create();">Create a Project</button> 
	<button onclick = "logout();">Log out</button></h1>
	<form method="POST" action="fromHome.php">
	<p><input type="text" size="10" name="keyword" > <input type="submit" value="Search Projects"></p>
	<h2>About Me</h2>
	<?php
	session_start();
	$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");
	$query0 = "SELECT uname, city, interests FROM users WHERE uid = '{$_SESSION["loginUsername"]}'";
	
	mysqli_query($connect, $query0) or die('Error querying database.');
	$result0 = mysqli_query($connect, $query0);
	// Display user information
	
	while ($row = mysqli_fetch_array($result0)) {
		//echo 'testing';
 		echo "UserName: {$row['uname']}" . "<br>";
		echo "City: {$row['city']}" . "<br>";
		echo "Interests: {$row['interests']}" . "<br>";
	};	
	?>
	<h2>Discussions</h2>
	<?php
	//$query1 = "SELECT fuid FROM follow WHERE uid = '{$_SESSION["loginUsername"]}'";
	//$result1 = mysqli_query($connect, $query0);
	//$query1 = "SELECT discuss.postid, discuss.uid, discuss.pbody FROM discuss, (SELECT fuid FROM follow WHERE uid = '{$_SESSION["loginUsername"]}') as t1 WHERE discuss.uid = '{$_SESSION["loginUsername"]}' or discuss.uid = t1.fuid ORDER BY postid";
	//mysqli_query($connect, $query1) or die('Error querying database.');
	//$result1 = mysqli_query($connect, $query1);
	
	//$getname1 = "SELECT TF.postid, TF.dtime, TF.pbody, users.uname, TF.projid FROM (SELECT discuss.dtime, discuss.postid, discuss.uid, discuss.pbody, discuss.projid FROM discuss, (SELECT fuid FROM follow WHERE uid = '{$_SESSION["loginUsername"]}') as t1 WHERE discuss.uid = '{$_SESSION["loginUsername"]}' or discuss.uid = t1.fuid) as TF, users WHERE TF.uid = users.uid ORDER BY TF.dtime"; 
	$getname = "SELECT postid, dtime, pbody, uname, projname FROM(SELECT TF.postid, TF.dtime, TF.pbody, users.uname, 
	TF.projid FROM (SELECT discuss.dtime, discuss.postid, discuss.uid, discuss.pbody, discuss.projid FROM discuss, 
	(SELECT fuid FROM follow WHERE uid = '{$_SESSION["loginUsername"]}') as t1 WHERE discuss.uid = '{$_SESSION["loginUsername"]}'
	or discuss.uid = t1.fuid) as TF, users WHERE TF.uid = users.uid) as Tn, allproj WHERE Tn.projid = allproj.projid ORDER BY dtime";
	
	mysqli_query($connect, $getname) or die('Error querying database.');
	$withname = mysqli_query($connect, $getname);
	while ($row = mysqli_fetch_array($withname)){
		echo '<input type="submit" name="uname" value="' . $row['uname'] . '">' . $row['pbody'] . ' about ' . '<input type="submit" name="projname" value="' . $row['projname'] . '">' . "<br>";
	};
	?>
	<h2>Updates</h2>
	<?php
	$query2 = "SELECT t1.projname, t1.title, t1.ubody, t1.uextra FROM 
	(SELECT projid, projname, title, ubody, uextra, postTime FROM updates natural join fundedproj) as t1, likes 
	WHERE likes.uid = '{$_SESSION["loginUsername"]}' and likes.projid = t1.projid ORDER BY postTime";
	$result2 = mysqli_query($connect, $query2);
	while ($row = mysqli_fetch_array($result2)) {
		echo '<input type="submit" name="projname" value="' . $row['projname'] . '">' . ': ' . $row['title'] . "<br>";
		echo $row['ubody'] . "<br>";
		echo $row['uextra'] . "<br>";
	};
	?>
	<h2>Following</h2>
	<?php
	$query3 = "SELECT users.uname FROM follow, users WHERE follow.uid = '{$_SESSION["loginUsername"]}' and follow.fuid = users.uid";
	mysqli_query($connect, $query3) or die('Error querying database.');
	$result3 = mysqli_query($connect, $query3);
	while ($row = mysqli_fetch_array($result3)){
		echo '<input type="submit" name="uname" value="' . $row['uname'] . '">'. "<br>";
		//echo "<a href='http://www.website.com/page.html'>{$row['uname']}</a>" . "<br>";
 		//echo $row['uname'] . "<br>";
	};
	?>
	<h2>Sponsored Projects</h2>
	<?php
	$query4 = "SELECT projname FROM sponsor natural join allproj WHERE uid = '{$_SESSION["loginUsername"]}'";
	mysqli_query($connect, $query4) or die('Error querying database.');
	$result4 = mysqli_query($connect, $query4);
	while ($row = mysqli_fetch_array($result4)) {
		echo '<input type="submit" name="projname" value="' . $row['projname'] . '">'. "<br>";
 		//echo $row['projname'] . "<br>";
	};
	?>
	<h2>Liked Projects</h2>
	<?php
	$query7 = "SELECT projname FROM likes natural join allproj WHERE uid = '{$_SESSION["loginUsername"]}'";
	mysqli_query($connect, $query7) or die('Error querying database.');
	$result7 = mysqli_query($connect, $query7);
	while ($row = mysqli_fetch_array($result7)) {
		echo '<input type="submit" name="projname" value="' . $row['projname'] . '">'. "<br>";
 		//echo $row['projname'] . "<br>";
	};
	?>
	<h2>My Projects</h2>
	<?php
	$query10 = "Select projname from allproj, own WHERE own.uid = '{$_SESSION["loginUsername"]}' and own.projid = allproj.projid";
	mysqli_query($connect, $query10) or die ('Error querying database.');
	$result10 = mysqli_query($connect, $query10);
	
	while($row = mysqli_fetch_array($result10)) {
		echo '<input type="submit" name="projname" value="' . $row['projname'] . '">'. "<br>";
		//echo "<a href='http://localhost:8080/fundme/projPage.php'>{$row['projname']}</a>" . "<br>";
		//echo $row['projname'] . "<br>";
	};
	?>
	
	<?php //Close connection 
	mysqli_close($connect);?>
</body>
</form>
	<script>
		function edit()
        {
			 window.location.href='http://localhost:8080/fundme/edit.php';
        }
        function logout()
        {
			 window.location.href='http://localhost:8080/fundme/logout.php';
        }
		function create()
        {
			 window.location.href='http://localhost:8080/fundme/createProjPage.php';
        }
    </script>
</html>