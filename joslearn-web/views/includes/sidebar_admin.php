<?php
/**
 * Sidebar Portal Admin Sekolah (Routing Berbasis Controller)
 */

if (!function_exists('e')) {
    function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}

/** Base path projek otomatis */
if (!function_exists('jl_root')) {
    function jl_root() {
        if (defined('BASE_URL')) return rtrim(BASE_URL, '/');
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
        $pos = strpos($script, '/index.php');
        if ($pos !== false) {
            return substr($script, 0, $pos);
        }
        $posViews = strpos($script, '/views/');
        return $posViews !== false ? substr($script, 0, $posViews) : rtrim(dirname($script), '/\\');
    }
}

/** URL routing admin: jl_admin_route('admin', 'student_master') */
if (!function_exists('jl_admin_route')) {
    function jl_admin_route($controller, $action) {
        return jl_root() . '/index.php?controller=' . $controller . '&action=' . $action;
    }
}

// Daftar Menu disesuaikan dengan Controller & Action router Anda
$menuUtama = [
    ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'bi-grid-1x2', 'ctrl' => 'admin', 'act' => 'dashboard'],
];

$menuDataMaster = [
    ['key' => 'data_siswa', 'label' => 'Data Siswa', 'icon' => 'bi-people', 'ctrl' => 'admin', 'act' => 'student_master'],
    ['key' => 'data_guru',  'label' => 'Data Guru',  'icon' => 'bi-person-badge', 'ctrl' => 'admin', 'act' => 'teacher_master'],
    ['key' => 'penugasan',  'label' => 'Penugasan',  'icon' => 'bi-grid-3x3', 'ctrl' => 'admin', 'act' => 'teacher_assignment'],
];

$menuAbsensi = [
    ['key' => 'pengajuan_izin', 'label' => 'Pengajuan Izin', 'icon' => 'bi-check2-circle', 'ctrl' => 'admin', 'act' => 'leave_requests'],
    ['key' => 'rekap_absensi',  'label' => 'Rekap Absensi',  'icon' => 'bi-journal-text', 'ctrl' => 'admin', 'act' => 'attendance_recap'],
];

$menuRapor = [
    ['key' => 'verifikasi_rapor', 'label' => 'Verifikasi Rapor', 'icon' => 'bi-file-earmark-check', 'ctrl' => 'admin', 'act' => 'report_verification'],
    ['key' => 'data_rapor',        'label' => 'Data Rapor',        'icon' => 'bi-file-earmark-richtext', 'ctrl' => 'admin', 'act' => 'report_data'],
];

$menuSistem = [
    ['key' => 'log_aktivitas', 'label' => 'Log Aktivitas', 'icon' => 'bi-clock-history', 'ctrl' => 'admin', 'act' => 'log_aktivitas'],
    ['key' => 'pengaturan',    'label' => 'Pengaturan',    'icon' => 'bi-gear', 'ctrl' => 'admin', 'act' => 'pengaturan'],
];

// ---- Tentukan Menu Aktif Berdasarkan URL Action yang Sedang Dibuka ----
$currentAction = $_GET['action'] ?? 'dashboard';
$activeKey = !empty($activeMenu) ? $activeMenu : $currentAction;

// Render satu kelompok menu
$renderMenu = function (array $items) use ($activeKey) {
    echo '<ul class="jl-nav">';
    foreach ($items as $m) {
        $isActive = ($m['key'] === $activeKey);
        $href     = jl_admin_route($m['ctrl'], $m['act']);

        $cls = [];
        if ($isActive)  $cls[] = 'active';

        echo '<li><a href="' . e($href) . '"'
            . ($cls ? ' class="' . e(implode(' ', $cls)) . '"' : '')
            . ($isActive ? ' aria-current="page"' : '')
            . '>';
        echo '<i class="bi ' . e($m['icon']) . '"><span>' . e($m['label']) . '</span></i>';
        echo '</a></li>';
    }
    echo '</ul>';
};
?>

<style>
    .jl-nav a.active {
        background-color: #ffffff !important;
        color: #0c56d0 !important;
        font-weight: 600;
    }
</style>

<aside class="jl-sidebar" id="jlSidebar" aria-label="Menu Utama Admin">
    <div class="jl-brand">
        <div class="logo">
            <span style="font-weight: bold; font-size: 1.2rem;">J</span>
        </div>
        <div>
            <div class="name">JosLearn</div>
        </div>
    </div>

    <nav>
        <div class="jl-nav-title">Menu Utama</div>
        <?php $renderMenu($menuUtama); ?>

        <div class="jl-nav-title mt-3">Data Master</div>
        <?php $renderMenu($menuDataMaster); ?>

        <div class="jl-nav-title mt-3">Absensi</div>
        <?php $renderMenu($menuAbsensi); ?>

        <div class="jl-nav-title mt-3">Rapor</div>
        <?php $renderMenu($menuRapor); ?>

        <div class="jl-nav-title mt-3">Sistem</div>
        <?php $renderMenu($menuSistem); ?>
    </nav>

    <div class="jl-sidebar-foot" style="border-top: 1px solid rgba(255, 255, 255, 0.15); padding-top: 12px; margin-top: auto;">
        <div style="display: flex; align-items: center; gap: 10px; padding: 0 8px;">
            <div style="background: #cfe2ff; color: #0d53de; font-weight: bold; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">
                AD
            </div>
            <div style="display: flex; flex-direction: column;">
                <span style="font-size: 0.85rem; font-weight: bold; color: #fff; line-height: 1.2;">Admin Sekolah</span>
                <span style="font-size: 0.72rem; color: #93c5fd;">Administrator</span>
            </div>
        </div>
    </div>
</aside>