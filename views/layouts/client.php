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

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-indigo-600">
                <a href="<?= ROOT_RELATIVE_PATH ?>/client/dashboard">E-Barber</a>
            </h1>
            <nav class="space-x-4">
                <a href="<?= ROOT_RELATIVE_PATH ?>/client/dashboard" class="hover:text-indigo-600">Accueil</a>
                <a href="<?= ROOT_RELATIVE_PATH ?>/auth/logout" class="text-red-600 hover:underline">Déconnexion</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        <?= $content ?? '<p class="text-red-600">Aucun contenu chargé.</p>' ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12 py-4 text-center text-sm text-gray-500">
        &copy; <?= date('Y') ?> E-Barber. Tous droits réservés.
    </footer>
</body>
</html>
