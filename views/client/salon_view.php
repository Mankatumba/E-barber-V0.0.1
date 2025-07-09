<?php require_once dirname(__DIR__) . '../layouts/header.php'; ?>

<h2><?= htmlspecialchars($salon['name']) ?> (<?= ucfirst($salon['category']) ?>)</h2>

<?php if (!empty($salon['profile_picture'])): ?>
    <img src="<?= ROOT_RELATIVE_PATH ?>/uploads/<?= htmlspecialchars($salon['profile_picture']) ?>" alt="photo" style="max-width: 300px;"><br><br>
<?php endif; ?>

<p><?= nl2br(htmlspecialchars($salon['description'])) ?></p>
<p><strong>WhatsApp :</strong> <?= htmlspecialchars($salon['whatsapp']) ?></p>
<p><strong>Téléphone :</strong> <?= htmlspecialchars($salon['phone']) ?></p>

<hr>
<h3>Services proposés</h3>
<ul>
    <?php foreach ($services as $s): ?>
        <li><strong><?= htmlspecialchars($s['name']) ?></strong> — <?= $s['price'] ?>$ (<?= $s['duration'] ?> min)</li>
    <?php endforeach; ?>
</ul>

<hr>
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

<p><a href="<?= ROOT_RELATIVE_PATH ?>/client/dashboard">⬅ Retour au tableau de bord</a></p>

<?php require_once dirname(__DIR__) . '../layouts/footer.php'; ?>
