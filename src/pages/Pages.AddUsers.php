<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}

$stmt = $pdo->prepare("SELECT role_id FROM possede WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user_role = $stmt->fetchColumn();

if ($user_role != 1) {
    die("Accès refusé.");
}

$stmt = $pdo->query("SELECT * FROM role");
$roles = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $role_id = $_POST['role_id'];

    $password_hashed = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO utilisateur (username, password, nom, prenom) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $password_hashed, $nom, $prenom]);

    if ($role_id) {
        $stmt = $pdo->prepare("INSERT INTO possede (username, role_id) VALUES (?, ?)");
        $stmt->execute([$username, $role_id]);
    }

    header('Location: Pages.ManageUsers.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Ajouter un utilisateur</h1>
    <a href="Pages.ManageUsers.php">Retour</a>
    <form method="POST">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" required>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" required>
        <label for="nom">Nom</label>
        <input type="text" name="nom" required>
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" required>
        <label for="role_id">Rôle</label>
        <select name="role_id">
            <option value="">Aucun</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['role_id']; ?>">
                    <?php echo htmlspecialchars($role['label']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
