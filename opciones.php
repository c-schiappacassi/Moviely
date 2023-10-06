<?php
    $opciones='
        <header>
            <a id="link-logo" href="index.php">
                <img id="logo" src="moviely logo.png" alt="">
            </a>
            <form id="search-bar" action="resultado_busqueda.php" method="post">
                <input type="search" name="buscar" placeholder="Buscar..." />
                <input type="submit" value="Search">
            </form>
            <nav>
                <ul>
                    <li><a href="#">Top Charts</a></li>
                    <li><a href="#">Mi Lista</a></li>
                    <li><a href="#">Mi Perfil</a></li>
                </ul>
            </nav>
        </header>
    ';
    $opciones_admin='
        <header>
            <a id="link-logo" href="index.php">
                <img id="logo" src="moviely logo.png" alt="">
            </a>
            <form id="search-bar" action="resultado_busqueda.php" method="post">
                <input type="search" name="buscar" placeholder="Buscar..." />
                <input type="submit" value="Search">
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
    $opciones_sin_sesion='
        <header>
            <a id="link-logo" href="index.php">
                <img id="logo" src="moviely logo.png" alt="">
            </a>
            <form id="search-bar" action="resultado_busqueda.php" method="post">
                <input type="search" name="buscar" placeholder="Buscar..." />
                <input type="submit" value="Search">
            </form>
            <nav>
                <ul>
                    <li><a href="#">Top Charts</a></li>
                    <li><a href="LogInUsuario.php">Iniciar Sesion</a></li>
                </ul>
            </nav>
        </header>
    ';
?>

