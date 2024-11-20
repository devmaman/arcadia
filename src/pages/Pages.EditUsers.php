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

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    $stmt = $pdo->prepare("
        SELECT u.username, u.nom, u.prenom, p.role_id 
        FROM utilisateur u
        LEFT JOIN possede p ON u.username = p.username
        WHERE u.username = ?
    ");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user) {
        die("Utilisateur introuvable.");
    }
}

$stmt = $pdo->query("SELECT * FROM role");
$roles = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $role_id = $_POST['role_id'];

    $stmt = $pdo->prepare("UPDATE utilisateur SET nom = ?, prenom = ? WHERE username = ?");
    $stmt->execute([$nom, $prenom, $username]);

    $stmt = $pdo->prepare("DELETE FROM possede WHERE username = ?");
    $stmt->execute([$username]);

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
    <title>Modifier un utilisateur</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <h1>Modifier un utilisateur</h1>
    <a href="Pages.ManageUsers.php">Retour</a>
    <form method="POST">
        <label for="nom">Nom</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
        <label for="role_id">Rôle</label>
        <select name="role_id">
            <option value="">Aucun</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['role_id']; ?>" <?php echo $user['role_id'] == $role['role_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($role['label']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
