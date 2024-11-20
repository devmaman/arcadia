<?php
session_start();
require_once '../includes/Includes.MySQL.php';
require_once '../includes/Includes.Images.php';

if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $etat = $_POST['etat'];
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

    $stmt = $pdo->prepare("INSERT INTO animal (prenom, etat, image_path) VALUES (?, ?, ?)");
    $stmt->execute([$prenom, $etat, $image_path]);

    header('Location: Pages.ManageAnimals.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un animal</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Ajouter un animal</h1>
    <a href="Pages.ManageAnimals.php">Retour</a>
    <form method="POST" enctype="multipart/form-data">
        <label for="prenom">Prénom de l'animal</label>
        <input type="text" name="prenom" required>

        <label for="etat">État de l'animal</label>
        <input type="text" name="etat" required>

        <label for="image">Image</label>
        <input type="file" name="image">

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
