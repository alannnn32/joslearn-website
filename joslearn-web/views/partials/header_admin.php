<?php
/**
 * Header Admin - Template Terpusat
 * Digunakan di semua halaman admin untuk konsistensi tampilan
 */

// Set tanggal hari ini dalam format Indonesia
$hari_ini = new DateTime();
$hari = $hari_ini->format('l');
$tanggal = $hari_ini->format('d F Y');

// Array hari dalam bahasa Indonesia
$hari_indonesia = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];

$nama_hari = $hari_indonesia[$hari] ?? $hari;
$tanggal_formatted = $nama_hari . ', ' . $tanggal;
?>

<!-- TOP HEADER -->
<div class="top-header">
    <div class="header-left-info">
        <div>
            <span class="header-semester">TAHUN AJARAN 2024/2025 • SEMESTER GENAP</span>
        </div>
        <div class="header-date"><?= $tanggal_formatted ?></div>
    </div>
    
    <div class="header-right">
        <div class="header-search">
            <i data-lucide="search" class="header-search-icon"></i>
            <input type="text" class="header-search-input" placeholder="Cari data siswa, kelas...">
        </div>
        
        <button class="header-icon-btn" title="Notifikasi">
            <i data-lucide="bell" style="width: 16px; height: 16px;"></i>
        </button>
        
        <div class="header-profile">
            <div class="header-profile-info">
                <span class="header-profile-name"><?= $_SESSION['user_name'] ?? 'Admin Sekolah' ?></span>
                <span class="header-profile-role">Super Admin</span>
            </div>
            <div class="header-avatar">
                <?= isset($_SESSION['user_name']) ? strtoupper(substr($_SESSION['user_name'], 0, 2)) : 'AS' ?>
            </div>
        </div>
    </div>
</div>
