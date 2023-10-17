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


        echo $opciones_sin_sesion;

        echo '
        <main>';

        if(isset($_GET['id_banneado']))
        {
            $id=$_GET['id_banneado'];
            $pregunta = mysqli_query($conexion,"SELECT * from review where id_usuario = '$id' and estado_review = 2");
            
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