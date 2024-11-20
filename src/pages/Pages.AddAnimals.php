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
    $race = $_POST['race'];
    $etat = $_POST['etat'];
    $habitat_id = $_POST['habitat_id'];
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

    $stmt = $pdo->prepare("
        INSERT INTO animal (prenom, race, etat, habitat_id, image_path)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$prenom, $race, $etat, $habitat_id, $image_path]);

    header('Location: Pages.ManageAnimals.php');
    exit();
}

$habitats = $pdo->query("SELECT habitat_id, nom FROM habitat")->fetchAll();
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
        <input type="text" name="prenom" id="prenom" required>

        <label for="race">Race de l'animal</label>
        <input type="text" name="race" id="race" required>

        <label for="etat">État de l'animal</label>
        <textarea name="etat" id="etat" rows="4" required></textarea>

        <label for="habitat_id">Habitat</label>
        <select name="habitat_id" id="habitat_id" required>
            <option value="">-- Sélectionnez un habitat --</option>
            <?php foreach ($habitats as $habitat): ?>
                <option value="<?php echo $habitat['habitat_id']; ?>">
                    <?php echo htmlspecialchars($habitat['nom']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="image">Image de l'animal</label>
        <input type="file" name="image" id="image">

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>