<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	called from discussPage
	inserts the new post into the database and then
	returns the user to the project pages

	05/07/2017 original
	-->
<?php
session_start();
$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");

$body = mysqli_real_escape_string($connect, $_POST['discuss']);

date_default_timezone_set("America/New_York");
//echo "The time is " . date("h:i:sa");
$dtime = date('Y-m-d H:i:s ', time());

$checkRowquery = "SELECT * FROM discuss";
mysqli_query($connect, $checkRowquery) or die('Error querying database.');
$checkRow = mysqli_query($connect, $checkRowquery);
$pid = mysqli_num_rows($checkRow);
$pid = $pid +1;
//, '{$dtime}')
$insertquery = "INSERT INTO discuss(postid, uid, pbody, projid, dtime) VALUES('{$pid}', '{$_SESSION["loginUsername"]}', '{$body}', '{$_SESSION["projid"]}', '{$dtime}')";
if (mysqli_query($connect, $insertquery)){
	echo "New post. <br>";}
else { 
	echo "Error: " . $sql . "<br>" . mysqli_error($connect); 
}
//mysqli_query($connect, $insertquery) or die ('Error querying database.');

header("Location: projPage.php");
mysqli_close($connect);
?>