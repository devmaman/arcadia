<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM habitat WHERE habitat_id = ?");
    $stmt->execute([$id]);
    $habitat = $stmt->fetch();

    if (!$habitat) {
        die("Habitat introuvable.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $commentaire_habitat = $_POST['commentaire_habitat'];

    $stmt = $pdo->prepare("UPDATE habitat SET nom = ?, description = ?, commentaire_habitat = ? WHERE habitat_id = ?");
    $stmt->execute([$nom, $description, $commentaire_habitat, $id]);

    header('Location: Pages.ManageHabitats.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un habitat</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Modifier l'habitat</h1>
    <a href="Pages.ManageHabitats.php">Retour</a>
    <form method="POST">
        <label for="nom">Nom</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($habitat['nom']); ?>" required>

        <label for="description">Description</label>
        <textarea name="description" required><?php echo htmlspecialchars($habitat['description']); ?></textarea>

        <label for="commentaire_habitat">Commentaire</label>
        <textarea name="commentaire_habitat" required><?php echo htmlspecialchars($habitat['commentaire_habitat']); ?></textarea>

        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
