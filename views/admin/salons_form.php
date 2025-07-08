<?php
$isEdit = isset($salon);
$title = $isEdit ? "Modifier Salon" : "Ajouter Salon";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
</head>
<body>

<h2><?= htmlspecialchars($title) ?></h2>

<?php if (!empty($errors)) : ?>
    <ul style="color:red;">
        <?php foreach ($errors as $err) : ?>
            <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Nom :</label><br>
    <input type="text" name="name" required value="<?= $isEdit ? htmlspecialchars($salon['name']) : '' ?>"><br><br>

    <label>Email :</label><br>
    <input type="email" name="email" required value="<?= $isEdit ? htmlspecialchars($salon['email']) : '' ?>"><br><br>

    <label>Téléphone :</label><br>
    <input type="text" name="contact_phone" value="<?= $isEdit ? htmlspecialchars($salon['contact_phone']) : '' ?>"><br><br>

    <label>WhatsApp :</label><br>
    <input type="text" name="whatsapp" value="<?= $isEdit ? htmlspecialchars($salon['whatsapp']) : '' ?>"><br><br>

    <label>Catégorie :</label><br>
    <select name="category">
        <option value="mixte" <?= $isEdit && $salon['category'] === 'mixte' ? 'selected' : '' ?>>Mixte</option>
        <option value="homme" <?= $isEdit && $salon['category'] === 'homme' ? 'selected' : '' ?>>Homme</option>
        <option value="femme" <?= $isEdit && $salon['category'] === 'femme' ? 'selected' : '' ?>>Femme</option>
    </select><br><br>

    <label>Description :</label><br>
    <textarea name="description" rows="4"><?= $isEdit ? htmlspecialchars($salon['description']) : '' ?></textarea><br><br>

    <label>Latitude :</label><br>
    <input type="text" name="latitude" value="<?= $isEdit ? htmlspecialchars($salon['latitude']) : '' ?>"><br><br>

    <label>Longitude :</label><br>
    <input type="text" name="longitude" value="<?= $isEdit ? htmlspecialchars($salon['longitude']) : '' ?>"><br><br>

    <label>Photo de profil :</label><br>
    <input type="file" name="profile_picture"><br>
    <?php if ($isEdit && !empty($salon['profile_picture'])): ?>
        <img src="<?= UPLOADS_URL . '/' . htmlspecialchars($salon['profile_picture']) ?>" width="80" alt="photo actuelle">
    <?php endif; ?>
    <br><br>

    <button type="submit"><?= $isEdit ? "Modifier" : "Ajouter" ?></button>
    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/salons">Annuler</a>
</form>

</body>
</html>
