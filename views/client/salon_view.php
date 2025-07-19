<?php ob_start(); ?>

<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 mt-6">

    <h2 class="text-2xl font-bold mb-4 text-indigo-600"><?= htmlspecialchars($salon['name']) ?> <span class="text-sm text-gray-500">(<?= ucfirst($salon['category']) ?>)</span></h2>

    <?php if (!empty($salon['profile_picture'])): ?>
         <img src="<?= UPLOADS_URL . '/' . (!empty($salon['profile_picture']) ? htmlspecialchars($salon['profile_picture']) : 'default.png') ?>" alt="Photo de profil" class="w-20 h-20 object-cover rounded shadow">
    <?php endif; ?>

    <p class="mb-3 text-gray-700 whitespace-pre-line"><?= nl2br(htmlspecialchars($salon['description'])) ?></p>

    <div class="mb-4 text-sm text-gray-600 space-y-1">
        <p><strong> WhatsApp :</strong> <?= htmlspecialchars($salon['whatsapp']) ?></p>
        <p><strong> Téléphone :</strong> <?= htmlspecialchars($salon['phone']) ?></p>
    </div>
<!-- Formulaire d'ajout aux favoris -->
<form method="POST" action="<?= ROOT_RELATIVE_PATH ?>/client/addFavori" class="mb-6">
    <input type="hidden" name="salon_id" value="<?= $salon['id'] ?>">
    <button type="submit"
            class="px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600 transition">
        Ajouter aux favoris
    </button>
</form>

<!-- Formulaire de réservation -->
<a href="<?= ROOT_RELATIVE_PATH ?>/client/reserver?salon_id=<?= $salon['id'] ?>" 
   class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
    Réserver un RDV
</a>


    <hr class="my-6">


  <!-- Galerie -->
<h3 class="text-lg font-semibold mb-2">Galerie de photos</h3>

<?php if (empty($images)): ?>
    <p class="text-gray-500 mb-4">Aucune image publiée.</p>
<?php else: ?>
    <div class="flex flex-wrap gap-3 mb-4">
        <?php foreach ($images as $img): ?>
            <img src="<?= UPLOADS_URL . '/' . htmlspecialchars($img['image_path']) ?>" alt="Photo" class="w-40 h-40 object-cover rounded shadow">
        <?php endforeach; ?>
    </div>
<?php endif; ?>


    <!-- Horaires -->
   <h3 class="text-lg font-semibold mb-2">Horaires d'ouverture</h3>

<?php if (empty($horaires)): ?>
    <p class="text-gray-500 mb-4">Ce salon n'a pas encore publié ses horaires.</p>
<?php else: ?>
    <ul class="text-sm text-gray-700 mb-4">
        <?php foreach ($horaires as $h): ?>
            <li>
                <?= htmlspecialchars($h['jour']) ?> : 
                <?= htmlspecialchars($h['heure_debut']) ?> - 
                <?= htmlspecialchars($h['heure_fin']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


    <!-- Services -->
    <h3 class="text-xl font-semibold mb-2"> Services proposés</h3>
    <ul class="mb-6 text-gray-700 space-y-1">
        <?php foreach ($services as $s): ?>
            <li><strong><?= htmlspecialchars($s['name']) ?></strong> — <?= $s['price'] ?>$ (<?= $s['duration'] ?> min)</li>
        <?php endforeach; ?>
    </ul>

    <!-- Avis -->
    <h3 class="text-xl font-semibold mb-2"> Avis</h3>
    <?php if (empty($avis)): ?>
        <p class="text-gray-500 mb-4">Aucun avis pour ce salon.</p>
    <?php else: ?>
        <ul class="mb-6 space-y-2 text-gray-700">
            <?php foreach ($avis as $a): ?>
                <li class="border p-2 rounded bg-gray-50">
                    <strong><?= htmlspecialchars($a['name']) ?></strong> (<?= $a['note'] ?>/5) :
                    <div class="whitespace-pre-line"><?= nl2br(htmlspecialchars($a['commentaire'])) ?></div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Formulaire Avis -->
    <h4 class="text-lg font-semibold mt-6 mb-2"> Laissez un avis</h4>
    <form method="POST" action="<?= ROOT_RELATIVE_PATH ?>/client/addAvis" class="space-y-4">
        <input type="hidden" name="salon_id" value="<?= $salon['id'] ?>">

        <div>
            <label class="block text-sm font-medium">Note :</label>
            <select name="note" required class="border rounded p-2 w-full">
                <option value="">--</option>
                <option value="1">⭐</option>
                <option value="2">⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Commentaire :</label>
            <textarea name="commentaire" rows="3" required class="border rounded p-2 w-full"></textarea>
        </div>

        <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
            Envoyer
        </button>
    </form>

    <div class="mt-6">
        <a href="<?= ROOT_RELATIVE_PATH ?>/client/dashboard" class="text-indigo-600 hover:underline">
             Retour au tableau de bord
        </a>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once dirname(__DIR__) . '/layouts/client.php';
?>
