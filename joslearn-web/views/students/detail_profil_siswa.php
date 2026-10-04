<?php
session_start();

// 1. Contoh Koneksi Database (sesuaikan dengan koneksi database kamu)
// $conn = mysqli_connect("localhost", "root", "", "db_sekolah");

$nis = $_GET['nis'] ?? '10231';

/* 
====================================================================
JIKA SUDAH PAKAI DATABASE MYSQL (Aktifkan bagian ini):
====================================================================
$query = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis'");
$siswa = mysqli_fetch_assoc($query);

if (!$siswa) {
    echo "Data siswa tidak ditemukan.";
    exit;
}
*/

// ====================================================================
// SIMULASI DATA (Jika belum terhubung ke Database MySQL)
// ====================================================================
$data_semua_siswa = [
    '10231' => [
        'nama' => 'Budi Santoso',
        'nis' => '10231',
        'kelas' => 'XII IPA 1',
        'status_akun' => $_SESSION['status_siswa_10231'] ?? 'Aktif',
        'email' => 'budi@sekolah.sch.id',
        'wali_kelas' => 'Rina Wulandari, M.Pd.',
        'kehadiran_persen' => '92%',
        'hadir' => 23,
        'izin' => 2,
        'sakit' => 1,
        'status_rapor' => 'Semester 1 — Diterbitkan'
    ],
    '10232' => [
        'nama' => 'Andi Pratama',
        'nis' => '10232',
        'kelas' => 'XII IPA 2',
        'status_akun' => $_SESSION['status_siswa_10232'] ?? 'Aktif',
        'email' => 'andi@sekolah.sch.id',
        'wali_kelas' => 'Bambang Hidayat, S.Pd.',
        'kehadiran_persen' => '95%',
        'hadir' => 24,
        'izin' => 1,
        'sakit' => 0,
        'status_rapor' => 'Semester 1 — Diterbitkan'
    ]
];

// Ambil data siswa sesuai NIS, jika tidak ada tampilkan default Budi Santoso
$siswa = $data_semua_siswa[$nis] ?? $data_semua_siswa['10231'];

// Membuat Inisial Nama untuk Avatar (Contoh: "Andi Pratama" -> "AP")
$words = explode(" ", $siswa['nama']);
$inisial = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

$success_message = "";

