<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	Start Page for a crowd funding website
	http://localhost:8080/fundme/loginPage.php

	04/27/2017 original from php examples given in class
	5/7/2017 added new user button
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                      "http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Login</title>
</head>
<body>
<h1>Fundme Login Page</h1>
<form method="POST" action="logincheck.php">
<table>
  <tr>
    <td>Enter your username:</td>
    <td><input type="text" size="10" name="loginUsername"></td>
  </tr>
  <tr>
    <td>Enter your password:</td>
    <td><input type="password" size="10" name="loginPassword"></td>
  </tr>
</table>
<p><input type="submit" value="Log in">
</form>
<button onclick = "newUser();">New User</button>
</body>
<script>
		function newUser()
        {
			 window.location.href='http://localhost:8080/fundme/newUserPage.php';
        }
</script>
</html>
