<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/diploma.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Creación de curso</title>
</head>
<body>
<header>
            <div class="left-nav">
                <a href="index.php"><img id="logo" src="img/udemy-logo.png"></a>
                    
                <div class="dropdown-categories">
                    <button class="categories-button">Categorías</button>
                    <div class="dropdown-categories-content">
                        <il>
                        <?php
                        include('rest/conexion.php');

                        $query = "SELECT Nombre FROM categorias";
                        $resultado = $conn->query($query);
                        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
                            echo '<li><button id="' . $data['Nombre'] . '"onclick="searchCat()">' . $data['Nombre'] . '</button></li>';
                        }
                    ?>
                        <!--li><button>Programación web</button></li>
                        <li><button>Marketing</button></li>
                        <li><button>Diseño</button></li-->
                    </il>
                </div> 

            </div>
            
        </div>
        
        <div class="center-nav">
            <div class="search-box">
                <form>
                     <input id='buscar' type="text" placeholder="Buscar cualquier cosa">
                     <img src="img/lupa.png" onclick="search()">
                </form>
            </div>
            
            <div class="pickers">
                <input class='date' id='date1' type="date" data-date-format="YYYY-MM-DD"/>
                <input class='date' id='date2' type="date" data-date-format="YYYY-MM-DD"/>
                <img src="img/lupa.png" onclick="searchDate()">
            </div>
                
                
            </div>
            <div class="right-nav">
                <div class="perfil-image">
                    <?php

                        $user = $_SESSION['email'];
                        include('rest/conexion.php');
                        if($_SESSION['type'] == 'Estudiante'){
                            $query = "SELECT FotoP FROM estudiantes WHERE email = '$user'";
                        }
                        else{
                            $query = "SELECT FotoP FROM profesores WHERE email = '$user'";
                        }
                        
                        $resultado = $conn->query($query);
                        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){ 
                    ?>
                    <img src="data:image/jpg;base64, <?php echo base64_encode($data['FotoP']) ?>">
                    <?php 
                    }
                    ?>
                </div>
                <div class="dropdown-categories-content-profile">
                    <il>
                        <li><button onclick="location.href='Perfil.php'">Perfil</button></li>
                        <?php
                            if($_SESSION['type'] == 'Profesor'){
                                echo '<li><button onclick="location.href=' . "'crearCurso.php'" . '">Crear Curso</button></li>';
                            }
                            else{
                                echo '<li><button onclick="location.href=' . "'Kardex.php'" . '">Mis cursos</button></li>';
                            }
                        ?>
                        <li><button onclick="location.href='messages.php'">Mensajes</button></li>
                        <li><button onclick="logout()">Salir</button></li>
                    </il>
                </div>
            </div>
        </header>
        <div class="d-flex justify-content-center">
            <div id='categoria' class="d-flex justify-content-center">
            <div class="">
                <div class='d-flex justify-content-center'>
                <h1>¡FELICIDADES, HAZ COMPLETADO ESTE CURSO!</h1>
                </div>
                

                <?php 

                    $name = '';
                    $curso = $_SESSION['curso'];
                    $today = date("Y/m/d");

                    $query = "SELECT Nombre, ApellidoP, ApellidoM FROM estudiantes WHERE email = '$user'";
                    $resultado = $conn->query($query);
                    while($data = $resultado->fetch(PDO::FETCH_ASSOC)){ 
                        $name = $data['Nombre'] . ' ' . $data['ApellidoP'] . ' ' . $data['ApellidoM'];
                    }

                    $query = "SELECT Nombre FROM cursos WHERE ID_curso = $curso";
                    $resultado = $conn->query($query);
                    while($data = $resultado->fetch(PDO::FETCH_ASSOC)){ 
                        $cursoNombre = $data['Nombre'];
                    }

                    $query = "SELECT Nombre, ApellidoP, ApellidoM FROM nombre_profesor_id WHERE ID_curso = $curso";
                    $resultado = $conn->query($query);
                    while($data = $resultado->fetch(PDO::FETCH_ASSOC)){ 
                        $nameProfe = $data['Nombre'] . ' ' . $data['ApellidoP'] . ' ' . $data['ApellidoM'];
                    }

                    $rutaFuente = 'img/arial.ttf';
                    $Nombreimg = "img/diploma.png";
                    $img = imagecreatefrompng($Nombreimg);
                    $color = imagecolorallocate($img, 255, 255, 255);
                    $angulo = 0;
                    
                    $bbox = imagettfbbox(50, 0, $rutaFuente, $name);
                    $center1 = (imagesx($img) /2) - (($bbox[2] - $bbox[0]) / 2);
                    imagettftext($img, 50, $angulo, $center1, 800, $color, $rutaFuente, $name);

                    $bbox2 = imagettfbbox(25, 0, $rutaFuente, $today);
                    $center2 = (imagesx($img) /2) - (($bbox2[2] - $bbox2[0]) / 2);
                    imagettftext($img, 25, $angulo, $center2, 1000, $color, $rutaFuente, $today);

                    $bbox3 = imagettfbbox(40, 0, $rutaFuente, $cursoNombre);
                    $center3 = (imagesx($img) /2) - (($bbox3[2] - $bbox3[0]) / 2);
                    imagettftext($img, 40, $angulo, $center3, 900, $color, $rutaFuente, $cursoNombre);

                    $bbox4 = imagettfbbox(35, 0, $rutaFuente, $nameProfe);
                    $center4 = (imagesx($img) /2) - (($bbox4[2] - $bbox4[0]) / 2);
                    imagettftext($img, 35, $angulo, $center4, 1200, $color, $rutaFuente, $nameProfe);

                    ob_start();
                    imagepng($img);
                    $imgData=ob_get_clean();
                    imagedestroy($img);
                    //Echo the data inline in an img tag with the common src-attribute
                    echo '<img src="data:image/png;base64,'.base64_encode($imgData).'" width="1000px" height="707px"/>';

                    //echo '<img src="data:image/png;base64, imagepng($img)">'

                    //echo '<img src="'. imagepng($img) .'" alt="">';
                    echo "<div class='download d-flex justify-content-center'>
                    <a class='files' download href='data:image/png;base64, " . base64_encode($imgData) . "'>Descargar Diploma</a><br>
                    </div>";
                ?>
                </div>
                
            </div>
        </div>
        <main class="d-flex justify-content-center">
            <div class='lvls' id='respuesta'>
                <H2>CALIFICA ESTE CURSO Y DEJA UN COMENTARIO</H2>
                <div class='desc'>
                    <br>
                    <div>
                    <span>Elige entre 1 y 5 estrellas para el curso</span>
                    </div>
                    <div>
                    <select id = 'stars'name="numeros" id="cars">
                        <option value="1">1 Estrella</option>
                        <option value="2">2 Estrellas</option>
                        <option value="3">3 Estrellas</option>
                        <option value="4">4 Estrellas</option>
                        <option value="5">5 Estrellas</option>
                    </select>
                    </div>
                    <br>
                    <div>

                        <textarea type="text" placeholder='Comentario' id = 'comentario' class='descTxt'></textarea>
                    </div>
                   <div class='d-flex justify-content-center'>
                        <button class='agg' onclick='agregar()'>Publicar</button>
                   </div>
            
                </div>
            </div>
        </main>