// Proses ketika tombol Nonaktifkan di dalam modal diklik
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'nonaktifkan') {
    // Jika menggunakan database:
    // mysqli_query($conn, "UPDATE siswa SET status_akun = 'Nonaktif' WHERE nis = '{$_POST['nis']}'");

    // Mengubah status akun di tampilan & session
    $siswa['status_akun'] = 'Nonaktif';
    $_SESSION['status_siswa_' . $siswa['nis']] = 'Nonaktif';
    $success_message = "Akun siswa berhasil dinonaktifkan.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Profil Siswa - JosLearn</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #0c56d0;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 16px;
            flex-shrink: 0;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 12px 24px 12px;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            background-color: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0c56d0;
            font-weight: 700;
            font-size: 20px;
        }

        .brand-title {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .menu-section {
            margin-bottom: 20px;
        }

        .menu-category {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: #93c5fd;
            letter-spacing: 0.5px;
            padding: 0 12px 8px 12px;
        }

        .menu-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: #dbeaff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .menu-item a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .menu-item.active a {
            background-color: #ffffff;
            color: #0c56d0;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin-top: auto;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background-color: #ffffff;
            color: #0c56d0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        .user-info .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
        }

        .user-info .user-role {
            font-size: 11px;
            color: #93c5fd;
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .top-header {
            background-color: #ffffff;
            height: 64px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
        }

        .header-meta .academic-year {
            font-size: 12px;
            font-weight: 700;
            color: #2563eb;
            text-transform: uppercase;
        }

        .header-meta .date-today {
            font-size: 13px;
            color: #64748b;
            margin-top: 2px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .search-box-top {
            position: relative;
            width: 280px;
        }

        .search-box-top input {
            width: 100%;
            padding: 8px 12px 8px 36px;
            background-color: #f1f5f9;
            border: 1px solid transparent;
            border-radius: 20px;
            font-size: 13px;
            outline: none;
        }

        .search-box-top i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            cursor: pointer;
            position: relative;
        }

        .icon-btn .badge-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 6px;
            height: 6px;
            background-color: #2563eb;
            border-radius: 50%;
        }

        .top-user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-left: 12px;
            border-left: 1px solid #e2e8f0;
        }

        .top-user-avatar {
            width: 36px;
            height: 36px;
            background-color: #e0e7ff;
            color: #3730a3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        .top-user-details .top-user-name {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
        }

        .top-user-details .badge-superadmin {
            display: inline-block;
            background-color: #dbeafe;
            color: #1e40af;
            font-size: 10px;
            font-weight: 600;
            padding: 1px 6px;
            border-radius: 4px;
            margin-top: 2px;
        }

        .content-body {
            padding: 32px;
            flex: 1;
        }

        .alert-success {
            background-color: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #2563eb;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .breadcrumb span.separator {
            color: #cbd5e1;
        }

        .breadcrumb span.current {
            color: #94a3b8;
        }

        .page-header-container {
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .page-subtitle {
            font-size: 14px;
            color: #64748b;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .student-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .student-avatar-large {
            width: 64px;
            height: 64px;
            background-color: #e0e7ff;
            color: #2563eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 700;
        }

        .student-title-info h2 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .student-title-info p {
            font-size: 13px;
            color: #64748b;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .info-box {
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 8px;
            padding: 14px 16px;
        }

        .info-box .label {
            font-size: 11px;
            font-weight: 500;
            color: #94a3b8;
            margin-bottom: 6px;
        }

        .info-box .value {
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
        }

        .info-box .value.status-active {
            color: #10b981;
        }

        .info-box .value.status-inactive {
            color: #ef4444;
        }

        .action-card-title {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
        }

        .info-alert-text {
            background-color: #eff6ff;
            color: #3b82f6;
            font-size: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .action-buttons-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid transparent;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-reset {
            background-color: #1d4ed8;
            color: #ffffff;
        }

        .btn-reset:hover {
            background-color: #1e40af;
        }

        .btn-danger {
            background-color: #dc2626;
            color: #ffffff;
        }

        .btn-danger:hover {
            background-color: #b91c1c;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .stat-card .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .stat-card .stat-label {
            font-size: 11px;
            color: #94a3b8;
        }

        .stat-card.stat-hadir .stat-value { color: #16a34a; }
        .stat-card.stat-izin .stat-value { color: #d97706; }
        .stat-card.stat-sakit .stat-value { color: #dc2626; }

        .rapor-card-title {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
        }

        .badge-rapor {
            display: inline-block;
            background-color: #ecfdf5;
            color: #059669;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 16px;
        }

        .footer {
            padding: 20px 32px;
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #64748b;
        }

        /* Modal Nonaktifkan Akun */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(2px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-card {
            background-color: #ffffff;
            border-radius: 16px;
            width: 100%;
            max-width: 500px;
            padding: 40px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            animation: modalFadeIn 0.2s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal-icon-container {
            width: 48px;
            height: 48px;
            background-color: #fef2f2;
            color: #ef4444;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .modal-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .modal-description {
            font-size: 13px;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
        }

        .btn-modal-cancel {
            flex: 1;
            padding: 10px;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-modal-cancel:hover {
            background-color: #f8fafc;
        }

        .btn-modal-danger {
            flex: 1;
            padding: 10px;
            background-color: #e00000;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-modal-danger:hover {
            background-color: #c00000;
        }

        @media (max-width: 900px) {
            .sidebar { display: none; }
            .info-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div>
            <div class="brand">
                <div class="brand-logo">J</div>
                <div class="brand-title">JosLearn</div>
            </div>

            <div class="menu-section">
                <div class="menu-category">Menu Utama</div>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="#"><i data-lucide="layout-dashboard" style="width: 16px;"></i> Dashboard</a>
                    </li>
                </ul>
            </div>

            <div class="menu-section">
                <div class="menu-category">Data Master</div>
                <ul class="menu-list">
                    <li class="menu-item active">
                        <a href="#"><i data-lucide="users" style="width: 16px;"></i> Data Siswa</a>
                    </li>
                    <li class="menu-item">
                        <a href="#"><i data-lucide="user-check" style="width: 16px;"></i> Data Guru</a>
                    </li>
                    <li class="menu-item">
                        <a href="#"><i data-lucide="clipboard-list" style="width: 16px;"></i> Penugasan</a>
                    </li>
                </ul>
            </div>

            <div class="menu-section">
                <div class="menu-category">Absensi</div>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="#"><i data-lucide="check-square" style="width: 16px;"></i> Pengajuan Izin</a>
                    </li>
                    <li class="menu-item">
                        <a href="#"><i data-lucide="file-text" style="width: 16px;"></i> Rekap Absensi</a>
                    </li>
                </ul>
            </div>

            <div class="menu-section">
                <div class="menu-category">Rapor</div>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="#"><i data-lucide="file-badge" style="width: 16px;"></i> Verifikasi Rapor</a>
                    </li>
                    <li class="menu-item">
                        <a href="#"><i data-lucide="bar-chart-3" style="width: 16px;"></i> Data Rapor</a>
                    </li>
                </ul>
            </div>

            <div class="menu-section">
                <div class="menu-category">Sistem</div>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="#"><i data-lucide="history" style="width: 16px;"></i> Log Aktivitas</a>
                    </li>
                    <li class="menu-item">
                        <a href="#"><i data-lucide="settings" style="width: 16px;"></i> Pengaturan</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">AD</div>
            <div class="user-info">
                <div class="user-name">Admin Sekolah</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
    </aside>

    <div class="main-wrapper">
        
        <header class="top-header">
            <div class="header-meta">
                <div class="academic-year">Tahun Ajaran 2024/2025 • Semester Genap</div>
                <div class="date-today">Senin, 24 Februari 2025</div>
            </div>

            <div class="header-actions">
                <div class="search-box-top">
                    <i data-lucide="search" style="width: 16px;"></i>
                    <input type="text" placeholder="Cari data siswa, kelas...">
                </div>

                <button class="icon-btn">
                    <i data-lucide="bell" style="width: 18px;"></i>
                    <span class="badge-dot"></span>
                </button>

                <div class="top-user-profile">
                    <div class="top-user-avatar">AS</div>
                    <div class="top-user-details">
                        <div class="top-user-name">Admin Sekolah</div>
                        <span class="badge-superadmin">Super Admin</span>
                    </div>
                </div>
            </div>
        </header>

        <main class="content-body">
            
            <!-- Output Alert Sukses Penonaktifan -->
            <?php if (!empty($success_message)): ?>
                <div class="alert-success">
                    <i data-lucide="check-circle" style="width: 18px; height: 18px; color: #dc2626;"></i>
                    <span><?php echo htmlspecialchars($success_message); ?></span>
                </div>
            <?php endif; ?>

            <div class="breadcrumb">
                <span>Data Induk</span>
                <span class="separator">•</span>
                <span class="current">T.A. 2024/2025</span>
            </div>

            <div class="page-header-container">
                <h1 class="page-title">Detail Profil Siswa</h1>
                <p class="page-subtitle">Manajemen data induk siswa aktif</p>
            </div>

            <div class="card">
                <div class="student-header">
                    <div class="student-avatar-large"><?php echo $inisial; ?></div>
                    <div class="student-title-info">
                        <h2><?php echo htmlspecialchars($siswa['nama']); ?></h2>
                        <p>NIS: <?php echo htmlspecialchars($siswa['nis']); ?> • Kelas: <?php echo htmlspecialchars($siswa['kelas']); ?></p>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-box">
                        <div class="label">Nama Siswa</div>
                        <div class="value"><?php echo htmlspecialchars($siswa['nama']); ?></div>
                    </div>
                    <div class="info-box">
                        <div class="label">Status Akun</div>
                        <div class="value <?php echo ($siswa['status_akun'] === 'Aktif') ? 'status-active' : 'status-inactive'; ?>">
                            <?php echo htmlspecialchars($siswa['status_akun']); ?>
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="label">NIS</div>
                        <div class="value"><?php echo htmlspecialchars($siswa['nis']); ?></div>
                    </div>
                    <div class="info-box">
                        <div class="label">Kelas</div>
                        <div class="value"><?php echo htmlspecialchars($siswa['kelas']); ?></div>
                    </div>
                    <div class="info-box">
                        <div class="label">Email Siswa</div>
                        <div class="value"><?php echo htmlspecialchars($siswa['email']); ?></div>
                    </div>
                    <div class="info-box">
                        <div class="label">Wali Kelas</div>
                        <div class="value"><?php echo htmlspecialchars($siswa['wali_kelas']); ?></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="action-card-title">Aksi Akun</div>
                <div class="info-alert-text">
                    Perubahan data dan status akun akan otomatis masuk ke Log Aktivitas.
                </div>
                <div class="action-buttons-group">
                    <a href="reset_password_siswa.php?nis=<?php echo urlencode($siswa['nis']); ?>" class="btn btn-reset">Reset Password</a>
                    <button type="button" class="btn btn-danger" onclick="showModal()">Nonaktifkan</button>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?php echo htmlspecialchars($siswa['kehadiran_persen']); ?></div>
                    <div class="stat-label">Kehadiran</div>
                </div>
                <div class="stat-card stat-hadir">
                    <div class="stat-value"><?php echo htmlspecialchars($siswa['hadir']); ?></div>
                    <div class="stat-label">Hadir</div>
                </div>
                <div class="stat-card stat-izin">
                    <div class="stat-value"><?php echo htmlspecialchars($siswa['izin']); ?></div>
                    <div class="stat-label">Izin</div>
                </div>
                <div class="stat-card stat-sakit">
                    <div class="stat-value"><?php echo htmlspecialchars($siswa['sakit']); ?></div>
                    <div class="stat-label">Sakit</div>
                </div>
            </div>

            <div class="card">
                <div class="rapor-card-title">Status Rapor</div>
                <span class="badge-rapor"><?php echo htmlspecialchars($siswa['status_rapor']); ?></span>
            </div>

        </main>

        <footer class="footer">
            <div>© <?php echo date('Y'); ?> JosLearn. Hak Cipta Dilindungi.</div>
            <div>Absensi & Nilai Raport Real Time</div>
        </footer>

    </div>

    <!-- Modal Konfirmasi Nonaktifkan Akun -->
    <div class="modal-overlay" id="modalNonaktifkan">
        <div class="modal-card">
            <div class="modal-icon-container">!</div>
            <div class="modal-title">Nonaktifkan akun siswa?</div>
            <div class="modal-description">
                <?php echo htmlspecialchars($siswa['nama']); ?> tidak dapat login ke aplikasi selama akun dinonaktifkan. Data absensi dan rapor tetap tersimpan.
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn-modal-cancel" onclick="hideModal()">Batal</button>
                
                <!-- Form Post untuk memproses penonaktifan di halaman yang sama -->
                <form method="POST" style="flex: 1;">
                    <input type="hidden" name="action" value="nonaktifkan">
                    <input type="hidden" name="nis" value="<?php echo htmlspecialchars($siswa['nis']); ?>">
                    <button type="submit" class="btn-modal-danger" style="width: 100%;">Nonaktifkan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function showModal() {
            document.getElementById('modalNonaktifkan').style.display = 'flex';
        }

        function hideModal() {
            document.getElementById('modalNonaktifkan').style.display = 'none';
        }
    </script>
</body>
</html>
