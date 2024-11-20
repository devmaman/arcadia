<?php
session_start();
require_once '../includes/Includes.Mail.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Tous les champs sont obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'L\'adresse email est invalide.';
    } else {
        $to = ZOO_EMAIL;
        $headers = "From: $email\r\nReply-To: $email\r\n";
        $body = "Nom : $name\nEmail : $email\n\nMessage :\n$message";

        if (mail($to, $subject, $body, $headers)) {
            $success = 'Votre message a été envoyé avec succès. Merci de nous avoir contactés.';
        } else {
            $error = 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer plus tard.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="../assets/Main.css">
</head>
<body>
    <header>
        <h1>Contactez-nous</h1>
    </header>

    <nav class="menu">
        <a href="../index.php">Accueil</a>
        <a href="Pages.Services.php">Services</a>
        <a href="Pages.Habitats.php">Habitats</a>
        <a href="Pages.Login.php">Connexion</a>
        <a href="Pages.Contact.php">Contact</a>
    </nav>

    <main class="container">
        <h2>Nous sommes là pour vous aider</h2>
        <p>Si vous avez des questions, n'hésitez pas à nous envoyer un message en remplissant le formulaire ci-dessous.</p>

        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Adresse email</label>
            <input type="email" name="email" id="email" required>

            <label for="subject">Sujet</label>
            <input type="text" name="subject" id="subject" required>

            <label for="message">Message</label>
            <textarea name="message" id="message" rows="5" required></textarea>

            <button type="submit">Envoyer</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Zoo Arcadia. Tous droits réservés. <a href="Pages.Contact.php">Contactez-nous</a></p>
    </footer>
</body>
</html>
