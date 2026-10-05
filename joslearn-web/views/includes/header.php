<?php
/**
 * views/includes/header.php
 * Membuka dokumen HTML, memuat sidebar sesuai role, lalu menampilkan TOPBAR
 * dan membuka area konten. Ditutup oleh footer.php.
 *
 * Variabel opsional yang bisa di-set oleh halaman SEBELUM include header:
 *   $pageTitle   judul halaman (tab browser)
 *   $activeMenu  key menu aktif di sidebar (mis. 'input_nilai')
 *
 * Data user diambil dari $_SESSION. Sesuaikan nama key-nya dengan AuthController.
 */

if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!function_exists('e')) {
    function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}

// URL helper: satu tempat untuk menyesuaikan pola URL (clean URL via .htaccess).
// Contoh hasil: jl_url('teacher/dashboard') => BASE_URL . 'teacher/dashboard'
if (!function_exists('jl_url')) {
    function jl_url($route = '') {
        $base = defined('BASE_URL') ? rtrim(BASE_URL, '/') . '/' : '/';
        return $base . ltrim($route, '/');
    }
}

// ---------- Data user & konteks (ganti fallback contoh dengan data sesungguhnya) ----------
$role         = $_SESSION['role']        ?? 'guru';                                   // 'guru' | 'admin'
$userName     = $_SESSION['nama']        ?? 'Bapak Ahmad Fauzi, M.Pd';
$userSubtitle = $_SESSION['jabatan']     ?? 'Guru Matematika & Wali Kelas XI-3';
$kelasWali    = $_SESSION['kelas_wali']  ?? 'XI-3';                                   // null/'' jika bukan wali kelas
$tahunAjaran  = $tahunAjaranAktif        ?? '2026/2027';
$semester     = $semesterAktif           ?? 'Semester Ganjil';
$dapodikOk    = $dapodikTerhubung        ?? true;
$notifCount   = $notifCount              ?? 1;

