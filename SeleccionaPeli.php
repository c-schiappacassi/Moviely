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
            <main>

            <form id="form-modi-elec" method="GET" action="ModificaPeli.php">
                <div class="cont-info">
                    <label class="importante" for="busca">Buscar por:</label>
                    <select class="busca" name="busca" required >
                        <option>Selecciona</option>
                        <option value="id">ID de contenido</option>
                        <option value="titulo">Título de contenido</option>
                    </select>
                    <div class="cont-espaciado">
                        <label class="opBusca" id="elijo-por-id">Ingrese el ID que busca:
                                <input type="number" name="busca_id" >
                        </label>
                        <br>
                        <label class="opBusca" id="elijo-por-titulo">Ingrese el título que busca:
                                <input type="text" name="busca_titulo" >
                        </label>
                    </div>
                </div>
                <input type="submit" name="submit-busca" value="Buscar contenido">
            </form>
                

        </main>
        <footer>
            <p>&copy; 2023 Your Movie Reviews</p>
        </footer>'; 

	?>  
        <script src="script/jquery.js"></script>
        <script>
            $(document).ready(function(){
                $('select.busca').on('change', function(){
                    var demovalue = $(this).val(); 
                    $("label.opBusca").hide();
                    $("#elijo-por-"+demovalue).show();
                });
            });
        </script>
        <script src="script/etiquetas-dinamicas.js"></script>     
</body>
</html>