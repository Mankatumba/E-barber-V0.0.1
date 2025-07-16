<?php ob_start(); ?>

<h2 class="text-2xl font-bold mb-6">Bienvenue <?= htmlspecialchars($client['name']) ?></h2>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<div class="mb-6">
    <a href="<?= ROOT_RELATIVE_PATH ?>/auth/logout" class="text-red-600 hover:underline">Se déconnecter</a>
</div>

<hr class="my-6">

<h3 class="text-xl font-semibold mb-2"> Mes salons favoris</h3>
<?php if (empty($favoris)): ?>
    <p class="text-gray-600">Vous n'avez encore aucun salon en favori.</p>
<?php else: ?>
    <ul class="space-y-2 mb-6">
        <?php foreach ($favoris as $salon): ?>
            <li>
                <?= htmlspecialchars($salon['name']) ?>
                <a href="<?= ROOT_RELATIVE_PATH ?>/client/deleteFavori/<?= $salon['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Retirer ce salon des favoris ?')"> Retirer</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr class="my-6">

<h3 class="text-xl font-semibold mb-2"> Mes rendez-vous</h3>
<?php if (empty($rdv)): ?>
    <p class="text-gray-600">Aucun rendez-vous pour le moment.</p>
<?php else: ?>
    <ul class="space-y-2 mb-6">
        <?php foreach ($rdv as $r): ?>
            <li>
                <?= htmlspecialchars($r['date']) ?> à <?= htmlspecialchars($r['heure']) ?> avec
                <strong><?= htmlspecialchars($r['salon_name']) ?></strong> —
                Statut : <em><?= htmlspecialchars($r['statut']) ?></em>
                <?php if ($r['statut'] !== 'annulé'): ?>
                    | <a href="<?= ROOT_RELATIVE_PATH ?>/client/cancelRdv/<?= $r['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Annuler ce rendez-vous ?')"> Annuler</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr class="my-6">

<h3 class="text-xl font-semibold mb-2"> Mes avis</h3>
<?php if (empty($avis)): ?>
    <p class="text-gray-600">Vous n'avez laissé aucun avis.</p>
<?php else: ?>
    <ul class="space-y-4 mb-6">
        <?php foreach ($avis as $a): ?>
            <li class="bg-gray-100 p-4 rounded shadow">
                <strong><?= htmlspecialchars($a['salon_name']) ?></strong> — Note : <?= $a['note'] ?>/5<br>
                <p class="text-gray-700">"<?= nl2br(htmlspecialchars($a['commentaire'])) ?>"</p>
                <a href="<?= ROOT_RELATIVE_PATH ?>/client/deleteAvis/<?= $a['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Supprimer cet avis ?')"> Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr class="my-6">

<h3 class="text-xl font-semibold mb-4"> Salons disponibles</h3>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php foreach ($salons as $salon): ?>
        <div class="border rounded-lg shadow p-4 bg-white">
            <h4 class="font-semibold text-lg"><?= htmlspecialchars($salon['name']) ?> (<?= ucfirst($salon['category']) ?>)</h4>

            <?php if (!empty($salon['profile_picture'])): ?>
                <img src="<?= ROOT_RELATIVE_PATH ?>/uploads/<?= htmlspecialchars($salon['profile_picture']) ?>" alt="photo" class="w-full h-40 object-cover mt-2 mb-3 rounded">
            <?php endif; ?>

            <p class="text-sm text-gray-700 mb-3"><?= nl2br(htmlspecialchars(substr($salon['description'], 0, 100))) ?>...</p>

            <a href="<?= ROOT_RELATIVE_PATH ?>/client/salon/<?= $salon['id'] ?>" class="text-blue-600 hover:underline">Voir le salon</a>
        </div>
    <?php endforeach; ?>
</div>

<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/client.php'; ?>
