<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM animal WHERE animal_id = ?");
    $stmt->execute([$id]);
    $animal = $stmt->fetch();

    if (!$animal) {
        die("Animal introuvable.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $etat = $_POST['etat'];

    $stmt = $pdo->prepare("UPDATE animal SET prenom = ?, etat = ? WHERE animal_id = ?");
    $stmt->execute([$prenom, $etat, $id]);

    header('Location: Pages.ManageAnimals.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un animal</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Modifier l'animal</h1>
    <a href="Pages.ManageAnimals.php">Retour</a>
    <form method="POST">
        <label for="prenom">Prénom de l'animal</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($animal['prenom']); ?>" required>

        <label for="etat">État de l'animal</label>
        <input type="text" name="etat" value="<?php echo htmlspecialchars($animal['etat']); ?>" required>

        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
