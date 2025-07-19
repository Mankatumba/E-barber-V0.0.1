<?php ob_start(); ?>


<div class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4 text-gray-700">Liste des rendez-vous</h2>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-100 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-6 py-3">Salon</th>
                    <th class="px-6 py-3">Client</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Heure</th>
                    <th class="px-6 py-3">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($rdvs as $rdv): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4"><?= htmlspecialchars($rdv['salon_name']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($rdv['user_name']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($rdv['date']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($rdv['heure']) ?></td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium 
                                <?= $rdv['statut'] === 'confirmé' ? 'bg-green-100 text-green-700' : 
                                    ($rdv['statut'] === 'refusé' ? 'bg-red-100 text-red-700' : 
                                    ($rdv['statut'] === 'en attente' ? 'bg-yellow-100 text-yellow-700' : 
                                    'bg-gray-100 text-gray-700')) ?>">
                                <?= htmlspecialchars($rdv['statut']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once dirname(__DIR__) . '/layouts/admin.php'; ?>
