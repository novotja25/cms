<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../db.php";
    $sql = "SELECT * FROM aktuality WHERE ID_data = :id";
    $con = $db->prepare($sql);
    $con->bindValue(":id", $_GET["id"], PDO::PARAM_INT);
    $con->execute();
    $data = $con->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $value) {
        $id = $value["ID_data"];
        $nadpis = $value["nadpis"];
        $text = $value["text"];
        $datum = $value["datum"];
    }
?>
<!DOCTYPE html>
<html lang="cs" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravit aktualitu - administrace</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="navbar" role="navigation">
        <div class="container is-flex is-justify-content-space-between is-align-items-center py-3">
            <a class="title is-5 mb-0" href="dashboard.php">Koupaliště - administrace</a>
            <div class="is-flex is-align-items-center">
                <span class="mr-3">Přihlášen jako <?php echo $_SESSION["uzivatelske_jmeno"]; ?></span>
                <span class="tag is-info mr-3">Úroveň <?php echo $_SESSION["uroven_opravneni"]; ?></span>
                <a class="button is-light" href="odhlaseni.php">Odhlásit</a>
            </div>
        </div>
    </nav>
    <section class="section">
        <div class="container">
            <a href="aktuality.php">Zpět na aktuality</a>
            <h1 class="title">Upravit aktualitu</h1>
            <div class="box">
                <form action="aktuality_upravit_check.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="field">
                        <label class="label" for="nadpis">Nadpis</label>
                        <div class="control">
                            <input class="input" type="text" id="nadpis" name="nadpis" value="<?php echo $nadpis; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="text">Text</label>
                        <div class="control">
                            <textarea class="textarea" id="text" name="text"><?php echo $text; ?></textarea>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="datum">Datum</label>
                        <div class="control">
                            <input class="input" type="date" id="datum" name="datum" value="<?php echo $datum; ?>">
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