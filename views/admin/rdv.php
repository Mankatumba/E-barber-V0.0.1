<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/menu.php'; ?>

<h2>Liste des rendez-vous</h2>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Salon</th>
            <th>Client</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rdvs as $rdv): ?>
            <tr>
                <td><?= htmlspecialchars($rdv['salon_name']) ?></td>
                <td><?= htmlspecialchars($rdv['client_name']) ?></td>
                <td><?= htmlspecialchars($rdv['date']) ?></td>
                <td><?= htmlspecialchars($rdv['heure']) ?></td>
                <td><?= htmlspecialchars($rdv['statut']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
