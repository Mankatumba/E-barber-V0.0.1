<?php require_once dirname(__DIR__) . '../layouts/header.php'; ?>

<h2>Créer un compte client</h2>

<?php if (!empty($errors)) : ?>
    <ul style="color: red;">
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST">
    <label>Nom complet :</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email :</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Créer mon compte</button>
</form>

<p><a href="<?= ROOT_RELATIVE_PATH ?>/auth">Déjà inscrit ? Se connecter</a></p>

<?php require_once dirname(__DIR__) . '../layouts/footer.php'; ?>
