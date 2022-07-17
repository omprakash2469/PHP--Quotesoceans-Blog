<?php
$host = 'localhost';
$username = "quotes";
$password = 'mysql##user';
$database = "quotedb";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", "$username", "$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    // $error = "Failed Database Connection " . $e->getMessage();
    include 'error/index.php';
    exit();
}
?>