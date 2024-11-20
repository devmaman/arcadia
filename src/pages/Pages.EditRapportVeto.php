<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM rapport_veterinaire WHERE rapport_veterinaire_id = ?");
    $stmt->execute([$id]);
    $report = $stmt->fetch();

    if (!$report) {
        die("Rapport vétérinaire introuvable.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $detail = $_POST['detail'];

    $stmt = $pdo->prepare("UPDATE rapport_veterinaire SET date = ?, detail = ? WHERE rapport_veterinaire_id = ?");
    $stmt->execute([$date, $detail, $id]);

    header('Location: Pages.ManageRapportVeto.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un rapport vétérinaire</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Modifier le rapport vétérinaire</h1>
    <a href="Pages.ManageRapportVeto.php">Retour</a>
    <form method="POST">
        <label for="date">Date du rapport</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($report['date']); ?>" required>

        <label for="detail">Détail du rapport</label>
        <textarea name="detail" required><?php echo htmlspecialchars($report['detail']); ?></textarea>

        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
