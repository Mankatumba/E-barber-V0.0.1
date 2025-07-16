<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<h2>Ma Galerie</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<!-- Formulaire d'ajout -->
<form method="POST" enctype="multipart/form-data" action="<?= ROOT_RELATIVE_PATH ?>/salon/gallery/upload">
    <label for="images">Ajouter des images :</label><br>
    <input type="file" name="images[]" id="images" multiple required accept="image/*">
    <button type="submit">Uploader</button>
</form>

<hr>

<!-- Galerie -->
<?php if (empty($images)): ?>
    <p>Aucune image pour le moment.</p>
<?php else: ?>
    <div style="display: flex; flex-wrap: wrap; gap: 15px;">
        <?php foreach ($images as $img): ?>
            <div style="text-align: center;">
                <img src="<?= UPLOADS_URL . '/' . htmlspecialchars($img['image_path']) ?>" width="150" height="150" style="object-fit: cover; border-radius: 8px;"><br>
                <form method="POST" action="<?= ROOT_RELATIVE_PATH ?>/salon/gallery/delete/<?= $img['id'] ?>" onsubmit="return confirm('Supprimer cette image ?');">
                    <button type="submit" style="color:red;">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<p style="margin-top: 20px;"><a href="<?= ROOT_RELATIVE_PATH ?>/salon/dashboard"> Retour au tableau de bord</a></p>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
