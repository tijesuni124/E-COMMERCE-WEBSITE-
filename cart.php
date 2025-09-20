<?php
session_start();
include("includes/header.php");

echo "<h2 class='mb-4'>Your Cart</h2>";

if (!empty($_SESSION['cart'])) {
    echo "<ul class='list-group mb-3'>";
    foreach ($_SESSION['cart'] as $index => $item) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                {$item['name']} - ₦{$item['price']}
                <a href='remove-item.php?index=$index' class='btn btn-sm btn-danger'>Remove</a>
              </li>";
    }
    echo "</ul>";
    echo "<a href='order.php' class='btn btn-primary btn-lg'>Place Order on WhatsApp</a>";
} else {
    echo "<p class='alert alert-warning'>Your cart is empty</p>";
}

include("includes/footer.php");
?>