<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>E-Barber - Super Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tu peux ajouter ici des couleurs personnalisées via Tailwind config si nécessaire -->
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">

    <!-- HEADER -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-indigo-700">E-Barber • Super Admin</h1>
            <nav class="space-x-4 text-sm">
                <a href="<?= ROOT_RELATIVE_PATH ?>/admin/dashboard" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                <a href="<?= ROOT_RELATIVE_PATH ?>/admin/salons" class="text-gray-700 hover:text-indigo-600">Salons</a>
                <a href="<?= ROOT_RELATIVE_PATH ?>/admin/clients" class="text-gray-700 hover:text-indigo-600">Clients</a>
                <a href="<?= ROOT_RELATIVE_PATH ?>/admin/rdv" class="text-gray-700 hover:text-indigo-600">Rendez-vous</a>
                <a href="<?= ROOT_RELATIVE_PATH ?>/auth/logout" class="text-red-600 hover:underline">Déconnexion</a>
            </nav>
        </div>
    </header>

    <!-- CONTENU PRINCIPAL -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        <?= $content ?? '' ?>
    </main>

    <!-- FOOTER -->
    <footer class="text-center text-sm text-gray-500 py-6">
        &copy; <?= date('Y') ?> E-Barber • Tous droits réservés
    </footer>

</body>
</html>
