<?php
require 'config.php';
require 'helper.php';

// Pastikan user sudah login untuk melihat riwayat
if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

// Query untuk mengambil riwayat belanja user dengan JOIN ke tabel products
// Mengambil data dari order_items berdasarkan order_id yang dimiliki user di tabel orders
$sql = "SELECT oi.*, p.title, p.image, o.created_at as order_date, o.payment_method 
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        JOIN orders o ON oi.order_id = o.id
        WHERE o.user_id = ?
        ORDER BY o.created_at DESC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$res = $stmt->get_result();
$history = $res->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Riwayat Pesanan | OVER Luxury</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4AF37;
            --black: #000000;
            --dark-gray: #1a1a1a;
        }

        body {
            background-color: var(--black);
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        h2, th, .navbar-brand {
            font-family: 'Playfair Display', serif;
        }

        .navbar {
            background-color: var(--black) !important;
            border-bottom: 1px solid var(--gold);
        }

        .history-box {
            background-color: var(--dark-gray);
            border: 1px solid #333;
            padding: 30px;
            border-radius: 0;
            margin-bottom: 20px;
        }

        .table {
            color: #fff;
            border-color: #333;
        }

        .text-gold { color: var(--gold); }
        .btn-gold {
            background-color: var(--gold);
            color: var(--black);
            font-weight: 600;
        }

        .btn-outline-gold {
            border: 1px solid var(--gold);
            color: var(--gold);
        }
        .badge-gold {
            background-color: var(--gold);
            color: var(--black);
        }
        
        .badge-status {
            border: 1px solid var(--gold);
            color: var(--gold);
            padding: 5px 15px;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .product-img {
            border: 1px solid var(--gold);
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/brand.png" alt="OVER Logo" style="height: 100px; width: auto; margin-bottom: -10px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">BERANDA</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">TENTANG OVER</a></li>
                    <li class="nav-item"><a class="nav-link" href="produk_over.php">PRODUK OVER</a></li>
                    <li class="nav-item"><a class="nav-link" href="article.php">ARTIKEL</a></li>
                    <li class="nav-item"><a class="nav-link" href="history.php">HISTORY</a></li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <a href="cart.php" class="btn btn-outline-gold me-3 position-relative">
                    Cart
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-gold">
                        <?= isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0 ?>
                    </span>
                </a>
                <?php if (is_logged_in()): ?>
                    <a href="logout.php" class="btn btn-link text-white text-decoration-none">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-link text-white text-decoration-none">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="mb-5 text-center">
            <h2 class="display-6">Riwayat <span class="text-gold">Koleksi Saya</span></h2>
            <p class="text-secondary small">Daftar pesanan mewah yang telah Anda lakukan.</p>
        </div>

        <?php if (empty($history)): ?>
            <div class="text-center py-5 border border-secondary">
                <p class="text-secondary">Anda belum memiliki riwayat pesanan.</p>
                <a href="index.php" class="btn btn-outline-gold mt-3">Mulai Belanja</a>
            </div>
        <?php else: ?>
            <div class="history-box shadow-lg">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-gold">
                                <th>Tanggal Pesan</th>
                                <th>Produk</th>
                                <th>Kuantitas</th>
                                <th>Total Harga</th>
                                <th>Pembayaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history as $h): ?>
                                <tr>
                                    <td class="small"><?= date('d M Y, H:i', strtotime($h['order_date'])) ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= e($h['image']) ?>" class="product-img me-3">
                                            <span class="fw-bold small"><?= e($h['title']) ?></span>
                                        </div>
                                    </td>
                                    <td><?= $h['qty'] ?> Helai</td>
                                    <td class="fw-bold">Rp <?= number_format($h['subtotal'], 0, ',', '.') ?></td>
                                    <td class="small"><?= e($h['payment_method']) ?></td>
                                    <td><span class="badge-status">Selesai</span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <footer class="bg-black py-5 mt-5">
        <div class="container text-center">
            <div class="mb-3">
                <img src="assets/images/brand.png" alt="OVER" height="100" class="mb-3 opacity-75">
            </div>
            <div class="text-secondary small mb-2">FOLLOW OVER DI SOCIAL MEDIA</div>
            <div class="fw-bold mb-4" style="color: var(--gold);">WA: 085830712932 • IG: @OVEROFFICIAL_ID</div>
            <div class="text-muted small">© <?= date('Y') ?> OVER STORE. All Rights Reserved.</div>
        </div>
    </footer>
</body>
</html>