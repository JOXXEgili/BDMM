<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdm2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
else
{
  echo "Connected successfully";
}


$sql = "INSERT INTO tabla1 (firstname, lastname, email)
VALUES ('Juan', 'Perez', 'juanito@perez.com')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}



$conn->close();
?>