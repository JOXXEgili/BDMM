<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cursosCreados.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tilt+Warp&display=swap" rel="stylesheet">
    <title>Busqueda</title>

    <script>
        $( document ).ready(function() {
            
        });
    </script>
</head>
<body>
    <header>
        <div class="left-nav">
        <a href="#.php"><img id="logo" src="img/udemy-logo.png"></a>
            <div class="dropdown-categories">
                <div class="dropdown-categories-content">
                    <il>
                    <?php
                        include('rest/conexion.php');

                    ?>
                        <!--li><button>Programación web</button></li>
                        <li><button>Marketing</button></li>
                        <li><button>Diseño</button></li-->
                    </il>
                </div> 

            </div>
            
        </div>
        
        <div class="right-nav" style="float:right;">
            <div class="perfil-image">
                <img src="img/user icon.jpg">
            </div>
            <div class="dropdown-categories-content-profile">
                <il>
                    <li><button onclick="location.href='activarUsuarios.php'">Activar usuarios</button></li>
                    <li><button onclick="location.href='activarComentarios.php'">Activar comentarios</button></li>
                    <li><button onclick="logout()">Salir</button></li>
                </il>
            </div> 
        </div>
    </header>
    <section class="cursos d-flex justify-content-center">
        <div>
        <div class="CursosHeader">
            <h1>USUARIOS</h1>
        </div>
        
        <?php
            $count = 0;
            $query = "SELECT email, Nombre, ApellidoP, ApellidoM, FotoP, Estado FROM estudiantes";
            $resultado = $conn->query($query);

            while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

                $min = base64_encode($data['FotoP']);
                $b64 = "data:image/jpg;base64, " . $min;
                if($data['Estado'] == 1){
                    echo '<div class="CursosContenedor" id="' . $data['email'] . '">
                    <div class="CursosCaja" onclick="curso()" id="' . $data['email'] . '">
                        <div class="CursoImg"><img src="'. $b64 . '" alt=""></div>
                        <div>
                        <div class="cajaTop" id="' . $data['email'] . '">
                            <div class="Nombres" id="' . $data['email'] . '">
                                <div class="NombresCurso" id="' . $data['email'] . '">
                                    <strong id="' . $data['email'] . '">' . $data['Nombre'] . ' ' . $data['ApellidoP'] . ' ' . $data['ApellidoM'] . '</strong>
                                    <span id="' . $data['email'] . '"> Estado: ' . $data['Estado'] . '</span>
                                </div>
                            </div>
                        </div>
                        <div class="info" id="' . $data['email'] . '">
                        </div>
                        
                        </div>
                        
                    </div>
                    <button class="disable d-flex justify-content-center" id="' . $data['email'] . '" onclick="habilitar()">Deshabilitar</button>
                </div>';
                }
                else{
                    echo '<div class="CursosContenedor" id="' . $data['email'] . '">
                    <div class="CursosCaja" onclick="curso()" id="' . $data['email'] . '">
                        <div class="CursoImg"><img src="'. $b64 . '" alt=""></div>
                        <div>
                        <div class="cajaTop" id="' . $data['email'] . '">
                            <div class="Nombres" id="' . $data['email'] . '">
                                <div class="NombresCurso" id="' . $data['email'] . '">
                                    <strong id="' . $data['email'] . '">' . $data['Nombre'] . ' ' . $data['ApellidoP'] . ' ' . $data['ApellidoM'] . '</strong>
                                    <span id="' . $data['email'] . '"> Estado: ' . $data['Estado'] . '</span>
                                </div>
                            </div>
                        </div>
                        <div class="info" id="' . $data['email'] . '">
                        </div>
                        
                        </div>
                        
                    </div>
                    <button class="disable d-flex justify-content-center" id="' . $data['email'] . '" onclick="habilitar()">Habilitar</button>
                </div>';
                }
            }

        ?>
        </div>
        <!--div class="CursosContenedor" >
            <div class="CursosCaja" onclick="location.href='Curso.html'">
                <div class="CursoImg"><img src="img/zuko.jpg" alt=""></div>
                <div>
                <div class="cajaTop">
                    <div class="Nombres">
                        <div class="NombresCurso">
                            <strong>Introducción Bases de datos</strong>
                            <span>Sergio Perez</span>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod, ducimus! Dignissimos illum beatae quaerat voluptatem. Officia delectus nihil unde quo neque, et, quidem adipisci nobis, rem magnam perspiciatis dignissimos! Quae.</p>
                </div>
                </div>
            </div>
        </div-->
            <!--div class="CursosContenedor" >
                <div class="CursosCaja" onclick="location.href='index.html'">
                    <div class="cajaTop">
                        <div class="Nombres">
                            <div class="NombresCurso">
                                <strong>Introducción Bases de datos</strong>
                                <span>Sergio Perez</span>
                            </div>
                        </div>
                    </div>
                    <div class="info">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod, ducimus! Dignissimos illum beatae quaerat voluptatem. Officia delectus nihil unde quo neque, et, quidem adipisci nobis, rem magnam perspiciatis dignissimos! Quae.</p>
                    </div>
                </div>
                <div class="CursosContenedor" >
                    <div class="CursosCaja" onclick="location.href='index.html'">
                        <div class="cajaTop">
                            <div class="Nombres">
                                <div class="NombresCurso">
                                    <strong>Introducción Bases de datos</strong>
                                    <span>Sergio Perez</span>
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod, ducimus! Dignissimos illum beatae quaerat voluptatem. Officia delectus nihil unde quo neque, et, quidem adipisci nobis, rem magnam perspiciatis dignissimos! Quae.</p>
                        </div>
                    </div>
                    <div class="CursosContenedor" >
                        <div class="CursosCaja" onclick="location.href='index.html'">
                            <div class="cajaTop">
                                <div class="Nombres">
                                    <div class="NombresCurso">
                                        <strong>Introducción Bases de datos</strong>
                                        <span>Sergio Perez</span>
                                    </div>
                                </div>
                            </div>
                            <div class="info">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod, ducimus! Dignissimos illum beatae quaerat voluptatem. Officia delectus nihil unde quo neque, et, quidem adipisci nobis, rem magnam perspiciatis dignissimos! Quae.</p>
                            </div>
                        </div-->
    </section>
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
                        location.href = 'http://localhost/BDMM/Curso.php';
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

function habilitar(){

    document.addEventListener('click', (e) =>
    {
        // Retrieve id from clicked element
        elementId = e.target.id;
        elementText = e.target.innerHTML;
        // If element has id

        if (elementId !== '') {
            var form_data = new FormData();                  // Creating object of FormData class
            form_data.append("type", elementText);
            form_data.append("id", elementId);

            $.ajax({
            url: "rest/habilitarUsuarios.php",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         // Setting the data attribute of ajax with file_data
                type: 'post'
            })
            .done(function(res){
                alert('Curso deshabilitado');
                location.href = 'http://localhost/BDMM/activarUsuarios.php';
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