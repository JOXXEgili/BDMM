<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/log-in.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <title>Udemy</title>

        <script>
            var contador = 0;
            function login(){
                var user, pass;
                user = document.getElementById("user-input").value;
                pass = document.getElementById("password-input").value;
                sessionStorage.setItem("email2", 'hola');
                //var re = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

                var form_data = new FormData();                  // Creating object of FormData class
                form_data.append("user", user);              // Appending parameter named file with properties of file_field to form_data
                form_data.append("pass", pass);                 // Adding extra parameters to form_data

                $.ajax({
                    url: "rest/apiLogin.php",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         // Setting the data attribute of ajax with file_data
                    type: 'post',
                    error: function(){
                        alert('La contraseña y/o el correo no coinciden');
                    }
                })
                .done(function(res){
                    sessionStorage.setItem("email", res);
                    location.href = 'http://localhost/BDMM/Perfil.php';
                    //sessionStorage.setItem("email", res);
                    alert(res);
                })
                .fail(function(){
                    //console.log('error');
                })
                .always(function(){
                    console.log('complete');
                })
                /*
                if(user != "" && re.test(pass)){
                    window.location ="Perfil.html"
                }
                else{
                    contador++;
                    console.log(contador)
                }
                
                if(user === ""){
                    document.getElementById("mssgUser").style.visibility = 'visible';
                }
                
                if(!re.test(pass)){
                    document.getElementById("mssgPass").style.visibility = 'visible';
                }
                if(contador === 3){
                    alert('Su cuenta ha sido bloqueada')
                    contador = 0;
                }*/
                
            }
        </script>
    </head>
    <body>
        <header>
            <div class="left-nav">
                <a href="index.html"><img id="logo" src="img/udemy-logo.png"></a>
                    
                <div class="dropdown-categories">
                    <button class="categories-button">Categorías</button>
                    <div class="dropdown-categories-content">
                        <il>
                            <li><button>Programación web</button></li>
                            <li><button>Marketing</button></li>
                            <li><button>Diseño</button></li>
                        </il>
                    </div> 

                </div>
                
            </div>
            
            <div class="center-nav">
                <div class="search-box">
                    <form>
                        
                         <input type="text" placeholder="Buscar cualquier cosa">
                         <img src="img/lupa.png">
                    </form>
                </div>
                
                
            </div>
            <div class="right-nav">
                <form action="log-in.php">
                    <button class="Log-in-button">Iniciar sesión</button>
                </form>
                
                <form action="register.php">
                    <button class="Register-button">Regístrate</button>
                </form>
            </div>
        </header>

        <main>
           <div class="log-in-box">
                <p style="font-weight: bold;">Inicia sesión en tu cuenta de Udemy</p>
                <form class="log-in-form" method="post">
                    <!--<label id="user-label">Usuario</label> <br>-->
                    <input id="user-input" type="text" placeholder="Usuario" required> <br> 
                    <span class="mssgUser" id="mssgUser">Error en Usuario</span>
                    <!--<label id="password-label">Contraseña</label> <br>-->
                    <input id="password-input" type="password" placeholder="Contraseña" required> <br>
                    <span class="mssgPass" id="mssgPass">Contraseña incorrecta</span>
                    <input class="ingresar" type="button" value="Iniciar sesión" onclick="login()">
                    <!--<button type="submit" onclick="location.href='Kardex.html'">Iniciar sesión</button> <br>-->
                    <!--<a href="url">He olvidado mi Contraseña</a> <br>
                    <a href="register.html">Regístrate</a>-->
                    <p>
                        <a>¿No tienes una cuenta?</a>
                        <a href="register.php">Regístrate</a>
                    </p>

                </form>
           </div>
            
            <h2></h2>
        </main>
        <footer>
            <p>Enseña en Udemy</p>
            <p>©FCFM</p>

        </footer>
    </body>
    
</html>