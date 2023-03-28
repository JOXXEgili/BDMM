<?php

//$nombre = $_POST['nam'];
//echo "hola " .$nombre;


//function connect(){

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "bdm";


  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
  
  
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

//}


/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "capaIntermediaMiercoles1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  echo "hola";
  die("Connection failed: " . $conn->connect_error);
  echo "hola";
}
else
{
  echo "Connected successfully";
}

/*
$sql = "INSERT INTO tabla1 (firstname, lastname, email)
VALUES ('Juan', 'Perez', 'juanito@perez.com')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

¨*/

//$conn->close();
?>