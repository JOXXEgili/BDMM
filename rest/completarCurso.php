<?php 
session_start(); 

if(isset($_POST["Nivel"])){ 

    include('conexion.php');

    $nvl = $_POST["Nivel"];
    $user = $_SESSION['email'];
    $curso = $_SESSION['curso'];
    $today = date("Y/m/d");

    $query = "SELECT COUNT(Estudiante) FROM progreso_no_duplicado WHERE Estudiante = '$user' AND ID_contenido = $nvl AND ID_curso = $curso";
    $resultado = $conn->query($query);

    $num = $resultado->fetchColumn();

    if($num == 0){
        $insert = $conn->query("INSERT INTO progreso(Visto, Estudiante, ID_contenido, ID_curso, UltimoIngreso) VALUES(1, '$user', $nvl, $curso, '$today')"); 
    }
    else{

    }
    
    $query = "SELECT Estudiante, NvlsProgreso, ID_curso, NvlsCurso FROM Nvls_acabados WHERE Estudiante = '$user' AND ID_curso = $curso";
    $resultado = $conn->query($query);
    while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
        
        if($data['NvlsProgreso'] == $data['NvlsCurso']){
            echo 'Acabado';
        }
        else{
            echo 'No acabado';
        }
    }

}
else{
    header('HTTP/1.1 409 No data sent');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ERROR: No data sent', 'code' => 1337)));
}
?>