<?php ob_start(); ?>

<div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6 mt-6">
    <h2 class="text-2xl font-bold text-indigo-700 mb-4">Bienvenue, <?= htmlspecialchars($_SESSION['user']['name']) ?></h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="bg-indigo-100 p-4 rounded shadow">
            <h3 class="text-lg font-semibold text-indigo-800">Salons enregistrés</h3>
            <p class="text-3xl font-bold text-indigo-900 mt-2"><?= $salons ?></p>
        </div>

        <div class="bg-green-100 p-4 rounded shadow">
            <h3 class="text-lg font-semibold text-green-800">Clients inscrits</h3>
            <p class="text-3xl font-bold text-green-900 mt-2"><?= $clients ?></p>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once dirname(__DIR__) . '/layouts/admin.php'; ?>
