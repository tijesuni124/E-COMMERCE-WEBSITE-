<?php
$API_KEY = "dxUecc9xfg1CyKWlPDJRM2C21ywm5Aii";

// Load hardcoded countries & services
include 'countries.php';
include 'services.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Virtual Number</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h2>Choose Your Service & Country</h2>
        <form action="create_va.php" method="POST" class="mt-3">

            <!-- Service Dropdown -->
            <div class="mb-3">
                <label for="service" class="form-label">Service</label>
                <select name="service" id="service" class="form-control" required>
                    <?php foreach ($services as $key => $srv): ?>
                    <option value="<?= $key ?>"><?= $srv ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Country Dropdown -->
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <select name="country" id="country" class="form-control" required>
                    <?php foreach ($countries as $id => $name): ?>
                    <option value="<?= $id ?>"><?= $name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <!-- Phone (optional) -->
            <div class="mb-3">
                <label for="phone" class="form-label">Your Phone (optional)</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Continue to Payment</button>
        </form>
    </div>
</body>

</html>