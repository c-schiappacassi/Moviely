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

      
        if (isset($_GET['submit-busca'])) {

            $id_busca= $_GET['busca_id'];
            $titulo_busca= $_GET['busca_titulo'] ;

            if ($titulo_busca != ""){
                $encontrado = mysqli_query($conexion,"SELECT id_peli FROM moviely.peli WHERE titulo = ('$titulo_busca')" );
                if ($encontrado->num_rows > 0){
                    $id_busca =  mysqli_fetch_assoc($encontrado);
                    $id_busca = $id_busca['id_peli'];
                } 
            }
            $encontrado = mysqli_query($conexion,"SELECT * FROM moviely.peli WHERE id_peli = ('$id_busca')" );

            if ($encontrado->num_rows > 0){
                $row_encontrado = mysqli_fetch_assoc($encontrado); 
                
    
                    echo '
                    <form class="form_alta_peli" method="POST" action="mofiBase.php" enctype="multipart/form-data"> 
                        <div class="divisor">
                            <div class="cont-info">
                                <div class="cont-espaciado">
                                    <label class="importante">Título
                                        <label style="font-size: 1rem;"> Modificar: <input type="checkbox" id="modiTit" name="modiTit"/></label>
                                        <br>
                                        <input id="tituloRead" type="text"  name="tituloRead" readonly value="'. $row_encontrado['titulo'].'" required>
                                        <input id="tituloMod" type="text"  name="tituloMod" placeholder="Escriba aquí..." >
                                    </label>
                                </div>
                                <input name="id_peli" type="hidden" value="'.$row_encontrado['id_peli'].'">
                                <div class="cont-espaciado">
                                    <label class="importante">Descripción
                                        <label style="font-size: 1rem;"> Modificar: <input type="checkbox" id="modiDes" name="modiDes"/></label>
                                        <br>
                                        <textarea readonly name="descripRead" id="descripcionRead" cols="30" rows="10" required>'. $row_encontrado['descripcion'].'</textarea>
                                        <textarea name="descripMod" id="descripcionMod" cols="30" rows="10" placeholder="Escriba aquí..." ></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="cont-info">
                                <div class="cont-espaciado">
                                    <label class="importante">Fecha de estreno <br>
                                        <input type="date" name="fecha" value="'. $row_encontrado['estreno'].'" required>
                                    </label>
                                </div>

                                <div class="cont-espaciado mas">
                                    <label class="importante">Poster:
                                        <input type="file" name="foto_cargar" id="foto_cargar" >
                                    </label>
                                </div>
                                <input name="path_poster" type="hidden" value="'.$row_encontrado['path_poster'].'">
                                <div class="cont-viejo" id="viejo-imagen">
                                    <p>Poster actual</p>
                                    <img style="width: 100px;" src="'.$row_encontrado['path_poster'].'." alt="Movie Posters">
                                </div>
                
                                <div class="cont-espaciado" id="mas-espacio">
                                    <label class="importante" for="tipo">Tipo de Contenido</label>
                                    <select class="tipo" name="tipo" >
                                        <option>Selecciona</option>
                                        <option value="duracion">Película</option>
                                        <option value="temporadas">Serie</option>
                                    </select>

                                    <div class="cont-viejo" id="viejo-texto">
                                    <p>Categorización actual: </p>';
                                    if($row_encontrado['duracion'] > 0){ echo '<p>Pelicula de '.$row_encontrado['duracion'].' minutos</p>'; }
                                    else {echo '<p>Serie de '.$row_encontrado['temporada'].' temporadas</p>';}
                                    echo '
                                    </div>
                                
                                    <div class="cont-espaciado">
                                        <label class="op" id="tipo_duracion" >Duracion en minutos
                                                <input type="number" name="dur_min" >
                                                <input name="dur_registro" type="hidden" value="'.$row_encontrado['duracion'].'">
                                        </label>
                    
                                        <label class="op" id="tipo_temporadas">Cantidad de temporadas
                                                <input type="number" name="temporada" >
                                                <input name="temp_registro" type="hidden" value="'.$row_encontrado['temporada'].'">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cont-cargados checkbox-group" id="director-cargado">
                        <p class="importante">Directores Cargados</p>';
                            $RelacionCargados = mysqli_query($conexion, "SELECT id_director FROM moviely.peli_director WHERE id_peli = ('$id_busca')");
                            $directorCont = $RelacionCargados->num_rows;
                            echo '<input type="hidden" name="directorCont" value="'.$directorCont.'">';

                            if ($RelacionCargados->num_rows > 0) {
                                while ($rowID = $RelacionCargados->fetch_assoc()) {
                                    $directorId = $rowID['id_director'];
                                    $direcInfo = mysqli_query($conexion, "SELECT * FROM moviely.director WHERE id_director = '$directorId'");
                                
                                    
                                    $direcInfoRow = $direcInfo->fetch_assoc();
                                    echo '
                                    <label class="label-cargado">
                                        <input type="checkbox" name="directors[]" id="'.$direcInfoRow['id_director'].'" checked="checked" value="'.$direcInfoRow['id_director'].'" />
                                        '.$direcInfoRow['nombre'].' '.$direcInfoRow['apellido'].'
                                        <input type="hidden" name="uncheckedDirectors" id="uncheckedDirectors" value="">
                                    </label>  
                                    ';
                                }
                            } else {
                                echo '<p>No directors found.</p>';
                            }
                        echo'    
                        </div>

                        <div class="cont-cargados checkbox-group" id="actor-cargado">
                        <p class="importante">Actores Cargados</p>';
                        $RelacionCargados = mysqli_query($conexion, "SELECT id_actor FROM moviely.peli_actor WHERE id_peli = ('$id_busca')");
                        $actorCont = $RelacionCargados->num_rows;
                        echo '<input type="hidden" name="actorCont" value="'.$actorCont.'">';

                        if ($RelacionCargados->num_rows > 0) {
                            while ($rowID = $RelacionCargados->fetch_assoc()) {
                                $actorId = $rowID['id_actor'];
                                $actorInfo = mysqli_query($conexion, "SELECT * FROM moviely.actor WHERE id_actor = '$actorId'");

                                $actorInfoRow = $actorInfo->fetch_assoc();
                                echo '
                                <label class="label-cargado">
                                    <input type="checkbox" name="actors[]" id="'.$actorInfoRow['id_actor'].'" value="'.$actorInfoRow['id_actor'].'" checked="checked"/>
                                    '.$actorInfoRow['nombre'].' '.$actorInfoRow['apellido'].'
                                    <input type="hidden" name="uncheckedActors" id="uncheckedActors" value="">                                    
                                </label>  
                                ';
                            }
                        } else {
                            echo '<p>No actors found.</p>';
                        }
                        echo'    
                        </div>

                        <div id="genero-cargado" class="checkbox-group">
                        <p class="importante">Generos Cargados</p>
                        ';
                        
                        $RelacionCargados = mysqli_query($conexion, "SELECT id_genero FROM moviely.peli_genero WHERE id_peli = ('$id_busca')");
                        $generoCont = $RelacionCargados->num_rows;
                        echo '<input type="hidden" name="generoCont" value="'.$generoCont.'">';

                        if ($RelacionCargados->num_rows > 0) {
                            while ($rowID = $RelacionCargados->fetch_assoc()) {
                                $generoId = $rowID['id_genero'];
                                $generoInfo = mysqli_query($conexion, "SELECT * FROM moviely.genero WHERE id_genero = '$generoId'");
                                
                                
                                $generoInfoRow = $generoInfo->fetch_assoc();
                                echo '
                                <label class="label-cargado"> 
                                    <input type="checkbox" name="genres[]" id="'.$generoInfoRow['id_genero'].'" checked="checked" value="'.$generoInfoRow['id_genero'].'" />
                                    '.$generoInfoRow['nombre_genero'].' 
                                    <input type="hidden" name="uncheckedGenres" id="uncheckedGenres" value="">
                                    </label>  
                                ';
                            }
                        } else {
                            echo '<p>No actors found.</p>';
                        }
                        echo'    
                        </div>


                        <div class="divisor cont-espaciado">
                            <div class="cont-dinamicas">
                                <div id="div-director" class="div-repetidor">
                                    <p class="importante">Agregar directores</p>
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
                                    <p class="importante">Agregar actores</p>
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
                                <p class="importante">Agregar generos</p>
                                <div>
                                    <div>
                                        <span>Nombre del Genero</span><input type="text" name="nombresG[]" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <input class="boton_agregar" type="button" value="+ Agregar" id="agregarG" />
                        </div>
                        <input type="submit" name="submit" value="Registrar Modificación"> 
                    </form>
                ';
                } 
            }else {echo '<p class="importante">No hay contenido bajo ese registro</p>';}
        


        echo '</main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>'; 

	?>  
        <script src="script/jquery.js"></script>   
        <script>
            
            const checkboxT = document.getElementById("modiTit");
            const checkboxD = document.getElementById("modiDes");
            $("#descripcionRead").show();
            $("#descripcionMod").hide();
            $("#tituloRead").show();
            $("#tituloMod").hide();
      
            checkboxD.addEventListener("change", function() {
                if (checkboxD.checked) {
                    $("#descripcionRead").hide();
                    $("#descripcionMod").show();
                } else {
                    $("#descripcionRead").show();
                    $("#descripcionMod").hide();
                }
            });

            checkboxT.addEventListener("change", function() {
                if (checkboxT.checked) {
                    $("#tituloRead").hide();
                    $("#tituloMod").show();
                } else {
                    $("#tituloRead").show();
                    $("#tituloMod").hide();
                }
            });
        </script>   
        <script src="script/check.js"></script> 
        <script src="script/etiquetas-dinamicas.js"></script>    
</body>
</html>