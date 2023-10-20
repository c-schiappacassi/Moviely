<?php
session_start();

if (isset($_POST["isChecked"])) {
    $isChecked = filter_var($_POST["isChecked"], FILTER_VALIDATE_BOOLEAN);
    // Update the $_SESSION variable based on the checkbox state
    $_SESSION["kids"] = $isChecked;
}
else{
    $_SESSION["kids"] = 0;
}
header("Location:index.php");
?>