<?php
// データベース接続情報一覧
$dbServer = isset($_ENV['MYSQL_SERVER'])    ? $_ENV['MYSQL_SERVER']      : '127.0.0.1';
$dbUser   = isset($_SERVER['MYSQL_USER'])   ? $_SERVER['MYSQL_USER']     : 'root';
$dbPass   = isset($_SERVER['MYSQL_PASSWORD']) ? $_SERVER['MYSQL_PASSWORD'] : '';
$dbName   = isset($_SERVER['MYSQL_DB'])     ? $_SERVER['MYSQL_DB']       : 'mydb';

// DSN文字列
$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";

try {
    $db = new PDO($dsn, $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベース接続エラー: " . htmlspecialchars($e->getMessage()));
}
?>