<?php
// remove_from_cart.php — Task 3
// Unset a product from $_SESSION['cart'] by product_id

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cart.php');
    exit();
}

$productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

if (!$productId || !isset($_SESSION['cart'][$productId])) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Produit introuvable.'];
    header('Location: cart.php');
    exit();
}

$name = $_SESSION['cart'][$productId]['name'];
unset($_SESSION['cart'][$productId]);

$_SESSION['flash'] = ['type' => 'success', 'message' => '✓ "' . $name . '" supprimé du panier.'];
header('Location: cart.php');
exit();
