<?php
require 'admin_only.php';

$id = (int)$_GET['id'];

$stmt = $mysqli->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: products.php");
exit;
?>