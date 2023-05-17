<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <th>id</th>
            <th>imagen</th>
        </tr>
        <?php

            $user = $_SESSION['email'];
            include('rest/conexion.php');
            if($_SESSION['type'] == 'Estudiante'){
                $query = "SELECT FotoP FROM estudiantes WHERE email = '$user'";
            }
            else{
                //$query = "SELECT FotoP FROM profesores WHERE email = '$user'"
                $query = "SELECT pdf FROM contenido_cursos WHERE ID_contenido = 1";
            }
            $query = "SELECT pdf FROM contenido_cursos WHERE ID_contenido = 1";
            $resultado = $conn->query($query);
            while($data = $resultado->fetch(PDO::FETCH_ASSOC)){ 
            ?>
            <!--img src="data:image/jpg;base64, <?php //echo base64_encode($data['Miniatura']) ?>"-->
            <a download="PDF Title" href="data:application/pdf;base64, <?php echo base64_encode($data['pdf']) ?>">Download PDF document</a>
            <?php 
            }
        ?>
    </table>
</body>
</html>