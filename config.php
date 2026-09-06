<?php
$host = '127.0.0.1';
$db   = 'yk_eggs';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("<h2>Database connection failed</h2><p>Make sure MySQL is running in XAMPP and that the <b>yk_eggs</b> database has been imported.</p><p>Error: " . htmlspecialchars($e->getMessage()) . "</p>");
}