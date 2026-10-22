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
        // Pastikan user sudah login dan memiliki role admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        // Load view dashboard admin
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     * Menampilkan halaman Data Siswa
     */
    public function studentMaster()
    {
        // Pastikan user sudah login dan memiliki role admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        // Load view student master
        require_once __DIR__ . '/../views/admin/student_master.php';
    }

    /**
     * Menampilkan halaman Data Guru
     */
    public function teacherMaster()
    {
        // Pastikan user sudah login dan memiliki role admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        // Load view teacher master
        require_once __DIR__ . '/../views/admin/teacher_master.php';
    }

    /**
     * Menampilkan halaman Penugasan Guru
     */
    public function teacherAssignment()
    {
        // Pastikan user sudah login dan memiliki role admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        // Load view teacher assignment
        require_once __DIR__ . '/../views/admin/teacher_assignment.php';
    }

    /**
     * Menampilkan halaman Pengajuan Izin
     */
    public function leaveRequests()
    {
        // Pastikan user sudah login dan memiliki role admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        // Load view leave requests
        require_once __DIR__ . '/../views/admin/leave_requests.php';
    }

    /**
     * Menampilkan halaman Rekap Absensi
     */
    public function attendanceRecap()
    {
        // Pastikan user sudah login dan memiliki role admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        // Load view attendance recap
        require_once __DIR__ . '/../views/admin/attendance_recap.php';
    }
}
