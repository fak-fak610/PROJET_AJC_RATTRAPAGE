<?php
require_once('Database.php');

class Mooc {
    public static function getAll() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM moocs ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM moocs WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($titre, $description, $image) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO moocs (titre, description, image, date) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$titre, $description, $image]);
    }

    public static function update($id, $titre, $description, $image) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE moocs SET titre = ?, description = ?, image = ? WHERE id = ?");
        return $stmt->execute([$titre, $description, $image, $id]);
    }

    public static function delete($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM moocs WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function getFavoris($user_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT moocs.* FROM mooc_favoris JOIN moocs ON mooc_favoris.mooc_id = moocs.id WHERE mooc_favoris.user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addFavori($user_id, $mooc_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO mooc_favoris (user_id, mooc_id) VALUES (?, ?)");
        return $stmt->execute([$user_id, $mooc_id]);
    }

    public static function removeFavori($user_id, $mooc_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM mooc_favoris WHERE user_id = ? AND mooc_id = ?");
        return $stmt->execute([$user_id, $mooc_id]);
    }
}
?>
