<?php if ($_SESSION['user']['role'] === 'super_admin') : ?>
<nav>
    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/dashboard">Dashboard</a>
    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/salons">Salons</a>
    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/clients">Clients</a>
    <a href="<?= ROOT_RELATIVE_PATH ?>/admin/rdv">Rendez-vous</a>
    <a href="<?= ROOT_RELATIVE_PATH ?>/auth/logout">Se déconnecter</a>
</nav>
<?php endif; ?>
