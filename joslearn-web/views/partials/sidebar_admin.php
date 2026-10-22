<?php
/**
 * Sidebar Admin - Template Terpusat
 * Digunakan di semua halaman admin untuk konsistensi tampilan
 */

// Deteksi halaman aktif berdasarkan controller dan action
$current_controller = $_GET['controller'] ?? 'admin';
$current_action = $_GET['action'] ?? 'dashboard';

// Function untuk mengecek active state
function isMenuActive($controller, $action, $current_controller, $current_action) {
    return ($controller == $current_controller && $action == $current_action) ? 'active' : '';
}
?>

<!-- SIDEBAR -->
<div class="sidebar">
    <div>
        <!-- Brand / Logo -->
        <div class="sidebar-brand">
            <div class="logo-box">J</div>
            <span class="fw-bold fs-5 text-white">JosLearn</span>
        </div>

        <!-- Menu List -->
        <div class="sidebar-menu">
            <!-- Menu Utama -->
            <div class="menu-category">Menu Utama</div>
            <a href="index.php?controller=admin&action=dashboard" class="nav-link <?= isMenuActive('admin', 'dashboard', $current_controller, $current_action) ?>">
                <i data-lucide="layout-dashboard" style="width: 18px; height: 18px;"></i> Dashboard
            </a>

            <!-- Data Master -->
            <div class="menu-category">Data Master</div>
            <a href="index.php?controller=admin&action=student_master" class="nav-link <?= isMenuActive('admin', 'student_master', $current_controller, $current_action) ?>">
                <i data-lucide="users" style="width: 18px; height: 18px;"></i> Data Siswa
            </a>
            <a href="index.php?controller=admin&action=teacher_master" class="nav-link <?= isMenuActive('admin', 'teacher_master', $current_controller, $current_action) ?>">
                <i data-lucide="user-check" style="width: 18px; height: 18px;"></i> Data Guru
            </a>
            <a href="index.php?controller=admin&action=teacher_assignment" class="nav-link <?= isMenuActive('admin', 'teacher_assignment', $current_controller, $current_action) ?>">
                <i data-lucide="grid" style="width: 18px; height: 18px;"></i> Penugasan
            </a>

            <!-- Absensi -->
            <div class="menu-category">Absensi</div>
            <a href="index.php?controller=admin&action=leave_requests" class="nav-link <?= isMenuActive('admin', 'leave_requests', $current_controller, $current_action) ?>">
                <i data-lucide="check-square" style="width: 18px; height: 18px;"></i> Pengajuan Izin
            </a>
            <a href="index.php?controller=admin&action=attendance_recap" class="nav-link <?= isMenuActive('admin', 'attendance_recap', $current_controller, $current_action) ?>">
                <i data-lucide="file-spreadsheet" style="width: 18px; height: 18px;"></i> Rekap Absensi
            </a>

            <!-- Rapor -->
            <div class="menu-category">Rapor</div>
            <a href="index.php?controller=report&action=verification" class="nav-link <?= isMenuActive('report', 'verification', $current_controller, $current_action) ?>">
                <i data-lucide="file-check" style="width: 18px; height: 18px;"></i> Verifikasi Rapor
            </a>
            <a href="index.php?controller=report&action=index" class="nav-link <?= isMenuActive('report', 'index', $current_controller, $current_action) ?>">
                <i data-lucide="folder-kanban" style="width: 18px; height: 18px;"></i> Data Rapor
            </a>

            <!-- Sistem -->
            <div class="menu-category">Sistem</div>
            <a href="#" class="nav-link">
                <i data-lucide="history" style="width: 18px; height: 18px;"></i> Log Aktivitas
            </a>
            <a href="#" class="nav-link">
                <i data-lucide="settings" style="width: 18px; height: 18px;"></i> Pengaturan
            </a>
        </div>
    </div>

    <!-- Sidebar Footer Profile -->
    <div class="sidebar-footer">
        <div class="sidebar-avatar">
            <?= isset($_SESSION['user_name']) ? strtoupper(substr($_SESSION['user_name'], 0, 2)) : 'AS' ?>
        </div>
        <div class="sidebar-user-info">
            <span class="sidebar-user-name"><?= $_SESSION['user_name'] ?? 'Admin Sekolah' ?></span>
            <span class="sidebar-user-role">Administrator</span>
        </div>
    </div>
</div>
