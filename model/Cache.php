<?php
class Cache {
    private static $pdo;
    private static $tableCreated = false;

    public static function init() {
        self::$pdo = Database::getConnection();
    }

    public static function get($key) {
        if (!self::$pdo) self::init();

        $stmt = self::$pdo->prepare("SELECT data, expires_at FROM cache WHERE cache_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && strtotime($result['expires_at']) > time()) {
            return json_decode($result['data'], true);
        }

        return null;
    }

    public static function set($key, $data, $ttl = 3600) {
        if (!self::$pdo) self::init();

        $expiresAt = date('Y-m-d H:i:s', time() + $ttl);
        $jsonData = json_encode($data);

        $stmt = self::$pdo->prepare("INSERT INTO cache (cache_key, data, expires_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE data = VALUES(data), expires_at = VALUES(expires_at)");
        $stmt->execute([$key, $jsonData, $expiresAt]);
    }

    public static function delete($key) {
        if (!self::$pdo) self::init();

        $stmt = self::$pdo->prepare("DELETE FROM cache WHERE cache_key = ?");
        $stmt->execute([$key]);
    }

    public static function createTableIfNotExists() {
        if (self::$tableCreated) return;

        if (!self::$pdo) self::init();

        $sql = "CREATE TABLE IF NOT EXISTS cache (
            id INT AUTO_INCREMENT PRIMARY KEY,
            cache_key VARCHAR(191) UNIQUE NOT NULL,
            data LONGTEXT NOT NULL,
            expires_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        self::$pdo->exec($sql);
        self::$tableCreated = true;
    }
}
?>
