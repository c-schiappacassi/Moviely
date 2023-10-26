<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" href="moviely favicon.png" type="image/ico">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link rel="stylesheet" href="css\font-awesome-4.7.0/css/font-awesome.min.css">
    <title>Banneado</title>
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
            $pregunta = mysqli_query($conexion,"SELECT * from review where id_usuario = '$id' and estado_review = 3");

            if($pregunta->num_rows > 0){
                $review_toxica = $pregunta->fetch_assoc();
                $estrellas = $review_toxica['calificacion'];
                $peli = $review_toxica['id_peli'];
                $peli = mysqli_query($conexion,"SELECT titulo from peli where id_peli = '$peli'");
                $peli =  $peli->fetch_assoc();
                $usuario = $review_toxica['id_usuario'];
                $usuario = mysqli_query($conexion,"SELECT nombre_usuario from usuario where id_usuario = '$usuario'");
                $usuario =  $usuario->fetch_assoc();

                echo'
                <div style="width:80%; margin: auto; padding-top:3%;">
                    <h1>Este Crítico ha sido banneado por su siguiente review de "'.$peli['titulo'].'" :</h1>
                </div>
                <div class="reseña" style="width:80%; margin: 5% auto;">
                    <div id="cont">
                        <p class="imp_review"><strong>'.$usuario['nombre_usuario'].'</strong></p> 
                        <div id="estre-review" >
                            <fieldset class="rateDisplay rateChico">
                                <input type="radio" id="rating10" name="ratingBanneada" value="10" '; if ($estrellas ==10  ){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating10" title="10/10"></label>
                                <input type="radio" id="rating9" name="ratingBanneada" value="9" '; if ($estrellas >=9  && $estrellas < 10){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating9" title="9/10"></label>
                                <input type="radio" id="rating8" name="ratingBanneada" value="8" '; if ($estrellas >=8 && $estrellas < 9){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating8" title="8/10"></label>
                                <input type="radio" id="rating7" name="ratingBanneada" value="7" '; if ($estrellas >=7 && $estrellas < 8){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating7" title="7/10"></label>
                                <input type="radio" id="rating6" name="ratingBanneada" value="6" '; if ($estrellas >=6  && $estrellas < 7){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating6" title="6/10"></label>
                                <input type="radio" id="rating5" name="ratingBanneada" value="5" '; if ($estrellas >=5  && $estrellas < 6){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating5" title="5/10"></label>
                                <input type="radio" id="rating4" name="ratingBanneada" value="4" '; if ($estrellas >=4 && $estrellas < 5){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating4" title="4/10"></label>
                                <input type="radio" id="rating3" name="ratingBanneada" value="3" '; if ($estrellas >=3 && $estrellas < 4){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating3" title="3/10"></label>
                                <input type="radio" id="rating2" name="ratingBanneada" value="2" '; if ($estrellas >=2 && $estrellas < 3){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating2" title="2/10"></label>
                                <input type="radio" id="rating1" name="ratingBanneada" value="1" '; if ($estrellas >=1 && $estrellas < 2){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating1" title="1/10"></label>
                            </fieldset>
                        </div>
                        <p>'.$review_toxica['comentario'].'</p>     
                    </div>     
                </div>
                <div style="width:80%; margin: auto; ">
                    <h2>No podra abrir sesión con este usuario hasta que un administrador lo permita.</h2>
                    <p>Si piensa que este es un error comuníquese con nosotros en MovielyReviews@hotmail.com</p>
                </div>
                ';
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
    ?>
    <script src="script/jquery.js"></script>
    <script src="script/pop-ups.js"></script>
    <script src="script/botonTop.js"></script>
</body>
</html>