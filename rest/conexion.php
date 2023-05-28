<?php


  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "bdm2";


  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
  
  
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

  // Database configuration  
  /*$dbHost     = "localhost";  
  $dbUsername = "root";  
  $dbPassword = "";  
  $dbName     = "prueba";  
    
  // Create database connection  
  $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);  
    
  // Check connection  
  if ($db->connect_error) {  
      die("Connection failed: " . $db->connect_error);  
  }*/
?>