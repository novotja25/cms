
<?php
    session_start();
    if (empty($_SESSION["loginid"])) {
        header("location: login.php");
        exit;
    } elseif ($_SESSION["uroven_opravneni"] >= 3) {
        header("location: dashboard.php");
        exit;
    } else {
        include "../db.php";
        $errors = $_SESSION["errors"] ?? null;
        unset($_SESSION["errors"]);
    }
?>
<!DOCTYPE html>
<html lang="cs" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nový uživatel - administrace</title>
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
            <div class="columns is-centered">
                <div class="column is-4">
                    <h1 class="title has-text-centered">Nový uživatel</h1>
                    <div class="box">
                        <?php
                            if ($errors != null) {
                                foreach ($errors as $value) {
                                    echo "<div class='notification is-danger'>";
                                    echo $value;
                                    echo "</div>";
                                }
                            }
                        ?>
                        <form action="registracecheck.php" method="post">
                            <div class="field">
                                <label class="label" for="uzivatelske_jmeno">Uživatelské jméno</label>
                                <div class="control">
                                    <input class="input" type="text" id="uzivatelske_jmeno" name="uzivatelske_jmeno">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label" for="heslo">Heslo</label>
                                <div class="control">
                                    <input class="input" type="password" id="heslo" name="heslo">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label" for="potvrzeni_hesla">Potvrzení hesla</label>
                                <div class="control">
                                    <input class="input" type="password" id="potvrzeni_hesla" name="potvrzeni_hesla">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label" for="uroven_opravneni">Úroveň oprávnění</label>
                                <div class="control">
                                    <div class="select">
                                        <select id="uroven_opravneni" name="uroven_opravneni">
                                            <?php
                                                for ($i = $_SESSION["uroven_opravneni"]; $i <= 3; $i++) {
                                                    echo "<option value='";
                                                    echo $i;
                                                    echo "'>";
                                                    echo $i;
                                                    echo "</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input class="button is-link is-fullwidth" type="submit" value="Vytvořit uživatele">
                                </div>
                            </div>
                        </form>
                    </div>
                    <p class="has-text-centered"><a href="dashboard.php">Zpět na přehled</a></p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>