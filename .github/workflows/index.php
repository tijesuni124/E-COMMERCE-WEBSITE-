<?php // index.php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>GlobalDigits - Virtual Phone Numbers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Hero */
    .hero {
        background: linear-gradient(rgba(0, 70, 150, 0.75), rgba(0, 70, 150, 0.75)),
            url('https://source.unsplash.com/1600x900/?phone,sms,sim') center/cover no-repeat;
        color: #fff;
        padding: 100px 20px;
    }

    /* Features */
    .feature-icon {
        font-size: 2.5rem;
        color: #0d6efd;
        margin-bottom: 15px;
    }

    /* Services chips */
    .services span {
        background: #fff;
        padding: 10px 15px;
        border-radius: 30px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        font-weight: 500;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .services img {
        height: 20px;
        width: 20px;
        object-fit: contain;
    }

    /* Footer */
    footer {
        background: #0d6efd;
        color: #fff;
        padding: 20px 0;
    }

    footer a {
        color: #ffc107;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                GlobalDigits
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="order.php">Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero text-center">
        <h1 class="display-5 fw-bold">Get Virtual Phone Numbers Instantly</h1>
        <p class="lead">Receive SMS verification codes from WhatsApp, Telegram, Instagram, and 100+ other services.</p>
        <a href="order.php"
            class="btn btn-warning btn-lg mt-3 d-flex align-items-center justify-content-center gap-2 mx-auto"
            style="max-width: 280px;">
            <i class="bi bi-phone"></i>
            <span>Get Started Now</span>
        </a>
    </div>

    <!-- Features Section -->
    <div id="features" class="container my-5">
        <h2 class="text-center mb-5 fw-bold">Why Choose GlobalDigits?</h2>
        <div class="row text-center g-4">
            <div class="col-md-4">
                <i class="bi bi-phone feature-icon"></i>
                <h5>Real Numbers</h5>
                <p>Get actual phone numbers from real carriers. No fake or unusable numbers.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-shield-lock feature-icon"></i>
                <h5>Completely Anonymous</h5>
                <p>Your privacy is protected. No personal info required, just an email.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-lightning-charge feature-icon"></i>
                <h5>Instant Delivery</h5>
                <p>Numbers are ready within seconds. No waiting, no delays.</p>
            </div>
        </div>
    </div>

    <!-- Supported Services -->
    <div id="services" class="bg-light py-5">
        <div class="container text-center">
            <h2 class="mb-4 fw-bold">Works with 100+ Services</h2>
            <p class="mb-4">Get verification codes for all major platforms and services.</p>
            <div class="d-flex flex-wrap justify-content-center gap-3 services">
                <span><img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp"> WhatsApp</span>
                <span><img src="https://cdn-icons-png.flaticon.com/512/2111/2111646.png" alt="Telegram"> Telegram</span>
                <span><img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram">
                    Instagram</span>
                <span><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook"> Facebook</span>
                <span><img src="https://cdn-icons-png.flaticon.com/512/3046/3046120.png" alt="TikTok"> TikTok</span>
                <span><img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" alt="Twitter"> Twitter</span>
            </div>
            <a href="order.php"
                class="btn btn-primary mt-4 d-flex align-items-center justify-content-center gap-2 mx-auto"
                style="max-width: 250px;">
                <i class="bi bi-key"></i> Get Your Number Now
            </a>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="text-center bg-primary text-white py-5">
        <h2 class="fw-bold">Ready to Get Started?</h2>
        <p>Join thousands of customers who trust <strong>GlobalDigits</strong>.</p>
        <a href="order.php" class="btn btn-light btn-lg d-flex align-items-center justify-content-center gap-2 mx-auto"
            style="max-width: 280px;">
            <i class="bi bi-phone-vibrate"></i> Get Your Number Now
        </a>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <p class="mb-0">&copy; <?php echo date("Y"); ?> GlobalDigits. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>