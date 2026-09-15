<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../lib.php";
    $errors = $_SESSION["errors"] ?? null;
    unset($_SESSION["errors"]);
    $sql = "SELECT * FROM kontakt";
    $con = $db->prepare($sql);
    $con->execute();
    $data = $con->fetchAll(PDO::FETCH_ASSOC);
    $id = null;
    $adresa = null;
    $telefon = null;
    $email = null;
    $mapa_odkaz = null;
    $uspech_kontakt = $_SESSION["kontakt_uspech"] ?? 
     null;
    unset($_SESSION["kontakt_uspech"]);
    foreach ($data as $value) {
        $id = $value["ID_data"];
        $adresa = $value["adresa"];
        $telefon = $value["telefon"];
        $email = $value["email"];
        $mapa_odkaz = $value["mapa_odkaz"];
    }
?>
<!DOCTYPE html>
<html lang="cs" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt - administrace</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="navbar" role="navigation">
        <div class="container is-flex is-justify-content-space-between is-align-items-center py-3">
            <a class="navbar-brand-link is-flex is-align-items-center" href="dashboard.php"><?php if (!empty($cesta_loga)) { ?><img src="<?php echo $cesta_loga; ?>" alt="logo" class="mr-2" style="height:2rem;"><?php } ?><span class="title is-5 mb-0"><?php echo $nazev_koupaliste; ?> - administrace</span></a>
            <div class="is-flex is-align-items-center">
                <span class="mr-3">Přihlášen jako <?php echo $_SESSION["uzivatelske_jmeno"]; ?></span>
                <span class="tag is-info mr-3">Úroveň <?php echo $_SESSION["uroven_opravneni"]; ?></span>
                <a class="button is-light" href="odhlaseni.php">Odhlásit</a>
        </div>
    </nav>
    <section class="section">
        <div class="container">
            <a href="dashboard.php">Zpět na přehled</a>
            <h1 class="title">Kontakt</h1>
            <div class="box">
                <?php
                    if ($errors != null) {
                        foreach ($errors as $value) {
                            echo "<div class='notification is-danger'>";
                            echo $value;
                            echo "</div>";
                        }
                    } else
                    if ($uspech_kontakt != null) {
                      echo "<div class='notification is-success'>";
                      echo $uspech_kontakt;
                      echo "</div>";
                    }
                ?>
                <form action="kontakt_zapis.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="field">
                        <label class="label" for="adresa">Adresa</label>
                        <div class="control">
                            <input class="input" type="text" id="adresa" name="adresa" value="<?php echo $adresa; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="telefon">Telefon</label>
                        <div class="control">
                            <input class="input" type="text" id="telefon" name="telefon" value="<?php echo $telefon; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="email">Email</label>
                        <div class="control">
                            <input class="input" type="email" id="email" name="email" value="<?php echo $email; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="mapa_odkaz">Odkaz na mapu</label>
                            <?php if (!empty($mapa_odkaz)) {
                                echo '<div class="control">';
                                echo '<input type="hidden" name="og_mapa_odkaz" value="'.htmlspecialchars($mapa_odkaz).'">';
                                echo '<input class="input" type="text" name="mapa_odkaz" id="mapa_odkaz" value="" placeholder="mapa nastavena">';
                                echo '</div>';
                            } else {
                                echo '<div class="control"><input class="input" type="text" name="mapa_odkaz" id="mapa_odkaz" value="" placeholder="vyplňte embed kod z google map"></div>';
                            } ?>
                        </div>
                    <div class="field">
                        <div class="control">
                            <input class="button is-link" type="submit" value="Uložit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>