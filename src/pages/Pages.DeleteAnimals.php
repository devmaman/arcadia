<?php
session_start();
require_once '../includes/Includes.MySQL.php';

if (!isset($_SESSION['username'])) {
    header('Location: Pages.Login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM animal WHERE animal_id = ?");
    $stmt->execute([$id]);

    header('Location: Pages.ManageAnimals.php');
    exit();
}
?>