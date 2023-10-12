<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
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
            if($resultado!=0) echo $opciones_admin;
            else echo $opciones;

            if(isset($_POST['limpiar'])) //Limpiar filtro
            {
                $_POST['usuario'] = '';
                $_POST['tipo'] = '';
            }  
        }
        else echo $opciones_sin_sesion;

        echo '
            <main>';// EMPIEZA EL MAIN

      
        if (isset($_GET['submit-modif'])) {

            $id_busca= $_GET['busca_id'];

            $encontrado = mysqli_query($conexion,"SELECT * FROM moviely.peli WHERE id_peli = ('$id_busca')" );
            
            if ($encontrado->num_rows > 0){
                $row_encontrado = mysqli_fetch_assoc($encontrado); 
                
    
                    echo '
                    <form id="form_alta_peli" class="form_alta_peli" method="POST" action="mofiBase.php" enctype="multipart/form-data"> 
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
                        echo '<input type="hidden" name="directorCont" value="' . $directorCont . '">';
                       

                        if ($RelacionCargados->num_rows > 0) {
                            while ($rowID = $RelacionCargados->fetch_assoc()) {
                                $directorId = $rowID['id_director'];
                                $direcInfo = mysqli_query($conexion, "SELECT * FROM moviely.director WHERE id_director = '$directorId'");
                        
                                $direcInfoRow = $direcInfo->fetch_assoc();
                                $checkboxId = 'director_' . $direcInfoRow['id_director']; // Unique ID for each checkbox
                                $checkboxName = 'directors[]'; // Name for all checkboxes
                        
                                echo '
                                <label class="label-cargado">
                                    <input type="checkbox" id="'.$direcInfoRow['id_director'].'" class="unchecked-Dire" name="directors_unchecked[]" checked="checked">
                                    '.$direcInfoRow['nombre'].' '.$direcInfoRow['apellido'].'
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
                                $actorId = $rowID['id_actor']; // Update variable names
                                $actorInfo = mysqli_query($conexion, "SELECT * FROM moviely.actor WHERE id_actor = '$actorId'"); // Update table name
                        
                                $actorInfoRow = $actorInfo->fetch_assoc(); // Update variable names
                                $checkboxId = 'actor_' . $actorInfoRow['id_actor']; // Unique ID for each checkbox
                                $checkboxName = 'actors[]'; // Name for all checkboxes
                        
                                echo '
                                <label class="label-cargado">
                                    <input type="checkbox" id="'.$actorInfoRow['id_actor'].'" class="unchecked-Actors" name="actors_unchecked[]" checked="checked"> <!-- Update class and name -->
                                    '.$actorInfoRow['nombre'].' '.$actorInfoRow['apellido'].' <!-- Update field names -->
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
                                $genreId = $rowID['id_genero']; // Update variable names
                                $genreInfo = mysqli_query($conexion, "SELECT * FROM moviely.genero WHERE id_genero = '$genreId'"); // Update table name
                        
                                $genreInfoRow = $genreInfo->fetch_assoc(); // Update variable names
                                $checkboxId = 'genre_' . $genreInfoRow['id_genero']; // Unique ID for each checkbox
                                $checkboxName = 'genres[]'; // Name for all checkboxes
                        
                                echo '
                                <label class="label-cargado">
                                    <input type="checkbox" id="'.$genreInfoRow['id_genero'].'" class="unchecked-Genres" name="genres_unchecked[]" checked="checked"> 
                                    '.$genreInfoRow['nombre_genero'].' 
                                </label>
                                ';
                            }
                        } else {
                            echo '<p>No genres found.</p>';
                        }
                        
                        echo'    
                        </div>


                        <div class="divisor cont-espaciado">
                            <div class="cont-dinamicas">
                                <div id="div-director" class="div-repetidor">
                                    <p class="importante">Agregar directores</p>
                                    <input type="text" id="checkboxSearchDire" placeholder="Buscar en el Sistema">
                                    <div id="checkboxContainerDire">
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
                                    <input type="text" id="checkboxSearchActor" placeholder="Buscar en el Sistema">
                                    <div id="checkboxContainerActor">
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
                                <p class="importante">Agregar generos</p>
                                <input type="text" id="checkboxSearchGenero" placeholder="Buscar en el Sistema">
                                <div id="checkboxContainerGenero">
                                    ';
                                    $todos_Genero = mysqli_query($conexion,"SELECT * FROM moviely.genero");
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
                                <p style="font-size:1.5rem;">Si no existe en el Sistema, <span style="font-weight:bold; ">Creelo</span>:</p>
                                <p>(Preste atención a la ortografía, Comience con Mayúscula)</p>
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
                    <form class="form_cancelar" method="GET" action="info.php">
                            <input type="hidden" name="id_peli" value="'.$row_encontrado['id_peli'].'">
                            <input type="submit" name="cancel" value="Cancelar Modificación"> 
                    </form>   
                ';
                } else {echo '<div class="completador"><h1 class="importante">No hay contenido bajo ese registro</h1><div>';}
            }
        


        echo '</main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>'; 

	?>  
        <script>
            document.getElementById('form_alta_peli').addEventListener('submit', function(event) {
                // Collect unchecked checkbox IDs
                const uncheckedIDsDirec = [];
                const checkboxes = document.querySelectorAll('.unchecked-Dire');
                checkboxes.forEach(function(checkbox) {
                    if (!checkbox.checked) {
                        // Collect the IDs of unchecked checkboxes
                        uncheckedIDsDirec.push(checkbox.id);
                    }
                });

                // Create a hidden input field to store unchecked IDs
                const uncheckedInput = document.createElement('input');
                uncheckedInput.type = 'hidden';
                uncheckedInput.name = 'unchecked_directors';
                uncheckedInput.value = uncheckedIDsDirec.join(',');

                // Append the hidden input to the form
                this.appendChild(uncheckedInput);

                //actores
                const uncheckedIDsActors = [];
                const actorCheckboxes = document.querySelectorAll('.unchecked-Actors');
                actorCheckboxes.forEach(function(checkbox) {
                    if (!checkbox.checked) {
                        uncheckedIDsActors.push(checkbox.id);
                    }
                });

                const uncheckedActorsInput = document.createElement('input');
                uncheckedActorsInput.type = 'hidden';
                uncheckedActorsInput.name = 'unchecked_actors';
                uncheckedActorsInput.value = uncheckedIDsActors.join(',');

                this.appendChild(uncheckedActorsInput);

                //generos
                const uncheckedIDsGenres = [];
                const genreCheckboxes = document.querySelectorAll('.unchecked-Genres');
                genreCheckboxes.forEach(function(checkbox) {
                    if (!checkbox.checked) {
                        uncheckedIDsGenres.push(checkbox.id);
                    }
                });

                const uncheckedGenresInput = document.createElement('input');
                uncheckedGenresInput.type = 'hidden';
                uncheckedGenresInput.name = 'unchecked_genres';
                uncheckedGenresInput.value = uncheckedIDsGenres.join(',');

                this.appendChild(uncheckedGenresInput);
            });
        </script>
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
        
        <script src="script/checked.js"></script>
        <script src="script/etiquetas-dinamicas.js"></script>    
</body>
</html>