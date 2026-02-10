
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <h5 class="text-white px-3 mb-4">
                        <i class="fas fa-shield-alt"></i> Admin Panel
                    </h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="index.php?page=admin_dashboard">
                                <i class="fas fa-chart-line"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?page=admin_moocs">
                                <i class="fas fa-graduation-cap"></i> MOOCs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?page=admin_livres">
                                <i class="fas fa-book"></i> Livres
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?page=admin_users">
                                <i class="fas fa-users"></i> Utilisateurs
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link text-warning" href="index.php?page=home">
                                <i class="fas fa-home"></i> Retour au site
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="index.php?page=admin_logout">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="fas fa-chart-line"></i> Tableau de bord
                    </h1>
                </div>

                <!-- Statistiques -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-graduation-cap"></i> MOOCs
                                </h5>
                                <h2><?php echo intval($stats['moocs'] ?? 0); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-book"></i> Livres
                                </h5>
                                <h2><?php echo intval($stats['livres'] ?? 0); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-users"></i> Utilisateurs
                                </h5>
                                <h2><?php echo intval($stats['users'] ?? 0); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-file-alt"></i> Documents
                                </h5>
                                <h2><?php echo intval($stats['documents'] ?? 0); ?></h2>
                        </div>
                    </div>
                </div>

                <!-- Derniers ajouts -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-graduation-cap"></i> Derniers MOOCs
                            </div>
                            <div class="card-body">
                                <?php if (empty($derniers_moocs)): ?>
                                    <p class="text-muted">Aucun MOOC trouvé.</p>
                                <?php else: ?>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($derniers_moocs as $m): ?>
                                            <li class="list-group-item">
                                                <strong><?php echo htmlspecialchars($m['titre']); ?></strong>
                                                <br><small class="text-muted"><?php echo htmlspecialchars($m['date']); ?></small>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <i class="fas fa-users"></i> Derniers utilisateurs
                            </div>
                            <div class="card-body">
                                <?php if (empty($derniers_users)): ?>
                                    <p class="text-muted">Aucun utilisateur trouvé.</p>
                                <?php else: ?>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($derniers_users as $u): ?>
                                            <li class="list-group-item">
                                                <strong><?php echo htmlspecialchars($u['username']); ?></strong>
                                                <br><small class="text-muted">ID: <?php echo intval($u['id']); ?> - Rôle: <?php echo htmlspecialchars($u['role']); ?></small>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
