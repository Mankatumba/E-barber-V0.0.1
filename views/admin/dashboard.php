<?php if ($_SESSION['user']['role'] === 'super_admin') : ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Super Admin</title>
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['user']['name']) ?></h1>
    <p><strong>Nombre de salons :</strong> <?= $salons ?></p>
    <p><strong>Nombre de clients :</strong> <?= $clients ?></p>

    <p><a href="<?= ROOT_RELATIVE_PATH ?>/auth/logout">Se déconnecter</a></p>
</body>
</html>
<?php endif; ?>
