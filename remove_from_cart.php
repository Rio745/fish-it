<?php
require 'config.php';
require 'helper.php';

// Menangkap ID produk yang akan dihapus dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0 && isset($_SESSION['cart'])) {
    // Mencari index produk di dalam array sesi keranjang
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] == $id) {
            // Menghapus produk dari array berdasarkan index
            unset($_SESSION['cart'][$index]);
            
            // Re-index array agar urutannya tetap rapi (opsional)
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            break; 
        }
    }
}

// Setelah dihapus, langsung alihkan kembali ke halaman keranjang
header('Location: cart.php');
exit;