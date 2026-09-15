<?php
    include "db.php";
    $nazev_koupaliste = $nazev_koupaliste ?? "Koupaliště";
    $cesta_loga = $cesta_loga ?? "";
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
    <title>Aktuality - <?php echo $nazev_koupaliste; ?></title>
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
        <h1>Aktuality</h1>
    </header>
    <div class="wave-divider">
        <svg viewBox="0 0 1440 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,32 C360,90 1080,-10 1440,48 L1440,100 L0,100 Z" fill="#f2e8d5"></path>
        </svg>
    </div>
    <section class="section">
        <div class="container">
            <?php if ($pocet == 0) { ?>
            <p class="has-text-centered">Zatím žádné aktuality.</p>
            <?php } else { ?>
            <div class="carousel-wrap">
                <?php if ($index > 0) { ?>
                <a class="carousel-arrow" href="novinky.php?index=<?php echo $index - 1; ?>" aria-label="Novější aktualita">←</a>
                <?php } else { ?>
                <span class="carousel-arrow carousel-arrow-disabled" aria-hidden="true">←</span>
                <?php } ?>
                <div class="box carousel-box">
                    <?php
                        $value = $data[$index];
                        echo "<p class='carousel-date'>";
                        echo $value["datum"];
                        echo "</p>";
                        echo "<h2 class='title is-4'>";
                        echo $value["nadpis"];
                        echo "</h2>";
                        echo "<div class='carousel-text'>";
                        echo nl2br(htmlspecialchars($value["text"]));
                        echo "</div>";
                    ?>
                </div>
                <?php if ($index < $pocet - 1) { ?>
                <a class="carousel-arrow" href="novinky.php?index=<?php echo $index + 1; ?>" aria-label="Starší aktualita">→</a>
                <?php } else { ?>
                <span class="carousel-arrow carousel-arrow-disabled" aria-hidden="true">→</span>
                <?php } ?>
            </div>
            <?php if ($index > 0) { ?>
            <div class="has-text-centered mt-4">
                <a class="fe-button" href="novinky.php">Vrátit do současnosti</a>
            </div>
            <?php } ?>
            <?php } ?>
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
