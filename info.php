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
                                        <fieldset class="rateDisplay">
                                            <input type="radio" id="rating10" name="rating" value="10" '; if ($calificacion ==10  ){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating10" title="10/10"></label>
                                            <input type="radio" id="rating9" name="rating" value="9" '; if ($calificacion >=9  && $calificacion < 10){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating9" title="9/10"></label>
                                            <input type="radio" id="rating8" name="rating" value="8" '; if ($calificacion >=8 && $calificacion < 9){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating8" title="8/10"></label>
                                            <input type="radio" id="rating7" name="rating" value="7" '; if ($calificacion >=7 && $calificacion < 8){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating7" title="7/10"></label>
                                            <input type="radio" id="rating6" name="rating" value="6" '; if ($calificacion >=6  && $calificacion < 7){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating6" title="6/10"></label>
                                            <input type="radio" id="rating5" name="rating" value="5" '; if ($calificacion >=5  && $calificacion < 6){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating5" title="5/10"></label>
                                            <input type="radio" id="rating4" name="rating" value="4" '; if ($calificacion >=4 && $calificacion < 5){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating4" title="4/10"></label>
                                            <input type="radio" id="rating3" name="rating" value="3" '; if ($calificacion >=3 && $calificacion < 4){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating3" title="3/10"></label>
                                            <input type="radio" id="rating2" name="rating" value="2" '; if ($calificacion >=2 && $calificacion < 3){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating2" title="2/10"></label>
                                            <input type="radio" id="rating1" name="rating" value="1" '; if ($calificacion >=1 && $calificacion < 2){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating1" title="1/10"></label>
                                        </fieldset>
                                        
                                        <p id="reviewCantInfo"><strong>'.$row_datos['calificacion'].'/10</strong> calificada por '.$row_datos['cant_review'].' Criticos</p>
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
            if( $_SESSION['administrador'] == 1){
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
            }
            else{
                echo '<div id="botones">';
                if(isset($_SESSION['id_usuario']))
                {
                    $id_usuario = $_SESSION['id_usuario'];
                    $existe_lista = mysqli_query($conexion, "SELECT * FROM moviely.mi_lista WHERE id_peli = ('$id_peli') AND id_usuario = ('$id_usuario');");

                    if($existe_lista->num_rows > 0){
                        echo'
                        <form id="MiLista-form" method="GET" action="administracionMiLista.php">
                            <input type="hidden" name="id_peli" value="'.$id_peli.'">
                            <button type="submit" name="boton-quitar-lista" class="Btn rojo-elim">Quitar de Mi Lista
                                <svg class="svg" fill="#f0f8ff" viewBox="-3.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><path d="M11.383 13.644A1.03 1.03 0 0 1 9.928 15.1L6 11.172 2.072 15.1a1.03 1.03 0 1 1-1.455-1.456l3.928-3.928L.617 5.79a1.03 1.03 0 1 1 1.455-1.456L6 8.261l3.928-3.928a1.03 1.03 0 0 1 1.455 1.456L7.455 9.716z"/></svg>
                            </button>
                        </form>
                        ';
                        
                    }
                    else{
                        echo'
                        <form id="MiLista-form" method="GET" action="administracionMiLista.php">
                            <input type="hidden" name="id_peli" value="'.$id_peli.'">
                            <button type="submit" name="boton-Agregar-lista" class="Btn">Agregar a Mi Lista
                                <svg id="add" class="svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="Complete"><g><line fill="none" stroke="#f0f8ff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12" x2="12" y1="19" y2="5"/><line fill="none" stroke="#f0f8ff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="5" x2="19" y1="12" y2="12"/></g>
                            </button>
                        </form>
                        ';
                         
                    }
                }
                else{   echo '
                    <button name="lista-sin-sesion" id="lista-sin-sesion" class="Btn">Agregar a Mi Lista
                        <svg id="add" class="svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="Complete"><g><line fill="none" stroke="#f0f8ff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12" x2="12" y1="19" y2="5"/><line fill="none" stroke="#f0f8ff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="5" x2="19" y1="12" y2="12"/></g>
                    </button>';
                }
                echo '</div>';
            }
            

            //EMPIEZAN LAS RESEÑAS
            echo '
            <div id="reviews">';
            if ($_SESSION['administrador'] == 0){
                echo'
                <div class="reseña">
                <p class="imp_review"><strong>Deja tu review!</strong></p>
                    <form id="form-review" action="publicacionReview.php" method="post">
                        <input type="hidden" name="id_peli" value="'.$id_peli.'">
                        <div id="alineador_estrelllas">
                            <p>Calificación en estrellas: </p>
                            <fieldset class="rate">
                                <input type="radio" id="rating-crit10" name="rating-crit" value="10"  /><label for="rating-crit10" title="10/10"></label>
                                <input type="radio" id="rating-crit9" name="rating-crit" value="9" /><label class="half" for="rating-crit9" title="9/10"></label>
                                <input type="radio" id="rating-crit8" name="rating-crit" value="8" /><label for="rating-crit8" title="8/10"></label>
                                <input type="radio" id="rating-crit7" name="rating-crit" value="7" /><label class="half" for="rating-crit7" title="7/10"></label>
                                <input type="radio" id="rating-crit6" name="rating-crit" value="6" /><label for="rating-crit6" title="6/10"></label>
                                <input type="radio" id="rating-crit5" name="rating-crit" value="5" /><label class="half" for="rating-crit5" title="5/10"></label>
                                <input type="radio" id="rating-crit4" name="rating-crit" value="4" /><label for="rating-crit4" title="4/10"></label>
                                <input type="radio" id="rating-crit3" name="rating-crit" value="3" /><label class="half" for="rating-crit3" title="3/10"></label>
                                <input type="radio" id="rating-crit2" name="rating-crit" value="2" /><label for="rating-crit2" title="2/10"></label>
                                <input type="radio" id="rating-crit1" name="rating-crit" value="1" /><label class="half" for="rating-crit1" title="1/10"></label>
                            </fieldset>
                        </div>
                        
                        <textarea name="coment-critico" rows="4" placeholder="Escriba aquí su review!..." ></textarea>
                        ';
                        if(isset($_SESSION['id_usuario']))
                        {
                            echo'<input class="publicar" type="submit" value="Publicar">
                            </form>';
                        }
                        else{   echo' </form> <button class="publicar" id="review-sin-sesion" >Publicar</button>';  };
                        echo '
                </div>';
            }
            
            echo '
                <div class="overlay" id="overlay-sin-sesion">
                    <div class="popup">
                        <span class="popup-close" id="pop-sin-sesion">&times;</span>
                        <div class="popup-content">
                            <p class="importante">Accion Negada</p>
                            <div class="descripcion_accion"><p>Parece que no a iniciado sesion!     :o <br><br>Solo los usuarios Criticos con sesión iniciada<br>pueden realizar esta acción</p></div>
                        </div>
                        <div class="popup-buttons">
                            <form method="POST" action="LogInUsuario.php">
                                <button >Iniciar Sesión</button>
                            </form>
                            <form method="POST" action="RegistrarUsuario.php">
                                <button >Crear Cuenta</button>
                            </form>
                        </div>
                    </div>
                </div>
                '; 
                
                $q_reseñas = mysqli_query($conexion, "SELECT * FROM moviely.review WHERE id_peli = ('$id_peli') AND estado_review is NULL");
                $contName = 1;
                if ($q_reseñas->num_rows > 0) {
                    while ($row = $q_reseñas->fetch_assoc()) {
                        $estrellas = $row['calificacion'];
                        $usuario = $row['id_usuario'];

                        $reseña_usuario = mysqli_query($conexion, "SELECT nombre_usuario FROM moviely.usuario WHERE id_usuario = ('$usuario')");
                        $usuario = $reseña_usuario->fetch_assoc();
                        
                        echo /*aca va un while que pase por todas las reviews*/'
                        <div class="reseña">
                            <div id="cont">
                                <p class="imp_review"><strong>'.$usuario['nombre_usuario'].'</strong></p> 
                                <div id="estre-review" >
                                    <fieldset class="rateDisplay rateChico">
                                        <input type="radio" id="rating10" name="rating'.$contName.'" value="10" '; if ($estrellas ==10  ){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating10" title="10/10"></label>
                                        <input type="radio" id="rating9" name="rating'.$contName.'" value="9" '; if ($estrellas >=9  && $estrellas < 10){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating9" title="9/10"></label>
                                        <input type="radio" id="rating8" name="rating'.$contName.'" value="8" '; if ($estrellas >=8 && $estrellas < 9){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating8" title="8/10"></label>
                                        <input type="radio" id="rating7" name="rating'.$contName.'" value="7" '; if ($estrellas >=7 && $estrellas < 8){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating7" title="7/10"></label>
                                        <input type="radio" id="rating6" name="rating'.$contName.'" value="6" '; if ($estrellas >=6  && $estrellas < 7){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating6" title="6/10"></label>
                                        <input type="radio" id="rating5" name="rating'.$contName.'" value="5" '; if ($estrellas >=5  && $estrellas < 6){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating5" title="5/10"></label>
                                        <input type="radio" id="rating4" name="rating'.$contName.'" value="4" '; if ($estrellas >=4 && $estrellas < 5){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating4" title="4/10"></label>
                                        <input type="radio" id="rating3" name="rating'.$contName.'" value="3" '; if ($estrellas >=3 && $estrellas < 4){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating3" title="3/10"></label>
                                        <input type="radio" id="rating2" name="rating'.$contName.'" value="2" '; if ($estrellas >=2 && $estrellas < 3){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating2" title="2/10"></label>
                                        <input type="radio" id="rating1" name="rating'.$contName.'" value="1" '; if ($estrellas >=1 && $estrellas < 2){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating1" title="1/10"></label>
                                    </fieldset>
                                </div>
                                <p>'.$row['comentario'].'</p>     
                            </div>     
                        </div>';
                        $contName++;
                    }
                } else if ($q_reseñas->num_rows == 0 && $_SESSION['administrador'] == 0) {
                    echo '<div class="reseña"><p>Que vacio... Se el primero en comentar!</p></div>';
                }
                else{
                    echo '<div class="reseña"><p>No hay reseñas</p></div>';
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