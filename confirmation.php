<?php
// confirmation.php — shown after successful checkout

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$orderId = $_SESSION['last_order_id'] ?? null;
unset($_SESSION['last_order_id']);

require_once 'header.php';
?>

<section class="confirmation-section">
    <div class="confirmation-card">
        <div class="confirmation-icon">✅</div>
        <h1>Commande confirmée !</h1>
        <?php if ($orderId): ?>
            <p>Votre commande <strong>#<?= (int)$orderId ?></strong> a bien été enregistrée.</p>
        <?php else: ?>
            <p>Votre commande a bien été enregistrée.</p>
        <?php endif; ?>
        <a href="index.php" class="btn btn-primary">Retour au catalogue</a>
    </div>
</section>

<?php require_once 'footer.php'; ?>
