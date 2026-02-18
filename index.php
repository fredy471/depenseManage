<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Gérez vos dépenses efficacement avec notre application de gestion de budget. Créez des paniers, suivez vos dépenses et optimisez votre budget selon la règle du 50/30/20.">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>Gestionnaire de depenses</title>
</head>

<body  data-user-id="<?=(int) $_SESSION['user_id'] ?>">

    <header class="container">
        <div class="row justify-content-between align-items-center element">
            <div class="col-auto">
                <a class="logo" href="#">
                    <img src="img/favicon.png" alt="logo" class="logolink">
                </a>
            </div>

            <nav class="col-auto menulink">
                <a class="nav-link" href="#">Accueil</a>
                <a class="nav-link ms-4" href="form.php">Commencer</a>
                <a class="nav-link ms-4" href="analys.php">Analyse</a>
                <a href="#" class="nav-link ms-4 text-danger logout-link">Deconnexion</a>
            </nav>

            <div class="col-auto">
                <button id="themeToggle" class="theme-toggle">Mode clair</button>
            </div>

            <div class="col-auto" id="openNav">
                <span class="hamburgerOp"> &#9776;</span>
            </div>
        </div>



        <div class=" row menulink-r" id="myNav">
            <div class="" id="closeNav">
                <span class="hamburgerCl">&times;</span>
            </div>
            <nav class="col-auto">
                <a class="nav-link ms-4" href="index.php">Accueil</a>
                <a class="nav-link ms-4" href="form.php">Commencer</a>
                <a class="nav-link ms-4" href="analys.php">Analyse</a>
                <a href="#" class="nav-link ms-4 text-danger logout-link">Deconnexion</a>
            </nav>
        </div>
    </header>

    <main class="content container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 banner text-center" data-aos="fade-up" data-aos-delay="300"
                data-aos-duration="1000">
                <h1 class="mb-4">Bienvenue sur le Gestionnaire de Dépenses</h1>
                <p class="mb-4">Suivez et analysez vos dépenses facilement avec notre application conviviale.</p>
                <a href="form.php" class="btn-banner">Commencer Maintenant <span class="arrow">&rarr;</span></a>
            </div>
        </div>

        <div class="section1-css container">
            <div class="row justify-content-around align-items-center">
                <div class="col-12 col-md-5 text-justify" data-aos="fade-up" data-aos-delay="300"
                    data-aos-duration="1000">
                    <h2 class="mb-4">Gérez vos finances en toute simplicité</h2>
                    <p class="mb-4">Prenez le contrôle de vos finances. Suivez vos dépenses, gérez votre budget et
                        visualisez vos habitudes de consommation à travers une interface intuitive.</p>
                    <a href="#" class="btn-css">En savoir plus</a>
                </div>
                <div class="col-12 col-md-5 mt-4" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
                    <img src="img/img1.jpg" alt="Gestion des finances" class="img-fluid mt-4">
                </div>
            </div>
        </div>

        <div class="section2-css container">
            <div class="row justify-content-around align-items-center">
                <div class="col-12 col-md-5 order-md-2 text-justify" data-aos="fade-up" data-aos-delay="300"
                    data-aos-duration="1000">
                    <h2 class="mb-4">Analysez vos dépenses</h2>
                    <p class="mb-4">Utilisez nos outils d'analyse pour visualiser vos dépenses par catégorie, période
                        ou mode de paiement. Identifiez les tendances et optimisez votre budget.</p>
                    <a href="#" class="btn-css">Découvrir les analyses</a>
                </div>
                <div class="col-12 col-md-5 order-md-1 mt-4" data-aos="fade-up" data-aos-delay="600"
                    data-aos-duration="2000">
                    <img src="img/img2.png" alt="Analyse des dépenses" class="img-fluid mt-4">
                </div>
            </div>
        </div>
    </main>


    <footer class="container-fluid py-5" style="border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="footer-css row justify-content-around align-items-center text-secondary">

            <div class="col-md-4 text-center text-md-start">
                <p class="mb-0">&copy; 2026 <span class="text-white fw-bold"></span>. Tous droits réservés.</p>
            </div>

            <div class="col-md-4 text-center my-3 my-md-0">
                <p class="small mb-0 italic">Maîtrisez chaque centime, gérez votre avenir.</p>
            </div>

            <div class="col-md-4 text-center text-md-end">
                <p class="mb-0">
                    <a href="#" class="text-decoration-none text-secondary me-3">Confidentialité</a>
                    <a href="#" class="text-decoration-none text-secondary">Aide</a>
                </p>
            </div>

        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="js/theme.js"></script>
    <script type="module" src="js/app.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
