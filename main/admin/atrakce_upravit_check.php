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
    $nazev = $_POST["nazev"];
    $popis = $_POST["popis"];
    if ($nazev == null) {
        $errors[] = "vyplnte nazev";
        $i++;
    }
    if ($popis == null) {
        $errors[] = "vyplnte popis";
        $i++;
    }
    if ($i == 0) {
        $sql = "UPDATE atrakce SET nazev = :n, popis = :p WHERE ID_data = :id";
        $con = $db->prepare($sql);
        $con->bindValue(":n", $nazev, PDO::PARAM_STR);
        $con->bindValue(":p", $popis, PDO::PARAM_STR);
        $con->bindValue(":id", $id, PDO::PARAM_INT);
        $con->execute();
        header("location: atrakce.php");
    } else {
        $_SESSION["errors"] = $errors;
        header("location: atrakce_upravit.php?id=" .$id);
    }
?>