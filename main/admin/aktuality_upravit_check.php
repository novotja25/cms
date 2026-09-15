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
    $nadpis = $_POST["nadpis"];
    $text = $_POST["text"];
    $datum = $_POST["datum"];
    if ($nadpis == null) {
        $errors[] = "vyplnte nadpis";
        $i++;
    }
    if ($text == null) {
        $errors[] = "vyplnte text";
        $i++;
    }
    if ($datum == null) {
        $errors[] = "vyplnte datum";
        $i++;
    }
    if ($i == 0) {
        $sql = "UPDATE aktuality SET nadpis = :n, text = :t, datum = :d WHERE ID_data = :id";
        $con = $db->prepare($sql);
        $con->bindValue(":n", $nadpis, PDO::PARAM_STR);
        $con->bindValue(":t", $text, PDO::PARAM_STR);
        $con->bindValue(":d", $datum, PDO::PARAM_STR);
        $con->bindValue(":id", $id, PDO::PARAM_INT);
        $con->execute();
        header("location: aktuality.php");
    } else {
        $_SESSION["errors"] = $errors;
        header("location: aktuality_upravit.php?id=" .$id);
    }
?>