</body>
<script>

    function search(){
            txt = document.getElementById("buscar").value;
            
            if(txt != '' && txt != null){
                var form_data = new FormData();                  // Creating object of FormData class
                form_data.append("txt", txt);            // Appending parameter named file with properties of file_field to form_data
                //form_data.append("msg", msg);
                //form_data.append("remitente", 'misa2_09raya2@hotmail.com');

                $.ajax({
                    url: "rest/buscar.php",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         // Setting the data attribute of ajax with file_data
                    type: 'post'
                })
                .done(function(res){
                    location.href = 'http://localhost/dashboard/BDMM/busqueda.php';
                })
                .fail(function(e){
                    console.log(e);
                })
                .always(function(){
                    console.log('complete');
                }) 
            }
        }

    function logout(){
            var form_data = new FormData();                  // Creating object of FormData class
            form_data.append("data", 'data');            // Appending parameter named file with properties of file_field to form_data
            //form_data.append("msg", msg);
            //form_data.append("remitente", 'misa2_09raya2@hotmail.com');

            $.ajax({
                url: "rest/logout.php",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         // Setting the data attribute of ajax with file_data
                type: 'post'
            })
            .done(function(res){
                alert('su sesión ha sido cerrada exitosamente');
                location.href = 'http://localhost/dashboard/BDMM/index.php';
            })
            .fail(function(e){
                console.log(e);
            })
            .always(function(){
                console.log('complete');
            }) 
    }

    function agregar(){
        calif = document.getElementById("stars").value;
        com = document.getElementById("comentario").value;

        if(calif != '' && com != ''){
            var form_data = new FormData();                  // Creating object of FormData class
            form_data.append("com", com);            // Appending parameter named file with properties of file_field to form_data
            form_data.append("calif", calif);  

            $.ajax({
                url: "rest/calificar.php",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         // Setting the data attribute of ajax with file_data
                type: 'post'
            })
            .done(function(res){
                alert('su comentario se ha publicado exitosamente');
                location.href = 'http://localhost/dashboard/BDMM/Kardex.php';
            })
            .fail(function(e){
                console.log(e);
            })
            .always(function(){
                console.log('complete');
            }) 
        }
        
    }

    function searchCat(){


document.addEventListener('click', (e) =>
{
// Retrieve id from clicked element
    elementId = e.target.id;
    // If element has id
    if (elementId !== '') {
        var form_data = new FormData();                  // Creating object of FormData class
        form_data.append("type", 'categoria');
        form_data.append("txt", elementId);

        $.ajax({
            url: "rest/buscar.php",
            dataType: 'script',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         // Setting the data attribute of ajax with file_data
            type: 'post'
        })
        .done(function(res){
            location.href = 'http://localhost/dashboard/BDMM/busqueda.php';
        })
        .fail(function(e){
            console.log(e);
        })
        .always(function(){
            console.log('complete');
        }) 
    }

})
}

