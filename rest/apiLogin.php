<?php
session_set_cookie_params(0);
session_start();
include_once "conexion.php";

$response = array();

if(isset($_POST["user"])){

    $email = $_POST["user"];
    $pass = $_POST["pass"];

    $sql = "SELECT count(email) FROM profesores WHERE email = '$email'";
    $result = $conn->query($sql);

    $num = $result->fetchColumn();// se obtiene el número de registros que devuelve para saber si encontró algo

    if($num == 0){
        
        $sql = "SELECT count(email) FROM estudiantes WHERE email = '$email'";
        $result = $conn->query($sql);

        $num = $result->fetchColumn(); // se obtiene el número de registros que devuelve para saber si encontró algo
        
        if($num != 0){
            $sql = "SELECT email, contraseña FROM estudiantes WHERE email = '$email' AND Estado = 1";
            $result = $conn->query($sql);
            while($data = $result->fetch(PDO::FETCH_ASSOC)){
                if($pass == $data['contraseña']){
                    
                    $_SESSION['type'] = 'Estudiante';
                    $_SESSION['email'] = $email;
                    $_SESSION['errores'] = 0;
                    echo 'bien';
                }
                else{

                    if($_SESSION['errores'] >= 2){
                        echo 'bloqueado';
                        $insert2 = $conn->query("UPDATE estudiantes SET Estado = 0 WHERE email = '$email'"); 
                        $_SESSION['errores'] = 0;
                    }
                    else{
                        $_SESSION['errores'] ++;
                        
                        echo'incorrectos';
                    }
                    
                }
            }
        }
        else{
            header('HTTP/1.1 409 User not found');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR: User not found', 'code' => 1337)));
        }
    }
    else{

        $sql = "SELECT email, contraseña FROM profesores WHERE email = '$email' AND Estado = 1";
        $result = $conn->query($sql);

        while($data = $result->fetch(PDO::FETCH_ASSOC)){

            if($pass == $data['contraseña']){
                $_SESSION['type'] = 'Profesor';
                $_SESSION['email'] = $email;
                echo 'bien';
                $_SESSION['errores'] = 0;   
            }
            else{
                if($_SESSION['errores'] >= 2){
                    echo 'bloqueado';
                    $insert2 = $conn->query("UPDATE estudiantes SET Estado = 0 WHERE email = '$email'"); 
                    $_SESSION['errores'] = 0;
                }
                else{
                    $_SESSION['errores'] ++;
                    echo'incorrectos';
                }
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