<?php
require 'config.php';
require 'helper.php';

// Menangkap ID artikel dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Dummy data (Sama dengan article.php, idealnya ini dari database)
$articles = [
    1 => [
        'title' => 'Gaya Hidup Modern & Kebersihan',
        'content' => 'Kebersihan adalah cerminan dari gaya hidup modern yang teratur. Di tengah kesibukan kota yang padat, menjaga higienitas bukan lagi sekadar rutinitas, melainkan kebutuhan eksklusif. OVER hadir untuk memastikan bahwa setiap sentuhan memberikan proteksi maksimal sekaligus kelembutan premium bagi kulit Anda...',
        'image' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&q=80&w=1200',
        'date' => '10 Dec 2023',
        'author' => 'Admin OVER'
    ],
    2 => [
        'title' => 'Mengapa 3-Ply Adalah Pilihan Terbaik?',
        'content' => 'Tisu 3-ply memberikan ketebalan ekstra yang berarti daya serap lebih tinggi. Namun, ketebalan saja tidak cukup. OVER menggabungkan tiga lapis serat alami berkualitas tinggi untuk menciptakan tekstur yang kuat namun tetap selembut sutra saat menyentuh wajah. Ini adalah standar baru dalam kenyamanan keluarga...',
        'image' => 'assets/images/3.png',
        'date' => '05 Dec 2023',
        'author' => 'Admin OVER'
    ],
    3 => [
        'title' => 'Eco-Luxury: Ramah Lingkungan',
        'content' => 'Kemewahan tidak harus merusak bumi. Di OVER, kami percaya pada konsep keberlanjutan. Seluruh bahan baku tisu kami berasal dari perkebunan kayu yang dikelola secara bertanggung jawab. Dengan memilih OVER, Anda tidak hanya memilih kenyamanan pribadi, tetapi juga berkontribusi pada masa depan bumi yang lebih hijau...',
        'image' => 'https://images.unsplash.com/photo-1616137422495-1e9e46e2aa77?auto=format&fit=crop&q=80&w=1200',
        'date' => '01 Dec 2023',
        'author' => 'Admin OVER'
    ]
];

$article = isset($articles[$id]) ? $articles[$id] : null;

if (!$article) {
    header("Location: article.php");
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?= $article['title'] ?> | OVER Insights</title>
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
            line-height: 1.8;
        }
        h1, h2, .navbar-brand { font-family: 'Playfair Display', serif; }
        .navbar { border-bottom: 1px solid var(--gold); background: #000; }
        
        .hero-article {
            height: 60vh;
            background: url('<?= $article['image'] ?>') center/cover no-repeat;
            border-bottom: 5px solid var(--gold);
            position: relative;
        }
        .hero-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.9));
        }
        .article-meta { color: var(--gold); letter-spacing: 2px; font-size: 0.9rem; }
        .content-body { font-size: 1.1rem; color: #ccc; }
        .back-link { color: var(--gold); text-decoration: none; transition: 0.3s; }
        .back-link:hover { color: #fff; padding-left: 5px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/images/brand.png" alt="Logo" style="height: 100px; width: auto; margin-bottom: -10px;">
        </a>
        <div class="collapse navbar-collapse justify-content-center">
            <ul class="navbar-nav">
                 <li class="nav-item"><a class="nav-link" href="index.php">BERANDA</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">TENTANG OVER</a></li>
                <li class="nav-item"><a class="nav-link" href="produk_over.php">PRODUK OVER</a></li>
                <li class="nav-item"><a class="nav-link active" href="article.php">ARTIKEL</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="hero-article">
    <div class="hero-overlay d-flex align-items-end">
        <div class="container pb-5">
            <div class="article-meta mb-2"><?= $article['date'] ?> | BY <?= $article['author'] ?></div>
            <h1 class="display-3 fw-bold" style="color: var(--gold);"><?= $article['title'] ?></h1>
        </div>
    </div>
</header>

<main class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="article.php" class="back-link mb-4 d-inline-block">← Kembali ke Artikel</a>
            <div class="content-body">
                <p><?= nl2br($article['content']) ?></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <h3 class="mt-5 mb-3 text-white">Komitmen OVER</h3>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            
            <hr class="my-5 border-secondary">
            
            <div class="share-box text-center">
                <h5 class="mb-3 text-gold" style="color: var(--gold);">Bagikan Insights Ini</h5>
                <button class="btn btn-outline-light btn-sm mx-1">WhatsApp</button>
                <button class="btn btn-outline-light btn-sm mx-1">Instagram</button>
            </div>
        </div>
    </div>
</main>

<footer class="bg-black py-5 border-top border-secondary">
    <div class="container text-center text-secondary small">
        © <?= date('Y') ?> OVER STORE. Excellence in Hygiene.
    </div>
</footer>

</body>
</html>