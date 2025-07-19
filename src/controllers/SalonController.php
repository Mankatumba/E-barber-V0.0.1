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

    // Assure que la session contient bien les données utilisateur
    if (!isset($_SESSION['user']['id'])) {
        die('Salon non authentifié.');
    }

    $salonId = $_SESSION['user']['id'];

    // Connexion à la base de données
    require_once __DIR__ . '/../config/database.php';
    $pdo = getPDO();

    // Infos du salon
    $stmt = $pdo->prepare("SELECT * FROM salons WHERE id = ?");
    $stmt->execute([$salonId]);
    $salon = $stmt->fetch();

    if (!$salon) {
        die("Salon introuvable.");
    }

    // Statistiques
    $nbFavoris = $pdo->prepare("SELECT COUNT(*) FROM favoris WHERE salon_id = ?");
    $nbFavoris->execute([$salonId]);
    $nbFavoris = $nbFavoris->fetchColumn();

    $nbRdv = $pdo->prepare("SELECT COUNT(*) FROM rdv WHERE salon_id = ?");
    $nbRdv->execute([$salonId]);
    $nbRdv = $nbRdv->fetchColumn();

    $avgAvis = $pdo->prepare("SELECT AVG(note) FROM avis WHERE salon_id = ?");
    $avgAvis->execute([$salonId]);
    $avgAvis = $avgAvis->fetchColumn();
    $avgAvis = $avgAvis ?: 0;

    // Services
    $stmt = $pdo->prepare("SELECT * FROM services WHERE salon_id = ?");
    $stmt->execute([$salonId]);
    $services = $stmt->fetchAll();

    // Horaires
    $stmt = $pdo->prepare("SELECT * FROM horaires_ouverture WHERE salon_id = ?");
    $stmt->execute([$salonId]);
    $horaires = $stmt->fetchAll();

    // Galerie
    $stmt = $pdo->prepare("SELECT * FROM galerie WHERE salon_id = ?");
    $stmt->execute([$salonId]);
    $galerie = $stmt->fetchAll();

    // Avis (avec nom du client)
    $stmt = $pdo->prepare("
        SELECT a.*, u.name AS client 
        FROM avis a 
        JOIN users u ON a.user_id = u.id 
        WHERE a.salon_id = ? 
        ORDER BY a.id DESC
    ");
    $stmt->execute([$salonId]);
    $avis = $stmt->fetchAll();

    // Vue
    require_once __DIR__ . '/../../views/salon/dashboard.php';
}


    public function horaires()
    {
        $this->checkSalon();
        require_once __DIR__ . '/../config/database.php';
        $pdo = getPDO();

        $salonId = $_SESSION['user']['id'];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jours = $_POST['jour'] ?? [];
            $heuresDebut = $_POST['heure_debut'] ?? [];
            $heuresFin = $_POST['heure_fin'] ?? [];

            $pdo->prepare("DELETE FROM horaires_ouverture WHERE salon_id = ?")->execute([$salonId]);

            for ($i = 0; $i < count($jours); $i++) {
                $jour = trim($jours[$i]);
                $debut = trim($heuresDebut[$i]);
                $fin = trim($heuresFin[$i]);

                if ($jour && $debut && $fin) {
                    $stmt = $pdo->prepare("INSERT INTO horaires_ouverture (salon_id, jour, heure_debut, heure_fin) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$salonId, $jour, $debut, $fin]);
                }
            }

            $_SESSION['success'] = "Horaires mis à jour.";
            header('Location: ' . ROOT_RELATIVE_PATH . '/salon/dashboard');
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM horaires_ouverture WHERE salon_id = ?");
        $stmt->execute([$salonId]);
        $horaires = $stmt->fetchAll();

        require_once __DIR__ . '/../../views/salon/horaires.php';
    }
    public function gallery()
{
    $this->checkSalon();
    require_once __DIR__ . '/../config/database.php';
    $pdo = getPDO();

    $salonId = $_SESSION['user']['id'];
 
    $stmt = $pdo->prepare("SELECT * FROM galerie WHERE salon_id = ?");
    $stmt->execute([$salonId]);
    $galerie = $stmt->fetchAll();

    require_once __DIR__ . '/../../views/salon/gallery.php';
}


public function uploadImage()
{
    $this->checkSalon();
    require_once __DIR__ . '/../config/database.php';
    $pdo = getPDO();

    $salonId = $_SESSION['user']['id'];

    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $index => $tmpPath) {
            $originalName = $_FILES['images']['name'][$index];
            $filename = uniqid() . '_' . $originalName;
            $target = UPLOADS_PATH . '/' . $filename;

            if (move_uploaded_file($tmpPath, $target)) {
                $stmt = $pdo->prepare("INSERT INTO galerie (salon_id, image_path) VALUES (?, ?)");
                $stmt->execute([$salonId, $filename]);
            }
        }
    }

    $_SESSION['success'] = "Images uploadées.";
    header('Location: ' . ROOT_RELATIVE_PATH . '/salon/gallery');
    exit;
}

