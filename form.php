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
                <a class="nav-link ms-4 text-danger logout-link" href="#" id="deconnect">Deconnexion</a>
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
                <a class="nav-link ms-4 text-danger logout-link" href="#">Deconnexion</a>
            </nav>
        </div>
    </header>

    <main class="content Container">
        <section class="banner-coach">
            <div class="banner-content">
                <div class="banner-icon">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <div class="banner-text">
                    <p><strong>Épargnez plus intelligemment :</strong> nous analysons votre budget selon la règle du
                        <strong>50/30/20</strong> pour optimiser votre gestion.
                    </p>
                </div>
                <button class="btn-info-rule" title="En savoir plus">
                    <i class="fa-solid fa-circle-info"></i>
                </button>
            </div>
        </section>

        <div class="section-form-css container">
            <div class="row">
                <div class="col-md-8 d-flex justify-content-between align-items-center mb-2 mx-auto">
                    <h4 class="mb-0 fw-bold text-white">Gerez votre budget ici</h4>
                    <span class="fs-4">
                        <i class="fa-solid fa-wallet text-primary"></i>
                    </span>
                </div>
            </div>
            <hr>
            <template id="bucketTemplate">
                <div class="swiper-slide">
                    <div class="bucket-card border-0 rounded-4 p-4 position-relative overflow-hidden">
                        <div class="accent-glow"></div>

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h3 class="bucket-name h5 text-white fw-bold mb-0"></h3>
                            <button class="btn btn-danger btn-sm delete-bucket-btn">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>

                        <div class="bucket-stats mt-4">
                            <div class="d-flex justify-content-between small text-secondary mb-1">
                                <span>Progression</span>
                                <span class="percent-text"></span>
                            </div>
                            <div class="progress bg-secondary bg-opacity-25 mb-4" style="height: 6px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                            </div>

                            <div class="row g-2 text-center">
                                <div class="col-6 text-start">
                                    <span class="bucket-budget fw-bold text-white"></span> <small
                                        class="text-secondary">F</small>
                                </div>
                            </div>
                        </div>
                        <ul class="expense-list"></ul>
                        <div
                            class="analytics d-flex justify-content-between align-items-center mt-3 small text-secondary">
                            <div>
                                Dépensé :
                                <span class="bucket-total fw-bold text-danger"></span> F CFA
                            </div>

                            <div>
                                Restant :
                                <span class="bucket-remaining fw-bold text-success"></span> F CFA
                            </div>
                        </div>

                        <div class="mt-4 d-flex align-items-center">
                            <div class="flex-fill"></div>
                            <div class="text-center">
                                <button class="add-expense-btn btn btn-outline-primary rounded-pill btn-sm px-4">
                                    <i class="fa-solid fa-plus-circle me-1"></i> Ajouter une dépense
                                </button>
                            </div>
                            <div class="flex-fill text-end">
                                <a href="#" class="nav-link p-0 view-analytics-link">Voir analytics</a>
                            </div>
                        </div>

                    </div>
            </template>

            <div id="bucketContainer"></div>

            <template id="expenseTemplate">
                <li class="expense-item flex-wrap d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex"> Type:
                        <span class="expense-category"></span>
                    </div>

                    <div class="d-flex">Montant:
                        <span class="expense-amount me-2"></span> F
                    </div>
                    <button class="btn btn-sm btn-danger delete-expense-btn"><i class="fa-solid fa-trash"></i></button>
                </li>
            </template>



            <div class="row  mt-4 col-md-8 justify-content-between align-items-center">
                <div class="" style="position:relative;">
                    <button class="btn btn-primary panierBtn" data-bs-toggle="modal" data-bs-target="#creerPanierModal">
                        <i class="fa-solid fa-plus"></i> <span style="color: white !important;">Créer un panier</span>
                    </button>
                </div>
            </div>

            <div class=""></div>
        </div>
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
