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
    $pdo = require __DIR__ . '/../config/database.php';
    $salonId = $_SESSION['user']['id'];

    // Salon
    $stmt = $pdo->prepare("SELECT * FROM salons WHERE id = ?");
    $stmt->execute([$salonId]);
    $salon = $stmt->fetch();

    // Statistiques
    $nbFavoris = $pdo->prepare("SELECT COUNT(*) FROM favoris WHERE salon_id = ?");
    $nbFavoris->execute([$salonId]);
    $nbFavoris = $nbFavoris->fetchColumn();

    $nbRdv = $pdo->prepare("SELECT COUNT(*) FROM rdv WHERE salon_id = ?");
    $nbRdv->execute([$salonId]);
    $nbRdv = $nbRdv->fetchColumn();

    $avgAvis = $pdo->prepare("SELECT AVG(note) FROM avis WHERE salon_id = ?");
    $avgAvis->execute([$salonId]);
    $avgAvis = $avgAvis->fetchColumn() ?: 0;

    // Services
    $stmt = $pdo->prepare("SELECT * FROM services WHERE salon_id = ?");
    $stmt->execute([$salonId]);
    $services = $stmt->fetchAll();

    // Horaires par service
    $horaires = [];
    foreach ($services as $s) {
        $stmt = $pdo->prepare("SELECT * FROM horaires WHERE service_id = ?");
        $stmt->execute([$s['id']]);
        $horaires[$s['id']] = $stmt->fetchAll();
    }

    require_once __DIR__ . '/../../views/salon/dashboard.php';
}

public function horaires($serviceId)
{
    $this->checkSalon();
    $pdo = require __DIR__ . '/../config/database.php';
    $errors = [];

    // Vérifie que le service appartient au salon connecté
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ? AND salon_id = ?");
    $stmt->execute([$serviceId, $_SESSION['user']['id']]);
    $service = $stmt->fetch();

    if (!$service) {
        header('Location: ' . ROOT_RELATIVE_PATH . '/salon/services');
        exit;
    }

    // Si formulaire soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $jours = $_POST['jour'] ?? [];
        $heuresDebut = $_POST['heure_debut'] ?? [];
        $heuresFin = $_POST['heure_fin'] ?? [];

        // Supprimer les anciens horaires
        $pdo->prepare("DELETE FROM horaires WHERE service_id = ?")->execute([$serviceId]);

        // Ajouter les nouveaux
        for ($i = 0; $i < count($jours); $i++) {
            $jour = trim($jours[$i]);
            $debut = trim($heuresDebut[$i]);
            $fin = trim($heuresFin[$i]);

            if ($jour && $debut && $fin) {
                $stmt = $pdo->prepare("INSERT INTO horaires (service_id, jour, heure_debut, heure_fin) VALUES (?, ?, ?, ?)");
                $stmt->execute([$serviceId, $jour, $debut, $fin]);
            }
        }

        $_SESSION['success'] = "Horaires mis à jour.";
        header('Location: ' . ROOT_RELATIVE_PATH . '/salon/services');
        exit;
    }

    // Horaires actuels
    $stmt = $pdo->prepare("SELECT * FROM horaires WHERE service_id = ?");
    $stmt->execute([$serviceId]);
    $horaires = $stmt->fetchAll();

    require_once __DIR__ . '/../../views/salon/horaires.php';
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

    public function services()
{
    $this->checkSalon();
    $pdo = require __DIR__ . '/../config/database.php';
    $salonId = $_SESSION['user']['id'];
    $errors = [];

    // Ajouter un service
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_service') {
        $name = trim($_POST['name']);
        $price = floatval($_POST['price']);
        $duration = intval($_POST['duration']);
        $description = trim($_POST['description']);

        if (!$name || $price <= 0) {
            $errors[] = "Nom et prix requis.";
        }

        if (empty($errors)) {
            $stmt = $pdo->prepare("INSERT INTO services (salon_id, name, price, duration, description) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$salonId, $name, $price, $duration, $description]);
            $_SESSION['success'] = "Service ajouté.";
            header('Location: ' . ROOT_RELATIVE_PATH . '/salon/services');
            exit;
        }
    }

    // Ajouter un horaire à un service
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_horaire') {
        $serviceId = intval($_POST['service_id']);
        $jour = $_POST['jour'];
        $heureDebut = $_POST['heure_debut'];
        $heureFin = $_POST['heure_fin'];

        $stmt = $pdo->prepare("INSERT INTO horaires (service_id, jour, heure_debut, heure_fin) VALUES (?, ?, ?, ?)");
        $stmt->execute([$serviceId, $jour, $heureDebut, $heureFin]);

        $_SESSION['success'] = "Horaire ajouté.";
        header('Location: ' . ROOT_RELATIVE_PATH . '/salon/services');
        exit;
    }

    // Supprimer un horaire
    if (isset($_GET['delete_horaire'])) {
        $horaireId = intval($_GET['delete_horaire']);
        $stmt = $pdo->prepare("DELETE FROM horaires WHERE id = ? AND service_id IN (SELECT id FROM services WHERE salon_id = ?)");
        $stmt->execute([$horaireId, $salonId]);

        $_SESSION['success'] = "Horaire supprimé.";
        header('Location: ' . ROOT_RELATIVE_PATH . '/salon/services');
        exit;
    }

    // Services et horaires
    $stmt = $pdo->prepare("SELECT * FROM services WHERE salon_id = ?");
    $stmt->execute([$salonId]);
    $services = $stmt->fetchAll();

    $horaires = [];
    foreach ($services as $s) {
        $stmt = $pdo->prepare("SELECT * FROM horaires WHERE service_id = ?");
        $stmt->execute([$s['id']]);
        $horaires[$s['id']] = $stmt->fetchAll();
    }

    require_once __DIR__ . '/../../views/salon/services.php';
}

    public function deleteService($id)
    {
        $this->checkSalon();
        $pdo = require __DIR__ . '/../config/database.php';
        $salonId = $_SESSION['user']['id'];

        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ? AND salon_id = ?");
        $stmt->execute([$id, $salonId]);

        $_SESSION['success'] = "Service supprimé.";
        header('Location: ' . ROOT_RELATIVE_PATH . '/salon/services');
        exit;
    }

    public function editService($id)
    {
        $this->checkSalon();
        $pdo = require __DIR__ . '/../config/database.php';
        $salonId = $_SESSION['user']['id'];
        $errors = [];

        $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ? AND salon_id = ?");
        $stmt->execute([$id, $salonId]);
        $service = $stmt->fetch();

        if (!$service) {
            $_SESSION['error'] = "Service introuvable.";
            header('Location: ' . ROOT_RELATIVE_PATH . '/salon/services');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $duration = intval($_POST['duration'] ?? 0);
            $description = trim($_POST['description'] ?? '');

            if (!$name || $price <= 0) {
                $errors[] = "Nom et prix requis.";
            }

            if (empty($errors)) {
                $stmt = $pdo->prepare("UPDATE services SET name = ?, price = ?, duration = ?, description = ? WHERE id = ? AND salon_id = ?");
                $stmt->execute([$name, $price, $duration, $description, $id, $salonId]);

                $_SESSION['success'] = "Service modifié avec succès.";
                header('Location: ' . ROOT_RELATIVE_PATH . '/salon/services');
                exit;
            }
        }

        require_once __DIR__ . '/../../views/salon/services.php';
    }
}
