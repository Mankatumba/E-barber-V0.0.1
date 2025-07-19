<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>E-Barber - Espace Client</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN (prod uniquement, pour dev tu peux compiler avec PostCSS ou Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icônes (optionnel) -->
    <link href="https://unpkg.com/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="<?= ROOT_RELATIVE_PATH ?>/assets/favicon.ico" type="image/x-icon">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        <?= $content ?? '<p class="text-red-600">Aucun contenu chargé.</p>' ?>
    </main>
