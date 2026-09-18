<?php
session_start();
require_once __DIR__ . '/config/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php'); exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Tafadhali jaza sehemu zote.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'] ?? $user['username'];
                $_SESSION['role'] = $user['role'] ?? 'admin';
                header('Location: index.php'); exit;
            } else {
                $error = 'Username au password si sahihi.';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#4A90E2">
    <title>Login | Mwalim Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/leo-style.css">
</head>
<body>

<div class="leo-login-page">
    <div class="leo-login-logo"><i class="fas fa-store"></i></div>
    <div class="leo-login-title">Mwalim Shop</div>
    <div class="leo-login-sub">Business Management System</div>

    <form method="post" class="leo-login-card">
        <?php if ($error): ?>
            <div style="background:#FEE2E2;color:#991B1B;padding:0.7rem 0.9rem;border-radius:10px;font-size:0.85rem;margin-bottom:1rem;">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="leo-form-row">
            <label class="leo-input-label">Username</label>
            <input type="text" name="username" class="leo-input" placeholder="Enter username" required autofocus>
        </div>

        <div class="leo-form-row">
            <label class="leo-input-label">Password</label>
            <input type="password" name="password" class="leo-input" placeholder="Enter password" required>
        </div>

        <button type="submit" class="leo-btn leo-btn--primary leo-btn--block" style="margin-top:0.5rem;">
            <i class="fas fa-sign-in-alt"></i> LOGIN
        </button>

        <p style="text-align:center;font-size:0.75rem;color:#9CA3AF;margin-top:1rem;">
            Default: <strong>admin</strong> / <strong>admin123</strong>
        </p>
    </form>
</div>

</body>
</html>
