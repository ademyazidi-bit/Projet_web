<?php
// add_to_cart.php — Member 2
// Handles POST from index.php product cards
// Adds a product to $_SESSION['cart'] or increments quantity if already present
//
// SESSION STRUCTURE (agreed by team):
// $_SESSION['cart'] = [
//     product_id => [
//         'id'       => int,
//         'name'     => string,
//         'price'    => float,
//         'quantity' => int
//     ],
//     ...
// ]

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// ── 1. Collect & validate input ──────────────────────────────────────────────

$productId    = filter_input(INPUT_POST, 'product_id',    FILTER_VALIDATE_INT);
$productName  = filter_input(INPUT_POST, 'product_name',  FILTER_SANITIZE_SPECIAL_CHARS);
$productPrice = filter_input(INPUT_POST, 'product_price', FILTER_VALIDATE_FLOAT);
$quantity     = filter_input(INPUT_POST, 'quantity',      FILTER_VALIDATE_INT);

// Basic validation
if (!$productId || !$productName || $productPrice === false || !$quantity || $quantity < 1) {
    $_SESSION['flash'] = [
        'type'    => 'error',
        'message' => 'Données invalides. Veuillez réessayer.'
    ];
    header('Location: index.php');
    exit;
}

// ── 2. Initialize cart if it doesn't exist ───────────────────────────────────

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ── 3. Add or update the product in the cart ─────────────────────────────────

if (isset($_SESSION['cart'][$productId])) {
    // Product already in cart → increment quantity
    $_SESSION['cart'][$productId]['quantity'] += $quantity;

    $_SESSION['flash'] = [
        'type'    => 'success',
        'message' => '✓ Quantité mise à jour pour "' . $productName . '".'
    ];
} else {
    // New product → add entry
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

// ── 4. Redirect back to product listing ──────────────────────────────────────

header('Location: index.php');
exit;
