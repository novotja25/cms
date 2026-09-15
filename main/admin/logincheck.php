<?php
    session_start();
    include '../lib.php';
    $uzivatelske_jmeno = $_POST["uzivatelske_jmeno"] ?? null;
    $heslo = $_POST["heslo"] ?? null;
    $hashall = saltedhash($heslo, $uzivatelske_jmeno);

    $sql = "SELECT * FROM administrator WHERE uzivatelske_jmeno = :u AND heslo_hash = :h";
    $con = $db->prepare($sql);
    $con->bindValue(":u", $uzivatelske_jmeno, PDO::PARAM_STR);
    $con->bindValue(":h", $hashall, PDO::PARAM_STR);
    $con->execute();
    $data = $con->fetchAll(PDO::FETCH_ASSOC);
    if (empty($data)) {
        $_SESSION["errorlogin"] = "spatne zadane udaje";
        header("location: login.php");
    } else {
        foreach ($data as $value) {
            $_SESSION["loginid"] = $value["ID_data"];
            $_SESSION["uroven_opravneni"] = $value["uroven_opravneni"];
            $_SESSION["uzivatelske_jmeno"] = $value["uzivatelske_jmeno"];
        }
        header("location: dashboard.php");
    }
?>