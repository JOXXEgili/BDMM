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
                include('rest/conexion.php');
                $query = "SELECT email, FotoP FROM estudiantes";
                $resultado = $conn->query($query);
                while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
                ?>
                <tr>
                    <td><?php echo $data['email'] ?></td>
                    <td><img height="50px" src="data:image/jpg;base64, <?php echo base64_encode($data['FotoP']) ?>"></td>
                </tr>
                <?php 
                }
                /*$resultado = $conn ->query($query);
                $result = mysqli_fetch_array($resultado);
                echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['img'] ).'"/>';*/
            ?>
    </table>
</body>
</html>