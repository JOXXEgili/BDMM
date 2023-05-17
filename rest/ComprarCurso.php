<?php
session_start();
include_once "conexion.php";

if(isset($_POST["nivel"])){

    $curso = $_SESSION['curso'];
    $email = $_SESSION['email'];

    if($_POST["Tipo"] == 'tarjeta' ){
        
        if($_POST["nivel"] == 0 || $_POST["nivel"] == '0'){

            $date = date("Y/m/d");

            $count = 0;

            $sql = "SELECT COUNT(ID_compra) FROM compras ";
            $result = $conn->query($sql);

            $idCompra = null;

            $num = $result->fetchColumn();
            $idCompra = $num + 1;

            $insert = $conn->query("INSERT INTO compras(ID_compra, Fecha, Cliente, TipoPago) VALUES($idCompra, '$date', '$email', 'T')"); 

            $sql = "SELECT ID_contenido, ID_curso FROM contenido_cursos WHERE ID_curso = $curso";
            $result = $conn->query($sql);
            while($data = $result->fetch(PDO::FETCH_ASSOC)){

                $idContenido = $data['ID_contenido'];

                $sql2 = "SELECT Precio FROM cursos WHERE ID_curso = $curso";
                $result2 = $conn->query($sql2);
                while($data2 = $result2->fetch(PDO::FETCH_ASSOC)){

                    $precio = $data2['Precio'];

                    if($count == 0){
                        $insert2 = $conn->query("INSERT INTO det_compras(ID_curso, ID_contenido, ID_compra, Precio) VALUES($curso, $idContenido, $idCompra, $precio)"); 
                        $count = $count + 1;
                    }
                    else{
                        $insert2 = $conn->query("INSERT INTO det_compras(ID_curso, ID_contenido, ID_compra, Precio) VALUES($curso, $idContenido, $idCompra, 0)"); 
                    }
                    $count = $count + 1;
                }
            } 
        }
        else{

            $lvl = $_POST["nivel"];
            $date = date("Y/m/d");

            $sql = "SELECT COUNT(ID_compra) FROM compras ";
            $result = $conn->query($sql);

            $idCompra = null;

            $num = $result->fetchColumn();
            $idCompra = $num + 1;

            $insert = $conn->query("INSERT INTO compras(ID_compra, Fecha, Cliente, TipoPago) VALUES($idCompra, '$date', '$email', 'T')"); 

            $sql2 = "SELECT Precio FROM contenido_cursos WHERE ID_curso = $curso AND ID_contenido = $lvl";
            $result2 = $conn->query($sql2);
            while($data2 = $result2->fetch(PDO::FETCH_ASSOC)){
                $precio = $data2['Precio'];

                $insert2 = $conn->query("INSERT INTO det_compras(ID_curso, ID_contenido, ID_compra, Precio) VALUES($curso, $lvl, $idCompra, $precio)"); 
            }
        }
    }
    else{
        $date = date("Y/m/d");

        $count = 0;

        $sql = "SELECT COUNT(ID_compra) FROM compras ";
        $result = $conn->query($sql);

        $idCompra = null;

        $num = $result->fetchColumn();
        $idCompra = $num + 1;

        $insert = $conn->query("INSERT INTO compras(ID_compra, Fecha, Cliente, TipoPago) VALUES($idCompra, '$date', '$email', 'P')"); 

        $sql = "SELECT ID_contenido, ID_curso FROM contenido_cursos WHERE ID_curso = $curso";
        $result = $conn->query($sql);
        while($data = $result->fetch(PDO::FETCH_ASSOC)){

            $idContenido = $data['ID_contenido'];

            $sql2 = "SELECT Precio FROM cursos WHERE ID_curso = $curso";
            $result2 = $conn->query($sql2);
            while($data2 = $result2->fetch(PDO::FETCH_ASSOC)){

                $precio = $data2['Precio'];

                if($count == 0){
                    $insert2 = $conn->query("INSERT INTO det_compras(ID_curso, ID_contenido, ID_compra, Precio) VALUES($curso, $idContenido, $idCompra, $precio)"); 
                    $count = $count + 1;
                }
                else{
                    $insert2 = $conn->query("INSERT INTO det_compras(ID_curso, ID_contenido, ID_compra, Precio) VALUES($curso, $idContenido, $idCompra, 0)"); 
                }
                $count = $count + 1;
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