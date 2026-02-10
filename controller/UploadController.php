<?php
require_once __DIR__ . '/../config.php';

class UploadController {
    
    public function index() {
        $this->upload();
    }

    public function upload() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $message = '';
        $type = '';

        if (!isset($_SESSION['user_id'])) {
            $message = "Vous devez être connecté pour uploader un document.";
            $type = "danger";
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
                $file = $_FILES['document'];
                $userId = $_SESSION['user_id'];
                
                $allowedExtensions = ['pdf', 'doc', 'docx', 'pptx', 'txt', 'odt', 'xlsx'];
                $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $message = "Erreur lors de l'upload du fichier.";
                    $type = "danger";
                } elseif (!in_array($fileExtension, $allowedExtensions)) {
                    $message = "Extension non autorisée. Formats acceptés : " . implode(', ', $allowedExtensions);
                    $type = "danger";
                } elseif ($file['size'] > 10 * 1024 * 1024) { 
                    $message = "Le fichier est trop volumineux (max 10 Mo).";
                    $type = "danger";
                } else {
                    $uploadDir = '../documents_biblio/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $newFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file['name']);
                    $destination = $uploadDir . $newFileName;
                    
                    if (move_uploaded_file($file['tmp_name'], $destination)) {
                        try {
                            $pdo = Database::getConnection();
                            $stmt = $pdo->prepare("INSERT INTO documents_user (nom, chemin, upload_time) VALUES (?, ?, NOW())");
                            $stmt->execute([$file['name'], $destination]);
                            
                            $message = "Document uploadé avec succès !";
                            $type = "success";
                        } catch (PDOException $e) {
                            $message = "Erreur lors de l'enregistrement en base de données : " . $e->getMessage();
                            $type = "danger";
                        }
                    } else {
                        $message = "Erreur lors du déplacement du fichier.";
                        $type = "danger";
                    }
                }
            }
        }

        // prend les derniers documents 
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->query("SELECT * FROM documents_user ORDER BY upload_time DESC");
            $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $documents = [];
            if (empty($message)) {
                $message = "Erreur lors de la récupération des documents : " . $e->getMessage();
                $type = "danger";
            }
        }

        require_once '../view/upload_view.php';
    }
}
?>
