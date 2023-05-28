<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/index.css">
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
            <?php

            if(isset($_SESSION['email'])){

                $page = '';
                $page2 = '';
                if($_SESSION['type'] == 'Profesor'){
                    $page = "'crearCurso.php'";
                    $page2 = 'Crear Curso';
                }
                else{
                    $page = "'Kardex.php'";
                    $page2 = 'Mis cursos';
                }

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
                            
                            $logo = base64_encode($data['FotoP']);
                        }

                        $b64 = "data:image/jpg;base64, " . $logo;
                        echo '<div class="perfil-image"><img src="' . $b64 . '" alt="avatar"></div>
                        <div class="dropdown-categories-content-profile">
                            <il>
                                <li><button onclick="location.href=' . "'Perfil.php'" . '">Perfil</button></li>
                                <li><button onclick="location.href=' . $page . '">' . $page2 . '</button></li>
                                <li><button onclick="location.href=' . "'messages.php'" . '">Mensajes</button></li>
                                <li><button onclick="logout()">Salir</button></li>
                            </il>
                        </div>';
            }
            else{
                echo '                <form action="log-in.php" id="botones">
                <button class="Log-in-button">Iniciar sesión</button>
            </form>
            <form action="register.php" id="botones">
                <button class="Register-button">Regístrate</button>
            </form>';
            }

            ?>
                
            </div>
        </header>

        <main>
            <div>
            <div class="promo">
                <h3 style="font-weight: bold;">Inicia sesión para <br> ahorrar</h3>
                <p>Tenemos ofertas especiales para los usuarios <br>
                    registrados hasta el 22 de febrero. Descubre todo lo <br>
                    que puedes ahorrar
                </p>
            </div>
            <img src="img/stock.jpg"> <br> 
            <h1>Una amplia selección de cursos</h1> <br>
            <h3>Elige entre 213.000 cursos de vídeos en línea con nuevo contenido cada mes</h3>
            <h2></h2>
            </div>
            <div class='nuevos'>
                <h2>Cursos nuevos</h2>
                <?php

                $query = "SELECT ID_curso ,Nombre, Precio, Descrip, Miniatura, Puntuacion, Estado, Autor, Creacion FROM cursos WHERE Estado = 1 GROUP BY Creacion DESC LIMIT 5";
                $resultado = $conn->query($query);
                while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

                    $email = $data['Autor'];

                    $query2 = "SELECT Nombre, ApellidoP, ApellidoM FROM Profesores WHERE email = '$email'";
                    $resultado2 = $conn->query($query2);


                    while($data2 = $resultado2->fetch(PDO::FETCH_ASSOC)){

                        $min = base64_encode($data['Miniatura']);
                        $b64 = "data:image/jpg;base64, " . $min;

                        echo '<div class="CursosContenedor" id="' . $data['ID_curso'] . '">
                            <div class="CursosCaja" onclick="curso()" id="' . $data['ID_curso'] . '">
                                <div class="CursoImg"><img src="'. $b64 . '" alt=""></div>
                                <div>
                                <div class="cajaTop" id="' . $data['ID_curso'] . '">
                                    <div class="Nombres" id="' . $data['ID_curso'] . '">
                                        <div class="NombresCurso" id="' . $data['ID_curso'] . '">
                                            <strong id="' . $data['ID_curso'] . '">' . $data['Nombre'] . '</strong>
                                            <span id="' . $data['ID_curso'] . '">' . $data2['Nombre'] . ' ' . $data2['ApellidoP'] . ' ' . $data2['ApellidoM'] . '</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="info" id="' . $data['ID_curso'] . '">
                                    <p id="' . $data['ID_curso'] . '">' . $data['Descrip'] . '</p>
                                </div>
                                </div>
                            </div>
                        </div>';
                    }
                }
                ?>
            </div>
            <div class="mejores">
                <h2>Mejor Calificados</h2>
                <?php

                $query = "SELECT ID_curso ,Nombre, Precio, Descrip, Miniatura, Puntuacion, Estado, Autor, Creacion FROM cursos WHERE Estado = 1 GROUP BY Puntuacion DESC LIMIT 5";
                $resultado = $conn->query($query);
                while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

                    $email = $data['Autor'];

                    $query2 = "SELECT Nombre, ApellidoP, ApellidoM FROM Profesores WHERE email = '$email'";
                    $resultado2 = $conn->query($query2);


                    while($data2 = $resultado2->fetch(PDO::FETCH_ASSOC)){

                        $min = base64_encode($data['Miniatura']);
                        $b64 = "data:image/jpg;base64, " . $min;

                        echo '<div class="CursosContenedor" id="' . $data['ID_curso'] . '">
                            <div class="CursosCaja" onclick="curso()" id="' . $data['ID_curso'] . '">
                                <div class="CursoImg"><img src="'. $b64 . '" alt=""></div>
                                <div>
                                <div class="cajaTop" id="' . $data['ID_curso'] . '">
                                    <div class="Nombres" id="' . $data['ID_curso'] . '">
                                        <div class="NombresCurso" id="' . $data['ID_curso'] . '">
                                            <strong id="' . $data['ID_curso'] . '">' . $data['Nombre'] . '</strong>
                                            <span id="' . $data['ID_curso'] . '">' . $data2['Nombre'] . ' ' . $data2['ApellidoP'] . ' ' . $data2['ApellidoM'] . '</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="info" id="' . $data['ID_curso'] . '">
                                    <p id="' . $data['ID_curso'] . '">' . $data['Descrip'] . '</p>
                                </div>
                                </div>
                            </div>
                        </div>';
                    }
                }
                ?>
            </div>
            <div class="mejores">
                <h2>Más vendidos</h2>
                <?php

                $query = "SELECT ID_curso, cantidad ,Nombre, Precio, Descrip, Miniatura, Puntuacion, Estado, Autor FROM nvls_mas_comprados_cursos GROUP BY cantidad DESC LIMIT 5";
                $resultado = $conn->query($query);
                while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

                    $email = $data['Autor'];

                    $query2 = "SELECT Nombre, ApellidoP, ApellidoM FROM Profesores WHERE email = '$email'";
                    $resultado2 = $conn->query($query2);


                    while($data2 = $resultado2->fetch(PDO::FETCH_ASSOC)){

                        $min = base64_encode($data['Miniatura']);
                        $b64 = "data:image/jpg;base64, " . $min;

                        echo '<div class="CursosContenedor" id="' . $data['ID_curso'] . '">
                            <div class="CursosCaja" onclick="curso()" id="' . $data['ID_curso'] . '">
                                <div class="CursoImg"><img src="'. $b64 . '" alt=""></div>
                                <div>
                                <div class="cajaTop" id="' . $data['ID_curso'] . '">
                                    <div class="Nombres" id="' . $data['ID_curso'] . '">
                                        <div class="NombresCurso" id="' . $data['ID_curso'] . '">
                                            <strong id="' . $data['ID_curso'] . '">' . $data['Nombre'] . '</strong>
                                            <span id="' . $data['ID_curso'] . '">' . $data2['Nombre'] . ' ' . $data2['ApellidoP'] . ' ' . $data2['ApellidoM'] . '</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="info" id="' . $data['ID_curso'] . '">
                                    <p id="' . $data['ID_curso'] . '">' . $data['Descrip'] . '</p>
                                </div>
                                </div>
                            </div>
                        </div>';
                    }
                }
                ?>
            </div>

        </main>
        
    </body>
    <script>

function search(){
        txt = document.getElementById("buscar").value;
            
        if(txt != '' && txt != null){
            var form_data = new FormData();                  // Creating object of FormData class
            form_data.append("txt", txt);            // Appending parameter named file with properties of file_field to form_data
            form_data.append("type", 'text');  
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

function curso(){
          // Appending parameter named file with properties of file_field to form_data
        //form_data.append("msg", msg);
        //form_data.append("remitente", 'misa2_09raya2@hotmail.com');

        let elementId;
        document.addEventListener('click', (e) =>
            {
                // Retrieve id from clicked element
                elementId = e.target.id;
                // If element has id
                if (elementId !== '') {
                    
                    var form_data = new FormData();                  // Creating object of FormData class
                    form_data.append("curso", elementId); 

                    $.ajax({
                        url: "rest/Curso_load.php",
                        dataType: 'script',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         // Setting the data attribute of ajax with file_data
                        type: 'post'
                    })
                    .done(function(res){
                        location.href = 'http://localhost/dashboard/BDMM/Curso.php';
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
    </script>
</html>