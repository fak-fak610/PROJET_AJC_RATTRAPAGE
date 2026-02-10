<?php
require_once __DIR__ . '/../config.php';

class Article {
    public static function getAll() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM actualites ORDER BY date_evt DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM actualites WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($titre, $date_evt, $texte) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO actualites (titre, date_evt, texte) VALUES (?, ?, ?)");
        return $stmt->execute([$titre, $date_evt, $texte]);
    }

    public static function update($id, $titre, $date_evt, $texte) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE actualites SET titre = ?, date_evt = ?, texte = ? WHERE id = ?");
        return $stmt->execute([$titre, $date_evt, $texte, $id]);
    }

    public static function delete($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM actualites WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
