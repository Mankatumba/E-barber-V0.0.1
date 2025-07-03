<?php

$isEdit = isset($client);
$title = $isEdit ? "Modifier Client" : "Ajouter Client";

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
    <input type="text" name="name" required value="<?= $isEdit ? htmlspecialchars($client['name']) : '' ?>"><br><br>

    <label>Email :</label><br>
    <input type="email" name="email" required value="<?= $isEdit ? htmlspecialchars($client['email']) : '' ?>"><br><br>

    <label>Mot de passe : <?= $isEdit ? '(laisser vide pour ne pas changer)' : '' ?></label><br>
    <input type="password" name="password" <?= $isEdit ? '' : 'required' ?>><br><br>

    <button type="submit"><?= $isEdit ? "Modifier" : "Ajouter" ?></button>
    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/clients">Annuler</a>
</form>

</body>
</html>
