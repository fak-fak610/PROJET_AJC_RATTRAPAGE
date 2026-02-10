<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs - Admin</title>
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
                            <a class="nav-link text-white active" href="index.php?page=admin_users">
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
                        <i class="fas fa-users"></i> Gestion des utilisateurs
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <span class="badge bg-info fs-6">
                            <?= count($users) ?> utilisateur(s)
                        </span>
                    </div>
                </div>

                <!-- Messages de succès/erreur -->
                <?php if ($success === 'role_changed'): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> Le rôle a été modifié avec succès !
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php elseif ($success === 'deleted'): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> L'utilisateur a été supprimé !
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php elseif (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php
                        switch ($_GET['error']) {
                            case 'cannot_demote_self':
                                echo "Vous ne pouvez pas vous retirer vos propres droits admin !";
                                break;
                            case 'cannot_delete_self':
                                echo "Vous ne pouvez pas supprimer votre propre compte !";
                                break;
                            case 'change_failed':
                                echo "Erreur lors du changement de rôle.";
                                break;
                            case 'delete_failed':
                                echo "Erreur lors de la suppression.";
                                break;
                            default:
                                echo "Une erreur est survenue.";
                        }
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Statistiques rapides -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-users"></i> Utilisateurs
                                </h5>
                                <h2><?= count(array_filter($users, fn($u) => $u['role'] === 'user')) ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-danger">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-shield-alt"></i> Administrateurs
                                </h5>
                                <h2><?= count(array_filter($users, fn($u) => $u['role'] === 'admin')) ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-user-check"></i> Total
                                </h5>
                                <h2><?= count($users) ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tableau des utilisateurs -->
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <i class="fas fa-list"></i> Liste des utilisateurs
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($users)): ?>
                            <div class="alert alert-info m-3">
                                <i class="fas fa-info-circle"></i> Aucun utilisateur trouvé.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Rôle</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?= $user['id'] ?></td>
                                                <td>
                                                    <strong><?= htmlspecialchars($user['username']) ?></strong>
                                                    <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                                        <span class="badge bg-info">Vous</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($user['email']) ?></td>
                                                <td>
                                                    <?php if ($user['role'] === 'admin'): ?>
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-shield-alt"></i> Admin
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-primary">
                                                            <i class="fas fa-user"></i> User
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <!-- Changer le rôle -->
                                                        <?php if ($user['role'] === 'user'): ?>
                                                            <a href="index.php?page=admin_user_change_role&id=<?= $user['id'] ?>&role=admin" 
                                                               class="btn btn-sm btn-warning"
                                                               onclick="return confirm('Promouvoir <?= htmlspecialchars($user['username']) ?> en admin ?')">
                                                                <i class="fas fa-arrow-up"></i> Promouvoir
                                                            </a>
                                                        <?php else: ?>
                                                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                                <a href="index.php?page=admin_user_change_role&id=<?= $user['id'] ?>&role=user" 
                                                                   class="btn btn-sm btn-secondary"
                                                                   onclick="return confirm('Rétrograder <?= htmlspecialchars($user['username']) ?> en user ?')">
                                                                    <i class="fas fa-arrow-down"></i> Rétrograder
                                                                </a>
                                                            <?php else: ?>
                                                                <button class="btn btn-sm btn-secondary" disabled>
                                                                    <i class="fas fa-lock"></i> Vous
                                                                </button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <!-- Supprimer -->
                                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                            <a href="index.php?page=admin_user_delete&id=<?= $user['id'] ?>" 
                                                               class="btn btn-sm btn-danger"
                                                               onclick="return confirm('Supprimer définitivement <?= htmlspecialchars($user['username']) ?> ?')">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Info box -->
                <div class="alert alert-warning mt-4">
                    <h5><i class="fas fa-info-circle"></i> Informations importantes</h5>
                    <ul class="mb-0">
                        <li>Les <strong>administrateurs</strong> ont accès au panel admin et peuvent gérer MOOCs, livres et utilisateurs.</li>
                        <li>Les <strong>utilisateurs</strong> normaux peuvent consulter le contenu et gérer leurs favoris.</li>
                        <li>Vous ne pouvez pas supprimer votre propre compte ni vous retirer les droits admin.</li>
                        <li>Les nouveaux inscrits sont automatiquement <strong>utilisateurs</strong> (pas admin).</li>
                    </ul>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>