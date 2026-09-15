<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../lib.php";
    $errors = $_SESSION["errors"] ?? null;
    $uspech = $_SESSION["galerie_uspech"] ?? null;
    unset($_SESSION["errors"]);
    unset($_SESSION["galerie_uspech"]);
    $sql = "SELECT * FROM galerie ORDER BY ID_data DESC";
    $con = $db->prepare($sql);
    $con->execute();
    $data = $con->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="cs" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie - administrace</title>
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
            <h1 class="title">Galerie</h1>
            <div class="box">
                <h2 class="title is-5">Přidat fotografii</h2>
                <?php
                    if ($errors != null) {
                        foreach ($errors as $value) {
                            echo "<div class='notification is-danger'>";
                            echo $value;
                            echo "</div>";
                        }
                    }
              if ($uspech != null) {
                echo "<div class='notification is-success'>";
                      echo $uspech;
                      echo "</div>";
              }
                ?>
                <form action="galerie_zapis.php" method="post" enctype="multipart/form-data">
                    <div class="field">
                        <label class="label" for="obrazek">Obrázek ( Odkaz )</label>
                        <div class="control">
                            <input class="input" type="url" id="obrazek" name="obrazek" placeholder="https://website.com/image.png">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="popis">Popis</label>
                        <div class="control">
                            <input class="input" type="text" id="popis" name="popis">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input class="button is-link" type="submit" value="Nahrát">
                        </div>
                    </div>
                </form>
            </div>
            <div class="columns is-multiline">
                <?php
                    foreach ($data as $value) {
                        echo "<div class='column is-3'>";
                        echo "<div class='box'>";
                        echo "<figure class='image is-4by3'>";
                        echo "<img src='".$value["odkaz_obrazek"]. "' alt='" . $value["popis"]."'>";
                        echo "</figure>";
                        echo "<";
                        echo $value["popis"];
                        echo "'>";
                        echo "</figure>";
                        echo "<p>";
                        echo $value["popis"];
                        echo "</p>";
                        echo "<a href='galerie_smazat.php?id=";
                        echo $value["ID_data"];
                        echo "'>Smazat</a>";
                        echo " ";
                        echo "<a href='galerie_upravit.php?id=";
                        echo $value["ID_data"];
                        echo "'>Upravit</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
    </section>
</body>
</html>