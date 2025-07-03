<?php

class GalleryController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'salon') {
            header('Location: ' . ROOT_RELATIVE_PATH . '/auth');
            exit;
        }
    }

    public function index()
    {
        $pdo = require __DIR__ . '/../config/database.php';
        $salonId = $_SESSION['user']['id'];

        $stmt = $pdo->prepare("SELECT * FROM gallery WHERE salon_id = ? ORDER BY uploaded_at DESC");
        $stmt->execute([$salonId]);
        $images = $stmt->fetchAll();

        require_once __DIR__ . '/../../views/salon/gallery.php';
    }

    public function upload()
    {
        $pdo = require __DIR__ . '/../config/database.php';
        $salonId = $_SESSION['user']['id'];

        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                $name = $_FILES['images']['name'][$index];
                $target = UPLOADS_PATH . '/' . basename($name);

                if (move_uploaded_file($tmpName, $target)) {
                    $stmt = $pdo->prepare("INSERT INTO gallery (salon_id, image_path) VALUES (?, ?)");
                    $stmt->execute([$salonId, $name]);
                }
            }
        }

        header('Location: ' . ROOT_RELATIVE_PATH . '/salon/gallery');
        exit;
    }

    public function delete($id)
    {
        $pdo = require __DIR__ . '/../config/database.php';
        $salonId = $_SESSION['user']['id'];

        $stmt = $pdo->prepare("SELECT * FROM gallery WHERE id = ? AND salon_id = ?");
        $stmt->execute([$id, $salonId]);
        $image = $stmt->fetch();

        if ($image) {
            unlink(UPLOADS_PATH . '/' . $image['image_path']);
            $deleteStmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
            $deleteStmt->execute([$id]);
        }

        header('Location: ' . ROOT_RELATIVE_PATH . '/salon/gallery');
        exit;
    }
}
