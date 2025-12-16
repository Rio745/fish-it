<?php
require 'admin_only.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];
    $price = (int)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $desc = $_POST['description'];
    $slug = strtolower(str_replace(" ", "-", $title));

    // Upload gambar
    $img_name = '';
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $img_name = "uploads/" . time() . "_" . rand(100, 999) . "." . $ext;
        move_uploaded_file($file['tmp_name'], "../" . $img_name);
    }

    $stmt = $mysqli->prepare("INSERT INTO products (title,slug,description,price,stock,image) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("sssii s", $title, $slug, $desc, $price, $stock, $img_name);
    $stmt->execute();

    header("Location: products.php");
    exit;
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h2>Tambah Produk</h2>
        <form method="post" enctype="multipart/form-data" style="max-width:600px;">
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" value="10">
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label>Gambar Produk</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button class="btn btn-success">Simpan</button>
            <a href="products.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>