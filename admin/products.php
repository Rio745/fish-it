<?php
require 'admin_only.php';

// Pastikan fungsi e() tersedia untuk keamanan output
if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

$res = $mysqli->query("SELECT * FROM products ORDER BY id DESC");
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h2 class="fw-bold text-primary">Manajemen Produk</h2>
            <a href="logout.php" class="btn btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                Logout
            </a>
        </div>

        <div class="mb-3">
            <a href="product_create.php" class="btn btn-success">+ Tambah Produk Baru</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="100">Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th width="100">Stok</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($res->num_rows > 0): ?>
                        <?php while ($p = $res->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center">
                                    <img src="../<?= e($p['image']) ?>" 
                                         class="img-thumbnail" 
                                         style="width: 70px; height: 70px; object-fit: cover;" 
                                         alt="<?= e($p['title']) ?>">
                                </td>
                                <td><strong><?= e($p['title']) ?></strong></td>
                                <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge bg-<?= $p['stock'] > 5 ? 'info' : 'danger' ?>">
                                        <?= e($p['stock']) ?>
                                    </td>
                                <td>
                                    <a href="product_edit.php?id=<?= $p['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="product_delete.php?id=<?= $p['id'] ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Hapus produk ini secara permanen?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data produk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>