<?php
// index.php — Member 2 | Task 4 + 5
// Product listing page — login guard + grid + Add to Cart buttons

// ── Login guard ───────────────────────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// ── Load products ─────────────────────────────────────────────────────────────
require_once 'products_model.php';
$products = getAllProducts();

require_once 'header.php';
?>

<section class="products-section">
    <div class="section-header">
        <h1 class="section-title">Catalogue</h1>
        <p class="section-subtitle"><?= count($products) ?> produits disponibles</p>
    </div>

    <div class="products-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card <?= (int)$product['stock'] === 0 ? 'out-of-stock' : '' ?>">

                <!-- Product Image — Member 4 will style this -->
                <?php if (!empty($product['url_image'])): ?>
                    <div class="product-image-wrap">
                        <img
                            src="<?= htmlspecialchars($product['url_image']) ?>"
                            alt="<?= htmlspecialchars($product['nom']) ?>"
                            class="product-image"
                        >
                    </div>
                <?php endif; ?>

                <!-- Product Info -->
                <div class="product-info">
                    <h3 class="product-name"><?= htmlspecialchars($product['nom']) ?></h3>
                    <p class="product-price"><?= number_format((float)$product['prix'], 2) ?> TND</p>

                    <?php if ((int)$product['stock'] === 0): ?>
                        <p class="stock-label out">Rupture de stock</p>
                    <?php elseif ((int)$product['stock'] <= 5): ?>
                        <p class="stock-label low">Plus que <?= (int)$product['stock'] ?> restants</p>
                    <?php endif; ?>
                </div>

                <!-- Task 5 — Add to Cart button (POST to add_to_cart.php — Member 3) -->
                <?php if ((int)$product['stock'] > 0): ?>
                    <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                        <input type="hidden" name="product_id"    value="<?= (int)$product['id'] ?>">
                        <input type="hidden" name="product_name"  value="<?= htmlspecialchars($product['nom']) ?>">
                        <input type="hidden" name="product_price" value="<?= (float)$product['prix'] ?>">
                        <input type="hidden" name="quantity"      value="1">
                        <button type="submit" class="btn btn-primary">+ Ajouter au panier</button>
                    </form>
                <?php else: ?>
                    <button class="btn btn-disabled" disabled>Indisponible</button>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once 'footer.php'; ?>
