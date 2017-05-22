<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	Page to make edits on the logged in user's profile
	called when the edit profile button is clicked
	calls the makeChanges.php file to update the database

	05/06/2017 original
-->
<!DOCTYPE html>
<html>
<head>
  <title>Edit Profile</title>
</head>
<body>
<h1>Edit Profile</h1>
<form method="POST" action="makeChanges.php">
	<table>
	<tr>
		<td>Change your city:</td>
		<td><input type="text" size="10" name="city"></td>
	</tr>
	<tr>
		<td>Change your state:</td>
		<td><input type="text" size="10" name="state"></td>
	</tr>
	<tr>
		<td>Change your interests:</td>
		<td><input type="text" size="10" name="interests"></td>
	</tr>
	<tr>
		<td>Change your credit card:</td>
		<td><input type="text" size="10" name="creditCard"></td>
	</tr>
	<tr>
		<td>Change your password:</td>
		<td><input type="password" size="10" name="loginPassword"></td>
	</tr>
	</table>
	<p><input type="submit" value="Edit"></p>
	</form>
</body>

</html>