$pageTitle  = $pageTitle  ?? 'Portal Guru';
$activeMenu = $activeMenu ?? '';
$portalName = ($role === 'admin') ? 'PORTAL ADMIN' : 'PORTAL GURU';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | JosLearn - SMAN 1 Rejoso</title>

    <!-- Hapus link yang sudah dimuat di tempat lain agar tidak dobel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- CSS proyek (file yang sudah tersedia) -->
    <link href="<?= e(jl_url('assets/css/style.css')) ?>" rel="stylesheet">
    <link href="<?= e(jl_url('assets/css/dashboard.css')) ?>" rel="stylesheet">

    <style>
        /* ===== Layout portal (prefix jl-). Boleh dipindah ke assets/css/dashboard.css ===== */
        :root { --jl-sidebar-w: 240px; --jl-blue: #2347b8; --jl-blue-dark: #1d3a9e; --jl-red: #d92d20;
                --jl-border: #e3e8f0; --jl-muted: #667085; --jl-bg: #f6f8fc; }
        body { font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif; background: var(--jl-bg); color: #1d2939; }
        .jl-app { min-height: 100vh; }

        /* Sidebar */
        .jl-sidebar { position: fixed; inset: 0 auto 0 0; width: var(--jl-sidebar-w); background: #fff; border-right: 1px solid var(--jl-border);
                      display: flex; flex-direction: column; padding: 16px 14px; z-index: 1040; overflow-y: auto; transition: transform .2s ease; }
        .jl-brand { display: flex; align-items: center; gap: 10px; padding: 2px 4px 14px; }
        .jl-brand .logo { width: 38px; height: 38px; border-radius: 10px; background: var(--jl-blue); color: #fff; display: grid; place-items: center; font-size: 1.15rem; flex: none; }
        .jl-brand .logo img { width: 100%; height: 100%; object-fit: contain; border-radius: 10px; }
        .jl-brand .name { font-weight: 800; font-size: 1.02rem; line-height: 1.1; }
        .jl-brand .school { font-size: .62rem; font-weight: 600; color: var(--jl-muted); letter-spacing: .04em; line-height: 1.2; }
        .jl-role { display: inline-flex; align-items: center; gap: 6px; background: #eaf0ff; color: var(--jl-blue); font-size: .64rem; font-weight: 700;
                   letter-spacing: .04em; border-radius: 999px; padding: 4px 10px; margin: 0 0 16px 2px; }
        .jl-role::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--jl-blue); }
        .jl-nav-title { font-size: .62rem; font-weight: 700; color: #98a2b3; letter-spacing: .08em; margin: 18px 0 6px 6px; text-transform: uppercase; }
        .jl-nav { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 2px; }
        .jl-nav a { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 9px; color: #344054; font-size: .86rem; font-weight: 500; text-decoration: none; }
        .jl-nav a i { font-size: 1.02rem; color: #667085; }
        .jl-nav a:hover { background: #f2f5fb; }
        .jl-nav a.active { background: var(--jl-blue-dark); color: #fff; font-weight: 600; box-shadow: 0 4px 10px rgba(29,58,158,.25); }
        .jl-nav a.active i { color: #fff; }
        .jl-nav .jl-badge { margin-left: auto; background: #eaf0ff; color: var(--jl-blue); font-size: .62rem; font-weight: 700; border-radius: 6px; padding: 2px 7px; }
        .jl-sidebar-foot { margin-top: auto; padding-top: 14px; border-top: 1px solid var(--jl-border); }
        .jl-nav a.logout, .jl-nav a.logout i { color: var(--jl-red); font-weight: 600; }
        .jl-nav a.logout:hover { background: #fff1f0; }
        .jl-backdrop { display: none; position: fixed; inset: 0; background: rgba(16,24,40,.45); z-index: 1035; }

        /* Area utama + topbar */
        .jl-main { margin-left: var(--jl-sidebar-w); min-width: 0; }
        .jl-topbar { position: sticky; top: 0; z-index: 1030; height: 64px; background: #fff; border-bottom: 1px solid var(--jl-border);
                     display: flex; align-items: center; gap: 16px; padding: 0 24px; }
        .jl-toggle { display: none; border: 0; background: transparent; font-size: 1.5rem; padding: 0; color: #344054; }
        .jl-portal { line-height: 1.1; white-space: nowrap; }
        .jl-portal b { display: block; font-size: .8rem; font-weight: 800; }
        .jl-portal span { font-size: .62rem; font-weight: 600; color: var(--jl-muted); letter-spacing: .06em; }
        .jl-search { position: relative; flex: 0 1 360px; }
        .jl-search i.bi-search { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #98a2b3; font-size: .85rem; }
        .jl-search input { width: 100%; border: 1px solid var(--jl-border); background: #f8fafc; border-radius: 10px; padding: 8px 52px 8px 34px; font-size: .82rem; }
        .jl-search input:focus { outline: none; border-color: var(--jl-blue); background: #fff; box-shadow: 0 0 0 3px rgba(35,71,184,.12); }
        .jl-search kbd { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: #fff; border: 1px solid var(--jl-border); color: var(--jl-muted);
                         font-size: .62rem; border-radius: 5px; padding: 1px 6px; }
        .jl-period { line-height: 1.1; white-space: nowrap; font-size: .62rem; font-weight: 700; color: var(--jl-muted); letter-spacing: .05em; }
        .jl-period b { display: block; font-size: .82rem; color: #1d2939; letter-spacing: 0; }
        .jl-period .sem { display: inline-block; margin-top: 3px; font-size: .68rem; font-weight: 600; color: #344054; letter-spacing: 0; }
        .jl-status { display: inline-flex; align-items: center; gap: 6px; background: #e8f7ef; color: #067647; border-radius: 999px; padding: 5px 12px; font-size: .74rem; font-weight: 600; white-space: nowrap; }
        .jl-status::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: #12a150; }
        .jl-status.off { background: #fff1f0; color: #b42318; }
        .jl-status.off::before { background: var(--jl-red); }
        .jl-bell { position: relative; border: 0; background: transparent; font-size: 1.2rem; color: #344054; padding: 6px; }
        .jl-bell .dot { position: absolute; top: 4px; right: 3px; min-width: 9px; height: 9px; border-radius: 99px; background: var(--jl-red); border: 2px solid #fff; }
        .jl-user { display: flex; align-items: center; gap: 10px; border: 0; background: transparent; text-align: right; padding: 0; }
        .jl-user .who { line-height: 1.15; }
        .jl-user .who b { display: block; font-size: .82rem; font-weight: 700; }
        .jl-user .who span { font-size: .66rem; color: var(--jl-muted); }
        .jl-user .avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--jl-blue-dark); color: #fff; display: grid; place-items: center; font-size: 1rem; }
        .jl-content { padding: 22px 24px; }

        @media (max-width: 1199.98px) { .jl-period, .jl-status { display: none; } }
        @media (max-width: 991.98px) {
            .jl-sidebar { transform: translateX(-100%); }
            .jl-sidebar.is-open { transform: translateX(0); box-shadow: 0 0 30px rgba(16,24,40,.2); }
            .jl-backdrop.is-open { display: block; }
            .jl-main { margin-left: 0; }
            .jl-toggle { display: block; }
            .jl-topbar { padding: 0 14px; }
            .jl-search { flex: 1 1 auto; }
            .jl-user .who, .jl-portal { display: none; }
            .jl-content { padding: 16px 14px; }
        }
    </style>
</head>
<body>
<div class="jl-app">

    <?php
    // Sidebar sesuai role
    $sidebarFile = ($role === 'admin') ? 'sidebar_admin.php' : 'sidebar_teacher.php';
    if (file_exists(__DIR__ . '/' . $sidebarFile)) {
        include __DIR__ . '/' . $sidebarFile;
    }
    ?>

    <div class="jl-main">

        <!-- ================= TOPBAR ================= -->
        <header class="jl-topbar">
            <button type="button" class="jl-toggle" id="jlToggle" aria-label="Buka menu"><i class="bi bi-list"></i></button>

            <div class="jl-portal"><b>SMAN 1 REJOSO</b><span><?= e($portalName) ?></span></div>

            <!-- TODO: arahkan action ke halaman/aksi pencarian global -->
            <form class="jl-search" action="" method="get" role="search">
                <i class="bi bi-search"></i>
                <input type="search" name="q" id="jlSearch" placeholder="Cari siswa, materi, jadwal, atau kelas..." autocomplete="off">
                <kbd id="jlKbd">Ctrl K</kbd>
            </form>

            <div class="ms-auto d-flex align-items-center gap-3">
                <div class="jl-period">
                    T.A.
                    <b><?= e($tahunAjaran) ?></b>
                </div>
                <span class="jl-period"><span class="sem"><?= e($semester) ?></span></span>

                <span class="jl-status <?= $dapodikOk ? '' : 'off' ?>"><?= $dapodikOk ? 'Dapodik Terhubung' : 'Dapodik Terputus' ?></span>

                <div class="dropdown">
                    <button class="jl-bell" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-label="Notifikasi">
                        <i class="bi bi-bell"></i><?php if ($notifCount > 0): ?><span class="dot"></span><?php endif; ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-0 shadow-sm" style="width:300px">
                        <div class="px-3 py-2 border-bottom fw-bold small">Notifikasi</div>
                        <!-- TODO: render notifikasi dari database -->
                        <div class="px-3 py-4 text-center text-secondary small">
                            <?= $notifCount > 0 ? e($notifCount) . ' notifikasi baru' : 'Tidak ada notifikasi baru' ?>
                        </div>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="jl-user" data-bs-toggle="dropdown" aria-label="Menu akun">
                        <span class="who"><b><?= e($userName) ?></b><span><?= e($userSubtitle) ?></span></span>
                        <span class="avatar"><i class="bi bi-person-fill"></i></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= e(jl_url('auth/logout')) ?>"><i class="bi bi-box-arrow-right me-2"></i>Keluar Portal</a></li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- ================= /TOPBAR ================= -->

        <main class="jl-content">