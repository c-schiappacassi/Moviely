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

        $sql = "SELECT path_poster FROM peli ORDER BY calificacion DESC LIMIT 10";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imagePath = $row["path_poster"];
                // Display the image using an <img> tag
                echo '<h1 id="top10">TOP 10</h1>
                        <div class="carousel-container">
                            <button class="carousel-prev">&#60</button>
                            <div class="carousel-slide">
                                <div class="cont">
                                    <img src='$imagePath[1]' alt="Image 1">
                                </div>
                                <div class="cont">
                                    <img src='$imagePath[2]' alt="Image 1">
                                </div>
                                <div class="cont">
                                    <img src='$imagePath[3]' alt="Image 1">
                                </div>
                                <div class="cont">
                                    <img src='$imagePath[4]' alt="Image 1">
                                </div>
                                <div class="cont">
                                    <img src='$imagePath[5]' alt="Image 1">
                                </div>
                                <div class="cont">
                                    <img src='$imagePath[6]' alt="Image 1">
                                </div>
                                <div class="cont">
                                    <img src='$imagePath[7]' alt="Image 1">
                                </div>
                                <div class="cont">
                                    <img src='$imagePath[8]' alt="Image 1">
                                </div>
                                <div class="cont">
                                    <img src='$imagePath[9]' alt="Image 1">
                                </div>
                                <div class="cont">
                                    <img src='$imagePath[10]' alt="Image 1">
                                </div>
                            </div>
                            <button class="carousel-next">&#62</button>
                        </div>
                "<img src='$imagePath' alt='Movie Poster'><br>"';
            }
        } else {
            echo "No movies found.";
        }
        

        echo '<div class="div_admin"><form action="admin.php" class="filtros_ppal" method="post">
            <label>Usuario<select name="usuario" class="campo" id="usuario">
            <option value ="">No definido</option>';
            $opciones_usuario=mysqli_query($conexion, "SELECT usuario FROM usuario order by usuario asc");
            while($respuesta=mysqli_fetch_array($opciones_usuario))
            {
                echo '<option value ="' . $respuesta['usuario'] . '" ';
                if(isset($_POST['usuario']) and $_POST['usuario']==$respuesta['usuario'])
                {
                    echo 'selected="selected"';
                }
                echo '>' . $respuesta['usuario'] . '</option>';
            }
        echo '</select></label>';
        
        echo '<label>Tipo<select name="tipo" class="campo" id="tipo">';
                echo '<option value ="" ';if(isset($_POST['tipo']) and $_POST['tipo']=='')echo 'selected="selected"';echo '>No definido</option>';
                echo '<option value ="a" ';if(isset($_POST['tipo']) and $_POST['tipo']=='a')echo 'selected="selected"';echo '>Alta</option>';
                echo '<option value ="m" ';if(isset($_POST['tipo']) and $_POST['tipo']=='m')echo 'selected="selected"';echo '>Modificacion</option>';
                echo '<option value ="b" ';if(isset($_POST['tipo']) and $_POST['tipo']=='b')echo 'selected="selected"';echo '>Baja</option>';
        echo '</select></label>';

        /*echo '<label>Fecha desde<input type="date" name"fecha_desde" value="';
        //if(isset($_POST['fecha_desde'])) echo $_POST['fecha_desde'];
        echo date('dd-mm-aaaa');
        echo'"/></label>';

        echo '<label>Fecha hasta<input type="date" name"fecha_hasta" ></label>';*/
        
        echo '<input type="submit" name="get_registros" id="get_registros" value="Aplicar" />
            <input type="submit" name="limpiar" id="limpiar" value="Limpiar filtros" /></form></div>';

        echo '<table class="table_registros"><tr><th>ID usuario</th><th>Usuario</th><th>Fecha</th><th>Tipo</th><th>Publicación</th><th>Descripción</th></tr>'; 

        $extra = 'where 1=1 ';
        if(isset($_POST['get_registros']))
        {
            if ($_POST['usuario'])
                $extra = $extra." and usuario.usuario = '".$_POST['usuario']."'";
            if ($_POST['tipo']) 
                $extra = $extra." and registro.tipo = '".$_POST['tipo']."'";
            /*$fecha_desde = date('Y-m-d', strtotime($_POST['fecha_desde']));
            if ($fecha_desde) 
                $extra = $extra." and registro.fecha >= '".$fecha_desde."'";
            if ($_POST['fecha_hasta']) 
                $extra = $extra." and registro.fecha <= '".$_POST['fecha_hasta']."'";*/
        }
        $q = "SELECT registro.persona as id_usuario, registro.fecha as fecha,
            case when registro.tipo = 'a' then 'Alta'
                when registro.tipo = 'b' then 'Baja'
                when registro.tipo = 'm' then 'Modificacion'
            end as tipo,
            usuario.usuario as usuario, pokemon.id as pokemon, 
            pokemon.imagen as imagen, registro.descripcion as descripcion
            from registro
            left join usuario on registro.persona = usuario.id
            left join pokemon on registro.pokemon = pokemon.id ".$extra."
            order by fecha desc limit 50";
        
        $registros=mysqli_query($conexion, $q);
        $resultado=mysqli_num_rows($registros);

        if($resultado!=0)
        {
           while($respuesta=mysqli_fetch_array($registros))
            {
                echo '<tr><td>'.$respuesta['id_usuario'].'</td><td>'.$respuesta['usuario'].'</td><td>'.$respuesta['fecha'].'</td><td>'.$respuesta['tipo'].'</td><td><a href="info.php?id='.$respuesta['pokemon'].'"><img height="35px" src='.$respuesta['imagen'].'></a></td><td>'.$respuesta['descripcion'].'</td></tr>';
            } 
        }
        else echo '<table class="table_sin_registro"><tr><td></td><td>Sin registros</td></td><td></tr></table>';
        echo '</table>';
    }
    else header("Location:login.php");   

    ?>
</body>
</html>