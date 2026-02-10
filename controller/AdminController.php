e<?php
require_once '../model/Database.php';
require_once '../model/Cache.php';
require_once 'UploadHelper.php';

class AdminController {
    
    private function checkAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: index.php?page=connexion');
            exit;
        }
    }
    
    
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin') {
            header('Location: index.php?page=admin_dashboard');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = ? OR email = ?");
                $stmt->execute([$username, $username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    // Vérifier si c'est un admin
                    if ($user['role'] !== 'admin') {
                        $error = "Accès refusé : vous n'avez pas les droits administrateur";
                    } else {
                        // Connexion réussie
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['user_role'] = $user['role'];
                        header('Location: index.php?page=admin_dashboard');
                        exit;
                    }
                } else {
                    $error = "Identifiants incorrects - Vérifiez votre nom d'utilisateur et mot de passe";
                }
            } catch (PDOException $e) {
                $error = "Erreur de connexion : " . $e->getMessage();
            }
        }

        require_once '../view/admin/login.php';
    }
    
    public function dashboard() {
        $this->checkAdmin();
        
        try {
            $pdo = Database::getConnection();
            
            // Statistiques
            $stats = [
                'moocs' => $pdo->query("SELECT COUNT(*) FROM moocs")->fetchColumn(),
                'livres' => $pdo->query("SELECT COUNT(*) FROM livres")->fetchColumn(),
                'users' => $pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE role = 'user'")->fetchColumn(),
                'admins' => $pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE role = 'admin'")->fetchColumn(),
                'documents' => $pdo->query("SELECT COUNT(*) FROM documents_user")->fetchColumn(),
            ];
            
            // Derniers ajouts
            $derniers_moocs = $pdo->query("SELECT titre, date FROM moocs ORDER BY date DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
            $derniers_users = $pdo->query("SELECT username, id, role FROM utilisateurs ORDER BY id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $stats = ['moocs' => 0, 'livres' => 0, 'users' => 0, 'admins' => 0, 'documents' => 0];
            $derniers_moocs = [];
            $derniers_users = [];
        }
        
        require_once '../view/admin/dashboard.php';
    }
    
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['user_role']);
        session_destroy();
        header('Location: index.php?page=connexion');
        exit;
    }
    
    
    public function users() {
        $this->checkAdmin();

        $success = $_GET['success'] ?? '';

        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->query("SELECT id, username, email, role FROM utilisateurs ORDER BY id DESC");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $users = [];
            $error = $e->getMessage();
        }

        require_once '../view/admin/users.php';
    }
    
    public function userChangeRole() {
        $this->checkAdmin();
        
        $userId = $_GET['id'] ?? 0;
        $newRole = $_GET['role'] ?? '';
        
        if ($userId && in_array($newRole, ['user', 'admin'])) {
            try {
                $pdo = Database::getConnection();
                
                if ($userId == $_SESSION['user_id'] && $newRole == 'user') {
                    header('Location: index.php?page=admin_users&error=cannot_demote_self');
                    exit;
                }
                
                $stmt = $pdo->prepare("UPDATE utilisateurs SET role = ? WHERE id = ?");
                $stmt->execute([$newRole, $userId]);
                
                header('Location: index.php?page=admin_users&success=role_changed');
            } catch (PDOException $e) {
                header('Location: index.php?page=admin_users&error=change_failed');
            }
        } else {
            header('Location: index.php?page=admin_users&error=invalid_params');
        }
        exit;
    }
    
    public function userDelete() {
        $this->checkAdmin();
        
        $userId = $_GET['id'] ?? 0;
        
        if ($userId == $_SESSION['user_id']) {
            header('Location: index.php?page=admin_users&error=cannot_delete_self');
            exit;
        }
        
        try {
            $pdo = Database::getConnection();
            
            $stmt = $pdo->prepare("DELETE FROM mooc_favoris WHERE user_id = ?");
            $stmt->execute([$userId]);
            
            $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
            $stmt->execute([$userId]);
            
            header('Location: index.php?page=admin_users&success=deleted');
        } catch (PDOException $e) {
            header('Location: index.php?page=admin_users&error=delete_failed');
        }
        exit;
    }
    
    
    public function moocs() {
        $this->checkAdmin();

        $success = $_GET['success'] ?? '';

        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->query("SELECT id, titre, date FROM moocs ORDER BY id DESC");
            $moocs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $moocs = [];
            $error = $e->getMessage();
        }

        require_once '../view/admin/moocs.php';
    }
    
    public function moocCreate() {
        $this->checkAdmin();
        
        $message = '';
        $type = '';
        $isEdit = false;
        $mooc = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $pdo = Database::getConnection();
                
                // Gestion de l'image
                $imagePath = $_POST['image_url'] ?? '';
                if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $imagePath = UploadHelper::uploadImage($_FILES['image_file'], 'moocs/images');
                }
                
                // Gestion de la vidéo
                $videoPath = $_POST['video_url'] ?? '';
                if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $videoPath = UploadHelper::uploadVideo($_FILES['video_file'], 'moocs/videos');
                }
                
                $stmt = $pdo->prepare("INSERT INTO moocs (titre, description, image, duree, effort, rythme, video, quizz) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $_POST['titre'],
                    $_POST['description'],
                    $imagePath,
                    $_POST['duree'],
                    $_POST['effort'],
                    $_POST['rythme'],
                    $videoPath,
                    $_POST['quizz'] ?? ''
                ]);

                // Update cache for recent moocs
                $recentMoocs = $pdo->query('SELECT id, titre, description, image FROM moocs ORDER BY id DESC LIMIT 6')->fetchAll(PDO::FETCH_ASSOC);
                Cache::set('moocs_recent', $recentMoocs, 3600);

                header('Location: index.php?page=admin_moocs&success=created');
                exit;
            } catch (Exception $e) {
                $message = "Erreur : " . $e->getMessage();
                $type = "danger";
            }
        }
        
        require_once '../view/admin/mooc_form.php';
    }
    
    public function moocEdit() {
        $this->checkAdmin();
        
        $id = $_GET['id'] ?? 0;
        $message = '';
        $type = '';
        $isEdit = true;
        
        try {
            $pdo = Database::getConnection();
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $stmt = $pdo->prepare("SELECT image, video FROM moocs WHERE id = ?");
                $stmt->execute([$id]);
                $oldMooc = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $imagePath = $_POST['image_url'] ?? $oldMooc['image'];
                if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                    if ($oldMooc['image'] && !UploadHelper::isExternalUrl($oldMooc['image'])) {
                        UploadHelper::deleteFile($oldMooc['image']);
                    }
                    $imagePath = UploadHelper::uploadImage($_FILES['image_file'], 'moocs/images');
                }
                
                $videoPath = $_POST['video_url'] ?? $oldMooc['video'];
                if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                    if ($oldMooc['video'] && !UploadHelper::isExternalUrl($oldMooc['video'])) {
                        UploadHelper::deleteFile($oldMooc['video']);
                    }
                    $videoPath = UploadHelper::uploadVideo($_FILES['video_file'], 'moocs/videos');
                }
                
                $stmt = $pdo->prepare("UPDATE moocs SET titre=?, description=?, image=?, duree=?, effort=?, rythme=?, video=?, quizz=? WHERE id=?");
                $stmt->execute([
                    $_POST['titre'],
                    $_POST['description'],
                    $imagePath,
                    $_POST['duree'],
                    $_POST['effort'],
                    $_POST['rythme'],
                    $videoPath,
                    $_POST['quizz'] ?? '',
                    $id
                ]);

                // Update cache for recent moocs
                $recentMoocs = $pdo->query('SELECT id, titre, description, image FROM moocs ORDER BY id DESC LIMIT 6')->fetchAll(PDO::FETCH_ASSOC);
                Cache::set('moocs_recent', $recentMoocs, 3600);

                header('Location: index.php?page=admin_moocs&success=updated');
                exit;
            }
            
            $stmt = $pdo->prepare("SELECT * FROM moocs WHERE id = ?");
            $stmt->execute([$id]);
            $mooc = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$mooc) {
                header('Location: index.php?page=admin_moocs');
                exit;
            }
            
        } catch (Exception $e) {
            $message = "Erreur : " . $e->getMessage();
            $type = "danger";
        }
        
        require_once '../view/admin/mooc_form.php';
    }
    
    public function moocDelete() {
        $this->checkAdmin();
        
        $id = $_GET['id'] ?? 0;
        
        try {
            $pdo = Database::getConnection();
            
            $stmt = $pdo->prepare("SELECT image, video FROM moocs WHERE id = ?");
            $stmt->execute([$id]);
            $mooc = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($mooc['image'] && !UploadHelper::isExternalUrl($mooc['image'])) {
                UploadHelper::deleteFile($mooc['image']);
            }
            if ($mooc['video'] && !UploadHelper::isExternalUrl($mooc['video'])) {
                UploadHelper::deleteFile($mooc['video']);
            }
            
            $stmt = $pdo->prepare("DELETE FROM mooc_favoris WHERE mooc_id = ?");
            $stmt->execute([$id]);

            $stmt = $pdo->prepare("DELETE FROM moocs WHERE id = ?");
            $stmt->execute([$id]);

            // Update cache for recent moocs
            $recentMoocs = $pdo->query('SELECT id, titre, description, image FROM moocs ORDER BY id DESC LIMIT 6')->fetchAll(PDO::FETCH_ASSOC);
            Cache::set('moocs_recent', $recentMoocs, 3600);

            header('Location: index.php?page=admin_moocs&success=deleted');
        } catch (PDOException $e) {
            header('Location: index.php?page=admin_moocs&error=delete_failed');
        }
        exit;
    }
    
    
    public function livres() {
        $this->checkAdmin();

        $success = $_GET['success'] ?? '';

        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->query("SELECT id, titre, auteur, date_ajout FROM livres ORDER BY id DESC");
            $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $livres = [];
            $error = $e->getMessage();
        }

        require_once '../view/admin/livres.php';
    }
    
    public function livreCreate() {
        $this->checkAdmin();
        
        $message = '';
        $type = '';
        $isEdit = false;
        $livre = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $pdo = Database::getConnection();
                
                $imagePath = $_POST['image_url'] ?? '';
                if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $imagePath = UploadHelper::uploadImage($_FILES['image_file'], 'livres/images');
                }
                
                $fichierPath = '';
                if (isset($_FILES['fichier_file']) && $_FILES['fichier_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $fichierPath = UploadHelper::uploadFile($_FILES['fichier_file'], 'livres/files', ['pdf', 'epub'], 20 * 1024 * 1024);
                }
                
                $stmt = $pdo->prepare("INSERT INTO livres (titre, auteur, image, fichier, description) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([
                    $_POST['titre'],
                    $_POST['auteur'] ?? '',
                    $imagePath,
                    $fichierPath,
                    $_POST['description']
                ]);
                
                header('Location: index.php?page=admin_livres&success=created');
                exit;
            } catch (Exception $e) {
                $message = "Erreur : " . $e->getMessage();
                $type = "danger";
            }
        }
        
        require_once '../view/admin/livre_form.php';
    }
    
    public function livreEdit() {
        $this->checkAdmin();
        
        $id = $_GET['id'] ?? 0;
        $message = '';
        $type = '';
        $isEdit = true;
        
        try {
            $pdo = Database::getConnection();
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $stmt = $pdo->prepare("SELECT image, fichier FROM livres WHERE id = ?");
                $stmt->execute([$id]);
                $oldLivre = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $imagePath = $_POST['image_url'] ?? $oldLivre['image'];
                if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                    if ($oldLivre['image'] && !UploadHelper::isExternalUrl($oldLivre['image'])) {
                        UploadHelper::deleteFile($oldLivre['image']);
                    }
                    $imagePath = UploadHelper::uploadImage($_FILES['image_file'], 'livres/images');
                }
                
                $fichierPath = $oldLivre['fichier'] ?? '';
                if (isset($_FILES['fichier_file']) && $_FILES['fichier_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                    if ($oldLivre['fichier']) {
                        UploadHelper::deleteFile($oldLivre['fichier']);
                    }
                    $fichierPath = UploadHelper::uploadFile($_FILES['fichier_file'], 'livres/files', ['pdf', 'epub'], 20 * 1024 * 1024);
                }
                
                $stmt = $pdo->prepare("UPDATE livres SET titre=?, auteur=?, image=?, fichier=?, description=? WHERE id=?");
                $stmt->execute([
                    $_POST['titre'],
                    $_POST['auteur'] ?? '',
                    $imagePath,
                    $fichierPath,
                    $_POST['description'],
                    $id
                ]);
                
                header('Location: index.php?page=admin_livres&success=updated');
                exit;
            }
            
            $stmt = $pdo->prepare("SELECT * FROM livres WHERE id = ?");
            $stmt->execute([$id]);
            $livre = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$livre) {
                header('Location: index.php?page=admin_livres');
                exit;
            }
            
        } catch (Exception $e) {
            $message = "Erreur : " . $e->getMessage();
            $type = "danger";
        }
        
        require_once '../view/admin/livre_form.php';
    }
    
    public function livreDelete() {
        $this->checkAdmin();
        
        $id = $_GET['id'] ?? 0;
        
        try {
            $pdo = Database::getConnection();
            
            // récupérer les fichiers
            $stmt = $pdo->prepare("SELECT image, fichier FROM livres WHERE id = ?");
            $stmt->execute([$id]);
            $livre = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // supprimer les fichiers
            if ($livre['image'] && !UploadHelper::isExternalUrl($livre['image'])) {
                UploadHelper::deleteFile($livre['image']);
            }
            if ($livre['fichier']) {
                UploadHelper::deleteFile($livre['fichier']);
            }
            
            // supprimer le livre
            $stmt = $pdo->prepare("DELETE FROM livres WHERE id = ?");
            $stmt->execute([$id]);
            
            header('Location: index.php?page=admin_livres&success=deleted');
        } catch (PDOException $e) {
            header('Location: index.php?page=admin_livres&error=delete_failed');
        }
        exit;
    }
}
?>
