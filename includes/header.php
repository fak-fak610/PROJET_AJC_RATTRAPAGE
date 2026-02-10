<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' - Centre AJC' : 'Centre AJC' ?></title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Styles globaux -->
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <?php
    $current_page = isset($_GET['page']) ? $_GET['page'] : basename($_SERVER['PHP_SELF']);
    if ($current_page === 'mes_favoris'): ?>
        <link rel="stylesheet" href="../assets/css/mes_favoris.css">
        <link rel="stylesheet" href="../assets/css/header_mooc.css">
    <?php elseif ($current_page === 'mooc'): ?>
        <link rel="stylesheet" href="../assets/css/mooc.css">
        <link rel="stylesheet" href="../assets/css/header_mooc.css">
    <?php elseif (strpos($current_page, 'bibliotheque') !== false): ?>
        <link rel="stylesheet" href="../assets/css/bibli.css">
    <?php endif; ?>
    <?php if (strpos($current_page, 'bibliotheque') !== false || strpos($current_page, 'livres') !== false): ?>
    <link rel="stylesheet" href="../assets/css/bibli.css">
    <?php endif; ?>

</head>
<body>

<header class="bg-dark py-2 mb-0 border-0 shadow-none">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <a href="index.php?page=home" class="d-flex align-items-center me-4">
                <img src="../assets/images/logo ajc.png" alt="Logo Centre AJC" width="100">
            </a>

            <nav class="flex-grow-1">
                <ul class="nav justify-content-center mb-0">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php?page=home"><i class="fa-solid fa-house"></i> Accueil</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="index.php?page=mooc"><i class="fa-solid fa-headphones"></i> MOOC</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="index.php?page=bibliotheque"><i class="fa-solid fa-book"></i> Bibliothèque</a></li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link text-white" href="index.php?page=mes_favoris"><i class="fas fa-heart"></i> Mes favoris</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <div class="ms-auto d-flex gap-2">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <a href="index.php?page=admin_dashboard" class="btn btn-danger">👑 ADMIN</a>
                    <?php endif; ?>
                    <a href="index.php?page=profil" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-user"></i> Profil
                    </a>
                    <a href="index.php?page=deconnexion" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                <?php else: ?>
                    <a href="index.php?page=connexion" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-in-alt"></i> Connexion
                    </a>
                    <a href="index.php?page=inscription" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-plus"></i> Inscription
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!in_array($current_page, ['connexion.php', 'inscription.php', 'mot_de_passe_oublie.php'])): ?>
            <div class="row mt-3 justify-content-center">
                <div class="col-md-6">
                    <form method="get" action="index.php" class="input-group">
                        <input type="hidden" name="page" value="mooc">
                        <input type="text" name="q" class="form-control py-2" placeholder="Rechercher un cours..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
                        <button class="btn btn-outline-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</header>
