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

    public function edit_profile()
{
    $this->checkSalon();
    $pdo = require __DIR__ . '/../config/database.php';
    $salonId = $_SESSION['user']['id'];
    $errors = [];

    // Récupérer les infos actuelles
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
        $contactPhone = trim($_POST['contact_phone'] ?? '');
        $whatsapp = trim($_POST['whatsapp'] ?? '');
        $latitude = trim($_POST['latitude'] ?? '');
        $longitude = trim($_POST['longitude'] ?? '');

        // Photo de profil
        $profilePicture = $salon['profile_picture'] ?? null;
        if (!empty($_FILES['profile_picture']['name'])) {
            $filename = uniqid() . '_' . $_FILES['profile_picture']['name'];
            $target = UPLOADS_PATH . '/' . $filename;

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
                $profilePicture = $filename;
            } else {
                $errors[] = "Erreur lors de l'upload de la photo.";
            }
        }

        if (empty($errors)) {
            $stmt = $pdo->prepare("UPDATE salons SET 
                name = ?, 
                description = ?, 
                category = ?, 
                contact_phone = ?, 
                whatsapp = ?, 
                latitude = ?, 
                longitude = ?, 
                profile_picture = ?
                WHERE id = ?");

            $stmt->execute([
                $name,
                $description,
                $category,
                $contactPhone,
                $whatsapp,
                $latitude,
                $longitude,
                $profilePicture,
                $salonId
            ]);

            $_SESSION['success'] = "Profil mis à jour avec succès.";
            header('Location: ' . ROOT_RELATIVE_PATH . '/salon/dashboard');
            exit;
        }
    }

    require_once __DIR__ . '/../../views/salon/edit_profile.php';
}


}
