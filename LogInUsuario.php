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
        include("conexion.php");
        include("opciones.php");

        if(isset($_SESSION['id_usuario']))
        {
            header('Location: Index.php');                                    
        }
        else echo $opciones_sin_sesion;

        echo '
                <main>
                    <div class="cont-espaciado"></div>
                    <div class="div_form">
                        <h1>Inicia Sesión</h1>
                        <p>Por medio del nombre de Usuario registrado</p>
                        <form class="form_usuario" method="post" action="LogInUsuario.php">
                            <div>
                                <label for="nombre_usuario">Usuario:</label>
                                <input type="text" name="nombre_usuario" required>
                            </div>
                            <div>
                                <label for="contra_usuario">Contraseña:</label>
                                <input type="password" name="contra_usuario" required>
                            </div>
                            <input type="submit" name="logueame" value="Iniciar Sesion">
                        </form>
                        <p style="font-size:1rem;">No tienes cuenta? <a href="RegistrarUsuario.php">Regístrate</a></p>
                        <p style="font-size:1rem;">Tambien puedes <a href="LogInMail.php">iniciar sesion por Mail registrado</a></p>
                    </div>
                    ';
                    
        if(isset($_POST['logueame'])){
            $usuario = $_POST['nombre_usuario'];
            $contra= md5($_POST['contra_usuario']);

            $usuario_regis = mysqli_query($conexion,"SELECT id_usuario from usuario where nombre_usuario = '$usuario'");
            $pregunta = mysqli_query($conexion,"SELECT id_usuario , nombre_usuario, mail , estado from usuario where nombre_usuario = '$usuario' and contraseña = '$contra'");
            if($usuario_regis->num_rows == 0 ){
                echo'                                                                   
                <div class="overlay show" id="overlay-mail-nuevo">
                    <div class="popup">
                        <span class="popup-close" id="pop-mail-nuevo">&times;</span>
                        <div class="popup-content">
                            <div class="descripcion_accion"><p>Parece que no existe este Usuario! :o <br>No tiene cuenta?</p></div>
                        </div>
                        <div class="popup-buttons">
                            <form method="POST" action="RegistrarUsuario.php">
                                <button >Crear Cuenta</button>
                            </form>
                            <button id="boton-mail-nuevo">Intentar denuevo con otro Usuario</button>
                        </div>
                    </div>
                </div>
                ';
            }
            else if ( $pregunta->num_rows == 0){
                echo'
                <div class="overlay show" id="overlay-incorrecto">
                    <div class="popup">
                        <span class="popup-close" id="pop-incorrecto">&times;</span>
                        <div class="popup-content">
                            <div class="descripcion_accion"><p>Error de ingreso! No coinciden los datos :o<br>Revise el usuario o contraseña</p></div>
                        </div>
                        <div class="popup-buttons">
                            <button id="boton-incorrecto">Intentar denuevo</button>
                        </div>
                    </div>
                </div>
                ';
            }
            else if ( $pregunta->num_rows == 1){
                $row = $pregunta->fetch_assoc();
                if($row['estado']> 0){
                    header('Location: Banneado.php?id_banneado='.$row['id_usuario'].'.php');
                }
                else{
                    $_SESSION['id_usuario'] = $row['id_usuario'];
                    $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
                    $_SESSION['mail_usuario'] = $row['mail'];
                    $_SESSION['estado'] = $row['estado'];
                    header('Location: Index.php');
                }
            }
        }
                    
        echo '
        </main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>
        '; 
    ?>
    <script src="script/jquery.js"></script>
    <script src="script/pop-ups.js"></script>
</body>
</html>