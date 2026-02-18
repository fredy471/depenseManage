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
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="module" src="js/app.js"></script>
    <title>Gestionnaire de depenses</title>
</head>

<body data-user-id="<?=(int) $_SESSION['user_id'] ?>">

    <header class="container">
        <div class="row align-items-center element">
            <div class="col-auto">
                <a class="logo" href="#">
                    <img src="img/favicon.png" alt="logo" class="logolink">
                </a>
            </div>

            <nav class="col-auto menulink">
                <a class="nav-link" href="index.php">Accueil</a>
                <a class="nav-link ms-4" href="form.php">Commencer</a>
                <a class="nav-link ms-4" href="analys.php">Analyse</a>
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
            </nav>
        </div>
    </header>

    <main class="content Container">
        <!--j fais une section pour dire que ici il verra les analyses globales ce sur quoi il a depense le plus -->
        <!--je veux bien  utiliser des framwork ou des librairies pour faire des grapihques-->


        <section class="container my-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="bucket-card border-0 rounded-4 p-4 position-relative overflow-hidden" id="globalstats">
                        <div class="accent-glow"></div>
                        <h4 class="text-white fw-bold mb-3">Analyse globale</h4>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="small text-secondary">Budget total</div>
                                <div class="h5 text-white mb-0"><span id="globalTotalBudget">0</span> F</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="small text-secondary">Dépenses totales</div>
                                <div class="h5 text-danger mb-0"><span id="globalTotalSpent">0</span> F</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="small text-secondary">Restant total</div>
                                <div class="h5 text-success mb-0"><span id="globalRemaining">0</span> F</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="small text-secondary">Catégorie la plus dépensée</div>
                                <div class="h5 text-white mb-0">
                                    <span id="globalTopCategory">Aucune</span>
                                    <span class="text-secondary"> - </span>
                                    <span id="globalTopCategoryAmount">0</span> F
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>


    <footer class="container-fluid py-5" style="border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="footer-css row justify-content-around align-items-center text-secondary">

            <div class="col-md-4 text-center text-md-start">
                <p class="mb-0"> Frydev &copy; 2026 <span class="text-white fw-bold"></span>. Tous droits réservés.</p>
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
    <!--Modal pour pannier-->
    <div class="modal fade" id="creerPanierModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-secondary">
                <div class="modal-header border-bottom border-secondary">
                    <h5 class="modal-title text-white">Nouveau Panier</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="bucketName" class="form-control mb-3" placeholder="Nom du projet">
                    <input type="number" id="bucketBudget" class="form-control" placeholder="Budget initial">
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-primary w-100" id="submitPanierButton" data-bs-toggle="modal"
                        data-bs-target="#creerPanierModal">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    <!---Modal pour depenses-->
    <div class="modal fade justify-content-center" id="addExpenseModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une dépense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="currentBucketId">

                    <div class="mb-3">
                        <label>Catégorie</label>
                        <select id="expenseCategory" class="form-select">
                            <option value="Transport">Transport</option>
                            <option value="Nourriture">Nourriture</option>
                            <option value="Loyer">Loyer</option>
                            <option value="Loisir">Loisir</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Montant</label>
                        <input type="number" id="expenseAmount" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="saveExpenseBtn">
                        Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!---Modal pour analytics-->
    <div class="modal fade" id="analyticsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content analytics-modal border-secondary">
                <div class="modal-header analytics-header">
                    <h5 class="modal-title">Analytics du panier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body analytics-body">
                    <div class="analytics-section">
                        <h6 class="analytics-title">Top categories</h6>
                        <div id="analyticsTopCategories" class="analytics-list"></div>
                    </div>

                    <div class="analytics-section">
                        <h6 class="analytics-title">Depenses par categorie</h6>
                        <div id="analyticsCategoryBreakdown" class="analytics-list"></div>
                    </div>

                    <div class="analytics-section analytics-rule">
                        <h6 class="analytics-title">Regle 50/30/20</h6>
                        <p id="analyticsRuleSummary" class="mb-0"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="js/theme.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>