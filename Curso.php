<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/curso.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tilt+Warp&display=swap" rel="stylesheet">

    <title>Curso</title>
</head>
<body>
    <header>
        <div class="left-nav">
            <img id="logo" src="img/udemy-logo.png" onclick="location.href='index.php'">
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
        <div class="right-nav" style="float:right;">
            <div class="perfil-image">
                <?php

                $user = $_SESSION['email'];
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
    <section>
            <?php 

            $curso = $_SESSION['curso'];

            $comprado = false;
            $NvlsComprados = false;
            
            $funcion = '';
            $funcion2 = '';
            if(!isset($_SESSION['type'])){
                $funcion = 'onclick="alrt()"';
                $funcion2 = 'onclick="alrt()"';
            }
            else if($_SESSION['type'] == 'Profesor'){
                $funcion = 'onclick="alrt()"';
                $funcion2 = 'onclick="alrt()"';
            }
            else if($_SESSION['type'] == 'Estudiante'){

                $query = "SELECT ID_compra FROM compras WHERE Cliente = '$user'";
                $resultado = $conn->query($query);
                while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

                    $idCompra = $data['ID_compra'];

                    $query2 = "SELECT * FROM nvls_comprados WHERE ID_compra = $idCompra";
                    $resultado2 = $conn->query($query2);
                    while($data2 = $resultado2->fetch(PDO::FETCH_ASSOC)){
                        
                        if($data2['LVL'] > 1 && $data2['ID_curso'] == $curso){
                            $comprado = true;
                        }
                        
                    }

                }

                if($comprado == false){
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
                }

                $funcion = 'onclick="buyCursos()"';
                $funcion2 = 'onclick="buyLvl()"';
            }


            $query = "SELECT ID_curso, Nombre, Precio, Descrip, Puntuacion, Autor, Estado, Creacion, Miniatura FROM cursos WHERE ID_curso = $curso AND Estado = 1";
            $resultado = $conn->query($query);
            while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

                $min = base64_encode($data['Miniatura']);
                $min = "data:image/jpg;base64, " . $min;

                $email = $data['Autor'];

                $query2 = "SELECT Nombre, ApellidoP, ApellidoM FROM Profesores WHERE email = '$email'";
                $resultado2 = $conn->query($query2);

                while($data2 = $resultado2->fetch(PDO::FETCH_ASSOC)){
                    $stars = '';

                    if($data['Puntuacion'] == null){
                        $stars = 'No se tienen las suficientes reseñas para una dar una calificación';
                    }
                    else{
                        $punt = $data['Puntuacion'];

                        for ($i = 1; $i <= $punt; $i++) {
                            $stars .= '<i style="" class="fa fa-star checked"></i>';
                        }

                        for($i = 1; $i <= 5 - $punt; $i++){
                            $stars .= '<i style="color: gray" class="fa fa-star checked"></i>';
                        }
                    }
                    
                    if($comprado){
                        echo '<div class="presentacion">
                        <div><img src="' . $min . '" alt="" width="200px" heigth = "200px"></div>
                        <div class="allInfo">
                        <div class="basicInfo">
                        <strong>'. $data['Nombre'] . '</strong>
                    <span>' . $data['Descrip'] .'</span>
                    </div>
                    <div class="extraInfo">
                        <div class="stars">' . $stars . '</div>
                        <div class="creador">
                            <p>' . $data2['Nombre'] . ' ' . $data2['ApellidoP'] . ' ' . $data2['ApellidoM'] . '</p>
                        </div>
                        <p class="creacion">Creado el ' . $data['Creacion'] .'</p>
                    </div></div></div>
                    <div class="pago">
                    <div class="contenido">
                    <div class="titulo">
                        <div style="display: flex;">
                        <h2 id="precio"> Este curso ya fue adquirido por ti</h2></div>
                    </div>
                    <div class="botonCompra">
                        <button class="pagar" onclick="cursarCurso()">Entrar al curso</button>
                    </div></div>
                    <div class="extraInfo">
                            <span>Garantía de 30 días</span>
                            <span>Acceso de por vida</span>
                    
                    </div>
                </div>';
                    }
                    else{
                    echo '<div class="presentacion">
                        <div><img src="' . $min . '" alt="" width="200px" heigth = "200px"></div>
                        <div class="allInfo">
                        <div class="basicInfo">
                            <strong>'. $data['Nombre'] . '</strong>
                        <span>' . $data['Descrip'] .'</span>
                        </div>
                        <div class="extraInfo">
                            <div class="stars">' . $stars . '</div>
                            <div class="creador">
                                <p>' . $data2['Nombre'] . ' ' . $data2['ApellidoP'] . ' ' . $data2['ApellidoM'] . '</p>
                            </div>
                            <p class="creacion">Creado el ' . $data['Creacion'] .'</p>
                        </div></div></div>
                        <div class="pago">
                        <div class="contenido">
                        <div class="titulo">
                            <h1>Aprovecha y adquierelo</h1>
                            <div style="display: flex;">
                            <h2 id="precio">' . $data['Precio'] .  '</h2><h2>   MXN$</h2></div>
                        </div>
                        <div class="botonCompra">
                            <button class="pagar" ' . $funcion . '>Comprar este curso</button>
                            <div id="paypal-payment-button"></div>
                        </div></div>
                        <div class="extraInfo">
                                <span>Garantía de 30 días</span>
                                <span>Acceso de por vida</span>
                        
                        </div>
                    </div>';
                    }
                }
            }

            ?>
            <!--div class="basicInfo">
                <strong>Introducción a las bases de datos</strong>
            <span>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Necessitatibus eum assumenda, illo ipsum similique inventore molestiae hic recusandae adipisci modi, numquam saepe doloremque. A reiciendis, eaque nobis rem minus cum error aspernatur? Nisi, perferendis. Quia veniam quaerat esse sint incidunt.</span>
            </div>
            <div class="extraInfo">
                <div class="stars">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star"></i>
                </div>
                <div class="creador">
                    <p>Curso creado por Juan Escutia</p>
                </div>
                <p class="creacion">Creado el 2023/2/12</p>
            </div-->
        <div class="curso">
            <h1>Contendio del curso</h1>
            <div class="nivles">
                <?php
                    $query = "SELECT ID_contenido, Contenido, Precio, ID_curso, Descrip FROM contenido_cursos WHERE ID_curso = $curso ORDER BY ID_contenido ASC";
                    $resultado = $conn->query($query);
                    while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

                        if($comprado){
                            echo '<details class="nivel">
                                    <summary>Nivel ' . $data['ID_contenido'] . '</summary>
                                    <ul>
                                        <li>' . $data['Descrip'] . '</li>
                                    </ul>
                            </details>';
                        }
                        else{
                            
                            if($NvlsComprados){

                                $query3 = "SELECT ID_contenido_det_compras FROM nvls_unicos_comprados WHERE Cliente = '$user' AND ID_curso = $curso";
                                $resultado3 = $conn->query($query3);
                                while($data3 = $resultado3->fetch(PDO::FETCH_ASSOC)){

                                    if($data['ID_contenido'] == $data3['ID_contenido_det_compras']){
                                        echo '<details class="nivel">
                                                <summary>Nivel ' . $data['ID_contenido'] . '</summary>
                                                <ul>
                                                    <li>' . $data['Descrip'] . '</li>
                                                    <li>Este nivel es tuyo</li>
                                                    <li><button class="pagarNvl" id="' . $data['ID_contenido'] .'" onclick="cursarNivel()">Cursar Nivel</button></li>
                                                </ul>
                                        </details>';
                                    }
                                    else{
                                        echo '<details class="nivel">
                                        <summary>Nivel ' . $data['ID_contenido'] . '</summary>
                                        <ul>
                                            <li>' . $data['Descrip'] . '</li>
                                            <li>Precio de: '. $data['Precio'] . 'MXN$</li>
                                            <li><button class="pagarNvl" id="' . $data['ID_contenido'] .'" '. $funcion2 . '>Comprar Nivel</button></li>
                                        </ul>
                                </details>';
                                    }
                                }
                            }
                            else{
                                echo '<details class="nivel">
                                        <summary>Nivel ' . $data['ID_contenido'] . '</summary>
                                        <ul>
                                            <li>' . $data['Descrip'] . '</li>
                                            <li>Precio de: '. $data['Precio'] . 'MXN$</li>
                                            <li><button class="pagarNvl" id="' . $data['ID_contenido'] .'" '. $funcion2 . '>Comprar Nivel</button></li>
                                        </ul>
                                </details>';
                            }
                        }
                    }
                ?>
                <!--details class="nivel">
                        <summary>Principios de Bases de datos</summary>
                        <ul>
                            <li>¿Qué es una base de datos?</li>
                            <li>Tipos de bases de datos</li>
                            <li>Diferencias entre tipos de bases de datos</li>
                        </ul>
                </details>
                <details class="nivel">
                    <summary>Modelo relacional</summary>
                    <ul>
                        <li>Introducción</li>
                        <li>Relaciones</li>
                        <li>Apss para realizarlo</li>
                    </ul>
            </details>
            <details class="nivel">
                <summary>Microsft sql</summary>
                <ul>
                    <li>Instalación</li>
                    <li>Primeros pasos</li>
                    <li>Creación de primer base de datos</li>
                </ul>
        </details-->
            </div>
        </div>
        <div class="comentarios">
            <h1>Comentarios</h1>
                <?php
                    $query = "SELECT COUNT(ID_curso) FROM comentario_Estudiante WHERE ID_curso = $curso";
                    $resultado = $conn->query($query);
                    $numero = $resultado->fetchColumn();

                    if($numero != 0){
                        $query = "SELECT Contenido, ID_curso, Fecha, Autor, FotoP, Nombre, ApellidoP, ApellidoM FROM comentario_Estudiante WHERE ID_curso = $curso ";
                        $resultado = $conn->query($query);
                        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

                            $query2 = "SELECT Estado FROM comentarios WHERE ID_curso = $curso AND Estado = 1";
                            $resultado2 = $conn->query($query2);
                            while($data2 = $resultado2->fetch(PDO::FETCH_ASSOC)){
                                $foto = base64_encode($data['FotoP']);
                                $foto = "data:image/jpg;base64, " . $foto;
                                $nombre = $data['Nombre'] . ' ' . $data['ApellidoP'] . ' ' . $data['ApellidoM'];
    
                                echo '<div class="CursosCaja">
                                    <div class="cajaTop">
                                        <div class="perfil-image">
                                            <img src="' . $foto .'">
                                        </div>
                                        <div class="Nombres">
                                            <div class="NombresCurso">
                                                
                                                <strong>'. $nombre . '</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <p>' . $data['Contenido'] . '</p>
                                        <p style="color: gray">' . $data['Fecha'] . '</p>
                                    </div>
                                </div>';
                                break;
                            }
                            
                        }
                    }
                    else{
                        echo '<h1>Este curso aún no tiene ningún comentario</h1>';
                    }
                ?>
                <!--div class="CursosCaja">
                    <div class="cajaTop">
                        <div class="perfil-image">
                            <img src="img/user icon.jpg" alt="">
                        </div>
                        <div class="Nombres">
                            <div class="NombresCurso">
                                <strong>Angel Cerecero</strong>
                            </div>
                        </div>
                    </div>
                    <div class="info">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum molestias veniam possimus illum aliquid nam pariatur atque iusto eius. Doloribus vero perspiciatis, deserunt et consequatur quibusdam nisi impedit assumenda quod.</p>
                    </div>
                </div>
                <div class="CursosCaja">
                    <div class="cajaTop">
                        <div class="perfil-image">
                            <img src="img/user icon.jpg" alt="">
                        </div>
                        <div class="Nombres">
                            <div class="NombresCurso">
                                <strong>Angel Cerecero</strong>
                            </div>
                        </div>
                    </div>
                    <div class="info">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum molestias veniam possimus illum aliquid nam pariatur atque iusto eius. Doloribus vero perspiciatis, deserunt et consequatur quibusdam nisi impedit assumenda quod.</p>
                    </div>
                </div>
                <div class="CursosCaja">
                    <div class="cajaTop">
                        <div class="perfil-image">
                            <img src="img/user icon.jpg" alt="">
                        </div>
                        <div class="Nombres">
                            <div class="NombresCurso">
                                <strong>Angel Cerecero</strong>
                            </div>
                        </div>
                    </div>
                    <div class="info">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum molestias veniam possimus illum aliquid nam pariatur atque iusto eius. Doloribus vero perspiciatis, deserunt et consequatur quibusdam nisi impedit assumenda quod.</p>
                    </div>
                </div>
                <div class="CursosCaja">
                    <div class="cajaTop">
                        <div class="perfil-image">
                            <img src="img/user icon.jpg" alt="">
                        </div>
                        <div class="Nombres">
                            <div class="NombresCurso">
                                <strong>Angel Cerecero</strong>
                            </div>
                        </div>
                    </div>
                    <div class="info">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum molestias veniam possimus illum aliquid nam pariatur atque iusto eius. Doloribus vero perspiciatis, deserunt et consequatur quibusdam nisi impedit assumenda quod.</p>
                    </div>
                </div-->
        </div>
    </section>
    <script src="https://www.paypal.com/sdk/js?client-id=AbD7ESGShm2n_qKo3CuMHYRxmWwEyMnRU63TyNPZ8kB6H14ismHteY3rwPDE-eacQs8ip3qWtf7gde8h&currency=MXN"></script>
    <script>
        var p = document.getElementById("precio").value;
        console.log(p)
        p2 = parseFloat(p);
        paypal.Buttons({


            onApprove:function(data, actions){
                actions.order.capture().then(function (detalles){
                    console.log(detalles);
                    
                    var form_data = new FormData();                  // Creating object of FormData class
                        form_data.append("nivel", '0');
                        form_data.append("Tipo", 'paypal'); 
                        // Appending parameter named file with properties of file_field to form_data
                        //form_data.append("msg", msg);
                        //form_data.append("remitente", 'misa2_09raya2@hotmail.com');

                        $.ajax({
                            url: "rest/ComprarCurso.php",
                            dataType: 'script',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,                         // Setting the data attribute of ajax with file_data
                            type: 'post'
                        })
                        .done(function(res){
                            alert('Compra exitosa');
                            location.href = 'http://localhost/dashboard/BDMM/Curso.php';
                        })
                        .fail(function(e){
                            console.log(e);
                        })
                        .always(function(){
                            console.log('complete');
                        })
                });
            },

            onCancel: function(data){
                alert("pago cancelado");
            }
        }).render('#paypal-payment-button');
    </script>
