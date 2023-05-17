<?php
session_set_cookie_params(0);
session_start();
include_once "conexion.php";

$response = array();

if(isset($_POST["txt"])){

    if($_POST["type"] == 'categoria'){
        $_SESSION['busqueda1'] = null;
        $_SESSION['busqueda2'] = $_POST["txt"];
        $_SESSION['busqueda3'] = null;
        $_SESSION['busqueda4'] = null;
    }
    else if($_POST["type"] == 'fecha'){
        $_SESSION['busqueda1'] = null;
        $_SESSION['busqueda2'] = null;
        $_SESSION['busqueda3'] = $_POST["txt"];
        $_SESSION['busqueda4'] = $_POST["txt2"];
    }
    else{
        $_SESSION['busqueda1'] = $_POST["txt"];
        $_SESSION['busqueda2'] = null;
        $_SESSION['busqueda3'] = null;
        $_SESSION['busqueda4'] = null;
    }

    echo 'Listo';
}
else{
    header('HTTP/1.1 409 No data sent');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ERROR: No data sent', 'code' => 1337)));
}

//echo json_encode($response);

?>