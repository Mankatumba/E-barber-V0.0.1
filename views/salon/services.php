<?php ob_start(); ?>

<h2 class="text-2xl font-bold mb-6">Gérer mes Services</h2>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (!empty($errors)) : ?>
    <ul class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h3 class="text-xl font-semibold mt-8 mb-4">Ajouter un service</h3>
<form method="POST" class="space-y-4 bg-white p-6 border rounded shadow">
    <input type="hidden" name="action" value="add_service">

    <div>
        <label class="block font-medium">Nom :</label>
        <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <div>
            <label class="block font-medium">Prix ($) :</label>
            <input type="number" name="price" step="0.01" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block font-medium">Durée (min) :</label>
            <input type="number" name="duration" class="w-full border rounded px-3 py-2">
        </div>
    </div>

    <div>
        <label class="block font-medium">Description :</label>
        <textarea name="description" rows="3" class="w-full border rounded px-3 py-2"></textarea>
    </div>

    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Ajouter le service</button>
</form>

<hr class="my-8">

<h3 class="text-xl font-semibold mb-4">Services existants</h3>

<?php foreach ($services as $s): ?>
    <div class="bg-white border rounded shadow p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h4 class="font-bold text-lg"><?= htmlspecialchars($s['name']) ?> — <?= $s['price'] ?> $ (<?= $s['duration'] ?> min)</h4>
                <p class="text-gray-700"><?= nl2br(htmlspecialchars($s['description'])) ?></p>
            </div>
            <div class="mt-2 md:mt-0 md:text-right space-x-3">
                <a href="<?= ROOT_RELATIVE_PATH ?>/salon/editService/<?= $s['id'] ?>" class="text-blue-600 hover:underline">Modifier</a>
                <a href="<?= ROOT_RELATIVE_PATH ?>/salon/deleteService/<?= $s['id'] ?>" onclick="return confirm('Supprimer ce service ?')" class="text-red-600 hover:underline">Supprimer</a>
                <a href="<?= ROOT_RELATIVE_PATH ?>/salon/horaires/<?= $s['id'] ?>" class="text-indigo-600 hover:underline">Définir horaires</a>
            </div>
        </div>

        <div class="mt-4">
            <h5 class="font-semibold">Horaires :</h5>
            <?php if (!empty($horaires[$s['id']])): ?>
                <ul class="list-disc list-inside text-sm">
                    <?php foreach ($horaires[$s['id']] as $h): ?>
                        <li class="flex justify-between items-center">
                            <?= htmlspecialchars($h['jour']) ?> : <?= htmlspecialchars($h['heure_debut']) ?> - <?= htmlspecialchars($h['heure_fin']) ?>
                            <a href="<?= ROOT_RELATIVE_PATH ?>/salon/services?delete_horaire=<?= $h['id'] ?>" class="text-red-500 text-sm ml-4 hover:underline" onclick="return confirm('Supprimer cet horaire ?')">🗑️</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-500">Aucun horaire défini.</p>
            <?php endif; ?>
        </div>

        <div class="mt-4">
            <h5 class="font-semibold mb-2">Ajouter un horaire</h5>
            <form method="POST" class="flex flex-wrap gap-4 items-end">
                <input type="hidden" name="action" value="add_horaire">
                <input type="hidden" name="service_id" value="<?= $s['id'] ?>">

                <div>
                    <label class="block text-sm">Jour</label>
                    <select name="jour" class="border rounded px-2 py-1">
                        <option>Lundi</option>
                        <option>Mardi</option>
                        <option>Mercredi</option>
                        <option>Jeudi</option>
                        <option>Vendredi</option>
                        <option>Samedi</option>
                        <option>Dimanche</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm">De</label>
                    <input type="time" name="heure_debut" class="border rounded px-2 py-1" required>
                </div>

                <div>
                    <label class="block text-sm">À</label>
                    <input type="time" name="heure_fin" class="border rounded px-2 py-1" required>
                </div>

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Valider</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<p class="mt-10">
    <a href="<?= ROOT_RELATIVE_PATH ?>/salon/dashboard" class="text-blue-600 hover:underline">← Retour au tableau de bord</a>
</p>

<?php $content = ob_get_clean(); require_once __DIR__ . '/../layouts/salon.php'; ?>
