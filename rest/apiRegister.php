<?php
session_set_cookie_params(0);
session_start();
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
    $logo = $_FILES["file"]["name"];
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
        //$stmt->bindParam(":P_FotoP",$img);
        //$stmt->execute();

        try{
            $stmt->execute();
            
            // If file upload form is submitted 
            $status = $statusMsg = ''; 
            if(isset($_POST["user_id"])){ 
                $status = 'error'; 
                if(!empty($_FILES["file"]["name"])) { 
                    // Get file info 
                    $fileName = basename($_FILES["file"]["name"]); 
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                    
                    // Allow certain file formats 
                    $allowTypes = array('jpg','png','jpeg','gif'); 
                    if(in_array($fileType, $allowTypes)){ 
                        $image = $_FILES['file']['tmp_name']; 
                        $imgContent = addslashes(file_get_contents($image)); 
                    
                        // Insert image content into database 
                        $insert = $conn->query("UPDATE estudiantes SET FotoP = '$imgContent' WHERE email = '$correo'"); 
                        
                        if($insert){ 
                            $status = 'success'; 
                            $statusMsg = "File uploaded successfully."; 
                        }else{ 
                            $statusMsg = "File upload failed, please try again."; 
                        }  
                    }else{ 
                        $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
                    } 
                }else{ 
                    $statusMsg = 'Please select an image file to upload.'; 
                } 
            }


            $_SESSION['email'] = $correo;

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