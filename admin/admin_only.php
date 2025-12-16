<?php
require '../config.php';
require '../helper.php';

if (!is_admin()) {
    header("Location: login.php");
    exit;
}
