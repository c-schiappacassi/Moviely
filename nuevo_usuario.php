<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <?php
        include("conexion.php");
        if (isset($_POST['registrar_datos']))
        {
            $usuario = $_POST['r_usuario'];
            $email = $_POST['r_email'];
            $password = md5($_POST['r_password']);

            if(mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuario WHERE nombre_usuario='$usuario'")))
            {
               $_SESSION['usuario_dup']='ok';
               header("Location:registro.php"); 
            }
            else
            {
                $consulta = mysqli_query($conexion, "INSERT INTO usuario (nombre_usuario, email, password) VALUES('$usuario', '$email', '$password')");
                $_SESSION['agregado']='ok';

                require 'PHPMailer/src/Exception.php';
                require 'PHPMailer/src/PHPMailer.php';
                require 'PHPMailer/src/SMTP.php';
                
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp-mail.outlook.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'find.em.all@outlook.com';
                $mail->Password = 'chichicuelote1';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('find.em.all@outlook.com', "Find 'em All");
                $mail->addAddress($email, $email);
                $mail->IsHTML(true);
                $mail->Subject = " Bienvenido a Find 'Em All!";
                
                $mail->AddEmbeddedImage("static/images/instructivo1.png","instructivo1");
                $mail->AddEmbeddedImage("static/images/instructivo2.png","instructivo2");
                $mail->AddEmbeddedImage("static/images/instructivo3.png","instructivo3");

                $mail->Body = "Bienvenido a Find 'Em All <strong>".$usuario.'</strong>! <br><br>Este mail contiene un instructivo para que puedas manejarte en el sitio. <br><br>En <strong>Menu</strong> podras encontrar las publicaciones activas como tambien el formulario para cargar un nuevo registro. <br><img height="400px" src="cid:instructivo1"/><br><br> En <strong>Mensajes</strong> podras encontrar la bandeja de entrada y salida de mensajeria. <br><img height="400px" src="cid:instructivo2"/><br><br> En <strong>Perfil</strong> podras encontrar tu informacion y la de los registros ingresados. Con la posibilidad de editar los mismos.<br><img height="400px" src="cid:instructivo3"/><br><br>Esperamos que este sitio te sea de ayuda y que todos los pokeamigos se reencuentren!.';

                $mail->send();
                
                header("Location:login.php"); 
            }
        }
        else
        {
            echo '<div class="titulo"><img class="pkbl" height="30px" src="static/images/pokeball.png"><img height="80px" src="static/images/find_em_all.png"><img class="pkbl" height="30px" src="static/images/pokeball.png"></div>';
            if (isset($_SESSION['usuario_dup']))
            {
                echo '<div class="error_dup">Usuario duplicado. Por favor elegir otro.</div>';
                unset($_SESSION['usuario_dup']);
            }
            echo '<div class="div_registro"><form action="registro.php" method="post" >
                    <label>Nombre
                        <input type="text" name="r_nombre" required />
                    </label><br />
                    <label>Apellido
                        <input type="text" name="r_apellido" required />
                    </label><br />
                    <label>Email
                        <input type="email" name="r_email" required />
                    </label><br />
                    <label>Nombre de usuario
                        <input name="r_usuario" type="text" maxlength="12" required/>
                    </label><br />
                    <label>Contraseña
                        <input type="password" name="r_password" maxlength="12" required/>
                    </label><br />
                    <input type="submit" name="registrar_datos" value="Registrarse"/>  
                </form></div>';
                echo '<div class="div_volver_login"><form action="login.php" method="post" ><input type="submit" name="volver" id="volver" value="Volver a Login" /></form></div>';
        }
	?>

</body>
</html>