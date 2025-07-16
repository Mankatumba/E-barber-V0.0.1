<?php ob_start(); ?>

<h2 class="text-2xl font-bold mb-6">Ma Galerie</h2>

<?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<!-- Formulaire d'ajout -->
<form method="POST" enctype="multipart/form-data" action="<?= ROOT_RELATIVE_PATH ?>/salon/gallery/upload" class="mb-8 bg-white p-6 border rounded shadow space-y-4">
    <div>
        <label for="images" class="block font-medium">Ajouter des images :</label>
        <input type="file" name="images[]" id="images" multiple required accept="image/*" class="block mt-2">
    </div>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Uploader</button>
</form>

<!-- Galerie -->
<?php if (empty($images)): ?>
    <p class="text-gray-600">Aucune image pour le moment.</p>
<?php else: ?>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        <?php foreach ($images as $img): ?>
            <div class="text-center">
                <img src="<?= UPLOADS_URL . '/' . htmlspecialchars($img['image_path']) ?>"
                     alt="Photo"
                     class="w-full h-40 object-cover rounded shadow mb-2">
                <form method="POST"
                      action="<?= ROOT_RELATIVE_PATH ?>/salon/gallery/delete/<?= $img['id'] ?>"
                      onsubmit="return confirm('Supprimer cette image ?');">
                    <button type="submit" class="text-red-600 hover:underline">🗑 Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<p class="mt-10">
    <a href="<?= ROOT_RELATIVE_PATH ?>/salon/dashboard" class="text-blue-600 hover:underline">← Retour au tableau de bord</a>
</p>

<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/salon.php'; ?>
