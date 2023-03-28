<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/register.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <title>Udemy</title>
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
                <form action="log-in.html">
                    <button class="Log-in-button">Iniciar sesión</button>
                </form>
                
                <button class="Register-button">Regístrate</button>
            </div>
        </header>

        <main>
           <div class="log-in-box">
                <p style="font-weight: bold;">Regístrate y comienza a aprender</p>
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
                    <label id="genre-label">Género</label> <br>
                    <select id="genre-input">
                        <option>H</option>
                        <option>M</option>
                        <option>O</option>
                    </select> 
                    <label id="date-label">Fecha de nacimiento</label> <br>
                    <input id="date-input" type="date"> <br>
                    <span class="mssgDate" id="mssgDate">Ingrese una fecha</span><br>
                    <label id="photo-label">Foto de perfil</label> <br>    
                    <input id="photo-input" type="file" name="images" ref="file">
                    <span class="mssgImg" id="mssgImg">Seleccione una imágen</span>
                    
                    <!--<button>Regístrate</button> <br>-->
                    <input class="registro" type="button" value="Registrarse" onclick="register()">
                    <a>¿Ya tienes una cuenta?</a> <br>
                    <a href="log-in.html">Iniciar sesión</a>
                </form>
           </div>
            <h2></h2>
        </main>
        <footer>
            <p>Enseña en Udemy</p>
            <p>©FCFM</p>
            <p id="respuesta"></p>
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
            birth = document.getElementById("date-input").value;
            logo = document.getElementById("photo-input");
            gender = document.getElementById("genre-input").value;

            var rePass = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            var reEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
            var reName = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;

            console.log(calculateAge(birth));
            console.log("holaS");
            
            var pic = $("#photo-input").prop('files')[0];   


            if(reName.test(name) && reName.test(FLastName) && reName.test(MLastName) && reEmail.test(email) && rePass.test(pass) && logo.files.length != 0 && birth && calculateAge(birth)){
                //window.location ="Perfil.html"

                //var logoBlob = convertBlob();

                var rute = 'nam=' + name + '&flast=' + FLastName + '&mlast=' + MLastName + '&ema=' + email + '&pas=' + pass + '&bir=' + birth + '&log=' + pic + '&gen=' + gender;

                $.ajax({
                    url: 'rest/apiRegister.php',
                    type: 'POST',
                    data: rute,
                })
                .done(function(res){
                    //$('#respuesta').html(res);
                    location.href = 'http://localhost/BDMM/Perfil.php';
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

            if(!logo.files.length != 0){
                document.getElementById("mssgImg").style.visibility = 'visible';
            }
            else{
                document.getElementById("mssgImg").style.visibility = 'hidden';
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

            if(!reEmail.test(email)){
                document.getElementById("mssgEmail").style.visibility = 'visible';
            }
            else{
                document.getElementById("mssgEmail").style.visibility = 'hidden';
            }
        }

        function calculateAge(birthday) { // birthday is a date
            //const date= document.getElementById("currentDate")
                const fecha = new Date(birthday);
                const fecha2 = new Date()
                //var fromato = fecha2.toISOString().split('T')[0];
                var diff = Math.floor((fecha2-fecha)/(24*3600*1000));
                /*if(!birthday.validity.valid){
                    return;
                }*/
                if(!(diff >= 4380)){
                    alert("Necesitas tener al menos 12 años para registrarte");
                    return false;
                }
                else{
                    return true;
                }
        }
        
        function convertBlob(){
            var pic = $("#profileImage").prop('files')[0];


            var x = 2;
            var y = 2;
            var z = x + y;
        }
    </script>
</html>