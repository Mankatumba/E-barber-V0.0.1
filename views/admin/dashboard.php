<?php 
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/menu.php';
?>

<div class="container">
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['user']['name']) ?></h1>
    <p><strong>Nombre de salons :</strong> <?= $salons ?></p>
    <p><strong>Nombre de clients :</strong> <?= $clients ?></p>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
