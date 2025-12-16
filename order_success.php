<?php
require 'config.php';
require 'helper.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $mysqli->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
if (!$order) {
    echo "Order not found";
    exit;
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <div class="alert alert-success">
            <h4>Pesanan Berhasil</h4>
            <p>Terima kasih, pesananmu telah diterima. Nomor pesanan: <strong>#<?= $order['id'] ?></strong></p>
            <p>Total: Rp <?= number_format($order['total'], 0, ',', '.') ?> • Metode: <?= e($order['payment_method']) ?></p>
        </div>
        <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
    </div>
</body>

</html>