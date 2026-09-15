<?php
    include "db.php";
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
    <title>Aktuality - Koupaliště</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <h1 class="title has-text-centered">Aktuality</h1>
            <?php if ($pocet == 0) { ?>
            <p class="has-text-centered">Zatím žádné aktuality.</p>
            <?php } else { ?>
            <div class="carousel-wrap">
                <?php if ($index > 0) { ?>
                <a class="carousel-arrow" href="aktuality.php?index=<?php echo $index - 1; ?>" aria-label="Novější aktualita">←</a>
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
                <a class="carousel-arrow" href="aktuality.php?index=<?php echo $index + 1; ?>" aria-label="Starší aktualita">→</a>
                <?php } else { ?>
                <span class="carousel-arrow carousel-arrow-disabled" aria-hidden="true">→</span>
                <?php } ?>
            </div>
            <?php if ($index > 0) { ?>
            <div class="has-text-centered mt-4">
                <a class="button is-link" href="aktuality.php">Vrátit do současnosti</a>
            </div>
            <?php } ?>
            <?php } ?>
        </div>
    </section>
</body>
</html>