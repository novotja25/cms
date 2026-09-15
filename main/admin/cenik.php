<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../lib.php";
    $errors = $_SESSION["errors"] ?? null;
    unset($_SESSION["errors"]);
    $sql = "SELECT * FROM cenik ORDER BY typ_vstupenky ASC";
    $con = $db->prepare($sql);
    $con->execute();
    $data = $con->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="cs" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ceník - administrace</title>
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
            <h1 class="title">Ceník</h1>
            <div class="box">
                <h2 class="title is-5">Přidat položku ceníku</h2>
                <?php
                    if ($errors != null) {
                        foreach ($errors as $value) {
                            echo "<div class='notification is-danger'>";
                            echo $value;
                            echo "</div>";
                        }
                    }
                ?>
                <form action="cenik_zapis.php" method="post">
                    <div class="field">
                        <label class="label" for="typ_vstupenky">Typ vstupenky</label>
                        <div class="control">
                            <input class="input" type="text" id="typ_vstupenky" name="typ_vstupenky">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="cena">Cena (Kč)</label>
                        <div class="control">
                            <input class="input" type="number" step="0.01" min="0" id="cena" name="cena">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input class="button is-link" type="submit" value="Přidat">
                        </div>
                    </div>
                </form>
            </div>
            <table class="table is-fullwidth is-striped">
                <thead>
                    <tr>
                        <th>Typ vstupenky</th>
                        <th>Cena</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data as $value) {
                            echo "<tr>";
                            echo "<td>";
                            echo $value["typ_vstupenky"];
                            echo "</td>";
                            echo "<td>";
                            echo $value["cena"];
                            echo " Kč";
                            echo "</td>";
                            echo "<td>";
                            echo "<a href='cenik_upravit.php?id=";
                            echo $value["ID_data"];
                            echo "'>Upravit</a> ";
                            echo "<a href='cenik_smazat.php?id=";
                            echo $value["ID_data"];
                            echo "'>Smazat</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
