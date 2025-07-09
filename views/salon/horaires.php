<?php require_once dirname(__DIR__) . '/../layouts/header.php'; ?>

<h2>Définir les horaires pour : <?= htmlspecialchars($service['name']) ?></h2>

<?php if (!empty($errors)) : ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST">
    <table>
        <thead>
            <tr>
                <th>Jour</th>
                <th>Heure de début</th>
                <th>Heure de fin</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
            foreach ($jours as $jour) {
                $exist = array_filter($horaires, fn($h) => $h['jour'] === $jour);
                $heure_debut = $exist ? reset($exist)['heure_debut'] : '';
                $heure_fin = $exist ? reset($exist)['heure_fin'] : '';
            ?>
                <tr>
                    <td>
                        <input type="hidden" name="jour[]" value="<?= $jour ?>">
                        <?= $jour ?>
                    </td>
                    <td><input type="time" name="heure_debut[]" value="<?= $heure_debut ?>"></td>
                    <td><input type="time" name="heure_fin[]" value="<?= $heure_fin ?>"></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <button type="submit">Enregistrer</button>
</form>

<p><a href="<?= ROOT_RELATIVE_PATH ?>/salon/services">Retour</a></p>

<?php require_once dirname(__DIR__) . '/../layouts/footer.php'; ?>
