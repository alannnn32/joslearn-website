<?php
/**
 * views/includes/sidebar_teacher.php
 * Sidebar Portal Guru & Wali Kelas. Dipanggil otomatis oleh header.php.
 * Style-nya ada di header.php (class jl-*).
 *
 * CARA KERJA NAVIGASI
 * - Tiap menu mengarah langsung ke file di views/teacher/ (mis. dashboard.php),
 *   jadi bisa dibuka lewat `php -S`, XAMPP, maupun Laragon tanpa router.
 * - Jika menu belum punya file halaman (atau file belum dibuat tim), menu tampil
 *   redup dan saat diklik muncul info "belum tersedia", bukan error 404.
 *   Begitu file-nya ada di views/teacher/, menu otomatis aktif tanpa ubah kode.
 * - Menu aktif ditentukan otomatis dari nama file yang sedang dibuka.
 *   $activeMenu (jika di-set halaman) tetap diprioritaskan.
 * - Opsional (config/constants.php):
 *     define('BASE_URL', '/joslearn-website/');   // jika base path tidak terdeteksi benar
 *     define('USE_CLEAN_URL', true);              // jika .htaccess + index.php router sudah jalan
 *                                                 // (link jadi /teacher/dashboard, tanpa .php)
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

/** URL halaman portal guru: jl_teacher_page('dashboard.php') */
if (!function_exists('jl_teacher_page')) {
    function jl_teacher_page($file) {
        if (defined('USE_CLEAN_URL') && USE_CLEAN_URL) {
            return jl_root() . '/teacher/' . preg_replace('/\.php$/', '', $file);
        }
        return jl_root() . '/views/teacher/' . $file;
    }
}

$isWali = !empty($kelasWali);

// 'file'  => nama file di views/teacher/ (null = memang belum ada di struktur projek)
// 'also'  => file lain yang tetap menandai menu ini sebagai aktif
$menuUtama = [
    ['key' => 'dashboard',   'label' => 'Dashboard',       'icon' => 'bi-grid-1x2',      'file' => 'dashboard.php'],
    ['key' => 'jadwal',      'label' => 'Jadwal Mengajar', 'icon' => 'bi-calendar3',     'file' => null],
    ['key' => 'kelas',       'label' => 'Kelas Diampu',    'icon' => 'bi-people',        'file' => null],
    ['key' => 'bobot',       'label' => 'Bobot Penilaian', 'icon' => 'bi-sliders',       'file' => null],
    ['key' => 'input_nilai', 'label' => 'Input Nilai',     'icon' => 'bi-pencil-square', 'file' => 'report_subject_grades.php'],
    ['key' => 'absensi',     'label' => 'Absensi',         'icon' => 'bi-person-check',  'file' => 'attendance_manage.php'],
];

$menuWali = [
    ['key' => 'validasi_rapor', 'label' => 'Validasi Rapor', 'icon' => 'bi-patch-check', 'file' => 'report_class_select.php',
     'also' => ['report_student_list.php', 'report_input_mode.php', 'report_summary.php'], 'badge' => $kelasWali ?? ''],
];

$menuAkun = [
    ['key' => 'profil',     'label' => 'Profil',     'icon' => 'bi-person', 'file' => null],
    ['key' => 'pengaturan', 'label' => 'Pengaturan', 'icon' => 'bi-gear',   'file' => 'pengaturan_guru.php'],
];

// ---- Tentukan menu aktif ----
$currentFile = basename(parse_url($_SERVER['SCRIPT_NAME'] ?? '', PHP_URL_PATH) ?: '');
$activeKey   = !empty($activeMenu) ? $activeMenu : '';
if ($activeKey === '') {
    foreach (array_merge($menuUtama, $menuWali, $menuAkun) as $m) {
        $files = array_merge($m['file'] ? [$m['file']] : [], $m['also'] ?? []);
        if (in_array($currentFile, $files, true)) { $activeKey = $m['key']; break; }
    }
}

