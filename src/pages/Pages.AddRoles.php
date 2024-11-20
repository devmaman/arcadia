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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $label = $_POST['label'];

    $stmt = $pdo->prepare("INSERT INTO role (label) VALUES (?)");
    $stmt->execute([$label]);

    header('Location: Pages.ManageRoles.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un rôle</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Ajouter un rôle</h1>
    <a href="Pages.ManageRoles.php">Retour</a>
    <form method="POST">
        <label for="label">Nom du rôle</label>
        <input type="text" name="label" required>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
