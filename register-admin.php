<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/register-admin.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <title>Udemy Administrador</title>
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
                <form action="log-in-admin.php">
                    <button class="Log-in-button">Iniciar sesión</button>
                </form>
                
                <button class="Register-button">Regístrate</button>
            </div>
        </header>

        <main>
           <div class="log-in-box">
                <p style="font-weight: bold;">Regístrate como administrador</p>
                <form class="log-in-form">
                    <input id="user-input" type="text" placeholder="Nombre"> <br> 
                    <span class="mssgName" id="mssgName">Error en el Nombre</span>
                    <input id="apellidoP-input" type="text" placeholder="Apellido paterno"> <br> 
                    <span class="mssgAP" id="mssgAP">Error en el apellido Paterno</span>
                    <input id="apellidoM-input" type="text" placeholder="Apellido materno"> <br> 
                    <span class="mssgAM" id="mssgAM">Error en el apellido Materno</span>
                    <input id="email-input" type="email" placeholder="Email"> <br>
                    <span class="mssgEmail" id="mssgEmail">Formato incorrecto de email</span>
                    <input id="password-input" type="password" placeholder="Contraseña"> <br>
                    <span class="mssgPass" id="mssgPass">Formato incorrecto de contraseña</span>
                    <br>
                    
                    
                    <!--<button>Regístrate</button> <br>-->
                    <input class="registro" type="button" value="Registrarse" onclick="register()">
                    <a>¿Ya tienes una cuenta?</a> <br>
                    <a href="log-in.php">Registrarse</a>
                </form>
           </div>
            <h2></h2>
        </main>
        <footer>
            <p>Enseña en Udemy</p>
            <p>©FCFM</p>
            <span id="respuesta" name="respuesta"></span>
        </footer>
    </body>
    <script>
        function register(){
            var name, MLastName, FLastName, email, pass, birth, logo, gender;

            name = document.getElementById("user-input").value;
            FLastName = document.getElementById("apellidoP-input").value;
            MLastName = document.getElementById("apellidoM-input").value;
            email = document.getElementById("email-input").value;
            pass = document.getElementById("password-input").value;

            var rePass = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            var reEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
            var reName = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;


            if(reName.test(name) && reName.test(FLastName) && reName.test(MLastName) && reEmail.test(email) && rePass.test(pass)){

                var form_data = new FormData();                  // Creating object of FormData class             // Appending parameter named file with properties of file_field to form_data
                form_data.append("user_id", 123);                 // Adding extra parameters to form_data
                form_data.append("mlast", MLastName);
                form_data.append("ema", email);
                form_data.append("pas", pass);
                form_data.append("nam", name);   
                form_data.append("flast", FLastName);
                form_data.append("type", 'register');  

                $.ajax({
                    url: "rest/apiRegisterAdmin.php",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         // Setting the data attribute of ajax with file_data
                    type: 'post',
                    error: function(xhr, status, error) {
                        // there was an error
                        alert('Este ususario ya está registrado');
                    }
                })
                .done(function(res){
                    //$('#respuesta').html(res);
                    //console.log(res);
                    alert('Usuario registrado exitosamente')
                    //alert(res);
                    //location.href = 'http://localhost/BDMM/log-in-admin.php';
                        
                })
                .fail(function(){
                    console.log('error');
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
            if(!rePass.test(pass)){
                document.getElementById("mssgPass").style.visibility = 'visible';
            }
            else{
                document.getElementById("mssgPass").style.visibility = 'hidden';
            }

            if(!reEmail.test(email)){
                document.getElementById("mssgEmail").style.visibility = 'visible';
            }
            else{
                document.getElementById("mssgEmail").style.visibility = 'hidden';
            }
        }

        
        function convertBlob(){
            var pic = $("#profileImage").prop('files')[0];


            var x = 2;
            var y = 2;
            var z = x + y;
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