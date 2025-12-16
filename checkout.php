<?php
require 'config.php';
require 'helper.php';

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

$total = 0;
foreach ($cart as $c) $total += $c['price'] * $c['qty'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $method = $_POST['payment_method'];

    $user_id = is_logged_in() ? $_SESSION['user']['id'] : null;

    $stmt = $mysqli->prepare("INSERT INTO orders (user_id, name, phone, address, total, payment_method) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param('isssis', $user_id, $name, $phone, $address, $total, $method);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    $stmt2 = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, qty, price) VALUES (?,?,?,?)");
    foreach ($cart as $it) {
        $stmt2->bind_param('iiii', $order_id, $it['id'], $it['qty'], $it['price']);
        $stmt2->execute();
        $mysqli->query("UPDATE products SET stock = stock - " . (int)$it['qty'] . " WHERE id = " . (int)$it['id']);
    }

    unset($_SESSION['cart']);
    header('Location: order_success.php?id=' . $order_id);
    exit;
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Checkout | OVER Luxury Experience</title>
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

        h2, h5, label, .navbar-brand {
            font-family: 'Playfair Display', serif;
        }

        .navbar {
            background-color: var(--black) !important;
            border-bottom: 1px solid var(--gold);
        }

        .checkout-container {
            background-color: var(--dark-gray);
            border: 1px solid #333;
            padding: 40px;
            margin-top: 30px;
        }

        .form-control, .form-select {
            background-color: #000;
            border: 1px solid #444;
            color: #fff;
            border-radius: 0;
        }

        .form-control:focus, .form-select:focus {
            background-color: #000;
            border-color: var(--gold);
            color: #fff;
            box-shadow: none;
        }

        .summary-box {
            background-color: #000;
            border: 1px solid var(--gold);
            padding: 25px;
        }

        .btn-gold {
            background-color: var(--gold);
            color: var(--black);
            font-weight: 600;
            border-radius: 0;
            padding: 15px;
            border: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: 0.3s;
        }

        .btn-gold:hover {
            background-color: #fff;
            color: #000;
        }

        label {
            color: var(--gold);
            margin-bottom: 8px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .text-gold { color: var(--gold); }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/brand.png" alt="OVER" style="height: 50px;">
            </a>
            <span class="text-secondary small d-none d-md-inline">SECURE CHECKOUT</span>
        </div>
    </nav>

    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="display-5">Finalize <span class="text-gold">Order</span></h2>
            <div style="width: 50px; height: 2px; background: var(--gold); margin: 10px auto;"></div>
        </div>

        <form method="post">
            <div class="row g-5">
                <div class="col-md-7">
                    <div class="checkout-container shadow-lg">
                        <h5 class="mb-4 text-white uppercase">Informasi Pengiriman</h5>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label>Nama Lengkap</label>
                                <input name="name" class="form-control" placeholder="Input nama sesuai identitas" required value="<?= is_logged_in() ? e($_SESSION['user']['name']) : '' ?>">
                            </div>
                            <div class="col-12 mb-3">
                                <label>Nomor Telepon (WA)</label>
                                <input name="phone" type="tel" class="form-control" placeholder="Contoh: 0812xxxx" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label>Alamat Lengkap Tujuan</label>
                                <textarea name="address" class="form-control" rows="4" placeholder="Sebutkan jalan, nomor rumah, RT/RW, dan kecamatan" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="summary-box shadow-lg">
                        <h5 class="mb-4 text-gold border-bottom border-secondary pb-2 uppercase">Ringkasan Koleksi</h5>
                        
                        <?php foreach ($cart as $it): ?>
                            <div class="d-flex justify-content-between mb-3 small">
                                <div class="text-secondary"><?= e($it['title']) ?> <span class="text-white">x <?= $it['qty'] ?></span></div>
                                <div class="fw-bold text-white">Rp <?= number_format($it['price'] * $it['qty'], 0, ',', '.') ?></div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="border-top border-secondary my-4 pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="uppercase mb-0 text-secondary">Total Investasi</h6>
                                <h4 class="text-gold fw-bold mb-0">Rp <?= number_format($total, 0, ',', '.') ?></h4>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top border-dark">
                            <label>Metode Pembayaran</label>
                            <select name="payment_method" class="form-select mb-4">
                                <option value="DANA">DANA - Dompet Digital</option>
                                <option value="ATM">ATM / Mobile Banking</option>
                                <option value="GOPAY">GoPay / QRIS</option>
                            </select>
                            <button class="btn btn-gold w-100 mt-2">Selesaikan Pesanan</button>
                            <p class="text-center text-secondary x-small mt-3 mb-0" style="font-size: 0.7rem;">
                                Transaksi dienkripsi dan diproses secara aman.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <footer class="text-center py-5 opacity-50">
        <small class="text-secondary">© <?= date('Y') ?> OVER STORE. Crafted for Excellence.</small>
    </footer>
</body>
</html>