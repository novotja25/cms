<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../db.php";
    $sql = "DELETE FROM galerie WHERE ID_data = :id";
    $con = $db->prepare($sql);
    $con->bindValue(":id", $_GET["id"], PDO::PARAM_INT);
    $con->execute();
    header("location: galerie.php");
?>