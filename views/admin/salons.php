<?php ob_start(); ?>

<div class="max-w-6xl mx-auto mt-8 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">Liste des salons</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm">
            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Adresse</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Téléphone</th>
                    <th class="px-4 py-2">Statut</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salons as $salon): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2"><?= htmlspecialchars($salon['name']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($salon['adresse']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($salon['email']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($salon['telephone'] ?? 'Non renseigné') ?></td>
                        <td class="px-4 py-2">
                            <?php if ($salon['status'] === 'active'): ?>
                                <span class="text-green-600 font-semibold">Actif</span>
                            <?php elseif ($salon['status'] === 'blocked'): ?>
                                <span class="text-red-600 font-semibold">Bloqué</span>
                            <?php else: ?>
                                <span class="text-gray-600"><?= htmlspecialchars($salon['status']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="<?= ROOT_RELATIVE_PATH ?>/admin/editSalon/<?= $salon['id'] ?>" class="text-blue-600 hover:underline">Modifier</a>
                            <?php if ($salon['status'] === 'blocked'): ?>
                                <a href="<?= ROOT_RELATIVE_PATH ?>/admin/unblock_salon/<?= $salon['id'] ?>" class="text-green-600 hover:underline"> Débloquer</a>
                            <?php else: ?>
                                <a href="<?= ROOT_RELATIVE_PATH ?>/admin/block_salon/<?= $salon['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Bloquer ce salon ?')">Bloquer</a>
                            <?php endif; ?>
                            <a href="<?= ROOT_RELATIVE_PATH ?>/admin/deleteSalon/<?= $salon['id'] ?>" class="text-gray-600 hover:underline" onclick="return confirm('Supprimer ce salon ?')"> Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once dirname(__DIR__) . '/layouts/admin.php'; ?>
