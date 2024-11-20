<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}

$stmt = $pdo->prepare("SELECT role_id FROM possede WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user_role = $stmt->fetchColumn();

if ($user_role != 1) {
    die("Accès refusé.");
}

$stmt = $pdo->query("SELECT * FROM role");
$roles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des rôles</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Gestion des rôles</h1>
    <a href="Pages.Dashboard.php">Retour au tableau de bord</a>
    <a href="Pages.AddRoles.php">Ajouter un rôle</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Label</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $role): ?>
                <tr>
                    <td><?php echo $role['role_id']; ?></td>
                    <td><?php echo htmlspecialchars($role['label']); ?></td>
                    <td>
                        <a href="Pages.EditRoles.php?id=<?php echo $role['role_id']; ?>">Modifier</a>
                        <a href="Pages.DeleteRoles.php?id=<?php echo $role['role_id']; ?>" onclick="return confirm('Êtes-vous sûr ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
