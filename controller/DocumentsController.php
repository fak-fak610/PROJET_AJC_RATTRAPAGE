<?php
require_once 'model/Database.php';

class DocumentsController {
    public function index() {
        session_start();

        $_SESSION['user_id'] = 1; 
        $userId = $_SESSION['user_id'];

        
        $pdo = Database::getConnection();

        // Dossier d’upload
        $dir = 'documents_biblio/';
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        // --- Nettoyage automatique des fichiers > 24h ---
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach($files as $file){
            $filePath = $dir.$file;
            if(is_file($filePath) && (time() - filemtime($filePath)) > 24*3600){
                unlink($filePath);
            }
        }

        $uploadMessage = '';
        $maxFileSize = 5 * 1024 * 1024;
        $allowedExt = ['pdf','doc','docx','ppt','pptx','txt','odt','xlsx'];
        $allowedMimes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'text/plain',
            'application/vnd.oasis.opendocument.text',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
        $blacklist = ['exe','bat','sh','php','js'];

        $stmt = $pdo->prepare("SELECT last_upload FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['doc'])) {
            if ($user && $user['last_upload'] && (time() - strtotime($user['last_upload'])) < (7 * 24 * 3600)) {
                $uploadMessage = "⚠️ Vous avez déjà uploadé un fichier cette semaine. Réessayez après 7 jours.";
            } else {
                $name = basename($_FILES['doc']['name']);
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $tmp = $_FILES['doc']['tmp_name'];

                if(!in_array($ext, $allowedExt)){
                    $uploadMessage = "⚠️ Format non autorisé : .$ext";
                } elseif(in_array($ext, $blacklist)){
                    $uploadMessage = "⚠️ Fichier interdit pour des raisons de sécurité";
                } elseif(!in_array(finfo_file(finfo_open(FILEINFO_MIME_TYPE), $tmp), $allowedMimes)){
                    $uploadMessage = "⚠️ Type de fichier non autorisé";
                } elseif($_FILES['doc']['size'] > $maxFileSize){
                    $uploadMessage = "⚠️ Fichier trop volumineux (>5 Mo).";
                } elseif(is_uploaded_file($tmp)){
                    $newName = time() . '_' . $name;
                    if(move_uploaded_file($tmp, $dir . $newName)){
                        $stmt = $pdo->prepare("UPDATE users SET last_upload = NOW() WHERE id = ?");
                        $stmt->execute([$userId]);
                        $uploadMessage = "✅ Fichier uploadé avec succès : $newName";
                    } else {
                        $uploadMessage = "⚠️ Erreur lors de l'upload.";
                    }
                } else {
                    $uploadMessage = "⚠️ Erreur lors de l'upload.";
                }
            }
        }

        $files = array_diff(scandir($dir, SCANDIR_SORT_DESCENDING), ['.', '..']);

        include 'view/documents_view.php';
    }
}
?>
