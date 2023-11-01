<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" href="moviely favicon.png" type="image/ico">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <title>Registro</title>
</head>

<body>
    <?php
        ob_start();
        include("conexion.php");
        include("opciones.php");

        if(isset($_SESSION['id_usuario']))
        {
            $id_usuario = $_SESSION['id_usuario'];
            
            $q = "SELECT * from usuario where id_usuario = '$id_usuario' and administrador =1";
            $resultado=mysqli_num_rows(mysqli_query($conexion,$q));
            if($resultado!=0){echo $opciones_admin; $_SESSION['administrador'] = 1;}
            else{
                echo $opciones;
                $_SESSION['administrador'] = 0;
            } 
        }
        else {
            echo $opciones_sin_sesion;
            $_SESSION['administrador'] = 0;
        } 

        echo '
        <main>';

        echo '
            <div class="cont-espaciado"></div>
            <div class="div_form">
                <h1>¡ Únete a la Comunidad !</h1>
                <p>Crea un usuario y conviértete en Crítico</p>
                <form class="form_usuario" method="post" action="RegistrarUsuario.php">
                    <div>
                        <label for="nombre_usuario">Usuario:</label>
                        <input type="text" name="nombre_usuario" maxlength="15" required>
                    </div>
                    <div>
                        <label for="mail_usuario">Email:</label>
                        <input type="email" name="mail_usuario" required ';if(isset($_POST['mail_usuario'])){echo'value='.$_POST['mail_usuario'].'';}echo '>
                    </div>
                    <div>
                        <label for="contra_usuario">Contraseña:</label>
                        <input type="password" name="contra_usuario" required>
                    </div>
                    <input type="submit" name="nuevo_critico" value="Registrame!">
                </form>
                <p style="font-size:1rem;">Ya tienes usuario? <a href="LogInUsuario.php">inicia sesion</a></p>
            </div>
            ';
        if(isset($_POST['nuevo_critico'])){
            $usuario = $_POST['nombre_usuario'];
            $mail = $_POST['mail_usuario'];
            $contra= md5($_POST['contra_usuario']);
            $pregunta = mysqli_query($conexion,"SELECT nombre_usuario, mail from usuario where nombre_usuario = '$usuario' or mail = '$mail'");

            if($pregunta->num_rows > 0 ){
                $row = $pregunta->fetch_assoc();
                if($usuario == $row['nombre_usuario']){
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
                else if ($mail == $row['mail']){
                    echo'
                    <div class="overlay show" id="overlay-mail-repe">
                        <div class="popup">
                            <span class="popup-close" id="pop-mail-repe">&times;</span>
                            <div class="popup-content">
                                <div class="descripcion_accion"><p>Un usuario con este mail ya esta registrado! <br>Quieres inicar sesión?</p></div>
                            </div>
                            <div class="popup-buttons">
                                <form method="POST" action="LogInMail.php">
                                    <input type="hidden" name="mail_usuario" value="'.$mail.'">
                                    <button >Iniciar Sesión</button>
                                </form>
                                <button id="boton-mail-repe">Intentar denuevo con otro mail</button>
                            </div>
                        </div>
                    </div>
                    ';
                }
            }
            else{
                $registro_usuario = mysqli_query($conexion,"INSERT INTO moviely.usuario (nombre_usuario, mail, contraseña) values ('$usuario', '$mail', '$contra')");
                $registrado = mysqli_query($conexion,"SELECT id_usuario FROM moviely.usuario WHERE nombre_usuario = '$usuario' AND mail='$mail';"); 
                $row_registrado = $registrado->fetch_assoc();

                header('Location: mail_registrado.php?id_usuario='.$row_registrado['id_usuario'].'');
            }    
        }
        echo '
        <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
        </main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>
        '; 
    ?>
    <script src="script/jquery.js"></script>
    <script src="script/pop-ups.js"></script>
    <script src="script/botonTop.js"></script>
</body>
</html>