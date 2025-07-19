<?php 
require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/helpers/auth.php';

// Suppression de session_start();

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    echo "Vous devez être connecté en tant que client pour réserver.";
    exit;
}

$client_id = $_SESSION['user_id'];

$salon_id = $_GET['salon_id'] ?? null;
$is_domicile = $_GET['is_domicile'] ?? 0;

if (!$salon_id) {
    echo "Salon introuvable.";
    exit;
}

$pdo = getPDO();

// Récupérer les services du salon
$stmt = $pdo->prepare("SELECT * FROM services WHERE salon_id = ?");
$stmt->execute([$salon_id]);
$services = $stmt->fetchAll();

// Récupérer les infos du salon pour affichage
$stmt = $pdo->prepare("SELECT * FROM salons WHERE id = ?");
$stmt->execute([$salon_id]);
$salon = $stmt->fetch();

if (!$salon) {
    echo "Salon non trouvé.";
    exit;
}
?>
<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réserver un RDV</title>
    <link href="<?= ROOT_RELATIVE_PATH ?>/assets/css/style.css" rel="stylesheet">
</head>
<body class="max-w-xl mx-auto mt-10 p-4">
    <h1 class="text-2xl font-bold mb-4">Réserver chez <?= htmlspecialchars($salon['name']) ?></h1>

    <form method="POST" action="<?= ROOT_RELATIVE_PATH ?>/client/valider_reservation" class="space-y-4">
        <input type="hidden" name="salon_id" value="<?= $salon_id ?>">
        <input type="hidden" name="is_domicile" value="<?= $is_domicile ?>">
        <input type="hidden" name="client_id" value="<?= $client_id ?>">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Service</label>
            <select name="service_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                <?php foreach ($services as $s): ?>
                    <option value="<?= $s['id'] ?>">
                        <?= htmlspecialchars($s['name']) ?> — <?= $s['price'] ?>$
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
            <input type="date" name="date" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Heure</label>
            <input type="time" name="heure" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                Valider la réservation
            </button>
        </div>
    </form>
</body>
</html>

<?php
$content = ob_get_clean();
require_once dirname(__DIR__) . '/layouts/client.php';
?>
