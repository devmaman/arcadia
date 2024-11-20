<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $detail = $_POST['detail'];

    $stmt = $pdo->prepare("INSERT INTO rapport_veterinaire (date, detail) VALUES (?, ?)");
    $stmt->execute([$date, $detail]);

    header('Location: Pages.ManageRapportVeto.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un rapport vétérinaire</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Ajouter un rapport vétérinaire</h1>
    <a href="Pages.ManageRapportVeto.php">Retour</a>
    <form method="POST">
        <label for="date">Date du rapport</label>
        <input type="date" name="date" required>

        <label for="detail">Détail du rapport</label>
        <textarea name="detail" required></textarea>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
