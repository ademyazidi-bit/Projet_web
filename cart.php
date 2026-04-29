<?php

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$cart = $_SESSION['cart'] ?? [];
$grandTotal = 0;

foreach ($cart as $item) {
    $grandTotal += $item['price'] * $item['quantity'];
}

require_once 'header.php';
?>

<section class="cart-section">
    <div class="section-header">
        <h1 class="section-title">Mon Panier</h1>
    </div>

    <?php if (empty($cart)): ?>
        <div class="cart-empty">
            <p>Votre panier est vide.</p>
            <a href="index.php" class="btn btn-primary">Continuer mes achats</a>
        </div>
    <?php else: ?>
        <div class="cart-table-wrap">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Sous-total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $id => $item): ?>
                        <?php $subtotal = $item['price'] * $item['quantity']; ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= number_format($item['price'], 2) ?> TND</td>
                            <td>
                                <form action="update_cart.php" method="POST" style="display:inline">
                                    <input type="hidden" name="product_id" value="<?= (int)$id ?>">
                                    <input type="hidden" name="action" value="decrease">
                                    <button type="submit" class="btn btn-qty">−</button>
                                </form>

                                <span class="qty-display"><?= (int)$item['quantity'] ?></span>

                                <form action="update_cart.php" method="POST" style="display:inline">
                                    <input type="hidden" name="product_id" value="<?= (int)$id ?>">
                                    <input type="hidden" name="action" value="increase">
                                    <button type="submit" class="btn btn-qty">+</button>
                                </form>
                            </td>
                            <td><?= number_format($subtotal, 2) ?> TND</td>
                            <td>
                                <form action="remove_from_cart.php" method="POST" style="display:inline">
                                    <input type="hidden" name="product_id" value="<?= (int)$id ?>">
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Retirer ce produit ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td colspan="2"><strong><?= number_format($grandTotal, 2) ?> TND</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="cart-actions">
            <a href="index.php" class="btn btn-secondary">← Continuer mes achats</a>
            <a href="checkout.php" class="btn btn-primary">Commander →</a>
        </div>
    <?php endif; ?>
</section>

<?php require_once 'footer.php'; ?>