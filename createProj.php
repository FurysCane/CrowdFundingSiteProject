<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	called from the createProjPage
	updates the active project table in the database
	with the new project then sends you to then new Project's page

	05/07/2017 original
	05/09/2017 media functionality taken from 
	https://www.w3schools.com/php/php_file_upload.asp
-->
<?php
session_start();
$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");

$name = mysqli_real_escape_string($connect, $_POST['projname']);
$endDate = mysqli_real_escape_string($connect, $_POST['endDate']);
$completeDate = mysqli_real_escape_string($connect, $_POST['completeDate']);
$minG = mysqli_real_escape_string($connect, $_POST['minGoal']);
$maxG = mysqli_real_escape_string($connect, $_POST['maxGoal']);
$tag = mysqli_real_escape_string($connect, $_POST['tag']);
$body = mysqli_real_escape_string($connect, $_POST['description']);

$uploadOk = 0;
if ($_FILES["media"]["name"] != NULL)
{
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["media"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$file_type = $_FILES['media']['type'];
$file_size = $_FILES['media']['size'];
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["media"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["media"]["size"] > 500000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "JPG") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} 
else {
    if (move_uploaded_file($_FILES["media"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["media"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file." . "<br>";
		echo $_FILES['media']['error'];
		$uploadOk == 0;
    }
}
}
date_default_timezone_set("America/New_York");
$dtime = date('Y-m-d H:i:s ', time());
$endDate = strtotime($endDate);
$completeDate = strtotime($completeDate);
$endDate = date("Y-m-d h:i:s", $endDate);
$completeDate = date("Y-m-d h:i:s", $completeDate);

$checkRowquery = "SELECT * FROM allproj";
mysqli_query($connect, $checkRowquery) or die('Error querying database.4');
$checkRow = mysqli_query($connect, $checkRowquery);
$pid = mysqli_num_rows($checkRow);
$pid = $pid + 1;

$checkNamequery = "SELECT * FROM allproj WHERE projname = '{$name}'";
mysqli_query($connect, $checkNamequery) or die('Error querying database.3');
$checkName = mysqli_query($connect, $checkNamequery);

//insert query into active proj
$insertProj = "INSERT INTO activeproj(projid, projname, description, startDate, endDate, completeDate, minGoal, maxGoal, totalFund, tag)
VALUES('{$pid}', '{$name}', '{$body}', '{$dtime}', '{$endDate}', '{$completeDate}', '{$minG}', '{$maxG}', '0', '{$tag}')";
//insert query into owner table
$insertOwn = "INSERT INTO own(uid, projid)
VALUES('{$_SESSION["loginUsername"]}', '{$pid}')";

if (mysqli_num_rows($checkName) == 1)
{
	$_SESSION["createMsg"] = "Please choose a unique name for your project.";
	header("Location: createProjPage.php");
}
else
{
	if (mysqli_query($connect, $insertProj)){
		mysqli_query($connect, $insertOwn) or die('Error querying database.2');
		$_SESSION["projname"] = $name;
		$_SESSION["projid"] = $pid;
		if ($uploadOk !=0)
		{
			$insertMedia = "UPDATE activeproj SET file = '{$target_file}' 
			WHERE projid = '{$_SESSION["projid"]}'";
			mysqli_query($connect, $insertMedia) or die(mysqli_error($connect));
		}
	}
	else { 
		echo "Error: " . $sql . "<br>" . mysqli_error($connect); 
	}
	header("Location: projPage.php");
}
mysqli_close($connect);
?>