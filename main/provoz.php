<?php
    include "db.php";
    $nazev_koupaliste = $nazev_koupaliste ?? "Koupaliště";
    $cesta_loga = $cesta_loga ?? "";
    $sql = "SELECT * FROM provozni_doba WHERE platnost_od <= CURDATE() AND platnost_do >= CURDATE() ORDER BY FIELD(den, 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota', 'Neděle')";
    $con = $db->prepare($sql);
    $con->execute();
    $doba = $con->fetchAll(PDO::FETCH_ASSOC);
    $sql = "SELECT * FROM cenik ORDER BY typ_vstupenky ASC";
    $con = $db->prepare($sql);
    $con->execute();
    $ceny = $con->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="cs" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otevírací doba a ceník - <?php echo $nazev_koupaliste; ?></title>
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
        <a class="fe-back" href="index.php">← Zpět na hlavní stránku</a>
        <h1>Otevírací doba a ceník</h1>
    </header>
    <div class="wave-divider">
        <svg viewBox="0 0 1440 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,32 C360,90 1080,-10 1440,48 L1440,100 L0,100 Z" fill="#f2e8d5"></path>
        </svg>
    </div>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <div class="fe-card">
                        <p class="fe-section-title mb-3">Otevírací doba</p>
                        <?php
                            if (empty($doba)) {
                                echo "<p>Otevírací doba zatím není nastavena.</p>";
                            } else {
                        ?>
                        <table class="table is-fullwidth is-striped">
                            <tbody>
                                <?php
                                    foreach ($doba as $value) {
                                        echo "<tr>";
                                        echo "<td>";
                                        echo $value["den"];
                                        echo "</td>";
                                        echo "<td>";
                                        echo substr($value["otevreno_od"], 0, 5);
                                        echo " - ";
                                        echo substr($value["otevreno_do"], 0, 5);
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                </div>
                <div class="column">
                    <div class="fe-card">
                        <p class="fe-section-title mb-3">Ceník</p>
                        <?php
                            if (empty($ceny)) {
                                echo "<p>Ceník zatím není nastaven.</p>";
                            } else {
                        ?>
                        <table class="table is-fullwidth is-striped">
                            <tbody>
                                <?php
                                    foreach ($ceny as $value) {
                                        echo "<tr>";
                                        echo "<td>";
                                        echo $value["typ_vstupenky"];
                                        echo "</td>";
                                        echo "<td>";
                                        echo $value["cena"];
                                        echo " Kč";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
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
