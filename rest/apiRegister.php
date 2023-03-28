<?php

include_once "conexion.php";
require "testing.php";

$response = array();/*
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $nombre = $_POST['nam'];
    $correo = $_POST['ema'];
    $contra = $_POST['pas'];
    $birth = $_POST['bir'];
    $logo = $_POST['log'];
    $gender = $_POST['gen'];
    //$response['regex'] = register($correo);
    if(register($correo, $nombre, $contra, $fLasName, $mLastName, $birth, $logo, $birth) == true){

        $input = $_POST;
        $sql = "INSERT INTO tabla1(nombre, correo, contra) VALUES(:nombre, :correo, :contra)";
        //$sql = "INSERT INTO tabla1(nombre, correo, contra) VALUES('$nombre', '$correo', '$contra')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":nombre",$nombre);
        $stmt->bindParam(":correo",$correo);
        $stmt->bindParam(":contra",$contra);
        //$stmt->execute();

        try{
            $stmt->execute();
            print("registrado");
            //htttp_response_code(201);
            header('HTTP/1.1 200 the request was successful');
            $response['error'] = false;
            $response['message'] = 'Usuario registrado exitosamente';
        }
        catch (Exception $e){
            header('HTTP/1.1 400 the request was not successful');
            $response['error'] = true;
            $response['message'] = $e->getMessage();
        }
    }
    else{
        $response['error'] = true;
        $response['message'] = "Asegurese de ingresar la info en el formato correcto"
    }
    echo json_encode($response);

}*/

$enter = false;

if(($_SERVER['REQUEST_METHOD'] == "POST") == 1){

    $nombre = $_POST['nam'];
    $apellidoP = $_POST['flast'];
    $apellidoM = $_POST['mlast'];
    $correo = $_POST['ema'];
    $contra = $_POST['pas'];
    $birth = $_POST['bir'];
    $logo = $_POST['log'];
    $gender = $_POST['gen'];
    //$pic = base64_encode(file_get_contents($_FILES['pic']['tmp_name']));

    //$logo = $_FILES['pic'];
    //$tmp_name = $logo['tmp_name'];


    //$pic = null;
    //echo $pic;
    //echo 'hola';
    //$response['error'] = false;
    //echo date("Y/m/d");
    //$response['regex'] = register($correo);
    if(register($correo, $nombre, $contra, $apellidoP, $apellidoM, $birth, $logo, $birth) == true){

        $today = date("Y/m/d");

        $input = $_POST;
        $sql = "CALL SP_GestionUsuarios('I', 'E', :P_email, :P_Nombre, :P_ApellidoP, :P_ApellidoM, :P_Contra, :P_Genero, :P_Birthday, :P_Registro, 1, null)";
        //$sql = "INSERT INTO tabla1(nombre, correo, contra) VALUES('$nombre', '$correo', '$contra')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":P_email",$correo);
        $stmt->bindParam(":P_Nombre",$nombre);
        $stmt->bindParam(":P_ApellidoP",$apellidoP);
        $stmt->bindParam(":P_ApellidoM",$apellidoM);
        $stmt->bindParam(":P_Contra",$contra);
        $stmt->bindParam(":P_Genero",$gender);
        $stmt->bindParam(":P_Birthday",$birth);
        $stmt->bindParam(":P_Registro",$today);
        //$stmt->bindParam(":P_FotoP",$image);
        //$stmt->execute();

        try{
            $stmt->execute();
            print("registrado");
            //htttp_response_code(201);
            header('HTTP/1.1 200 the request was successful');
            //$response['error'] = false;
            //$response['message'] = 'Usuario registrado exitosamente';
            $enter = true;


            
        }
        catch (Exception $e){
            header('HTTP/1.1 400 the request was not successful');
            $response['error'] = true;
            $response['message'] = $e->getMessage();
        }
    }
    else{
        $response['error'] = true;
        $response['message'] = "Asegurese de ingresar la info en el formato correcto";
    }
    //echo json_encode($response);

    if($enter){
        header('location: http://localhost/BDMM/phpPrueba.php', true, 307);
        die();
    }


}





?>