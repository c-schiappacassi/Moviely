<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <title>Admin</title>
</head>

<body>
    <?php
        include("conexion.php");
        include("opciones.php");

/*
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
        }  */  

        echo '
        <header>
            <img id="logo" src="moviely logo.png" alt="">
            <div class="search-bar">
                <input type="text" placeholder="Search for movies...">
                <button>Search</button>
            </div>
            <nav>
                <ul>
                    <li><a href="#">Top Charts</a></li>
                    <li><a href="#">Mi Lista</a></li>
                    <li><a href="#">Mi Perfil</a></li>
                </ul>
            </nav>
            
        </header>
        <main>';

        $id = $_GET['id_peli'];
        echo '<h1>'.$id.'</h1>';

        echo '
        </main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>
        '; 
/*    
     }
    else header("Location:login.php");   */

    ?>
        <script src="script/lightbox-plus-jquery.js"></script>
        <script src="slick/slick.min.js"></script>
        <script src="script/script.js"></script>
</body>
</html>