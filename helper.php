<?php

function e($v)
{
    return htmlspecialchars($v ?? '', ENT_QUOTES);
}
function url($path = '')
{
    return '/' . ltrim($path, '/');
} // adjust base if not root
function is_logged_in()
{
    return !empty($_SESSION['user']);
}
function is_admin()
{
    return is_logged_in() && !empty($_SESSION['user']['is_admin']);
}
