<?php
session_start();

$id_siswa = isset($_GET['id']) ? $_GET['id'] : '';
$nama_siswa = "Budi Santoso";

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_baru = isset($_POST['password_baru']) ? $_POST['password_baru'] : '';

    if (empty($password_baru)) {
        $message = 'Password baru wajib diisi!';
        $message_type = 'error';
    } else {
        $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
        
        $message = 'Password berhasil direset!';
        $message_type = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - JosLearn</title>

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

        .search-box {
            position: relative;
            width: 280px;
        }

        .search-box input {
            width: 100%;
            padding: 8px 12px 8px 36px;
            background-color: #f1f5f9;
            border: 1px solid transparent;
            border-radius: 20px;
            font-size: 13px;
            outline: none;
            transition: all 0.2s;
        }

        .search-box input:focus {
            background-color: #ffffff;
            border-color: #cbd5e1;
        }

        .search-box i {
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-reset {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 48px 40px;
            width: 100%;
            max-width: 640px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            text-align: center;
        }

        .reset-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .reset-subtitle {
            font-size: 13px;
            color: #94a3b8;
            line-height: 1.5;
            max-width: 420px;
            margin: 0 auto 32px auto;
        }

        .form-reset-group {
            text-align: left;
            margin-bottom: 24px;
        }

        .form-reset-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .form-reset-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            transition: all 0.2s ease;
            background-color: #ffffff;
        }

        .form-reset-group input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-reset-group input::placeholder {
            color: #cbd5e1;
        }

        .reset-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-reset {
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-reset-cancel {
            background-color: #ffffff;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-reset-cancel:hover {
            background-color: #f8fafc;
        }

        .btn-reset-submit {
            background-color: #2563eb;
            color: #ffffff;
        }

        .btn-reset-submit:hover {
            background-color: #1d4ed8;
        }

        .alert-message {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: left;
        }

        .alert-message.error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-message.success {
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
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
                <div class="search-box">
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

            <div class="card-reset">
                <h1 class="reset-title">Reset password <?php echo htmlspecialchars($nama_siswa); ?>?</h1>
                <p class="reset-subtitle">Password akun akan direset. Siswa perlu menggunakan password baru untuk masuk kembali.</p>

                <?php if (!empty($message)): ?>
                    <div class="alert-message <?php echo $message_type; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . htmlspecialchars($id_siswa); ?>" method="POST">
                    
                    <div class="form-reset-group">
                        <label for="password_baru">Password Baru</label>
                        <input type="password" id="password_baru" name="password_baru" placeholder="Masukkan password baru" required>
                    </div>

                    <div class="reset-actions">
                        <a href="detail_profil_siswa.php?id=<?php echo urlencode($id_siswa); ?>" class="btn-reset btn-reset-cancel" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Batal</a>
                        <button type="submit" class="btn-reset btn-reset-submit">Reset Password</button>
                    </div>

                </form>
            </div>

        </main>

        <footer class="footer">
            <div>© 2025 JosLearn. Hak Cipta Dilindungi.</div>
            <div>Absensi & Nilai Raport Real Time</div>
        </footer>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>