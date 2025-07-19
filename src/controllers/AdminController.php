<?php

class AdminController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function checkAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'super_admin') {
            header('Location: ' . ROOT_RELATIVE_PATH . '/auth');
            exit;
        }
    }

    public function dashboard()
    {
        $this->checkAdmin();

       require_once __DIR__ . '/../config/database.php';
       $pdo = getPDO();


        $salons = $pdo->query("SELECT COUNT(*) FROM salons")->fetchColumn();
        $clients = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'client'")->fetchColumn();

        require_once dirname(__DIR__, 2) . '/views/admin/dashboard.php';
    }

    public function salons()
    {
        $this->checkAdmin();

        require_once __DIR__ . '/../config/database.php';
        $pdo = getPDO();

        $stmt = $pdo->query("SELECT * FROM salons ORDER BY created_at DESC");
        $salons = $stmt->fetchAll();

        require_once __DIR__ . '/../../views/admin/salons.php';
    }

    public function createSalon()
    {
        $this->checkAdmin();
       require_once __DIR__ . '/../config/database.php';
       $pdo = getPDO();

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $phone = trim($_POST['phone'] ?? '');

            if (!$name) $errors[] = "Le nom est requis";
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";

            if (empty($errors)) {
                $stmt = $pdo->prepare("INSERT INTO salons (name, email, address, phone, created_at) VALUES (?, ?, ?, ?, NOW())");
                $stmt->execute([$name, $email, $address, $phone]);
                header('Location: ' . ROOT_RELATIVE_PATH . '/admin/salons');
                exit;
            }
        }

        require_once __DIR__ . '/../../views/admin/salons_form.php';
    }

    public function editSalon($id)
    {
        $this->checkAdmin();
        $pdo = require __DIR__ . '/../config/database.php';
        $errors = [];

        $stmt = $pdo->prepare("SELECT * FROM salons WHERE id = ?");
        $stmt->execute([$id]);
        $salon = $stmt->fetch();

        if (!$salon) {
            header('Location: ' . ROOT_RELATIVE_PATH . '/admin/salons');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $phone = trim($_POST['phone'] ?? '');

            if (!$name) $errors[] = "Le nom est requis";
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";

            if (empty($errors)) {
                $stmt = $pdo->prepare("UPDATE salons SET name = ?, email = ?, address = ?, phone = ? WHERE id = ?");
                $stmt->execute([$name, $email, $address, $phone, $id]);
                header('Location: ' . ROOT_RELATIVE_PATH . '/admin/salons');
                exit;
            }
        }

        require_once __DIR__ . '/../../views/admin/salons_form.php';
    }

    public function deleteSalon($id)
    {
        $this->checkAdmin();
        $pdo = require __DIR__ . '/../config/database.php';

        $stmt = $pdo->prepare("DELETE FROM salons WHERE id = ?");
        $stmt->execute([$id]);

        header('Location: ' . ROOT_RELATIVE_PATH . '/admin/salons');
        exit;
    }

    public function block_salon($id)
    {
        $this->checkAdmin();
        $pdo = require __DIR__ . '/../config/database.php';

        $stmt = $pdo->prepare("UPDATE salons SET status = 'blocked' WHERE id = ?");
        $stmt->execute([$id]);

        header('Location: ' . ROOT_RELATIVE_PATH . '/admin/salons');
        exit;
    }

    public function unblock_salon($id)
    {
        $this->checkAdmin();
        $pdo = require __DIR__ . '/../config/database.php';

        $stmt = $pdo->prepare("UPDATE salons SET status = 'active' WHERE id = ?");
        $stmt->execute([$id]);

        header('Location: ' . ROOT_RELATIVE_PATH . '/admin/salons');
        exit;
    }

    public function clients()
    {
        $this->checkAdmin();

        require_once __DIR__ . '/../config/database.php';
        $pdo = getPDO();

        $stmt = $pdo->query("SELECT * FROM users WHERE role = 'client' ORDER BY created_at DESC");
        $clients = $stmt->fetchAll();

        require_once __DIR__ . '/../../views/admin/clients.php';
    }

    public function createClient()
    {
        $this->checkAdmin();
        $pdo = require __DIR__ . '/../config/database.php';
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!$name) $errors[] = "Le nom est requis";
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
            if (!$password) $errors[] = "Le mot de passe est requis";

            if (empty($errors)) {
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, 'client', NOW())");
                $stmt->execute([$name, $email, $password]);
                header('Location: ' . ROOT_RELATIVE_PATH . '/admin/clients');
                exit;
            }
        }

        require_once __DIR__ . '/../../views/admin/clients_form.php';
    }

    public function suspend_client($id)
    {
        $this->checkAdmin();
        $pdo = require __DIR__ . '/../config/database.php';
        $stmt = $pdo->prepare("UPDATE users SET status = 'suspended' WHERE id = ? AND role = 'client'");
        $stmt->execute([$id]);
        header('Location: ' . ROOT_RELATIVE_PATH . '/admin/clients');
        exit;
    }

    public function unsuspend_client($id)
    {
        $this->checkAdmin();
        $pdo = require __DIR__ . '/../config/database.php';
        $stmt = $pdo->prepare("UPDATE users SET status = 'active' WHERE id = ? AND role = 'client'");
        $stmt->execute([$id]);
        header('Location: ' . ROOT_RELATIVE_PATH . '/admin/clients');
        exit;
    }

    public function deleteClient($id)
    {
        $this->checkAdmin();
        $pdo = require __DIR__ . '/../config/database.php';

        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'client'");
        $stmt->execute([$id]);

        header('Location: ' . ROOT_RELATIVE_PATH . '/admin/clients');
        exit;
    }

    public function rdv()
    {
        $this->checkAdmin();

        require_once __DIR__ . '/../config/database.php';
        $pdo = getPDO();

        $stmt = $pdo->query("SELECT rdv.*, users.name as client_name, salons.name as salon_name 
                     FROM rdv
                     JOIN users ON rdv.user_id = users.id
                     JOIN salons ON rdv.salon_id = salons.id
                     ORDER BY rdv.date DESC");

        $rdvs = $stmt->fetchAll();

        require_once __DIR__ . '/../../views/admin/rdv.php';
    }
}
