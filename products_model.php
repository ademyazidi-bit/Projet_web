<?php
require_once 'bd.php';

function getAllProducts() {
    global $pdo; 

    $stmt = $pdo->query("SELECT * FROM produits ORDER BY id ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>