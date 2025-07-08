<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Mon Salon</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<div style="display: flex; gap: 20px;">
    <div>
        <img src="<?= UPLOADS_URL . '/' . (!empty($salon['profile_picture']) ? htmlspecialchars($salon['profile_picture']) : 'default.png') ?>" alt="Photo de profil" width="150">
    </div>
    <div>
        <p><strong>Nom :</strong> <?= htmlspecialchars($salon['name']) ?></p>
        <p><strong>Description :</strong><br> <?= nl2br(htmlspecialchars($salon['description'])) ?></p>
        <p><strong>Catégorie :</strong> <?= ucfirst($salon['category']) ?></p>
        <p><strong>Contact :</strong> <?= htmlspecialchars($salon['contact_phone'] ?? 'Non renseigné') ?></p>
        <p><strong>WhatsApp :</strong> <?= htmlspecialchars($salon['whatsapp'] ?? 'Non renseigné') ?></p>
        <p><strong>Localisation :</strong> Latitude <?= htmlspecialchars($salon['latitude']) ?> / Longitude <?= htmlspecialchars($salon['longitude']) ?></p>
    </div>
</div>

<hr>
<h3>Statistiques</h3>
<ul>
    <li><strong>Nombre de clients abonnés :</strong> <?= isset($nbFavoris) ? $nbFavoris : '0' ?></li>
    <li><strong>Nombre de réservations :</strong> <?= isset($nbRdv) ? $nbRdv : '0' ?></li>
    <li><strong>Moyenne des avis :</strong> <?= isset($avgAvis) ? number_format($avgAvis, 1) : '0.0' ?>/5</li>
</ul>

<hr>

<h3>Horaires d'ouverture</h3>
<?php if (empty($horaires)): ?>
    <p>Aucun horaire défini.</p>
<?php else: ?>
    <ul>
        <?php foreach ($horaires as $h): ?>
            <li><?= htmlspecialchars($h['jour']) ?> : <?= htmlspecialchars($h['heure_ouverture']) ?> - <?= htmlspecialchars($h['heure_fermeture']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h3>Services</h3>
<?php if (empty($services)): ?>
    <p>Aucun service enregistré.</p>
<?php else: ?>
    <ul>
        <?php foreach ($services as $s): ?>
            <li><?= htmlspecialchars($s['nom']) ?> - <?= htmlspecialchars($s['prix']) ?> FCFA</li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr>
<p><a href="<?= ROOT_RELATIVE_PATH ?>/salon/edit_profile">Modifier mon profil</a></p>
<p><a href="<?= ROOT_RELATIVE_PATH ?>/auth/logout">Se déconnecter</a></p>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
