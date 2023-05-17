<?php
session_set_cookie_params(0);
session_start();
include_once "conexion.php";

$response = array();

if(isset($_POST["name"])){

    $name = $_POST["name"];
    $FLastName = $_POST["FLastName"];
    $MLastName = $_POST["MLastName"];
    $birth = $_POST["birth"];
    $gender = $_POST["gender"];
    $pass = $_POST["pass"];
    $user = $_SESSION['email'];
    
    if($_SESSION['type'] == 'Profesor'){

        if($_POST["logo2"] == 'nada'){
            $insert = $conn->query("UPDATE profesores SET Nombre = '$name', ApellidoP = '$FLastName', ApellidoM = '$MLastName', contraseña = '$pass', Genero = '$gender', Birthday = '$birth' WHERE email = '$user'"); 
        }
        else{

            if(!empty($_FILES["file"]["name"])) { 
                // Get file info 
                $fileName = basename($_FILES["file"]["name"]); 
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                
                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg','gif', 'PNG'); 
                if(in_array($fileType, $allowTypes)){ 
                    $image = $_FILES['file']['tmp_name']; 
                    $imgContent = addslashes(file_get_contents($image)); 
                
                    $insert = $conn->query("UPDATE profesores SET Nombre = '$name', ApellidoP = '$FLastName', ApellidoM = '$MLastName', contraseña = '$pass', Genero = '$gender', Birthday = '$birth', FotoP = '$imgContent' WHERE email = '$user'"); 
                    
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
        
    }
    else{
        echo $_POST["logo2"];
        if($_POST["logo2"] == 'nada'){
            $insert = $conn->query("UPDATE estudiantes SET Nombre = '$name', ApellidoP = '$FLastName', ApellidoM = '$MLastName', contraseña = '$pass', Genero = '$gender', Birthday = '$birth' WHERE email = '$user'"); 
        }
        else{

            if(!empty($_FILES["file"]["name"])) { 
                // Get file info 
                $fileName = basename($_FILES["file"]["name"]); 
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                
                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg','gif', 'PNG'); 
                if(in_array($fileType, $allowTypes)){ 
                    $image = $_FILES['file']['tmp_name']; 
                    $imgContent = addslashes(file_get_contents($image)); 
                
                    $insert = $conn->query("UPDATE estudiantes SET Nombre = '$name', ApellidoP = '$FLastName', ApellidoM = '$MLastName', contraseña = '$pass', Genero = '$gender', Birthday = '$birth', FotoP = '$imgContent' WHERE email = '$user'"); 
                    
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
    }
    

}
else{
    header('HTTP/1.1 409 No data sent');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ERROR: No data sent', 'code' => 1337)));
}



?>