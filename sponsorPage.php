<!-- Write your comments here
	Frances Yu
	fay216/N15493821
	CS6083 Principles of Database Systems
	Final Project
	called from the projPage when the sponsor button is clicked
	takes the dollar amount a user wants to pledge to a project and sends it 
	to the sponsor.php for processing

	05/07/2017 original

	-->
<!DOCTYPE html>

<html>
<head>
  <title>Sponsor this project</title>
</head>
<body>
<h1> Sponsor this project </h1>
<form method="POST" action="sponsor.php">
	<table>
	<tr>
		<td>Sponsor Amount: (must be in whole dollars)</td>
		<td><input type="text" size="10" name="pledge"></td>
	</tr>
	</table>
<p><input type="submit" value="pledge">
</form>
</body>
</html>