<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header('Location: Pages.Home.php');
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <form method="POST">
        <h2>Se connecter</h2>
        
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" required>
        
        <label for="password">Mot de passe</label>
        <input type="password" name="password" required>
        
        <button type="submit">Connexion</button>
        
        <p>Pas encore de compte ? <a href="Pages.Register.php">Inscrivez-vous ici</a>.</p>
    </form>
</body>
</html>
