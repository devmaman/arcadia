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

if ($user_role != 0) {
    die("Accès refusé.");
}

$stats = [
    'total_animals' => $pdo->query("SELECT COUNT(*) FROM animal")->fetchColumn(),
    'total_habitats' => $pdo->query("SELECT COUNT(*) FROM habitat")->fetchColumn(),
    'total_users' => $pdo->query("SELECT COUNT(*) FROM utilisateur")->fetchColumn(),
];

$animal_views = $pdo->query("
    SELECT animal.prenom, COUNT(*) AS views 
    FROM animal 
    GROUP BY animal.animal_id 
    ORDER BY views DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../assets/Main.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Tableau de bord</h1>
    <a href="logout.php">Déconnexion</a>

    <section>
        <h2>Navigation</h2>
        <ul>
            <li><a href="Pages.ManageAnimals.php">Gérer les animaux</a></li>
            <li><a href="Pages.ManageHabitats.php">Gérer les habitats</a></li>
            <li><a href="Pages.ManageUsers.php">Gérer les utilisateurs</a></li>
            <li><a href="Pages.ManageRoles.php">Gérer les rôles</a></li>
        </ul>
    </section>

    <section>
        <h2>Statistiques générales</h2>
        <ul>
            <li>Nombre total d'animaux : <?php echo $stats['total_animals']; ?></li>
            <li>Nombre total d'habitats : <?php echo $stats['total_habitats']; ?></li>
            <li>Nombre total d'utilisateurs : <?php echo $stats['total_users']; ?></li>
        </ul>
    </section>

    <script>
        const ctx = document.getElementById('animalChart').getContext('2d');
        const animalChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($animal_views, 'prenom')); ?>,
                datasets: [{
                    label: 'Nombre de consultations',
                    data: <?php echo json_encode(array_column($animal_views, 'views')); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
