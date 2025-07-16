<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<h2><?= htmlspecialchars($salon['name']) ?> (<?= ucfirst($salon['category']) ?>)</h2>

<?php if (!empty($salon['profile_picture'])): ?>
    <img src="<?= ROOT_RELATIVE_PATH ?>/uploads/<?= htmlspecialchars($salon['profile_picture']) ?>" alt="photo" style="max-width: 300px;"><br><br>
<?php endif; ?>

<p><?= nl2br(htmlspecialchars($salon['description'])) ?></p>
<p><strong>WhatsApp :</strong> <?= htmlspecialchars($salon['whatsapp']) ?></p>
<p><strong>Téléphone :</strong> <?= htmlspecialchars($salon['phone']) ?></p>
<p><strong>Localisation :</strong> Latitude <?= htmlspecialchars($salon['latitude']) ?> / Longitude <?= htmlspecialchars($salon['longitude']) ?></p>

<!-- Ajouter aux favoris -->
<form method="POST" action="<?= ROOT_RELATIVE_PATH ?>/client/addFavori">

    <input type="hidden" name="salon_id" value="<?= $salon['id'] ?>">
    <button type="submit">💖 Ajouter aux favoris</button>
</form>

<hr>

<!-- Galerie -->
<h3>Galerie</h3>
<?php if (empty($images)): ?>
    <p>Aucune image publiée.</p>
<?php else: ?>
    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
        <?php foreach ($images as $img): ?>
            <img src="<?= ROOT_RELATIVE_PATH ?>/uploads/<?= htmlspecialchars($img['image_path']) ?>" alt="image" style="width: 150px; height: 150px; object-fit: cover;">
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<hr>

<!-- Horaires -->
<h3>Horaires d'ouverture</h3>
<?php if (empty($horaires)): ?>
    <p>Non spécifiés.</p>
<?php else: ?>
    <ul>
        <?php foreach ($horaires as $h): ?>
            <li><?= htmlspecialchars($h['jour']) ?> : <?= htmlspecialchars($h['heure_ouverture']) ?> - <?= htmlspecialchars($h['heure_fermeture']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr>

<!-- Services -->
<h3>Services proposés</h3>
<ul>
    <?php foreach ($services as $s): ?>
        <li><strong><?= htmlspecialchars($s['name']) ?></strong> — <?= $s['price'] ?>$ (<?= $s['duration'] ?> min)</li>
    <?php endforeach; ?>
</ul>

<hr>

<!-- Avis -->
<h3>Avis</h3>
<?php if (empty($avis)): ?>
    <p>Aucun avis pour ce salon.</p>
<?php else: ?>
    <ul>
        <?php foreach ($avis as $a): ?>
            <li><strong><?= htmlspecialchars($a['name']) ?></strong> (<?= $a['note'] ?>/5) : <?= nl2br(htmlspecialchars($a['commentaire'])) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<!-- Formulaire Avis -->
<h4>Laisser un avis</h4>
<form method="POST" action="<?= ROOT_RELATIVE_PATH ?>/client/addAvis">
    <input type="hidden" name="salon_id" value="<?= $salon['id'] ?>">
    
    <label>Note :</label>
    <select name="note" required>
        <option value="">--</option>
        <option value="1">⭐</option>
        <option value="2">⭐⭐</option>
        <option value="3">⭐⭐⭐</option>
        <option value="4">⭐⭐⭐⭐</option>
        <option value="5">⭐⭐⭐⭐⭐</option>
    </select><br><br>

    <label>Commentaire :</label><br>
    <textarea name="commentaire" rows="3" required></textarea><br><br>

    <button type="submit">Envoyer</button>
</form>

<p><a href="<?= ROOT_RELATIVE_PATH ?>/client/dashboard">⬅ Retour au tableau de bord</a></p>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
