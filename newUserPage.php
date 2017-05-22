<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	called from login page for new users

	05/07/2017 original
-->
<!DOCTYPE html>
<html>
<head>
  <title>New User</title>
</head>
<body>
<h1>Create new Profile</h1>
<form method="POST" action="newUser.php">
	<table>
	<tr>
		<td>Email:</td>
		<td><input type="text" size="10" name="uid"></td>
	</tr>
	<tr>
		<td>Name:</td>
		<td><input type="text" size="10" name="name"></td>
	</tr>
	<tr>
		<td>City:</td>
		<td><input type="text" size="10" name="city"></td>
	</tr>
	<tr>
		<td>State:</td>
		<td><input type="text" size="10" name="state"></td>
	</tr>
	<tr>
		<td>Interests:</td>
		<td><input type="text" size="10" name="interests"></td>
	</tr>
	<tr>
		<td>Credit card:</td>
		<td><input type="text" size="10" name="creditCard"></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type="password" size="10" name="loginPassword"></td>
	</tr>
	</table>
	<p><input type="submit" value="Submit"></p>
	</form>
</body>

</html>