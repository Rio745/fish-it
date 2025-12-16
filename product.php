<?php
require 'config.php';
require 'helper.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$product = $res->fetch_assoc();

if (!$product) {
    header('Location: index.php'); // Mengarahkan kembali ke index jika produk tidak ada
    exit;
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title><?= e($product['title']) ?> | OVER Luxury Collection</title>
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

        h2, h4, .navbar-brand {
            font-family: 'Playfair Display', serif;
        }

        /* Navbar Styling */
        .navbar {
            background-color: var(--black) !important;
            border-bottom: 1px solid var(--gold);
        }

        /* Product Detail Box */
        .product-container {
            background-color: var(--dark-gray);
            border: 1px solid #333;
            border-radius: 0;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .img-luxury {
            border: 1px solid var(--gold);
            padding: 10px;
            background: #000;
        }

        .price-tag {
            color: var(--gold);
            font-size: 2rem;
            margin: 20px 0;
        }

        /* Form Styling */
        .qty-input {
            background-color: #000;
            border: 1px solid var(--gold);
            color: #fff;
            text-align: center;
        }

        .qty-input:focus {
            background-color: #000;
            color: #fff;
            border-color: #fff;
            box-shadow: none;
        }

        /* Buttons */
        .btn-gold {
            background-color: var(--gold);
            color: var(--black);
            font-weight: 600;
            border-radius: 0;
            padding: 12px 30px;
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 100%;
        }

        .btn-gold:hover {
            background-color: #AA882E;
            color: #fff;
        }

        .btn-outline-gold {
            border: 1px solid var(--gold);
            color: var(--gold);
            border-radius: 0;
        }

        footer {
            border-top: 1px solid var(--gold);
            margin-top: 80px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/brand.png" alt="OVER Logo" style="height: 50px;">
            </a>
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav">
                                        <li class="nav-item">
                        <a class="nav-link" href="index.php">BERANDA</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="about.php">TENTANG OVER</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php">PRODUK OVER</a></li>
                    <li class="nav-item"><a class="nav-link" href="article.php">ARTIKEL</a></li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <a href="cart.php" class="btn btn-outline-gold me-3 position-relative btn-sm">
                    Cart (<?= isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0 ?>)
                </a>
                <?php if (is_logged_in()): ?>
                    <a href="logout.php" class="btn btn-link text-white text-decoration-none btn-sm">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-link text-white text-decoration-none btn-sm">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="produk_over.php" class="text-secondary">Store</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= e($product['title']) ?></li>
            </ol>
        </nav>

        <div class="product-container shadow-lg mt-4">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0 text-center">
                    <img src="<?= e($product['image']) ?>" class="img-fluid img-luxury" alt="<?= e($product['title']) ?>">
                </div>
                <div class="col-md-6 ps-md-5">
                    <span class="text-secondary small text-uppercase letter-spacing-2">Luxury Collection</span>
                    <h2 class="display-5 mb-3 fw-bold"><?= e($product['title']) ?></h2>
                    <hr style="border-color: var(--gold); width: 50px; opacity: 1;">
                    
                    <p class="text-secondary my-4 fs-5" style="line-height: 1.8;">
                        <?= e($product['description']) ?>
                    </p>

                    <div class="price-tag fw-bold">
                        Rp <?= number_format($product['price'], 0, ',', '.') ?>
                    </div>

                    <form action="add_to_cart.php" method="post" class="mt-4">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <div class="row align-items-end g-3">
                            <div class="col-4 col-md-3">
                                <label class="small text-secondary mb-2">Quantity</label>
                                <input type="number" name="qty" value="1" min="1" max="<?= $product['stock'] ?>" class="form-control qty-input">
                            </div>
                            <div class="col-8 col-md-9">
                                <button class="btn btn-gold">Tambah ke Bag</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="mt-4 small text-secondary">
                        <span class="me-3">Tersedia: <strong><?= $product['stock'] ?> unit</strong></span>
                        <span>• Premium Serat Alami</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-black py-5">
        <div class="container text-center">
            <div class="mb-3">
                <img src="assets/images/brand.png" alt="OVER" height="60" class="mb-3 opacity-75">
            </div>
            <p class="text-secondary small">Memberikan sentuhan kemewahan dalam setiap helai.</p>
            <div class="fw-bold mb-4" style="color: var(--gold);">WA: 085830712932 • IG: @OVEROFFICIAL_ID</div>
            <div class="text-muted small">© <?= date('Y') ?> OVER STORE. Excellence in Hygiene.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>