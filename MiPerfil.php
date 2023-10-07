<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <title>Admin</title>
</head>

<body>
    <?php
        ob_start();
        include("conexion.php");
        include("opciones.php");

        if(isset($_SESSION['id_usuario']))
        {
            $id_usuario = $_SESSION['id_usuario'];
            
            $q = "SELECT * from usuario where id_usuario = '$id_usuario' and administrador = 1";
            $resultado=mysqli_num_rows(mysqli_query($conexion,$q));
            if($resultado!=0) echo $opciones_admin;
            else echo $opciones;

            echo '
            <main>
                <div id="perfil">
                    <div id="info-usuario" class="cont">
                        <div id="text-perfil">
                            <h1 class="importante">'.$_SESSION['nombre_usuario'].'</h1>
                            <h2>'.$_SESSION['mail_usuario'].'</h2>
                            <a href="MiLista.php">Ver Mi Lista</a>
                        </div>

                        <button id="click-edit" class="Btn">
                                <svg class="svg" viewBox="0 0 512 512">
                                <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>   
                        </button>  

                        <div id="div_logout">
                        <a href="LogOut.php">Cerrar Sesion</a>
                        </div>  

                        <div class="overlay" id="overlay-edit-perfil">
                            <div class="popup">
                                <span class="popup-close" id="pop-cerrar-edit">&times;</span>
                                <div class="popup-content">
                                    <p>Edición de perfil</p>
                                </div>
                                <form id="edit-perfil" method="post" action="MiPerfil.php">
                                    <div>
                                        <label for="nombre_usuario_nuevo">Cambiar Usuario:</label>
                                        <input type="text" name="nombre_usuario_nuevo"  maxlength="15"   '; echo'placeholder='.$_SESSION['nombre_usuario'].'' ;echo '>
                                    </div>
                                    <div>
                                        <label for="mail_usuario_nuevo">Cambiar Email:</label>
                                        <input type="email" name="mail_usuario_nuevo"  '; echo'placeholder='.$_SESSION['mail_usuario'].'' ;echo '>
                                    </div>
                                    <div id="botones-edit">
                                        <button name="submit-modif-perfil" class="Btn">Editar Perfil
                                            <svg class="svg" viewBox="0 0 512 512">
                                            <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>   
                                        </button>  
                                        <button id="boton-cancelo-edit-perfil" >Cancelar operación.</button>
                                    </div>                                 
                                </form>
                            </div>
                        </div>

                    </div>
  
                    <div id="usuario-reviews">
                    </div>
                </div>';

            if (isset($_POST['submit-modif-perfil'])){
                $nom_nuevo = $_POST['nombre_usuario_nuevo'];
                $mail_nuevo = $_POST['mail_usuario_nuevo'];

                $pregunta = mysqli_query($conexion,"SELECT nombre_usuario, mail from usuario where nombre_usuario = '$nom_nuevo' or mail = '$mail_nuevo'");

                if($pregunta->num_rows > 0 ){
                    $row = $pregunta->fetch_assoc();
                    if($nom_nuevo == $row['nombre_usuario']){
                        echo'                                                                   
                        <div class="overlay show" id="overlay-usuario-repe">
                            <div class="popup">
                                <span class="popup-close" id="pop-usuario-repe">&times;</span>
                                <div class="popup-content">
                                    <div class="descripcion_accion"><p>Ups! este nombre de usuario ya esta ocupado :( <br> Prueba con otro!</p></div>
                                </div>
                                <div class="popup-buttons">
                                    <button id="boton-usuario-repe" class="boton-cancelo">Intentar denuevo</button>
                                </div>
                            </div>
                        </div>
                        ';
                        
                    }
                    else if ($mail_nuevo == $row['mail']){
                        echo'
                        <div class="overlay show" id="overlay-mail-repe">
                            <div class="popup">
                                <span class="popup-close" id="pop-mail-repe">&times;</span>
                                <div class="popup-content">
                                    <div class="descripcion_accion"><p>Un usuario con este mail ya esta registrado en otra cuenta!</p></div>
                                </div>
                                <div class="popup-buttons">
                                    <button id="boton-mail-repe">Intentar denuevo con otro mail</button>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                }
                else{
                    $id_usuario = $_SESSION['id_usuario'];
                    if($nom_nuevo > "" && $mail_nuevo > ""){
                        $update = mysqli_query($conexion,"UPDATE usuario SET nombre_usuario = '$nom_nuevo', mail = '$mail_nuevo' WHERE id_usuario = '$id_usuario'");
                        session_destroy();
                        header('Location: mail_registrado.php?id_usuario='.$id_usuario.'');
                    }
                    else if($mail_nuevo == "" && $nom_nuevo > ""){
                        $update = mysqli_query($conexion,"UPDATE usuario SET nombre_usuario = '$nom_nuevo' WHERE id_usuario = '$id_usuario'");
                        session_destroy();
                        header("Location:LogInUsuario.php");
                    }
                    else if($mail_nuevo > "" && $nom_nuevo == ""){ 
                        $update = mysqli_query($conexion,"UPDATE usuario SET mail = '$mail_nuevo' WHERE id_usuario = '$id_usuario'");
                        header('Location: mail_registrado.php?id_usuario='.$id_usuario.'');
                    }
                } 
            }                
            echo '
            </main>
            <footer>
                <p>&copy; 2023 Your Movie Reviews</p>
            </footer>
            ';
            
            if(isset($_POST['submit-modif-perfil'])){
                
            } 
        }
        else {header('Location: LogInUsuario.php');};
                    
       
    ?>
    <script src="script/jquery.js"></script>
    <script src="script/pop-ups.js"></script>
    
</body>
</html>