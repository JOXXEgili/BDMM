<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Chatear</title>
  <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'-->
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

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
                    $page2 = 'Mis cursos';
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
                echo '                <form action="log-in.php" id="botones">
                <button class="Log-in-button">Iniciar sesión</button>
            </form>
            <form action="register.php" id="botones">
                <button class="Register-button">Regístrate</button>
            </form>';
            }

            ?>
                
            </div>
        </header>
        <body2 class='body2'>
<!-- partial:index.partial.html -->
<div class="container clearfix">
    <div class="people-list" id="people-list">
      <div class="search" style='display:flex;'>
      <img src="img/lupa.png" onclick="users()" style='width:40px; cursor:pointer;'>
        <input type="text" placeholder="buscar" id='findUser' />
        <i class="fa fa-search"></i>
      </div>
      <ul class="list" id='respuesta' name='respuesta'>
        <!--li class="clearfix">
          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Vincent Porter</div>
            <div class="status">
              <i class="fa fa-circle online"></i> online
            </div>
          </div>
        </li>
        
        <li class="clearfix">
          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_02.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Aiden Chavez</div>
            <div class="status">
              <i class="fa fa-circle offline"></i> left 7 mins ago
            </div>
          </div>
        </li>
        
        <li class="clearfix">
          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_03.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Mike Thomas</div>
            <div class="status">
              <i class="fa fa-circle online"></i> online
            </div>
          </div>
        </li>
        
        <li class="clearfix">
          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_04.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Erica Hughes</div>
            <div class="status">
              <i class="fa fa-circle online"></i> online
            </div>
          </div>
        </li>
        
        <li class="clearfix">
          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_05.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Ginger Johnston</div>
            <div class="status">
              <i class="fa fa-circle online"></i> online
            </div>
          </div>
        </li>
        
        <li class="clearfix">
          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_06.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Tracy Carpenter</div>
            <div class="status">
              <i class="fa fa-circle offline"></i> left 30 mins ago
            </div>
          </div>
        </li>
        
        <li class="clearfix">
          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_07.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Christian Kelly</div>
            <div class="status">
              <i class="fa fa-circle offline"></i> left 10 hours ago
            </div>
          </div>
        </li>
        
        <li class="clearfix">
          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_08.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Monica Ward</div>
            <div class="status">
              <i class="fa fa-circle online"></i> online
            </div>
          </div>
        </li>
        
        <li class="clearfix">
          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_09.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Dean Henry</div>
            <div class="status">
              <i class="fa fa-circle offline"></i> offline since Oct 28
            </div>
          </div>
        </li>
        
        <li class="clearfix">
          <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_10.jpg" alt="avatar" />
          <div class="about">
            <div class="name">Peyton Mckinney</div>
            <div class="status">
              <i class="fa fa-circle online"></i> online
            </div>
          </div>
        </li-->
      </ul>
    </div>
    
    <div class="chat">
      <div class="chat-header clearfix">
        <img style='  width: 50px;height: 50px;border-radius: 50px;' id='avatar2' src="" alt="avatar" />
        
        <div class="chat-about">
          <div class="chat-with" id='nombre'></div>
          <div class="chat-num-messages" id='l'></div>
        </div>
        <i class="fa fa-star"></i>
      </div> <!-- end chat-header -->
      
      <div class="chat-history" id='mensajes'>
        <ul>
          <!--li class="clearfix">
            <div class="message-data align-right">
              <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp;
              <span class="message-data-name" >Olia</span> <i class="fa fa-circle me"></i>
              
            </div>
            <div class="message other-message float-right">
              Hi Vincent, how are you? How is the project coming along?
            </div>
          </li>
          
          <li>
            <div class="message-data">
              <span class="message-data-name"><i class="fa fa-circle online"></i> Vincent</span>
              <span class="message-data-time">10:12 AM, Today</span>
            </div>
            <div class="message my-message">
              Are we meeting today? Project has been already finished and I have results to show you.
            </div>
          </li>
          
          <li class="clearfix">
            <div class="message-data align-right">
              <span class="message-data-time" >10:14 AM, Today</span> &nbsp; &nbsp;
              <span class="message-data-name" >Olia</span> <i class="fa fa-circle me"></i>
              
            </div>
            <div class="message other-message float-right">
              Well I am not sure. The rest of the team is not here yet. Maybe in an hour or so? Have you faced any problems at the last phase of the project?
            </div>
          </li>
          
          <li>
            <div class="message-data">
              <span class="message-data-name"><i class="fa fa-circle online"></i> Vincent</span>
              <span class="message-data-time">10:20 AM, Today</span>
            </div>
            <div class="message my-message">
              Actually everything was fine. I'm very excited to show this to our team.
            </div>
          </li>
          
          <li>
            <div class="message-data">
              <span class="message-data-name"><i class="fa fa-circle online"></i> Vincent</span>
              <span class="message-data-time">10:31 AM, Today</span>
            </div>
            <i class="fa fa-circle online"></i>
            <i class="fa fa-circle online" style="color: #AED2A6"></i>
            <i class="fa fa-circle online" style="color:#DAE9DA"></i>
          </li-->
          
        </ul>
        
      </div> <!-- end chat-history -->
      
      <div class="chat-message clearfix">
        <textarea name="message-to-send" id="msg" placeholder ="Type your message" rows="3"></textarea>
                
        <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
        <i class="fa fa-file-image-o"></i>
        
        <button id='btn' onclick='send()'>Send</button>

      </div> <!-- end chat-message -->
      
    </div> <!-- end chat -->
    
  </div> <!-- end container -->

