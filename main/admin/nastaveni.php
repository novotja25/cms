<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../lib.php";
    $errors = $_SESSION["errors"] ?? null;
    unset($_SESSION["errors"]);
    $sql = "SELECT * FROM nastaveni";
    $con = $db->prepare($sql);
    $con->execute();
    $data = $con->fetchAll(PDO::FETCH_ASSOC);
    $id = null;
    $teplota_vody = null;
    $nazev_koupaliste_pole = null;
    $cesta_loga_pole = null;
    foreach ($data as $value) {
        $id = $value["ID_data"];
        $teplota_vody = $value["teplota_vody"];
        $nazev_koupaliste_pole = $value["nazev_koupaliste"];
        $cesta_loga_pole = $value["cesta_loga"];
    }
?>
<!DOCTYPE html>
<html lang="cs" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nastavení - administrace</title>
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
        </div>
    </nav>
    <section class="section">
        <div class="container">
            <a href="dashboard.php">Zpět na přehled</a>
            <h1 class="title">Nastavení</h1>
            <div class="box">
                <h2 class="title is-5">Název a logo webu</h2>
                <?php
                    if ($errors != null) {
                        foreach ($errors as $value) {
                            echo "<div class='notification is-danger'>";
                            echo $value;
                            echo "</div>";
                        }
                    }
                ?>
                <form action="nastaveni_zapis.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="teplota_vody" value="<?php echo $teplota_vody; ?>">
                    <div class="field">
                        <label class="label" for="nazev_koupaliste">Název koupaliště</label>
                        <div class="control">
                            <input class="input" type="text" id="nazev_koupaliste" name="nazev_koupaliste" value="<?php echo $nazev_koupaliste_pole; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="cesta_loga">Odkaz na logo (volitelné)</label>
                        <div class="control">
                            <input class="input" type="text" id="cesta_loga" name="cesta_loga" value="<?php echo $cesta_loga_pole; ?>" placeholder="https://web.cz/logo.png">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input class="button is-link" type="submit" value="Uložit název a logo">
                        </div>
                    </div>
                </form>
            </div>
            <div class="box">
                <h2 class="title is-5">Teplota vody</h2>
                <form action="nastaveni_zapis.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="nazev_koupaliste" value="<?php echo $nazev_koupaliste_pole; ?>">
                    <input type="hidden" name="cesta_loga" value="<?php echo $cesta_loga_pole; ?>">
                    <div class="field">
                        <label class="label" for="teplota_vody">Teplota vody (°C)</label>
                        <div class="control">
                            <input class="input" type="number" step="0.1" id="teplota_vody" name="teplota_vody" value="<?php echo $teplota_vody; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input class="button is-link" type="submit" value="Uložit teplotu">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
