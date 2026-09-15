<?php
    session_start();
    $loginerror = $_SESSION["errorlogin"] ?? null;
    unset($_SESSION["errorlogin"]);
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení administrátora</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-4">
                    <h1 class="title has-text-centered">Přihlášení</h1>
                    <div class="box">
                        <?php
                            if ($loginerror != null) {
                                echo "<div class='notification is-danger'>";
                                echo $loginerror;
                                echo "</div>";
                            }
                        ?>
                        <form action="logincheck.php" method="post">
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
                                <div class="control">
                                    <input class="button is-link is-fullwidth" id="submitlogin" type="submit" value="Přihlásit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>