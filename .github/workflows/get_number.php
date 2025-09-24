<?php
// === CONFIG ===
$orders_file = __DIR__ . "/orders.json";

// === Input ===
$email = $_GET['email'] ?? null;
$phone = $_GET['phone'] ?? null;

if (!$email && !$phone) {
    die("❌ Missing identifier. Provide ?email=... or ?phone=...");
}

if (!file_exists($orders_file)) {
    die("❌ No orders found.");
}
$orders = json_decode(file_get_contents($orders_file), true);

// === Find matching order ===
foreach ($orders as $order) {
    if (
        ($email && $order['customer']['email'] === $email) ||
        ($phone && $order['customer']['phone'] === $phone)
    ) {
        if ($order['status'] === "paid") {
            echo json_encode([
                "status" => "success",
                "phone_number" => $order['phone_number'],
                "activation_id" => $order['activation_id'],
                '<a href="get_numbers.php" class="btn btn-primary mt-4">Get Code</a'
            ]);
            exit;
        } elseif ($order['status'] === "pending_payment") {
            echo json_encode([
                "status" => "waiting_payment",
                "message" => "Please complete payment first."
            ]);
            exit;
        } elseif ($order['status'] === "paid_but_failed_to_get_number") {
            echo json_encode([
                "status" => "error",
                "message" => "Payment received but failed to fetch number.",
                "tiger_error" => $order['tiger_error'] ?? "unknown"
            ]);
            exit;
        }
    }
}

echo json_encode(["status" => "not_found"]);