<?php
// checkout.php — Task 5
// Login guard + insert into commandes + insert each item into articles_commande
// + clear cart + redirect to confirmation.php

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Votre panier est vide.'];
    header('Location: cart.php');
    exit();
}

require_once 'bd.php';

try {
    $pdo->beginTransaction();

    // 1. Insert the order
    $userId = (int)$_SESSION['user']['id'];
    $stmt = $pdo->prepare("INSERT INTO commandes (utilisateur_id) VALUES (:uid) RETURNING id");
    $stmt->execute([':uid' => $userId]);
    $orderId = $stmt->fetchColumn();

    // 2. Insert each cart item into articles_commande
    $stmtItem = $pdo->prepare(
        "INSERT INTO articles_commande (commande_id, produit_id, quantite, prix_unitaire)
         VALUES (:commande_id, :produit_id, :quantite, :prix_unitaire)"
    );

    foreach ($cart as $item) {
        $stmtItem->execute([
            ':commande_id'   => $orderId,
            ':produit_id'    => (int)$item['id'],
            ':quantite'      => (int)$item['quantity'],
            ':prix_unitaire' => (float)$item['price'],
        ]);
    }

    $pdo->commit();

    // 3. Clear the cart
    $_SESSION['cart'] = [];
    $_SESSION['last_order_id'] = $orderId;

    header('Location: confirmation.php');
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = [
        'type'    => 'error',
        'message' => 'Erreur lors de la commande. Veuillez réessayer.'
    ];
    header('Location: cart.php');
    exit();
}
