<?php
session_start();
require_once '../includes/Includes.MySQL.php';

$stmt = $pdo->query("SELECT nom, description FROM service");
$services = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <header>
        <h1>Nos services</h1>
    </header>

    <nav class="menu">
        <a href="../index.php">Accueil</a>
        <a href="Pages.Services.php">Services</a>
        <a href="Pages.Habitats.php">Habitats</a>
        <a href="Pages.Login.php">Connexion</a>
        <a href="Pages.Contact.php">Contact</a>
    </nav>

    <main class="container">
        <h2>Découvrez nos services</h2>
        <p>Voici la liste des services que nous proposons.</p>

        <div class="services">
            <?php foreach ($services as $service): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($service['nom']); ?></h3>
                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Zoo Arcadia. Tous droits réservés. <a href="Pages.Contact.php">Contactez-nous</a></p>
    </footer>
</body>
</html>