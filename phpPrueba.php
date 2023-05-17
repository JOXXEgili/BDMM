
<?php

include_once "rest/conexion.php";
///require "testing.php";

$response = array();

$maxsize =  10485760; // 10MB
        echo 'hola';
        $target_file = '';
        if(isset($_FILES['vids']['name']) && $_FILES['vids']['name'] != ''){
            $name = $_FILES['vids']['name'];
            $target_dir = "videos/";
            $target_file = $target_dir . $_FILES["vids"]["name"];

            // Select file type
            $extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Valid file extensions
            $extensions_arr = array("mp4","avi","3gp","mov","mpeg");

            // Check extension
            if( in_array($extension,$extensions_arr) ){
        
                // Check file size
                echo $_FILES['vids']['size'];
                if(($_FILES['vids']['size'] >= $maxsize) || ($_FILES["vids"]["size"] == 0)) {
                    echo "File too large. File must be less than 5MB.";
                    $check = false;
                }else{
                    // Upload
                    if(move_uploaded_file($_FILES['vids']['tmp_name'],$target_file)){

                        echo $target_file;
                    // Insert record
                    $_SESSION['message'] = "Upload successfully.";
                    }
                    else{
                        echo 'no se guardó el video';
                    }
                }

            }else{
                echo "Invalid file extension.";
                $check = false;
            }
        }
        else{
            echo 'q pasa';
        }

echo json_encode($response);

?>