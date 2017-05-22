<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	User page that is not the logged in user.
	called when a username button is clicked

	05/06/2017 original
	05/07/2017 added buttons for projects and users 
-->
<!DOCTYPE html>

<html>
<head>
  <title>User Page</title>
</head>
<?php
	session_start();
	$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");
?>
<body>
	<h1><?php	echo $_SESSION["uname"];?> <button onclick = "home();">Home</button> <button onclick = "logout();">Log out</button></h1>
	<button onclick="followUser()">Follow Me </button>
	<?php	
	if (isset($_SESSION["followMsg"]))
	{	
		echo $_SESSION["followMsg"];
		unset($_SESSION["followMsg"]);
	}
	
	?>
	<form method="POST" action="fromHome.php">
	<p><input type="text" size="10" name="keyword" > <input type="submit" value="Search Projects"></p>
	<h2>About Me</h2>
	<?php
	
	$query0 = "SELECT uid,uname, city, interests FROM users WHERE uname = '{$_SESSION["uname"]}'";
	
	mysqli_query($connect, $query0) or die('Error querying database.');
	$result0 = mysqli_query($connect, $query0);
	// Display user information
	
	while ($row = mysqli_fetch_array($result0)) {
		$_SESSION["uid"] = $row['uid'];
		//echo '<input type="submit" name = "fuid" value="Follow Me">'
 		echo "UserName: {$row['uname']}" . "<br>";
		echo "City: {$row['city']}" . "<br>";
		echo "Interests: {$row['interests']}" . "<br>";
	};	
	
	
	?>
	<h2>Discussions</h2>
	<?php
	//$query1 = "SELECT discuss.postid, discuss.uid, discuss.pbody FROM discuss, (SELECT fuid FROM follow WHERE uid = '{$_SESSION["uid"]}') as t1 WHERE discuss.uid = '{$_SESSION["uid"]}' or discuss.uid = t1.fuid ORDER BY postid";
	//$result1 = mysqli_query($connect, $query1);
	//while ($row = mysqli_fetch_array($result1)) {
	//	echo $row['uid'] . ':' . $row['pbody'] . "<br>";
	//};
	$getname = "SELECT postid, dtime, pbody, uname, projname FROM(SELECT TF.postid, TF.dtime, TF.pbody, users.uname, 
	TF.projid FROM (SELECT discuss.dtime, discuss.postid, discuss.uid, discuss.pbody, discuss.projid FROM discuss, 
	(SELECT fuid FROM follow WHERE uid = '{$_SESSION["uid"]}') as t1 WHERE discuss.uid = '{$_SESSION["uid"]}'
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
	WHERE likes.uid = '{$_SESSION["uid"]}' and likes.projid = t1.projid ORDER BY postTime";
	$result2 = mysqli_query($connect, $query2);
	while ($row = mysqli_fetch_array($result2)){
		echo '<input type="submit" name="projname" value="' . $row['projname'] . '">'. ': ' . $row['title'] . "<br>";
		//echo $row['projname'] . ': ' . $row['title'] . "<br>";
		echo $row['ubody'] . "<br>";
		echo $row['uextra'] . "<br>";
	};
	?>
	<h2>Following</h2>
	<?php
	$query3 = "SELECT users.uname FROM follow, users WHERE follow.uid = '{$_SESSION["uid"]}' and follow.fuid = users.uid";
	mysqli_query($connect, $query3) or die('Error querying database.');
	$result3 = mysqli_query($connect, $query3);
	while ($row = mysqli_fetch_array($result3)){
		echo '<input type="submit" name="uname" value="' . $row['uname'] . '">'. "<br>";
	};
	?>
	<h2>Sponsored Projects</h2>
	<?php
	$query4 = "SELECT projname FROM sponsor natural join allproj WHERE uid = '{$_SESSION["uid"]}'";
	mysqli_query($connect, $query4) or die('Error querying database.');
	$result4 = mysqli_query($connect, $query4);
	while ($row = mysqli_fetch_array($result4)) {
		echo '<input type="submit" name="projname" value="' . $row['projname'] . '">'. "<br>";
 		//echo $row['projname'] . "<br>";
	};
	?>
	<h2>Liked Projects</h2>
	<?php
	$query7 = "SELECT projname FROM likes natural join allproj WHERE uid = '{$_SESSION["uid"]}'";
	mysqli_query($connect, $query7) or die('Error querying database.');
	$result7 = mysqli_query($connect, $query7);
	while ($row = mysqli_fetch_array($result7)) {
		echo '<input type="submit" name="projname" value="' . $row['projname'] . '">'. "<br>";
 		//echo $row['projname'] . "<br>";
	};
	?>
	<h2>My Projects</h2>
	<?php
	$query10 = "Select projname from allproj, own WHERE own.uid = '{$_SESSION["uid"]}' and own.projid = allproj.projid";
	mysqli_query($connect, $query10) or die ('Error querying database.');
	$result10 = mysqli_query($connect, $query10);
	
	while($row = mysqli_fetch_array($result10)) {
		echo '<input type="submit" name="projname" value="' . $row['projname'] . '">'. "<br>";
	};
	?>
	
	<?php //Close connection 
	 //unset($_SESSION["uid"]);
	mysqli_close($connect);?>
</body>
</form>
	<script>
        function logout()
        {
			 window.location.href='http://localhost:8080/fundme/logout.php';
        }
		function home()
		{
			window.location.href='http://localhost:8080/fundme/home.php';
		}
		function followUser()
		{
			window.location.href = 'http://localhost:8080/fundme/followUser.php';
		}
    </script>
</html>