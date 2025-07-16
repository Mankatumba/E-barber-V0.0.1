<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'Salon - E-Barber' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">

  <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <div class="text-2xl font-bold text-blue-600">E-Barber</div>
    <div class="space-x-4">
      <a href="<?= ROOT_RELATIVE_PATH ?>/salon/dashboard" class="hover:text-blue-500">Dashboard</a>
      <a href="<?= ROOT_RELATIVE_PATH ?>/salon/services" class="hover:text-blue-500">Services</a>
      <a href="<?= ROOT_RELATIVE_PATH ?>/salon/gallery" class="hover:text-blue-500">Galerie</a>
      <a href="<?= ROOT_RELATIVE_PATH ?>/salon/edit_profile" class="hover:text-blue-500">Profil</a>
      <a href="<?= ROOT_RELATIVE_PATH ?>/auth/logout" class="text-red-500">Déconnexion</a>
    </div>
  </nav>

  <main class="max-w-6xl mx-auto p-6 mt-6 bg-white rounded-lg shadow">
    <?php if (!empty($_SESSION['success'])): ?>
      <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

    <?= $content ?>
  </main>

</body>
</html>
