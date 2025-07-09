<?php require_once dirname(__DIR__) . '../layouts/header.php'; ?>

<h2>Gérer mes Services</h2>

<?php if (!empty($_SESSION['success'])): ?>
    <p style="color: green;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<?php if (!empty($errors)) : ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h3>Ajouter un service</h3>
<form method="POST">
    <input type="hidden" name="action" value="add_service">

    <label>Nom :</label><br>
    <input type="text" name="name" required><br><br>

    <label>Prix ($) :</label><br>
    <input type="number" name="price" step="0.01" required><br><br>

    <label>Durée (min) :</label><br>
    <input type="number" name="duration"><br><br>

    <label>Description :</label><br>
    <textarea name="description" rows="3"></textarea><br><br>

    <button type="submit">Ajouter le service</button>
</form>

<hr>

<h3>Services existants</h3>

<?php foreach ($services as $s): ?>
    <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
        <strong><?= htmlspecialchars($s['name']) ?></strong> — <?= $s['price'] ?> $ (<?= $s['duration'] ?> min)<br>
        <?= nl2br(htmlspecialchars($s['description'])) ?><br><br>

        <a href="<?= ROOT_RELATIVE_PATH ?>/salon/editService/<?= $s['id'] ?>">Modifier</a> |
        <a href="<?= ROOT_RELATIVE_PATH ?>/salon/deleteService/<?= $s['id'] ?>" onclick="return confirm('Supprimer ce service ?')">Supprimer</a> |
        <a href="<?= ROOT_RELATIVE_PATH ?>/salon/horaires/<?= $s['id'] ?>">Définir horaires</a>

        <h4>Horaires :</h4>
        <?php if (!empty($horaires[$s['id']])): ?>
            <ul>
                <?php foreach ($horaires[$s['id']] as $h): ?>
                    <li>
                        <?= htmlspecialchars($h['jour']) ?> : <?= htmlspecialchars($h['heure_debut']) ?> - <?= htmlspecialchars($h['heure_fin']) ?>
                        <a href="<?= ROOT_RELATIVE_PATH ?>/salon/services?delete_horaire=<?= $h['id'] ?>" onclick="return confirm('Supprimer cet horaire ?')">🗑️</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucun horaire défini.</p>
        <?php endif; ?>

        <h5>Ajouter un horaire</h5>
        <form method="POST" style="margin-top: 10px;">
            <input type="hidden" name="action" value="add_horaire">
            <input type="hidden" name="service_id" value="<?= $s['id'] ?>">

            <label>Jour :</label>
            <select name="jour" required>
                <option>Lundi</option>
                <option>Mardi</option>
                <option>Mercredi</option>
                <option>Jeudi</option>
                <option>Vendredi</option>
                <option>Samedi</option>
                <option>Dimanche</option>
            </select>

            <label>De :</label>
            <input type="time" name="heure_debut" required>

            <label>à</label>
            <input type="time" name="heure_fin" required>

            <button type="submit">Valider</button>
        </form>
    </div>
<?php endforeach; ?>

<?php require_once dirname(__DIR__) . '../layouts/footer.php'; ?>
