<?php
session_start();

$phone = "2349012345678"; // Your WhatsApp number
$message = "Hello, I want to order:\n";

foreach ($_SESSION['cart'] as $item) {
    $message .= "- {$item['name']} (₦{$item['price']})\n";
}

$url = "https://wa.me/$phone?text=" . urlencode($message);

header("Location: $url");
exit();