<%-- 
    Document   : Home
    Created on : 3 dic 2022, 16:49:22
    Author     : Gilberto
--%>
<%@page import="javax.swing.ImageIcon"%>
<%@page import="java.sql.PreparedStatement"%>
<%@page import="com.Form.GetConnection"%>
<%@page import="java.sql.Connection"%>
<%@page import="java.sql.ResultSet"%>
<%@page import="java.awt.Image"%>

<%
    
%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%  
    Object Likes_Query = session.getAttribute("likes");
    Object Query = session.getAttribute("Query");
    Object ID = session.getAttribute("username");
    Object i = session.getAttribute("Load_more");
    int j=0;
    
    if(i == null)
    {
         j = 10;
    }
    else
    {
        j = (Integer) i;
    }
        
    if(ID == null)
        ID = "";
    if(Query == null)
        Query = "SELECT * FROM Post WHERE estado = 1 ORDER BY fechaCreacion DESC";
    Object foto = session.getAttribute("foto");

%>
<!DOCTYPE html>
<html>
    <head>
        <title>PAGINA DE INICIO</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="CSS/Home.css">
    </head>
    <body>
        <script src="JAVASCRIPT/java.js"> </script>
        <nav>
            <div class="nav-left">
                <p><a href="Home.jsp"><img src="img/reddit.png" class="logo"/></a></p>
                
                <ul>
                    <li> <p><a href="Likes.jsp"><img src="img/like.png"></a></p></li>
                    <li> <p><a href="Comments.jsp"><img src="img/comment.png"></a></p></li>
                    <li> <p><a href="Fecha.jsp"><img src="img/recientes.jpg"></a></p></li>
                </ul>          
            </div>
            <div class="nav-right">
                <div class="search-box"> 
                    <form action="Search.jsp" method="post">
                        <img src="img/lupa.png"> 
                        <input type="text" name="search" placeholder="Buscar"> 
                    </form>
                    
                </div>
                <div class="nav-user-icon" onclick="settingsMenuToggle()">
                    <p><% out.println(ID);%></p>
                    
                    <img src="img/<%out.println(foto);%>">
                </div>
            </div>
                
                <div class="settings-menu">
                    <div class="setting-menu-inner"> 
                        <div class="user-profile">
                        <img src="img/<%out.println(foto);%>">
                        <div>
                            <form action="GetProfile.jsp" method="post">
                                <p><% out.println(ID);%> <a href="Profile.jsp">Ver mi perfil</a></p>
                                <input  style="display: none" type="text" name="author" value="<%out.println(ID);%>"> 
                                <input  style="display: none" type="text" name="foto_autor" value="<%out.println(foto);%>">
                            </form>
                            
                            
                        </div>
                        <input  style="display: none" type="text" name="author" value="<%out.println(ID);%>"> 
                        <input  style="display: none" type="text" name="foto_autor" value="<%out.println(foto);%>"> 
                        </div>
                        
                        <hr>
                        <div class="user-profile">
                        <img src="img/settings2.png">
                        <div>
                            <p> Ajustes</p>
                            <a href="#">Cambiar información</a>
                        </div>
                        <input  style="display: none" type="text" name="author" value="<%out.println(ID);%>"> 
                        <input  style="display: none" type="text" name="foto_autor" value="<%out.println(foto);%>"> 
                        </div>
                        <hr>
                        <div class="user-profile">
                            <img src="img/log-out.png">
                        <div>
                            <p>Cerrar sesión<a href="Home_U.jsp">Salir</a></p>
                            
                        </div>
                        </div>
                    </div>
                </div>
                    
                    
                
        </nav>
        <div class="container">
            <div class="left-sidebar"> </div>

            <div class="main-content"> 
                <div class="write-post-container"> 
                    <form action="Postear.jsp" method="post"> 
                    <div class="user-profile">
                        <img src="img/<%out.println(foto);%>">
                        <p> <% out.println(ID);%> </p>
                        <input  style="display: none" type="text" name="author" value="<%out.println(ID);%>"> 
                        <input  style="display: none" type="text" name="foto_autor" value="<%out.println(foto);%>"> 
                        <input  style="display: none" type="text" name="opc" value="1"> 
                        
                    </div>
                    
                        <div class="post-input-container"> 
                            <textarea rows="3" placeholder="¿Qué estás pensando?" name="contenido"></textarea>
                            
                            
                        <div class="add-post-links"> 
                            <a href="#"> <img src="img//camara-icon.png">Foto</a>
                            <input type="submit" value="Publicar" onclick="Hashtag(document.getElementsByName('contenido2')[0].value)">
                            
                        </div>
                    </div>
                    </form>
                    
                </div>
                     <button onclick="window.modal1.showModal();">Abrir ventana modal</button>

                    <dialog id="modal1">
                       <h2>Este es el título de mi ventana modal</h2>
                       <p>Este es un texto de ejemplo dentro de una ventana modal</p>
                       <button onclick="window.modal1.close();">Cerrar</button>
                    </dialog>
                <% 
                    
                    String fecha = null;
                    String contenido = null;
                    String autor = null;
                    String foto_autor = null;
                    String likes = null;
                    String comments = null;
                    String id = null;
                    String foto_post = null;

                    
                        
                        try 
                        {
                             Connection con = GetConnection.getConnection();
                             String sql = Query.toString();
                             //String sql = "SELECT * FROM Post WHERE id_post = "+i+" AND estado = 1";
                             //String sql = "SELECT * FROM Post WHERE estado = 1 ORDER BY fechaCreacion DESC";
                             PreparedStatement ps = con.prepareStatement (sql);
                             ResultSet rs = ps.executeQuery();
                             
                             if(rs.next ())
                             {
                                while(rs.getRow() <= j)
                                {
                                    fecha = rs.getObject("fechaCreacion").toString();
                                contenido = rs.getObject("content").toString();
                                autor = rs.getObject("autor").toString();
                                foto_autor = rs.getObject("foto_autor").toString();
                                likes = rs.getObject("likes").toString();
                                comments = rs.getObject("comments").toString();
                                id = rs.getObject("id_post").toString();
                                
                                    
                                    out.println("<div class='post-container'>");
                                    out.println("   <form action='Edit.jsp' method='post'>");
                                    out.println("   <input style='display: none' type='text' name='foto_autor' value='"+id+"'>");
                                    out.println("   <div class='user-profile'>");
                                    out.println("       <img src='img/"+foto_autor+"'>");
                                    out.println("       <div>");
                                    out.println("           <p>"+autor+"</p>");
                                    out.println("           <span>"+fecha+"</span>");
                                    out.println("       </div>");
                                    out.println("   </div>");
                                    out.println("   <p class='post-text'>"+contenido+"</p>");
                                    
                                    out.println("   <div class='post-row'>");
                                    out.println("       <div class='activity-icons'>");
                                    out.println("           <div><img src='img/like-icon.png'>"+likes+"</div>");
                                    out.println("           <div><img src='img/comments-icon.png'>"+comments+"</div>");   
                                    out.println("       </div>");    
                                    out.println("   </div>");
                                    out.println("   </form>");
                                    out.println("</div>");
                                    rs.next ();
                                }   
                             }
                             else
                             {
                                
                             }
                        }
                        catch (Exception e)
                        {

                        }
                        finally 
                        {
                        }
                            
                                  
                %>
                
                <form action="Load_More.jsp" method="post">
                    <button type="submit" class="load-more-btn" name="Load-more">Cargar más</button>
                    
                    <input  style="display: none" type="text" name="Load_more" value="<%out.println(j);%>">
                    <input  style="display: none" type="text" name="opc" value="1">
                </form>

            </div>

            <div class="right-sidebar"> </div>

        </div>
               
        <footer class="footer"> 
            <div class="footer-left">
                <p>FCFM</p>
                <p>Niños Héroes, Ciudad Universitaria, 66451 San Nicolás de los Garza, N.L.</p>
            </div>
            <div class="footer-right">
                <p>©LMAD</p>
            </div>
        
        
        </footer>
                <script src="JAVASCRIPT/Home.js"></script>
    </body>
</html>

