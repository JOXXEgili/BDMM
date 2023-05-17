<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Kardex.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tilt+Warp&display=swap" rel="stylesheet">

    <title>Kardex</title>
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
                <input class='date' id='fecha1' type="date" data-date-format="YYYY-MM-DD"/>
                <input class='date' id='fecha2' type="date" data-date-format="YYYY-MM-DD"/>
                <img src="img/lupa.png" onclick="searchDate()">
            </div>
        </div>
        <div class="right-nav" style="float:right;">
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
                    $page2 = 'Mis Cursos';
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
                echo 'nada';
            }
        ?>
        </div>
    </header>

    <section class="Cursos">
        <div class="CursosHeader">
            <span>Tus Cursos</span>
        </div>
        <div class="filtros">
            <div class="rango apartado">
                Rango de fechas
                <div class="pickers">
                    <input type="date" id='date1' />
                    <input type="date" id='date2'/>
                </div>
            </div>
            <div class="categoria apartado">
                Categoría
                <div>
                <select name="cars" id="cats">
                    <option value="Todas">Todas</option>
                    <?php 
                        $query = "SELECT ID_categoria, Nombre, Estado FROM categorias WHERE Estado = 1 GROUP BY ID_categoria ASC";
                        $resultado = $conn->query($query);
                        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
                            echo '<option value="'. $data['Nombre'] .'">'. $data['Nombre'] . '</option>';
                        }
                    ?>
                    <!--option value="Todas">Todas</option>
                    <option value="mercedes">Programación</option>
                    <option value="audi">Matemáticas</option-->
                  </select>
                </div>
            </div>
            <div class="terminado apartado">
                Terminados
                <div class="form-check terminado">
                    <input class="checkTerminado" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    </label>
                </div>
            </div>
            <div class="activo apartado">
                Activos
                <div class="form-check terminado">
                    <input class="checkActivo" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                      
                    </label>
                </div>

            </div>
        </div>
        <button class="AceptarFiltro" onclick='filtro()'>Aceptar</button>
        <div class="CursosContenedor" >
            <?php 
                $user = $_SESSION['email'];

                $aux = 0;

                $query = "SELECT ID_compra, Cliente, Fecha FROM compras WHERE Cliente = '$user'";
                $resultado = $conn->query($query);
                while($data = $resultado->fetch(PDO::FETCH_ASSOC)){

                    $compra = $data['ID_compra'];

                    //echo 'compra: ' . $compra . ' ';
                    
                    $query2 = "SELECT ID_curso, ID_compra FROM det_compras WHERE ID_compra = $compra";
                    $resultado2 = $conn->query($query2);
                    while($data2 = $resultado2->fetch(PDO::FETCH_ASSOC)){

                        $curso = $data2['ID_curso'];
                        
                        
                        if($compra != $aux){
                            $aux = $compra;
                            //echo 'curso: ' . $curso . ' ';
                            
                            $query3 = "SELECT ID_curso, Nombre, Miniatura, Autor, Estado FROM cursos WHERE ID_curso = $curso";
                            $resultado3 = $conn->query($query3);
                            while($data3 = $resultado3->fetch(PDO::FETCH_ASSOC)){
                               
                                $prof = $data3['Autor'];
                                $estado = $data3['Estado'];

                                if($data['Estado'] == 1){
                                    $estado = 'Sí';
                                }
                                else{
                                    $estado = 'No';
                                }

                                //echo 'email: ' . $prof . ' ';

                                $query4 = "SELECT email, Nombre, ApellidoP, ApellidoM FROM profesores WHERE email = '$prof'";
                                $resultado4 = $conn->query($query4);
                                while($data4 = $resultado4->fetch(PDO::FETCH_ASSOC)){

                                    $query5 = "SELECT Estudiante, ID_curso, UltimoIngreso FROM progreso WHERE Estudiante = '$prof' AND ID_curso = $curso";
                                    $resultado5 = $conn->query($query5);

                                    $query6 = "SELECT ID_categoria, ID_curso FROM cursos_categorias WHERE ID_curso = $curso";
                                    $resultado6 = $conn->query($query6);
                                    while($data6 = $resultado6->fetch(PDO::FETCH_ASSOC)){
                                        $categoria = $data6['ID_categoria'];

                                        $query7 = "SELECT ID_categoria, Nombre FROM categorias WHERE ID_categoria = $categoria";
                                        $resultado7 = $conn->query($query7);
                                        while($data7 = $resultado7->fetch(PDO::FETCH_ASSOC)){
                                            
                                            if($resultado5->fetch(PDO::FETCH_ASSOC) != null){
                                                while($data5 = $resultado5->fetch(PDO::FETCH_ASSOC)){
                                                    
                                                    echo '<div class="CursosCaja" onclick="location.href=' . "'index.html'" .'">
                                                            <div class="cajaTop">
                                                                <div class="Nombres">
                                                                    <div class="NombresCurso">
                                                                        <strong>' . $data3['Nombre'] . '</strong>
                                                                        <span>' . $data4['Nombre'] . ' ' . $data4['ApellidoP'] . ' ' . $data4['ApellidoM'] . '</span>
                                                                    </div>
                                                                </div>
                                                                <div class="resenia">
                                                                    <div class="progress">
                                                                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">100%</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="info">
                                                                <p>Categoría: ' . $data7['Nombre'] . '</p>
                                                                <div style="display: flex">
                                                                <p>Inscripción: </p>&nbsp;
                                                                <p id="fech">' . $data['Fecha'] . '</p>
                                                                </div>
                                                                <p id="estado">Activo: '. $estado . '</p>
                                                                <p>Última interacción: ' . $data5["UltimoIngreso"] . '</p>
                                                                <p>Finalización: 2023/02/27</p>
                                                            </div>
                                                        </div>';
                                                
                                                }
                                            }
                                            else{
                                                $ultimaInteraccion = 'Nunca';
                                                $query8 = "SELECT MAX(UltimoIngreso) FROM progreso WHERE ID_curso = $curso AND Estudiante = '$user'";
                                                $resultado8 = $conn->query($query8);
                                                while($data8 = $resultado8->fetch(PDO::FETCH_ASSOC)){
                                                    $ultimaInteraccion = $data8['MAX(UltimoIngreso)'];
                                                }
                                                $query9 = "SELECT NvlsProgreso, NvlsCurso FROM nvls_acabados WHERE ID_curso = $curso AND Estudiante = '$user'";
                                                $resultado9 = $conn->query($query9);
                                                $fin = 'Aún en curso';
                                                $percent = 0;
                                                while($data9 = $resultado9->fetch(PDO::FETCH_ASSOC)){
                                                    if($data9['NvlsProgreso'] == $data9['NvlsCurso']){
                                                        $fin = $ultimaInteraccion;
                                                        $percent = ($data9['NvlsProgreso'] * 100)/$data9['NvlsCurso'];
                                                    }
                                                }
                                                echo '<div class="CursosCaja" onclick="location.href=' . "'index.html'" .'">
                                                        <div class="cajaTop">
                                                            <div class="Nombres">
                                                                <div class="NombresCurso">
                                                                    <strong>' . $data3['Nombre'] . '</strong>
                                                                    <span>' . $data4['Nombre'] . ' ' . $data4['ApellidoP'] . ' ' . $data4['ApellidoM'] . '</span>
                                                                </div>
                                                            </div>
                                                            <div class="resenia">
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: ' . $percent .'%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">'. $percent . '%</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="info">
                                                            <p id="NomCat" >Categoría: ' . $data7['Nombre'] . '</p>
                                                            <div style="display: flex">
                                                                <p>Inscripción: </p>&nbsp;
                                                                <p id="fech">' . $data['Fecha'] . '</p>
                                                            </div>
                                                            <p>Última interacción: '. $ultimaInteraccion . '</p>
                                                            <p id="fin">Finalización: ' . $fin . '</p>
                                                        </div>
                                                    </div>';
                                            }
    
                                        }

                                    }

                                }

                            }
                        }
                    }
                }
            ?>
            <!--div class="CursosCaja" onclick="location.href='index.html'">
                <div class="cajaTop">
                    <div class="Nombres">
                        <div class="NombresCurso">
                            <strong>Introducción Bases de datos</strong>
                            <span>Sergio Perez</span>
                        </div>
                    </div>
                    <div class="resenia">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">100%</div>
                          </div>
                        <div class="stars">
                            <i class="fa fa-star checked"></i>
                            <i class="fa fa-star checked"></i>
                            <i class="fa fa-star checked"></i>
                            <i class="fa fa-star checked"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <p id="NomCat" >Categoría: Arte</p>
                    <div style='display:flex'>
                        <p>Inscripción:</p>&nbsp;
                        <p id='fech'>2023/02/12</p>   
                    </div>
                    <p>Última interacción 2023/02/27</p>
                    <p id="fin">Finalización 2023/02/27</p>
                </div>
            </div-->
            <!--div class="CursosCaja" onclick="location.href='index.html'">
                <div class="cajaTop">
                    <div class="Nombres">
                        <div class="NombresCurso">
                            <strong>Programación Básica</strong>
                            <span>Sergio Perez</span>
                        </div>
                    </div>
                    <div class="resenia">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 85%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">85%</div>
                          </div>
                    </div>
                </div>
                <div class="info">
                    <p>Inscripción 2023/02/12</p>
                    <p>Última interacción 2023/02/27</p>
                    <p>Finalización En curso</p>
                </div>
            </div>
            <div class="CursosCaja" onclick="location.href='index.html'">
                <div class="cajaTop">
                    <div class="Nombres">
                        <div class="NombresCurso">
                            <strong>Teoría de la programación</strong>
                            <span>Sergio Perez</span>
                        </div>
                    </div>
                    <div class="resenia">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">100%</div>
                          </div>
                        <div class="stars">
                            <i class="fa fa-star checked"></i>
                            <i class="fa fa-star checked"></i>
                            <i class="fa fa-star checked"></i>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <p>Inscripción 2023/02/12</p>
                    <p>Última interacción 2023/02/27</p>
                    <p>Finalización 2023/02/27</p>
                </div>
            </div>
            <div class="CursosCaja" onclick="location.href='index.html'">
                <div class="cajaTop">
                    <div class="Nombres">
                        <div class="NombresCurso">
                            <strong>Matemáticas para videojuegos</strong>
                            <span>Sergio Perez</span>
                        </div>
                    </div>
                    <div class="resenia">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 30%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">30%</div>
                          </div>
                        <div class="stars">
                        </div>
                    </div>
                </div>
                <div class="info">
                    <p>Inscripción 2023/02/12</p>
                    <p>Última interacción 2023/02/27</p>
                    <p>Finalización En curso</p>
                </div>
            </div-->
            
        </div>
        
    </section>
