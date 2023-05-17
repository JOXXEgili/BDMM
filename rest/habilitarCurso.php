<?php
session_set_cookie_params(0);
session_start();
include_once "conexion.php";

$response = array();

if(isset($_POST["type"])){

    if($_POST["type"] == 'Deshabilitar'){
        $id = $_POST["id"];
        $insert2 = $conn->query("UPDATE cursos SET Estado = 0 WHERE ID_curso = $id"); 
    }
    else{
        $id = $_POST["id"];
        $insert2 = $conn->query("UPDATE cursos SET Estado = 1 WHERE ID_curso = $id"); 
    }
}
else{
    header('HTTP/1.1 409 No data sent');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ERROR: No data sent', 'code' => 1337)));
}

//echo json_encode($response);

?>