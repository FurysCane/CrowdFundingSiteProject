<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	called when the rating buttom is clicked in the project page
	and sends the rating to the rate.php file for processing

	05/07/2017 original
	-->
<!DOCTYPE html>

<html>
<head>
  <title>Rate this project</title>
</head>
<body>
<h1> Rate this project </h1>
<form method="POST" action="rate.php">
	<table>
	<tr>
		<td>Rate this project out of 5:</td>
		<td><input type="text" size="10" name="rating"></td>
	</tr>
	</table>
<p><input type="submit" value="Rate"></p>
</form>
</body>
</html>
