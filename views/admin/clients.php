<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/menu.php'; ?>

<h2>Liste des clients</h2>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Date d'inscription</th>
             <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= htmlspecialchars($client['name']) ?></td>
                <td><?= htmlspecialchars($client['email']) ?></td>
                <td><?= htmlspecialchars($client['telephone']) ?></td>
                <td><?= htmlspecialchars($client['created_at']) ?></td>
                <td>
                <?php if ($client['status'] === 'suspended'): ?>
                    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/unsuspend_client/<?= $client['id'] ?>">Réactiver</a>
                <?php else: ?>
                    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/suspend_client/<?= $client['id'] ?>">Suspendre</a>
                <?php endif; ?>
                </td>
                <td><?= $client['status'] ?></td>


            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
