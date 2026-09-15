<?php
   session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../db.php";
    $errors = array();
    $id = $_POST["id"] ?? null;
    $odkaz = $_POST["obrazek"] ?? null;
    $popis = $_POST["popis"] ?? null;
    if ($odkaz === '' || !filter_var($odkaz, FILTER_VALIDATE_URL)) {
       $errors[] = "Zadejte platný odkaz (např.     https://domena.cz/obrazek.jpg)";
      $_SESSION["errors"] = $errors;
      header("location: galerie.php");
      exit;
    };
    if ($popis == null) {
      $errors[] = "Zadejte popisek (např. Na tomto obrázku je pes)";
        $_SESSION["errors"] = $errors;
      header("location: galerie.php");
      exit;
    };
    if ($id == null) {
      $sql = "INSERT INTO galerie (odkaz_obrazek, popis) VALUES (:ob, :p)";
            $con = $db->prepare($sql);
            $con->bindValue(":ob", $odkaz, PDO::PARAM_STR);
            $con->bindValue(":p", $popis, PDO::PARAM_STR);
            $con->execute();
    } else {
      $sql = "UPDATE galerie SET odkaz_obrazek = :ob, popis = :p, WHERE ID_data = :id";
            $con = $db->prepare($sql);
            $con->bindValue(":ob", $odkaz, PDO::PARAM_STR);
            $con->bindValue(":p", $popis, PDO::PARAM_STR);;
            $con->bindValue(":id", $id, PDO::PARAM_INT);
            $con->execute();
    }
    $_SESSION["galerie_uspech"] = "úspěšně nahráno";
    header("location: galerie.php");
