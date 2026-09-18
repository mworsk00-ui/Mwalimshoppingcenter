<?php
// Auth Guard - kila page inayohitaji login
if (session_status() === PHP_SESSION_NONE) session_start();

$current = basename($_SERVER['PHP_SELF'] ?? '');
$public_pages = ['login.php', 'logout.php'];

if (!in_array($current, $public_pages) && !isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
