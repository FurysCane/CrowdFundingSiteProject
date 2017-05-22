<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	Helpler function page for the sponsor page
	called from the sponsorpage

	05/07/2017 original
	-->
<?php
session_start();
$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");

$amount = mysqli_real_escape_string($connect, $_POST['pledge']);
//$_SESSION["amount"] = $amount;

$checkSponsorquery = "SELECT * FROM sponsor WHERE projid = '{$_SESSION["projid"]}' and uid = '{$_SESSION["loginUsername"]}'";
mysqli_query($connect, $checkSponsorquery) or die('Error querying database.');
$checkSponsor = mysqli_query($connect, $checkSponsorquery);

$checkActivequery = "SELECT * FROM activeproj WHERE projid = '{$_SESSION["projid"]}'";
mysqli_query($connect, $checkActivequery) or die('Error querying database.');
$checkActive = mysqli_query($connect, $checkActivequery);

$insertquery = "INSERT into sponsor(projid, uid, pledge) values('{$_SESSION["projid"]}', '{$_SESSION["loginUsername"]}', '{$amount}')";
$updatequery = "UPDATE sponsor SET pledge = '{$amount}' WHERE projid = '{$_SESSION["projid"]}' and uid = '{$_SESSION["loginUsername"]}";

if ((fmod($amount,1) != 0) or ($amount <= 0)) 
{
	$_SESSION["sponsorMsg"] = "Sponsor amounts must be in positive whole dollars.";
}
else if (!(mysqli_num_rows($checkActive) == 1))
{
	$_SESSION["sponsorMsg"] = "You cannot sponsor inactive projects.";
}
else if (mysqli_num_rows($checkSponsor) == 1)
{
	$_SESSION["sponsorMsg"] = "Your pledge cannot be changed";
	//mysqli_query($connect, $updatequery) or die ('Error querying database.');
	// currently messes with the trigger to update the project total
}
else 
{
	$_SESSION["sponsorMsg"] = "Thank you for sponsoring this project.";
	mysqli_query($connect, $insertquery) or die ('Error querying database.');
$checkActive = mysqli_query($connect, $checkActivequery);
while ($row = mysqli_fetch_array($checkActive)) {
		$body = mysqli_real_escape_string($connect,$row["description"]);
		$startDate = mysqli_real_escape_string($connect,$row["startDate"]);
		$endDate = mysqli_real_escape_string($connect,$row["endDate"]);
		$completeDate = mysqli_real_escape_string($connect,$row["completeDate"]);
		$total = mysqli_real_escape_string($connect,$row["totalFund"]);
		$minG = mysqli_real_escape_string($connect,$row["minGoal"]);
		$maxG = mysqli_real_escape_string($connect,$row["maxGoal"]);
		$tag = mysqli_real_escape_string($connect,$row["tag"]);
	};
	if ($total >= $maxG)
	{
		// insert project into the funded table
		$insertfunded = "INSERT INTO fundedproj(projid, projname, description, startDate, endDate, 
		completeDate, minGoal, maxGoal, totalFund, tag)
		VALUES('{$_SESSION["projid"]}', '{$_SESSION["projname"]}', '{$body}', '{$startDate}', 
		'{$endDate}', '{$completeDate}', '{$minG}', '{$maxG}', '{$total}', '{$tag}')";
		mysqli_query($connect, $insertfunded) or die(mysqli_error($connect));
		
		// charge sponsors who pledged to the project
		$getsponsors = "SELECT * FROM sponsor WHERE projid = '{$_SESSION["projid"]}'";
		mysqli_query($connect, $getsponsors) or die(mysqli_error($connect));
		$sponsors = mysqli_query($connect, $getsponsors);
		
		while ($row = mysqli_fetch_array($sponsors)) {
			$insertcharge = "INSERT INTO charges(uid, projid, charged) 
			VALUES('{$row[uid]}', '{$row['projid']}', '{$row['pledge']}')";
			mysqli_query($connect, $insertcharge) or die(mysqli_error($connect));
		}
	}
}
header("Location: projPage.php");
mysqli_close($connect);
?>