<?php
// === CONFIG ===
$tiger_api_key = "dxUecc9xfg1CyKWlPDJRM2C21ywm5Aii";
$orders_file = __DIR__ . "/orders.json";

// === Input ===
$activation_id = $_GET['activation_id'] ?? null;


// === Step 1: Call Tiger-SMS getStatus ===
$url = "https://tiger-sms.shop/stubs/handler_api.php?" . http_build_query([
    "api_key" => $tiger_api_key,
    "action"  => "getStatus",
    "id"      => $activation_id
]);

$response = file_get_contents($url);

if (!$response) {
    die("❌ Error contacting Tiger-SMS");
}

// === Step 2: Handle response ===
if (strpos($response, "STATUS_OK") === 0) {
    // Example: STATUS_OK:1234
    $parts = explode(":", $response);
    $code = $parts[1] ?? null;

    if (file_exists($orders_file)) {
        $orders = json_decode(file_get_contents($orders_file), true);
        $new_orders = [];

        foreach ($orders as $order) {
            if (($order['activation_id'] ?? null) === $activation_id) {
                // ✅ Mark as completed, but do not keep in file
                file_put_contents(__DIR__ . "/used_orders.log", date("c") . " USED: " . json_encode($order) . PHP_EOL, FILE_APPEND);
            } else {
                $new_orders[] = $order; // keep others
            }
        }

        // Save only active orders
        file_put_contents($orders_file, json_encode($new_orders, JSON_PRETTY_PRINT));
    }

    echo json_encode([
        "status" => "success",
        "code" => $code
    ]);
} elseif ($response === "STATUS_WAIT_CODE") {
    echo json_encode([
        "status" => "waiting",
        "message" => "Waiting for SMS code..."
    ]);
} elseif ($response === "STATUS_CANCEL") {
    echo json_encode([
        "status" => "failed",
        "message" => "Activation was cancelled."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "raw_response" => $response
    ]);
}