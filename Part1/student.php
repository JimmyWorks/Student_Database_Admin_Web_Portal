<?php // student.php

  // Use login.php to get login credentials
  require_once 'login.php';
  
  // Create the connection
  $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
  if ($connection->connect_error) die($connection->connect_error);

  // Delete Handler
  if (isset($_POST['delete']) && isset($_POST['ID']))
  {
    $ID   = get_post($connection, 'ID');
    $query  = "DELETE FROM student WHERE ID='$ID'";
    $result = $connection->query($query);
	
	// Report failure if action failed
  	if (!$result) echo "DELETE failed: $query<br>" .
      $connection->error . "<br><br>";
  }

  // Create Handler
  if (isset($_POST['Name'])   &&
	  isset($_POST['Major'])  &&
	  isset($_POST['Year'])   &&
      isset($_POST['userid']) &&
      isset($_POST['email']))
  {
	// Assign variables to user values
    $Name   = get_post($connection, 'Name');
    $userid = get_post($connection, 'userid');
    $Major  = get_post($connection, 'Major');
    $Year   = get_post($connection, 'Year');
    $email  = get_post($connection, 'email');
	
	// If the ID field was not empty, use the ID submitted
	if(!empty($_POST['ID']))
	{
		$ID		= get_post($connection, 'ID');
	}
	// Else, auto-increment the ID value by 1 from max ID in table
	else
	{
		// Get the max ID value in the database
		$query = "SELECT MAX(ID) as max FROM student";
		$result = $connection->query($query);
		if (!$result) echo "SELECT MAX(ID) failed: $query<br>" .
		  $connection->error . "<br><br>";
		  
		// New ID is the max value + 1
		if($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			$ID = $row['max'] + 1;
		}
	}
	
	// Insert new student into the database
    $query    = "INSERT INTO student VALUES" .
      "('$ID', '$Name', '$Major', '$Year', '$userid', '$email')";
    $result   = $connection->query($query);
	
	// Verify the insert was successful
  	if (!$result) echo "INSERT failed: $query<br>" .
      $connection->error . "<br><br>";
  }

  echo <<<_END
  
  <!-- 
  //Display the POST fields and CREATE button
  -->
  
  <form action="student.php" method="post">
	<pre>
     ID		<input type="number" name="ID">
     Name	<input type="text" name="Name">
     Net ID 	<input type="text" name="userid">
     Major	<input type="text" name="Major">
     Year	<input type="text" name="Year">
     Email	<input type="email" name="email">
     <input type="submit" value="ADD RECORD">
	</pre>
  </form>
_END;

  // Report all students in the database
  $query  = "SELECT * FROM student";
  $result = $connection->query($query);

  if (!$result) die ("Database access failed: " . $connection->error);

  $rows = $result->num_rows;
  
  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
	
  <!-- 
  Display each entry in the student table
  DO NOT display the ID field which is $row[0]
  -->
	
  <pre>
    Name 	$row[1]
    Net ID 	$row[4]
    Email	$row[5]
    Major 	$row[2]
    Year 	$row[3]

  </pre>
  
  <!--
  Add the DELETE button
  -->
  <form action="student.php" method="post">
  <input type="hidden" name="delete" value="yes">
  <input type="hidden" name="ID" value="$row[0]">
  <input type="submit" value="DELETE RECORD"></form>
_END;
  }
  
  // Close all connections
  $result->close();
  $connection->close();
  
  function get_post($connection, $var)
  {
    return $connection->real_escape_string($_POST[$var]);
  }
?>
