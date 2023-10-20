<?php
session_start();

if (isset($_POST["isChecked"]) && isset($_POST['quebusca'])) {
    $isChecked = filter_var($_POST["isChecked"], FILTER_VALIDATE_BOOLEAN);
    // Update the $_SESSION variable based on the checkbox state
    $_SESSION["kids"] = $isChecked;
    $busca = $_POST['quebusca'];
    header('Location:resultado_busqueda.php?buscar='.$busca.'');
}
else if(isset($_POST["isChecked"])){
    $isChecked = filter_var($_POST["isChecked"], FILTER_VALIDATE_BOOLEAN);
    // Update the $_SESSION variable based on the checkbox state
    $_SESSION["kids"] = $isChecked;
    header("Location:index.php");
}
else{
    $_SESSION["kids"] = 0;
    header("Location:index.php");
}

?>