// Cek file halaman benar-benar ada (folder views/teacher/ bersebelahan dengan views/includes/)
$teacherDir = realpath(__DIR__ . '/../teacher') ?: (__DIR__ . '/../teacher');
$pageExists = function ($file) use ($teacherDir) {
    return $file && is_file($teacherDir . DIRECTORY_SEPARATOR . $file);
};

// Logout: boleh di-override halaman dengan men-set $logoutUrl sebelum include header.
// TODO: sesuaikan dengan aksi logout di AuthController (harus menghapus session).
if (empty($logoutUrl)) {
    $logoutUrl = jl_root() . '/controllers/AuthController.php?action=logout';
}

// Render satu daftar menu
$renderMenu = function (array $items) use ($activeKey, $pageExists) {
    echo '<ul class="jl-nav">';
    foreach ($items as $m) {
        $isActive = ($m['key'] === $activeKey);
        $ready    = $pageExists($m['file'] ?? null);
        $href     = $ready ? jl_teacher_page($m['file']) : '#';

        $cls = [];
        if ($isActive)  $cls[] = 'active';
        if (!$ready)    $cls[] = 'is-soon';

        echo '<li><a href="' . e($href) . '"'
           . ($cls ? ' class="' . e(implode(' ', $cls)) . '"' : '')
           . ($isActive ? ' aria-current="page"' : '')
           . (!$ready ? ' data-soon="' . e($m['label']) . '" title="Halaman belum tersedia" aria-disabled="true"' : '')
           . '>';
        echo '<i class="bi ' . e($m['icon']) . '"></i><span>' . e($m['label']) . '</span>';
        if (!empty($m['badge'])) echo '<span class="jl-badge">' . e($m['badge']) . '</span>';
        echo '</a></li>';
    }
    echo '</ul>';
};
?>
<style>
    /* Menu yang halamannya belum ada */
    .jl-nav a.is-soon { opacity: .55; cursor: not-allowed; }
    .jl-nav a.is-soon:hover { background: transparent; }
    .jl-toast { position: fixed; left: 50%; bottom: 28px; transform: translateX(-50%) translateY(20px); background: #1d2939; color: #fff;
                font-size: .82rem; padding: 10px 16px; border-radius: 10px; opacity: 0; pointer-events: none; z-index: 2000;
                transition: opacity .2s ease, transform .2s ease; box-shadow: 0 8px 24px rgba(16,24,40,.25); }
    .jl-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
</style>

<aside class="jl-sidebar" id="jlSidebar" aria-label="Menu utama">
    <div class="jl-brand">
        <div class="logo">
            <!-- Ganti dengan logo: <img src="<?= e(jl_root() . '/assets/images/NAMA_LOGO.png') ?>" alt="Logo JosLearn"> -->
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div>
            <div class="name">JosLearn</div>
            <div class="school">SMAN 1<br>REJOSO</div>
        </div>
    </div>

    <div class="jl-role"><?= $isWali ? 'ROLE: GURU &amp; WALI KELAS' : 'ROLE: GURU' ?></div>

    <nav>
        <?php $renderMenu($menuUtama); ?>

        <?php if ($isWali): ?>
            <div class="jl-nav-title">Otoritas Wali Kelas</div>
            <?php $renderMenu($menuWali); ?>
        <?php endif; ?>

        <div class="mt-3"><?php $renderMenu($menuAkun); ?></div>
    </nav>

    <div class="jl-sidebar-foot">
        <ul class="jl-nav">
            <li><a href="<?= e($logoutUrl) ?>" class="logout" id="jlLogout"><i class="bi bi-box-arrow-left"></i><span>Keluar Portal</span></a></li>
        </ul>
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
    // Menu yang belum ada halamannya: jangan pindah halaman, beri info saja
    document.querySelectorAll('#jlSidebar a[data-soon]').forEach(function (a) {
        a.addEventListener('click', function (ev) {
            ev.preventDefault();
            show('Halaman "' + a.dataset.soon + '" belum tersedia.');
        });
    });
    // Konfirmasi sebelum keluar
    var lo = document.getElementById('jlLogout');
    if (lo) lo.addEventListener('click', function (ev) {
        if (!confirm('Keluar dari Portal Guru?')) ev.preventDefault();
    });
})();
</script>