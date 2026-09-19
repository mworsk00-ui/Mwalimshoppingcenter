<?php
/**
 * Flash message helper.
 * Usage:  flash('success', 'Saved!');  header('Location: ...');
 * Session is started in includes/header.php. This file only guards.
 */

if (session_status() === PHP_SESSION_NONE) {
    // Only start if headers not sent yet (prevents warnings)
    if (!headers_sent()) {
        session_start();
    }
}

function flash(string $type, string $message): void {
    if (session_status() === PHP_SESSION_ACTIVE) {
        $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
    }
}

function flash_render(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) return;
    if (empty($_SESSION['flash'])) return;
    $items = $_SESSION['flash'];
    unset($_SESSION['flash']);
    echo '<script>window.__LEO_FLASH__ = ' . json_encode($items) . ';</script>';
}