<?php ob_start(); ?>

<h2 class="text-2xl font-bold mb-6">Modifier le Profil du Salon</h2>

<?php if (!empty($errors)): ?>
    <ul class="bg-red-100 text-red-700 p-4 rounded mb-6">
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="space-y-6">
    <div>
        <label class="block font-semibold mb-1">Nom du salon</label>
        <input type="text" name="name" value="<?= htmlspecialchars($salon['name']) ?>" required
               class="w-full border border-gray-300 rounded px-3 py-2">
    </div>

    <div>
        <label class="block font-semibold mb-1">Description</label>
        <textarea name="description" rows="4"
                  class="w-full border border-gray-300 rounded px-3 py-2"><?= htmlspecialchars($salon['description']) ?></textarea>
    </div>

    <div>
        <label class="block font-semibold mb-1">Catégorie</label>
        <select name="category" class="w-full border border-gray-300 rounded px-3 py-2">
            <option value="mixte" <?= $salon['category'] === 'mixte' ? 'selected' : '' ?>>Mixte</option>
            <option value="homme" <?= $salon['category'] === 'homme' ? 'selected' : '' ?>>Homme</option>
            <option value="femme" <?= $salon['category'] === 'femme' ? 'selected' : '' ?>>Femme</option>
        </select>
    </div>

    <div>
        <label class="block font-semibold mb-1">Téléphone de contact</label>
        <input type="text" name="contact_phone" value="<?= htmlspecialchars($salon['contact_phone'] ?? '') ?>"
               class="w-full border border-gray-300 rounded px-3 py-2">
    </div>

    <div>
        <label class="block font-semibold mb-1">Numéro WhatsApp</label>
        <input type="text" name="whatsapp" value="<?= htmlspecialchars($salon['whatsapp'] ?? '') ?>"
               class="w-full border border-gray-300 rounded px-3 py-2">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block font-semibold mb-1">Latitude</label>
            <input type="text" name="latitude" id="latitude" value="<?= htmlspecialchars($salon['latitude'] ?? '') ?>"
                   class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div>
            <label class="block font-semibold mb-1">Longitude</label>
            <input type="text" name="longitude" id="longitude" value="<?= htmlspecialchars($salon['longitude'] ?? '') ?>"
                   class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
    </div>

    <div>
        <label class="block font-semibold mb-1">Photo de profil</label>
        <input type="file" name="profile_picture"
               class="block w-full border border-gray-300 rounded px-3 py-2 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"> Enregistrer</button>
        <a href="<?= ROOT_RELATIVE_PATH ?>/salon/dashboard" class="text-gray-600 hover:underline">Annuler</a>
    </div>
</form>

<p class="mt-6">
    <a href="<?= ROOT_RELATIVE_PATH ?>/salon/dashboard" class="text-blue-600 hover:underline"> Retour au tableau de bord</a>
</p>


<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/salon.php'; ?>
