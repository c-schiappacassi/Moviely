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
            <main>';// EMPIEZA EL MAIN

        include("conexion.php");
        if (isset($_POST['submit']))
        {

            $titulo = $_POST['titulo'];
            $descrip = $_POST['descrip'];
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
                if($duracion_peli > 0){  
                    $registro = "INSERT INTO peli (titulo, path_poster, estreno, descripcion, duracion, calificacion, cant_review,cant_estrellas) values ('$titulo', '$target_file', '$fecha', '$descrip', '$duracion_peli', 0,0,0);" ;
                }
                else if($temporadas_serie > 0){
                    $registro = "INSERT INTO peli (titulo, path_poster, estreno, descripcion, temporada) values ('$titulo', '$target_file', '$fecha', '$descrip', '$temporadas_serie'); " ;
                }
                else{
                    echo '<h2>Faltaron datos de la duración del contenido (minutos si es pelicula, temporadas si es serie), intente nuevamente sin obviar datos</h2>';
                }

                $result = mysqli_query($conexion,$registro);

                if($result=1){
                    echo '<h2>La pelicula se dio de alta correctamente</h2>';
                    $result_peli = mysqli_query($conexion,"SELECT id_peli FROM moviely.peli WHERE titulo = ('$titulo')" );
                    $row_peli = mysqli_fetch_assoc($result_peli); 
                    $idpeli = $row_peli['id_peli'];
                    
                    if( isset( $_POST['nombres'] ) ){
                        foreach( $_POST['nombres'] as $indice => $nombre ){
                            $apellido = $_POST['apellidos'][$indice];

                            $buscadire = "SELECT id_director FROM moviely.director WHERE nombre=('$nombre') AND apellido=('$apellido')";
                            
                            $existedire = mysqli_query($conexion,$buscadire);

                            if ($existedire->num_rows == 0){
                                $consulta_sql = mysqli_query($conexion,"INSERT INTO director SET nombre='$nombre', apellido='$apellido'");
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

                    if( isset( $_POST['nombresA'] ) ){
                        foreach( $_POST['nombresA'] as $indice => $nombre ){
                            $apellido = $_POST['apellidosA'][$indice];

                            $buscaactor = "SELECT id_actor FROM moviely.actor WHERE nombre=('$nombre') AND apellido=('$apellido')";
                            
                            $existeactor = mysqli_query($conexion,$buscaactor);

                            if ($existeactor->num_rows == 0){
                                $consulta_sql = mysqli_query($conexion,"INSERT INTO moviely.actor SET nombre='$nombre', apellido='$apellido'");
                                $existeactor = mysqli_query($conexion,$buscaactor);
                            }
                            $row_actor = mysqli_fetch_assoc($existeactor); 
                            $idactor = $row_actor['id_actor'];

                            $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_actor WHERE id_peli=($idpeli) AND id_actor=($idactor)");
                            if ($existe_relacion->num_rows==0){
                                $relacion = mysqli_query($conexion,"INSERT INTO peli_actor ( id_peli, id_actor) values ( $idpeli , $idactor);");
                            }
                        }
                    }

                    if( isset( $_POST['nombresG'] ) ){
                        foreach( $_POST['nombresG'] as $indice => $nombre ){
                            $buscagenero = "SELECT id_genero FROM moviely.genero WHERE nombre_genero=('$nombre')";
                            
                            $existegenero = mysqli_query($conexion,$buscagenero);

                            if ($existegenero->num_rows == 0){
                                $consulta_sql = mysqli_query($conexion,"INSERT INTO moviely.genero SET nombre_genero='$nombre'");
                                $existegenero = mysqli_query($conexion,$buscagenero);
                            }
                            $row_genero = mysqli_fetch_assoc($existegenero); 
                            $idgenero = $row_genero['id_genero'];

                            $existe_relacion= mysqli_query($conexion, "SELECT * FROM moviely.peli_genero WHERE id_peli=($idpeli) AND id_genero=($idgenero)");
                            if ($existe_relacion->num_rows==0){
                                $relacion = mysqli_query($conexion,"INSERT INTO moviely.peli_genero ( id_peli, id_genero) values ( $idpeli , $idgenero);");
                            }
                        }
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

                    <div class="cont-espaciado mas">
                        <label class="importante">Seleccione  foto:
                            <input type="file" name="foto_cargar" id="foto_cargar" required>
                        </label>
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
                        <div>
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
                    <div>
                        <div>
                            <span>Nombre del Genero</span><input type="text" name="nombresG[]" autocomplete="off" />
                        </div>
                    </div>
                </div>
                <input class="boton_agregar" type="button" value="+ Agregar" id="agregarG" />
            </div>

            <input type="submit" name="submit" value="Registrar Contenido">
        </form>
                ';
        }

        echo '</main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>';  

	?>  
        <script src="script/lightbox-plus-jquery.js"></script>
        <script src="script/etiquetas-dinamicas.js"></script>
        
</body>
</html>