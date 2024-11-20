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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM role WHERE role_id = ?");
    $stmt->execute([$id]);

    header('Location: Pages.ManageRoles.php');
    exit();
}
?>
