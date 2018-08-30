<?php //setupusers3.php

  // Create connection to SQL server
  require_once 'login.php';
  $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
  if ($connection->connect_error) die($connection->connect_error);

  // Part of encryption
  $salt1    = "!0lxp/?";
  $salt2    = "+z@~";
  
  // Check if users3 table exists
  $query = "SELECT 1 FROM users3 LIMIT 1";
  $exists = $connection->query($query);

  // If the table does not exist, create the table  
  if($exists == FALSE)
  {
	$query = "CREATE TABLE users3 (
    userid VARCHAR(32) NOT NULL,
    password VARCHAR(64) NOT NULL,
	role VARCHAR(32) NOT NULL,
	CONSTRAINT check_role CHECK(role IN ('student', 'administrator'))
  )";
  $result = $connection->query($query);
  if (!$result) die($connection->error);
  }
  
  // Check if admin accounts exist
  $query = "SELECT * FROM users3 WHERE role='administrator' LIMIT 1";
  $result = $connection->query($query);
  
  // If no admin login accounts exist, create the default
  if($result->num_rows == 0)
  {
	  echo "No admin accounts exist<br>   Creating default admin<br>";
	  $user = "admin";
	  $type = "administrator";
	  $token = hash('ripemd160', "$salt1$user$salt2");
	  add_login($user, $token, $type);
  }
  else
  {
	  echo "Admin accounts exist<br>";
  }
  
  
  // Check if the student table exists
  $query = "SELECT 1 FROM student LIMIT 1";
  $exists = $connection->query($query);
 
  // If it exists, check what students do not have a login 
  if($exists !== FALSE)
  {
	  // Left Join between student and users3 table 
	  // seeking students without a login
	  $query = "SELECT s.userid AS username 
				FROM student s 
				LEFT JOIN users3 u 
				ON s.userid = u.userid 
				WHERE u.userid is NULL";
	  $result = $connection->query($query);
	  if (!$result) die($connection->error);
	  
	  // If results found, create default login for those accounts
	  if ($result->num_rows > 0) 
	  {
		$type	  = "student";
		  
		echo "New student users without login accounts:<br>";
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
		{
			$user = $row["username"];
			echo $user . "<br>";
			echo "   Creating account with default login...<br>";
			
			$token = hash('ripemd160', "$salt1$user$salt2");
			add_login($user, $token, $type);
		}
	  } 
	  // Otherwise, accounts are up-to-date
	  else 
	  {
		echo "All students in the system have corresponding login accounts!<br>";
	  }
  }
  else
  {
	  echo "Cannot locate student table!!<br>";
  }
  
  // Function for creating new user logins on users3 table
  function add_login($user, $password, $type)
  {
	global $connection;
	$query = "INSERT INTO users3 VALUES('$user', '$password', '$type')";
	$insert = $connection->query($query);
	if (!$insert) die($connection->error);
  }
  
?>