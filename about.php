<?php
require 'config.php';
require 'helper.php';
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Tentang Kami | OVER Luxury Collection</title>
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

        h1, h2, h3, .navbar-brand {
            font-family: 'Playfair Display', serif;
        }

        .navbar {
            background-color: var(--black) !important;
            border-bottom: 1px solid var(--gold);
        }

        /* Hero Section About */
        .about-hero {
            padding: 100px 0 60px;
            text-align: center;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('assets/images/about-bg.jpg'); /* Ganti dengan gambar background jika ada */
            background-size: cover;
            border-bottom: 1px solid var(--gold);
        }

        .about-hero h1 {
            font-size: 3.5rem;
            color: var(--gold);
            margin-bottom: 20px;
        }

        /* Content Section */
        .content-box {
            background-color: var(--dark-gray);
            border: 1px solid #333;
            padding: 50px;
            border-radius: 8px;
            margin-top: -50px;
            position: relative;
            z-index: 10;
        }

        .accent-line {
            width: 80px;
            height: 3px;
            background-color: var(--gold);
            margin: 20px 0;
        }

        .mission-vision h4 {
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }
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
        
        .img-luxury {
            border: 1px solid var(--gold);
            padding: 10px;
            filter: grayscale(30%);
            transition: 0.3s;
        }

        .img-luxury:hover {
            filter: grayscale(0%);
            border-color: #fff;
        }

        footer {
            border-top: 1px solid var(--gold);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/brand.png" alt="OVER Logo" style="height: 100px; width: auto; margin-bottom: -10px;">
            </a>
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

    <section class="about-hero">
        <div class="container">
            <h1>Our Story</h1>
            <p class="lead text-secondary">Mendefinisikan Ulang Kemewahan dalam Kebutuhan Sehari-hari.</p>
        </div>
    </section>

    <section class="container mb-5">
        <div class="content-box shadow-lg">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="assets/images/brand.jpg" alt="OVER Philosophy" class="img-fluid img-luxury">
                </div>
                <div class="col-md-6 ps-md-5">
                    <h2 class="mb-3">Filosofi <span style="color: var(--gold);">OVER</span></h2>
                    <div class="accent-line"></div>
                    <p class="text-secondary">
                        Lahir dari keinginan untuk memberikan kenyamanan maksimal bagi setiap keluarga, 
                        <strong>OVER</strong> bukan sekadar produk higienis. Kami adalah perpaduan antara 
                        inovasi serat alami terbaik dan sentuhan estetika premium.
                    </p>
                    <p class="text-secondary">
                        Setiap helai tisu OVER dirancang untuk memberikan kelembutan yang memanjakan kulit, 
                        sekaligus menjaga komitmen kami terhadap kelestarian lingkungan melalui penggunaan 
                        100% serat alami yang bersertifikasi.
                    </p>
                </div>
            </div>

            <hr class="my-5" style="border-color: #333;">

            <div class="row mission-vision text-center">
                <div class="col-md-6 mb-4">
                    <h4>Visi Kami</h4>
                    <p class="text-secondary">Menjadi simbol gaya hidup modern yang mengutamakan kualitas, kebersihan, dan kemewahan dalam setiap aspek terkecil kehidupan.</p>
                </div>
                <div class="col-md-6 mb-4">
                    <h4>Misi Kami</h4>
                    <p class="text-secondary">Menghadirkan produk premium yang higienis, teruji secara dermatologis, dan aman (Food Grade) tanpa mengabaikan aspek keberlanjutan alam.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-black py-5 mt-5">
        <div class="container text-center">
            <div class="mb-3">
                <img src="assets/images/brand.png" alt="OVER" height="60" class="mb-3 opacity-75">
            </div>
            <div class="text-secondary small">FOLLOW OVER DI SOCIAL MEDIA</div>
            <div class="fw-bold mb-4" style="color: var(--gold);">WA: 085830712932 • IG: @OVEROFFICIAL_ID</div>
            <div class="text-muted small">© <?= date('Y') ?> OVER STORE. Crafted for Excellence.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>