</body>
<script>
    function buyLvl(){
        let elementId;
        document.addEventListener('click', (e) =>
            {
                // Retrieve id from clicked element
                elementId = e.target.id;
                // If element has id
                if (elementId !== '') {
                    
                    //var form_data = new FormData();                  // Creating object of FormData class
                    //form_data.append("lvl", elementId); 
                    sessionStorage.setItem('lvl', elementId);
                     console.log(elementId)
                    location.href = 'http://localhost/dashboard/BDMM/pagoTarjeta.php'
                    /*
                    $.ajax({
                        url: "rest/ComprarCurso.php",
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
                    })*/
                }

        })
    }

    function alrt(){
        alert('No puede realizar compras porque necesita tener una cuenta de tipo Estudiante');
    }
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

        function buyCursos(){
        /*var form_data = new FormData();                  // Creating object of FormData class
            form_data.append("nivel", '0');
            // Appending parameter named file with properties of file_field to form_data
            //form_data.append("msg", msg);
            //form_data.append("remitente", 'misa2_09raya2@hotmail.com');

            $.ajax({
                url: "rest/ComprarCurso.php",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         // Setting the data attribute of ajax with file_data
                type: 'post'
            })
            .done(function(res){
                alert('Compra exitosa');
                //location.href = 'http://localhost/dashboard/BDMM/index.php';
            })
            .fail(function(e){
                console.log(e);
            })
            .always(function(){
                console.log('complete');
            }) */
            location.href = 'http://localhost/dashboard/BDMM/pagoTarjeta.php'
    }

    function cursarNivel(){
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
                        location.href = 'http://localhost/dashboard/BDMM/Nivel.php';
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

    function cursarCurso(){
            var form_data = new FormData();                  // Creating object of FormData class
            form_data.append("Nivel", 1);
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
                location.href = 'http://localhost/dashboard/BDMM/Nivel.php';
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
</script>
</html>