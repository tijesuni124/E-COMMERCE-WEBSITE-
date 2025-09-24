<?php
// === CONFIG ===
$tiger_api_key = "dxUecc9xfg1CyKWlPDJRM2C21ywm5Aii";
$paystack_secret = "sk_test_ed4c582d1f8a7417d7d20bb06c47b631f142f056"; 

// === Step 1: Read webhook JSON ===
$raw = file_get_contents("php://input");
$headers = getallheaders();
$signature = $headers['x-paystack-signature'] ?? $headers['X-Paystack-Signature'] ?? null;

// Verify signature
if (!$signature || $signature !== hash_hmac('sha512', $raw, $paystack_secret)) {
    http_response_code(401);
    die("❌ Invalid signature");
}

$data = json_decode($raw, true);
if (!$data) {
    http_response_code(400);
    die("❌ Invalid JSON");
}

// Debug logging
file_put_contents(__DIR__ . "/callback.log", date("c") . " RAW: " . $raw . PHP_EOL, FILE_APPEND);

// === Step 2: Verify event type ===
if (($data['event'] ?? '') !== "charge.success") {
    http_response_code(200);
    echo "⚠️ Not a successful charge event, ignored.";
    exit;
}

// === Step 3: Re-verify with Paystack API ===
$reference = $data['data']['reference'] ?? null;
if (!$reference) {
    http_response_code(400);
    die("❌ Missing reference");
}

$ch = curl_init("https://api.paystack.co/transaction/verify/" . urlencode($reference));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $paystack_secret"
]);
$verify_response = curl_exec($ch);
curl_close($ch);

$verify_data = json_decode($verify_response, true);

if (
    !$verify_data ||
    !isset($verify_data['data']['status']) ||
    $verify_data['data']['status'] !== "success"
) {
    http_response_code(400);
    die("❌ Paystack verification failed");
}

// === Step 4: Extract customer & metadata ===
$customer_email = $verify_data['data']['customer']['email'] ?? null;
$metadata = $verify_data['data']['metadata'] ?? [];
$customer_phone = $metadata['phone'] ?? null;
$service = $metadata['service'] ?? null;
$country = $metadata['country'] ?? null;

if (!$customer_email) {
    http_response_code(400);
    die("❌ Missing customer identifiers");
}

// === Step 5: Load orders.json ===
$orders_file = __DIR__ . "/orders.json";
if (!file_exists($orders_file)) {
    http_response_code(404);
    die("❌ No orders found.");
}
$orders = json_decode(file_get_contents($orders_file), true);

// === Step 6: Find matching order ===
$found = false;
foreach ($orders as &$order) {
    if (
        ($order['customer']['email'] === $customer_email) ||
        ($customer_phone && $order['customer']['phone'] === $customer_phone)
    ) {
        if ($order['status'] === "pending_payment") {
            $found = true;

            // === Step 7: Call Tiger-SMS getNumber ===
            $url = "https://api.tiger-sms.com/stubs/handler_api.php?" . http_build_query([
                "api_key" => $tiger_api_key,
                "action"  => "getNumber",
                "service" => $service,
                "country" => $country
            ]);

            $resp = file_get_contents($url);
            file_put_contents(__DIR__ . "/callback.log", date("c") . " TigerResp: " . $resp . PHP_EOL, FILE_APPEND);

            if (strpos($resp, "ACCESS_NUMBER") === 0) {
                // Example: ACCESS_NUMBER:activation_id:phone
                $parts = explode(":", $resp);
                $activation_id = $parts[1] ?? null;
                $phone_number  = $parts[2] ?? null;

                $order['status'] = "paid";
                $order['activation_id'] = $activation_id;
                $order['phone_number']  = $phone_number;
            } else {
                $order['status'] = "paid_but_failed_to_get_number";
                $order['tiger_error'] = $resp;
            }
        }
    }
}
unset($order);

// === Step 8: Save back ===
file_put_contents($orders_file, json_encode($orders, JSON_PRETTY_PRINT));

http_response_code(200);
echo "✅ Paystack Callback processed and verified.";