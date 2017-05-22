<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	Displays the project information can be called from any page
	with a project button

	05/07/2017 original
	-->
<!DOCTYPE html>
<html>
<head>
  <title>Project Page </title>
</head>
<?php
	session_start();
	$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");
?>
<body>
<button onclick = "home();">Home</button> <button onclick = "logout();">Log out</button>

<h1> <?php	echo $_SESSION["projname"];?></h1>
<p> <button onclick="likeProj()">Like Project </button> <button onclick = "sponsor();">Sponsor this Project</button> 
<button onclick = "rate();">Rate</button>  <button onclick = "update();">Update</button> 
<button onclick = "video();">Upload video</button></p>
<?php	
	if (isset($_SESSION["likeMsg"]))
	{	
		echo $_SESSION["likeMsg"];
		unset($_SESSION["likeMsg"]);
	}
	if (isset($_SESSION["rateMsg"]))
	{	
		echo $_SESSION["rateMsg"];
		unset($_SESSION["rateMsg"]);
	}
	if (isset($_SESSION["sponsorMsg"]))
	{	
		echo $_SESSION["sponsorMsg"];
		unset($_SESSION["sponsorMsg"]);
	}
	if (isset($_SESSION["updateMsg"]))
	{	
		echo $_SESSION["updateMsg"];
		unset($_SESSION["updateMsg"]);
	}
?>
<form method="POST" action="fromHome.php">
	<h2> Project Details </h2>
	<?php
	//Display creator
	$createdquery = "SELECT uname,own.uid FROM own, users WHERE own.projid = {$_SESSION["projid"]} and own.uid = users.uid";
	mysqli_query($connect, $createdquery) or die('Error querying database.');
	$creator = mysqli_query($connect, $createdquery);
	while ($row = mysqli_fetch_array($creator)){
		$_SESSION["creator"] = $row['uid'];
		echo 'Created by ' . '<input type="submit" name="uname" value="' . $row['uname'] . '">'. "<br>";
	};
	
	//Display ratings
	$ratingquery = "SELECT avg(rating) as A FROM rate WHERE projid = {$_SESSION["projid"]}";
	mysqli_query($connect, $ratingquery) or die('Error querying database.');
	$rating = mysqli_query($connect, $ratingquery);
	if (mysqli_num_rows($rating) == 1)
	{
		while ($row = mysqli_fetch_array($rating)){
		echo "Current Rating: {$row["A"]} out of 5" . "<br>";
		}
	}	
	
	$query0 = "SELECT * FROM allproj WHERE projid = '{$_SESSION["projid"]}'";
	mysqli_query($connect, $query0) or die('Error querying database.');
	$result0 = mysqli_query($connect, $query0);
	while ($row = mysqli_fetch_array($result0)) {
		//echo 'testing';
		//$_SESSION["projid"] = $row['projid'];
		if ($row['file'] != NULL){
			//echo $text;
			$text =  $row['file'];
			echo "<a href='{$text}'> View </a>" . "<br>";
			//echo "<a href='http://localhost:8080/fundme/uploads/Spanish%20Tree%20Complete.jpg'>Click here</a>";
		}
 		echo "Description: {$row['description']}" . "<br>";
		echo "Multimedia: {$row['otherinfo']}" . "<br>";
		echo "Start Date: {$row['startDate']}" . "<br>";
		echo "End Date: {$row['endDate']}" . "<br>";
		echo "Estimated Completion Date: {$row['completeDate']}" . "<br>";
		echo "Minimum Goal: $" . "{$row['minGoal']}" . "<br>";
		echo "Maximum Goal: $" . "{$row['maxGoal']}" . "<br>";
		echo "Current Funds: $" . "{$row['totalFund']}" . "<br>";
		echo "Tags: ". '<input type="submit" name="tag" value="' . $row['tag'] . '">' . "<br>";
	};
	
	
	?>
	<h2> Updates </h2>
	<?php
	$updatequery = "SELECT * FROM updates WHERE projid = {$_SESSION["projid"]}";
	mysqli_query($connect, $updatequery) or die('Error querying database.');
	$updates = mysqli_query($connect, $updatequery);
	while ($row = mysqli_fetch_array($updates)){
		echo $row['title'] . "<br>";
		echo $row['ubody'] . "<br>";
		//echo $row['uextra'] . "<br>";
		$text =  $row['file'];
		//$text = "file:///" . "{$row['file']}";
		if ($row['file'] != NULL){
			//echo $text;
			echo "<a href='{$text}'> View </a>" . "<br>";
			//echo "<a href='http://localhost:8080/fundme/uploads/Spanish%20Tree%20Complete.jpg'>Click here</a>";
		}
		echo "<br>";
	};
	?>

	<h2> Sponsors </h2>
	<?php
	$query1 = "SELECT uname FROM sponsor, users WHERE projid = '{$_SESSION["projid"]}' and sponsor.uid = users.uid";
	mysqli_query($connect, $query1) or die('Error querying database.');
	$result1 = mysqli_query($connect, $query1);
	while ($row = mysqli_fetch_array($result1)) {
		echo '<input type="submit" name="uname" value="' . $row['uname'] . '">'. "<br>";
	};
	?>
	
	<h2> Discussion </h2>
	<?php
	$query2 = "SELECT postid, dtime, pbody, extra, uname FROM discuss,users 
	WHERE projid = '{$_SESSION["projid"]}' and  discuss.uid = users.uid ORDER BY dtime";
	mysqli_query($connect, $query2) or die('Error querying database.');
	$result2 = mysqli_query($connect, $query2);
	while ($row = mysqli_fetch_array($result2)){
		echo '<input type="submit" name="uname" value="' . $row['uname'] . '">' . $row['pbody'] . "<br>";
	};
	?> </form>
	<button onclick = "discuss();">Talk about the Project</button> </p>
	<?php	
	//Close connection 
	mysqli_close($connect);
	?>
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
	function likeProj()
	{
		window.location.href='http://localhost:8080/fundme/likeProj.php';
	}
	function discuss()
	{
		window.location.href='http://localhost:8080/fundme/discussPage.php';
	}
	function rate()
	{
		window.location.href='http://localhost:8080/fundme/ratePage.php';
	}
	function sponsor()
	{
		window.location.href='http://localhost:8080/fundme/sponsorPage.php';
	}
	function update()
	{
		window.location.href='http://localhost:8080/fundme/updatePage.php';
	}
	function video()
	{
		window.location.href='http://localhost:8080/fundme/videoPage.php';
	}
</script>
</html>