<?php session_start();?>
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


echo $opciones_sin_links;
echo '
    <main>
    <svg id="loader" viewBox="25 25 50 50">
        <circle r="20" cy="50" cx="50"></circle>
    </svg>
    </main>
    <footer>
        <p>&copy; 2023 Your Movie Reviews</p>
    </footer>
';
include("vendor\config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_GET['id_usuario']) || isset($_SESSION['id_usuario'])){

    if(isset($_SESSION['id_usuario'])){
        $id = $_SESSION['id_usuario'];
    }
    else{$id = $_GET['id_usuario'];} 

    $registrado = mysqli_query($conexion,"SELECT nombre_usuario, mail FROM moviely.usuario WHERE id_usuario = '$id';"); 
    $row_registrado = $registrado->fetch_assoc();
    
    
    require_once 'vendor/autoload.php'; 
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->SMTPSecure = 'tls';
        $mail->Port = 25;

        $mail->Host = 'smtp.office365.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'MovielyReviews@hotmail.com'; 
        $mail->Password = 'MOVIELY_moviely';

        $mail->setFrom('MovielyReviews@hotmail.com', 'Moviely-Reviews');
        $mail->addAddress(''.$row_registrado['mail'].'', ''.$row_registrado['nombre_usuario'].'');
        $mail->isHTML(true);
        $mail->Subject = 'Bienvenido a Moviely!';
        $mail->Body = '¡Bienvenido a Moviely '.$row_registrado['nombre_usuario'].'!,
        <br><br>Estamos muy contentos de que te hayas registrado en nuestra comunidad de amantes del cine.
        <br><br>Moviely es un lugar donde puedes compartir tus opiniones sobre películas, encontrar nuevos títulos que ver y consultar reviews con otros cinéfilos de todo el mundo!
        <br>Para empezar, te recomendamos que explores la plataforma y descubras todas las funciones que tenemos para ofrecer. 
        <br>Puedes leer reseñas de otros usuarios, guardar en tu lista tus películas favoritas, dejar tu calificación y opinión cinematografica.
        <br><br>Estamos seguros de que te divertirás mucho en Moviely. ¡Gracias por formar parte de nuestra comunidad!
        <br><br> - El equipo de Moviely.
        <br><br> P.D.: Te dejamos el Manual del Crítico para ayudarte a explorar Moviely!';
        // $file_path = 'path/to/your/attachment/file.pdf'; // path al manual de usuario
        // $mail->addAttachment($file_path, 'attachment.pdf'); //cambiar nombre

        $mail->send();
        $_GET['id_usuario'] = ""; 
        
        session_destroy();

        header('Location: LogInUsuario.php');   
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
</body>
</html>