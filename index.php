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
        <main>

        <h1 id="top10">TOP 10</h1>
        <div class="carousel-container">
        <button class="carousel-prev">&#60</button>
        <div class="carousel-slide">';
    
            // Assuming you have a database connection established earlier
            $sql = "SELECT path_poster as poster, id_peli as id FROM peli ORDER BY calificacion DESC LIMIT 10";
            $result = mysqli_query($conexion,$sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagePath = $row["poster"];
                    echo '<div class="cont"><a href="info.php?id_peli=' . $row["id"] . '" ><img src="' . $imagePath . '" alt="Movie Posters"></a></div>';
                }
            } else {
                echo '<p>No movies found.</p>';
            }
            
        echo '</div>
        <button class="carousel-next">&#62</button>
        </div>';
        
        echo '
        <h2 id="top15accion">TOP 15 en genero ACCIÓN</h2>
        <div class="small-carousel-container">
            <button class="small-carousel-prev">&#60</button>
            <div class="small-carousel-slide">';

            $sql = "SELECT path_poster as poster, id_peli as id FROM peli ORDER BY id_peli DESC LIMIT 15";
            $result = mysqli_query($conexion,$sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagePath = $row["poster"];
                    echo '<div class="small-carousel-item"><a href="info.php?id_peli=' . $row["id"] . '" ><img src="'.$imagePath.'." alt="Movie Posters"></a></a></div>';
                }
            } else {
                echo '<p>No movies found.</p>';
            }
            
        echo '    </div>
            <button class="small-carousel-next">&#62</button>
        </div>';
        
     
        echo '
        </main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>
        ';   
    

    ?>
        <script src="script/jquery.js"></script>
        <script src="slick/slick.min.js"></script>
        <script src="script/script.js"></script>
</body>
</html>