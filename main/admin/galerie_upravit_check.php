<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../db.php";
    $i = 0;
    $errors = array();
    $id = $_POST["id"];
    $obrazek = $_POST["obrazek"];
    $popis = $_POST["popis"];
    if ($obrazek == null) {
        $errors[] = "vyplnte odkaz";
        $i++;
    }
    if ($popis == null) {
        $errors[] = "vyplnte popis";
        $i++;
    }
    if ($obrazek === '' || !filter_var($obrazek, FILTER_VALIDATE_URL)) {
       $errors[] = "Zadejte platný odkaz (např.     https://domena.cz/obrazek.jpg)";
        $i++;
    };
    if ($i == 0) {
        $sql = "UPDATE galerie SET odkaz_obrazek = :ob, popis = :p WHERE ID_data = :id";
        $con = $db->prepare($sql);
        $con->bindValue(":ob", $obrazek, PDO::PARAM_STR);
        $con->bindValue(":p", $popis, PDO::PARAM_STR);
        $con->bindValue(":id", $id, PDO::PARAM_INT);
        $con->execute();
        header("location: galerie.php");
    } else {
        $_SESSION["errors"] = $errors;
        header("location: galerie_upravit.php?id=" .$id);
    }
?>