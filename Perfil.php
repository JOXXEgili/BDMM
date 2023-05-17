<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/Perfil.css">
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
                                echo '<li><button onclick="location.href=' . "'crearCurso.php'" . '">Crear Curso</button></li><li><button onclick="location.href=' . "'cursosCreados.php'" . '">Cursos Creados</button></li>';
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
           <div class="log-in-box">
                <p style="font-weight: bold;">Ajustes y perfil</p>
                <form class="log-in-form">
                    <input id="user-input" type="text" placeholder="Nombre"> <br> 
                    <span class="mssgName" id="mssgName">Error en el Nombre</span>
                    <input id="apellidoP-input" type="text" placeholder="Apellido paterno"> <br> 
                    <span class="mssgAP" id="mssgAP">Error en el apellido Paterno</span>
                    <input id="apellidoM-input" type="text" placeholder="Apellido materno"> <br> 
                    <span class="mssgAM" id="mssgAM">Error en el apellido Materno</span>
                    <input id="password-input" type="password" placeholder="Contraseña"> <br>
                    <span class="mssgPass" id="mssgPass">Formato incorrecto de contraseña</span>
                    <label id="genre-label">Género</label> <br>
                    <select id="genre-input">
                        <option value='H'>H</option>
                        <option value='M'>M</option>
                        <option value='O'>O</option>
                    </select> 
                    <label id="date-label">Fecha de nacimiento</label> <br>
                    <input id="date-input" type="date"> <br>
                    <span class="mssgDate" id="mssgDate">Ingrese una fecha</span><br>
                    <label id="photo-label">Foto de perfil</label> <br>    
                    <input id="photo-input" type="file">
                    <span class="mssgImg" id="mssgImg">Seleccione una imágen</span>
                    
                    <!--<button>Regístrate</button> <br>-->
                    <input class="registro" type="button" value="Modificar" onclick="register()">
                </form>
           </div>
            
            <h2></h2>
        </main>
    </body>
    <?php
                $nombre = '';
                $apellidoP ='';
                $apellidoM ='';
                $contra='';
                $genero='';
                $birth='';
                if($_SESSION['type'] == 'Profesor'){
                    $query = "SELECT Nombre, ApellidoP, ApellidoM, contraseña, Genero, Birthday FROM profesores WHERE email = '$user'";
                    $resultado = $conn->query($query);
                    while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
                        $nombre = $data['Nombre'];
                        $apellidoP = $data['ApellidoP'];
                        $apellidoM = $data['ApellidoM'];
                        $contra = $data['contraseña'];
                        $genero = $data['Genero'];
                        $birth = $data['Birthday'];
                    }
                }
                else{
                    $query = "SELECT Nombre, ApellidoP, ApellidoM, contraseña, Genero, Birthday FROM estudiantes WHERE email = '$user'";
                    $resultado = $conn->query($query);
                    while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
                        $nombre = $data['Nombre'];
                        $apellidoP = $data['ApellidoP'];
                        $apellidoM = $data['ApellidoM'];
                        $contra = $data['contraseña'];
                        $genero = $data['Genero'];
                        $birth = $data['Birthday'];
                    }
                }

                if($genero == 'H')
                    $genero = 0;
                if($genero == 'M')
                    $genero = 1;
                if($genero == 'O')
                    $genero = 2;
            ?>
    <script>

        
        document.addEventListener('DOMContentLoaded', function() {

                document.getElementById("user-input").value = <?php echo '"' . $nombre . '"';?>;
                document.getElementById("apellidoP-input").value = <?php echo '"' . $apellidoP . '"';?>;
                document.getElementById("apellidoM-input").value = <?php echo '"' . $apellidoM . '"';?>;
                document.getElementById("password-input").value = <?php echo '"' . $contra . '"';?>;
                document.getElementById("date-input").value = <?php echo '"' . $birth . '"';?>;
                document.getElementById("genre-input").selectedIndex = <?php echo '"' . $genero . '"';?>;
                
            
        }, false);

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

            function register(){

                var e = sessionStorage.getItem("email");
                var name, MLastName, FLastName, email, pass, birth, logo, gender, logo2;

                name = document.getElementById("user-input").value;
                FLastName = document.getElementById("apellidoP-input").value;
                MLastName = document.getElementById("apellidoM-input").value;
                //email = document.getElementById("email-input").value;
                pass = document.getElementById("password-input").value;
                birth = document.getElementById("date-input").value;
                logo = document.getElementById("photo-input");
                gender = document.getElementById("genre-input").value;
                

                var rePass = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
                var reEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
                var reName = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;
                
                if(reName.test(name) && reName.test(FLastName) && reName.test(MLastName) && rePass.test(pass) && birth){
                    console.log('hola')
                    
                    document.getElementById("mssgName").style.visibility = 'hidden';
                    document.getElementById("mssgAP").style.visibility = 'hidden';
                    document.getElementById("mssgAM").style.visibility = 'hidden';
                    document.getElementById("mssgImg").style.visibility = 'hidden';
                    document.getElementById("mssgDate").style.visibility = 'hidden';
                    document.getElementById("mssgPass").style.visibility = 'hidden';

                    if(logo.files.length == 0){
                        logo2 = 'nada';
                    }
                    else{
                        logo2 = 'info';
                    }

                    var file_data = $("#photo-input").prop("files")[0];
                    var form_data = new FormData();                  // Creating object of FormData class
                    form_data.append("name", name);
                    form_data.append("FLastName", FLastName);
                    form_data.append("MLastName", MLastName);
                    form_data.append("pass", pass);
                    form_data.append("birth", birth);
                    form_data.append("file", file_data);
                    form_data.append("logo2", logo2);
                    form_data.append("gender", gender);

                    $.ajax({
                        url: "rest/apiUpdate.php",
                        dataType: 'script',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         // Setting the data attribute of ajax with file_data
                        type: 'post'
                    })
                    .done(function(res){
                        alert('Información actualizada')
                        location.href = 'http://localhost/BDMM/Perfil.php';
                    })
                    .fail(function(e){
                        console.log(e);
                    })
                    .always(function(){
                        console.log('complete');
                    }) 
                    
                }

                if(!reName.test(name)){
                    console.log("Hola")
                    document.getElementById("mssgName").style.visibility = 'visible';
                }
                else{
                    document.getElementById("mssgName").style.visibility = 'hidden';
                }

                if(!reName.test(FLastName)){
                    document.getElementById("mssgAP").style.visibility = 'visible';
                }
                else{
                    document.getElementById("mssgAP").style.visibility = 'hidden';
                }

                if(!reName.test(MLastName)){
                    document.getElementById("mssgAM").style.visibility = 'visible';
                }
                else{
                    document.getElementById("mssgAM").style.visibility = 'hidden';
                }
                if(!birth){
                    document.getElementById("mssgDate").style.visibility = 'visible';
                }
                else{
                    document.getElementById("mssgDate").style.visibility = 'hidden';
                }

                if(!rePass.test(pass)){
                    document.getElementById("mssgPass").style.visibility = 'visible';
                }
                else{
                    document.getElementById("mssgPass").style.visibility = 'hidden';
                }
                /*
                if(!reEmail.test(email)){
                    document.getElementById("mssgEmail").style.visibility = 'visible';
                }
                else{
                    document.getElementById("mssgEmail").style.visibility = 'hidden';
                }*/
            }
        </script>
</html>