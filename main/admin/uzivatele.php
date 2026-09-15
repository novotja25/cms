<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    } elseif ($_SESSION["uroven_opravneni"] >= 3) {
        header("location: dashboard.php");
        exit;
    }
    include "../db.php";
    $sql = "SELECT * FROM administrator ORDER BY uroven_opravneni ASC";
    $con = $db->prepare($sql);
    $con->execute();
    $data = $con->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="cs" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uživatelé - administrace</title>
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
            <a href="dashboard.php">Zpět na přehled</a>
            <h1 class="title">Uživatelé</h1>
            <div class="box">
                <a class="button is-link is-small" href="registrace.php">Přidat uživatele</a>
            </div>
            <table class="table is-fullwidth is-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Uživatelské jméno</th>
                        <th>Úroveň oprávnění</th>
                        <th>Smazat uživatele</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data as $value) {
                            echo "<tr>";
                            echo "<td>";
                            echo $value["ID_data"];
                            echo "</td>";
                            echo "<td>";
                            echo $value["uzivatelske_jmeno"];
                            echo "</td>";
                            echo "<td>";
                            echo $value["uroven_opravneni"];
                            echo "</td>";
                            echo "<td>";
                            echo "<a href='uzivatele_smazat.php?id=".$value["ID_data"]."'>"."Smazat".    "</a>";
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