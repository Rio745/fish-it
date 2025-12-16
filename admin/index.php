<?php
require 'admin_only.php';
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h2>Dashboard Admin</h2>
        <p>Halo, <?= e($_SESSION['user']['name']) ?>!</p>

        <a href="products.php" class="btn btn-primary">Kelola Produk</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>

</html>