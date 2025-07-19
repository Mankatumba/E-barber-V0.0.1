<?php

class AuthController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        if (isset($_SESSION['user'])) {
            $role = $_SESSION['user']['role'];
            switch ($role) {
                case 'super_admin':
                    header('Location: ' . ROOT_RELATIVE_PATH . '/admin/dashboard');
                    break;
                case 'salon':
                    header('Location: ' . ROOT_RELATIVE_PATH . '/salon/dashboard');
                    break;
                case 'client':
                    header('Location: ' . ROOT_RELATIVE_PATH . '/client/dashboard');
                    break;
                default:
                    session_destroy();
                    header('Location: ' . ROOT_RELATIVE_PATH . '/auth?error=unknown_role');
            }
            exit;
        }

       require_once dirname(__DIR__, 2) . '/views/auth/login.php';

    }

public function registerClient()
{
    $pdo = require __DIR__ . '/../config/database.php';
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (!$name || !$email || !$password) {
            $errors[] = "Tous les champs sont obligatoires.";
        }

        // Vérifier si l'email est déjà utilisé
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Cet email est déjà utilisé.";
        }

        if (empty($errors)) {
            // Enregistrer le client avec mot de passe en clair comme tu l’utilises
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'client')");
            $stmt->execute([$name, $email, $password]);

            $_SESSION['success'] = "Compte client créé avec succès. Vous pouvez vous connecter.";
            header('Location: ' . ROOT_RELATIVE_PATH . '/auth');
            exit;
        }
    }

    require_once __DIR__ . '/../../views/auth/register_client.php';
}


public function login()
{
    require_once __DIR__ . '/../config/database.php';
    $pdo = getPDO();

    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // 1. Vérification dans la table users (clients et super admin)
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?"); #ligne 84
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && $user['password'] === $password) {
            // Vérification de statut si colonne 'status' existe
            if (isset($user['status']) && $user['status'] === 'blocked') {
                $error = "Votre compte a été bloqué.";
            } else {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'role' => $user['role'],
                ];
                if ($user['role'] === 'super_admin') {
                    header('Location: ' . ROOT_RELATIVE_PATH . '/admin/dashboard');
                } else {
                    header('Location: ' . ROOT_RELATIVE_PATH . '/client/dashboard'); // à adapter
                }
                exit;
            }
        }

        // 2. Vérification dans la table salons
        $stmt = $pdo->prepare("SELECT * FROM salons WHERE email = ?");
        $stmt->execute([$email]);
        $salon = $stmt->fetch();

        if ($salon && $salon['password'] === $password) {
            if (isset($salon['status']) && $salon['status'] === 'blocked') {
                $error = "Ce salon est actuellement bloqué.";
            } else {
                $_SESSION['user'] = [
                    'id' => $salon['id'],
                    'name' => $salon['name'],
                    'role' => 'salon',
                ];
                header('Location: ' . ROOT_RELATIVE_PATH . '/salon/dashboard');
                exit;
            }
        }

        // Si aucun utilisateur trouvé
        if (!$error) {
            $error = "Email ou mot de passe invalide.";
        }
    }

    // On transmet $error à la vue
    require_once __DIR__ . '/../../views/auth/login.php';
}

public function registerSalon()
{
    $pdo = require __DIR__ . '/../config/database.php';
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $category = $_POST['category'] ?? 'mixte';

        if (!$name) $errors[] = "Le nom est requis";
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
        if (!$password) $errors[] = "Mot de passe requis";

        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO salons (name, email, password, category, created_at) VALUES (?, ?, ?, ?, NOW())");
                $stmt->execute([$name, $email, $password, $category]);
                header('Location: ' . ROOT_RELATIVE_PATH . '/auth?registered=1');
                exit;
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $errors[] = "Cet email est déjà utilisé.";
                } else {
                    throw $e;
                }
            }
        }
    }

    require_once __DIR__ . '/../../views/auth/register_salon.php';
}

    public function logout()
    {
        session_destroy();
        header('Location: ' . ROOT_RELATIVE_PATH . '/auth');
        exit;
    }
}