<script id="message-template" type="text/x-handlebars-template">
  <li class="clearfix">
    <div class="message-data align-right">
      <span class="message-data-time" >{{time}}, Today</span> &nbsp; &nbsp;
      <span class="message-data-name" >Olia</span> <i class="fa fa-circle me"></i>
    </div>
    <div class="message other-message float-right">
      {{messageOutput}}
    </div>
  </li>
</script>

<script id="message-response-template" type="text/x-handlebars-template">
  <li>
    <div class="message-data">
      <span class="message-data-name"><i class="fa fa-circle online"></i> Vincent</span>
      <span class="message-data-time">{{time}}, Today</span>
    </div>
    <div class="message my-message">
      {{response}}
    </div>
  </li>
</script>
<!-- partial -->
  <!--script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.0/handlebars.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js'></script><script  src="./script.js"></script-->
</body2>
</body>
<script>
  document.getElementById("avatar2").hidden = true;
  document.getElementById("msg").hidden = true;
  document.getElementById("btn").hidden = true;
  var currentInbox;

  //var remitente = document.getElementById("apellidoP-input").value;

  var form_data = new FormData();                  // Creating object of FormData class
  form_data.append("action", '3');            // Appending parameter named file with properties of file_field to form_data
  //form_data.append("msg", msg);
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
      //console.log(res);
      console.log('hola');
      //location.href = 'http://localhost/dashboard/BDMM/Perfil.php';
  })
  .fail(function(e){
      console.log(e);
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
              //location.href = 'http://localhost/dashboard/BDMM/Perfil.php';
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
              //location.href = 'http://localhost/dashboard/BDMM/Perfil.php';
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
      var img = document.getElementById("avatar").src;
      $('#nombre').html(txt);
      $('#l').html('Listo para chatear');
      document.getElementById("avatar2").src = img;
      document.getElementById("avatar2").hidden = false;
      document.getElementById("msg").hidden = false;
      document.getElementById("btn").hidden = false;
      currentInbox = id;
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

function users(){

  var user;
  user = document.getElementById('findUser').value;

  var form_data = new FormData();                  // Creating object of FormData class
  form_data.append("action", '4');            // Appending parameter named file with properties of file_field to form_data
  form_data.append("remitente", user);
  form_data.append("msg", 'msg');

  console.log(user);
  
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
    if(res === 'encontrado'){
      location.href = 'http://localhost/dashboard/BDMM/messages.php';
    }
    else{
      alert('Usuario no encontrado');
    }
    
    //document.getElementById("msg").value = '';
  })
  .fail(function(){
    console.log('error');
  })
  .always(function(){
    console.log('complete');
  })
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
</script>
</html>
