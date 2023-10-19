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
        if (isset($_POST['desbannear-review'])) {
            if (isset($_POST['checkedIds']) && is_array($_POST['checkedIds'])) {
                $checkedIds = $_POST['checkedIds'];

                foreach ($checkedIds as $checkedId) {
                    $BanReviews = mysqli_query($conexion, "UPDATE moviely.review SET estado_review = NULL WHERE id_review = '$checkedId'");
                    
                    $calificaciones = mysqli_query($conexion, "SELECT * FROM moviely.review WHERE id_review = '$checkedId'");
                    
                    if($calificaciones->num_rows > 0){
                        $row = $calificaciones->fetch_assoc();
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
            }
            else {
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