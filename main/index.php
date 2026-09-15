<?php
    include "db.php";
    $novinky_pocet = 0;
    $nazev_koupaliste = $nazev_koupaliste ?? "Koupaliště";
    $cesta_loga = $cesta_loga ?? "";
    $sql = "SELECT * FROM aktuality ORDER BY datum DESC LIMIT 3";
    $con = $db->prepare($sql);
    $con->execute();
    $aktuality = $con->fetchAll(PDO::FETCH_ASSOC);
    $sql = "SELECT * FROM nastaveni";
    $con = $db->prepare($sql);
    $con->execute();
    $nastaveni = $con->fetchAll(PDO::FETCH_ASSOC);
    $teplota_vody = null;
    foreach ($nastaveni as $value) {
        $teplota_vody = $value["teplota_vody"];
    }
    $sql = "SELECT * FROM provozni_doba WHERE platnost_od <= CURDATE() AND platnost_do >= CURDATE() ORDER BY FIELD(den, 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota', 'Neděle')";
    $con = $db->prepare($sql);
    $con->execute();
    $doba = $con->fetchAll(PDO::FETCH_ASSOC);
    $sql = "SELECT * FROM aktuality ORDER BY datum DESC";
    $con = $db->prepare($sql);
    $con->execute();
    $data = $con->fetchAll(PDO::FETCH_ASSOC);
    $pocet = count($data);
    $index = (int)($_GET["index"] ?? 0);
    if ($index < 0) {
        $index = 0;
    }
    if ($index > $pocet - 1) {
        $index = $pocet - 1;
    }
?>
<!DOCTYPE html>
<html lang="cs" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nazev_koupaliste; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="frontend.css">
</head>
<body>
    <nav class="fe-nav">
        <div class="container is-flex is-justify-content-space-between is-align-items-center py-3">
            <a class="fe-brand is-flex is-align-items-center" href="index.php">
                <?php if (!empty($cesta_loga)) { ?><img src="<?php echo $cesta_loga; ?>" alt="logo" class="mr-2" style="height:2rem;"><?php } ?>
                <?php echo $nazev_koupaliste; ?>
            </a>
            <div class="fe-nav-links">
                <a href="novinky.php">Aktuality</a>
                <a href="provoz.php">Otevírací doba</a>
                <a href="vybaveni.php">Atrakce</a>
                <a href="fotogalerie.php">Galerie</a>
                <a href="kontaktni-udaje.php">Kontakt</a>
            </div>
        </div>
    </nav>
    <header class="fe-header">
        <h1><?php echo $nazev_koupaliste; ?></h1>
        <p>Léto, voda, sluníčko - přesně tak, jak má být.</p>
        <?php if ($teplota_vody != null) { ?>
        <div class="fe-badge">Teplota vody dnes: <?php echo $teplota_vody; ?> °C</div>
        <?php } ?>
    </header>
    <div class="wave-divider">
        <svg viewBox="0 0 1440 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,32 C360,90 1080,-10 1440,48 L1440,100 L0,100 Z" fill="#f2e8d5"></path>
        </svg>
    </div>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-4">
                    <p class="fe-section-title mb-3">Dnes otevřeno</p>
                    <div class="fe-card mb-4">
                        <?php
                            if (empty($doba)) {
                                echo "<p>Zatím nenastaveno</p>";
                            } else {
                                foreach ($doba as $value) {
                                    echo "<p>";
                                    echo "<b>";
                                    echo $value["den"];
                                    echo "</b>";
                                    echo ": ";
                                    echo substr($value["otevreno_od"], 0, 5);
                                    echo " - ";
                                    echo substr($value["otevreno_do"], 0, 5);
                                    echo "</p>";
                                }
                            }
                        ?>
                        <p class="mt-3"><a href="provoz.php">Celá otevírací doba a ceník →</a></p>
                    </div>
                </div>
                <div class="column is-8">
                    <p class="fe-section-title mb-3">Aktuality</p>
                    <?php
                        if (empty($aktuality)) {
                            echo "<p>Zatím žádné aktuality.</p>";
                        } else {
                            foreach ($aktuality as $value) {
                                $novinky_pocet++;
                                if ($novinky_pocet < 4) {
                                    echo "<a href='https://novotja25.sps-prosek.cz/cms/main/novinky.php?index=".$index."'>";
                                    echo "<div class='fe-card mb-4'>";
                                    echo "<span class='fe-tag-date'>";
                                    echo $value["datum"];
                                    echo "</span>";
                                    echo "<h2 class='title is-5'>";
                                    echo $value["nadpis"];
                                    echo "</h2>";
                                    echo "</div>";
                                    echo "</a>";
                                    $index++; 
                                }
                                
                            }
                        }
                    ?>
                    <p><a class="fe-button" href="novinky.php">Všechny aktuality</a></p>
                </div>
            </div>
        </div>
    </section>
    <footer class="fe-footer">
        <p>
            <a href="novinky.php">Aktuality</a>
            <a href="provoz.php">Otevírací doba</a>
            <a href="vybaveni.php">Atrakce</a>
            <a href="fotogalerie.php">Galerie</a>
            <a href="kontaktni-udaje.php">Kontakt</a>
        </p>
        <p class="mt-3">&copy; <?php echo date("Y"); ?> <?php echo $nazev_koupaliste; ?></p>
    </footer>
</body>
</html>
