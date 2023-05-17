<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/Nivel.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <title>Udemy</title>
        
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
        <main>
            <div class='top'>

                    <div class='videoContainer'>
                    <?php
                        $lvl = $_SESSION['Niveles'];
                        $curso = $_SESSION['curso'];
                        $NvlsComprados = false;

                        $query = "SELECT COUNT(ID_curso) FROM nvls_unicos_comprados WHERE Cliente = '$user' AND ID_curso = $curso";
                        $resultado = $conn->query($query);
                        $numero = $resultado->fetchColumn();

                        $query = "SELECT COUNT(ID_curso) FROM contenido_cursos WHERE ID_curso = $curso";
                        $resultado = $conn->query($query);
                        $numero2 = $resultado->fetchColumn();

                        if($numero == $numero2){
                            $comprado = true;
                        }
                        else if ($numero != 0){
                            $NvlsComprados = true;
                        }
                        
                        if($NvlsComprados){
                            $query3 = "SELECT ID_contenido_det_compras FROM nvls_unicos_comprados WHERE Cliente = '$user' AND ID_curso = $curso";
                            $resultado3 = $conn->query($query3);
                            while($data3 = $resultado3->fetch(PDO::FETCH_ASSOC)){
                                if($lvl == $data3['ID_contenido_det_compras']){
                                    $cont = $data3['ID_contenido_det_compras'];
                                    $query2 = "SELECT video FROM contenido_cursos WHERE ID_contenido = $cont AND ID_curso = $curso";
                                    
                                    $resultado2 = $conn->query($query2);
                                    while($data2 = $resultado2->fetch(PDO::FETCH_ASSOC)){
                                    $location = 'rest/' . $data2['video'];
                                    echo "<div>
                                        <video id='myVideo' src='".$location."' controls width='1080px' height='660px' ></video>     
                                    </div>";

                                    }
                                }
                            }
                        }
                        else{
                        $query = "SELECT * FROM nvls_cliente WHERE ID_curso = $curso AND Cliente = '$user'";
                        $resultado = $conn->query($query);
                        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

                            if($lvl == $data['ID_contenido']){
                                $cont = $data['ID_contenido'];
                                $query2 = "SELECT video FROM contenido_cursos WHERE ID_contenido = $cont AND ID_curso = $curso";
                                
                                $resultado2 = $conn->query($query2);
                                while($data2 = $resultado2->fetch(PDO::FETCH_ASSOC)){
                                $location = 'rest/' . $data2['video'];
                                echo "<div>
                                    <video id='myVideo' src='".$location."' controls width='1080px' height='660px' ></video>     
                                </div>";
                                }
                            }
                        }
                        
                        }

                    ?>
                    </div>

                <div class='lvlsContainer'>
                    <?php
                        $query = "SELECT ID_contenido, Descrip FROM contenido_cursos WHERE ID_curso = $curso";

                        $resultado = $conn->query($query);
                        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

                            if($NvlsComprados){
                                
                                $query4 = "SELECT ID_contenido_det_compras FROM nvls_unicos_comprados WHERE Cliente = '$user' AND ID_curso = $curso";
                                $resultado4 = $conn->query($query4);
                                while($data4 = $resultado4->fetch(PDO::FETCH_ASSOC)){
                                    $cont = $data['ID_contenido'];
                                    $descrip = $data['Descrip'];
                                    if($data['ID_contenido'] == $data4['ID_contenido_det_compras']){

                                        $cursado = "<h6  id = '" . $cont ."'>Aún no cursas este nivel</h6>";
            
                                        $query3 = "SELECT Estudiante, ID_contenido, ID_curso FROM nvls_progreso WHERE ID_curso = $curso AND Estudiante = '$user'";
                                        $resultado3 = $conn->query($query3);
                                        while($data3 = $resultado3->fetch(PDO::FETCH_ASSOC)){
                                            echo 'no entra';
                                            $cont2 = $data3['ID_contenido'];
                                            if($cont == $cont2){
                                                $cursado = "<h6  id = '" . $cont ."'>Ya cursaste este nivel</h6>";
                                            }
        
                                        }
                                        if($lvl == $cont){
                                            
                                            echo "<div class='lvl current' id = '" . $cont ."' onclick='changeLvl()'>
                                                <h5 id = '" . $cont ."'>Nivel " . $cont .": " . $descrip ."</h5>" . $cursado . "
                                            </div>";
                                        }
                                        else{
                                            
                                            echo "<div class='lvl' id = '" . $cont ."' onclick='changeLvl()'>
                                                <h5 id = '" . $cont ."'>Nivel " . $cont .": " . $descrip ."</h5>" . $cursado . "
                                            </div>";
                                        }
                                    }
                                    else{
                                        echo "<div class='lvl' id = '" . $cont ."' onclick='mssg()'>
                                        <h5 id = '" . $cont ."'>Nivel " . $cont .": " . $descrip ."</h5><h6>Este nivel no es de tu propiedad</h6>
                                    </div>";
                                    }
                                }
                            }
                            else{

                                $cont = $data['ID_contenido'];
                                $descrip = $data['Descrip'];
    
                                $cursado = "<h6  id = '" . $cont ."'>Aún no cursas este nivel</h6>";
    
                                $query3 = "SELECT Estudiante, ID_contenido, ID_curso FROM nvls_progreso WHERE ID_curso = $curso AND Estudiante = '$user' AND ID_contenido = $cont";
                                $resultado3 = $conn->query($query3);
                                while($data3 = $resultado3->fetch(PDO::FETCH_ASSOC)){
                                    
                                    $cont2 = $data3['ID_contenido'];
                                    if($cont == $cont2){
                                        $cursado = "<h6  id = '" . $cont ."'>Ya cursaste este nivel</h6>";
                                    }
    
                                    if($lvl == $cont){
                                    
                                        echo "<div class='lvl current' id = '" . $cont ."' onclick='changeLvl()'>
                                            <h5 id = '" . $cont ."'>Nivel " . $cont .": " . $descrip ."</h5>" . $cursado . "
                                        </div>";
                                    }
                                    else{
                                        
                                        echo "<div class='lvl' id = '" . $cont ."' onclick='changeLvl()'>
                                            <h5 id = '" . $cont ."'>Nivel " . $cont .": " . $descrip ."</h5>" . $cursado . "
                                        </div>";
                                    }
                                    
                                }
                                
                            }

                        }

                    ?>
                    <!--div class='lvl'>
                        <h5>Nivel 1: Aprenderás los primeros pasos</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div>
                    <div class='lvl'>
                        <h5>Nivel 2: Aprenderás los primeros pasos para este largo cursodddd dddddddd dddd dddd dddddd ddddd ddddddd dddd  ddddddd dddddd dddd</h5>
                    </div-->
                </div>
            </div>
            <div class='down'>
                <div class="inst">
                    <h1>Instrucciones y Tips</h1>
                    <br>
                    <?php
                        $query = "SELECT ID_contenido, Contenido FROM contenido_cursos WHERE ID_curso = $curso AND ID_contenido = $lvl";

                        $resultado = $conn->query($query);
                        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
                            $cont = $data['Contenido'];

                            if($cont == null){
                                echo "<h4> El profesor no proporcionó ningún tipo de instrucción ni tip :(</h4>";
                            }
                            else{
                                echo "<h4>" . $cont . "</h4>";
                            }
                            

                        }

                    ?>
                    
                </div>
                <div class="adjuntados">
                    <div class='image'>
                        <h1>Imágen Proporcionada</h1>
                        <?php
                        $query = "SELECT ID_contenido, Miniatura FROM contenido_cursos WHERE ID_curso = $curso AND ID_contenido = $lvl";

                        $resultado = $conn->query($query);
                        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

                            if($data['Miniatura'] == null){
                                echo "<h4> El profesor no proporcionó ningún tipo de imágen :(</h4>";
                            }
                            else{
                                echo "<img src='data:image/jpg;base64, " . base64_encode($data['Miniatura']) ."' alt='' width='800px' height='800px'>";
                            }
                            

                        }

                    ?>
                        <!--img src="img/zuko.jpg" alt="" width='800px' height='800px'-->
                    </div>
                    <div class="archivos">
                    <h1>Archivos Proporcionados</h1>
                        <?php
                            $query = "SELECT pdf, Miniatura FROM contenido_cursos WHERE ID_contenido = $lvl AND ID_curso = $curso";
                            $resultado = $conn->query($query);
                            while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
                                
                                if($data['pdf'] == null){
                                    echo "<div class='download'>
                                    <a class='files' href='#'>No se adjuntó un archivo pdf para su descarga</a><br>
                                    </div>";
                                }
                                else{
                                    echo "<div class='download'>
                                    <a class='files' download='PDF Title' href='data:application/pdf;base64, " . base64_encode($data['pdf']) . "'>Descargar documento PDF</a><br>
                                    </div>";
                                }   

                                if($data['Miniatura'] == null){
                                    echo "<div class='download'>
                                    <a class='files' href='#'>No se adjuntó una imágen para su descarga</a><br>
                                    </div>";
                                }
                                else{
                                    echo "<div class='download'>
                                    <a class='files' download href='data:image/png;base64, " . base64_encode($data['Miniatura']) . "'>Descargar Imágen</a><br>
                                    </div>";
                                }
                            }
                            ?>
                            <!--img src="data:image/jpg;base64, <?php //echo base64_encode($data['Miniatura']) ?>"-->
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
                    location.href = 'http://localhost/BDMM/busqueda.php';
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
                location.href = 'http://localhost/BDMM/index.php';
            })
            .fail(function(e){
                console.log(e);
            })
            .always(function(){
                console.log('complete');
            }) 
        }
        
        function changeLvl(){
            let elementId;
            document.addEventListener('click', (e) =>
                {
                    // Retrieve id from clicked element
                    elementId = e.target.id;
                    // If element has id
                    if (elementId !== '') {
                        
                        var form_data = new FormData();                  // Creating object of FormData class
                        form_data.append("Nivel", elementId);
                        // Appending parameter named file with properties of file_field to form_data
                        //form_data.append("msg", msg);
                        //form_data.append("remitente", 'misa2_09raya2@hotmail.com');

                        $.ajax({
                            url: "rest/CargarNivel.php",
                            dataType: 'script',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,                         // Setting the data attribute of ajax with file_data
                            type: 'post'
                        })
                        .done(function(res){
                            location.href = 'http://localhost/BDMM/Nivel.php';
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
        document.getElementById('myVideo').addEventListener('ended',myHandler,false);
        function myHandler(e) {
            
            var nivel = <?php echo $lvl; ?>;

            var form_data = new FormData();                  // Creating object of FormData class
            form_data.append("Nivel", nivel);

            $.ajax({
                url: "rest/completarCurso.php",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         // Setting the data attribute of ajax with file_data
                type: 'post'
            })
            .done(function(res){
                if(res === 'Acabado'){
                    alert('Haz completado el curso con éxtio');
                    location.href = 'http://localhost/BDMM/diploma.php';
                }
                else{
                    alert('Haz completado este nivel :)');
                    location.href = 'http://localhost/BDMM/Nivel.php';
                }
                
                //
            })
            .fail(function(e){
                console.log(e);
            })
            .always(function(){
                console.log('complete');
            })

        }

        function mssg(){
            alert('Este nivel no fue comprado');
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
            location.href = 'http://localhost/BDMM/busqueda.php';
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
        location.href = 'http://localhost/BDMM/busqueda.php';
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