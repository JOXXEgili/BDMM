<?php session_start(); 

if(isset($_POST["Nivel"])){

    $_SESSION['Niveles'] = $_POST["Nivel"];
    echo 'Listo';

}
else{
    header('HTTP/1.1 409 No data sent');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ERROR: No data sent', 'code' => 1337)));
}
?>