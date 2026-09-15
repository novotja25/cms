<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../db.php";
    $i = 0;
    $errors = array();
    $typ_vstupenky = $_POST["typ_vstupenky"];
    $cena = $_POST["cena"];
    if ($typ_vstupenky == null) {
        $errors[] = "vyplnte typ vstupenky";
        $i++;
    }
    if ($cena == null) {
        $errors[] = "vyplnte cenu";
        $i++;
    }
    if ($i == 0) {
        $sql = "INSERT INTO cenik (typ_vstupenky, cena) VALUES (:t, :c)";
        $con = $db->prepare($sql);
        $con->bindValue(":t", $typ_vstupenky, PDO::PARAM_STR);
        $con->bindValue(":c", $cena, PDO::PARAM_STR);
        $con->execute();
        header("location: cenik.php");
    } else {
        $_SESSION["errors"] = $errors;
        header("location: cenik.php");
    }
?>
