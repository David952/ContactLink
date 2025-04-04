<?php

// Charge les variables d'environnement depuis le fichier .env
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Récupère les identifiants de la base de données depuis les variables d'environnement
$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$dbName = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbName", $user, $password);

    // Défini le mode d'erreur PDO sur exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS contacts (
        id SERIAL PRIMARY KEY,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        phone TEXT,
        image TEXT
    );");
    
    return $pdo;

} catch (PDOException $e) {
    // Gère les erreurs de connexion
    echo "Connection failed: " . $e->getMessage();
    return null;
}