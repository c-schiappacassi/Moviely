<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="icon" href="moviely favicon.png" type="image/ico">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Alta</title>
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

        include("conexion.php");

        if( $_SESSION['administrador'] > 0){
            if (isset($_POST['submit']))
            {
    
                $titulo = str_replace("'", "''", $_POST['titulo']);
                $descrip = str_replace("'", "''", $_POST['descrip']);                
                $fecha = $_POST['fecha'];
                $duracion_peli = $_POST['dur_min'];
                $temporadas_serie = $_POST['temporada'];
                
                //variables de guardado de imagen
                $target_dir = "posters/";
                $target_file = $target_dir . date("YmdHis"). basename($_FILES["foto_cargar"]["name"]);
                $target_tmp = $_FILES["foto_cargar"]["tmp_name"];
    
                $existe = mysqli_query($conexion,"SELECT id_peli FROM moviely.peli WHERE titulo = ('$titulo')" );
    
                move_uploaded_file($target_tmp, $target_file);
    
                if ($existe->num_rows > 0) {
                    echo '<p>Una pelicula con este titulo ya existe en la base de datos</p>';
                } else 
                {
                    if($duracion_peli > 0 && $temporadas_serie <= 0){  
                        $registro = "INSERT INTO peli (titulo, path_poster, estreno, descripcion, duracion) values ('$titulo', '$target_file', '$fecha', '$descrip', '$duracion_peli');" ;
                        $result = mysqli_query($conexion,$registro);
                    }
                    else if($temporadas_serie > 0 && $duracion_peli <= 0 ){
                        $registro = "INSERT INTO peli (titulo, path_poster, estreno, descripcion, temporada) values ('$titulo', '$target_file', '$fecha', '$descrip', '$temporadas_serie'); " ;
                        $result = mysqli_query($conexion,$registro);
                    }
                    else{
                        echo '<h2>Faltaron datos de la duración del contenido (minutos si es pelicula, temporadas si es serie), intente nuevamente sin obviar datos</h2>';
                    }
    
                    if($result == 1){
                        $flagD = 0; $flagA = 0; $flagG = 0;
                        $result_peli = mysqli_query($conexion,"SELECT id_peli FROM moviely.peli WHERE titulo = ('$titulo')" );
                        $row_peli = mysqli_fetch_assoc($result_peli); 
                        $idpeli = $row_peli['id_peli'];
    
                        $NuevoDireCont = 0;  
                        $NuevoActCont = 0;
                        $NuevoGenCont = 0;
    
                        // querys de error:
                        $destruc_peli = "DELETE FROM moviely.peli WHERE id_peli = ($idpeli);";
                        $destruc_peli_direc = "DELETE FROM moviely.peli_director WHERE id_peli = ($idpeli);";
                        $destruc_peli_actor = "DELETE FROM moviely.peli_actor WHERE id_peli = ($idpeli);";
                        
                        if( isset( $_POST['nombres'] ) ){
                            foreach( $_POST['nombres'] as $indice => $nombre ){        
                                if($nombre != ""){
                                    $NuevoDireCont++;  
                                }                       
                            }
                        }
                        
                        if( isset( $_POST['nombresA'] ) ){
                            foreach( $_POST['nombresA'] as $indice => $nombre ){
                                if($nombre != ""){
                                    $NuevoActCont++;  
                                }   
                            }
                        }                   
    
                        //DIRECTORES
                        if (isset($_POST['checkboxDire'])) {
                            $checkedCheckboxValues = $_POST['checkboxDire'];
    
                            foreach ($checkedCheckboxValues as $checkedCheckboxValue) { 
                                $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_director WHERE id_peli=($idpeli) AND id_director=($checkedCheckboxValue)");
                                if ($existe_relacion->num_rows==0){
                                    $relacion = mysqli_query($conexion,"INSERT INTO peli_director ( id_peli, id_director) values ( $idpeli , $checkedCheckboxValue );");
                                }
                            }
                        } else {$flagD = 1;};
                        if( isset( $_POST['nombres'] ) ){
                            foreach( $_POST['nombres'] as $indice => $nombre ){
                                $nombre = str_replace("'", "''", $_POST['nombres'][$indice]);
                                $apellido = str_replace("'", "''", $_POST['apellidos'][$indice]);
                                if ($flagD == 1 && $NuevoDireCont == 0){
                                    $hay_error = mysqli_query($conexion, $destruc_peli);
                                }
                                else if ($nombre > ""){
                                    $flagD = 0;
                                    $buscadire = "SELECT id_director FROM moviely.director WHERE nombre=('$nombre') AND apellido=('$apellido')";
                                
                                    $existedire = mysqli_query($conexion,$buscadire);
    
                                    if ($existedire->num_rows == 0){
                                        $consulta_sql = mysqli_query($conexion,"INSERT INTO director (nombre , apellido) VALUES ('$nombre' , '$apellido' )");
                                        $existedire = mysqli_query($conexion,$buscadire);
                                    }
                                    $row_dire = mysqli_fetch_assoc($existedire); 
                                    $iddire = $row_dire['id_director'];
    
                                    $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_director WHERE id_peli=($idpeli) AND id_director=($iddire)");
                                    if ($existe_relacion->num_rows==0){
                                        $relacion = mysqli_query($conexion,"INSERT INTO peli_director ( id_peli, id_director) values ( $idpeli , $iddire);");
                                    }
    
                                }
                            }
                        }
                        //ACTORES
                        if (isset($_POST['checkboxActor'])) {
                            $checkedCheckboxValues = $_POST['checkboxActor'];
                    
                            foreach ($checkedCheckboxValues as $checkedCheckboxValue) {
                                $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_actor WHERE id_peli=($idpeli) AND id_actor=($checkedCheckboxValue)");
                                if ($existe_relacion->num_rows==0){
                                    $relacion = mysqli_query($conexion,"INSERT INTO peli_actor ( id_peli, id_actor) values ( $idpeli , $checkedCheckboxValue);");
                                }
                            }
                        } else { $flagA = 1;  }
                        if( isset( $_POST['nombresA'] ) ){
                            foreach( $_POST['nombresA'] as $indice => $nombre ){
                                $nombre = str_replace("'", "''", $_POST['nombresA'][$indice]);
                                $apellido = str_replace("'", "''", $_POST['apellidosA'][$indice]);

                                if ($flagA == 1 && $NuevoActCont == 0 ){
                                    $hay_error = mysqli_query($conexion, $destruc_peli_direc);
                                    $hay_error = mysqli_query($conexion, $destruc_peli);
                                }
                                else if ($nombre > ""){
                                    $flagA = 0;
                                    $buscaactor = "SELECT id_actor FROM moviely.actor WHERE nombre=('$nombre') AND apellido=('$apellido')";
                                
                                    $existeactor = mysqli_query($conexion,$buscaactor);
        
                                    if ($existeactor->num_rows == 0){
                                        $consulta_sql = mysqli_query($conexion,"INSERT INTO moviely.actor (nombre , apellido) VALUES ('$nombre', '$apellido')");
                                        $existeactor = mysqli_query($conexion,$buscaactor);
                                    }
                                    $row_actor = mysqli_fetch_assoc($existeactor); 
                                    $idactor = $row_actor['id_actor'];
        
                                    $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_actor WHERE id_peli=($idpeli) AND id_actor=($idactor)");
                                    if ($existe_relacion->num_rows==0){
                                        $relacion = mysqli_query($conexion,"INSERT INTO peli_actor ( id_peli, id_actor) VALUES ( $idpeli , $idactor);");
                                    }
                                }
                            }
                        }
    
                        //GENEROS
                        if (isset($_POST['checkboxGenero'])) {
                            $checkedCheckboxValues = $_POST['checkboxGenero'];
            
                            foreach ($checkedCheckboxValues as $checkedCheckboxValue) {
                                $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_genero WHERE id_peli=($idpeli) AND id_genero=($checkedCheckboxValue)");
                                if ($existe_relacion->num_rows==0){
                                    $relacion = mysqli_query($conexion,"INSERT INTO moviely.peli_genero ( id_peli, id_genero) values ( $idpeli, $checkedCheckboxValue);");
                                }
                            }
                        } else {  $flagG = 1;   }

    
                        if($flagA > 0 || $flagD > 0 || $flagG > 0){
                            
                            echo '
                            <div style="width:80%; margin: auto; padding-top:3%;">
                                <h2>La pelicula NO se dio de alta correctamente, intente nuevamente con datos validos</h2>
                            </div>';
                        }
                        else{
                            echo '  
                            <div style="width:80%; margin: auto; padding-top:3%;">
                                <h2>La pelicula se dio de alta correctamente</h2>
                                <a href="info.php?id_peli='.$idpeli.'">Visualizar el contenido recien cargado</a>
                            </div>';
                        }
                    } else {  echo '<h2>La pelicula NO se dio de alta correctamente, intente nuevamente con datos validos</h2>';}
                }
    
            }
            else
            {
                echo '
                <form class="form_alta_peli" method="post" action="AltaPeli.php" enctype="multipart/form-data"> 
                <div class="divisor">
                    <div class="cont-info">
                        <div class="cont-espaciado">
                            <label class="importante">Título <br>
                                <input id="titulo" type="text" name="titulo" required>
                            </label>
                        </div>
                        <div class="cont-espaciado">
                            <label class="importante">Descripción <br>
                                <textarea  name="descrip" id="descripcion" cols="30" rows="10" required></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="cont-info">
                        <div class="cont-espaciado">
                            <label class="importante">Fecha de estreno <br>
                                <input type="date" name="fecha" required>
                            </label>
                        </div>
    
                        <div style="display:flex; align-items: center;" class="cont-espaciado mas">
                            <label  class="importante">Poster:</label>
                            <input type="file" name="foto_cargar" id="foto_cargar" required>
                        </div>
        
                        <div class="cont-espaciado" id="mas-espacio">
                            <label class="importante" for="tipo">Tipo de Contenido</label>
                            <select class="tipo" name="tipo" required >
                                <option>Selecciona</option>
                                <option value="duracion">Película</option>
                                <option value="temporadas">Serie</option>
                            </select>
                            <div class="cont-espaciado">
                                <label class="op" id="tipo_duracion">Duracion en minutos
                                        <input type="number" name="dur_min" >
                                </label>
            
                                <label class="op" id="tipo_temporadas">Cantidad de temporadas
                                        <input type="number" name="temporada" >
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="divisor">
                    <div class="cont-dinamicas">
                        <div id="div-director" class="div-repetidor">
                            <p class="importante">Directores</p>
                            <input type="text" id="checkboxSearchDire" placeholder="Buscar en el Sistema">
                            <div class="custom-scroll" id="checkboxContainerDire">
                                ';
                                $todos_direc = mysqli_query($conexion,"SELECT * FROM moviely.director");
                                while ($row_direc = $todos_direc->fetch_assoc()) {
                                    echo'
                                    <div class="checkbox-container-Dire">
                                        <label>'.$row_direc['nombre'].' '.$row_direc['apellido'].'</label>
                                        <input type="checkbox" name="checkboxDire[]" id="'.$row_direc['id_director'].'" value="'.$row_direc['id_director'].'" class="checkboxDire" data-name="'.$row_direc['nombre'].' '.$row_direc['apellido'].'">
                                    </div>
                                    ';
                                }
                                echo '
                            </div>
                            <p style="font-size:1.5rem;">Si no existe en el Sistema, <span style="font-weight:bold; ">Creelo</span>:</p>
                            <p>(Preste atención a la ortografía, Comience con Mayúscula)</p>
                            <div class="text_repe" >
                                <div>
                                    <span>Nombre</span><input type="text" name="nombres[]" autocomplete="off" />
                                </div>
                                <div>
                                    <span>Apellido</span><input type="text" name="apellidos[]" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <input class="boton_agregar" type="button" value="+ Agregar" id="agregarD" />
                    </div>
                    <div class="cont-dinamicas">
                        <div id="div-actor" class="div-repetidor">
                            <p class="importante">Actores</p>
                            <input type="text" id="checkboxSearchActor" placeholder="Buscar en el Sistema">
                            <div class="custom-scroll" id="checkboxContainerActor">
                                ';
                                $todos_Actorc = mysqli_query($conexion,"SELECT * FROM moviely.actor");
                                while ($row_Actor = $todos_Actorc->fetch_assoc()) {
                                    echo'
                                    <div class="checkbox-container-Actor">
                                        <label>'.$row_Actor['nombre'].' '.$row_Actor['apellido'].'</label>
                                        <input type="checkbox" name="checkboxActor[]" id="'.$row_Actor['id_actor'].'" value="'.$row_Actor['id_actor'].'" class="checkboxActor" data-name="'.$row_Actor['nombre'].' '.$row_Actor['apellido'].'">
                                    </div>
                                    ';
                                }
                                echo '
                            </div>
                            <p style="font-size:1.5rem;">Si no existe en el Sistema, <span style="font-weight:bold; ">Creelo</span>:</p>
                            <p>(Preste atención a la ortografía, Comience con Mayúscula)</p>
                            <div>
                                <div>
                                    <span>Nombre</span><input type="text" name="nombresA[]" autocomplete="off" />
                                </div>
                                <div>
                                    <span>Apellido</span><input type="text" name="apellidosA[]" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <input class="boton_agregar" type="button" value="+ Agregar" id="agregarA" />
                    </div>
                </div>
                
                <div class="cont-dinamicas cont-genero">
                    <div id="div-genero" class="div-repetidor">
                        <p class="importante">Generos</p>
                        <div id="checkboxContainerGenero">
                            ';
                            $todos_Genero = mysqli_query($conexion,"SELECT * FROM moviely.genero ORDER BY nombre_genero ASC");
                            while ($row_Genero = $todos_Genero->fetch_assoc()) {
                                echo'
                                <div class="checkbox-container-Genero">
                                    <label>'.$row_Genero['nombre_genero'].'</label>
                                    <input type="checkbox" name="checkboxGenero[]" id="'.$row_Genero['id_genero'].'" value="'.$row_Genero['id_genero'].'" class="checkboxGenero" data-name="'.$row_Genero['nombre_genero'].'">
                                </div>
                                ';
                            }
                            echo '
                        </div>
                    </div>
                </div>
                <input id="res-cont" type="submit" name="submit" value="Registrar Contenido">
            </form>
                    ';
            }
        }
        else{
           echo ' <div style="width:80%; margin: auto; padding-top:3%;">
            <h1>Acceso Negado</h1>
            </div>';
        }
        echo '
        <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
        </main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>';  

	?>  
        <script src="script/jquery.js"></script>
        <script src="script/checked.js"></script>
        <script src="script/etiquetas-dinamicas.js"></script>
        <script src="script/botonTop.js"></script>
</body>
</html>