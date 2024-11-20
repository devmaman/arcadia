<?php
session_start();
require_once '../includes/Includes.MySQL.php';
require_once '../includes/Includes.Images.php';

if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $commentaire_habitat = $_POST['commentaire_habitat'];
    $image_path = null;

    if (!empty($_FILES['image']['name'])) {
        if ($_FILES['image']['size'] > MAX_FILE_SIZE) {
            die("Le fichier est trop volumineux.");
        }

        if (!in_array($_FILES['image']['type'], ALLOWED_FILE_TYPES)) {
            die("Type de fichier non autorisé.");
        }

        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $image_path = UPLOAD_DIR . $image_name;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            die("Erreur lors du téléversement de l'image.");
        }

        $image_path = '/uploads/' . $image_name;
    }

    $stmt = $pdo->prepare("INSERT INTO habitat (nom, description, commentaire_habitat, image_path) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $description, $commentaire_habitat, $image_path]);

    header('Location: Pages.ManageHabitats.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un habitat</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Ajouter un habitat</h1>
    <a href="Pages.ManageHabitats.php">Retour</a>
    <form method="POST" enctype="multipart/form-data">
        <label for="nom">Nom</label>
        <input type="text" name="nom" required>

        <label for="description">Description</label>
        <textarea name="description" required></textarea>

        <label for="commentaire_habitat">Commentaire</label>
        <textarea name="commentaire_habitat" required></textarea>

        <label for="image">Image</label>
        <input type="file" name="image">

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>