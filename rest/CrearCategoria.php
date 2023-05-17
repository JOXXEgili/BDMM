<?php
session_set_cookie_params(0);
session_start();
include_once "conexion.php";

$response = array();

if(isset($_POST["cat"])){

    $cat = $_POST["cat"];
    $catDesc = $_POST["catDesc"];
    $user = $_SESSION['email'];

    $check = true;
    $date = date("Y/m/d");

    $query = "SELECT ID_categoria, Nombre FROM categorias WHERE Nombre = '$cat'";
    $resultado = $conn->query($query);
    while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
        $check = false;
    }

    if($check){
        $insert = $conn->query("INSERT INTO categorias(Nombre, Descripcion, Creación, Estado, Autor) VALUES('$cat', '$catDesc', '$date', 1, '$user')");
    }
    else{
        header('HTTP/1.1 409 No data sent');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR: No data sent', 'code' => 1337)));
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