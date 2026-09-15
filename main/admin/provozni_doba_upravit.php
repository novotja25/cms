<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    }
    include "../db.php";
    $sql = "SELECT * FROM provozni_doba WHERE ID_data = :id";
    $con = $db->prepare($sql);
    $con->bindValue(":id", $_GET["id"], PDO::PARAM_INT);
    $con->execute();
    $data = $con->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $value) {
        $id = $value["ID_data"];
        $den = $value["den"];
        $otevreno_od = $value["otevreno_od"];
        $otevreno_do = $value["otevreno_do"];
        $platnost_od = $value["platnost_od"];
        $platnost_do = $value["platnost_do"];
    }
    if (empty($id)) {
      header("location: provozni_doba.php");
    }
?>
<!DOCTYPE html>
<html lang="cs" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravit provozní dobu - administrace</title>
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
            <a href="provozni_doba.php">Zpět na provozní dobu</a>
            <h1 class="title">Upravit provozní dobu</h1>
            <div class="box">
                <form action="provozni_doba_upravit_check.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="field">
                        <label class="label" for="den">Den</label>
                        <div class="control">
                            <div class="select">
                                <select id="den" name="den">
                                    <?php
                                        $dny = array("Pondělí", "Úterý", "Středa", "Čtvrtek", "Pátek", "Sobota", "Neděle");
                                        foreach ($dny as $d) {
                                            echo "<option value='";
                                            echo $d;
                                            if ($d == $den) {
                                                echo "' selected>";
                                            } else {
                                                echo "'>";
                                            }
                                            echo $d;
                                            echo "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="otevreno_od">Otevřeno od</label>
                        <div class="control">
                            <input class="input" type="time" id="otevreno_od" name="otevreno_od" value="<?php echo $otevreno_od; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="otevreno_do">Otevřeno do</label>
                        <div class="control">
                            <input class="input" type="time" id="otevreno_do" name="otevreno_do" value="<?php echo $otevreno_do; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="platnost_od">Platnost od</label>
                        <div class="control">
                            <input class="input" type="date" id="platnost_od" name="platnost_od" value="<?php echo $platnost_od; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="platnost_do">Platnost do</label>
                        <div class="control">
                            <input class="input" type="date" id="platnost_do" name="platnost_do" value="<?php echo $platnost_do; ?>">
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
