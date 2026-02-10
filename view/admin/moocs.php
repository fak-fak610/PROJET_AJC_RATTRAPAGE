<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des MOOCs - Admin</title>
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
                            <a class="nav-link text-white" href="index.php?page=admin_dashboard">
                                <i class="fas fa-chart-line"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="index.php?page=admin_moocs">
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
                        <i class="fas fa-graduation-cap"></i> Gestion des MOOCs
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="index.php?page=admin_mooc_create" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nouveau MOOC
                        </a>
                    </div>
                </div>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th><i class="fas fa-hashtag"></i> ID</th>
                                        <th><i class="fas fa-heading"></i> Titre</th>
                                        <th><i class="fas fa-calendar"></i> Date</th>
                                        <th><i class="fas fa-cogs"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($moocs)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                                                <br>Aucun MOOC trouvé.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($moocs as $m): ?>
                                            <tr>
                                                <td><?php echo intval($m['id']); ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($m['titre']); ?></strong>
                                                </td>
                                                <td><?php echo htmlspecialchars($m['date']); ?></td>
                                                <td>
                                                    <a href="index.php?page=admin_mooc_edit&id=<?php echo intval($m['id']); ?>" class="btn btn-sm btn-outline-primary me-1">
                                                        <i class="fas fa-edit"></i> Éditer
                                                    </a>
                                                    <a href="index.php?page=admin_mooc_delete&id=<?php echo intval($m['id']); ?>" class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce MOOC ?');">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
