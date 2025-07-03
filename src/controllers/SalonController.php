<?php

class SalonController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function checkSalon()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'salon') {
            header('Location: ' . ROOT_RELATIVE_PATH . '/auth');
            exit;
        }
    }

    public function dashboard()
    {
        $this->checkSalon();
        $salonId = $_SESSION['user']['id'];
        $pdo = require __DIR__ . '/../config/database.php';

        $stmt = $pdo->prepare("SELECT * FROM salons WHERE id = ?");
        $stmt->execute([$salonId]);
        $salon = $stmt->fetch();

        require_once __DIR__ . '/../../views/salon/dashboard.php';
    }

    public function editProfile()
    {
        $this->checkSalon();
        $pdo = require __DIR__ . '/../config/database.php';
        $salonId = $_SESSION['user']['id'];
        $errors = [];

        $stmt = $pdo->prepare("SELECT * FROM salons WHERE id = ?");
        $stmt->execute([$salonId]);
        $salon = $stmt->fetch();

        if (!$salon) {
            header('Location: ' . ROOT_RELATIVE_PATH . '/salon/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $latitude = trim($_POST['latitude'] ?? '');
            $longitude = trim($_POST['longitude'] ?? '');

            // Photo de profil
            if (!empty($_FILES['profile_photo']['name'])) {
                $profilePhotoName = uniqid() . '_' . $_FILES['profile_photo']['name'];
                $targetPath = UPLOADS_PATH . '/' . $profilePhotoName;

                if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetPath)) {
                    $salon['profile_photo'] = $profilePhotoName;
                } else {
                    $errors[] = "Erreur lors de l'upload de la photo.";
                }
            }

            if (empty($errors)) {
                $stmt = $pdo->prepare("UPDATE salons SET name = ?, description = ?, category = ?, address = ?, latitude = ?, longitude = ?, profile_photo = ? WHERE id = ?");
                $stmt->execute([
                    $name,
                    $description,
                    $category,
                    $address,
                    $latitude,
                    $longitude,
                    $salon['profile_photo'] ?? null,
                    $salonId
                ]);

                header('Location: ' . ROOT_RELATIVE_PATH . '/salon/dashboard');
                exit;
            }
        }

        require_once __DIR__ . '/../../views/salon/edit_profile.php';
    }
}
