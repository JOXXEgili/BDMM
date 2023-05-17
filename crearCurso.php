<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/crearCurso.css">
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
        <div id='categoria' class=" justify-content-center">
            <h2>CREACIÓN DE CATEGORÍAS</h2>
            <div class="d-flex justify-content-center">
                <input type="text" id='cat' placeholder='Ingrese una nueva categoría'>
                <input type="text" id='catDesc' placeholder='Cree una descripción'>
                <button id='crearCat' onclick='categoria()'>Aceptar</button>
            </div>

        </div></div>
        <main class="d-flex justify-content-center">
            <div class='lvls' id='respuesta'>
                <H1>CREA TU CURSO AHORA MISMO</H1>
                <input type="text" id='titulo' placeholder='Titulo'>
                <br>
                <div class='desc d-flex justify-content-center'>
                    <textarea type="text" placeholder='Descripción' id = 'desc' class='descTxt'></textarea>
                    <div>
                    <label for="">Ingrese el costo por el curso completo<input type="number" id = 'precioTotal' required name="price" min="0" value="0" step=".01"></label>
                    <label >Adjunte su miniatura<input type='file' name='myImage' id='miniatura' accept='image/png, image/gif, image/jpeg' /></label>
                    <br>
                    <label class='labelCat' for="">Categoría <select name="categorias" id="categorias" class='precio'>
                        <?php 
                            $query = "SELECT ID_categoria, Nombre, Estado FROM categorias WHERE Estado = 1 GROUP BY ID_categoria ASC";
                            $resultado = $conn->query($query);
                        while($data = $resultado->fetch(PDO::FETCH_ASSOC)){
                            echo '<option value="'. $data['Nombre'] .'">'. $data['Nombre'] . '</option>';
                        }
                        ?>
                            <!--option value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option-->
                        </select></label>
                    </div>
                </div>
                <br>
                <div id='add_to_me'>
                <div class="lvl" >
                    <h2>Nivel 1</h2>
                    <textarea class='inst' placeholder='Ingrese instrucciones, consejos, datos, opciones, etc.'></textarea>
                    <div class='info d-flex justify-content-center'>
                        <label >Adjunte un pdf<input name='userfile' class='pdf' type='file' accept='application/pdf' /></label>
                        <label >Adjunte una imágen<input type='file' name='myImage' class='img' accept='image/png, image/gif, image/jpeg' /></label>
                    </div>
                    <div  class='info d-flex justify-content-center'>        
                        <label for="">Descripción<input class='descripcion' id = 'desc2' type="text" placeholder='Ingrese a grandes razgos de lo que trata este nivel'></label>
                    </div>
                    <div  class='info d-flex justify-content-center'>        
                        <label >Adjunte un video*<input type='file' name='myVide' class='vid' accept='video/mp4,video/x-m4v,video/*'></label>
                        <label class='precio'>Ingrese el costo del nivel<input type='number' class='costoNivel' required name='price' min='0' value='0' step='.01'></label>
                    </div>
                </div>
                </div>
                <button class='agg' onclick='agregar()'>Agregar otro nivel</button>
                <br>
                <button class='aceptar' onclick='publicar()'>Pública tu curso ahora mismo</button>
            </div>
        </main>
