<?php require_once dirname(__DIR__) . '../layouts/header.php'; ?>

<h2>Bienvenue <?= htmlspecialchars($client['name']) ?> </h2>

<?php if (!empty($_SESSION['success'])): ?>
    <p style="color: green;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<p><a href="<?= ROOT_RELATIVE_PATH ?>/auth/logout">Se déconnecter</a></p>
<hr>

<h3>Mes salons favoris</h3>
<?php if (empty($favoris)): ?>
    <p>Vous n'avez encore aucun salon en favori.</p>
<?php else: ?>
    <ul>
        <?php foreach ($favoris as $salon): ?>
            <li>
                <?= htmlspecialchars($salon['name']) ?> —
                <a href="<?= ROOT_RELATIVE_PATH ?>/client/deleteFavori/<?= $salon['id'] ?>" onclick="return confirm('Retirer ce salon des favoris ?')">🗑 Retirer</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr>

<h3>Mes rendez-vous</h3>
<?php if (empty($rdv)): ?>
    <p>Aucun rendez-vous pour le moment.</p>
<?php else: ?>
    <ul>
        <?php foreach ($rdv as $r): ?>
            <li>
                <?= htmlspecialchars($r['date']) ?> à <?= htmlspecialchars($r['heure']) ?> avec <strong><?= htmlspecialchars($r['salon_name']) ?></strong>
                — Statut : <em><?= htmlspecialchars($r['statut']) ?></em>
                <?php if ($r['statut'] !== 'annulé'): ?>
                    | <a href="<?= ROOT_RELATIVE_PATH ?>/client/cancelRdv/<?= $r['id'] ?>" onclick="return confirm('Annuler ce rendez-vous ?')">❌ Annuler</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr>

<h3>Mes avis</h3>
<?php if (empty($avis)): ?>
    <p>Vous n'avez laissé aucun avis.</p>
<?php else: ?>
    <ul>
        <?php foreach ($avis as $a): ?>
            <li>
                <strong><?= htmlspecialchars($a['salon_name']) ?></strong> — Note : <?= $a['note'] ?>/5 <br>
                "<?= nl2br(htmlspecialchars($a['commentaire'])) ?>" <br>
                <a href="<?= ROOT_RELATIVE_PATH ?>/client/deleteAvis/<?= $a['id'] ?>" onclick="return confirm('Supprimer cet avis ?')">🗑 Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr>

<h3>Salons disponibles</h3>
<div style="display: flex; flex-wrap: wrap; gap: 20px;">
    <?php foreach ($salons as $salon): ?>
        <div style="border: 1px solid #ccc; padding: 15px; width: 250px;">
            <h4><?= htmlspecialchars($salon['name']) ?> (<?= ucfirst($salon['category']) ?>)</h4>

            <?php if (!empty($salon['profile_picture'])): ?>
                <img src="<?= ROOT_RELATIVE_PATH ?>/uploads/<?= htmlspecialchars($salon['profile_picture']) ?>" alt="photo" style="max-width: 100%; height: auto;">
            <?php endif; ?>

            <p><?= nl2br(htmlspecialchars(substr($salon['description'], 0, 100))) ?>...</p>

            <a href="<?= ROOT_RELATIVE_PATH ?>/client/salon/<?= $salon['id'] ?>">Voir le salon</a>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once dirname(__DIR__) . '../layouts/footer.php'; ?>
