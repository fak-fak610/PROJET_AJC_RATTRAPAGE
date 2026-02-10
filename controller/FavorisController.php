<?php
require_once 'model/mooc.php';

class FavorisController {
    public function index() {
        session_start();
        $pdo = Database::getConnection();

        // Vérifier la connexioon utilisateur
        if (empty($_SESSION['user_id'])) {
            echo '
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Accès aux favoris - Centre AJC</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
                <link rel="stylesheet" href="css/style.css" />
                <link rel="stylesheet" href="css/mes_favoris.css" />
            </head>
            <body>
            <div class="container mt-5">
                <h2 class="mb-4 text-center">Mes MOOC favoris</h2>
                <div class="alert alert-warning text-center">
                    <strong>Vous devez être connecté pour accéder à vos favoris.</strong><br>
                    <a href="connexion.php" class="btn btn-primary btn-sm mt-2">Se connecter</a>
                    <span class="mx-2">ou</span>
                    <a href="inscription.php" class="btn btn-outline-primary btn-sm mt-2">Créer un compte</a>
                </div>
            </div>
            </body>
            </html>';
            exit;
        }

        $user_id = $_SESSION['user_id'];

        // enlever des favoris
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'supprimer_favori') {
            $mooc_id = (int)$_POST['mooc_id']; // cast sécurisé
            Mooc::removeFavori($user_id, $mooc_id);
            $message = "Favori retiré !";
        }

        // liste des favoris
        $favoris = Mooc::getFavoris($user_id);

        include 'view/mes_favoris.php';
    }
}
?>
