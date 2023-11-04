<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" href="moviely favicon.png" type="image/ico">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Modificación</title>
</head>

<body>
    <?php
        include("conexion.php");
        include("opciones.php");

        if(isset($_SESSION['id_usuario']))
        {
            $id_usuario = $_SESSION['id_usuario'];
            
            $q = "SELECT administrador from usuario where id_usuario = '$id_usuario' and administrador = 1";
            $resultado=mysqli_num_rows(mysqli_query($conexion,$q));
            if($resultado > 0){echo $opciones_admin; $_SESSION['administrador'] = 1;}
            else{
                echo $opciones;
                $_SESSION['administrador'] = 0;
            } 
        }
        else {
            echo $opciones_sin_sesion;
            $_SESSION['administrador'] = 0;
        } 
        echo ' <main> ';
        if($_SESSION['administrador'] > 0){
            echo '<div class="completador">
                <h1>';
                // EMPIEZA EL MAIN
                if(isset($_POST['submit-modificacion'])){
                    $id_peli = $_POST['id_peli'];
                    $flag_update = 0;

                    $destruc_peli = "DELETE FROM moviely.peli WHERE id_peli = ($id_peli);";
                    $destruc_peli_direc = "DELETE FROM moviely.peli_director WHERE id_peli = ($id_peli);";
                    $destruc_peli_actor = "DELETE FROM moviely.peli_actor WHERE id_peli = ($id_peli);";

                    //variables con modificaciones a cargar
                    $titulo = ($_POST['tituloMod'] == "") ?  str_replace("'", "''",$_POST['tituloRead']) : str_replace("'", "''",$_POST['tituloMod']) ; //verifica modificacion titulo
                    $descrip = ($_POST['descripMod'] == "") ? str_replace("'", "''",$_POST['descripRead'] ) : str_replace("'", "''",$_POST['descripMod'] ); //verifica modificacion descripcion
                    $estreno = $_POST['fecha'];
                    $duracion = 0;
                    $temporada = 0;
    
                    //variables asistentes
                    $direcCont = $_POST['directorCont'];
                    $actCont = $_POST['actorCont'];
                    $genCont =  $_POST['generoCont'];
                    $direcContChau = 0;
                    $actorContChau = 0;
                    $generoContChau = 0;
                    $NuevoDireCont = 0;
                    $NuevoActCont = 0;
                    $NuevoGenCont = 0;

                    //contamos cuantos directores, generos, y actores quieren desvincular
                    if (isset($_POST['unchecked_directors'])) {
                        $uncheckedDirectorIDs = $_POST['unchecked_directors'];
                        $directorIDsArray = explode(',', $uncheckedDirectorIDs);

                        foreach ($directorIDsArray as $directorID) {
                            if($directorID > 0){    $direcContChau ++;  }
                        }
                    }

                    if (isset($_POST['unchecked_actors'])) {
                        $uncheckedActorsIDs = $_POST['unchecked_actors'];
                        $actorsIDsArray = explode(',', $uncheckedActorsIDs);

                        foreach ($actorsIDsArray as $actorID) {
                            if($actorID > 0){    $actorContChau ++;  }
                        }
                    }

                    if (isset($_POST['unchecked_genres'])) {
                        $uncheckedGenresIDs = $_POST['unchecked_genres'];
                        $genresIDsArray = explode(',', $uncheckedGenresIDs);

                        foreach ($genresIDsArray as $genreID) {
                            if($genreID > 0){    $generoContChau ++;  }
                        }
                    }
                    
                    //verificacion duracion o temporadas
                    
                    if($_POST['dur_min'] > 0 && $_POST['temporada'] == 0){  
                        $duracion = $_POST['dur_min'];
                        $temporada = NULL;
                    }
                    else if($_POST['dur_min'] == 0 && $_POST['temporada'] > 0 ){
                        $temporada = $_POST['temporada'];
                        $duracion = NULL;
                    }
                    else{
                        $flag_update=1;
                    }

                    //verificacion archivo imagen
                    if(!empty($_FILES['foto_cargar']['tmp_name']) ){  
                        $target_dir = "posters/";
                        $target_file = $target_dir . date("YmdHis"). basename($_FILES["foto_cargar"]["name"]);
                        $target_tmp = $_FILES["foto_cargar"]["tmp_name"];
                        move_uploaded_file($target_tmp, $target_file);
                        $poster = $target_file;
                    }else{
                        $poster = $_POST['path_poster'];
                    }

                    //verifico de no quedarme sin director, actor o genero
                    $flagD = 0;$flagA = 0;$flagG = 0;
                    if (isset($_POST['checkboxDire'])) {} else {$flagD = 1;}
                    //vincular actor seleccionados
                    if (isset($_POST['checkboxActor'])) {} else { $flagA = 1;  }
                    //vincular generos seleccionados
                    if (isset($_POST['checkboxGenero'])) {} else {  $flagG = 1; }

                    if( isset( $_POST['nombres'] ) ){
                        foreach( $_POST['nombres'] as $indice => $nombre ){        
                            if($nombre != ""){
                                $NuevoDireCont++;  
                            }                       
                        }
                    }
                    if ( $direcContChau == $direcCont && $NuevoDireCont == 0 && $flagD == 1 ) { $flag_update=1; }
                
                    
                    if( isset( $_POST['nombresA'] ) ){
                        foreach( $_POST['nombresA'] as $indice => $nombre ){
                            if($nombre != ""){
                                $NuevoActCont++;  
                            }   
                        }
                    }
                    if ( $actorContChau == $actCont && $NuevoActCont == 0 && $flagA == 1 ) {$flag_update=1;}
                    
                    if ($generoContChau == $genCont && $flagG == 1) {$flag_update=1;}

                    if($flag_update < 1){
                        //nuevos directores
                        if( isset( $_POST['nombres'] ) ){
                            foreach( $_POST['nombres'] as $indice => $nombre ){
                                $nombre = str_replace("'", "''", $_POST['nombres'][$indice]);
                                $apellido = str_replace("'", "''", $_POST['apellidos'][$indice]);

                                if ($nombre != "" && $apellido != ""){
                                    $buscadire = "SELECT id_director FROM moviely.director WHERE nombre=('$nombre') AND apellido=('$apellido')";
                                    
                                    $existedire = mysqli_query($conexion,$buscadire);
        
                                    if ($existedire->num_rows == 0){
                                        $consulta_sql = mysqli_query($conexion,"INSERT INTO director SET nombre='$nombre', apellido='$apellido'");
                                        $existedire = mysqli_query($conexion,$buscadire);
                                    }
                                    $row_dire = mysqli_fetch_assoc($existedire); 
                                    $iddire = $row_dire['id_director'];
        
                                    $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_director WHERE id_peli=($id_peli) AND id_director=($iddire)");
                                    if ($existe_relacion->num_rows==0){
                                        $relacion = mysqli_query($conexion,"INSERT INTO peli_director ( id_peli, id_director) values ( $id_peli , $iddire);");
                                    }
                                }                       
                            }
                        }
                        //eliminamos los directores unchecked
                        foreach ($directorIDsArray as $id){
                            $eliminoDire = mysqli_query($conexion,"DELETE FROM  moviely.peli_director WHERE id_peli=('$id_peli') AND id_director=('$id')");
                        }
                        
                        
                        //nuevos actores
                        if( isset( $_POST['nombresA'] ) ){
                            foreach( $_POST['nombresA'] as $indice => $nombre ){
                                $nombre = str_replace("'", "''", $_POST['nombresA'][$indice]);
                                $apellido = str_replace("'", "''", $_POST['apellidosA'][$indice]);
                                
                                if ($nombre != "" && $apellido != ""){
                                    $buscaactor = "SELECT id_actor FROM moviely.actor WHERE nombre=('$nombre') AND apellido=('$apellido')";
                                    
                                    $existeactor = mysqli_query($conexion,$buscaactor);
        
                                    if ($existeactor->num_rows == 0){
                                        $consulta_sql = mysqli_query($conexion,"INSERT INTO moviely.actor SET nombre='$nombre', apellido='$apellido'");
                                        $existeactor = mysqli_query($conexion,$buscaactor);
                                    }
                                    $row_actor = mysqli_fetch_assoc($existeactor); 
                                    $idactor = $row_actor['id_actor'];
        
                                    $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_actor WHERE id_peli=($id_peli) AND id_actor=($idactor)");
                                    if ($existe_relacion->num_rows==0){
                                        $relacion = mysqli_query($conexion,"INSERT INTO peli_actor ( id_peli, id_actor) values ( $id_peli , $idactor);");
                                    }
                                }   
                            }
                        }
                        //eliminamos los actores unchecked
                        foreach ($actorsIDsArray as $id){
                            $eliminoActor = mysqli_query($conexion,"DELETE FROM moviely.peli_actor WHERE id_peli=('$id_peli') AND id_actor=('$id')");
                        }
                        
                        //eliminamos los generos unchecked
                        foreach ($genresIDsArray as $id){
                            $eliminoGen = mysqli_query($conexion,"DELETE FROM  moviely.peli_genero WHERE id_peli=('$id_peli') AND id_genero=('$id')");
                        }    

                        // vinculamos directores selecionados
                        if (isset($_POST['checkboxDire'])) {
                            $checkedCheckboxValues = $_POST['checkboxDire'];
    
                            foreach ($checkedCheckboxValues as $checkedCheckboxValue) { 
                                $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_director WHERE id_peli=($id_peli) AND id_director=($checkedCheckboxValue)");
                                if ($existe_relacion->num_rows==0){
                                    $relacion = mysqli_query($conexion,"INSERT INTO peli_director ( id_peli, id_director) values ( '$id_peli' , '$checkedCheckboxValue' );");
                                }
                            }
                        }
                        //vincular actor seleccionados
                        if (isset($_POST['checkboxActor'])) {
                            $checkedCheckboxValues = $_POST['checkboxActor'];
                    
                            foreach ($checkedCheckboxValues as $checkedCheckboxValue) {
                                $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_actor WHERE id_peli=($id_peli) AND id_actor=($checkedCheckboxValue)");
                                if ($existe_relacion->num_rows==0){
                                    $relacion = mysqli_query($conexion,"INSERT INTO peli_actor ( id_peli, id_actor) values ( $id_peli , $checkedCheckboxValue);");
                                }
                            }
                        }
                        //vincular generos seleccionados
                        if (isset($_POST['checkboxGenero'])) {
                            $checkedCheckboxValues = $_POST['checkboxGenero'];
            
                            foreach ($checkedCheckboxValues as $checkedCheckboxValue) {
                                $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_genero WHERE id_peli=($id_peli) AND id_genero=($checkedCheckboxValue)");
                                if ($existe_relacion->num_rows==0){
                                    $relacion = mysqli_query($conexion,"INSERT INTO moviely.peli_genero ( id_peli, id_genero) values ( $id_peli, $checkedCheckboxValue);");
                                }
                            }
                        }
        
                        $update= "UPDATE moviely.peli SET titulo=('$titulo'), path_poster=('$poster'),estreno=('$estreno'), descripcion=('$descrip'),temporada=('$temporada'),duracion=('$duracion') WHERE id_peli=('$id_peli')";
                        $resultado_update = mysqli_query($conexion,$update);
                        if ($resultado_update){echo 'Se a modificado con exito el contenido!';} else {echo '<h1>No se ha podido modificar el contenido, inetente nuevamente. Si el error persiste, comuniquese con el administrador</h1>';}
                    }
                    else{
                        echo 'No se a modificado el contenido por error de carga, Asegurese de que deje registrado al menos un director, un actor y un genero para el Contenido; y de completar el campo de un solo tipo de contenido (Pelicula o Serie) ';
                    }
                    echo '  </h1>
                        <a href="info.php?id_peli='.$id_peli.'">Volver a la visualizacion del contenido</a><br>
                        <a href="index.php">Volver a la home</a>
                    </div>';
                }
                else{
                    echo '
                    <div style="width:80%; margin: auto; padding-top:3%;">
                        <h1>Acceso Negado</h1>
                    </div>';    
                }
        }
        else {
            echo '
            <div style="width:80%; margin: auto; padding-top:3%;">
                <h1>Acceso Negado</h1>
            </div>';      
        }
        echo '</main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>'; 
	?> 
</body>
</html>

