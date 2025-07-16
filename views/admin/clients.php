<?php ob_start(); ?>

<div class="max-w-6xl mx-auto mt-8 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">Liste des clients</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm">
            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Téléphone</th>
                    <th class="px-4 py-2">Date d'inscription</th>
                    <th class="px-4 py-2">Statut</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2"><?= htmlspecialchars($client['name']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($client['email']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($client['telephone']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($client['created_at']) ?></td>
                        <td class="px-4 py-2">
                            <?php if ($client['status'] === 'active'): ?>
                                <span class="text-green-600 font-semibold">Actif</span>
                            <?php elseif ($client['status'] === 'suspended'): ?>
                                <span class="text-red-600 font-semibold">Suspendu</span>
                            <?php else: ?>
                                <span class="text-gray-600"><?= htmlspecialchars($client['status']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2">
                            <?php if ($client['status'] === 'suspended'): ?>
                                <a href="<?= ROOT_RELATIVE_PATH ?>/admin/unsuspend_client/<?= $client['id'] ?>" class="text-blue-600 hover:underline">✅ Réactiver</a>
                            <?php else: ?>
                                <a href="<?= ROOT_RELATIVE_PATH ?>/admin/suspend_client/<?= $client['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Suspendre ce client ?')">⛔ Suspendre</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once dirname(__DIR__) . '/layouts/admin.php'; ?>
