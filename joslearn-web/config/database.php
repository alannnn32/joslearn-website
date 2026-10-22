<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier']);
    $password   = trim($_POST['password']);

    if (empty($identifier) || empty($password)) {
        die("Username/NIS/NIP dan Password harus diisi!");
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE identifier = ?");
    $stmt->execute([$identifier]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($password, $user['password_hash'])) {
            // Simpan informasi pengguna ke dalam Session
            $_SESSION['user_id']      = $user['id'];
            $_SESSION['nama_lengkap']  = $user['nama_lengkap'];
            $_SESSION['role']          = $user['role'];

            header("Location: dashboard.php");
            exit;
        } else {
            echo "<script>alert('Password salah!'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Username / NIS / NIP tidak ditemukan!'); window.location.href='login.php';</script>";
    }
} else {
    header("Location: login.php");
    exit;
}
?>