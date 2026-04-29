<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$productId    = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$productName  = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_SPECIAL_CHARS);
$productPrice = filter_input(INPUT_POST, 'product_price', FILTER_VALIDATE_FLOAT);
$quantity     = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

if (!$productId || !$productName || $productPrice === false || !$quantity || $quantity < 1) {
    $_SESSION['flash'] = [
        'type'    => 'error',
        'message' => 'Données invalides. Veuillez réessayer.'
    ];
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]['quantity'] += $quantity;

    $_SESSION['flash'] = [
        'type'    => 'success',
        'message' => '✓ Quantité mise à jour pour "' . $productName . '".'
    ];
} else {
    $_SESSION['cart'][$productId] = [
        'id'       => $productId,
        'name'     => $productName,
        'price'    => $productPrice,
        'quantity' => $quantity
    ];

    $_SESSION['flash'] = [
        'type'    => 'success',
        'message' => '✓ "' . $productName . '" ajouté au panier.'
    ];
}

header('Location: index.php');
exit;