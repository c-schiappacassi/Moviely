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
    <title>Home</title>
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
        <main>
        <h1 id="top10">TOP 10</h1>
        <div class="carousel-container">
        <button class="carousel-prev">&#60</button>
        <div class="carousel-slide">';
    
            if(isset($_SESSION['kids']) == false || ($_SESSION['kids'] == 0 || $_SESSION['kids'] == false )){
                $sql = "SELECT path_poster as poster, id_peli as id FROM peli ORDER BY calificacion DESC LIMIT 10";
            }
            else{
                $sql = "SELECT DISTINCT peli.path_poster as poster, peli.id_peli as id FROM peli
                INNER JOIN peli_genero ON peli.id_peli = peli_genero.id_peli
                INNER JOIN genero ON peli_genero.id_genero = genero.id_genero
                WHERE genero.nombre_genero IN ('Kids', 'Familiar', 'Infantil')
                GROUP BY peli.titulo
                ORDER BY peli.calificacion DESC
                LIMIT 10;";
            }
            $result = mysqli_query($conexion,$sql);
            $puesto = 1;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagePath = $row["poster"];
                    echo '<div class="cont"><a href="info.php?id_peli=' . $row["id"] . '" ><img src="' . $imagePath . '" alt="Movie Posters"></a><div class="puesto"><p>'.$puesto.'°</p></div></div>';
                    $puesto++;
                }
            } else {
                echo '<p>No movies found.</p>';
            }
            
        echo '</div>
        <button class="carousel-next">&#62</button>
        </div>';

        if(isset($_SESSION['kids']) == false || ($_SESSION['kids'] == 0 || $_SESSION['kids'] == false )){
            //GENERO ACCION, AVENTURA, WESTERN
            echo '
            <h2 id="top15accion">TOP 15 en genero ACCIÓN</h2>
            <div class="small-carousel-container">
                <button class="small-carousel-prev" id="slideprev-1">&#60</button>
                <div class="small-carousel-slide" id="slide-1">';

                $sql = "SELECT DISTINCT peli.path_poster as poster, peli.id_peli as id FROM peli
                    INNER JOIN peli_genero ON peli.id_peli = peli_genero.id_peli
                    INNER JOIN genero ON peli_genero.id_genero = genero.id_genero
                    WHERE genero.nombre_genero IN ('Acción', 'Aventura', 'Wéstern' , 'Bélicas', 'Catástrofe')
                    GROUP BY peli.titulo
                    ORDER BY peli.calificacion DESC
                    LIMIT 15;";
                $result = mysqli_query($conexion,$sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = $row["poster"];
                        echo '<div class="small-carousel-item"><a href="info.php?id_peli=' . $row["id"] . '" ><img src="'.$imagePath.'" alt="Movie Posters"></a></a></div>';
                    }
                } else {
                    echo '<p>No movies found.</p>';
                }
                
            echo '    </div>
                <button class="small-carousel-next" id="slidenext-1">&#62</button>
            </div>';

            //GENERO COMEDIA, SÁTIRA
            echo '
            <h2 id="top15accion">TOP 15 en genero COMEDIA</h2>
            <div class="small-carousel-container">
                <button class="small-carousel-prev" id="slideprev-2">&#60</button>
                <div class="small-carousel-slide" id="slide-2">';

                $sql = "SELECT DISTINCT peli.path_poster as poster, peli.id_peli as id FROM peli 
                    INNER JOIN peli_genero ON peli.id_peli = peli_genero.id_peli 
                    INNER JOIN genero ON peli_genero.id_genero = genero.id_genero
                    WHERE genero.nombre_genero IN ('Comedia','Sátira')
                    GROUP BY peli.titulo
                    ORDER BY peli.calificacion DESC LIMIT 15;";
                $result = mysqli_query($conexion,$sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = $row["poster"];
                        echo '<div class="small-carousel-item"><a href="info.php?id_peli=' . $row["id"] . '" ><img src="'.$imagePath.'" alt="Movie Posters"></a></a></div>';
                    }
                } else {
                    echo '<p>No movies found.</p>';
                }
                
            echo '    </div>
                <button class="small-carousel-next" id="slidenext-2">&#62</button>
            </div>';
            
            //GENERO DRAMÁTICO, HISTORIA REAL
            echo '
            <h2 id="top15accion">TOP 15 en genero DRAMÁTICO</h2>
            <div class="small-carousel-container">
                <button class="small-carousel-prev" id="slideprev-3">&#60</button>
                <div class="small-carousel-slide" id="slide-3">';

                $sql = "SELECT DISTINCT peli.path_poster as poster, peli.id_peli as id FROM peli
                    INNER JOIN peli_genero ON peli.id_peli = peli_genero.id_peli 
                    INNER JOIN genero ON peli_genero.id_genero = genero.id_genero
                    WHERE genero.nombre_genero IN ('Dramático','Historia Real', 'Juveniles', 'Musical','Documental', 'Religioso', 'Históricas', 'Deportivas')
                    GROUP BY peli.titulo
                    ORDER BY peli.calificacion DESC LIMIT 15;";
                $result = mysqli_query($conexion,$sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = $row["poster"];
                        echo '<div class="small-carousel-item"><a href="info.php?id_peli=' . $row["id"] . '" ><img src="'.$imagePath.'" alt="Movie Posters"></a></a></div>';
                    }
                } else {
                    echo '<p>No movies found.</p>';
                }
                
            echo '    </div>
                <button class="small-carousel-next" id="slidenext-3">&#62</button>
            </div>';
            
            //GENERO FANTASÍA
            echo '
            <h2 id="top15accion">TOP 15 en genero FANTASÍA</h2>
            <div class="small-carousel-container">
                <button class="small-carousel-prev" id="slideprev-4">&#60</button>
                <div class="small-carousel-slide" id="slide-4">';

                $sql = "SELECT DISTINCT peli.path_poster as poster, peli.id_peli as id FROM peli 
                    INNER JOIN peli_genero ON peli.id_peli = peli_genero.id_peli 
                    INNER JOIN genero ON peli_genero.id_genero = genero.id_genero
                    WHERE genero.nombre_genero IN ('Fantasía', 'Ciencia Ficción', 'Épicas', 'Futuristas')
                    GROUP BY peli.titulo
                    ORDER BY peli.calificacion DESC LIMIT 15;";
                $result = mysqli_query($conexion,$sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = $row["poster"];
                        echo '<div class="small-carousel-item"><a href="info.php?id_peli=' . $row["id"] . '" ><img src="'.$imagePath.'" alt="Movie Posters"></a></a></div>';
                    }
                } else {
                    echo '<p>No movies found.</p>';
                }
                
            echo '    </div>
                <button class="small-carousel-next" id="slidenext-4">&#62</button>
            </div>';
            
            //GENERO KIDS, FAMILIAR, INFANTIL
            echo '
            <h2 id="top15accion">TOP 15 en genero KIDS</h2>
            <div class="small-carousel-container">
                <button class="small-carousel-prev" id="slideprev-5">&#60</button>
                <div class="small-carousel-slide" id="slide-5">';

                $sql = "SELECT DISTINCT peli.path_poster as poster, peli.id_peli as id FROM peli 
                    INNER JOIN peli_genero ON peli.id_peli = peli_genero.id_peli 
                    INNER JOIN genero ON peli_genero.id_genero = genero.id_genero
                    WHERE genero.nombre_genero IN ('Kids','Familiar','Infantil')
                    GROUP BY peli.titulo
                    ORDER BY peli.calificacion DESC LIMIT 15;";
                $result = mysqli_query($conexion,$sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = $row["poster"];
                        echo '<div class="small-carousel-item"><a href="info.php?id_peli=' . $row["id"] . '" ><img src="'.$imagePath.'" alt="Movie Posters"></a></a></div>';
                    }
                } else {
                    echo '<p>No movies found.</p>';
                }
                
            echo '    </div>
                <button class="small-carousel-next" id="slidenext-5">&#62</button>
            </div>';
            
            //GENERO SUSPENSO, MISTERIO
            echo '
            <h2 id="top15accion">TOP 15 en genero SUSPENSO</h2>
            <div class="small-carousel-container">
                <button class="small-carousel-prev" id="slideprev-6">&#60</button>
                <div class="small-carousel-slide" id="slide-6">';

                $sql = "SELECT DISTINCT peli.path_poster as poster, peli.id_peli as id FROM peli 
                    INNER JOIN peli_genero ON peli.id_peli = peli_genero.id_peli 
                    INNER JOIN genero ON peli_genero.id_genero = genero.id_genero
                    WHERE genero.nombre_genero IN ('Suspenso','Misterio', 'Policial', 'Crimen','Gangsters')
                    GROUP BY peli.titulo
                    ORDER BY peli.calificacion DESC LIMIT 15;";
                $result = mysqli_query($conexion,$sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = $row["poster"];
                        echo '<div class="small-carousel-item"><a href="info.php?id_peli=' . $row["id"] . '" ><img src="'.$imagePath.'" alt="Movie Posters"></a></a></div>';
                    }
                } else {
                    echo '<p>No movies found.</p>';
                }
                
            echo '    </div>
                <button class="small-carousel-next" id="slidenext-6">&#62</button>
            </div>';
            
            //GENERO TERROR, THRILLER
            echo '
            <h2 id="top15accion">TOP 15 en genero TERROR</h2>
            <div class="small-carousel-container">
                <button class="small-carousel-prev" id="slideprev-7">&#60</button>
                <div class="small-carousel-slide"id="slide-7">';

                $sql = "SELECT DISTINCT peli.path_poster as poster, peli.id_peli as id FROM peli 
                    INNER JOIN peli_genero ON peli.id_peli = peli_genero.id_peli 
                    INNER JOIN genero ON peli_genero.id_genero = genero.id_genero
                    WHERE genero.nombre_genero IN ('Terror','Thriller')
                    GROUP BY peli.titulo
                    ORDER BY peli.calificacion DESC LIMIT 15;";
                $result = mysqli_query($conexion,$sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = $row["poster"];
                        echo '<div class="small-carousel-item"><a href="info.php?id_peli=' . $row["id"] . '" ><img src="'.$imagePath.'" alt="Movie Posters"></a></a></div>';
                    }
                } else {
                    echo '<p>No movies found.</p>';
                }
                
            echo '    </div>
                <button class="small-carousel-next" id="slidenext-7">&#62</button>
            </div>';
        }
        else{
            //PELICULAS PARA KIDS
            $consulta = "SELECT DISTINCT peli.path_poster, peli.id_peli 
            FROM peli 
            INNER JOIN peli_genero ON peli.id_peli = peli_genero.id_peli 
            INNER JOIN genero ON peli_genero.id_genero = genero.id_genero
            WHERE genero.nombre_genero IN ('Kids','Infantil', 'Familiar')
            GROUP BY peli.titulo
            ORDER BY peli.calificacion DESC
            LIMIT 18446744073709551615 OFFSET 10 ; ";

            $consulta = mysqli_query($conexion,$consulta);  
            
            echo '<div id="contenido-kids"><h2>Contenido Kids</h2></div><div id="cont-busca">';
            if($consulta->num_rows > 0){
                while($row = $consulta->fetch_assoc()) {
            
                    $imagePath = $row["path_poster"];
                echo '<div class="cont"><a href="info.php?id_peli=' . $row["id_peli"] . '" ><img src="' . $imagePath . '" alt="Movie Posters"></a></div>';
            
                }
            }else{
                echo '<p>No movies found.</p>';
            }
            echo '</div>';
        }

        echo'
        <div id="kids-cont">
            <p>Modo Kids</p>
            <div class="checkbox-wrapper-8">
                <input type="checkbox" id="cb3-8" class="tgl tgl-skewed" ';
                if(isset($_SESSION['kids']) && $_SESSION["kids"] == 1){echo'checked'; }
                echo'>
                <label for="cb3-8" data-tg-on="ON" data-tg-off="OFF" class="tgl-btn"></label>
            </div>  
        </div>
        ';
        echo '
        <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
        </main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>
        ';   
    ?>
        <script src="script/jquery.js"></script>
        <script src="slick/slick.min.js"></script>
        <script src="script/script.js"></script>
        <script src="script/botonTop.js"></script>
        <script>
            $(document).ready(function() {
                $("#cb3-8").on("change", function() {
                    var isChecked = $(this).prop("checked");
                    
                    // Send an AJAX request to update the session variable
                    $.ajax({
                        url: "updateKids.php",
                        method: "POST",
                        data: { isChecked: isChecked },
                        success: function(response) {
                            // Reload the page after the session variable is updated
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                        }
                    });
                });
            });
        </script>
</body>
</html>