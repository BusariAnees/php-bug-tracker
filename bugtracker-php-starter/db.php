
<?php
require_once __DIR__.'/config.php';

function db() {
    static $pdo;
    if (!$pdo) {
        $dsn = 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            if (APP_DEBUG) {
                die('DB connection failed: '.$e->getMessage());
            } else {
                die('Database connection error.');
            }
        }
    }
    return $pdo;
}