function searchDate(){

const date1 = document.getElementById('date1');
const date2 = document.getElementById('date2');

if(!date1.value && !!date2.value){
    alert('Si se desea filtrar por fecha se debe de seleccionar una fecha para cada campo y el primer campo debe ser menor al segundo');
}
if(!!date1.value && !date2.value){
    alert('Si se desea filtrar por fecha se debe de seleccionar una fecha para cada campo y el primer campo debe ser menor al segundo');
}
if(!date1.value && !date2.value){
    alert('Si se desea filtrar por fecha se debe de seleccionar una fecha para cada campo y el primer campo debe ser menor al segundo');
}
if(date1.value < date2.value){

    var form_data = new FormData();                  // Creating object of FormData class
    form_data.append("type", 'fecha');
    form_data.append("txt", date1.value);
    form_data.append("txt2", date2.value);

    $.ajax({
        url: "rest/buscar.php",
        dataType: 'script',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         // Setting the data attribute of ajax with file_data
        type: 'post'
    })
    .done(function(res){
        location.href = 'http://localhost/dashboard/BDMM/busqueda.php';
    })
    .fail(function(e){
        console.log(e);
    })
    .always(function(){
        console.log('complete');
    }) 
}
if(date1.value > date2.value){
    alert('La primer fecha debe ser anterior a la segunda fecha');
}
}
</script>
</html>