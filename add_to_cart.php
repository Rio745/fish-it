<?php
require 'config.php';
require 'helper.php';

$id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$qty = isset($_POST['qty']) ? max(1, (int)$_POST['qty']) : 1;

$stmt = $mysqli->prepare("SELECT id, title, price, image FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$p = $res->fetch_assoc();
if (!$p) {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$found = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $p['id']) {
        $item['qty'] += $qty;
        $found = true;
        break;
    }
}
if (!$found) {
    $_SESSION['cart'][] = ['id' => $p['id'], 'title' => $p['title'], 'price' => $p['price'], 'qty' => $qty, 'image' => $p['image']];
}

header('Location: cart.php');
exit;
