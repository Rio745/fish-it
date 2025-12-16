<?php
require 'config.php';
require 'helper.php';
if (!isset($_POST['qty'])) {
    header('Location: cart.php');
    exit;
}
$qtys = $_POST['qty'];
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

foreach ($_SESSION['cart'] as $k => $item) {
    $id = $item['id'];
    if (isset($qtys[$id])) {
        $q = max(1, (int)$qtys[$id]);
        $_SESSION['cart'][$k]['qty'] = $q;
    }
}
header('Location: cart.php');
exit;
