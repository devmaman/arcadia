<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <header class="header-home">
        <h1>Bienvenue au Zoo Arcadia</h1>
    </header>

    <main class="home-container">
        <h2>Bonjour, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h2>
        <p class="welcome-text">
            Vous êtes connecté à votre espace personnel. Explorez les fonctionnalités disponibles et découvrez tout ce que le Zoo Arcadia a à offrir !
        </p>
        <a href="../includes/Includes.Logout.php" class="btn btn-danger">Déconnexion</a>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Zoo Arcadia. Tous droits réservés.</p>
    </footer>
</body>
</html>