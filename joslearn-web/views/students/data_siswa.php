<?php
session_start();

$data_siswa = [
    [
        'no' => 1,
        'nama' => 'Andi Pratama',
        'inisial' => 'AP',
        'nisn' => '1234567890',
        'kelas' => 'X IPA 1'
    ],
    [
        'no' => 2,
        'nama' => 'Siti Aisyah',
        'inisial' => 'SA',
        'nisn' => '1234567891',
        'kelas' => 'X IPA 1'
    ],
    [
        'no' => 3,
        'nama' => 'Budi Santoso',
        'inisial' => 'BS',
        'nisn' => '1234567892',
        'kelas' => 'X IPA 2'
    ]
];

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$kelas_filter = isset($_GET['kelas']) ? trim($_GET['kelas']) : '';

if (!empty($search)) {
    $data_siswa = array_filter($data_siswa, function($siswa) use ($search) {
        return stripos($siswa['nama'], $search) !== false || stripos($siswa['nisn'], $search) !== false;
    });
}

if (!empty($kelas_filter)) {
    $data_siswa = array_filter($data_siswa, function($siswa) use ($kelas_filter) {
        return $siswa['kelas'] === $kelas_filter;
    });
}

$total_siswa = count($data_siswa);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - JosLearn</title>
    
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
            transition: all 0.2s;
        }

        .search-box-top input:focus {
            background-color: #ffffff;
            border-color: #cbd5e1;
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
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
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

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-outline {
            background-color: #ffffff;
            color: #2563eb;
            border-color: #cbd5e1;
        }

        .btn-outline:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
        }

        .btn-primary {
            background-color: #2563eb;
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .card-table {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            overflow: hidden;
        }

        .table-toolbar {
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
        }

        .toolbar-filters {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .search-box-table {
            position: relative;
            width: 240px;
        }

        .search-box-table input {
            width: 100%;
            padding: 8px 12px 8px 36px;
            border: 1px solid #cbd5e1;
            border-radius: 20px;
            font-size: 13px;
            outline: none;
        }

        .search-box-table i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .dropdown-filter {
            padding: 8px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 20px;
            font-size: 13px;
            color: #475569;
            background-color: #ffffff;
            outline: none;
            cursor: pointer;
        }

        .badge-total {
            background-color: #e0f2fe;
            color: #0284c7;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 600;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-table th {
            background-color: #f8fafc;
            padding: 12px 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #475569;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
        }

        .custom-table td {
            padding: 14px 20px;
            font-size: 13px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .custom-table tr:last-child td {
            border-bottom: none;
        }

        .student-cell {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            color: #0f172a;
        }

        .student-avatar {
            width: 32px;
            height: 32px;
            background-color: #e0e7ff;
            color: #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 11px;
        }

        .badge-kelas {
            background-color: #e0f2fe;
            color: #0284c7;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .action-icons {
            display: flex;
            gap: 12px;
        }

        .action-btn {
            color: #2563eb;
            cursor: pointer;
            text-decoration: none;
        }

        .action-btn.delete {
            color: #f43f5e;
        }

        .table-pagination {
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f1f5f9;
            font-size: 12px;
            color: #64748b;
        }

        .pagination-nav {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .page-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            color: #64748b;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
        }

        .page-btn.active {
            background-color: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
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

        @media (max-width: 900px) {
            .sidebar { display: none; }
            .page-header-container { flex-direction: column; gap: 16px; }
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
            
            <div class="breadcrumb">
                <span>Data Induk</span>
                <span class="separator">•</span>
                <span class="current">T.A. 2024/2025</span>
            </div>

            <div class="page-header-container">
                <div>
                    <h1 class="page-title">Data Siswa</h1>
                    <p class="page-subtitle">Manajemen data induk siswa aktif</p>
                </div>
                <div class="action-buttons">
                    <button class="btn btn-outline">Import Excel</button>
                    <a href="tambah_siswa.php" class="btn btn-primary">
                        <i data-lucide="plus" style="width: 16px;"></i> Tambah Siswa
                    </a>
                </div>
            </div>

            <div class="card-table">
                <div class="table-toolbar">
                    <div class="toolbar-filters">
                        <form method="GET" style="display:flex; gap:12px;">
                            <div class="search-box-table">
                                <i data-lucide="search" style="width: 16px;"></i>
                                <input type="text" name="search" placeholder="Cari nama/NISN..." value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            <select class="dropdown-filter" name="kelas" onchange="this.form.submit()">
                                <option value="">Semua Kelas</option>
                                <option value="X IPA 1" <?php echo $kelas_filter === 'X IPA 1' ? 'selected' : ''; ?>>X IPA 1</option>
                                <option value="X IPA 2" <?php echo $kelas_filter === 'X IPA 2' ? 'selected' : ''; ?>>X IPA 2</option>
                            </select>
                        </form>
                    </div>
                    <div class="badge-total">
                        Total Siswa: <?php echo $total_siswa; ?>
                    </div>
                </div>

                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">NO</th>
                            <th>NAMA</th>
                            <th>NISN</th>
                            <th>KELAS</th>
                            <th style="width: 100px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($data_siswa)): ?>
                            <?php foreach($data_siswa as $row): ?>
                            <tr>
                                <td><?php echo $row['no']; ?></td>
                                <td>
                                    <div class="student-cell">
                                        <div class="student-avatar"><?php echo $row['inisial']; ?></div>
                                        <span><?php echo htmlspecialchars($row['nama']); ?></span>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($row['nisn']); ?></td>
                                <td><span class="badge-kelas"><?php echo htmlspecialchars($row['kelas']); ?></span></td>
                                <td>
                                    <div class="action-icons">
                                        <a href="detail_profil_siswa.php?edit=<?php echo $row['no']; ?>" class="action-btn" title="Edit">
                                            <i data-lucide="square-pen" style="width: 16px;"></i>
                                        </a>
                                        <a href="#" class="action-btn delete" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i data-lucide="trash-2" style="width: 16px;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 24px;">
                                    Data siswa tidak ditemukan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="table-pagination">
                    <div>Menampilkan 1-<?php echo $total_siswa; ?> dari <?php echo $total_siswa; ?> siswa</div>
                    <div class="pagination-nav">
                        <a href="#" class="page-btn"><i data-lucide="chevron-left" style="width: 14px;"></i></a>
                        <a href="#" class="page-btn active">1</a>
                        <a href="#" class="page-btn"><i data-lucide="chevron-right" style="width: 14px;"></i></a>
                    </div>
                </div>
            </div>

        </main>

        <footer class="footer">
            <div>© <?php echo date('Y'); ?> JosLearn. Hak Cipta Dilindungi.</div>
            <div>Absensi & Nilai Raport Real Time</div>
        </footer>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
