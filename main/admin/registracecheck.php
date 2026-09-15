<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    } elseif ($_SESSION["uroven_opravneni"] >= 3) {
        header("location: dashboard.php");
        exit;
    }
    include '../lib.php';
    $i = 0;
    $errors = array();
    $uzivatelske_jmeno = $_POST["uzivatelske_jmeno"];
    $heslo = $_POST["heslo"];
    $potvrzeni_hesla = $_POST["potvrzeni_hesla"];
    $uroven_opravneni = $_POST["uroven_opravneni"];
    if ($uzivatelske_jmeno == null) {
        $errors[] = "vyplnte uzivatelske jmeno";
        $i++;
    }
    if ($heslo == null) {
        $errors[] = "vyplnte heslo";
        $i++;
    }
    if ($potvrzeni_hesla == null) {
        $errors[] = "vyplnte potvrzeni hesla";
        $i++;
    }
    if ($heslo != $potvrzeni_hesla) {
        $errors[] = "hesla se neshoduji";
        $i++;
    }
    if ($uzivatelske_jmeno != null && checkusername($uzivatelske_jmeno) == 2) {
        $errors[] = "uzivatelske jmeno se uz pouziva";
        $i++;
    }
    if ($uroven_opravneni < $_SESSION["uroven_opravneni"] || $uroven_opravneni > 3) {
        $errors[] = "neplatna uroven opravneni";
        $i++;
    }
    if ($i == 0) {
        $hashall = saltedhash($heslo, $uzivatelske_jmeno);
        zapisadmin($uzivatelske_jmeno, $hashall, $uroven_opravneni);
        header("location: dashboard.php");
    } else {
        $_SESSION["errors"] = $errors;
        header("location: registrace.php");
    }
?>