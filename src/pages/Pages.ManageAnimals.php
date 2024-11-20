<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}

$stmt = $pdo->query("SELECT * FROM animal");
$animals = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des animaux</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Gestion des animaux</h1>
    <a href="Pages.Dashboard.php">Retour au tableau de bord</a>
    <a href="Pages.AddAnimals.php">Ajouter un animal</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>État</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($animals as $animal): ?>
                <tr>
                    <td><?php echo $animal['animal_id']; ?></td>
                    <td><?php echo htmlspecialchars($animal['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($animal['etat']); ?></td>
                    <td>
                        <?php if ($animal['image_path']): ?>
                            <img src="..<?php echo $animal['image_path']; ?>" alt="Image de <?php echo htmlspecialchars($animal['prenom']); ?>" width="100">
                        <?php else: ?>
                            Aucune image
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="Pages.EditAnimals.php?id=<?php echo $animal['animal_id']; ?>">Modifier</a>
                        <a href="Pages.DeleteAnimals.php?id=<?php echo $animal['animal_id']; ?>" onclick="return confirm('Êtes-vous sûr ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
