<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../db.php";
    $i = 0;
    $errors = array();
    $den = $_POST["den"];
    $otevreno_od = $_POST["otevreno_od"];
    $otevreno_do = $_POST["otevreno_do"];
    $platnost_od = $_POST["platnost_od"];
    $platnost_do = $_POST["platnost_do"];
    if ($den == null) {
        $errors[] = "vyplnte den";
        $i++;
    }
    if ($otevreno_od == null) {
        $errors[] = "vyplnte otevreno od";
        $i++;
    }
    if ($otevreno_do == null) {
        $errors[] = "vyplnte otevreno do";
        $i++;
    }
    if ($platnost_od == null) {
        $errors[] = "vyplnte platnost od";
        $i++;
    }
    if ($platnost_do == null) {
        $errors[] = "vyplnte platnost do";
        $i++;
    }
    if ($i == 0) {
        $sql = "INSERT INTO provozni_doba (den, otevreno_od, otevreno_do, platnost_od, platnost_do) VALUES (:den, :oo, :od, :po, :pd)";
        $con = $db->prepare($sql);
        $con->bindValue(":den", $den, PDO::PARAM_STR);
        $con->bindValue(":oo", $otevreno_od, PDO::PARAM_STR);
        $con->bindValue(":od", $otevreno_do, PDO::PARAM_STR);
        $con->bindValue(":po", $platnost_od, PDO::PARAM_STR);
        $con->bindValue(":pd", $platnost_do, PDO::PARAM_STR);
        $con->execute();
        header("location: provozni_doba.php");
    } else {
        $_SESSION["errors"] = $errors;
        header("location: provozni_doba.php");
    }
?>
