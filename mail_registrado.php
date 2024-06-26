<?php session_start();?>

<?php
include("conexion.php");
include("opciones.php");

include("vendor\config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
echo '
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="moviely favicon.png" type="image/ico">
    <title>mail</title>
</head>
</html>';

if (isset($_GET['id_usuario'])){

    $id = $_GET['id_usuario'];

    $registrado = mysqli_query($conexion,"SELECT nombre_usuario, mail FROM moviely.usuario WHERE id_usuario = '$id';"); 
    
    if($registrado->num_rows > 0){
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
            <br><br> - El equipo de Moviely.
            <br><br> P.D.: Te dejamos el Manual del Crítico para ayudarte a explorar Moviely!';
            $file_path = 'Manual del Crítico - Moviely.pdf'; 
            $mail->addAttachment($file_path, 'Manual del Critico - Moviely.pdf');
            
            $mail->send();
            $_GET['id_usuario'] = ""; 
            
            session_destroy();
    
            header('Location: LogInUsuario.php');   
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }   
} 
else{
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
}
?>
