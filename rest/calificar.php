<?php
session_set_cookie_params(0);
session_start();
include_once "conexion.php";

$response = array();

if(isset($_POST["com"])){

    $comentario = $_POST["com"];
    $calif = $_POST["calif"];
    $curso = $_SESSION['curso'];
    $user = $_SESSION['email'];

    $insert = $conn->query("INSERT INTO comentarios(Contenido, Fecha, Estado, ID_curso, Autor) VALUES('$comentario', now(), 1, $curso, '$user')");

    $sql = "SELECT count(ID_review) FROM reviews";
    $result = $conn->query($sql);
    
    $num = $result->fetchColumn();

    $insert = $conn->query("UPDATE reviews SET Score = $calif WHERE ID_review = $num");

}
else{
    header('HTTP/1.1 409 No data sent');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ERROR: No data sent', 'code' => 1337)));
}

//echo json_encode($response);

?>