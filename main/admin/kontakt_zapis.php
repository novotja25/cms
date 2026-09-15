<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../db.php";
    $i = 0;
    $errors = array();
    $id = $_POST["id"] ?? null;
    $adresa = $_POST["adresa"] ?? null;
    $telefon = $_POST["telefon"] ?? null;
    $email = $_POST["email"] ?? null;
    $mapa_odkaz = $_POST["mapa_odkaz"] ?? null;
    $og_mapa_odkaz = $_POST["og_mapa_odkaz"] ?? null;
    if ($adresa == null) {
        $errors[] = "vyplnte adresu";
        $i++;
    }
    if ($mapa_odkaz == null) {
        $mapa_odkaz = $og_mapa_odkaz;
    }
    if ($telefon == null) {
        $errors[] = "vyplnte telefon";
        $i++;
    }
    if ($email == null) {
        $errors[] = "vyplnte email";
        $i++;
    }
    if ($i == 0) {
        if (empty($id)) {
            $sql = "INSERT INTO kontakt (adresa, telefon, email, mapa_odkaz) VALUES (:a, :t, :e, :m)";
            $con = $db->prepare($sql);
            $con->bindValue(":a", $adresa, PDO::PARAM_STR);
            $con->bindValue(":t", $telefon, PDO::PARAM_STR);
            $con->bindValue(":e", $email, PDO::PARAM_STR);
            $con->bindValue(":m", $mapa_odkaz, PDO::PARAM_STR);
            $con->execute();
        } else {
            $sql = "UPDATE kontakt SET adresa = :a, telefon = :t, email = :e, mapa_odkaz = :m WHERE ID_data = :id";
            $con = $db->prepare($sql);
            $con->bindValue(":a", $adresa, PDO::PARAM_STR);
            $con->bindValue(":t", $telefon, PDO::PARAM_STR);
            $con->bindValue(":e", $email, PDO::PARAM_STR);
            $con->bindValue(":m", $mapa_odkaz, PDO::PARAM_STR);
            $con->bindValue(":id", $id, PDO::PARAM_INT);
            $con->execute();
        }
        header("location: kontakt.php");
        $_SESSION["kontakt_uspech"] = "uspěšně aktualizováno";
    } else {
        $_SESSION["errors"] = $errors;
        header("location: kontakt.php");
    }
?>