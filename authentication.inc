
<?php

function authenticateUser($connect, $username, $password)
{
  // Test the username and password parameters
  if (!isset($username) || !isset($password))
    return false;

  // Create a digest of the password collected from
  // the challenge
  // $password_digest = md5(trim($password));

  // Formulate the SQL find the user
  $query = "SELECT upass FROM users WHERE uid = '{$username}' AND upass = '{$password}'";
  $result = mysqli_query($connect, $query);
  if (!$result)
    mysqli_error();

  // exactly one row? then we have found the user
  if (mysqli_num_rows($result) != 1)
    return false;
  else
    return true;
}



?>
