<?php
    require_once 'config.php';
    define('DB_NAME', 'novotja25');
    define('DB_USER', 'novotja25');
    define('DB_PASSWORD', 'rnZUz9ga');
    define('DB_HOST', '127.0.0.1');

    global $db;
    $db = new PDO(
            "mysql:host=" .DB_HOST. ";dbname=" .DB_NAME,DB_USER,DB_PASSWORD, null
          );
    $sql = "SELECT * FROM nastaveni";
    $con = $db->prepare($sql);
    $con->execute();
    $nastaveni_data = $con->fetchAll(PDO::FETCH_ASSOC);
    foreach ($nastaveni_data as $value) {
        if (!empty($value["nazev_koupaliste"])) {
            $nazev_koupaliste = $value["nazev_koupaliste"];
        }
        if (!empty($value["cesta_loga"])) {
            $cesta_loga = $value["cesta_loga"];
        }
    }
?>
