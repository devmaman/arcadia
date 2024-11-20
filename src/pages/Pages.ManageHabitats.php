<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}

$stmt = $pdo->query("SELECT * FROM habitat");
$habitats = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des habitats</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Gestion des habitats</h1>
    <a href="Pages.Dashboard.php">Retour au tableau de bord</a>
    <a href="Pages.AddHabitats.php">Ajouter un habitats</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Commentaire</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($habitats as $habitat): ?>
                <tr>
                    <td><?php echo htmlspecialchars($habitat['habitat_id']); ?></td>
                    <td><?php echo htmlspecialchars($habitat['nom']); ?></td>
                    <td><?php echo htmlspecialchars($habitat['description']); ?></td>
                    <td><?php echo htmlspecialchars($habitat['commentaire_habitat']); ?></td>
                    <td>
                        <?php if ($habitat['image_path']): ?>
                            <img src="..<?php echo $habitat['image_path']; ?>" alt="Image de <?php echo htmlspecialchars($habitat['nom']); ?>" width="100">
                        <?php else: ?>
                            Aucune image
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="Pages.EditHabitats.php?id=<?php echo $habitat['habitat_id']; ?>">Modifier</a>
                        <a href="Pages.DeleteHabitats.php?id=<?php echo $habitat['habitat_id']; ?>" onclick="return confirm('Êtes-vous sûr ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
