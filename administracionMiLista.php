<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link rel="stylesheet" href="css\font-awesome-4.7.0/css/font-awesome.min.css">
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

        echo '<main>';// EMPIEZA EL MAIN

        if (isset($_SESSION['id_usuario']) && $_SESSION['administrador'] == 0 ){
            if($_GET['id_peli'] != 0){
                $id_peli = $_GET['id_peli'];
                
                if(isset($_SESSION['id_usuario']) && $_SESSION['administrador'] == 0 )
                {
                    $id_usuario = $_SESSION['id_usuario'];
                    if(isset($_GET['boton-quitar-lista']) || isset($_GET['quitar'])){
                        $quitar_lista = mysqli_query($conexion, "DELETE FROM moviely.mi_lista WHERE id_usuario = '$id_usuario' AND id_peli = '$id_peli' ;");
                        if(isset($_GET['quitar'])){
                            header('Location: MiLista.php');
                        }else{
                            header('Location: info.php?id_peli='.$id_peli.'');
                        }
                    }
                    if(isset($_GET['boton-Agregar-lista'])){
                        $agregar_lista = mysqli_query($conexion, "INSERT INTO moviely.mi_lista ( id_usuario , id_peli ) VALUES (  '$id_usuario' , '$id_peli');");
                        header('Location: info.php?id_peli='.$id_peli.'');
                    }   
                }
            }
        }
        else if(isset($_SESSION['id_usuario']) && $_SESSION['administrador'] > 0 ){
            echo '
            <div style="width:80%; margin: auto; padding-top:3%;">
            <h1>Acceso Negado</h1>
            </div>';
        }
        else{ header("Location:login.php");  }

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