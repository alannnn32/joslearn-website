<?php
// Koneksi database (PDO) -> variabel $pdo
// Sesuaikan host, nama database, user, dan password dengan server kamu.
$db_host = 'localhost';
$db_name = 'db_sekolah_login';
$db_user = 'root';
$db_pass = '';   // XAMPP/Laragon biasanya kosong

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die('Koneksi database gagal: ' . $e->getMessage());
}
