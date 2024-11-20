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

$stmt = $pdo->query("
    SELECT u.username, u.nom, u.prenom, r.label AS role 
    FROM utilisateur u
    LEFT JOIN possede p ON u.username = p.username
    LEFT JOIN role r ON p.role_id = r.role_id
");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Gestion des utilisateurs</h1>
    <a href="Pages.Dashboard.php">Retour au tableau de bord</a>
    <a href="Pages.AddUsers.php">Ajouter un utilisateur</a>
    <table>
        <thead>
            <tr>
                <th>Nom d'utilisateur</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['nom']); ?></td>
                    <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($user['role'] ?: 'Non défini'); ?></td>
                    <td>
                        <a href="Pages.EditUsers.php?username=<?php echo $user['username']; ?>">Modifier</a>
                        <a href="Pages.DeleteUsers.php?username=<?php echo $user['username']; ?>" onclick="return confirm('Êtes-vous sûr ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
