<?php ob_start(); ?>

<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded shadow">
    <h2 class="text-xl font-semibold mb-4 text-center">Créer un compte salon</h2>

    <?php if (!empty($errors)) : ?>
        <ul class="text-red-500 text-sm mb-4">
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Nom du salon :</label>
            <input type="text" name="name" required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">Catégorie :</label>
            <select name="category" class="w-full border px-3 py-2 rounded">
                <option value="mixte">Mixte</option>
                <option value="homme">Homme</option>
                <option value="femme">Femme</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Email :</label>
            <input type="email" name="email" required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">Mot de passe :</label>
            <input type="password" name="password" required class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded font-semibold">Créer le salon</button>
    </form>

    <p class="mt-4 text-sm text-center">
        <a href="<?= ROOT_RELATIVE_PATH ?>/auth" class="text-blue-600 hover:underline">Retour à la connexion</a>
    </p>
</div>

<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/salon_form.php'; ?>
