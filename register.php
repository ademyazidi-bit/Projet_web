<?php
// register.php — Member 2 | Task 1
// Registration form — calls registerUser() from auth_model.php

if (session_status() === PHP_SESSION_NONE) session_start();

// Already logged in → go to shop
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'auth_model.php';
    require_once 'validation.php';

    $name     = sanitize($_POST['name']     ?? '');
    $email    = sanitize($_POST['email']    ?? '');
    $password = sanitize($_POST['password'] ?? '');

    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Tous les champs sont obligatoires.';
    } elseif (!isValidEmail($email)) {
        $error = 'Adresse email invalide.';
    } elseif (strlen($password) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères.';
    } else {
        $result = registerUser($name, $email, $password);
        if ($result === true) {
            header('Location: login.php?registered=1');
            exit();
        } else {
            $error = $result; // error message returned by registerUser()
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechShop — Inscription</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body class="auth-body">

<div class="auth-card">
    <div class="auth-logo">
        <span class="logo-icon">⬡</span>
        <span class="logo-text">Tech<strong>Shop</strong></span>
    </div>

    <h1 class="auth-title">Créer un compte</h1>

    <?php if ($error): ?>
        <p class="auth-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="register.php" class="auth-form" id="form-register" novalidate>
        <div class="form-group">
            <label for="name">Nom complet</label>
            <input type="text" id="name" name="name"
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                   placeholder="Votre nom" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   placeholder="votre@email.com" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password"
                   placeholder="Minimum 6 caractères" required>
        </div>

        <button type="submit" class="btn btn-primary btn-full">S'inscrire</button>
    </form>

    <p class="auth-switch">
        Déjà un compte ? <a href="login.php">Se connecter</a>
    </p>
</div>

<script src="validation.js"></script>
</body>
</html>
