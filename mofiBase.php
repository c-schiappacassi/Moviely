<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Admin</title>
</head>

<body>
    <?php
        include("conexion.php");
        include("opciones.php");

        echo '<header>';

        if(isset($_SESSION['id_usuario']))
        {
            $id_usuario = $_SESSION['id_usuario'];
            
            $q = "SELECT * from usuario where id_usuario = '$id_usuario' and administrador =1";
            $resultado=mysqli_num_rows(mysqli_query($conexion,$q));
            if($resultado!=0) echo $opciones_admin;
            else echo $opciones;

            if(isset($_POST['limpiar'])) //Limpiar filtro
            {
                $_POST['usuario'] = '';
                $_POST['tipo'] = '';
            }  
        }
        else echo $opciones_sin_sesion;

        echo '</header>
            <main> 
            
            <div class="completador">
                <h1>';
                // EMPIEZA EL MAIN

                if(isset($_POST['submit'])){
                    $id_peli = $_POST['id_peli'];
                    $flag_update = 0;

                    //variables con modificaciones a cargar
                    $titulo = ($_POST['tituloMod'] == "") ? $_POST['tituloRead'] : $_POST['tituloMod']; //verifica modificacion titulo
                    $descrip = ($_POST['descripMod'] == "") ? $_POST['descripRead'] : $_POST['descripMod']; //verifica modificacion descripcion
                    $estreno = $_POST['fecha'];
                    $duracion = 0;
                    $temporada = 0;
                
                    $uncheckedDirectors = isset($_POST['uncheckeddirectors']) ? $_POST['uncheckeddirectors'] : [];
                    $uncheckedActors = isset($_POST['uncheckedactors']) ? $_POST['uncheckedactors'] : [];
                    $uncheckedGenres = isset($_POST['uncheckedgenres']) ? $_POST['uncheckedgenres'] : [];
                    
                    //variables asistentes
                    $direcCont = $_POST['directorCont'];
                    $actCont = $_POST['actorCont'];
                    $genCont =  $_POST['generoCont'] ;
                    $NuevoDireCont = 0;
                    $NuevoActCont = 0;
                    $NuevoGenCont = 0;
                    
                    //verificacion duracion o temporadas
                    if ($_POST['dur_min'] > 0 ){
                        $duracion = $_POST['dur_min'];
                        $temporada = NULL;
                    }
                    else if($_POST['temporada'] > 0){
                        $temporada = $_POST['temporada'];
                        $duracion = NULL;
                    }
                    else {
                        if ($_POST['dur_registro'] > 0){
                            $duracion = $_POST['dur_registro'];
                            $temporada = NULL;
                        }
                        else {
                            $temporada = $_POST['temp_registro'];
                            $duracion = NULL;
                        }
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
                    if( isset( $_POST['nombres'] ) ){
                        foreach( $_POST['nombres'] as $indice => $nombre ){        
                            if($nombre != ""){
                                $NuevoDireCont++;  
                            }                       
                        }
                    }
                    if (count($uncheckedDirectors) == $direcCont && $NuevoDireCont == 0) { $flag_update=1; }
                
                    
                    if( isset( $_POST['nombresA'] ) ){
                        foreach( $_POST['nombresA'] as $indice => $nombre ){
                            if($nombre != ""){
                                $NuevoActCont++;  
                            }   
                        }
                    }

                    if (count($uncheckedActors) == $actCont && $NuevoActCont == 0 ) {$flag_update=1;}
                    
                    
                    if( isset( $_POST['nombresG'] ) ){
                        foreach( $_POST['nombresG'] as $indice => $nombre ){
                            if($nombre != ""){
                                $NuevoGenCont++;
                            }   
                        }
                    }
                    if (count($uncheckedGenres) == $genCont && $NuevoGenCont == 0 ) {$flag_update=1;}

                
                    if($flag_update != 1){
                        //nuevos directores
                        if( isset( $_POST['nombres'] ) ){
                            foreach( $_POST['nombres'] as $indice => $nombre ){
                                $apellido = $_POST['apellidos'][$indice];
                                
                                if($nombre != ""){
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
                                    $NuevoDireCont++;  
                                }                       
                            }
                        }
                        
                        //eliminamos los directores unchecked
                        foreach ($uncheckedDirectors as $id){
                            $eliminoDire = mysqli_query($conexion,"DELETE FROM  moviely.peli_director WHERE id_peli=('$id_peli') AND id_director=('$id')");
                        }
                        
                        
                        //nuevos actores
                        if( isset( $_POST['nombresA'] ) ){
                            foreach( $_POST['nombresA'] as $indice => $nombre ){
                                $apellido = $_POST['apellidosA'][$indice];
                                
                                if($nombre != ""){
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
        
                                    $NuevoActCont++;  
                                }   
                            }
                        }
                        //eliminamos los actores unchecked
                        foreach ($uncheckedActors as $id){
                            $eliminoActor = mysqli_query($conexion,"DELETE FROM  moviely.peli_actor WHERE id_peli=('$id_peli') AND id_actor=('$id')");
                        }
                        
        
                        //nuevos generos
                        if( isset( $_POST['nombresG'] ) ){
                            foreach( $_POST['nombresG'] as $indice => $nombre ){
                                
                                if($nombre != ""){
                                    $buscagenero = "SELECT id_genero FROM moviely.genero WHERE nombre_genero=('$nombre')";
                                    
                                    $existegenero = mysqli_query($conexion,$buscagenero);
        
                                    if ($existegenero->num_rows == 0){
                                        $consulta_sql = mysqli_query($conexion,"INSERT INTO moviely.genero SET nombre_genero='$nombre'");
                                        $existegenero = mysqli_query($conexion,$buscagenero);
                                    }
                                    $row_genero = mysqli_fetch_assoc($existegenero); 
                                    $idgenero = $row_genero['id_genero'];
        
                                    $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_genero WHERE id_peli=($id_peli) AND id_genero=($idgenero)");
                                    if ($existe_relacion->num_rows==0){
                                        $relacion = mysqli_query($conexion,"INSERT INTO moviely.peli_genero ( id_peli, id_genero) values ( $id_peli , $idgenero);");
                                    }
                                    $NuevoGenCont++;
                                }   
                            }
                        }
                        //eliminamos los generos unchecked
                        foreach ($uncheckedGenres as $id){
                            $eliminoGen = mysqli_query($conexion,"DELETE FROM  moviely.peli_genero WHERE id_peli=('$id_peli') AND id_genero=('$id')");
                        }    
        
                        $update= "UPDATE moviely.peli SET titulo=('$titulo'),path_poster=('$poster'),estreno=('$estreno'),descripcion=('$descrip'),temporada=('$temporada'),duracion=('$duracion') WHERE id_peli=('$id_peli')";
                        $resultado_update = mysqli_query($conexion,$update);
                        if ($resultado_update){echo 'Se a modificado con exito el contenido!';} else {echo '<h1>No se ha podido modificar el contenido, inetente nuevamente. Si el error persiste, comuniquese con el administrador</h1>';}
                    }
                    else{
                        echo 'No se a modificado el contenido por error de carga, Asegurese de que deje registrado al menos un director, un actor y un genero para el Contenido ';
                    }
                }

        echo '  </h1>
            </div>
        </main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>'; 

	?>  
       <script src="script/jquery.js"></script>      
        <script src="script/etiquetas-dinamicas.js"></script>    
</body>
</html>

