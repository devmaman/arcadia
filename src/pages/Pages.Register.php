<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        $error = "Nom d'utilisateur déjà utilisé. Veuillez en choisir un autre.";
    } else {
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO utilisateur (username, password, nom, prenom) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $password_hashed, $nom, $prenom]);

        header('Location: Pages.Login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <form method="POST">
        <h2>Créer un compte</h2>
        
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" required>
        
        <label for="password">Mot de passe</label>
        <input type="password" name="password" required>
        
        <label for="nom">Nom</label>
        <input type="text" name="nom" required>
        
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" required>
        
        <button type="submit">S'inscrire</button>
        
        <p>Vous avez déjà un compte ? <a href="Pages.Login.php">Connectez-vous ici</a>.</p>
    </form>
</body>
</html>
