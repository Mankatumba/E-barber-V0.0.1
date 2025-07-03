<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    
    <form method="POST" action="<?= ROOT_RELATIVE_PATH ?>/auth/login">
        <label>Email :</label><br>
        <input type="email" name="email" required><br><br>
        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Se connecter</button>
    </form>
    <p>Vous êtes un salon ? <a href="<?= ROOT_RELATIVE_PATH ?>/auth/registerSalon">Créer un compte</a></p>

</body>
</html>
