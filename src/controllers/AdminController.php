<?php

class AdminController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function dashboard()
    {
        // Vérification de la session et du rôle
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'super_admin') {
            header('Location: ' . ROOT_RELATIVE_PATH . '/auth');
            exit;
        }

        // Connexion à la base de données
        $pdo = require __DIR__ . '/../config/database.php';

        // Récupérer les données à afficher
        $salons = $pdo->query("SELECT COUNT(*) FROM salons")->fetchColumn();
        $clients = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'client'")->fetchColumn();

        // Chargement de la vue dashboard
        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }
}
