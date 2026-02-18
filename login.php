<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gérez vos dépenses efficacement avec notre application de gestion de budget. Créez des paniers, suivez vos dépenses et optimisez votre budget selon la règle du 50/30/20.">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>Gestionnaire de depenses</title>
</head>

<body>

    <main>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <form method="POST" class="col-md-5 col-12 col-sm-6  col-lg-4 m-auto login-css" action="auth.php">
                    <div class="col-12 m-auto col-md-12 mb-4">
                        <h1 class="text-center">Bienvenue</h1>
                        <p class="">Connectez-vous ou creer un compte pour acceder gratuitement à depensesManager</p>
                    </div>
                    <div class="mb-4">
                        <?php
                        if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
                            echo "<div class='alert alert-danger'>" . htmlspecialchars($_SESSION['error']) . "</div>";
                            unset($_SESSION['error']);
                        }
                        ?>

                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Votre Email <span>*</span></label>
                        <input type="email" id="email" class="form-control" placeholder="welcome@gmail.com" name="email">
                    </div>

                    <div class="mb-4">
                        <label for="pwd" class="form-label">Mot de passe <span>*</span></label>
                        <input type="password" class="form-control" placeholder="*****" name="pwd" id="pwd">
                        <small class="text-dark bg-danger"></small>
                    </div>

                    <div class="">
                        <button class="btn btn-lg roounded-0 w-100 btn-primary mt-4" type="submit" name="submit">Se connecter</button>
                    </div>
                    <div>
                        <small class="muted" style="flex-wrap:nowrap;">Vous n'avez pas encore de compte ? <a href="./signin.php" class="">Inscrivez-vous</a></small>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>

</html>