<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}

$stmt = $pdo->query("SELECT * FROM rapport_veterinaire");
$reports = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des rapports vétérinaires</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Gestion des rapports vétérinaires</h1>
    <a href="Pages.Dashboard.php">Retour au tableau de bord</a>
    <a href="Pages.AddRapportVeto.php">Ajouter un rapport vétérinaire</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Détail</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?php echo $report['rapport_veterinaire_id']; ?></td>
                    <td><?php echo htmlspecialchars($report['date']); ?></td>
                    <td><?php echo htmlspecialchars($report['detail']); ?></td>
                    <td>
                        <a href="Pages.EditRapportVeto.php?id=<?php echo $report['rapport_veterinaire_id']; ?>">Modifier</a>
                        <a href="Pages.DeleteRapportVeto.php?id=<?php echo $report['rapport_veterinaire_id']; ?>" onclick="return confirm('Êtes-vous sûr ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
