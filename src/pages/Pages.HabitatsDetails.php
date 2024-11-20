<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if (!isset($_GET['id'])) {
    header('Location: Pages.Habitats.php');
    exit();
}

$habitat_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT nom, description, image_path FROM habitat WHERE habitat_id = ?");
$stmt->execute([$habitat_id]);
$habitat = $stmt->fetch();

if (!$habitat) {
    die("Habitat introuvable.");
}

$stmt = $pdo->prepare("SELECT prenom, race, image_path FROM animal WHERE habitat_id = ?");
$stmt->execute([$habitat_id]);
$animals = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'habitat</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($habitat['nom']); ?></h1>
    </header>

    <nav class="menu">
        <a href="../index.php">Accueil</a>
        <a href="Pages.Services.php">Services</a>
        <a href="Pages.Habitats.php">Habitats</a>
        <a href="Pages.Login.php">Connexion</a>
        <a href="Pages.Contact.php">Contact</a>
    </nav>

    <main class="container">
        <h2><?php echo htmlspecialchars($habitat['nom']); ?></h2>
        <?php if ($habitat['image_path']): ?>
            <img src="..<?php echo $habitat['image_path']; ?>" alt="Image de <?php echo htmlspecialchars($habitat['nom']); ?>">
        <?php endif; ?>
        <p><?php echo htmlspecialchars($habitat['description']); ?></p>

        <h3>Les animaux de cet habitat</h3>
        <div class="animals">
            <?php foreach ($animals as $animal): ?>
                <div class="card">
                    <?php if ($animal['image_path']): ?>
                        <img src="..<?php echo $animal['image_path']; ?>" alt="Image de <?php echo htmlspecialchars($animal['prenom']); ?>">
                    <?php endif; ?>
                    <h4><?php echo htmlspecialchars($animal['prenom']); ?></h4>
                    <p>Race : <?php echo htmlspecialchars($animal['race']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Zoo Arcadia. Tous droits réservés. <a href="Pages.Contact.php">Contactez-nous</a></p>
    </footer>
</body>
</html>
