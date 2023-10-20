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

    echo '<main style="padding-top:2%;">';// EMPIEZA EL MAIN

    if($_SESSION['administrador'] > 0){
        echo' <form id="form_reviews_ban" method="POST" action="DesbannearReview.php"><div id="reviews">';

        $contName = 1;
        $crit_reseña_ban= mysqli_query($conexion, "SELECT * FROM moviely.review WHERE estado_review = 1 ");

        if($crit_reseña_ban->num_rows > 0){
            while($row= $crit_reseña_ban->fetch_assoc()){
                $estrellas = $row['calificacion'];
                $id_peli = $row['id_peli'];
                $id_usuario = $row['id_usuario'];

                $reseña_peli = mysqli_query($conexion, "SELECT titulo FROM moviely.peli WHERE id_peli = $id_peli ");
                $reseña_peli = $reseña_peli->fetch_assoc();
                $usuario = mysqli_query($conexion, "SELECT nombre_usuario FROM moviely.usuario WHERE id_usuario = $id_usuario ");
                $usuario = $usuario->fetch_assoc();

                echo'
                <div class="reseña" style="border-top: 4px solid #FA3902; border-bottom: 4px solid #FA3902;">
                    <input type="checkbox" name="checkedIds[]" id="'.$row['id_review'].'" value="'.$row['id_review'].'" class="checkboxRev checkbox-input">
                    <input type="hidden" id="checkedIdsInput2" name="checlistaBanReview2" value="">    
                    <div id="cont">
                        <p class="imp_review"><strong>'.$usuario['nombre_usuario'].'</strong> <span class="mini">dejo en <span><a href="info.php?id_peli='.$id_peli.'" class="imp_review">'.$reseña_peli['titulo'].'</a></p> 
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
                        <p class="razon-ban">" '.$row['comentario'].' "</p>     
                    </div>      
                </div>';
                $contName++;
            }
            echo '</div><button name="desbannear-review" type="submit">Desbannear las Reviews seleccionadas</button></form></div>';
        }else{echo '<h1>No hay Reviews Banneadas</h1></div></form></div>';}


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
document.getElementById('form_reviews_ban').addEventListener('submit', function(event) {
    // Collect checked checkbox values
    const checkboxes = document.querySelectorAll('.checkboxRev:checked');
    const checkedIds2 = [];

    checkboxes.forEach((checkbox) => {
        checkedIds2.push(checkbox.value);
    });

    // Set the value of the hidden input field
    document.getElementById('checkedIdsInput2').value = checkedIds2.join(',');
});
</script>
</body>
</html>