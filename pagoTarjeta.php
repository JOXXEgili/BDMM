<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/PagoTarjeta.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <title>Udemy</title>
        
        <script>
        </script>
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

        <main class='d-flex justify-content-center'>
           <div class="log-in-box">
                <h2 style="font-weight: bold;">Pago con tarjeta</h2>
                <br>    
                <form class="log-in-form">
                    <input id="card-number" type="text" placeholder="Número de la tarjeta"> <br> 
                    <span class="mssgName" id="mssgName">Error en el número de la tarjeta</span>
                    <br>
                    <div class='fecha d-flex justify-content-center'>
                    <label id="month-label">Mes<select id="month-input">
                        <option>01</option>
                        <option>02</option>
                        <option>03</option>
                        <option>04</option>
                        <option>05</option>
                        <option>06</option>
                        <option>07</option>
                        <option>08</option>
                        <option>09</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                    </select> </label>

                    <label id="year-label">Año<select id="year-input">
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                        <option value="2032">2032</option>
                        <option value="2033">2033</option>
                        <option value="2034">2034</option>
                        <option value="2035">2035</option>
                        <option value="2036">2036</option>
                        <option value="2037">2037</option>
                        <option value="2038">2038</option>
                        <option value="2039">2039</option>
                        <option value="2040">2040</option>
                        <option value="2041">2041</option>
                        <option value="2042">2042</option>
                        <option value="2043">2043</option>
                    </select> </label> <br>
                    </div>
                    <br>
                    <div class='cvv'>
                        <input id="cvv" type="number" max='999' placeholder="CVV"> <br> 
                        <span class="mssgCVV" id="mssgCVV">Error en el cvv</span>
                    </div>
                    
                    <!--<button>Regístrate</button> <br>-->
                    <input class="registro" type="button" value="PAGAR" onclick="register()">
                </form>
           </div>
            
            <h2></h2>
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

        function register(){

            var e = sessionStorage.getItem("email");
            var number, cvv;

            number = document.getElementById("card-number").value;
            cvv = document.getElementById("cvv").value;

            year = document.getElementById("year-input").value;
            month = document.getElementById("month-input").value;

            var reNumber = /^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/;
            var reCVV = /^[0-9]{3}$/;

            if(reNumber.test(number) && reCVV.test(cvv)){
                document.getElementById("mssgName").style.visibility = 'hidden';
                document.getElementById("mssgCVV").style.visibility = 'hidden';
                const d = new Date();
                let month2 = d.getMonth();
                let year2 = d.getFullYear();
                month2 = month2 + 1;

                if((month > month2 && year == year2) || year > year2){
                    var lvl = sessionStorage.getItem('lvl');
                    if(lvl != null){

                        var form_data = new FormData();                  // Creating object of FormData class
                        form_data.append("nivel", lvl);
                        form_data.append("Tipo", 'tarjeta'); 

                        console.log(lvl);

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
                            sessionStorage.setItem('lvl', null);
                            location.href = 'http://localhost/dashboard/BDMM/Kardex.php';
                        })
                        .fail(function(e){
                            console.log(e);
                        })
                        .always(function(){
                            console.log('complete');
                        })
                    }
                    else{
                        var form_data = new FormData();                  // Creating object of FormData class
                        form_data.append("nivel", '0');
                        form_data.append("Tipo", 'tarjeta'); 
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
                else{
                    alert('La fecha está vencida');
                }
            }

            if(!reNumber.test(number)){
                document.getElementById("mssgName").style.visibility = 'visible';
            }
            else{
                document.getElementById("mssgName").style.visibility = 'hidden';
            }

            if(!reCVV.test(cvv)){   
                document.getElementById("mssgCVV").style.visibility = 'visible';
            }
            else{
                document.getElementById("mssgCVV").style.visibility = 'hidden';
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