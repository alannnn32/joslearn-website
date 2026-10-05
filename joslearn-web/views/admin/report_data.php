<?php
/**
 * Modul Data Raport Admin - JosLearn
 * Terintegrasi penuh dengan struktur MVC, Session, dan Layout existing.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security / Role Guard (Pastikan hanya admin yang dapat mengakses)
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Sesuaikan dengan mekanisme redirect existing jika ada
    // header("Location: index.php?controller=auth&action=login");
    // exit;
}

// Ambil data filter dari parameter GET
$filter_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$filter_semester = isset($_GET['semester']) ? $_GET['semester'] : 'Semester Genap 2024/2025';
$filter_siswa = isset($_GET['siswa']) ? $_GET['siswa'] : '';

// Contoh data dinamis / pengambilan data dari model (jika model tersedia, gunakan model tersebut)
// $reports = Grade::getReportData($filter_kelas, $filter_semester, $filter_siswa);
$reports = [
    [
        'id' => 1,
        'nama' => 'Andi Pratama',
        'nisn' => '1234567890',
        'kelas' => 'X IPA 1',
        'inisial' => 'AP',
        'kelengkapan' => '100%',
        'status' => 'Diterbitkan',
        'updated_at' => '03 Okt 2026'
    ],
    [
        'id' => 2,
        'nama' => 'Aji Kusuma',
        'nisn' => '1234567777',
        'kelas' => 'X IPA 1',
        'inisial' => 'AP',
        'kelengkapan' => '94%',
        'status' => 'Revisi',
        'updated_at' => '03 Okt 2026'
    ],
    [
        'id' => 3,
        'nama' => 'Kusuma Aji',
        'nisn' => '1234567777',
        'kelas' => 'X IPA 1',
        'inisial' => 'AP',
        'kelengkapan' => '88%',
        'status' => 'Belum Lengkap',
        'updated_at' => '03 Okt 2026'
    ]
];

// Hitung total siswa secara dinamis berdasarkan hasil filter
$total_siswa = count($reports);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Raport - Admin JosLearn</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Inter / Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --primary-blue: #075CCB;
            --dark-blue: #064FA8;
            --light-blue: #EAF4FF;
            --bg-body: #F5F8FC;
            --text-main: #111827;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            margin: 0;
            overflow-x: hidden;
        }
        /* Layout Grid */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        /* Sidebar Styling */
        .sidebar-container {
            width: 145px;
            background-color: var(--primary-blue);
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
        }
        .sidebar-brand {
            padding: 16px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 14px;
            color: #FFFFFF;
        }
        .sidebar-brand-box {
            background: #FFFFFF;
            color: var(--primary-blue);
            width: 24px;
            height: 24px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
        }
        .sidebar-menu {
            padding: 0 8px;
            overflow-y: auto;
            flex-grow: 1;
        }
        .menu-category {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.6);
            margin: 14px 0 6px 6px;
            font-weight: 600;
        }
        .menu-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-size: 11.5px;
            font-weight: 500;
            border-radius: 6px;
            margin-bottom: 2px;
            transition: all 0.2s;
        }
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
        }
        .menu-item.active {
            background: #FFFFFF;
            color: var(--primary-blue);
            font-weight: 600;
        }
        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .admin-avatar-sm {
            width: 28px;
            height: 28px;
            background: #FFFFFF;
            color: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 11px;
        }

        /* Main Content Area */
        .main-wrapper {
            margin-left: 145px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        /* Top Header Styling */
        .top-header {
            height: 60px;
            background: #FFFFFF;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .header-left-info {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
        }
        .header-left-info .title-top {
            color: var(--primary-blue);
            font-weight: 700;
            text-transform: uppercase;
        }
        .header-search {
            position: relative;
            width: 280px;
        }
        .header-search input {
            width: 100%;
            font-size: 11.5px;
            padding: 6px 12px 6px 32px;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            background: #FAFAFB;
        }
        .header-search i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            color: var(--text-muted);
        }
        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .header-icon-btn {
            background: #FAFAFB;
            border: 1px solid var(--border-color);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
        }
        .profile-box {
            display: flex;
            align-items: center;
            gap: 8px;
            text-align: right;
        }

        /* Content Body */
        .content-body {
            padding: 24px;
            flex-grow: 1;
        }
        .breadcrumb-text {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 2px;
        }
        .page-subtitle {
            font-size: 12.5px;
            color: var(--text-muted);
            margin-bottom: 20px;
        }
        .card-custom {
            background: #FFFFFF;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.01);
            margin-bottom: 20px;
        }
        .filter-header {
            font-size: 10.5px;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .form-label-custom {
            font-size: 11px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 5px;
        }
        .form-select {
            font-size: 12px;
            border-color: var(--border-color);
            border-radius: 6px;
            padding: 8px 12px;
        }
        .table-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .table-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }
        .badge-total {
            background: var(--light-blue);
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            margin-left: 8px;
        }
        .sync-info {
            font-size: 11px;
            color: var(--text-muted);
        }
        .table {
            margin-bottom: 0;
            font-size: 12px;
        }
        .table th {
            background: #FAFAFB;
            color: #475569;
            font-weight: 600;
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
        }
        .table td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
            color: #334155;
        }
        .student-avatar {
            width: 30px;
            height: 30px;
            background: var(--light-blue);
            color: var(--primary-blue);
            font-weight: 700;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .badge-status {
            font-size: 10.5px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
        }
        .badge-diterbitkan {
            background: #DCFCE7;
            color: #16A34A;
        }
        .badge-revisi {
            background: #FEF3C7;
            color: #D97706;
        }
        .badge-belum {
            background: #FFEDD5;
            color: #C2410C;
        }
        .btn-action {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: #FFFFFF;
            color: var(--primary-blue);
            transition: all 0.2s;
        }
        .btn-action:hover {
            background: var(--light-blue);
            border-color: var(--primary-blue);
        }
        /* Footer Styling */
        .footer-admin {
            padding: 16px 24px;
            background: #FFFFFF;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <!-- 1. SIDEBAR ADMIN -->
    <aside class="sidebar-container">
        <div>
            <div class="sidebar-brand">
                <div class="sidebar-brand-box">J</div>
                <span>JosLearn</span>
            </div>
            
            <div class="sidebar-menu">
                <div class="menu-category">Menu Utama</div>
                <a href="index.php?controller=admin&action=dashboard" class="menu-item">
                    <i data-lucide="layout-dashboard" style="width: 14px; height: 14px;">}</i> Dashboard
                </a>

                <div class="menu-category">Data Master</div>
                <a href="index.php?controller=student&action=index" class="menu-item">
                    <i data-lucide="users" style="width: 14px; height: 14px;"></i> Data Siswa
                </a>
                <a href="index.php?controller=teacher&action=index" class="menu-item">
                    <i data-lucide="graduation-cap" style="width: 14px; height: 14px;"></i> Data Guru
                </a>
                <a href="index.php?controller=assignment&action=index" class="menu-item">
                    <i data-lucide="folder-kanban" style="width: 14px; height: 14px;"></i> Penugasan
                </a>

                <div class="menu-category">Absensi</div>
                <a href="index.php?controller=attendance&action=permission" class="menu-item">
                    <i data-lucide="file-text" style="width: 14px; height: 14px;"></i> Pengajuan Izin
                </a>
                <a href="index.php?controller=attendance&action=recap" class="menu-item">
                    <i data-lucide="calendar-check" style="width: 14px; height: 14px;"></i> Rekap Absensi
                </a>

                <div class="menu-category">Rapor</div>
                <a href="index.php?controller=report&action=verification" class="menu-item">
                    <i data-lucide="shield-check" style="width: 14px; height: 14px;"></i> Verifikasi Rapor
                </a>
                <a href="index.php?controller=report&action=index" class="menu-item active">
                    <i data-lucide="book-open" style="width: 14px; height: 14px;"></i> Data Raport
                </a>

                <div class="menu-category">Sistem</div>
                <a href="index.php?controller=system&action=logs" class="menu-item">
                    <i data-lucide="activity" style="width: 14px; height: 14px;"></i> Log Aktivitas
                </a>
                <a href="index.php?controller=system&action=settings" class="menu-item">
                    <i data-lucide="settings" style="width: 14px; height: 14px;"></i> Pengaturan
                </a>
            </div>
        </div>

        <!-- Sidebar Footer Profile -->
        <div class="sidebar-footer">
            <div class="admin-avatar-sm">AD</div>
            <div style="overflow: hidden;">
                <div style="font-weight: 700; font-size: 11px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">Admin Sekolah</div>
                <div style="font-size: 9px; opacity: 0.8;">Administrator</div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT CONTAINER -->
    <div class="main-wrapper">
        <!-- 2. HEADER / TOPBAR -->
        <header class="top-header">
            <div class="header-left-info">
                <div><span class="title-top">Tahun Ajaran 2024/2025</span> &bull; Semester Genap</div>
                <div style="font-size: 10px; color: #64748B;">Senin, 24 Februari 2025</div>
            </div>
            
            <div class="header-right">
                <div class="header-search">
                    <i data-lucide="search"></i>
                    <input type="text" placeholder="Cari data nilai, siswa, kelas...">
                </div>
                <div class="header-icon-btn" title="Notifikasi">
                    <i data-lucide="bell" style="width: 14px; height: 14px;"></i>
                </div>
                <div class="profile-box">
                    <div style="line-height: 1.2;">
                        <div style="font-weight: 700; font-size: 11.5px;">Admin Sekolah</div>
                        <div style="font-size: 10px; color: var(--text-muted);">Super Admin</div>
                    </div>
                    <div class="admin-avatar-sm" style="background: var(--light-blue); color: var(--primary-blue); font-weight: 700;">AS</div>
                </div>
            </div>
        </header>

        <!-- 3. MAIN CONTENT -->
        <div class="content-body">
            <!-- PAGE HEADER -->
            <div class="breadcrumb-text">Data Raport &bull; T.A. 2024/2025</div>
            <h1 class="page-title">Data Raport</h1>
            <div class="page-subtitle">Manajemen dan rekapitulasi nilai akademik raport siswa</div>

            <!-- 4. FILTER DATA -->
            <div class="card card-custom p-3 mb-4">
                <div class="filter-header">
                    <i data-lucide="filter" style="width: 13px; height: 13px;"></i> FILTER NILAI
                </div>
                <form method="GET" action="index.php">
                    <input type="hidden" name="controller" value="report">
                    <input type="hidden" name="action" value="index">
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label-custom">Kelas</label>
                            <select class="form-select" name="kelas" onchange="this.form.submit()">
                                <option value="">Semua Kelas</option>
                                <option value="X IPA 1" <?= ($filter_kelas == 'X IPA 1') ? 'selected' : ''; ?>>X IPA 1</option>
                                <option value="X IPA 2" <?= ($filter_kelas == 'X IPA 2') ? 'selected' : ''; ?>>X IPA 2</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-custom">Semester</label>
                            <select class="form-select" name="semester">
                                <option value="Semester Genap 2024/2025" <?= ($filter_semester == 'Semester Genap 2024/2025') ? 'selected' : ''; ?>>Semester Genap 2024/2025</option>
                                <option value="Semester Ganjil 2024/2025" <?= ($filter_semester == 'Semester Ganjil 2024/2025') ? 'selected' : ''; ?>>Semester Ganjil 2024/2025</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-custom">Siswa</label>
                            <select class="form-select" name="siswa">
                                <option value="">Semua Siswa</option>
                                <option value="Andi Pratama" <?= ($filter_siswa == 'Andi Pratama') ? 'selected' : ''; ?>>Andi Pratama</option>
                                <option value="Aji Kusuma" <?= ($filter_siswa == 'Aji Kusuma') ? 'selected' : ''; ?>>Aji Kusuma</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- 5. TABEL DATA RAPORT -->
            <div class="card card-custom">
                <div class="table-card-header">
                    <div class="d-flex align-items-center">
                        <h2 class="table-title">Daftar Rekapitulasi Nilai Raport</h2>
                        <span class="badge-total">Total Siswa: <?= $total_siswa; ?></span>
                    </div>
                    <div class="sync-info">
                        Terakhir disinkronkan: Hari ini, 10:45 WIB
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama</th>
                                <th>Kelengkapan</th>
                                <th>Status</th>
                                <th>Terakhir Diubah</th>
                                <th style="width: 70px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($reports)): ?>
                                <?php foreach ($reports as $index => $row): ?>
                                    <tr>
                                        <td class="fw-semibold text-secondary"><?= $index + 1; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="student-avatar"><?= htmlspecialchars($row['inisial']); ?></div>
                                                <div>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($row['nama']); ?></div>
                                                    <div style="font-size: 11px; color: var(--text-muted);">NISN: <?= htmlspecialchars($row['nisn']); ?> &bull; <?= htmlspecialchars($row['kelas']); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-dark"><?= htmlspecialchars($row['kelengkapan']); ?></td>
                                        <td>
                                            <?php 
                                                $statusClass = 'badge-diterbitkan';
                                                if ($row['status'] == 'Revisi') $statusClass = 'badge-revisi';
                                                if ($row['status'] == 'Belum Lengkap') $statusClass = 'badge-belum';
                                            ?>
                                            <span class="badge-status <?= $statusClass; ?>"><?= htmlspecialchars($row['status']); ?></span>
                                        </td>
                                        <td class="text-secondary" style="font-size: 11.5px;"><?= htmlspecialchars($row['updated_at']); ?></td>
                                        <td class="text-center">
                                            <a href="index.php?controller=report&action=edit&id=<?= $row['id']; ?>" class="btn-action" title="Edit Raport">
                                                <i data-lucide="pencil" style="width: 13px; height: 13px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Tidak ada data raport yang ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 6. FOOTER -->
        <footer class="footer-admin">
            <div>&copy; 2025 JosLearn. Hak Cipta Dilindungi.</div>
            <div>Absensi & Nilai Raport Real Time</div>
        </footer>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize Lucide Icons
    lucide.createIcons();
</script>
</body>
</html>