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
    //  estado_review sera 
    //      - NULL si la review no esta banneada 
    //      - 1 si la review ha sido banneada individualmente
    //      - 2 si el critico que dejo esa review ha sido banneado
    //      - 3 si es la review que causo que bannearan al critico 

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
            if (isset($_POST['boton-bannear-reseña'])){
                $id_review_ban= $_POST['id_review_ban'];
                $id_peli= $_POST['id_peli'];
                $BanReviewToxica = mysqli_query($conexion, "UPDATE moviely.review SET estado_review = 1 WHERE id_review = ('$id_review_ban')");
                $calificacion = mysqli_query($conexion, "SELECT * FROM moviely.review WHERE id_review = ('$id_review_ban')");
                $calificacion = $calificacion->fetch_assoc();
    
                $buscar_peli=  mysqli_query($conexion, "SELECT * FROM moviely.peli WHERE id_peli = ('$id_peli')");
                $peli = $buscar_peli->fetch_assoc();
                
                if($peli['cant_review'] > 0){
                    $nueva_cant_reviews =  ($peli['cant_review']) - 1;
                    $nueva_cant_estrellas =  ($peli['cant_estrellas']) - $calificacion['calificacion'];
                    if($nueva_cant_reviews == 0){
                        $nueva_calif = 0;
                    }
                    else $nueva_calif= ($nueva_cant_estrellas / $nueva_cant_reviews) ;
                    $update_calif_peli =  mysqli_query($conexion,"UPDATE peli SET calificacion='$nueva_calif', cant_review ='$nueva_cant_reviews', cant_estrellas='$nueva_cant_estrellas' WHERE id_peli='$id_peli'" );        
                
                    if ($BanReviewToxica == false || $update_calif_peli == false ){
                        echo'
                        <div style="width:80%; margin: auto; padding-top:3%;">
                            <h1>Algo salio mal!</h1>
                        </div>';
                    }
                    else{
                        echo'
                        <div style="width:80%; margin: auto; padding-top:3%;">
                            <h1>Review Banneada correctamente</h1>
                            <a href="info.php?id_peli='.$id_peli.'">Volver al contenido</a> o <a href="listaBanReview.php">Ver la lista de Reviews Banneadas</a>
                        </div>';
                    }
                }
            }
            
            if (isset($_POST['boton-bannear-critico'])){
                $id_critico_ban= $_POST['id_critico-ban'];
                $id_review_ban= $_POST['id_review_ban'];
                $id_peli= $_POST['id_peli'];
    
                $BanUsuario = mysqli_query($conexion, "UPDATE moviely.usuario SET estado = 1 WHERE id_usuario = ('$id_critico_ban')");
                $BanReviews = mysqli_query($conexion, "UPDATE moviely.review SET estado_review = 2 WHERE id_usuario = ('$id_critico_ban')");
                $BanReviewToxica = mysqli_query($conexion, "UPDATE moviely.review SET estado_review = 3 WHERE id_review = ('$id_review_ban')");
                
                $calificaciones = mysqli_query($conexion, "SELECT * FROM moviely.review WHERE id_usuario = ('$id_critico_ban')");
    
                if($calificaciones->num_rows > 0){
                    while ($row = $calificaciones->fetch_assoc()) 
                    {
                        $peli = $row['id_peli'];
                        $buscar_peli=  mysqli_query($conexion, "SELECT * FROM moviely.peli WHERE id_peli = ('$peli')");
                        $peli = $buscar_peli->fetch_assoc();
                        
                        if($peli['cant_review'] > 0){
                            $nueva_cant_reviews =  ($peli['cant_review']) - 1;
                            $nueva_cant_estrellas =  ($peli['cant_estrellas']) - $row['calificacion'];
                            if($nueva_cant_reviews == 0){
                                $nueva_calif = 0;
                            }
                            else $nueva_calif= ($nueva_cant_estrellas / $nueva_cant_reviews) ;
                            $idpeli = $peli['id_peli'];
                            $update_calif_peli =  mysqli_query($conexion,"UPDATE peli SET calificacion='$nueva_calif', cant_review ='$nueva_cant_reviews', cant_estrellas='$nueva_cant_estrellas' WHERE id_peli='$idpeli'" );        
                        }
                    }
                }
    
                if ($BanReviewToxica == false|| $BanReviews == false ||  $BanUsuario == false ){
                    echo'
                    <div style="width:80%; margin: auto; padding-top:3%;">
                        <h1>Algo salio mal!</h1>
                    </div>';
                }
                else{
                    echo'
                    <div style="width:80%; margin: auto; padding-top:3%;">
                        <h1>Crítico Banneado correctamente</h1>
                        <a href="info.php?id_peli='.$id_peli.'">Volver al contenido</a> o <a href="listaBanCrit.php">Ver la lista de Críticos Banneados</a>
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