</body>
<script>

    function categoria(){

        cat = document.getElementById("cat").value;
        catDesc = document.getElementById("catDesc").value;

        if(cat != '' && catDesc != ''){
            var form_data = new FormData();                  // Creating object of FormData class
            form_data.append("cat", cat);
            form_data.append("catDesc", catDesc); 

            $.ajax({
                url: "rest/CrearCategoria.php",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         // Setting the data attribute of ajax with file_data
                type: 'post',
                error: function(xhr, status, error) {
                }
            })
            .done(function(res){
                alert('Registro exitoso');
                //location.href = 'http://localhost/BDMM/crearCurso.php';
            })
            .fail(function(e){
                alert('Ya hay una categoría con este nombre')
                console.log(e);
            })
            .always(function(){
                console.log('complete');
            })
        }
    }

    function agregar(){

        var lvlList = document.querySelectorAll('.lvl');
        var count = 1;

        for(var i=0; i<lvlList.length; i++){
            count ++;
        }



        document.getElementById("add_to_me").innerHTML +=
            "<div class='lvl' ><h2>Nivel " + count + "</h2><textarea class='inst' placeholder='Ingrese instrucciones, consejos, datos, opciones, etc.'></textarea><div class='info d-flex justify-content-center'><label >Adjunte un pdf<input name='userfile' type='file' class='pdf' accept='application/pdf' /></label><label >Adjunte una imágen<input type='file' class='img' name='myImage' accept='image/png, image/gif, image/jpeg' /></label></div><div  class='info d-flex justify-content-center'><label for=''>Descripción<input class='descripcion' id = 'desc2' type='text' placeholder='Ingrese a grandes razgos de lo que trata este nivel'></label></div><div  class='info d-flex justify-content-center'><label >Adjunte un video*<input type='file' name='myVide' class='vid' accept='video/mp4,video/x-m4v,video/*'></label><label class='precio'>Ingrese el costo del nivel<input type='number' class='costoNivel' required name='price' min='0' value='0' step='.01'></label></div></div>";

    }

    function publicar(){

        var check = true;
        var titulo, desc, precioTotal, desc2;
        //var insts=[];// pdfs, imgs, vids, costosNivel;
        //var pdfs=[];

        var answer='';


        var form_data = new FormData(); 

        titulo = document.getElementById("titulo").value;
        cat = document.getElementById("categorias").value;
        desc = document.getElementById("desc").value;
        //desc2 = document.getElementById("desc2").value;
        precioTotal = document.getElementById("precioTotal").value;
        miniatura = document.getElementById("miniatura").files[0];
        //var miniatura2 = $("#miniatura").prop("files")[0];  

        //console.log(miniatura);

        if(titulo === '' || desc === '' || parseFloat(precioTotal) === 0 || document.getElementById("miniatura").files.length == 0){
            answer += "El titulo, la descripción y el precio total del curso no pueden estar vacíos\n\n";
            check = false;
        }
        else{

            var lvlList = document.querySelectorAll('.lvl');
            for(var i=0; i<lvlList.length; i++){
                if(lvlList[i].querySelector('.vid').files.length === 0 && lvlList[i].querySelector('#desc2').value != ''){
                    answer += 'Al menos debe haber un video por nivel y es obligatorio poner una descripción para el nivel';
                    check = false;
                }
            }

            if(check){
                                // Creating object of FormData class
                form_data.append("action", '1');
                form_data.append("miniatura", miniatura);
                form_data.append("titulo", titulo);              // Appending parameter named file with properties of file_field to form_data
                form_data.append("desc", desc);                 // Adding extra parameters to form_data
                form_data.append("precioTotal", precioTotal);
                $.ajax({
                        url: "rest/apiCrearCurso.php",
                        dataType: 'script',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         // Setting the data attribute of ajax with file_data
                        type: 'post',
                        error: function(xhr, status, error) {
                            alert('Ocurrió un error\n\n')
                        }
                })
                .done(function(res){
                        //alert('Curso publicado exitosamente');
                        //$('#respuesta').html(res);
                        //location.href = 'http://localhost/BDMM/Perfil.php';
                                    
                })
                .fail(function(){
                    console.log('error');
                })
                .always(function(){
                    console.log('complete');
                })
            }
        

            for(var i=0; i<lvlList.length; i++){
                /*console.log(lvlList[i].querySelector('.inst').value);
                console.log(lvlList[i].querySelector('.pdf').value);
                console.log(lvlList[i].querySelector('.img').value);
                console.log(lvlList[i].querySelector('.vid').value);
                console.log(lvlList[i].querySelector('.costoNivel').value);*/

                //insts.push(lvlList[i].querySelector('.inst').value);
                //lvlList[i].querySelector('.pdf').files[0];
                //imgs.push(lvlList[i].querySelector('.img').files[0]);
                //vids.push(lvlList[i].querySelector('.vid').files[0]);
                //precioNivel.push(lvlList[i].querySelector('.costoNivel').value)
                if(check){
                    
                    var id = i + 1;
                    var insts = lvlList[i].querySelector('.inst').value;
                    var pdf = lvlList[i].querySelector('.pdf').files[0];
                    var vid = lvlList[i].querySelector('.vid').files[0];
                    var img = lvlList[i].querySelector('.img').files[0];
                    var precioNivel = lvlList[i].querySelector('.costoNivel').value;
                    desc2 = lvlList[i].querySelector('#desc2').value;

                    /*console.log(id);
                    console.log(insts);
                    console.log(pdf);*/
                    form_data.set("action", "2");
                    form_data.set("id", id);
                    form_data.set("insts", insts);
                    form_data.set("pdfs", pdf);
                    form_data.set("imgs", img);
                    form_data.set("vids", vid);
                    form_data.set("precioNivel", precioNivel);
                    form_data.set("descripcion2", desc2);
                    form_data.set("cat", cat);
                    /*form_data.append("imgs", imgs);   
                    form_data.append("vids", vids);   
                    form_data.append("precioNivel", precioNivel);*/ 

                    $.ajax({
                        url: "rest/apiCrearCurso.php",
                        dataType: 'script',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         // Setting the data attribute of ajax with file_data
                        type: 'post',
                        error: function(xhr, status, error) {
                            // there was an error
                            alert('Ocurrió un error\n\n')
                        }
                    })
                    .done(function(res){
                        //$('#respuesta').html(res);
                        //console.log(res);
                        answer += 'Curso publicado exitosamente\n\n';
                        //alert(res);
                        //location.href = 'http://localhost/BDMM/Perfil.php';
                            
                    })
                    .fail(function(){
                        console.log('error');
                    })
                    .always(function(){
                        console.log('complete');
                    })
                    answer += 'Curso publicado exitosamente\n\n';
                }
            }
        }

        
        alert(answer);
        
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
</script>
</html>