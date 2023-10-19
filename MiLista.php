<?php session_start();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link rel="stylesheet" href="css\font-awesome-4.7.0/css/font-awesome.min.css">
    <title>Admin</title>
</head>

<body>
    <?php
        ob_start();
        include("conexion.php");
        include("opciones.php");

        if(isset($_SESSION['id_usuario']))
        {
            $id_usuario = $_SESSION['id_usuario'];
            
            $q = "SELECT * from usuario where id_usuario = '$id_usuario' and administrador = 1";
            $resultado=mysqli_num_rows(mysqli_query($conexion,$q));
            if($resultado!=0){echo $opciones_admin; $_SESSION['administrador'] = 1;}
            else{
                echo $opciones;
                $_SESSION['administrador'] = 0;
            } 

            echo '
            <main  style="padding-top: 1%; padding-bottom: 1%;">';

            if( $_SESSION['administrador'] == 0){
                $usuario = $_SESSION['id_usuario'];
                echo'
                <h1 style="padding-left: 5%; font-size:3.5rem;">Mi Lista</h1>';                
            
                $pelis = mysqli_query($conexion, "SELECT id_peli FROM mi_lista WHERE id_usuario = '$usuario' ");

                if ($pelis->num_rows > 0) {
                    echo '<div class="carousel-container">
                    <button class="carousel-prev">&#60</button>
                    <div class="carousel-slide">';
                    while ($row = $pelis->fetch_assoc()) {
                        $id = $row["id_peli"];

                        $result = mysqli_query($conexion,"SELECT path_poster as poster FROM peli WHERE id_peli = '$id'");

                        while ($row = $result->fetch_assoc()) {
                            $imagePath = $row["poster"];
                            echo '
                            <div class="cont">
                                <form method="GET" action="administracionMiLista.php">
                                    <input type="hidden" name="id_peli" value="'.$id.'">
                                    <button name="quitar" class="uiverse">
                                        <span class="tooltip">Quitar</span>
                                        <span id="equis">
                                            &times
                                        </span>
                                    </button>
                                </form>
                                
                                <a href="info.php?id_peli=' . $id . '" >
                                    <img src="' . $imagePath . '" alt="Movie Posters">
                                </a>
                            </div>';

                            
                        }
                    }
                    echo '</div>
                <button class="carousel-next">&#62</button>
                </div>';
                } else {
                    echo '
                    <div style="width:80%; margin: auto; padding-top:3%;">
                        <p>No tienes nada guardado en tu lista  :( </p>
                    </div>';
                }
                
                    
                
            }
             
            echo '
            </main>
            <footer>
                <p>&copy; 2023 Your Movie Reviews</p>
            </footer>
            ';
        }
        else {header('Location: LogInUsuario.php');};
                    
       
    ?>
    <script src="script/jquery.js"></script>
    <script src="slick/slick.min.js"></script>
    <script>
        $(document).ready(function(){
            var movieCount = $('.carousel-slide .cont').length;

            var slickOptions = {
                infinite: false,
                arrows: false,
                centerMode: false,
                variableWidth: true,
                pauseOnHover: false,
                pauseOnFocus: false,
                pauseOnDotsHover: false,
            };

            if (movieCount > 4) {
                slickOptions.slidesToShow = 1;
                slickOptions.slidesToScroll = 1;
                slickOptions.autoplay = true;
                slickOptions.autoplaySpeed = 3000;
                slickOptions.centerMode = true;
                slickOptions.infinite = true;
            } else {
                // If there are 5 or fewer movies, show them all without sliding
                slickOptions.slidesToShow = movieCount;
                slickOptions.slidesToScroll = movieCount;
            }

            $('.carousel-slide').slick(slickOptions);

            $('.carousel-prev').on('click', function(){
                $('.carousel-slide').slick('slickPrev');
            });

            $('.carousel-next').on('click', function(){
                $('.carousel-slide').slick('slickNext');
            });
        });
    </script>
</body>
</html>