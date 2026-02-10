<?php
require_once __DIR__ . '/../config.php';

class Livres {

    public static function getAll() {
        $pdo = Database::getConnection();

       
        $sql = "SELECT id, titre, image, description, date_ajout, lien FROM livres";
        $stmt = $pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
