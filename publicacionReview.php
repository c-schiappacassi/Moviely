<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link rel="icon" href="moviely favicon.png" type="image/ico">
    <title>Publicación Review</title>
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
            if($resultado!=0){
                echo $opciones_admin; 
                $_SESSION['administrador'] = 1;
                echo '
                <main>
                    <div style="width:80%; margin: auto; padding-top:3%;">
                        <h1>Acción Negada, Los usuarios administradores no pueden dejar reviews</h1>
                    </div>
                </main>
                <footer>
                    <p>&copy; 2023 Your Movie Reviews</p>
                </footer>
                '; 
            }
            else{
                echo $opciones;
                $_SESSION['administrador'] = 0;

                echo '
                <main>
                ';
                if(isset($_POST['public-review'])){
                    $id_peli = $_POST['id_peli'];
                    $id_usuario = $_SESSION['id_usuario'];
                    $calif = $_POST['rating-crit'];
                    $comentario = $_POST['coment-critico'];
    
                    $existe_review =  mysqli_query($conexion,"SELECT * FROM moviely.review WHERE id_usuario = '$id_usuario' AND id_peli = '$id_peli';"); 
                    
                    if($existe_review->num_rows > 0){
                        echo '<h1>Acción Negada, Solo puedes dejar 1 review por Contenido y ya tienes una!</h1>';
                    }
                    else{
                        $info_peli =  mysqli_query($conexion,"SELECT * FROM moviely.peli WHERE id_peli = '$id_peli';"); 
                        $row = $info_peli->fetch_assoc();
    
                        $nueva_cant_reviews =  ($row['cant_review']) + 1;
                        $nueva_cant_estrellas =  ($row['cant_estrellas']) + $calif;
                        $nueva_calif= ($nueva_cant_estrellas / $nueva_cant_reviews) ;
    
                        $nueva_review =  mysqli_query($conexion,"INSERT INTO review (id_usuario , id_peli , comentario , calificacion) values ('$id_usuario', '$id_peli', '$comentario', '$calif');" );        
                        $update_calif_peli =  mysqli_query($conexion,"UPDATE peli SET calificacion='$nueva_calif', cant_review ='$nueva_cant_reviews', cant_estrellas='$nueva_cant_estrellas' WHERE id_peli='$id_peli';" );        
                        header('Location:info.php?id_peli='.$id_peli.'');
                    }
                }else{
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
            }
        }
        else{
            echo $opciones_sin_sesion;
            echo '
            <main>
            <div style="width:80%; margin: auto; padding-top:3%;">
                <h1>Acción Negada, <a href="LogInUsuario.php" >Inicie Sesion</a></h1>
            </div>
            </main>
            <footer>
                <p>&copy; 2023 Your Movie Reviews</p>
            </footer>
            '; 
        } 


    ?>
        <script src="script/jquery.js"></script>
        <script src="script/pop-ups.js"></script>
        <script src="script/botonTop.js"></script>
</body>
</html>