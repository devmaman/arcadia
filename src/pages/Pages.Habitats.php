<?php
session_start();
require_once '../includes/Includes.MySQL.php';

$stmt = $pdo->query("SELECT habitat_id, nom, description, image_path FROM habitat");
$habitats = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitats</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <header>
        <h1>Nos habitats</h1>
    </header>

    <nav class="menu">
        <a href="../index.php">Accueil</a>
        <a href="Pages.Services.php">Services</a>
        <a href="Pages.Habitats.php">Habitats</a>
        <a href="Pages.Login.php">Connexion</a>
        <a href="Pages.Contact.php">Contact</a>
    </nav>

    <main class="container">
        <h2>Explorez nos habitats</h2>
        <p>Découvrez les habitats soigneusement conçus pour nos animaux.</p>

        <div class="habitats">
            <?php foreach ($habitats as $habitat): ?>
                <div class="card">
                    <?php if ($habitat['image_path']): ?>
                        <img src="..<?php echo $habitat['image_path']; ?>" alt="Image de l'habitat <?php echo htmlspecialchars($habitat['nom']); ?>">
                    <?php else: ?>
                        <div class="no-image">Aucune image disponible</div>
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($habitat['nom']); ?></h3>
                    <p><?php echo htmlspecialchars($habitat['description']); ?></p>
                    <a href="Pages.HabitatsDetails.php?id=<?php echo $habitat['habitat_id']; ?>" class="btn btn-primary">Voir les détails</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Zoo Arcadia. Tous droits réservés. <a href="Pages.Contact.php">Contactez-nous</a></p>
    </footer>
</body>
</html>
