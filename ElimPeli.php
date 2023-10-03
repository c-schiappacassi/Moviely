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
            if($resultado!=0) {
                echo $opciones_admin;
                echo '
                <main> ';
                    
                // EMPIEZA EL MAIN
                if(isset($_POST['boton-eliminar'])){
                    $id_peli = $_POST['id_peli'];
                    echo $id_peli;
                }
                        
                echo '  
                </main>
                <footer>
                    <p>&copy; 2023 Your Movie Reviews</p>
                </footer>'; 
            }
            else echo $opciones;

            if(isset($_POST['limpiar'])) //Limpiar filtro
            {
                $_POST['usuario'] = '';
                $_POST['tipo'] = '';
            }  
        }
        else echo $opciones_sin_sesion;

        
	?>  
</body>
</html>

