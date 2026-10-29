<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('DELETE FROM siswa WHERE id = ?');
    $stmt->execute([(int)($_POST['id'] ?? 0)]);
    $_SESSION['pesan'] = $stmt->rowCount() ? 'Data siswa berhasil dihapus.' : 'Data siswa tidak ditemukan.';
}
header('Location: ../teacher/data_siswa.php');
exit;
