<?php
session_set_cookie_params(0);
session_start();
include_once "../conexion.php";
require "../testing.php";

$response = array();

$_SESSION['email'] = 'misa2_09raya2@hotmail.com';

$user = $_SESSION['email'];

if($_POST['action'] == '1'){
    
    // Obtener los mensajes anteriores
    $remitente = $_POST['remitente'];
    if($_SESSION['type'] == 'Estudiante'){
        $sql = "SELECT ID_chat FROM inbox WHERE Estudiante = '$user' AND Profesor = '$remitente'";
    }
    else{
        $sql = "SELECT ID_chat FROM inbox WHERE Estudiante = '$remitente' AND Profesor = '$user'";
    }
    
    $result = $conn->query($sql);

    $idChat = '';
    while($data = $result->fetch(PDO::FETCH_ASSOC)){
        $idChat = $data['ID_chat'];

    }

    $sql = "SELECT ID_chat, Estudiante, Profesor, Contenido FROM mensaje WHERE ID_chat = $idChat ORDER BY ID_chat ASC";
    $result = $conn->query($sql);
    while($data = $result->fetch(PDO::FETCH_ASSOC)){

        $msg = $data['Contenido'];

        if($data['Estudiante'] == null){
            if($_SESSION['type'] == 'Profesor'){
                echo "<h5 id = 'right'>" . $msg ."</h5>";
            }
            else{
                echo "<h5 id = 'left'>" . $msg ."</h5>";
            }
            
        }
        else{
            if($_SESSION['type'] == 'Profesor'){
                echo "<h5 id = 'left'>" . $msg ."</h5>";
            }
            else{
                echo "<h5 id = 'right'>" . $msg ."</h5>";
            }
        }
    }

}
else if($_POST['action'] == '2'){//para enviar mensajes
    $msg = $_POST['msg'];
    $remitente = $_POST['remitente'];
    //$_SESSION['type'] = 'Estudiante';
    //PRIMERO SE MIRA SI YA ESTÁ REGISTRADO UN INBOX CON ESTOS USUARIOS, DE NO SER ASÍ SE CREA AQUÍ MISMO
    if($_SESSION['type'] == 'Estudiante'){
        //$query = "SELECT ID_chat FROM 'inbox' WHERE Estudiante = '$user' AND Profesor = '$remitente'";
        $sql = "SELECT count(ID_CHAT) FROM inbox WHERE Estudiante = '$user' AND Profesor = '$remitente'";
        $result = $conn->query($sql);

        $num = $result->fetchColumn();

        if($num == 0){                     
            $sql = "INSERT INTO inbox(Estudiante, Profesor) VALUES(:P_estudiante, :P_profesor)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":P_estudiante",$user);
            $stmt->bindParam(":P_profesor",$remitente);

            $stmt->execute();
        }
    }
    else{
        //$query = "SELECT ID_chat FROM 'inbox' WHERE Estudiante = '$remitente' AND Profesor = '$user'";
        $sql = "SELECT count(ID_CHAT) FROM inbox WHERE Estudiante = '$remitente' AND Profesor = '$user'";
        $result = $conn->query($sql);

        $num = $result->fetchColumn();

        if($num == 0){                     
            $sql = "INSERT INTO inbox(Estudiante, Profesor) VALUES(:P_estudiante, :P_profesor)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":P_estudiante",$remitente);
            $stmt->bindParam(":P_profesor",$user);

            $stmt->execute();
        }
    }
    //AQUÍ EMPIEZA EL PROCESO DE ENVÍO DE MENSAJES
    if($_SESSION['type'] == 'Estudiante'){

        $chat = '';

        $query = "SELECT ID_chat FROM inbox WHERE Estudiante = '$user' AND Profesor = '$remitente'";
        $resultado = $conn->query($query);
        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
            $chat = $data['ID_chat'];
        }

        $date = date("Y/m/d");

        $sql = "INSERT INTO mensaje(Contenido, Fecha, ID_chat, Estudiante) VALUES(:P_contenido, :P_fecha, :P_chat, :P_estudiante)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":P_contenido",$msg);
        $stmt->bindParam(":P_fecha", $date);
        $stmt->bindParam(":P_chat", $chat);
        $stmt->bindParam(":P_estudiante", $user);

        $stmt->execute();
    }
    else{
        $chat = '';

        $query = "SELECT ID_chat FROM inbox WHERE Estudiante = '$remitente' AND Profesor = '$user'";
        $resultado = $conn->query($query);
        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
            $chat = $data['ID_chat'];
        }

        $sql = "INSERT INTO mensaje(Contenido, Fecha, ID_chat, Profesor) VALUES(:P_contenido, :P_fecha, :P_chat, :P_profesor)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":P_contenido",$msg);
        $stmt->bindParam(":P_fecha", date("Y/m/d"));
        $stmt->bindParam(":P_chat", $chat);
        $stmt->bindParam(":P_profesor", $user);

        $stmt->execute();
    }
}
else if($_POST['action'] == '3'){ // para cargar los inbox
      //$sql = "SELECT * FROM inbox WHERE Estudiante = $user";
      //$remitente = $_POST['remitente'];

      if( $_SESSION['type'] == 'Estudiante'){
        $sql = "SELECT count(ID_CHAT) FROM inbox WHERE Estudiante = '$user'";
      }
      else{
        $sql = "SELECT count(ID_CHAT) FROM inbox WHERE Profesor = '$user'";
      }
      $result = $conn->query($sql);
  
      $num = $result->fetchColumn();
  
      if($num == 0){       
             //verificamos si nuestro usuario es profesor o estudiante
          $_SESSION['type'] = 'Estudiante';
      }
      else{

          $_SESSION['type'] = 'Profesor';
      }
      
      $logo = '';
      $name = '';
  
      $type = $_SESSION['type'];
  
      if($_SESSION['type'] == 'Profesor'){
  
          $query = "SELECT Estudiante FROM inbox WHERE $type = '$user'";
          $resultado = $conn->query($query);

          while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

            $emailRemitente = $data['Estudiante'];
            
            $query = "SELECT FotoP FROM estudiantes WHERE email = '$emailRemitente'";
            $resultado = $conn->query($query);
            while($data2 = $resultado->fetch(PDO::FETCH_ASSOC)){ 
                $logo = base64_encode($data2['FotoP']);
            }
          
            $b64 = "data:image/jpg;base64, " . $logo;
  
            $nombre = '';

            if($_SESSION['type'] == 'Profesor'){

                $query = "SELECT Nombre, ApellidoP, ApellidoM FROM estudiantes WHERE email = '$emailRemitente'";
            }
            else{
                $query = "SELECT Nombre, ApellidoP, ApellidoM FROM profesores WHERE email = '$emailRemitente'";
            }
            $result = $conn->query($query);
            while($data = $result->fetch(PDO::FETCH_ASSOC)){
                $nombre = $data['Nombre'] . ' ' . $data['ApellidoP'] . ' ' . $data['ApellidoM'];
            }

              echo "<div id ='$emailRemitente' class='inbox-container' onclick='getDataInbox(event, this.id)'><img src='$b64'><h3>$nombre</h3></div>";
          }
      }
      else{
          $query = "SELECT Profesor FROM inbox WHERE $type = '$user'";
          $resultado = $conn->query($query);
          while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

            $emailRemitente = $data['Profesor'];
  
            $query = "SELECT FotoP FROM profesores WHERE email = '$emailRemitente'";
            $resultado = $conn->query($query);
            while($data2 = $resultado->fetch(PDO::FETCH_ASSOC)){ 
                $logo = base64_encode($data2['FotoP']);
            }
          
            $b64 = "data:image/jpg;base64, " . $logo;
  
            //$nombre = getName($data['Profesor']);
            $nombre = '';

            if($_SESSION['type'] == 'Profesor'){
                $query = "SELECT Nombre, ApellidoP, ApellidoM FROM estudiantes WHERE email = '$emailRemitente'";
            }
            else{
                $query = "SELECT Nombre, ApellidoP, ApellidoM FROM profesores WHERE email = '$emailRemitente'";
            }
            $result = $conn->query($query);
            while($data = $result->fetch(PDO::FETCH_ASSOC)){
                $nombre = $data['Nombre'] . ' ' . $data['ApellidoP'] . ' ' . $data['ApellidoM'];
            }

            /*$response['message'] =*/echo "<div id ='$emailRemitente' class='inbox-container' onclick='getDataInbox(event, this.id)'><img src='$b64'><h3>$nombre</h3></div>";
          }
      }
      //echo json_encode($response);
}


