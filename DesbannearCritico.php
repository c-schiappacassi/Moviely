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

    if($_SESSION['administrador'] > 0){
        if (isset($_POST['desbannear-crit-2'])) {
            if (isset($_POST['checkedIds']) && is_array($_POST['checkedIds'])) {
                $checkedIds = $_POST['checkedIds'];
                echo '<div style="width:80%; margin: auto; padding-top:3%;">';
                foreach ($checkedIds as $checkedId) {

                    $BanReviews = mysqli_query($conexion, "UPDATE moviely.review SET estado_review = NULL WHERE id_usuario = '$checkedId'");
                    $BanCrit = mysqli_query($conexion, "UPDATE moviely.usuario SET estado = NULL WHERE id_usuario = '$checkedId'");

                    $calificaciones = mysqli_query($conexion, "SELECT * FROM moviely.review WHERE id_usuario = '$checkedId'");
                    
                    if($calificaciones->num_rows > 0){
                        while($row = $calificaciones->fetch_assoc()){
                            $peli = $row['id_peli'];
                            $buscar_peli=  mysqli_query($conexion, "SELECT * FROM moviely.peli WHERE id_peli = '$peli'");
                            $peli = $buscar_peli->fetch_assoc();
    
                            $nueva_cant_reviews =  ($peli['cant_review']) + 1;
                            $nueva_cant_estrellas =  ($peli['cant_estrellas']) + $row['calificacion'];
                            
                            $nueva_calif= ($nueva_cant_estrellas / $nueva_cant_reviews) ;
                            $idpeli = $peli['id_peli'];
                            $update_calif_peli =  mysqli_query($conexion,"UPDATE peli SET calificacion='$nueva_calif', cant_review ='$nueva_cant_reviews', cant_estrellas='$nueva_cant_estrellas' WHERE id_peli='$idpeli'" );        
                        }
                    }
                    $critico =  mysqli_query($conexion, "SELECT nombre_usuario FROM moviely.usuario WHERE id_usuario = '$checkedId'");
                    if($critico ->num_rows > 0){
                        $critico = $critico->fetch_assoc();
                        echo ' <p class="importante">Se desbanneo al Critico <strong>'.$critico['nombre_usuario'].'</strong></p> '; 
                    }
                }
                echo '</div>';
            } else {
                echo "No checked review IDs found.";
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