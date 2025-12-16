<?php
require 'config.php';
require 'helper.php';

// Opsional: Jika Anda memiliki tabel database untuk artikel, Anda bisa menggunakan query ini:
// $articles = $mysqli->query("SELECT * FROM articles ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);

// Untuk demo, kita gunakan data dummy agar tampilan langsung terlihat:
$articles = [
    [
        'id' => 1,
        'title' => 'Gaya Hidup Modern & Kebersihan',
        'excerpt' => 'Menemukan keseimbangan antara kesibukan kota besar dan menjaga kebersihan diri secara eksklusif.',
        'image' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&q=80&w=1200',
        'date' => '10 Dec 2023'
    ],
    [
        'id' => 2,
        'title' => 'Mengapa 3-Ply Adalah Pilihan Terbaik?',
        'excerpt' => 'Eksplorasi mendalam mengenai kekuatan dan kelembutan lapisan tisu premium untuk kenyamanan keluarga.',
        'image' => 'assets/images/3.png',
        'date' => '05 Dec 2023'
    ],
    [
        'id' => 3,
        'title' => 'Eco-Luxury: Kemewahan yang Ramah Lingkungan',
        'excerpt' => 'Bagaimana OVER menjaga komitmen serat alami 100% untuk masa depan bumi yang lebih baik.',
        'image' => 'https://images.unsplash.com/photo-1616137422495-1e9e46e2aa77?auto=format&fit=crop&q=80&w=1200',
        'date' => '01 Dec 2023'
    ]
];
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Artikel & Tips | OVER Luxury Collection</title>
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

        h1, h2, h5, .navbar-brand {
            font-family: 'Playfair Display', serif;
        }

        .navbar {
            background-color: var(--black) !important;
            border-bottom: 1px solid var(--gold);
        }

        /* Hero Section */
        .article-header {
            padding: 80px 0;
            text-align: center;
            border-bottom: 1px solid var(--gold);
            background: linear-gradient(to bottom, #111, #000);
        }

        .article-header h1 {
            font-size: 3rem;
            color: var(--gold);
        }

        /* Card Styling */
        .article-card {
            background-color: var(--dark-gray);
            border: 1px solid #333;
            transition: all 0.4s ease;
            overflow: hidden;
            border-radius: 0; /* Kotak siku memberikan kesan lebih formal & mewah */
        }

        .article-card:hover {
            border-color: var(--gold);
            transform: translateY(-5px);
        }

        .article-img-wrapper {
            overflow: hidden;
            height: 250px;
        }

        .article-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
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

        .article-card:hover img {
            transform: scale(1.1);
        }

        .btn-read-more {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            margin-top: 15px;
            border-bottom: 1px solid transparent;
            transition: 0.3s;
        }

        .btn-read-more:hover {
            border-bottom-color: var(--gold);
            color: #fff;
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

        .date-badge {
            font-size: 0.75rem;
            color: var(--gold);
            text-transform: uppercase;
            margin-bottom: 10px;
            display: block;
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

    <section class="article-header">
        <div class="container">
            <h1>Lifestyle & Insights</h1>
            <p class="text-secondary">Clean life, smart choice. Temukan inspirasi gaya hidup modern bersama OVER.</p>
        </div>
    </section>

    <section class="container my-5 pb-5">
        <div class="row g-4">
            <?php foreach ($articles as $art): ?>
                <div class="col-md-4">
                    <article class="article-card h-100 shadow-lg">
                        <div class="article-img-wrapper">
                            <img src="<?= $art['image'] ?>" alt="<?= $art['title'] ?>">
                        </div>
                        <div class="card-body p-4">
                            <span class="date-badge"><?= $art['date'] ?></span>
                            <h5 class="card-title text-white mb-3"><?= $art['title'] ?></h5>
                            <p class="card-text text-secondary small">
                                <?= $art['excerpt'] ?>
                            </p>
                            <a href="article_detail.php?id=<?= $art['id'] ?>" class="btn-read-more">Baca Selengkapnya →</a>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

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