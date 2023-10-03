<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Admin</title>
</head>

<body>
    <?php
        include("conexion.php");
        include("opciones.php");

        if(isset($_SESSION['id_usuario']))
        {
            $id_usuario = $_SESSION['id_usuario'];
            
            $q = "SELECT * from usuario where id_usuario = '$id_usuario' and administrador =1";
            $resultado=mysqli_num_rows(mysqli_query($conexion,$q));
            if($resultado!=0) echo $opciones_admin;
            else echo $opciones;

            if(isset($_POST['limpiar'])) //Limpiar filtro
            {
                $_POST['usuario'] = '';
                $_POST['tipo'] = '';
            }  
        }
        else echo $opciones_sin_sesion;  

        echo '
            <main>';// EMPIEZA EL MAIN

        include("conexion.php");

        

        echo '</main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>';  

	?>  
        <script src="script/jquery.js"></script>
        <script src="script/checked-Generoctores.js"></script>
        <script src="script/etiquetas-dinamicas.js"></script>

        
</body>
</html>