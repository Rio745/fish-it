<?php
require 'admin_only.php';

$id = (int)$_GET['id'];

$stmt = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die("Produk tidak ditemukan");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];
    $price = (int)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $desc = $_POST['description'];

    $img_path = $product['image'];

    // upload gambar baru jika ada
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $img_path = "uploads/" . time() . "_" . rand(100, 999) . "." . $ext;
        move_uploaded_file($file['tmp_name'], "../" . $img_path);
    }

    $stmt = $mysqli->prepare("UPDATE products SET title=?, description=?, price=?, stock=?, image=? WHERE id=?");
    $stmt->bind_param("ssiisi", $title, $desc, $price, $stock, $img_path, $id);
    $stmt->execute();

    header("Location: products.php");
    exit;
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-5">
        <h2>Edit Produk</h2>
        <form method="post" enctype="multipart/form-data" style="max-width:600px;">
            <label class="mt-2">Nama Produk</label>
            <input name="title" class="form-control" value="<?= e($product['title']) ?>">

            <label class="mt-2">Harga</label>
            <input type="number" name="price" class="form-control" value="<?= e($product['price']) ?>">

            <label class="mt-2">Stock</label>
            <input type="number" name="stock" class="form-control" value="<?= e($product['stock']) ?>">

            <label class="mt-2">Deskripsi</label>
            <textarea name="description" class="form-control"><?= e($product['description']) ?></textarea>

            <label class="mt-2">Gambar Saat Ini</label><br>
            <img src="../<?= $product['image'] ?>" width="120">

            <label class="mt-2">Ganti Gambar (opsional)</label>
            <input type="file" name="image" class="form-control">

            <button class="btn btn-primary mt-3">Update</button>
            <a href="products.php" class="btn btn-secondary mt-3">Kembali</a>
        </form>
    </div>

</body>

</html>