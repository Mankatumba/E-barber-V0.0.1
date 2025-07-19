<?php

class ClientController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function checkClient()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
            header('Location: ' . ROOT_RELATIVE_PATH . '/auth');
            exit;
        }
    }
public function dashboard()
{
    $this->checkClient();

    require_once __DIR__ . '/../config/database.php';
    $pdo = getPDO();

    $clientId = $_SESSION['user']['id'];

    // Infos client
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$clientId]);
    $client = $stmt->fetch();

    

    // Salons favoris
    $stmt = $pdo->prepare("SELECT s.* 
                           FROM favoris f 
                           JOIN salons s ON f.salon_id = s.id 
                           WHERE f.user_id = ?");
    $stmt->execute([$clientId]);
    $favoris = $stmt->fetchAll();

    // Rendez-vous
    $stmt = $pdo->prepare("SELECT r.*, s.name AS salon_name 
                           FROM rdv r 
                           JOIN salons s ON r.salon_id = s.id 
                           WHERE r.user_id = ? 
                           ORDER BY r.date DESC");
    $stmt->execute([$clientId]);
    $rdv = $stmt->fetchAll();

    // Avis donnés
    $stmt = $pdo->prepare("SELECT a.*, s.name AS salon_name 
                           FROM avis a 
                           JOIN salons s ON a.salon_id = s.id 
                           WHERE a.user_id = ?");
    $stmt->execute([$clientId]);
    $avis = $stmt->fetchAll();

    // Tous les salons
    $stmt = $pdo->query("SELECT id, name, category, profile_picture, description 
                         FROM salons");
    $salons = $stmt->fetchAll();

    require_once __DIR__ . '/../../views/client/dashboard.php';
}

    public function deleteFavori($salonId)
    {
        $this->checkClient();
        require __DIR__ . '/../config/database.php';
        $pdo = getPDO();
        $clientId = $_SESSION['user']['id'];

        $stmt = $pdo->prepare("DELETE FROM favoris WHERE salon_id = ? AND user_id = ?");
        $stmt->execute([$salonId, $clientId]);

        $_SESSION['success'] = "Salon retiré des favoris.";
        header('Location: ' . ROOT_RELATIVE_PATH . '/client/dashboard');
        exit;
    }

public function valider_reservation()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $salon_id = $_POST['salon_id'] ?? null;
        $client_id = $_SESSION['user_id'] ?? null; 
        $service_id = $_POST['service_id'] ?? null;
        $date = $_POST['date'] ?? null;
        $heure = $_POST['heure'] ?? null;
        $is_domicile = $_POST['is_domicile'] ?? 0;

        if (!$salon_id || !$client_id || !$service_id || !$date || !$heure) {
            die("Données invalides.");
        }

        $stmt = $this->pdo->prepare("INSERT INTO rdv (salon_id, user_id, service_id, date, heure, statut, is_domicile)
                                     VALUES (?, ?, ?, ?, ?, 'en_attente', ?)");
        $stmt->execute([$salon_id, $client_id, $service_id, $date, $heure, $is_domicile]);

        header("Location: " . ROOT_RELATIVE_PATH . "/client/mes_reservations");
        exit;
    }
}


public function annuler_reservation()
{
    if (!isset($_GET['id'])) {
        die("ID réservation manquant.");
    }

    $reservation_id = $_GET['id'];
    $client_id = $_SESSION['user_id'];

    // Vérifier que la réservation appartient bien au client
    $stmt = $this->pdo->prepare("SELECT * FROM rdv WHERE id = ? AND client_id = ?");
    $stmt->execute([$reservation_id, $client_id]);
    $rdv = $stmt->fetch();

    if (!$rdv) {
        die("Réservation introuvable.");
    }

    // Supprimer la réservation
    $stmt = $this->pdo->prepare("DELETE FROM rdv WHERE id = ?");
    $stmt->execute([$reservation_id]);

    header("Location: " . ROOT_RELATIVE_PATH . "/client/mes_reservations");
    exit;
}


    public function deleteAvis($avisId)
    {
        $this->checkClient();
        require_once __DIR__ . '/../config/database.php';
        $pdo = getPDO();
        $clientId = $_SESSION['user']['id'];

        $stmt = $pdo->prepare("DELETE FROM avis WHERE id = ? AND user_id = ?");
        $stmt->execute([$avisId, $clientId]);

        $_SESSION['success'] = "Avis supprimé.";
        header('Location: ' . ROOT_RELATIVE_PATH . '/client/dashboard');
        exit;
    }
  public function salon($id)
{
    $this->checkClient();

    require_once __DIR__ . '/../config/database.php';
    $pdo = getPDO();

    // Récupération du salon
    $stmt = $pdo->prepare("SELECT * FROM salons WHERE id = ?");
    $stmt->execute([$id]);
    $salon = $stmt->fetch();

    if (!$salon) {
        $_SESSION['error'] = "Salon introuvable.";
        header('Location: ' . ROOT_RELATIVE_PATH . '/client/dashboard');
        exit;
    }

    // Services proposés
    $stmt = $pdo->prepare("SELECT * FROM services WHERE salon_id = ?");
    $stmt->execute([$id]);
    $services = $stmt->fetchAll();

    // Avis
    $stmt = $pdo->prepare("SELECT a.*, u.name FROM avis a JOIN users u ON a.user_id = u.id WHERE a.salon_id = ?");
    $stmt->execute([$id]);
    $avis = $stmt->fetchAll();

    // Galerie
    $stmt = $pdo->prepare("SELECT * FROM galerie WHERE salon_id = ?");
    $stmt->execute([$id]);
    $images = $stmt->fetchAll();

    //horaire
    $stmt = $pdo->prepare("SELECT * FROM horaires_ouverture WHERE salon_id = ?");
    $stmt->execute([$id]);
    $horaires = $stmt->fetchAll();

    require_once __DIR__ . '/../../views/client/salon_view.php';
}

public function addFavori()
{
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
        header('Location: ' . ROOT_RELATIVE_PATH . '/auth');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salon_id'])) {
        require_once __DIR__ . '/../config/database.php';
        $pdo = getPDO();

        $clientId = $_SESSION['user']['id'];
        $salonId = intval($_POST['salon_id']);

        // Vérifie si le favori existe déjà
        $stmt = $pdo->prepare("SELECT * FROM favoris WHERE user_id = ? AND salon_id = ?");
        $stmt->execute([$clientId, $salonId]);

        if (!$stmt->fetch()) {
            $stmt = $pdo->prepare("INSERT INTO favoris (user_id, salon_id) VALUES (?, ?)");
            $stmt->execute([$clientId, $salonId]);
        }

        $_SESSION['success'] = "Salon ajouté à vos favoris.";
        header('Location: ' . ROOT_RELATIVE_PATH . '/client/dashboard');
        exit;
    }

    http_response_code(400);
    echo "Requête invalide.";
}


public function addAvis()
{
    
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
        header('Location: ' . ROOT_RELATIVE_PATH . '/auth');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/../config/database.php';
        $pdo = getPDO();
        $clientId = $_SESSION['user']['id'];
        $salonId = intval($_POST['salon_id']);
        $note = intval($_POST['note']);
        $commentaire = trim($_POST['commentaire']);

        // Optionnel : vérifier qu’un avis pour ce salon n’existe pas déjà
        $stmt = $pdo->prepare("SELECT * FROM avis WHERE user_id = ? AND salon_id = ?");
        $stmt->execute([$clientId, $salonId]);
        if ($stmt->fetch()) {
            $_SESSION['success'] = "Vous avez déjà laissé un avis pour ce salon.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO avis (user_id, salon_id, note, commentaire, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$clientId, $salonId, $note, $commentaire]);
            $_SESSION['success'] = "Avis publié avec succès.";
        }

        header('Location: ' . ROOT_RELATIVE_PATH . '/client/salon/' . $salonId);
        exit;
    }

    http_response_code(400);
    echo "Requête invalide.";
}
public function reserver()
{
    require_once __DIR__ . '/../config/database.php';
    $pdo = getPDO();

    // Vérifier que l'utilisateur est bien connecté et est un client
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
        header('Location: ' . ROOT_RELATIVE_PATH . '/login');
        exit;
    }

    $userId = $_SESSION['user']['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $salonId = $_POST['salon_id'] ?? null;
        $serviceId = $_POST['service_id'] ?? null;
        $date = $_POST['date'] ?? null;
        $isDomicile = isset($_POST['is_domicile']) ? 1 : 0;

        // Validation simple
        if ($salonId && $serviceId && $date) {
            $stmt = $pdo->prepare("INSERT INTO rdv (user_id, salon_id, service_id, date, is_domicile, status, created_at)
                                   VALUES (?, ?, ?, ?, ?, ?, NOW())");

            $stmt->execute([
                $userId,
                $salonId,
                $serviceId,
                $date,
                $isDomicile,
                'en_attente' // statut par défaut
            ]);

            $_SESSION['success'] = "Votre réservation a bien été enregistrée.";
            header('Location: ' . ROOT_RELATIVE_PATH . '/client/mes_rdv'); // Rediriger vers une page de confirmation
            exit;
        } else {
            $_SESSION['error'] = "Tous les champs sont obligatoires.";
        }
    }

    // Si GET, on redirige vers l'accueil ou une page erreur
    header('Location: ' . ROOT_RELATIVE_PATH . '/client/dashboard');
    exit;
}


}
