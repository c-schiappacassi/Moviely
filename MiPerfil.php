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
        ob_start();
        include("conexion.php");
        include("opciones.php");

        if(isset($_SESSION['id_usuario']))
        {
            $id_usuario = $_SESSION['id_usuario'];
            
            $q = "SELECT * from usuario where id_usuario = '$id_usuario' and administrador = 1";
            $resultado=mysqli_num_rows(mysqli_query($conexion,$q));
            if($resultado!=0){echo $opciones_admin; $_SESSION['administrador'] = 1;}
            else{
                echo $opciones;
                $_SESSION['administrador'] = 0;
            } 

            echo '
            <main>
                <div id="perfil">
                    <div id="info-usuario" class="cont">
                        <div id="text-perfil">
                            <h1 class="importante">'.$_SESSION['nombre_usuario'].'</h1>
                            <h2>'.$_SESSION['mail_usuario'].'</h2>
                            ';
                            if($_SESSION['administrador'] == 0){echo '<a href="MiLista.php">Ver Mi Lista</a>';};
                            echo'
                        </div>
                        ';
                        if($_SESSION['administrador'] == 0){
                            echo '
                            <button id="click-edit" class="Btn">
                                <svg class="svg" viewBox="0 0 512 512">
                                <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>   
                            </button>  ';
                        };
                        echo'                 

                        <div id="div_logout">
                            <a href="LogOut.php">Cerrar Sesion</a>
                        </div> 

                        <div class="overlay" id="overlay-edit-perfil">
                            <div class="popup">
                                <span class="popup-close" id="pop-cerrar-edit">&times;</span>
                                <div class="popup-content">
                                    <p>Edición de perfil</p>
                                </div>
                                <form id="edit-perfil" method="post" action="MiPerfil.php">
                                    <div>
                                        <label for="nombre_usuario_nuevo">Cambiar Usuario:</label>
                                        <input type="text" name="nombre_usuario_nuevo"  maxlength="15"   '; echo'placeholder='.$_SESSION['nombre_usuario'].'' ;echo '>
                                    </div>
                                    <div>
                                        <label for="mail_usuario_nuevo">Cambiar Email:</label>
                                        <input type="email" name="mail_usuario_nuevo"  '; echo'placeholder='.$_SESSION['mail_usuario'].'' ;echo '>
                                    </div>
                                    <div id="botones-edit">
                                        <button name="submit-modif-perfil" class="Btn">Editar Perfil
                                            <svg class="svg" viewBox="0 0 512 512">
                                            <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>   
                                        </button>  
                                        <button id="boton-cancelo-edit-perfil" >Cancelar operación.</button>
                                    </div>                                 
                                </form>
                            </div>
                        </div>

                    </div>
  
                    <div id="usuario-reviews">';

                    if( $_SESSION['administrador'] == 0){
                        echo '
                        <h1>Mis Reviews</h1>';
                        $q_reseñas = mysqli_query($conexion, "SELECT * FROM moviely.review WHERE id_usuario = '$id_usuario' ");
                        $contName = 1;
                                if ($q_reseñas->num_rows > 0) {
                                    while ($row = $q_reseñas->fetch_assoc()) {
                                        $estrellas = $row['calificacion'];
                                        $id_peli = $row['id_peli'];

                                        $reseña_peli = mysqli_query($conexion, "SELECT titulo FROM moviely.peli WHERE id_peli = ('$id_peli')");
                                        $reseña_peli = $reseña_peli->fetch_assoc();

                                        echo /*aca va un while que pase por todas las reviews*/'
                                        <div class="reseña"'; if($row['estado_review'] > 0){echo'style="border-top: 4px solid #FA3902; border-bottom: 4px solid #FA3902;';} echo'">
                                            <form method="POST" action="MiPerfil.php">
                                                <input type="hidden" name="id_review_elim" value="'.$row['id_review'].'">
                                                <input type="hidden" name="review_elim_peli" value="'.$row['id_peli'].'">
                                                <input type="hidden" name="review_elim_calif" value="'.$row['calificacion'].'">
                                                <button name="boton-eliminar" id="boton-eliminar-reseña" class="Btn">
                                                    <svg class="svg" fill="#ffffff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M5.755,20.283,4,8H20L18.245,20.283A2,2,0,0,1,16.265,22H7.735A2,2,0,0,1,5.755,20.283ZM21,4H16V3a1,1,0,0,0-1-1H9A1,1,0,0,0,8,3V4H3A1,1,0,0,0,3,6H21a1,1,0,0,0,0-2Z"></path></g></svg>
                                                </button>
                                            </form>
                                            
                                            <div id="cont">';
                                                if($row['estado_review'] > 0){
                                                    echo'
                                                    <p style="color:#FA3902;"><strong>Review Banneada por Administradores<strong></p>
                                                    ';
                                                }
                                                echo'
                                                <a href="info.php?id_peli='.$id_peli.'" class="imp_review">'.$reseña_peli['titulo'].'</a> 
                                                <div id="estre-review" >
                                                    <fieldset class="rateDisplay rateChico">
                                                        <input type="radio" id="rating10" name="rating'.$contName.'" value="10" '; if ($estrellas ==10  ){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating10" title="5 stars"></label>
                                                        <input type="radio" id="rating9" name="rating'.$contName.'" value="9" '; if ($estrellas >=9  && $estrellas < 10){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating9" title="4 1/2 stars"></label>
                                                        <input type="radio" id="rating8" name="rating'.$contName.'" value="8" '; if ($estrellas >=8 && $estrellas < 9){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating8" title="4 stars"></label>
                                                        <input type="radio" id="rating7" name="rating'.$contName.'" value="7" '; if ($estrellas >=7 && $estrellas < 8){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating7" title="3 1/2 stars"></label>
                                                        <input type="radio" id="rating6" name="rating'.$contName.'" value="6" '; if ($estrellas >=6  && $estrellas < 7){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating6" title="3 stars"></label>
                                                        <input type="radio" id="rating5" name="rating'.$contName.'" value="5" '; if ($estrellas >=5  && $estrellas < 6){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating5" title="2 1/2 stars"></label>
                                                        <input type="radio" id="rating4" name="rating'.$contName.'" value="4" '; if ($estrellas >=4 && $estrellas < 5){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating4" title="2 stars"></label>
                                                        <input type="radio" id="rating3" name="rating'.$contName.'" value="3" '; if ($estrellas >=3 && $estrellas < 4){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating3" title="1 1/2 stars"></label>
                                                        <input type="radio" id="rating2" name="rating'.$contName.'" value="2" '; if ($estrellas >=2 && $estrellas < 3){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating2" title="1 star"></label>
                                                        <input type="radio" id="rating1" name="rating'.$contName.'" value="1" '; if ($estrellas >=1 && $estrellas < 2){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating1" title="1/2 star"></label>
                                                    </fieldset>
                                                </div>
                                                <p>'.$row['comentario'].'</p>     
                                            </div>
                                        </div>';
                                        $contName++;
                                    }
                                } else {
                                    echo '<div class="reseña"><p>Que vacio... Se el primero en comentar!</p></div>';
                                }


                        if (isset($_POST['submit-modif-perfil'])){
                            $nom_nuevo = $_POST['nombre_usuario_nuevo'];
                            $mail_nuevo = $_POST['mail_usuario_nuevo'];

                            $pregunta = mysqli_query($conexion,"SELECT nombre_usuario, mail from usuario where nombre_usuario = '$nom_nuevo' or mail = '$mail_nuevo'");

                            if($pregunta->num_rows > 0 ){
                                $row = $pregunta->fetch_assoc();
                                if($nom_nuevo == $row['nombre_usuario']){
                                    echo'                                                                   
                                    <div class="overlay show" id="overlay-usuario-repe">
                                        <div class="popup">
                                            <span class="popup-close" id="pop-usuario-repe">&times;</span>
                                            <div class="popup-content">
                                                <div class="descripcion_accion"><p>Ups! este nombre de usuario ya esta ocupado :( <br> Prueba con otro!</p></div>
                                            </div>
                                            <div class="popup-buttons">
                                                <button id="boton-usuario-repe" class="boton-cancelo">Intentar denuevo</button>
                                            </div>
                                        </div>
                                    </div>
                                    ';
                                    
                                }
                                else if ($mail_nuevo == $row['mail']){
                                    echo'
                                    <div class="overlay show" id="overlay-mail-repe">
                                        <div class="popup">
                                            <span class="popup-close" id="pop-mail-repe">&times;</span>
                                            <div class="popup-content">
                                                <div class="descripcion_accion"><p>Un usuario con este mail ya esta registrado en otra cuenta!</p></div>
                                            </div>
                                            <div class="popup-buttons">
                                                <button id="boton-mail-repe">Intentar denuevo con otro mail</button>
                                            </div>
                                        </div>
                                    </div>
                                    ';
                                }
                            }
                            else{
                                $id_usuario = $_SESSION['id_usuario'];
                                if($nom_nuevo > "" && $mail_nuevo > ""){
                                    $update = mysqli_query($conexion,"UPDATE usuario SET nombre_usuario = '$nom_nuevo', mail = '$mail_nuevo' WHERE id_usuario = '$id_usuario'");
                                    session_destroy();
                                    header('Location: mail_registrado.php?id_usuario='.$id_usuario.'');
                                }
                                else if($mail_nuevo == "" && $nom_nuevo > ""){
                                    $update = mysqli_query($conexion,"UPDATE usuario SET nombre_usuario = '$nom_nuevo' WHERE id_usuario = '$id_usuario'");
                                    session_destroy();
                                    header("Location:LogInUsuario.php");
                                }
                                else if($mail_nuevo > "" && $nom_nuevo == ""){ 
                                    $update = mysqli_query($conexion,"UPDATE usuario SET mail = '$mail_nuevo' WHERE id_usuario = '$id_usuario'");
                                    header('Location: mail_registrado.php?id_usuario='.$id_usuario.'');
                                }
                            } 
                        } 
                        
                        if (isset($_POST['id_review_elim'])){
                            $id_review_elim= $_POST['id_review_elim'];
                            $review_peli_elim= $_POST['review_elim_peli'];
                            $review_calif_elim= $_POST['review_elim_calif'];

                            $estado = mysqli_query($conexion,"SELECT estado_review FROM moviely.review WHERE id_review = '$id_review_elim';"); 
                            $estado = $estado->fetch_assoc();
                            $info_peli =  mysqli_query($conexion,"SELECT * FROM moviely.peli WHERE id_peli = '$review_peli_elim';"); 
                            $row = $info_peli->fetch_assoc();

                            if($row['cant_review'] > 0 && ($estado['estado_review'] == 0 || $estado['estado_review'] == NULL )){
                                $nueva_cant_reviews =  ($row['cant_review']) - 1;
                                $nueva_cant_estrellas =  ($row['cant_estrellas']) - $review_calif_elim;
                                if($nueva_cant_reviews == 0){
                                    $nueva_calif = 0;
                                }
                                else $nueva_calif= ($nueva_cant_estrellas / $nueva_cant_reviews) ;

                                $update_calif_peli =  mysqli_query($conexion,"UPDATE peli SET calificacion='$nueva_calif', cant_review ='$nueva_cant_reviews', cant_estrellas='$nueva_cant_estrellas' WHERE id_peli='$review_peli_elim';" );        
                            }
                            $elim_review =  mysqli_query($conexion,"DELETE FROM moviely.review WHERE id_review = '$id_review_elim';" );        
                            header('Location:MiPerfil.php');
                        }
                    }
            echo '
            <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
            </main>
            <footer>
                <p>&copy; 2023 Your Movie Reviews</p>
            </footer>
            ';
            
            if(isset($_POST['submit-modif-perfil'])){
                
            } 
        }
        else {header('Location: LogInUsuario.php');};
                    
       
    ?>
    <script src="script/jquery.js"></script>
    <script src="script/pop-ups.js"></script>
    <script src="script/botonTop.js"></script>
    
</body>
</html>