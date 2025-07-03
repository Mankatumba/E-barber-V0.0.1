<?php require_once __DIR__ . '/../layouts/header.php'; ?>


<h2>Mon Salon</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<div style="display: flex; gap: 20px;">
    <div>
        <img src="<?= UPLOADS_URL . '/' . htmlspecialchars($salon['profile_photo']) ?>" alt="Photo de profil" width="150">
    </div>
    <div>
        <p><strong>Nom :</strong> <?= htmlspecialchars($salon['name']) ?></p>
        <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($salon['description'])) ?></p>
        <p><strong>Catégorie :</strong> <?= ucfirst($salon['category']) ?></p>
        <p><strong>Adresse :</strong> <?= htmlspecialchars($salon['address']) ?></p>
        <p><strong>Localisation :</strong> Latitude <?= htmlspecialchars($salon['latitude']) ?> / Longitude <?= htmlspecialchars($salon['longitude']) ?></p>
    </div>
</div>

<p><a href="<?= ROOT_RELATIVE_PATH ?>/salon/edit-profile">Modifier mon profil</a></p>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
