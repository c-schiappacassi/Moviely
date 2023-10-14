<?php
ob_start();
    $opciones='
        <header>
            <a id="link-logo" href="index.php">
                <img id="logo" src="moviely logo.png" alt="">
            </a>
            <form id="search-bar" action="resultado_busqueda.php" method="get" autocomplete="off">
                <input type="search" name="buscar" placeholder="Buscar..." />
                <input type="submit" name="boton-buscar" value="Search">
            </form>
            <nav>
                <ul>
                    <li><a href="index.php">Top Charts</a></li>
                    <li><a href="MiLista.php">Mi Lista</a></li>
                    <li><a href="MiPerfil.php">Mi Perfil</a></li>
                </ul>
            </nav>
        </header>
        ';
        if(isset($_GET['boton-buscar'])){
            header('Location: resultado_busqueda.php?buscar='.$_GET['buscar'].'');
        }
     

    $opciones_admin='
        <header>
            <a id="link-logo" href="index.php">
                <img id="logo" src="moviely logo.png" alt="">
            </a>
            <form id="search-bar" action="resultado_busqueda.php" method="get" autocomplete="off">
                <input type="search" name="buscar" placeholder="Buscar..." />
                <input type="submit" name="boton-buscar" value="Search">
            </form>
            <nav>
                <ul>
                    <li><a href="AltaPeli.php">Alta Contenido</a></li>
                    <li><a href="">Criticos Banneados</a></li>
                    <li><a href="">Reviews Banneadas</a></li>
                    <li><a href="MiPerfil.php">Mi perfil</a></li>
                </ul>
            </nav>
        </header>
        ';
        if(isset($_GET['boton-buscar'])){
            header('Location: resultado_busqueda.php?buscar='.$_GET['buscar'].'');
        }
        
        
    $opciones_sin_sesion='
        <header>
            <a id="link-logo" href="index.php">
                <img id="logo" src="moviely logo.png" alt="">
            </a>
            <form id="search-bar" action="resultado_busqueda.php" method="get" autocomplete="off">
                <input type="search" name="buscar" placeholder="Buscar..." />
                <input type="submit" name="boton-buscar" value="Search">
            </form>
            <nav>
                <ul>
                    <li><a href="index.php">Top Charts</a></li>
                    <li><a href="LogInUsuario.php">Iniciar Sesion</a></li>
                </ul>
            </nav>
        </header>
        ';
        if(isset($_GET['boton-buscar'])){
            header('Location: resultado_busqueda.php?buscar='.$_GET['buscar'].'');
        }  

    $opciones_sin_links='
        <header>
            <a id="link-logo" href="">
                <img id="logo" src="moviely logo.png" alt="">
            </a>
        </header>
        ';
?>

