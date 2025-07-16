<?php ob_start(); ?>

<h2 class="text-2xl font-bold mb-6">Définir les horaires pour : <?= htmlspecialchars($service['name']) ?></h2>

<?php if (!empty($errors)) : ?>
    <ul class="bg-red-100 text-red-700 p-4 rounded mb-6">
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST" class="space-y-6">
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left p-2 border-b">Jour</th>
                    <th class="text-left p-2 border-b">Heure de début</th>
                    <th class="text-left p-2 border-b">Heure de fin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
                foreach ($jours as $jour) {
                    $exist = array_filter($horaires, fn($h) => $h['jour'] === $jour);
                    $heure_debut = $exist ? reset($exist)['heure_debut'] : '';
                    $heure_fin = $exist ? reset($exist)['heure_fin'] : '';
                ?>
                    <tr class="border-t">
                        <td class="p-2">
                            <input type="hidden" name="jour[]" value="<?= $jour ?>">
                            <span class="font-medium"><?= $jour ?></span>
                        </td>
                        <td class="p-2">
                            <input type="time" name="heure_debut[]" value="<?= $heure_debut ?>"
                                class="w-full border border-gray-300 rounded px-3 py-1">
                        </td>
                        <td class="p-2">
                            <input type="time" name="heure_fin[]" value="<?= $heure_fin ?>"
                                class="w-full border border-gray-300 rounded px-3 py-1">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="flex gap-4 items-center">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            💾 Enregistrer
        </button>
        <a href="<?= ROOT_RELATIVE_PATH ?>/salon/services" class="text-gray-600 hover:underline">
            Retour
        </a>
    </div>
</form>

<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/salon.php'; ?>
