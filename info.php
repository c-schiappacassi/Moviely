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

            if(isset($_POST['limpiar'])) //Limpiar filtro
            {
                $_POST['usuario'] = '';
                $_POST['tipo'] = '';
            }  
        }
        else echo $opciones_sin_sesion;

        echo '
                <main>';// EMPIEZA EL MAIN

        if($_GET['id_peli'] != 0){
            $id_peli = $_GET['id_peli'];
            $q_datos = mysqli_query($conexion, "SELECT * FROM moviely.peli WHERE id_peli = ('$id_peli')");
            $row_datos = mysqli_fetch_assoc($q_datos); 
            $calificacion = $row_datos['calificacion'] ;

            $q_direcPeli= mysqli_query($conexion, "SELECT id_director FROM moviely.peli_director WHERE id_peli = ('$id_peli')");
            $q_actorPeli= mysqli_query($conexion, "SELECT id_actor FROM moviely.peli_actor WHERE id_peli = ('$id_peli')");
            $q_generoPeli= mysqli_query($conexion, "SELECT id_genero FROM moviely.peli_genero WHERE id_peli = ('$id_peli')");

            //$calificacion = $row_datos['calificacion'];
            
            echo '
            <div id="informacion">
                    <div class="informacionMini" id="contPoster">
                        <img src="'.$row_datos['path_poster'].'" alt="">
                    </div>
                    <div  id="contDatos">
                            <h1 id="tituloInfo">'.$row_datos['titulo'].'</h1>
                            <div>
                                <div id="contEstreFecha">
                                    <div>
                                        <div class="rating-registrado">
                                            <input value="5" '; if ($calificacion >=4.51){echo 'checked="checked"';}else{echo 'onclick="return false;"';}  echo'name="rating" id="star5" type="radio">
                                            <label for="star5"></label>
                                            <input value="4" '; if ($calificacion >=3.51  && $calificacion <4.51){echo 'checked="checked"';}else{echo 'onclick="return false;"';} echo' name="rating" id="star4" type="radio">
                                            <label for="star4"></label>
                                            <input value="3" '; if ($calificacion >=2.51  && $calificacion < 3.51){echo 'checked="checked"';}else{echo 'onclick="return false;"';} echo' name="rating" id="star3" type="radio">
                                            <label for="star3"></label>
                                            <input value="2" '; if ($calificacion >= 1.51  && $calificacion < 2.51){echo 'checked="checked"';}else{echo 'onclick="return false;"';} echo' name="rating" id="star2" type="radio">
                                            <label for="star2"></label>
                                            <input value="1" '; if ($calificacion >=1  && $calificacion < 1.51){echo 'checked="checked"';}else{echo 'onclick="return false;"';} echo' name="rating" id="star1" type="radio">
                                            <label for="star1"></label>
                                        </div>
                                        <p id="reviewCantInfo"><strong>'.$row_datos['calificacion'].'/5</strong> calificada por '.$row_datos['cant_review'].' Criticos</p>
                                    </div>
                                    
                                    
                                    <div id="contFechaDur">
                                        <p><span style="font-weight: bold;">Estreno:</span><br>
                                        <input id="dateInfo" type="date" readonly value="'.$row_datos['estreno'].'">
                                        </p>
                                        <p id="duracionInfo">
                                        <span style="font-weight: bold;">Duracion:</span><br>'; 
                                            if ($row_datos['duracion'] == 0  && $row_datos['temporada'] > 1 ){
                                                echo ''.$row_datos['temporada'].' temporadas';
                                            }
                                            else if ($row_datos['temporada'] == 1){echo 'Serie de '.$row_datos['temporada'].' temporada';}
                                            else {echo ''.$row_datos['duracion'] .' minutos';} 
                                        echo'</p>
                                    </div>
                                </div>
                                <div id="contDesTags">
                                    <div style="width: 90%;">
                                        <p id="descripcionInfo">'.$row_datos['descripcion'].'</p>
                                    </div> 
                            
                                    <div id="contDatosTags">
                                        <div class="tags" id="directores">
                                            <p><span style="font-weight: bold;">Directores</span>: ';
                                            $contadorDire = 0;
                                            if ($q_direcPeli->num_rows > 0) {
                                                while ($row = $q_direcPeli->fetch_assoc()) {
                                                    $q_direcInfo = mysqli_query($conexion, "SELECT * FROM moviely.director WHERE id_director = ('$row[id_director]')");
                                                    $direc =  $q_direcInfo->fetch_assoc();
                                                    $contadorDire ++;
                                                    echo ''.$direc['nombre'].' '.$direc['apellido'].'';
                                                    if ($contadorDire != $q_direcPeli->num_rows){
                                                        echo ', ';
                                                    }
                                                    else{echo '.';}
                                                }
                                            } else {
                                                echo 'No directors found.';
                                            }
                                        echo'</p>
                                        </div>
                                        <div class="tags"  id="actores">
                                            <p><span style="font-weight: bold;">Actores</span>: ';
                                            $contadorActor = 0;
                                            if ($q_actorPeli->num_rows > 0) {
                                                while ($row = $q_actorPeli->fetch_assoc()) {
                                                    $q_actorInfo = mysqli_query($conexion, "SELECT * FROM moviely.actor WHERE id_actor = ('$row[id_actor]')");
                                                    $actor =  $q_actorInfo->fetch_assoc();
                                                    $contadorActor ++;
                                                    echo ''.$actor['nombre'].' '.$actor['apellido'].'';
                                                    if ($contadorActor != $q_actorPeli->num_rows){
                                                        echo ', ';
                                                    }
                                                    else{echo '.';}
                                                }
                                            } else {
                                                echo 'No actors found.';
                                            }
                                        echo'</p>
                                        </div>
                                        <div class="tags" id="generos">
                                            <p><span style="font-weight: bold;">Generos</span>: ';
                                            $contadorGen = 0;
                                            if ($q_generoPeli->num_rows > 0) {
                                                while ($row = $q_generoPeli->fetch_assoc()) {
                                                    $q_genInfo = mysqli_query($conexion, "SELECT * FROM moviely.genero WHERE id_genero = ('$row[id_genero]')");
                                                    $gen =  $q_genInfo->fetch_assoc();
                                                    $contadorGen ++;
                                                    echo ''.$gen['nombre_genero'].'';
                                                    if ($contadorGen != $q_generoPeli->num_rows){
                                                        echo ', ';
                                                    }
                                                    else{echo '.';}
                                                }
                                            } else {
                                                echo 'No genres found.';
                                            }
                                        echo'</p>
                                        </div>
                                    </div>
                                </div>
                            <div>    
                        </div>
                    </div>
                </div>
            </div>';
            //TERMINO LA INFO DE LA PELI

            //botones admin
            echo '
            <div id="botones-admin">
                <form method="GET" action="ModificaPeli.php">
                    <input type="hidden" name="busca_id" value="'.$id_peli.'">
                    <button name="submit-modif" class="Btn">Modificar
                        <svg class="svg" viewBox="0 0 512 512">
                        <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>   
                    </button>                       
                </form>
                <button id="quiero-elim" style="width: 150px;" class="Btn rojo-elim">ELIMINAR
                    <svg class="svg" fill="#ffffff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M5.755,20.283,4,8H20L18.245,20.283A2,2,0,0,1,16.265,22H7.735A2,2,0,0,1,5.755,20.283ZM21,4H16V3a1,1,0,0,0-1-1H9A1,1,0,0,0,8,3V4H3A1,1,0,0,0,3,6H21a1,1,0,0,0,0-2Z"></path></g></svg>
                </button>
            </div>

            <div class="overlay" id="overlay-elim-peli">
                <div class="popup">
                    <span class="popup-close" id="pop-elim-peli">&times;</span>
                    <div class="popup-content">
                        <p>¿ ESTAS SEGURO ?</p>
                        <div class="descripcion_accion"><p>Esta acción BORRARIA PERMANENTEMENTE toda la informacion de "'.$row_datos['titulo'].'" y TODAS sus reviews</p></div>
                    </div>
                    <div class="popup-buttons">
                        <form method="POST" action="ElimPeli.php">
                            <input type="hidden" name="id_peli" value="'.$id_peli.'">
                            <button name="boton-eliminar" id="boton-eliminar" class="Btn">SI, ELIMINAR
                                <svg class="svg" fill="#ffffff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M5.755,20.283,4,8H20L18.245,20.283A2,2,0,0,1,16.265,22H7.735A2,2,0,0,1,5.755,20.283ZM21,4H16V3a1,1,0,0,0-1-1H9A1,1,0,0,0,8,3V4H3A1,1,0,0,0,3,6H21a1,1,0,0,0,0-2Z"></path></g></svg>
                            </button>
                        </form>
                        <button id="boton-cancelo-elim" class="boton-cancelo">Cancelar operación.</button>
                    </div>
                </div>
            </div>
            ';

            //EMPIEZAN LAS RESEÑAS
            echo '
            <div id="reviews">
                <div class="reseña">
                    <form id="form-review" action="publicacionReview.php" method="post">
                        <input type="hidden" name="id_peli" value="'.$id_peli.'">
                        <p>Calificación en estrellas: </p>
                        <div class="rating">
                            <input value="5" name="rating-critico" id="starCrit5" type="radio">
                            <label for="starCrit5"></label>
                            <input value="4" name="rating-critico" id="starCrit4" type="radio">
                            <label for="starCrit4"></label>
                            <input value="3" name="rating-critico" id="starCrit3" type="radio">
                            <label for="starCrit3"></label>
                            <input value="2" name="rating-critico" id="starCrit2" type="radio">
                            <label for="starCrit2"></label>
                            <input value="1" name="rating-critico" id="starCrit1" type="radio">
                            <label for="starCrit1"></label>
                        </div>
                        <textarea name="coment-critico" rows="4" placeholder="Escriba aquí su review!..." ></textarea>
                        ';
                        if(isset($_SESSION['id_usuario']) &&  $_SESSION['administrador'] == 0)
                        {
                            echo'<input class="publicar" type="submit" value="Publicar">';
                        }
                        else{   echo '<button class="publicar" id="no-hay-sesion" >Publicar</button>';  };
                        echo '
                    </form>
                </div>
                '; 
                
                $q_reseñas = mysqli_query($conexion, "SELECT * FROM moviely.review WHERE id_peli = ('$id_peli') AND estado_review = 0 AND estado_usuario = 0 ");
                
                if ($q_reseñas->num_rows > 0) {
                    while ($row = $q_reseñas->fetch_assoc()) {
                        $estrellas = $row['calificacion'];
                        $usuario = $row['id_usuario'];

                        $reseña_usuario = mysqli_query($conexion, "SELECT nombre_usuario FROM moviely.usuario WHERE id_usuario = ('$usuario')");
                        $usuario = $reseña_usuario->fetch_assoc();
                        echo /*aca va un while que pase por todas las reviews*/'
                        <div class="reseña">
                            <strong>'; $usuario['nombre_usuario']; echo'</strong> 
                            <div id="estre-review" class="rating">
                                <input value="5" '; if ($estrellas >=4.51){echo 'checked="checked"';}else{echo 'onclick="return false;"';}  echo'name="rating-reviews" id="starRev5" type="radio">
                                <label for="starRev5"></label>
                                <input value="4" '; if ($estrellas >=3.51  && $estrellas <4.51){echo 'checked="checked"';}else{echo 'onclick="return false;"';} echo' name="rating-reviews" id="starRev4" type="radio">
                                <label for="starRev4"></label>
                                <input value="3" '; if ($estrellas >=2.51  && $estrellas < 3.51){echo 'checked="checked"';}else{echo 'onclick="return false;"';} echo' name="rating-reviews" id="starRev3" type="radio">
                                <label for="starRev3"></label>
                                <input value="2" '; if ($estrellas >= 1.51  && $estrellas < 2.51){echo 'checked="checked"';}else{echo 'onclick="return false;"';} echo' name="rating-reviews" id="starRev2" type="radio">
                                <label for="starRev2"></label>
                                <input value="1" '; if ($estrellas >=1  && $estrellas < 1.51){echo 'checked="checked"';}else{echo 'onclick="return false;"';} echo' name="rating-reviews" id="starRev1" type="radio">
                                <label for="starRev1"></label>
                            </div> 
                            <p>'; $row['comentario']; echo'</p>              
                        </div>';
                    }
                } else {
                    echo '<p>Que vacio... Se el primero en comentar!</p>';
                }
            echo'    
            </div>
            ';
            
        }

        echo '
        </main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>
        '; 
/*    
     }
    else header("Location:login.php");   */

    ?>
        <script src="script/jquery.js"></script>
        <script src="script/pop-ups.js"></script>
</body>
</html>