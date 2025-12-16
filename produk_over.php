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
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .navbar-brand {
            font-family: 'Playfair Display', serif;
        }

        /* Navbar Styling */
        .navbar {
            background-color: var(--black) !important;
            border-bottom: 1px solid var(--gold);
            padding: 1rem 0;
        }

        .navbar-brand img {
            height: 50px;
            /* Menyesuaikan logo */
        }

        /* Card Styling */
        .card {
            background-color: var(--dark-gray);
            border: 1px solid #333;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            border-color: var(--gold);
        }

        .card-title {
            color: var(--gold);
        }

        /* Button Styling */

        .btn-gold {
            background-color: var(--gold);
            color: var(--black);
            font-weight: 600;
        }

        .btn-outline-gold {
            border: 1px solid var(--gold);
            color: var(--gold);
        }

        /* Search Bar */
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

        footer {
            border-top: 1px solid var(--gold);
            margin-top: 50px;
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
                    <a href="logout.php" class="btn btn-link text-white text-decoration-none">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-link text-white text-decoration-none">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row align-items-center mb-5">
            <div class="col-md-7">
                <h1 class="display-4 fw-bold mb-2">Produk <span style="color: var(--gold);">OVER</span></h1>
                <p class="lead text-secondary">Sentuhan kemewahan untuk kebutuhan sehari-hari. Eksklusivitas dalam setiap detail.</p>
            </div>
            <div class="col-md-5">
                <form method="get" class="d-flex shadow-sm">
                    <input name="q" class="form-control search-input me-2 py-2" placeholder="Cari koleksi eksklusif..." value="<?= e($search) ?>">
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
                            <h5 class="card-title fs-4 mb-3"><?= e($p['title']) ?></h5>
                            <p class="card-text text-secondary small mb-4 text-truncate-2"><?= e($p['description']) ?></p>

                            <div class="mt-auto pt-3 border-top border-secondary">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <div class="text-white fw-bold fs-5">Rp <?= number_format($p['price'], 0, ',', '.') ?></div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <a href="product.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-gold mb-1">Detail</a>
                                        <form action="add_to_cart.php" method="post" class="d-inline">
                                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                            <button class="btn btn-sm btn-gold mb-1">Add</button>
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