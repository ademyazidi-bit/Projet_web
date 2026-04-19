<?php
// login.php — Member 2 | Task 2
// Login form — calls loginUser(), sets $_SESSION['user'] on success

if (session_status() === PHP_SESSION_NONE) session_start();

// Already logged in → go to shop
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'auth_model.php';
    require_once 'validation.php';

    $email    = sanitize($_POST['email']    ?? '');
    $password = sanitize($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } elseif (!isValidEmail($email)) {
        $error = 'Adresse email invalide.';
    } else {
        $user = loginUser($email, $password);
        if ($user) {
            // Set session contract (shared structure)
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email']
            ];
            header('Location: index.php');
            exit();
        } else {
            $error = 'Email ou mot de passe incorrect.';
        }
    }
}

$registered = isset($_GET['registered']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechShop — Connexion</title>
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

    <h1 class="auth-title">Connexion</h1>

    <?php if ($registered): ?>
        <p class="auth-success">Compte créé avec succès ! Connectez-vous.</p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="auth-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php" class="auth-form">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   placeholder="votre@email.com" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password"
                   placeholder="Votre mot de passe" required>
        </div>

        <button type="submit" class="btn btn-primary btn-full">Se connecter</button>
    </form>

    <p class="auth-switch">
        Pas encore de compte ? <a href="register.php">S'inscrire</a>
    </p>
</div>

</body>
</html>