public function deleteImage($id)
{
    $this->checkSalon();
    require_once __DIR__ . '/../config/database.php';
    $pdo = getPDO();

    $salonId = $_SESSION['user']['id'];

    $stmt = $pdo->prepare("SELECT * FROM galerie WHERE id = ? AND salon_id = ?");
    $stmt->execute([$id, $salonId]);
    $galerie = $stmt->fetch();

    if ($galerie) {
        $path = UPLOADS_PATH . '/' . $galerie['image_path'];
        if (file_exists($path)) {
            unlink($path);
        }

        $stmt = $pdo->prepare("DELETE FROM galerie WHERE id = ? AND salon_id = ?");
        $stmt->execute([$id, $salonId]);
    }

    $_SESSION['success'] = "Image supprimée.";
    header('Location: ' . ROOT_RELATIVE_PATH . '/salon/gallery');
    exit;
}

    public function edit_profile()
{
    $this->checkSalon();
    require_once __DIR__ . '/../config/database.php';
    $pdo = getPDO();
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
        $contactPhone = trim($_POST['phone'] ?? '');
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
                phone = ?, 
                whatsapp = ?, 
                latitude = ?, 
                longitude = ?, 
                profile_picture = ?
                WHERE id = ?");

            $stmt->execute([
                $name, $description, $category, $contactPhone,
                $whatsapp, $latitude, $longitude, $profilePicture, $salonId
            ]);

            $_SESSION['success'] = "Profil mis à jour.";
            header('Location: ' . ROOT_RELATIVE_PATH . '/salon/dashboard');
            exit;
        }
    }

    require_once __DIR__ . '/../../views/salon/edit_profile.php';
}

public function services()
{
    $this->checkSalon();
    require_once __DIR__ . '/../config/database.php';
    $pdo = getPDO();

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

    // Liste des services
    $stmt = $pdo->prepare("SELECT * FROM services WHERE salon_id = ?");
    $stmt->execute([$salonId]);
    $services = $stmt->fetchAll();

    require_once __DIR__ . '/../../views/salon/services.php';
}
public function validerRdv($rdvId)
{
    $this->checkSalon();
    $pdo = require __DIR__ . '/../config/database.php';
    $salonId = $_SESSION['user']['id'];

    $stmt = $pdo->prepare("UPDATE rdv SET status = 'confirmé' WHERE id = ? AND salon_id = ?");
    $stmt->execute([$rdvId, $salonId]);

    $_SESSION['success'] = "Rendez-vous confirmé.";
    header('Location: ' . ROOT_RELATIVE_PATH . '/salon/rdv');
    exit;
}

public function refuserRdv($rdvId)
{
    $this->checkSalon();
    $pdo = require __DIR__ . '/../config/database.php';
    $salonId = $_SESSION['user']['id'];

    $stmt = $pdo->prepare("UPDATE rdv SET status = 'refusé' WHERE id = ? AND salon_id = ?");
    $stmt->execute([$rdvId, $salonId]);

    $_SESSION['success'] = "Rendez-vous refusé.";
    header('Location: ' . ROOT_RELATIVE_PATH . '/salon/rdv');
    exit;
}

public function attenteRdv($rdvId)
{
    $this->checkSalon();
    $pdo = require __DIR__ . '/../config/database.php';
    $salonId = $_SESSION['user']['id'];

    $stmt = $pdo->prepare("UPDATE rdv SET status = 'en attente' WHERE id = ? AND salon_id = ?");
    $stmt->execute([$rdvId, $salonId]);

    $_SESSION['success'] = "Rendez-vous mis en attente.";
    header('Location: ' . ROOT_RELATIVE_PATH . '/salon/rdv');
    exit;
}


}
