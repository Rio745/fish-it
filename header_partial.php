<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helper.php';

// Hitung jumlah item di cart
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0;
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand fw-bold" href="index.php">OVER</a>

        <!-- Toggle (mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">Beranda</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="market.php">Market</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="article.php">Artikel</a>
                </li>

            </ul>

            <!-- AKSI BAGIAN KANAN -->
            <div class="d-flex align-items-center gap-3">

                <!-- Cart -->
                <a href="cart.php" class="btn btn-outline-dark position-relative">
                    Cart
                    <span class="badge bg-warning text-dark position-absolute top-0 start-100 translate-middle p-2 rounded-circle">
                        <?= $cart_count ?>
                    </span>
                </a>

                <!-- Login / Logout -->
                <?php if (is_logged_in()) : ?>
                    <span class="me-2">Halo, <strong><?= e($_SESSION['user']['name']) ?></strong></span>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                <?php else : ?>
                    <a href="login.php" class="btn btn-primary">Login</a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</nav>

<!-- Include Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>