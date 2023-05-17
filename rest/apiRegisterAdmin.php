<?php
session_set_cookie_params(0);
session_start();
include_once "conexion.php";

$response = array();

if(isset($_POST["ema"])){

    if($_POST["ema"] == 'register'){
        $email = $_POST["ema"];
        $pass = $_POST["pas"];
        $mlast = $_POST["mlast"];
        $flast = $_POST["flast"];
        $nam = $_POST["nam"];

        $insert = $conn->query("INSERT INTO admin(email, contraseña, Nombre, ApellidoP, ApellidoM) VALUES('$email', '$pass', '$nam', '$flast', '$mlast')"); 
    }
    else{
        echo 'hola';
        $email = $_POST["ema"];
        $pass = $_POST["pass"];
        $sql = "SELECT email, contraseña FROM admin WHERE email = '$email'";
        $result = $conn->query($sql);
        while($data = $result->fetch(PDO::FETCH_ASSOC)){
            if($pass == $data['contraseña']){
                
                $_SESSION['type'] = 'Estudiante';
                $_SESSION['email'] = $email;
                echo $_SESSION['email'];
            }
            else{
                header('HTTP/1.1 409 No match in password and email');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'ERROR: No match in password and email', 'code' => 1337)));
            }
        }
    }

}
else{
    header('HTTP/1.1 409 No data sent');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ERROR: No data sent', 'code' => 1337)));
}

//echo json_encode($response);

?>