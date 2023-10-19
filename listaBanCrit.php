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

    echo '<main>';// EMPIEZA EL MAIN

    if($_SESSION['administrador'] > 0){
        echo' <form id="form_criticos" method="POST" action="DesbannearCritico.php"><div id="reviews">';

        $contName = 1;
        $critBaneado = mysqli_query($conexion, "SELECT id_usuario, nombre_usuario, mail from usuario where estado > 0");
        
        if ($critBaneado->num_rows > 0) {
            while ($row = $critBaneado->fetch_assoc()) {
                $id_usuario = $row['id_usuario'];

                $crit_reseña = mysqli_query($conexion, "SELECT * FROM moviely.review WHERE id_usuario = '$id_usuario' and estado_review = 3");
                if ($crit_reseña->num_rows == 1) {
                    $crit_reseña = $crit_reseña->fetch_assoc();
                    $estrellas = $crit_reseña['calificacion'];
                    $id_peli = $crit_reseña['id_peli'];

                    $reseña_peli = mysqli_query($conexion, "SELECT titulo FROM moviely.peli WHERE id_peli = $id_peli");
                    $reseña_peli = $reseña_peli->fetch_assoc();

                echo'
                <div class="reseña" style="border-top: 4px solid #FA3902; border-bottom: 4px solid #FA3902;">
                    <div id="cont">
                        <p class="imp_review"><strong>'.$row['nombre_usuario'].'</strong></p>
                        <input type="checkbox" name="checkedIds[]" id="'.$row['id_usuario'].'" value="'.$row['id_usuario'].'" class="checkboxRev">
                        <input type="hidden" id="checkedIdsInput1" name="checkedIds1" value="">
                        <a href="info.php?id_peli='.$id_peli.'" class="imp_review">'.$reseña_peli['titulo'].'</a> 
                        <div id="estre-review" >
                            <fieldset class="rateDisplay rateChico">
                                <input type="radio" id="rating10" name="rating'.$contName.'" value="10" '; if ($estrellas ==10  ){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating10" title="10/10"></label>
                                <input type="radio" id="rating9" name="rating'.$contName.'" value="9" '; if ($estrellas >=9  && $estrellas < 10){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating9" title="9/10"></label>
                                <input type="radio" id="rating8" name="rating'.$contName.'" value="8" '; if ($estrellas >=8 && $estrellas < 9){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating8" title="8/10"></label>
                                <input type="radio" id="rating7" name="rating'.$contName.'" value="7" '; if ($estrellas >=7 && $estrellas < 8){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating7" title="7/10"></label>
                                <input type="radio" id="rating6" name="rating'.$contName.'" value="6" '; if ($estrellas >=6  && $estrellas < 7){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating6" title="6/10"></label>
                                <input type="radio" id="rating5" name="rating'.$contName.'" value="5" '; if ($estrellas >=5  && $estrellas < 6){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating5" title="5/10"></label>
                                <input type="radio" id="rating4" name="rating'.$contName.'" value="4" '; if ($estrellas >=4 && $estrellas < 5){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating4" title="4/10"></label>
                                <input type="radio" id="rating3" name="rating'.$contName.'" value="3" '; if ($estrellas >=3 && $estrellas < 4){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating3" title="3/10"></label>
                                <input type="radio" id="rating2" name="rating'.$contName.'" value="2" '; if ($estrellas >=2 && $estrellas < 3){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label for="rating2" title="2/10"></label>
                                <input type="radio" id="rating1" name="rating'.$contName.'" value="1" '; if ($estrellas >=1 && $estrellas < 2){echo 'checked';}else{echo 'onclick="return false;"';} echo'/><label class="half" for="rating1" title="1/10"></label>
                            </fieldset>
                        </div>
                        <p>'.$crit_reseña['comentario'].'</p>     
                    </div>      
                </div>';
                $contName++;
            }
            }
        }
        echo '</div><button name="desbannear-crit-2" type="submit">Desbannear las seleccionadas</button></form></div>';


    }
    else{
        echo '
        <div style="width:80%; margin: auto; padding-top:3%;">
            <h1>Acceso Negado</h1>
        </div>';
    }
    echo '
    </main>
    <footer>
        <p>&copy; 2023 Your Movie Reviews</p>
    </footer>
    '; 
?>
<script src="script/jquery.js"></script>
<script src="script/pop-ups.js"></script>
<script>
document.getElementById('form_criticos').addEventListener('submit', function(event) {
    // Collect checked checkbox values
    const checkboxes = document.querySelectorAll('.checkboxRev:checked');
    const checkedIds1 = [];

    checkboxes.forEach((checkbox) => {
        checkedIds1.push(checkbox.value);
    });

    // Set the value of the hidden input field
    document.getElementById('checkedIdsInput1').value = checkedIds1.join(',');
});
</script>
</body>
</html>