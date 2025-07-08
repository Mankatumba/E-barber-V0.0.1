<?php require_once dirname(__DIR__) . '../layouts/header.php'; ?>

<h2>Créer un compte salon</h2>

<?php if (!empty($errors)) : ?>
    <ul style="color: red;">
        <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST">
    <label>Nom du salon :</label><br>
    <input type="text" name="name" required><br><br>

    <label>Catégorie :</label><br>
    <select name="category">
        <option value="mixte">Mixte</option>
        <option value="homme">Homme</option>
        <option value="femme">Femme</option>
    </select><br><br>

    <label>Email :</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Créer le salon</button>
</form>

<p><a href="<?= ROOT_RELATIVE_PATH ?>/auth">Retour à la connexion</a></p>

<?php require_once dirname(__DIR__) . '../layouts/footer.php'; ?>