</body>
<script>
    function filtro(){

        if($('.checkTerminado').is(':checked') && $('.checkActivo').is(':checked')){//SI SELECCIONA LOS 2 CHECKBOX
            alert('Las casillas de cursos activos y terminados no pueden estar seleccionadas al mismo tiempo');
        }
        var cursos = document.querySelectorAll('.CursosCaja');

        const date1 = document.getElementById('date1');
        const date2 = document.getElementById('date2');

        if(!date1.value && !!date2.value){
            alert('Si se desea filtrar por fecha se debe de seleccionar una fecha para cada campo y el primer campo debe ser menor al segundo');//SI SELECCIONA SOLO EL PRIMER DATE
        }
        if(!!date1.value && !date2.value){
            alert('Si se desea filtrar por fecha se debe de seleccionar una fecha para cada campo y el primer campo debe ser menor al segundo');//SI SELECCIONA SOLO EL SEGUNDO DATE
        }

        if( $('.checkTerminado').is(':checked') && !$('.checkActivo').is(':checked') && !date1.value && !date2.value){// SI SELECCIONA LOS TERMINADOS
            //terminados activado y sin rangos de fecha
            if(document.getElementById("cats").value == 'Todas'){//TODAS LAS CATEGORÍAS
                for(var i=0; i<cursos.length; i++){
                    if(cursos[i].querySelector('#fin').innerHTML == 'Finalización: Aún en curso'){
                        cursos[i].style.display = 'none';
                    }
                    else{
                        cursos[i].style.display = 'inline';
                    }
                }
            }
            else{// UNA CATEGORÍA ES ESPECÍFICO
                for(var i=0; i<cursos.length; i++){
                    if(cursos[i].querySelector('#fin').innerHTML == 'Finalización: Aún en curso'){
                        //if('Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){
                            cursos[i].style.display = 'none';
                        //}
                    }
                    else{
                        if('Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){
                            cursos[i].style.display = 'none';
                        }
                        else{
                            cursos[i].style.display = 'inline';
                        }
                    }
                }
            }

        }

        if( !$('.checkTerminado').is(':checked') && $('.checkActivo').is(':checked') && !date1.value && !date2.value){//SI SELECCIONA LOS ACTIVOS
            //terminados activado y sin rangos de fecha
            if(document.getElementById("cats").value == 'Todas'){// TODAS LAS CATEGORÍAS
                for(var i=0; i<cursos.length; i++){
                    if(cursos[i].querySelector('#estado').innerHTML != 'Activo: Sí'){
                        cursos[i].style.display = 'none';
                    }
                    else{
                        cursos[i].style.display = 'inline';
                    }
                }
            }
            else{// UNA CATEGORÍA ES ESPECÍFICO
                for(var i=0; i<cursos.length; i++){
                    if(cursos[i].querySelector('#estado').innerHTML != 'Activo: Sí'){
                        //if('Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){
                            cursos[i].style.display = 'none';
                        //}
                    }
                    else{
                        if('Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){
                            cursos[i].style.display = 'none';
                        }
                        else{
                            cursos[i].style.display = 'inline';
                        }
                    }
                }
            }

        }

        if( !$('.checkTerminado').is(':checked') && !$('.checkActivo').is(':checked') && !date1.value && !date2.value){//SI NO SELECCIONA NINGÚN CHECKBOX
            //terminados activado y sin rangos de fecha
            if(document.getElementById("cats").value == 'Todas'){//TODAS LAS CATEGORÍAS
                for(var i=0; i<cursos.length; i++){
                    cursos[i].style.display = 'inline';
                }
            }
            else{
                for(var i=0; i<cursos.length; i++){// NINGUNA CATEGORÍA

                    if('Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){
                        cursos[i].style.display = 'none';
                    }
                    else{
                        cursos[i].style.display = 'inline';
                    }
                }
            }

        }

        if( !$('.checkTerminado').is(':checked') && !$('.checkActivo').is(':checked') && !!date1.value && !!date2.value){// NINGÚN CHECKBOX Y UN RANGO DE FECHAS
            //terminados activado y sin rangos de fecha

            if(date1.value < date2.value){
                
                for(var i=0; i<cursos.length; i++){
                    const d = cursos[i].querySelector('#fech').innerHTML;

                    if( !(Date.parse(d) > Date.parse(date1.value)) && !(Date.parse(d) < Date.parse(date2.value))){
                        cursos[i].style.display = 'none';
                    }
                    else if( (Date.parse(d) < Date.parse(date1.value)) && (Date.parse(d) < Date.parse(date2.value))){
                        cursos[i].style.display = 'none';
                    }
                    else if( (Date.parse(d) > Date.parse(date1.value)) && (Date.parse(d) > Date.parse(date2.value))){
                        cursos[i].style.display = 'none';
                    }
                    else if(document.getElementById("cats").value == 'Todas'){
                        cursos[i].style.display = 'inline';
                    }
                    else if('Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){
                        cursos[i].style.display = 'none';
                    }
                    else{
                        cursos[i].style.display = 'inline';
                    }
                }
                
            }
            else{
                alert('La primera fecha no puede ser menor que la segunda')
            }
        }

        if( $('.checkTerminado').is(':checked') && !$('.checkActivo').is(':checked') && !!date1.value && !!date2.value){// TERMINADOS Y UN RANGO DE FECHAS
            //terminados activado y sin rangos de fecha

            if(date1.value < date2.value){
                
                for(var i=0; i<cursos.length; i++){
                    const d = cursos[i].querySelector('#fech').innerHTML;
                    //cursos[i].querySelector('#fin').innerHTML != 'Finalización: Aún en curso'
                    if(cursos[i].querySelector('#fin').innerHTML == 'Finalización: Aún en curso'){
                        cursos[i].style.display = 'none';
                    }
                    else if( !(Date.parse(d) > Date.parse(date1.value)) && !(Date.parse(d) < Date.parse(date2.value))){
                        cursos[i].style.display = 'none';
                    }
                    else if( (Date.parse(d) < Date.parse(date1.value)) && (Date.parse(d) < Date.parse(date2.value))){
                        cursos[i].style.display = 'none';
                    }
                    else if( (Date.parse(d) > Date.parse(date1.value)) && (Date.parse(d) > Date.parse(date2.value))){
                        cursos[i].style.display = 'none';
                    }
                    else if(document.getElementById("cats").value == 'Todas'){
                        cursos[i].style.display = 'inline';
                    }
                    else if('Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){
                        cursos[i].style.display = 'none';
                    }
                    else{
                        cursos[i].style.display = 'inline';
                    }
                }
                
            }
            else{
                alert('La primera fecha no puede ser menor que la segunda')
            }
        }

        if( !$('.checkTerminado').is(':checked') && $('.checkActivo').is(':checked') && !!date1.value && !!date2.value){// TERMINADOS Y UN RANGO DE FECHAS
            //terminados activado y sin rangos de fecha

            if(date1.value < date2.value){
                
                for(var i=0; i<cursos.length; i++){
                    const d = cursos[i].querySelector('#fech').innerHTML;
                    //cursos[i].querySelector('#fin').innerHTML != 'Finalización: Aún en curso'
                    if(cursos[i].querySelector('#estado').innerHTML != 'Activo: Sí'){
                        cursos[i].style.display = 'none';
                    }
                    else if( !(Date.parse(d) > Date.parse(date1.value)) && !(Date.parse(d) < Date.parse(date2.value))){
                        cursos[i].style.display = 'none';
                    }
                    else if( (Date.parse(d) < Date.parse(date1.value)) && (Date.parse(d) < Date.parse(date2.value))){
                        cursos[i].style.display = 'none';
                    }
                    else if( (Date.parse(d) > Date.parse(date1.value)) && (Date.parse(d) > Date.parse(date2.value))){
                        cursos[i].style.display = 'none';
                    }
                    else if(document.getElementById("cats").value == 'Todas'){
                        cursos[i].style.display = 'inline';
                    }
                    else if('Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){
                        cursos[i].style.display = 'none';
                    }
                    else{
                        cursos[i].style.display = 'inline';
                    }
                }
                
            }
            else{
                alert('La primera fecha no puede ser menor que la segunda')
            }
        }
        /*
        if( !$('.checkTerminado').is(':checked') && $('.checkActivo').is(':checked')){
            
            for(var i=0; i<cursos.length; i++){
                if(cursos[i].querySelector('#fin').innerHTML != 'Finalización: Aún en curso' && document.getElementById("cats").value == 'Todas'){
                    cursos[i].style.display = 'none';
                }
                else{
                    cursos[i].style.display = 'inline';
                }

                if(cursos[i].querySelector('#fin').innerHTML != 'Finalización: Aún en curso' && 'Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){
                    cursos[i].style.display = 'none';
                }
                else{
                    cursos[i].style.display = 'inline';
                }
            }

        }*/
        /*if( $('.checkTerminado').is(':checked') && !$('.checkActivo').is(':checked') && document.getElementById("cats").value == 'Todas'){
            for(var i=0; i<cursos.length; i++){


                //if($('#fin').text() === 'Finalización: Aún no se comienza'){
                if(cursos[i].querySelector('#fin').innerHTML == 'Finalización: Aún en curso'){

                    
                    //document.getElementById("mssgDate").style.visibility = 'hidden';
                    cursos[i].style.display = 'none';
                }
                else{
                    cursos[i].style.display = 'inline';
                }
                
            }                
        }

        if( !$('.checkTerminado').is(':checked') && $('.checkActivo').is(':checked') ){
            for(var i=0; i<cursos.length; i++){


                //if($('#fin').text() === 'Finalización: Aún no se comienza'){
                if(cursos[i].querySelector('#fin').innerHTML != 'Finalización: Aún en curso' && 'Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){

                    
                    //document.getElementById("mssgDate").style.visibility = 'hidden';
                    cursos[i].style.display = 'none';
                }
                else{
                    cursos[i].style.display = 'inline';
                }
                /*
                if(cursos[i].querySelector('#fin').innerHTML != 'Finalización: Aún en curso' && document.getElementById("cats").value == 'Todas'){

                //document.getElementById("mssgDate").style.visibility = 'hidden';
                cursos[i].style.display = 'none';
                }
                else{
                cursos[i].style.display = 'inline';
                }*--/
                
            }                
        }*/
        /*
        if( !$('.checkTerminado').is(':checked') && $('.checkActivo').is(':checked') && document.getElementById("cats").value != 'Todas'){
            for(var i=0; i<cursos.length; i++){

                console.log('Categoría: ' + document.getElementById("cats").value)
                //if($('#fin').text() === 'Finalización: Aún no se comienza'){
                if('Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){

                    
                    //document.getElementById("mssgDate").style.visibility = 'hidden';
                    cursos[i].style.display = 'none';
                }
                else{
                    cursos[i].style.display = 'inline';
                }
                
            }                
        }

        if( $('.checkTerminado').is(':checked') && !$('.checkActivo').is(':checked') && document.getElementById("cats").value != 'Todas'){
            for(var i=0; i<cursos.length; i++){

                console.log('Categoría: ' + document.getElementById("cats").value)
                //if($('#fin').text() === 'Finalización: Aún no se comienza'){
                if('Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){

                    
                    //document.getElementById("mssgDate").style.visibility = 'hidden';
                    cursos[i].style.display = 'none';
                }
                else{
                    cursos[i].style.display = 'inline';
                }
                
            }                
        }

        if( !$('.checkTerminado').is(':checked') && !$('.checkActivo').is(':checked') && document.getElementById("cats").value != 'Todas'){
            for(var i=0; i<cursos.length; i++){

                console.log('Categoría: ' + document.getElementById("cats").value)
                //if($('#fin').text() === 'Finalización: Aún no se comienza'){
                if('Categoría: ' + document.getElementById("cats").value != cursos[i].querySelector('#NomCat').innerHTML){
                    //document.getElementById("mssgDate").style.visibility = 'hidden';
                    cursos[i].style.display = 'none';
                }
                else{
                    cursos[i].style.display = 'inline';
                }
                
            }                
        }*/
        //$('.CursosContenedor').html('');

    }

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

const date1 = document.getElementById('fecha1');
const date2 = document.getElementById('fecha2');

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