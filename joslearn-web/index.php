<?php
/**
 * Main Entry Point / Router System JosLearn.
 */

// TODO: Implement routing dan session authentication.
require_once __DIR__ . '/config/constants.php';
/**
 * index.php - Router sederhana JosLearn
 */
session_start();
date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/config/constants.php';

// Tampilkan error saat pengembangan saja
if (defined('DEV_MODE') && DEV_MODE) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

require_once __DIR__ . '/controllers/AuthController.php';

$page   = $_GET['page'] ?? 'login';
$auth   = new AuthController();
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

switch ($page) {
    case 'new_password':
        $isPost ? $auth->saveNewPassword() : $auth->showNewPassword();
        break;

    case 'login':
        require __DIR__ . '/views/auth/login.php';
        break;

    case 'verify_otp':
        require __DIR__ . '/views/auth/verify_otp.php';
        break;

    default:
        http_response_code(404);
        echo 'Halaman tidak ditemukan.';
}
echo "JosLearn Web";
