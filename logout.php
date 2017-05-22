<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	page can be called from most pages when the logout button is clicked
	it closes the session, destroys the session values, as well as 
	logging out the current user

	05/07/2017 original
	-->
<!DOCTYPE html>

<html>
<head>
  <title>Log out</title>
</head>
<body>
	<h1>Logout <button onclick = "login();">Login Page</button></h1>
<?php
	//require_once "HTML/Template/ITX.php";
	session_start();
	$connect = mysqli_connect("localhost:3306", "root", "", "fundme") or die ("Could Not Connect To MySql");

	$message = "";

	// An authenticated user has logged out -- be polite and thank them for
	// using your application.
	if (isset($_SESSION["loginUsername"]))
		$message .= "Thanks {$_SESSION["loginUsername"]} for
                 using the Application.";

	if (isset($_SESSION["message"]))
	{
		$message .= $_SESSION["message"];
		unset($_SESSION["message"]);
	}
	echo $message;
	
	// Destroy the session.  
	session_destroy();
	mysqli_close($connect);

?>
</body>
<script>
	function login()
	{
			window.location.href='http://localhost:8080/fundme/loginPage.php';
	}
</script>
</html>
