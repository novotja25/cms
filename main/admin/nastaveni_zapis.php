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
    $teplota_vody = $_POST["teplota_vody"] ?? null;
    $nazev_koupaliste_pole = $_POST["nazev_koupaliste"] ?? null;
    $cesta_loga_pole = $_POST["cesta_loga"] ?? null;
    if ($teplota_vody == null) {
        $errors[] = "vyplnte teplotu vody";
        $i++;
    }
    if ($nazev_koupaliste_pole == null) {
        $errors[] = "vyplnte nazev koupaliste";
        $i++;
    }
    if ($i == 0) {
        if (empty($id)) {
            $sql = "INSERT INTO nastaveni (teplota_vody, nazev_koupaliste, cesta_loga) VALUES (:t, :n, :l)";
            $con = $db->prepare($sql);
            $con->bindValue(":t", $teplota_vody, PDO::PARAM_STR);
            $con->bindValue(":n", $nazev_koupaliste_pole, PDO::PARAM_STR);
            $con->bindValue(":l", $cesta_loga_pole, PDO::PARAM_STR);
            $con->execute();
        } else {
            $sql = "UPDATE nastaveni SET teplota_vody = :t, nazev_koupaliste = :n, cesta_loga = :l WHERE ID_data = :id";
            $con = $db->prepare($sql);
            $con->bindValue(":t", $teplota_vody, PDO::PARAM_STR);
            $con->bindValue(":n", $nazev_koupaliste_pole, PDO::PARAM_STR);
            $con->bindValue(":l", $cesta_loga_pole, PDO::PARAM_STR);
            $con->bindValue(":id", $id, PDO::PARAM_INT);
            $con->execute();
        }
        header("location: nastaveni.php");
    } else {
        $_SESSION["errors"] = $errors;
        header("location: nastaveni.php");
    }
?>
