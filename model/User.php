<?php
require_once('Database.php');

class User {
    public static function getById($id) {
        $pdo = Database::getConnection();
       $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");   
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getByUsername($username) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getByEmail($email) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($username, $email, $password) {
        $pdo = Database::getConnection();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (username, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $email, $hashedPassword]);
    }

    public static function update($id, $username, $email) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE utilisateurs SET username = ?, email = ? WHERE id = ?");
        return $stmt->execute([$username, $email, $id]);
    }

    public static function updatePassword($id, $password) {
        $pdo = Database::getConnection();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
        return $stmt->execute([$hashedPassword, $id]);
    }

    public static function updateLastUpload($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE utilisateurs SET last_upload = NOW() WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

    public static function login($login, $password) {
        $user = self::getByUsername($login);
        if (!$user) {
            $user = self::getByEmail($login);
        }
        if ($user && self::verifyPassword($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
?>
