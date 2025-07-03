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

<form method="POST" action="">
    <label>Nom :</label><br>
    <input type="text" name="name" required value="<?= $isEdit ? htmlspecialchars($salon['name']) : '' ?>"><br><br>

    <label>Email :</label><br>
    <input type="email" name="email" required value="<?= $isEdit ? htmlspecialchars($salon['email']) : '' ?>"><br><br>

    <label>Adresse :</label><br>
    <input type="text" name="address" value="<?= $isEdit ? htmlspecialchars($salon['address']) : '' ?>"><br><br>

    <label>Téléphone :</label><br>
    <input type="text" name="phone" value="<?= $isEdit ? htmlspecialchars($salon['phone']) : '' ?>"><br><br>

    <button type="submit"><?= $isEdit ? "Modifier" : "Ajouter" ?></button>
    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/salons">Annuler</a>
</form>

</body>
</html>
