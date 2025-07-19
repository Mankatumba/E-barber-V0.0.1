<?php ob_start(); ?>

<h2 class="text-2xl font-bold mb-4">Mon Salon</h2>

<?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<div class="flex flex-col md:flex-row gap-6 mb-6">
    <div>
        <img src="<?= UPLOADS_URL . '/' . (!empty($salon['profile_picture']) ? htmlspecialchars($salon['profile_picture']) : 'default.png') ?>" alt="Photo de profil" class="w-40 h-40 object-cover rounded shadow">
    </div>
    <div class="space-y-2">
        <p><strong>Nom :</strong> <?= htmlspecialchars($salon['name']) ?></p>
        <p><strong>Description :</strong><br> <?= nl2br(htmlspecialchars($salon['description'])) ?></p>
        <p><strong>Catégorie :</strong> <?= ucfirst($salon['category']) ?></p>
        <p><strong>Contact :</strong> <?= htmlspecialchars($salon['contact_phone'] ?? 'Non renseigné') ?></p>
        <p><strong>WhatsApp :</strong> <?= htmlspecialchars($salon['whatsapp'] ?? 'Non renseigné') ?></p>
        <p><strong>Localisation :</strong> Latitude <?= htmlspecialchars($salon['latitude']) ?> / Longitude <?= htmlspecialchars($salon['longitude']) ?></p>
    </div>
</div>

<hr class="my-6">

<h3 class="text-lg font-semibold mb-2">Statistiques</h3>
<ul class="list-disc list-inside mb-6">
    <li><strong>Nombre de clients abonnés :</strong> <?= $nbFavoris ?? '0' ?></li>
    <li><strong>Nombre de réservations :</strong> <?= $nbRdv ?? '0' ?></li>
    <li><strong>Moyenne des avis :</strong> <?= number_format($avgAvis ?? 0, 1) ?>/5</li>
</ul>

<hr class="my-6">

<h3 class="text-lg font-semibold mb-2">Horaires d'ouverture</h3>
<?php if (empty($horaires)): ?>
    <p class="text-gray-500 mb-4">Aucun horaire défini.</p>
<?php else: ?>
    <ul class="mb-4">
        <?php foreach ($horaires as $h): ?>
            <li><?= htmlspecialchars($h['jour']) ?> : <?= htmlspecialchars($h['heure_debut']) ?> - <?= htmlspecialchars($h['heure_fin']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr class="my-6">

<h3 class="text-lg font-semibold mb-2">Services</h3>
<?php if (empty($services)): ?>
    <p class="text-gray-500 mb-4">Aucun service enregistré.</p>
<?php else: ?>
    <ul class="mb-4">
        <?php foreach ($services as $s): ?>
            <li><?= htmlspecialchars($s['name']) ?> — <?= htmlspecialchars($s['price']) ?> $ (<?= $s['duration'] ?> min)</li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr class="my-6">
<h3 class="text-lg font-semibold mb-2">Galerie de photos</h3>
<?php if (empty($galerie)): ?>
    <p class="text-gray-500 mb-4">Aucune image publiée.</p>
<?php else: ?>

    <div class="flex flex-wrap gap-3 mb-4">
        <?php foreach ($galerie as $img): ?>
           <img src="<?= UPLOADS_URL . '/' . htmlspecialchars($img['image_path']) ?>" alt="Photo" class="w-28 h-28 object-cover rounded shadow">
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<a href="<?= ROOT_RELATIVE_PATH ?>/salon/gallery" class="text-blue-600 hover:underline block mb-4">Gérer la galerie</a>

<hr class="my-6">

<div class="space-y-2">
    <a href="<?= ROOT_RELATIVE_PATH ?>/salon/edit_profile" class="text-blue-600 hover:underline block">Modifier mon profil</a>
    <a href="<?= ROOT_RELATIVE_PATH ?>/salon/services" class="text-blue-600 hover:underline block">Gérer mes services</a>
    <a href="<?= ROOT_RELATIVE_PATH ?>/auth/logout" class="text-red-600 hover:underline block">Se déconnecter</a>
</div>

<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/salon.php'; ?>
