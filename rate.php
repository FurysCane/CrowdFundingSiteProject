<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	page is called when the rate button is clicked on the project page
	it checks if the rating follows the rules, if the project was funded, and 
	if the person was a sponsor before adding a tuple into the rating table
	of the database

	05/07/2017 original
	-->
<?php
session_start();
$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");

$rating = mysqli_real_escape_string($connect, $_POST['rating']);

$checkfundedquery = "SELECT * FROM fundedproj WHERE projid = '{$_SESSION["projid"]}'";
mysqli_query($connect, $checkfundedquery) or die('Error querying database.');
$checkfunded = mysqli_query($connect, $checkfundedquery);

$checkSponsorquery = "SELECT * FROM sponsor WHERE projid = '{$_SESSION["projid"]}' and uid = '{$_SESSION["loginUsername"]}'";
mysqli_query($connect, $checkSponsorquery) or die('Error querying database.');
$checkSponsor = mysqli_query($connect, $checkSponsorquery);

$checkquery = "SELECT * FROM rate WHERE uid = '{$_SESSION["loginUsername"]}' and projid = '{$_SESSION["projid"]}'";
$insertquery = "INSERT into rate(projid, uid, rating) values('{$_SESSION["projid"]}', '{$_SESSION["loginUsername"]}', '{$rating}')";
$updatequery = "UPDATE rate SET rating = '{$rating}' WHERE projid = '{$_SESSION["projid"]}' and uid = '{$_SESSION["loginUsername"]}'";
mysqli_query($connect, $checkquery) or die('Error querying database.');
$check = mysqli_query($connect, $checkquery);

if (($rating > 5) or ($rating < 0))
{
	$_SESSION["rateMsg"] = "Ratings must be between 0 and 5.";
}
else if (mysqli_num_rows($check) == 1)
{
	$_SESSION["rateMsg"] = "Your rating for this Project has been updated.";
	mysqli_query($connect, $updatequery) or die ('Error querying database.');
}
else if (!(mysqli_num_rows($checkfunded) == 1))
{
	$_SESSION["rateMsg"] = "I'm sorry. You cannot rate an unfunded project.";
}
else if (!(mysqli_num_rows($checkSponsor) == 1))
{
	$_SESSION["rateMsg"] = "I'm sorry. You cannot rate a project you haven't funded.";
}
else
{
	mysqli_query($connect, $insertquery) or die ('Error querying database.');
	$_SESSION["rateMsg"] = "Thank you for rating this Project.";
}
header("Location: projPage.php");
mysqli_close($connect);
?>