<?php
session_set_cookie_params(0);
session_start();
include_once "conexion.php";

$response = array();

if(isset($_POST["titulo"])){

    

    //$miniatura = $_POST["miniatura"];
    
    //$pdfs = $_POST["pdfs"];
    //$pdfs = json_decode(stripslashes($_POST['pdfs']));
    //$imgs = $_POST["imgs"];
    //$vids = $_POST["vids"];
    //$precioNivel =$_POST["precioNivel"];
    $today = date("Y/m/d");

    $email = $_SESSION['email'];

    if($_POST["action"] == '1'){

        $titulo = $_POST["titulo"];
        $desc = $_POST["desc"];
        $precioTotal = $_POST["precioTotal"];

        $sql = "SELECT obtainID();";
        $result = $conn->query($sql);

        $num = $result->fetchColumn();
        $id = $num + 1;

        //echo $miniatura . ' ';

        //echo  'HOLAP' . $_FILES["miniatura"]["name"];

        /*$sql = "INSERT INTO cursos(ID_curso, Nombre, Precio, Descrip, Miniatura, Estado, Puntuacion, Creacion, Autor) VALUES(:P_id, :P_titulo, :P_precioTotal, :P_desc, null, 1, null, :P_today, :P_email)";
        //$sql = "INSERT INTO tabla1(nombre, correo, contra) VALUES('$nombre', '$correo', '$contra')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":P_id",$id);
        $stmt->bindParam(":P_titulo",$titulo);
        $stmt->bindParam(":P_desc",$desc);
        $stmt->bindParam(":P_precioTotal",$precioTotal);
        //$stmt->bindParam(":P_miniatura",$imgContent);
        $stmt->bindParam(":P_today",$today);
        $stmt->bindParam(":P_email",$email);
        /*$stmt->bindParam(":P_insts",$insts);
        $stmt->bindParam(":P_pdfs",$pdfs);
        $stmt->bindParam(":P_imgs",$imgs);
        $stmt->bindParam(":P_vids",$vids);
        $stmt->bindParam(":P_precioNivel",$precioNivel);*/
        //$stmt->execute();

        if(!empty($_FILES["miniatura"]["name"])) { //CONVERTIR IMGS A BASE64
            // Get file info 
            $fileName = basename($_FILES["miniatura"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
            
            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif', 'PNG'); 
            echo $fileType;
            if(in_array($fileType, $allowTypes)){ 
                $image = $_FILES['miniatura']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
            
                //$insert = $conn->query("UPDATE cursos SET miniatura = '$imgContent' WHERE ID_curso = $id"); 
                $insert = $conn->query("INSERT INTO cursos(ID_curso, Nombre, Precio, Descrip, Miniatura, Estado, Puntuacion, Creacion, Autor) VALUES($id, '$titulo', '$precioTotal', '$desc', '$imgContent', 1, null, '$today', '$email')"); 
                
                //echo '<img src="data:image/jpg;base64, ' . base64_encode($imgContent) . '">';
            }else{ 
                echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload. para el curso en sí'; 
                $check = false;
            } 
        }else{ 
            echo 'Please select an image file to upload.'; 
            $check = false;
        }
    }

    if($_POST["action"] == '2'){

        $sql = "SELECT obtainID();";
        //$sql = "SELECT count(ID_curso) FROM cursos";
        $result = $conn->query($sql);

        $id = null;

        $num = $result->fetchColumn();
        $id = $num;

        $check = true;

        $pdfContent = '';
        $imgContent ='';
        $vidContent = '';
        $precioNivel =$_POST["precioNivel"];
        $insts = $_POST["insts"];
        $idContenido = $_POST["id"];
        $desc2 = $_POST["descripcion2"];
        $cat = $_POST["cat"];

        if(!empty($_FILES["pdfs"]["name"])) { //CONVERTIR PDFS A BASE64

            // Get file info 
            $fileName = basename($_FILES["pdfs"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
            
            // Allow certain file formats 
            $allowTypes = array('pdf'); 
            if(in_array($fileType, $allowTypes)){ 
                $pdf = $_FILES["pdfs"]['tmp_name']; 
                $pdfContent = addslashes(file_get_contents($pdf));

                //echo $idContenido . ' ' . $id . $insts;

                
            }else{ 
                echo 'Sorry, only PDF files are allowed to upload.'; 
                header('HTTP/1.1 409 No data sent');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'ERROR: No data sent', 'code' => 1337)));
            } 
        }else{ 
            //echo 'Please select an PDF file to upload.'; 
        } 

        if(!empty($_FILES["imgs"]["name"])) { //CONVERTIR IMGS A BASE64
            // Get file info 
            $fileName = basename($_FILES["imgs"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
            
            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif'); 
            if(in_array($fileType, $allowTypes)){ 
                $image = $_FILES['imgs']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
                

            }else{ 
                echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
            } 
        }else{ 
           // echo 'Please select an image file to upload.'; 
        }
        $maxsize =  52428800; // 50MB
                    
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
                    echo "File too large. File must be less than 50MB.";
                    $check = false;
                }else{
                    // Upload
                    if(move_uploaded_file($_FILES['vids']['tmp_name'],$target_file)){
                    // Insert record
                    $_SESSION['message'] = "Upload successfully.";
                    }
                }

            }else{
                echo "Invalid file extension.";
                $check = false;
            }
        }else{
            echo "Please select a file.";
            $check = false;
        }

        $idcat = '';
        $query = "SELECT ID_categoria, Nombre, Estado FROM categorias WHERE Nombre = '$cat'";
        $resultado = $conn->query($query);
        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
            $idcat = $data['ID_categoria'];
        }

        if($check){
            $insert = $conn->query("INSERT INTO contenido_cursos(ID_contenido, Contenido, Descrip, Estado, Miniatura, Precio, ID_curso, video ,pdf) VALUES($idContenido, '$insts', '$desc2', 1, '$imgContent', $precioNivel, $id, '$target_file', '$pdfContent')"); 

            $sql = "SELECT count(ID_curso_cat) FROM cursos_categorias WHERE ID_categoria = $idcat AND ID_curso = $id";
            $result = $conn->query($sql);
            $num = $result->fetchColumn();

            if($num == 0){
                $insert2 = $conn->query("INSERT INTO cursos_categorias(Estado, ID_categoria, ID_curso) VALUES(1, $idcat, $id)"); 
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