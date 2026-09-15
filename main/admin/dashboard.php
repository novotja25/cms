<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    } else {
        include "../lib.php";
        $pocet_aktuality = pocetradku("aktuality");
        $pocet_provozni_doba = pocetradku("provozni_doba");
        $pocet_cenik = pocetradku("cenik");
        $pocet_galerie = pocetradku("galerie");
        $pocet_atrakce = pocetradku("atrakce");
        $pocet_kontakt = pocetradku("kontakt");
        $pocet_nastaveni = pocetradku("nastaveni");
        $pocet_administrator = pocetradku("administrator");
    }
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přehled - administrace</title>
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
            <h1 class="title">Přehled</h1>
            <div class="columns is-multiline">
                <div class="column is-4">
                    <div class="box">
                        <p class="heading">Aktuality</p>
                        <p class="title is-3"><?php echo $pocet_aktuality; ?></p>
                        <a class="button is-link is-small" href="aktuality.php">Spravovat</a>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="box">
                        <p class="heading">Provozní doba</p>
                        <p class="title is-3"><?php echo $pocet_provozni_doba; ?></p>
                        <a class="button is-link is-small" href="provozni_doba.php">Spravovat</a>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="box">
                        <p class="heading">Ceník</p>
                        <p class="title is-3"><?php echo $pocet_cenik; ?></p>
                        <a class="button is-link is-small" href="cenik.php">Spravovat</a>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="box">
                        <p class="heading">Galerie</p>
                        <p class="title is-3"><?php echo $pocet_galerie; ?></p>
                        <a class="button is-link is-small" href="galerie.php">Spravovat</a>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="box">
                        <p class="heading">Atrakce</p>
                        <p class="title is-3"><?php echo $pocet_atrakce; ?></p>
                        <a class="button is-link is-small" href="atrakce.php">Spravovat</a>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="box">
                        <p class="heading">Kontakt</p>
                        <p class="title is-3"><?php echo $pocet_kontakt; ?></p>
                        <a class="button is-link is-small" href="kontakt.php">Spravovat</a>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="box">
                        <p class="heading">Nastavení</p>
                        <p class="title is-3"><?php echo $pocet_nastaveni; ?></p>
                        <a class="button is-link is-small" href="nastaveni.php">Spravovat</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if ($_SESSION["uroven_opravneni"] < 3) { ?>
    <section class="section">
        <div class="container">
            <h2 class="title is-4">Uživatelé</h2>
            <div class="box">
                <p class="heading">Administrátoři</p>
                <p class="title is-3"><?php echo $pocet_administrator; ?></p>
                <a class="button is-link is-small" href="registrace.php">Přidat uživatele</a>
              <a class="button is-link is-small" href="/cms/main/admin/uzivatele.php">List uživatelů</a>
            </div>
        </div>
    </section>
    <?php } ?>
</body>
</html>