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

        require_once __DIR__ . '/../../views/auth/login.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $pdo = require __DIR__ . '/../config/database.php';

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $password === $user['password']) {
                $_SESSION['user'] = $user;

                switch ($user['role']) {
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
            } else {
                $error = "Email ou mot de passe incorrect.";
                require_once __DIR__ . '/../../views/auth/login.php';
            }
        } else {
            require_once __DIR__ . '/../../views/auth/login.php';
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . ROOT_RELATIVE_PATH . '/auth');
        exit;
    }
}
