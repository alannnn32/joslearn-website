<?php
/**
 * views/includes/sidebar_admin.php
 * Sidebar Portal Admin Sekolah. Dipanggil otomatis oleh header.php.
 * 
 * CARA KERJA NAVIGASI:
 * - Tiap menu mengarah langsung ke file di views/admin/ (mis. dashboard.php),
 *   sehingga bisa dibuka lewat php -S, XAMPP, maupun Laragon tanpa router tambahan.
 * - Jika menu belum memiliki file halaman, menu akan tampil redup (is-soon)
 *   dan saat diklik muncul notifikasi toast "belum tersedia", bukan error 404.
 * - Menu aktif ditentukan otomatis dari nama file yang sedang dibuka,
 *   namun $activeMenu (jika di-set di halaman) tetap diprioritaskan.
 */

if (!function_exists('e')) {
    function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}

/** Base path projek, mis. '' (php -S) atau '/joslearn-website' (XAMPP/Laragon). */
if (!function_exists('jl_root')) {
    function jl_root() {
        if (defined('BASE_URL')) return rtrim(BASE_URL, '/');
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
        $pos = strpos($script, '/views/');
        return $pos !== false ? substr($script, 0, $pos) : rtrim(dirname($script), '/\\');
    }
}

/** URL halaman portal admin: jl_admin_page('dashboard.php') */
if (!function_exists('jl_admin_page')) {
    function jl_admin_page($file) {
        if (defined('USE_CLEAN_URL') && USE_CLEAN_URL) {
            return jl_root() . '/admin/' . preg_replace('/\.php$/', '', $file);
        }
        return jl_root() . '/views/admin/' . $file;
    }
}

// Struktur Daftar Menu Admin Sekolah Berdasarkan Referensi
$menuUtama = [
    ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'bi-grid-1x2', 'file' => 'dashboard.php'],
];

$menuDataMaster = [
    ['key' => 'data_siswa', 'label' => 'Data Siswa', 'icon' => 'bi-people', 'file' => 'data_siswa.php'],
    ['key' => 'data_guru',  'label' => 'Data Guru',  'icon' => 'bi-person-badge', 'file' => 'data_guru.php'],
    ['key' => 'penugasan',  'label' => 'Penugasan',  'icon' => 'bi-grid-3x3', 'file' => 'penugasan.php'],
];

$menuAbsensi = [
    ['key' => 'pengajuan_izin', 'label' => 'Pengajuan Izin', 'icon' => 'bi-check2-circle', 'file' => 'pengajuan_izin.php'],
    ['key' => 'rekap_absensi',  'label' => 'Rekap Absensi',  'icon' => 'bi-journal-text', 'file' => 'rekap_absensi.php'],
];

$menuRapor = [
    ['key' => 'verifikasi_rapor', 'label' => 'Verifikasi Rapor', 'icon' => 'bi-file-earmark-check', 'file' => 'verifikasi_rapor.php'],
    ['key' => 'data_rapor',        'label' => 'Data Rapor',        'icon' => 'bi-file-earmark-richtext', 'file' => 'data_rapor.php'],
];

$menuSistem = [
    ['key' => 'log_aktivitas', 'label' => 'Log Aktivitas', 'icon' => 'bi-clock-history', 'file' => 'log_aktivitas.php'],
    ['key' => 'pengaturan',    'label' => 'Pengaturan',    'icon' => 'bi-gear', 'file' => 'pengaturan.php'],
];

// ---- Tentukan Menu Aktif ----
$currentFile = basename(parse_url($_SERVER['SCRIPT_NAME'] ?? '', PHP_URL_PATH) ?: '');
$activeKey   = !empty($activeMenu) ? $activeMenu : '';
if ($activeKey === '') {
    $allMenus = array_merge($menuUtama, $menuDataMaster, $menuAbsensi, $menuRapor, $menuSistem);
    foreach ($allMenus as $m) {
        $files = array_merge($m['file'] ? [$m['file']] : [], $m['also'] ?? []);
        if (in_array($currentFile, $files, true)) { 
            $activeKey = $m['key']; 
            break; 
        }
    }
}

// Cek folder fisik halaman di views/admin/
$adminDir = realpath(__DIR__ . '/../admin') ?: (__DIR__ . '/../admin');
$pageExists = function ($file) use ($adminDir) {
    return $file && is_file($adminDir . DIRECTORY_SEPARATOR . $file);
};

// Render satu kelompok menu
$renderMenu = function (array $items) use ($activeKey, $pageExists) {
    echo '<ul class="jl-nav">';
    foreach ($items as $m) {
        $isActive = ($m['key'] === $activeKey);
        $ready    = $pageExists($m['file'] ?? null);
        $href     = $ready ? jl_admin_page($m['file']) : '#';

        $cls = [];
        if ($isActive)  $cls[] = 'active';
        if (!$ready)    $cls[] = 'is-soon';

        echo '<li><a href="' . e($href) . '"'
            . ($cls ? ' class="' . e(implode(' ', $cls)) . '"' : '')
            . ($isActive ? ' aria-current="page"' : '')
            . (!$ready ? ' data-soon="' . e($m['label']) . '" title="Halaman belum tersedia" aria-disabled="true"' : '')
            . '>';
        echo '<i class="bi ' . e($m['icon']) . '"><span>' . e($m['label']) . '</span></i>';
        echo '</a></li>';
    }
    echo '</ul>';
};
?>

<style>
    /* Styling tambahan khusus sidebar jika belum ter-cover di CSS utama */
    .jl-nav a.is-soon { opacity: .55; cursor: not-allowed; }
    .jl-nav a.is-soon:hover { background: transparent; }
    .jl-toast { 
        position: fixed; left: 50%; bottom: 28px; transform: translateX(-50%) translateY(20px); 
        background: #1d2939; color: #fff; font-size: .82rem; padding: 10px 16px; border-radius: 10px; 
        opacity: 0; pointer-events: none; z-index: 2000; transition: opacity .2s ease, transform .2s ease; 
        box-shadow: 0 8px 24px rgba(16,24,40,.25); 
    }
    .jl-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
</style>

<aside class="jl-sidebar" id="jlSidebar" aria-label="Menu Utama Admin">
    <!-- Brand / Logo -->
    <div class="jl-brand">
        <div class="logo">
            <span style="font-weight: bold; font-size: 1.2rem;">J</span>
        </div>
        <div>
            <div class="name">JosLearn</div>
        </div>
    </div>

    <!-- Navigasi Sidebar -->
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

    <!-- Footer Sidebar: Info Profil Admin Sekolah -->
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

<div class="jl-backdrop" id="jlBackdrop"></div>
<div class="jl-toast" id="jlToast" role="status" aria-live="polite"></div>

<script>
(function () {
    var toast = document.getElementById('jlToast'), t;
    function show(msg) {
        toast.textContent = msg;
        toast.classList.add('show');
        clearTimeout(t);
        t = setTimeout(function () { toast.classList.remove('show'); }, 2200);
    }
    // Jika menu belum ada filenya, cegah pindah halaman dan tampilkan toast info
    document.querySelectorAll('#jlSidebar a[data-soon]').forEach(function (a) {
        a.addEventListener('click', function (ev) {
            ev.preventDefault();
            show('Halaman "' + a.dataset.soon + '" belum tersedia.');
        });
    });
})();
</script>