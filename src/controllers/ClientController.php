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
        $pdo = require __DIR__ . '/../config/database.php';
        $clientId = $_SESSION['user']['id'];

        // Infos client
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$clientId]);
        $client = $stmt->fetch();

        // Salons favoris
            $clientId = $_SESSION['user']['id'];
        $stmt = $pdo->prepare("SELECT s.* FROM favoris f JOIN salons s ON f.salon_id = s.id WHERE f.client_id = ?");
        $stmt->execute([$clientId]);
        $favoris = $stmt->fetchAll();

        // Rendez-vous
        $stmt = $pdo->prepare("SELECT r.*, s.name AS salon_name FROM rdv r JOIN salons s ON r.salon_id = s.id WHERE r.user_id = ? ORDER BY r.date DESC");
        $stmt->execute([$clientId]);
        $rdv = $stmt->fetchAll();


        // Avis donnés
        $stmt = $pdo->prepare("SELECT a.*, s.name AS salon_name FROM avis a JOIN salons s ON a.salon_id = s.id WHERE a.user_id = ?");
        $stmt->execute([$clientId]);
        $avis = $stmt->fetchAll();

        // Récupération de tous les salons
        $stmt = $pdo->query("SELECT id, name, category, profile_picture, description FROM salons");
        $salons = $stmt->fetchAll();


        require_once __DIR__ . '/../../views/client/dashboard.php';
    }

    public function deleteFavori($salonId)
    {
        $this->checkClient();
        $pdo = require __DIR__ . '/../config/database.php';
        $clientId = $_SESSION['user']['id'];

        $stmt = $pdo->prepare("DELETE FROM favoris WHERE salon_id = ? AND user_id = ?");
        $stmt->execute([$salonId, $clientId]);

        $_SESSION['success'] = "Salon retiré des favoris.";
        header('Location: ' . ROOT_RELATIVE_PATH . '/client/dashboard');
        exit;
    }

    public function cancelRdv($rdvId)
    {
        $this->checkClient();
        $pdo = require __DIR__ . '/../config/database.php';
        $clientId = $_SESSION['user']['id'];

        $stmt = $pdo->prepare("UPDATE rdv SET statut = 'annulé' WHERE id = ? AND user_id = ?");
        $stmt->execute([$rdvId, $clientId]);

        $_SESSION['success'] = "Rendez-vous annulé.";
        header('Location: ' . ROOT_RELATIVE_PATH . '/client/dashboard');
        exit;
    }

    public function deleteAvis($avisId)
    {
        $this->checkClient();
        $pdo = require __DIR__ . '/../config/database.php';
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
    $pdo = require __DIR__ . '/../config/database.php';

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

    // Avis (facultatif)
    $stmt = $pdo->prepare("SELECT a.*, u.name FROM avis a JOIN users u ON a.user_id = u.id WHERE a.salon_id = ?");
    $stmt->execute([$id]);
    $avis = $stmt->fetchAll();

    require_once __DIR__ . '/../../views/client/salon_view.php';
}


}
