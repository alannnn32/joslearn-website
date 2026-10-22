<?php
/**
 * File test untuk mengakses dashboard admin
 * Set session admin dummy untuk testing
 */
session_start();

// Set session dummy untuk admin
$_SESSION['user_id'] = 1;
$_SESSION['user_role'] = 'admin';
$_SESSION['user_name'] = 'Admin Sekolah';
$_SESSION['user_email'] = 'admin@joslearn.id';

// Ambil action dari parameter atau default ke dashboard
$action = $_GET['action'] ?? 'dashboard';

// Redirect ke halaman yang diminta
header("Location: index.php?controller=admin&action=" . $action);
exit;
