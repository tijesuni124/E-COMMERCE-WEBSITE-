<?php
// === CONFIG ===
$tiger_api_key = "dxUecc9xfg1CyKWlPDJRM2C21ywm5Aii"; 
$paystack_secret = "sk_test_ed4c582d1f8a7417d7d20bb06c47b631f142f056"; 
$paystack_public = "pk_test_fb8fe2bbca8e9e76f05bcf2a73bb55c624dfb688"; 

// === Step 0: Get input from order.php form ===
$service        = $_POST['service'] ?? null;
$country        = $_POST['country'] ?? null;
$email          = $_POST['email'] ?? null;
$customer_phone = $_POST['phone'] ?? null;

if (!$service || !$country || !$email) {
    die("❌ Missing required input");
}

// === Step 1: Get price from Tiger-SMS ===
$tiger_url = "https://api.tiger-sms.com/stubs/handler_api.php?api_key=$tiger_api_key&action=getPrices&service=$service&country=$country";

$ch = curl_init($tiger_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$tiger_json = curl_exec($ch);

if (curl_errno($ch)) {
    die("❌ Error fetching Tiger-SMS prices: " . curl_error($ch));
}
curl_close($ch);

$tiger_data = json_decode($tiger_json, true);

if (!is_array($tiger_data) || empty($tiger_data[$country][$service]['cost'])) {
    echo "<h3>⚠️ Raw Tiger-SMS Response</h3><pre>" . htmlspecialchars($tiger_json) . "</pre>";
    die("❌ Invalid Tiger-SMS price response.");
}

$usd_price   = $tiger_data[$country][$service]['cost'];
$naira_price = ($usd_price * 1500) + 1500; // conversion

// === Step 2: Initialize Paystack Transaction ===
$paystack_url = "https://api.paystack.co/transaction/initialize";

$payload = [
    "email" => $email,
    "amount" => $naira_price * 100, // Paystack expects kobo
    "currency" => "NGN",
    "callback_url" => "callback.php",
    "metadata" => [
        "service" => $service,
        "country" => $country,
        "phone"   => $customer_phone
    ]
];

$ch = curl_init($paystack_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $paystack_secret"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    die("❌ cURL Error connecting to Paystack: " . curl_error($ch));
}
curl_close($ch);

$res_data = json_decode($response, true);

// === Step 3: Save order locally ===
$orders_file = __DIR__ . "/orders.json";
$orders = file_exists($orders_file) ? json_decode(file_get_contents($orders_file), true) : [];

$order_entry = [
    "service"   => $service,
    "country"   => $country,
    "usd_price" => $usd_price,
    "naira_price" => $naira_price,
    "customer"  => [
        "email" => $email,
        "phone" => $customer_phone
    ],
    "paystack_response" => $res_data,
    "status"    => "pending_payment",
    "created_at" => date("c")
];

$orders[] = $order_entry;
file_put_contents($orders_file, json_encode($orders, JSON_PRETTY_PRINT));

// === Step 4: Redirect to Paystack Checkout ===
if (isset($res_data['status']) && $res_data['status'] === true && !empty($res_data['data']['authorization_url'])) {
    header("Location: " . $res_data['data']['authorization_url']);
    exit;
} else {
    echo "<h2>⚠️ Failed to Initialize Paystack Payment</h2>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
    file_put_contents(__DIR__ . "/paystack_errors.log", date("c") . " - " . $response . "\n", FILE_APPEND);
}