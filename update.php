<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	called from updatePage.php to insert tuples into the update table
	of the database
	

	05/07/2017 original
	05/09/2017 media functionality taken from 
	https://www.w3schools.com/php/php_file_upload.asp
-->
<?php
session_start();
$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");

date_default_timezone_set("America/New_York");
$dtime = date('Y-m-d H:i:s ', time());

$title = mysqli_real_escape_string($connect, $_POST['title']);
$ubody = mysqli_real_escape_string($connect, $_POST['ubody']);

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
} else {
    if (move_uploaded_file($_FILES["media"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["media"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file." . "<br>";
		echo $_FILES['media']['error'];
		$uploadOk == 0;
    }
}
}
//$sql="INSERT INTO tbl_uploads(file,type,size) VALUES('$file','$file_type','$file_size')";
// mysql_query($sql); 
//$insert = "INSERT INTO updates(projid, postTime, title, ubody, file, filetype, filesize)
//VALUES('{$_SESSION["projid"]}', '{$dtime}', '{$title}', '{$ubody}', '{$target_file}', '{$file_type}', '{$file_size}')";
$insert = "INSERT INTO updates(projid, postTime, title, ubody)
VALUES('{$_SESSION["projid"]}', '{$dtime}', '{$title}', '{$ubody}')";

mysqli_query($connect, $insert) or die(mysqli_error($connect));
if ($uploadOk !=0)
{
	$insertMedia = "UPDATE updates SET file = '{$target_file}' 
	WHERE projid = '{$_SESSION["projid"]}' and postTime = '{$dtime}'";
	mysqli_query($connect, $insertMedia) or die(mysqli_error($connect));
}
header("Location: projPage.php");
mysqli_close($connect);
?>