<?php
class UploadHelper {

    public static function uploadImage($file, $destination) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $maxSize = 5 * 1024 * 1024;
        
        return self::uploadFile($file, $destination, $allowedExtensions, $maxSize);
    }
    
    public static function uploadVideo($file, $destination) {
        $allowedExtensions = ['mp4', 'avi', 'mov', 'webm', 'mkv'];
        $maxSize = 100 * 1024 * 1024;

        return self::uploadFile($file, $destination, $allowedExtensions, $maxSize);
    }

    public static function uploadAudio($file, $destination) {
        $allowedExtensions = ['mp3', 'wav', 'ogg', 'aac', 'm4a'];
        $maxSize = 50 * 1024 * 1024;

        return self::uploadFile($file, $destination, $allowedExtensions, $maxSize);
    }

    public static function uploadFile($file, $destination, $allowedExtensions, $maxSize) {
        return self::uploadFilePrivate($file, $destination, $allowedExtensions, $maxSize);
    }

    public static function uploadGenericFile($file, $destination, $allowedExtensions, $maxSize) {
        return self::uploadFilePrivate($file, $destination, $allowedExtensions, $maxSize);
    }

    private static function uploadFilePrivate($file, $destination, $allowedExtensions, $maxSize) {
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return false;
        }
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erreur lors de l'upload du fichier (code: {$file['error']})");
        }
        
        if ($file['size'] > $maxSize) {
            $maxSizeMB = $maxSize / (1024 * 1024);
            throw new Exception("Le fichier est trop volumineux (max {$maxSizeMB} Mo)");
        }
        
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new Exception("Extension non autorisée. Formats acceptés : " . implode(', ', $allowedExtensions));
        }
        
        $uploadDir = "../uploads/{$destination}/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $newFileName = time() . '_' . uniqid() . '.' . $fileExtension;
        $filePath = $uploadDir . $newFileName;
        
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception("Erreur lors du déplacement du fichier");
        }
        
        return "uploads/{$destination}/" . $newFileName;
    }
    
    public static function deleteFile($filePath) {
        $fullPath = "../{$filePath}";
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        return false;
    }
    
    public static function isExternalUrl($path) {
        return filter_var($path, FILTER_VALIDATE_URL) !== false;
    }
}
?>
