<?php // authenticate3.php

  // Create connection to SQL server
  require_once 'login.php';
  $auth_connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
  if ($auth_connection->connect_error) die($auth_connection->connect_error);

  // Check User Credentials
  if (isset($_SERVER['PHP_AUTH_USER']) &&
      isset($_SERVER['PHP_AUTH_PW']))
  {
    $un_temp = mysql_entities_fix_string($auth_connection, $_SERVER['PHP_AUTH_USER']);
    $pw_temp = mysql_entities_fix_string($auth_connection, $_SERVER['PHP_AUTH_PW']);

	// Get user id
    $query  = "SELECT * FROM users3 WHERE userid='$un_temp'";
    $result = $auth_connection->query($query);
    if (!$result) die($auth_connection->error);
	
	// If user id exists
    elseif ($result->num_rows)
    {
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$result->close();

		// Make encrypted token based on user password given
		$salt1    = "!0lxp/?";
        $salt2    = "+z@~";
        $token = hash('ripemd160', "$salt1$pw_temp$salt2");

		// Check if created token matches the token saved in the database
        if ($token == $row['password'])
		{
			$userid = $row['userid'];
			$type = $row['role'];
			
			// Check the account-type and re-direct accordingly
			switch($type){
				case 'student':
				    echo "Welcome, $userid!<br>You are now logged in<br>";
					break;
				case 'administrator':
					include_once("./student.php");
					break;
				default:
					die("Interal error: Role not defined<br>");
			}
        }
		else die("Invalid username/password combination");
    }
    else die("Invalid username/password combination");
  }
  else
  {
    header('WWW-Authenticate: Basic realm="Restricted Section"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Please enter your username and password");
  }

  // Close the connection
  $auth_connection->close();

  // Functions for fixing extra slashes in strings
  
  function mysql_entities_fix_string($auth_connection, $string)
  {
    return htmlentities(mysql_fix_string($auth_connection, $string));
  }	

  function mysql_fix_string($auth_connection, $string)
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $auth_connection->real_escape_string($string);
  }
?>