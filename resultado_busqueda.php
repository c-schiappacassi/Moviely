<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
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


        echo '</main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>';
    ?>
    <script src="script/jquery.js"></script>
    <script src="script/pop-ups.js"></script>
</body>
</html>