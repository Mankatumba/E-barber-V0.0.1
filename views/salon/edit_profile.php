<?php require_once dirname(__DIR__) . '../layouts/header.php'; ?>

<h2>Modifier le Profil du Salon</h2>

<?php if (!empty($errors)): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Nom du salon :</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($salon['name']) ?>" required><br><br>

    <label>Description :</label><br>
    <textarea name="description" rows="4"><?= htmlspecialchars($salon['description']) ?></textarea><br><br>

    <label>Catégorie :</label><br>
    <select name="category">
        <option value="mixte" <?= $salon['category'] === 'mixte' ? 'selected' : '' ?>>Mixte</option>
        <option value="homme" <?= $salon['category'] === 'homme' ? 'selected' : '' ?>>Homme</option>
        <option value="femme" <?= $salon['category'] === 'femme' ? 'selected' : '' ?>>Femme</option>
    </select><br><br>

    <label>Téléphone de contact :</label><br>
    <input type="text" name="contact_phone" value="<?= htmlspecialchars($salon['contact_phone'] ?? '') ?>"><br><br>

    <label>Numéro WhatsApp :</label><br>
    <input type="text" name="whatsapp" value="<?= htmlspecialchars($salon['whatsapp'] ?? '') ?>"><br><br>

    <label>Latitude :</label><br>
    <input type="text" name="latitude" id="latitude" value="<?= htmlspecialchars($salon['latitude'] ?? '') ?>"><br><br>

    <label>Longitude :</label><br>
    <input type="text" name="longitude" id="longitude" value="<?= htmlspecialchars($salon['longitude'] ?? '') ?>"><br><br>

    <label>Photo de profil :</label><br>
    <input type="file" name="profile_picture"><br><br>

    <div id="map" style="width: 100%; height: 300px;"></div><br>

    <button type="submit">Enregistrer</button>
</form>

<p><a href="<?= ROOT_RELATIVE_PATH ?>/salon/dashboard">Annuler</a></p>

<!-- Leaflet.js + carte OpenStreetMap (gratuite) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const lat = parseFloat(document.getElementById('latitude').value) || -4.325; // Kinshasa par défaut
    const lng = parseFloat(document.getElementById('longitude').value) || 15.322;

    const map = L.map('map').setView([lat, lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    marker.on('dragend', function (e) {
        const position = marker.getLatLng();
        document.getElementById('latitude').value = position.lat;
        document.getElementById('longitude').value = position.lng;
    });
</script>

<?php require_once dirname(__DIR__) . '../layouts/footer.php'; ?>