function loadInbox(){

    //$sql = "SELECT * FROM inbox WHERE Estudiante = $user";
    $sql = "SELECT count(ID_CHAT) FROM inbox WHERE Estudiante = '$remitente' AND Profesor = '$user'";
    $result = $conn->query($sql);

    $num = $result->fetchColumn();

    if($num != 0){                     //verificamos si nuestro usuario es profesor o estudiante
        $_SESSION['type'] = 'Estudiante';
    }
    else{
        $_SESSION['type'] = 'Profesor';
    }

    $logo = '';
    $name = '';

    $type = $_SESSION['type'];

    if($_SESSION['type'] == 'Profesor'){

        $query = "SELECT Estudiante FROM 'inbox' WHERE '$type' = '$user'";
        $resultado = $conn->query($query);

        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

            $emailRemitente = $data['Estudiante'];

            $query = "SELECT FotoP FROM estudiantes WHERE email = '$emailRemitente'";
            $resultado = $conn->query($query);
            while($data2 = $resultado->fetch(PDO::FETCH_ASSOC)){ 
                $logo = base64_encode($data2['FotoP']);
            }
        
            $b64 = "data:image/jpg;base64, " . $logo;

            $nombre = getName($data['Estudiante']);
            $response['message'] = "<div class='inbox-container'><img src='$b64'><h3>'$nombre'</h3></div>";
        }
    }
    else{
        $query = "SELECT Profesor FROM 'inbox' WHERE '$type' = '$user'";
        $resultado = $conn->query($query);
        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

            $emailRemitente = $data['Profesor'];

            $query = "SELECT FotoP FROM profesores WHERE email = '$emailRemitente'";
            $resultado = $conn->query($query);
            while($data2 = $resultado->fetch(PDO::FETCH_ASSOC)){ 
                $logo = base64_encode($data2['FotoP']);
            }
        
            $b64 = "data:image/jpg;base64, " . $logo;

            $nombre = getName($data['Profesor']);
            $response['message'] = "<div class='inbox-container'><img src='$b64'><h3>'$nombre'</h3></div>";
        }
    }

}

function getName(){
    include_once "../conexion.php";
    $name = '';
    $query = '';
    $user = $_SESSION['email'];
    if($_SESSION['type'] == 'Profesor'){
        $query = "SELECT Nombre, ApellidoP, ApellidoM FROM estudiantes WHERE email = '$user'";
    }
    else{
        echo 'debe entrar aki';
        $query = "SELECT Nombre, ApellidoP, ApellidoM FROM profesores WHERE email = '$user'";
    }

    $result = $conn->query($query);
    while($data = $result->fetch(PDO::FETCH_ASSOC)){
        $name = $data['Nombre'] . ' ' . $data['ApellidoP'] . ' ' . $data['ApellidoM'];
    }

    return $name;
}

?>