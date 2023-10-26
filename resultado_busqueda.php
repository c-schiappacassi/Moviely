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
    <title>Busqueda</title>
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
        echo '<main>';
        $buscar = $_GET['buscar'];

        if(isset($_SESSION['kids']) == false || ($_SESSION['kids'] == 0 || $_SESSION['kids'] == false )){
            $consulta = mysqli_query($conexion, "SELECT * FROM peli INNER JOIN peli_director ON peli.id_peli = peli_director.id_peli
                                                            INNER JOIN director ON peli_director.id_director = director.id_director
                                                            INNER JOIN peli_actor ON peli.id_peli = peli_actor.id_peli
                                                            INNER JOIN actor ON peli_actor.id_actor = actor.id_actor
                                                            INNER JOIN peli_genero ON peli.id_peli = peli_genero.id_peli
                                                            INNER JOIN genero ON peli_genero.id_genero = genero.id_genero
                                                            WHERE peli.titulo LIKE '%$buscar%'
                                                            OR director.nombre LIKE '%$buscar%'
                                                            OR director.apellido LIKE '%$buscar%'
                                                            OR actor.nombre LIKE '%$buscar%'
                                                            OR actor.apellido LIKE '%$buscar%'
                                                            OR genero.nombre_genero LIKE '%$buscar%'
                                                            GROUP BY peli.id_peli, peli.titulo  ");
        }else{
            $consulta = mysqli_query($conexion, "SELECT * FROM peli INNER JOIN peli_director ON peli.id_peli = peli_director.id_peli
                                                            INNER JOIN director ON peli_director.id_director = director.id_director
                                                            INNER JOIN peli_actor ON peli.id_peli = peli_actor.id_peli
                                                            INNER JOIN actor ON peli_actor.id_actor = actor.id_actor
                                                            INNER JOIN peli_genero ON peli.id_peli = peli_genero.id_peli
                                                            INNER JOIN genero ON peli_genero.id_genero = genero.id_genero
                                                            WHERE (peli.titulo LIKE '%$buscar%'
                                                                    OR director.nombre LIKE '%$buscar%'
                                                                    OR director.apellido LIKE '%$buscar%'
                                                                    OR actor.nombre LIKE '%$buscar%'
                                                                    OR actor.apellido LIKE '%$buscar%'
                                                                    OR genero.nombre_genero LIKE '%$buscar%')
                                                            AND genero.nombre_genero IN ('Kids', 'Familiar', 'Infantil')
                                                            GROUP BY peli.id_peli, peli.titulo  ");

        }

        
        
        echo '<div id="cont-busca">';
        if($consulta->num_rows > 0){
            while($row = $consulta->fetch_assoc()) {
        
                $imagePath = $row["path_poster"];
            echo '<div class="cont"><a href="info.php?id_peli=' . $row["id_peli"] . '" ><img src="' . $imagePath . '" alt="Movie Posters"></a></div>';
        
            }
        }else{
            if( isset($_SESSION['kids']) && $_SESSION['kids'] == 1 ){
                echo '<p>Filtrado automatico para niños, </p>';
            }
            echo '<p>No se encontro nada :(</p>';
        }
        echo '</div>';
        mysqli_free_result($consulta);
        mysqli_close($conexion);
        
        $quebusco = $_GET['buscar'];
        echo '<script>var phpValue = ' . json_encode($quebusco) . ';</script>';
       
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
        </footer>';
    ?>
    <script src="script/jquery.js"></script>
    <script src="script/pop-ups.js"></script>
    <script src="script/botonTop.js"></script>
    <script>
        $(document).ready(function() {
            $("#cb3-8").on("change", function() {
                var isChecked = $(this).prop("checked");
                
                // Use the phpValue variable from PHP
                var busca = phpValue;

                // Send an AJAX request to update the session variable
                $.ajax({
                    url: "updateKids.php",
                    method: "POST",
                    data: { isChecked: isChecked, quebusca: busca },
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