<?php

include_once "rest/conexion.php";
///require "testing.php";

$response = array();/*
if(isset($_POST['user_id'])){
    $img = addslashes(file_get_contents($_FILES["file"]['tmp_name']));
    //$img = addslashes(file_get_contents('C:\\xampp\\tmp\\why.tmp'));
    //$response['message'] = $img;

    $sql = "INSERT INTO fotos(img) VALUES(:P_img)";
    //$sql = "INSERT INTO tabla1(nombre, correo, contra) VALUES('$nombre', '$correo', '$contra')";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":P_img",$img);
    $stmt->execute();

}*/

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
            $insert = $conn->query("INSERT into fotos (img) VALUES ('$imgContent')"); 
             
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

/*
if(isset($_FILES['file'])){
    //$response['error'] = false;
    $name = $_FILES['file']['name'];
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){
         // Upload file
         if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){
               // Convert to base64 
               $image_base64 = base64_encode(file_get_contents('upload/'.$name) );
               $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
               $response['message'] = $image;
         }
         else{
            $response['message'] = 'nada2';
         }
    }
    else{
        $response['message'] = 'nada';
    }
    
}
else{
    //$response['error'] = true;
    $response['message'] = 'Sin imagen';
}
/*
if(isset($_POST['image'])){
    $response['message'] = 'Imagen cargada erroneamente';
}
else{
    $response['message'] = $_POST['image'];
}*/

echo json_encode($response);

?>