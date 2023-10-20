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

        if($_SESSION['administrador'] > 0){
            if (isset($_GET['boton-eliminar'])){
                $id_peli=$_GET['id_peli'];

                $elim_listas= mysqli_query($conexion, "DELETE FROM moviely.mi_lista WHERE id_peli = '$id_peli'") ;
                $elim_reviews= mysqli_query($conexion, "DELETE FROM moviely.review WHERE id_peli = '$id_peli'") ;
                $elim_genero= mysqli_query($conexion, "DELETE FROM moviely.peli_genero WHERE id_peli = '$id_peli'") ;
                $elim_actores= mysqli_query($conexion, "DELETE FROM moviely.peli_actor WHERE id_peli = '$id_peli'") ;
                $elim_directores= mysqli_query($conexion, "DELETE FROM moviely.peli_director WHERE id_peli = '$id_peli'") ;
                $elim_peli= mysqli_query($conexion, "DELETE FROM moviely.peli WHERE id_peli = '$id_peli'") ;

                if ($elim_listas == false|| $elim_reviews == false ||  $elim_genero == false || $elim_actores == false || $elim_directores == false || $elim_peli == false ){
                    echo' 
                    <div style="width:80%; margin: auto; padding-top:3%;">
                        <h1>Algo salio mal!</h1>
                    </div>';
                }
                else{
                    echo'
                    <div style="width:80%; margin: auto; padding-top:3%;">
                        <h1>Contenido ELIMINADO permanentementa</h1>
                        <a href="index.php">Volver a la home</a>
                    </div>';
                }  
            }
        }
        else{
            echo '
            <div style="width:80%; margin: auto; padding-top:3%;">
                <h1>Acceso Negado</h1>
            </div>';
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