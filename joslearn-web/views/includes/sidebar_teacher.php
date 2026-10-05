<?php
/**
 * views/includes/sidebar_teacher.php
 * Sidebar Portal Guru & Wali Kelas. Dipanggil otomatis oleh header.php.
 * Style-nya ada di header.php (class jl-*).
 *
 * Memakai: $activeMenu, $kelasWali (dari header.php), fungsi jl_url() dan e().
 * Route yang belum punya halaman di struktur projek diisi '#'.
 * Ganti dengan route yang benar setelah halamannya dibuat tim.
 */

$isWali = !empty($kelasWali);

$menuUtama = [
    ['key' => 'dashboard',    'label' => 'Dashboard',       'icon' => 'bi-grid-1x2',        'href' => jl_url('teacher/dashboard')],
    ['key' => 'jadwal',       'label' => 'Jadwal Mengajar', 'icon' => 'bi-calendar3',       'href' => '#'],                                  // TODO route
    ['key' => 'kelas',        'label' => 'Kelas Diampu',    'icon' => 'bi-people',          'href' => '#'],                                  // TODO route
    ['key' => 'bobot',        'label' => 'Bobot Penilaian', 'icon' => 'bi-sliders',         'href' => '#'],                                  // TODO route
    ['key' => 'input_nilai',  'label' => 'Input Nilai',     'icon' => 'bi-pencil-square',   'href' => jl_url('teacher/report_subject_grades')],
    ['key' => 'absensi',      'label' => 'Absensi',         'icon' => 'bi-person-check',    'href' => jl_url('teacher/attendance_manage')],
];

$menuWali = [
    ['key' => 'validasi_rapor', 'label' => 'Validasi Rapor', 'icon' => 'bi-patch-check',    'href' => jl_url('teacher/report_class_select'), 'badge' => $kelasWali],
];

$menuAkun = [
    ['key' => 'profil',       'label' => 'Profil',          'icon' => 'bi-person',          'href' => '#'],                                  // TODO route
    ['key' => 'pengaturan',   'label' => 'Pengaturan',      'icon' => 'bi-gear',            'href' => '#'],                                  // TODO route
];

// Render satu daftar menu
$renderMenu = function (array $items) use ($activeMenu) {
    echo '<ul class="jl-nav">';
    foreach ($items as $m) {
        $active = ($m['key'] === $activeMenu) ? ' active' : '';
        echo '<li><a href="' . e($m['href']) . '" class="' . trim($active) . '"' . ($active ? ' aria-current="page"' : '') . '>';
        echo '<i class="bi ' . e($m['icon']) . '"></i><span>' . e($m['label']) . '</span>';
        if (!empty($m['badge'])) echo '<span class="jl-badge">' . e($m['badge']) . '</span>';
        echo '</a></li>';
    }
    echo '</ul>';
};
?>
<aside class="jl-sidebar" id="jlSidebar" aria-label="Menu utama">
    <div class="jl-brand">
        <div class="logo">
            <!-- Ganti dengan logo: <img src="<?= e(jl_url('assets/images/NAMA_LOGO.png')) ?>" alt="Logo JosLearn"> -->
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
            <li><a href="<?= e(jl_url('auth/logout')) ?>" class="logout"><i class="bi bi-box-arrow-left"></i><span>Keluar Portal</span></a></li>
        </ul>
    </div>
</aside>
<div class="jl-backdrop" id="jlBackdrop"></div>