<?php
// database.php

$host = '127.0.0.1';      // adresse du serveur MySQL
$db   = 'e_barber';       // nom de ta base de données
$user = 'root';           // utilisateur MySQL (par défaut sous XAMPP : root)
$pass = '';               // mot de passe (vide sous XAMPP par défaut)
$charset = 'utf8mb4';     // charset recommandé

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Gestion des erreurs en exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch par défaut en tableau associatif
    PDO::ATTR_EMULATE_PREPARES   => false,                  // pour utiliser les vraies requêtes préparées
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    return $pdo;
} catch (PDOException $e) {
    // En cas d’erreur de connexion, on affiche un message simple (adapter selon besoin)
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
    exit;
}
