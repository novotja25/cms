<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../db.php";
    $sql = "SELECT * FROM galerie WHERE ID_data = :id";
    $con = $db->prepare($sql);
    $con->bindValue(":id", $_GET["id"], PDO::PARAM_INT);
    $con->execute();
    $data = $con->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $value) {
        $id = $value["ID_data"];
        $odkaz_obrazek = $value["odkaz_obrazek"];
        $popis = $value["popis"];
    }
?>
<!DOCTYPE html>
<html lang="cs" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravit fotografii - administrace</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="navbar" role="navigation">
        <div class="container is-flex is-justify-content-space-between is-align-items-center py-3">
            <a class="navbar-brand-link is-flex is-align-items-center" href="dashboard.php"><?php if (!empty($cesta_loga)) { ?><img src="<?php echo $cesta_loga; ?>" alt="logo" class="mr-2" style="height:2rem;"><?php } ?><span class="title is-5 mb-0">Koupaliště - administrace</span></a>
            <div class="is-flex is-align-items-center">
                <span class="mr-3">Přihlášen jako <?php echo $_SESSION["uzivatelske_jmeno"]; ?></span>
                <span class="tag is-info mr-3">Úroveň <?php echo $_SESSION["uroven_opravneni"]; ?></span>
                <a class="button is-light" href="odhlaseni.php">Odhlásit</a>
            </div>
        </div>
    </nav>
    <section class="section">
        <div class="container">
            <a href="galerie.php">Zpět na galerii</a>
            <h1 class="title">Upravit fotografii</h1>
            <div class="box">
                <form action="galerie_upravit_check.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="field">
                        <label class="label" for="obrazek">Obrázek (odkaz)</label>
                        <div class="control">
                            <input class="input" type="url" id="obrazek" name="obrazek" value="<?php echo $odkaz_obrazek; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="popis">Popis</label>
                        <div class="control">
                            <input class="input" type="text" id="popis" name="popis" value="<?php echo $popis; ?>">
                        </div>
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