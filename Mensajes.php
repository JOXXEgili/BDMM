<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/Mensajes.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <title>Udemy</title>
    </head>
    <body>
        <header>
            <div class="left-nav">
                <img id="logo" src="img/udemy-logo.png">
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
                         <img src="img/lupa.png" onclick="location.href='busqueda.html'">
                    </form>
                </div>
                
                
            </div>
            <div class="right-nav">
                
            </div>
        </header>

        <div class="mensajes">
            <h1>Mensajes</h1>
            <h3>Tienes 0 mensajes sin leer</h3>
            
        </div>
        <div class="inbox" id='respuesta' name='respuesta'>
            
        <!--
            <div class="inbox-container">
                <img src="img/zuko.jpg">
                <h3>Geralt de Rivia</h3>
                <p>Hola Gilberto, gracias por comprar mi curso...</p>
            </div>
            <div class="inbox-container">
                <img src="img/stock.jpg">
                <h3>Jack Conrad</h3>
                <p>Felicidades por acabar el curso...</p>
            </div-->
            
        </div>
        <div class="chat">
            <h2 id='nombre'></h2>
            <div id='mensajes'>
            </div>
            <textarea id='msg' placeholder="Revisa la sección de preguntas y respuestas del curso abtes de enviar tu mensaje."></textarea>
            <button onclick="send()">Enviar</button>
        </div>
       
        
    </body>
    <footer>
        <p>Enseña en Udemy</p>
        <p>©FCFM</p>
    </footer>
    <script>

        var currentInbox;
        
        //var remitente = document.getElementById("apellidoP-input").value;

        var form_data = new FormData();                  // Creating object of FormData class
        form_data.append("action", '3');            // Appending parameter named file with properties of file_field to form_data
        form_data.append("msg", msg);
        //form_data.append("remitente", 'misa2_09raya2@hotmail.com');

        $.ajax({
            url: "rest/Chat/savesMessages.php",
            dataType: 'script',
             cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         // Setting the data attribute of ajax with file_data
            type: 'post'
        })
        .done(function(res){
            $('#respuesta').html(res);
            console.log(res);
            //location.href = 'http://localhost/BDMM/Perfil.php';
        })
        .fail(function(){
            console.log('error');
        })
        .always(function(){
            console.log('complete');
        })
        
        setInterval(refreshMessages, 300);
        function refreshMessages() {
            var form_data = new FormData();                
            form_data.append("action", '1');           
            form_data.append("remitente", currentInbox);
            if(currentInbox != '' && currentInbox != null){

                $.ajax({
                url: "rest/Chat/savesMessages.php",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         // Setting the data attribute of ajax with file_data
                type: 'post'
            })
            .done(function(res){
                    $('#mensajes').html(res);
                    //location.href = 'http://localhost/BDMM/Perfil.php';
                })
                .fail(function(){
                    console.log('error');
                })
                .always(function(){
                    console.log('complete');
                })
            }
        }

        function send(){

            if(currentInbox != null && currentInbox != ''){

                var msg = document.getElementById("msg").value;

                var form_data = new FormData();                  // Creating object of FormData class
                form_data.append("action", '2');            // Appending parameter named file with properties of file_field to form_data
                form_data.append("remitente", currentInbox);
                form_data.append("msg", msg);
                
                $.ajax({
                    url: "rest/Chat/savesMessages.php",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         // Setting the data attribute of ajax with file_data
                    type: 'post'
                })
                .done(function(res){
                    //$('#respuesta').html(res);
                    console.log('Mensaje enviado');
                    //location.href = 'http://localhost/BDMM/Perfil.php';
                    document.getElementById("msg").value = '';
                })
                .fail(function(){
                    console.log('error');
                })
                .always(function(){
                    console.log('complete');
                })
                //alert(currentInbox);*/
            }
        }

        function getDataInbox(e, id){
            /*
            document.addEventListener('click', function(e) {
                e = e || window.event;
                var target = e.target || e.srcElement,
                    text = target.textContent || target.innerText; 
                    sessionStorage.setItem("msgTo", text);
                    $('#nombre').html(text);  
            }, false);*/
            var txt = $(e.target).text();
            $('#nombre').html(txt);
            currentInbox = id;
        }
        
    </script>
</html>