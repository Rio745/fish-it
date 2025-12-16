<?php
require 'config.php';
require 'helper.php';

$search = isset($_GET['q']) ? $_GET['q'] : '';
$sql = "SELECT * FROM products WHERE title LIKE ? OR description LIKE ? ORDER BY created_at DESC";
$stmt = $mysqli->prepare($sql);
$like = "%$search%";
$stmt->bind_param('ss', $like, $like);
$stmt->execute();
$res = $stmt->get_result();
$products = $res->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>OVER Store | Luxury Collection</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #AA882E;
            --black: #000000;
            --dark-gray: #1a1a1a;
        }

        body {
            background-color: var(--black);
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h5,
        .navbar-brand {
            font-family: 'Playfair Display', serif;
        }

        /* --- New Landing Page Styling --- */
        .hero-section {
            background-color: var(--black);
            padding: 80px 0;
            text-align: center;
            position: relative;
            border-bottom: 2px solid var(--gold);
        }

        .hero-title {
            color: var(--gold);
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .badge-baru {
            position: absolute;
            top: 40px;
            right: -50px;
            background: #fff;
            color: #000;
            padding: 10px 80px;
            transform: rotate(45deg);
            font-weight: bold;
            z-index: 10;
        }

        .product-preview {
            max-width: 80%;
            margin-top: 30px;
            filter: drop-shadow(0 10px 20px rgba(212, 175, 55, 0.2));
        }

        .info-panel {
            background-color: #fff;
            color: #000;
            padding: 60px 0;
        }

        .info-title {
            font-size: 2rem;
            border-right: 3px solid var(--gold);
            padding-right: 20px;
            font-weight: 700;
        }

        .info-detail h4 {
            border-bottom: 2px solid var(--gold);
            display: inline-block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        /* --- Existing Elements --- */
        .navbar {
            background-color: var(--black) !important;
            border-bottom: 1px solid var(--gold);
        }

        .card {
            background-color: var(--dark-gray);
            border: 1px solid #333;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            border-color: var(--gold);
        }

        .btn-gold {
            background-color: var(--gold);
            color: var(--black);
            font-weight: 600;
        }

        .btn-outline-gold {
            border: 1px solid var(--gold);
            color: var(--gold);
        }

         .search-input {
            background-color: #222;
            border: 1px solid #444;
            color: white;
        }

        .search-input:focus {
            background-color: #222;
            border-color: var(--gold);
            color: white;
            box-shadow: none;
        }

        .badge-gold {
            background-color: var(--gold);
            color: var(--black);
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
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
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
                    <a href="logout.php" class="btn btn-link text-white text-decoration-none btn-sm">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-link text-white text-decoration-none btn-sm">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="badge-baru">BARU!</div>
        <div class="container">
            <h1 class="hero-title">OVER</h1>
            <h2 class="text-white mb-4">Kini Hadir dalam 3 ply!</h2>
            <div class="d-flex justify-content-center gap-3">
                <button class="btn btn-outline-gold rounded-pill px-4">Helaian lebih banyak</button>
                <button class="btn btn-outline-gold rounded-pill px-4">Helaian lebih besar</button>
            </div>
            <img src="assets/images/3.png" alt="Preview Produk" class="product-preview">
        </div>
    </header>

    <section class="info-panel">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="info-title">OVER MEMBERIKAN SENTUHAN KEMEWAHAN DAN KEBAHAGIAAN DALAM KEHIDUPAN SEHARI-HARI.</h1>
                </div>
                <div class="col-md-6 mt-4 mt-md-0 ps-md-5">
                    <div class="mb-4">
                        <h4 class="text-uppercase">100% Serat Alami</h4>
                        <p class="text-muted">OVER, tisu dengan kualitas premium yang higienis, lembut dan alami untuk seluruh keluarga. Terbuat dari 100% serat alami.</p>
                    </div>
                    <div>
                        <h4 class="text-uppercase">Telah Tersertifikasi</h4>
                        <p class="text-muted">OVER, telah teruji dermatologis Hypoallergenic, serta bersertifikat Food Grade dan Halal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container my-5" id="store">
        <div class="row align-items-center mb-5 pt-5">
            <div class="col-md-7">
                <h1 class="display-5 fw-bold mb-2">Exclusive <span style="color: var(--gold);">Collection</span></h1>
                <p class="text-secondary">Eksklusivitas dalam setiap detail produk pilihan kami.</p>
            </div>
            <div class="col-md-5">
                <form method="get" class="d-flex shadow-sm">
                    <input name="q" class="form-control search-input me-2 py-2" placeholder="Cari koleksi..." value="<?= e($search) ?>">
                    <button class="btn btn-gold px-4">Cari</button>
                </form>
            </div>
        </div>

        <div class="row">
            <?php foreach ($products as $p): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= e($p['image']) ?>" class="card-img-top" style="height:280px;object-fit:cover; border-bottom: 2px solid var(--gold);">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fs-4 mb-3" style="color: var(--gold);"><?= e($p['title']) ?></h5>
                            <p class="card-text text-secondary small mb-4"><?= e($p['description']) ?></p>
                            <div class="mt-auto pt-3 border-top border-secondary">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <div class="text-white fw-bold">Rp <?= number_format($p['price'], 0, ',', '.') ?></div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <form action="add_to_cart.php" method="post" class="d-inline">
                                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                            <button class="btn btn-sm btn-gold">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="bg-black py-5">
        <div class="container text-center">
            <div class="py-4 border-top border-bottom border-dark mb-4">
                <h3 class="mb-3">ARTIKEL TIPS</h3>
                <p class="text-secondary"><strong>OVER</strong> tisu yang tepat untuk gaya hidup modern. Clean life smart choice</p>
            </div>
            <div class="mb-3">
                <img src="assets/images/brand.png" alt="OVER" height="80" class="mb-3 opacity-75">
            </div>
            <div class="text-secondary small mb-2">FOLLOW OVER DI SOCIAL MEDIA</div>
            <div class="fw-bold mb-4" style="color: var(--gold);">WA: 085830712932 • IG: @OVEROFFICIAL_ID</div>
            <div class="text-muted small">© <?= date('Y') ?> OVER STORE. All Rights Reserved.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>