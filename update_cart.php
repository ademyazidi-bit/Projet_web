<?php

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
$action = $_POST['action'] ?? '';

if (!$productId || !in_array($action, ['increase', 'decrease'])) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Requête invalide.'
    ];
    header('Location: cart.php');
    exit();
}

if (!isset($_SESSION['cart'][$productId])) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Produit introuvable dans le panier.'
    ];
    header('Location: cart.php');
    exit();
}

if ($action === 'increase') {
    $_SESSION['cart'][$productId]['quantity']++;

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => '✓ Quantité augmentée.'
    ];
} else {
    $_SESSION['cart'][$productId]['quantity']--;

    if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
        $name = $_SESSION['cart'][$productId]['name'];
        unset($_SESSION['cart'][$productId]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => '✓ "' . $name . '" retiré du panier.'
        ];
    } else {
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => '✓ Quantité diminuée.'
        ];
    }
}

header('Location: cart.php');
exit();