<?php
require_once __DIR__ . '/../src/config/constants.php';

$filename = $_GET['file'] ?? null;

if (!$filename || !preg_match('/^[\w\-]+\.(jpg|jpeg|png|gif)$/i', $filename)) {
    http_response_code(404);
    exit('Fichier non trouvé.');
}

$path = UPLOADS_PATH . '/' . $filename;

if (!file_exists($path)) {
    http_response_code(404);
    exit('Fichier introuvable.');
}

$mime = mime_content_type($path);
header("Content-Type: $mime");
readfile($path);
exit;
