<?php
    require_once 'db.php';
    function saltedhash($password, $email){
        $hashpassword = hash('sha512', $password);
        $hashemail = hash('sha256', $email);
        $salt = substr($hashemail, -3);
        $hashall = $hashemail.$hashpassword.$salt;
        return $hashall;
    }
    function zapisadmin($uzivatelske_jmeno, $hashall, $uroven_opravneni){
        global $db;
        $sql = "INSERT INTO administrator (uzivatelske_jmeno, heslo_hash, uroven_opravneni) VALUES (:u, :h, :o)";
        $con = $db->prepare($sql);
        $con->bindValue(":u", $uzivatelske_jmeno, PDO::PARAM_STR);
        $con->bindValue(":h", $hashall, PDO::PARAM_STR);
        $con->bindValue(":o", $uroven_opravneni, PDO::PARAM_INT);
        $con->execute();
    }
    function checkusername($uzivatelske_jmeno){
        global $db;
        $sql = "SELECT 1 FROM administrator WHERE uzivatelske_jmeno = :u LIMIT 1";
        $con = $db->prepare($sql);
        $con->bindValue(":u", $uzivatelske_jmeno, PDO::PARAM_STR);
        $con->execute();
        $ucheck = $con->fetchColumn();
        return $ucheck ? 2 : 1;
    }
    function pocetradku($tabulka){
        global $db;
        $sql = "SELECT COUNT(*) FROM " .$tabulka;
        $con = $db->prepare($sql);
        $con->execute();
        $data = $con->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]["COUNT(*)"];
    }
?>