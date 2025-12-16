<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // isi sesuai servermu
define('DB_NAME', 'tisu');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_error) {
    die('DB Connect Error: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
?>