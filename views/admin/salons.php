<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/menu.php';
?>

<div class="container">
    <h2>Liste des salons</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Actions</th>
            <th>Statut</th>
        </tr>
        <?php foreach ($salons as $salon) : ?>
            <tr>
                <td><?= htmlspecialchars($salon['name']) ?></td>
                <td><?= htmlspecialchars($salon['adresse']) ?></td>
                <td><?= htmlspecialchars($salon['email']) ?></td>
                <td><?= isset($client['telephone']) ? htmlspecialchars($client['telephone']) : 'Non renseigné' ?>
</td>
                <td>
                    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/editSalon/<?= $salon['id'] ?>">Modifier</a>
                     <?php if ($salon['status'] === 'blocked'): ?>
                    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/unblock_salon/<?= $salon['id'] ?>">Débloquer</a>
                    <?php else: ?>
                    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/block_salon/<?= $salon['id'] ?>">Bloquer</a>
                    <?php endif; ?>
                    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/deleteSalon/<?= $salon['id'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>

                </td>
                <td><?= $salon['status'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
