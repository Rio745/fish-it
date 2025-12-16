<?php
require 'config.php';
require 'helper.php';
$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $c) $total += $c['price'] * $c['qty'];
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Keranjang Belanja | OVER Luxury</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4AF37;
            --black: #000000;
            --dark-gray: #1a1a1a;
            --text-gray: #b0b0b0;
        }

        body {
            background-color: var(--black);
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        h2, th {
            font-family: 'Playfair Display', serif;
            color: var(--gold);
        }

        .container {
            margin-top: 80px;
        }

        /* Card-style list */
        .cart-container {
            background-color: var(--dark-gray);
            border: 1px solid #333;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        /* Table Styling */
        .table {
            color: #ffffff;
            border-color: #333;
        }

        .table thead th {
            border-bottom: 2px solid var(--gold);
            padding-bottom: 15px;
        }

        .table tbody tr {
            border-bottom: 1px solid #333;
            vertical-align: middle;
        }

        .product-img {
            border: 1px solid var(--gold);
            border-radius: 4px;
            transition: transform 0.3s ease;
        }

        /* Input Qty */
        .form-control-qty {
            background-color: #222;
            border: 1px solid #444;
            color: white;
            text-align: center;
            border-radius: 4px;
        }

        .form-control-qty:focus {
            background-color: #222;
            border-color: var(--gold);
            color: white;
            box-shadow: none;
        }

        /* Buttons */
        .btn-gold {
            background-color: var(--gold);
            color: var(--black);
            font-weight: 600;
            border: none;
        }

        .btn-gold:hover {
            background-color: #AA882E;
            color: white;
        }

        .btn-outline-gold {
            border: 1px solid var(--gold);
            color: var(--gold);
        }

        .btn-outline-gold:hover {
            background-color: var(--gold);
            color: var(--black);
        }

        .empty-cart-box {
            border: 1px dashed var(--gold);
            padding: 50px;
            text-align: center;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="mb-4">
            <h2>Luxury <span style="color:#fff">Shopping Bag</span></h2>
            <p class="text-secondary small text-uppercase letter-spacing-1">Pastikan koleksi pilihan Anda sudah sesuai.</p>
        </div>

        <?php if (empty($cart)): ?>
            <div class="empty-cart-box">
                <h4 class="mb-3">Keranjang Anda Kosong</h4>
                <p class="text-secondary mb-4">Sepertinya Anda belum memilih koleksi mewah kami hari ini.</p>
                <a href="produk_over.php" class="btn btn-gold px-4">Kembali ke Koleksi</a>
            </div>
        <?php else: ?>
            <div class="cart-container">
                <form action="update_cart.php" method="post">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th style="width: 120px;">Kuantitas</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $idx => $c): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= e($c['image']) ?>" style="width:70px;height:70px;object-fit:cover" class="product-img me-3">
                                                <div>
                                                    <div class="fw-bold fs-6"><?= e($c['title']) ?></div>
                                                    <small class="text-secondary">Premium Grade</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp <?= number_format($c['price'], 0, ',', '.') ?></td>
                                        <td>
                                            <input type="number" name="qty[<?= $c['id'] ?>]" value="<?= $c['qty'] ?>" min="1" class="form-control form-control-qty">
                                        </td>
                                        <td class="fw-bold">Rp <?= number_format($c['price'] * $c['qty'], 0, ',', '.') ?></td>
                                        <td>
                                            <a href="remove_from_cart.php?id=<?= $c['id'] ?>" class="text-danger text-decoration-none small">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-5 align-items-end">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <a href="produk_over.php" class="btn btn-outline-gold me-2 px-4">Lanjut Belanja</a>
                            <button type="submit" class="btn btn-secondary px-4">Update Bag</button>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="mb-3">
                                <span class="text-secondary">Estimasi Total :</span>
                                <h3 class="fw-bold mt-1" style="color: var(--gold);">Rp <?= number_format($total, 0, ',', '.') ?></h3>
                            </div>
                            <a href="checkout.php" class="btn btn-gold btn-lg px-5">Checkout Sekarang</a>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <footer class="text-center py-5 mt-5 border-top border-secondary opacity-50">
        <small>© <?= date('Y') ?> OVER STORE. Luxury Collections.</small>
    </footer>
</body>

</html>