

<h2>Inscription d’un Salon</h2>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Nom du salon :</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email :</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="password" required><br><br>

    <label>Adresse :</label><br>
    <input type="text" name="address"><br><br>

    <label>Numéro de téléphone :</label><br>
    <input type="text" name="phone"><br><br>

    <label>Description :</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Catégorie :</label><br>
    <select name="category">
        <option value="mixte">Mixte</option>
        <option value="homme">Homme</option>
        <option value="femme">Femme</option>
    </select><br><br>

    <label>Latitude :</label><br>
    <input type="text" name="latitude"><br><br>

    <label>Longitude :</label><br>
    <input type="text" name="longitude"><br><br>

    <label>Photo de profil :</label><br>
    <input type="file" name="profile_photo"><br><br>

    <button type="submit">S’inscrire</button>
</form>

<p><a href="<?= ROOT_RELATIVE_PATH ?>/auth">Retour à la connexion</a></p>
