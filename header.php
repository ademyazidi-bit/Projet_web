<?php

if (session_status() === PHP_SESSION_NONE) session_start();

$cartCount = 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += (int)$item['quantity'];
    }
}

$currentPage = basename($_SERVER['PHP_SELF']);
$userName = $_SESSION['user']['name'] ?? 'Invité';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechShop</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>

<header class="site-header">
    <nav class="navbar">

        <a href="index.php" class="nav-logo">
            <span class="logo-icon">⬡</span>
            <span class="logo-text">Tech<strong>Shop</strong></span>
        </a>

        <div class="nav-right">

            <span class="nav-username">👤 <?= htmlspecialchars($userName) ?></span>

            <a href="cart.php" class="nav-link <?= $currentPage === 'cart.php' ? 'active' : '' ?>">
                🛒 Panier
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>

            <a href="logout.php" class="btn btn-logout">Déconnexion</a>

        </div>
    </nav>
</header>

<?php if (!empty($_SESSION['flash'])): ?>
    <div class="flash-message flash-<?= htmlspecialchars($_SESSION['flash']['type']) ?>">
        <?= htmlspecialchars($_SESSION['flash']['message']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<main class="main-content">