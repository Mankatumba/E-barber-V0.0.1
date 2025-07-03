<?php require_once dirname(__DIR__) . '/../layouts/header.php'; ?>

<h2>Ma Galerie</h2>

<form method="POST" enctype="multipart/form-data" action="<?= ROOT_RELATIVE_PATH ?>/salon/gallery/upload">
    <label>Ajouter des images :</label><br>
    <input type="file" name="images[]" multiple required>
    <button type="submit">Uploader</button>
</form>

<hr>

<div style="display: flex; flex-wrap: wrap; gap: 10px;">
    <?php foreach ($images as $img): ?>
        <div style="text-align:center;">
            <img src="<?= UPLOADS_URL . '/' . htmlspecialchars($img['image_path']) ?>" width="150" height="150" style="object-fit: cover;"><br>
            <form method="POST" action="<?= ROOT_RELATIVE_PATH ?>/salon/gallery/delete/<?= $img['id'] ?>" onsubmit="return confirm('Supprimer cette image ?');">
                <button type="submit" style="color:red;">Supprimer</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once dirname(__DIR__) . '/../layouts/footer.php'; ?>
