<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../db.php";
    $i = 0;
    $errors = array();
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
        $sql = "INSERT INTO atrakce (nazev, popis) VALUES (:n, :p)";
        $con = $db->prepare($sql);
        $con->bindValue(":n", $nazev, PDO::PARAM_STR);
        $con->bindValue(":p", $popis, PDO::PARAM_STR);
        $con->execute();
        header("location: atrakce.php");
    } else {
        $_SESSION["errors"] = $errors;
        header("location: atrakce.php");
    }
?>