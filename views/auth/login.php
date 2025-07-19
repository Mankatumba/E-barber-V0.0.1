<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-semibold mb-4 text-center">Connexion</h2>
        
        <?php if (isset($error)) : ?>
            <p class="text-red-500 text-sm mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="<?= ROOT_RELATIVE_PATH ?>/auth/login" class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Email :</label>
                <input type="email" name="email" required class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="block text-sm font-medium">Mot de passe :</label>
                <input type="password" name="password" required class="w-full border px-3 py-2 rounded">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded">Se connecter</button>
        </form>

        <div class="mt-4 text-sm text-center">
            <p>Vous êtes un salon ? 
                <a href="<?= ROOT_RELATIVE_PATH ?>/auth/registerSalon" class="text-blue-600 hover:underline">Créer un compte</a>
            </p>
            <p>Vous êtes un nouveau client ? 
                <a href="<?= ROOT_RELATIVE_PATH ?>/auth/registerClient" class="text-blue-600 hover:underline">Créer un compte</a>
            </p>
        </div>
    </div>
</body>
</html>
