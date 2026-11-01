<?php
/**
 * AdminController - Controller untuk manajemen admin
 * Mengelola data siswa, guru, penugasan, dan log aktivitas.
 */

class AdminController
{
    /**
     * Menampilkan dashboard admin
     */
    public function dashboard()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     * Menampilkan halaman Data Siswa (Memuat file data_siswa.php)
     */
    public function student_master()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        require_once __DIR__ . '/../views/admin/data_siswa.php';
    }

    /**
     * Menampilkan halaman Data Guru
     */
    public function teacher_master()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        require_once __DIR__ . '/../views/admin/teacher_master.php';
    }

    /**
     * Menampilkan halaman Penugasan Guru
     */
    public function teacher_assignment()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        require_once __DIR__ . '/../views/admin/teacher_assignment.php';
    }

    /**
     * Menampilkan halaman Pengajuan Izin
     */
    public function leave_requests()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        require_once __DIR__ . '/../views/admin/leave_requests.php';
    }

    /**
     * Menampilkan halaman Rekap Absensi
     */
    public function attendance_recap()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        require_once __DIR__ . '/../views/admin/attendance_recap.php';
    }
}