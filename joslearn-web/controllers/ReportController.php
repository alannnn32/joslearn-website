<?php
/**
 * ReportController - Controller untuk manajemen raport
 * Menangani input nilai guru mapel, verifikasi, dan penerbitan rapor.
 */

class ReportController
{
    /**
     * Menampilkan halaman Data Raport (index)
     */
    public function index()
    {
        // Pastikan user sudah login dan memiliki role admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        // Load view data raport
        require_once __DIR__ . '/../views/admin/report_data.php';
    }

    /**
     * Menampilkan halaman Verifikasi Raport
     */
    public function verification()
    {
        // Pastikan user sudah login dan memiliki role admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        // Load view verifikasi raport
        require_once __DIR__ . '/../views/admin/report_verification.php';
    }

    /**
     * Menampilkan form edit raport
     */
    public function edit()
    {
        // Pastikan user sudah login dan memiliki role admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header("Location: index.php?controller=report&action=index");
            exit;
        }

        // TODO: Load data raport berdasarkan ID dari database
        // Untuk sementara redirect ke index
        header("Location: index.php?controller=report&action=index");
        exit;
    }
}
