<?php
session_start();

$data = json_decode(file_get_contents("products.json"), true);
$allProducts = [];
foreach ($data['products'] as $cat => $items) {
    foreach ($items as $p) {
        $allProducts[$p['id']] = $p;
    }
}

$id = $_GET['id'];
if (isset($allProducts[$id])) {
    $_SESSION['cart'][] = $allProducts[$id];
}

header("Location: cart.php");
exit();