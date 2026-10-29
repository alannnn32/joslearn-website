<?php
// Mulai sesi jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Keamanan: Jika belum login, alihkan ke halaman login
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: views/auth/login.php');
    exit();
}

// Ambil data dari sesi
$role = strtolower($_SESSION['role'] ?? '');
$nama_lengkap = $_SESSION['nama_lengkap'] ?? 'Pengguna';
$username = $_SESSION['username'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - JosLearn</title>
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
            background-color: #f3f4f6;
            color: #1f2937;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 260px;
            background-color: #ffffff;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 20px;
            color: #1e6bf2;
            padding: 0 8px;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background-color: #1e6bf2;
            color: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .nav-menu {
            list-style: none;
            margin-top: 32px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-item a:hover,
        .nav-item.active a {
            background-color: #eff6ff;
            color: #1e6bf2;
            font-weight: 600;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            color: #dc2626;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            background-color: #fef2f2;
        }

        .logout-btn:hover {
            background-color: #fee2e2;
        }

        /* Main Area */
        .main-content {
            flex: 1;
            padding: 32px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
        }

        .header p {
            font-size: 14px;
            color: #6b7280;
        }

        .badge-role {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .role-admin {
            background-color: #fef3c7;
            color: #92400e;
        }

        .role-teacher {
            background-color: #dbeafe;
            color: #1e40af;
        }

        /* Dashboard Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .card h3 {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .card .value {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }

        .section-box {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e5e7eb;
            margin-bottom: 24px;
        }

        .section-box h2 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #111827;
        }
    </style>
</head>

<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div>
            <div class="brand">
                <div class="brand-icon">J</div>
                <span>JOSLEARN</span>
            </div>

            <ul class="nav-menu">
                <li class="nav-item active">
                    <a href="index.php"><i data-lucide="layout-dashboard" style="width: 18px;"></i> Dashboard</a>
                </li>

                <?php if ($role === 'admin'): ?>
                    <li class="nav-item"><a href="#"><i data-lucide="users" style="width: 18px;"></i> Kelola Pengguna</a>
                    </li>
                    <li class="nav-item"><a href="#"><i data-lucide="school" style="width: 18px;"></i> Kelola Kelas</a></li>
                    <li class="nav-item"><a href="#"><i data-lucide="settings" style="width: 18px;"></i> Pengaturan
                            Sistem</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="#"><i data-lucide="clipboard-check" style="width: 18px;"></i> Input
                            Absensi</a></li>
                    <li class="nav-item"><a href="#"><i data-lucide="file-text" style="width: 18px;"></i> Input Nilai
                            Raport</a></li>
                    <li class="nav-item"><a href="#"><i data-lucide="book-open" style="width: 18px;"></i> Jadwal
                            Mengajar</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <a href="views/auth/login.php?logout=true" class="logout-btn" onclick="<?php session_destroy(); ?>">
            <i data-lucide="log-out" style="width: 18px;"></i> Keluar
        </a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="header">
            <div>
                <h1>Selamat Datang, <?php echo htmlspecialchars($nama_lengkap); ?>!</h1>
                <p>Ringkasan informasi dan aktivitas akun Anda</p>
            </div>
            <div>
                <?php
                $badgeClass = ($role === 'admin') ? 'role-admin' : 'role-teacher';
                ?>
                <span
                    class="badge-role <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($_SESSION['role'] ?? 'Pengguna'); ?></span>
            </div>
        </div>

        <!-- PEMANGGILAN KONTEN BERDASARKAN ROLE (MODULAR) -->
        <?php
        if ($role === 'admin') {
            // Memuat tampilan khusus admin dari file terpisah
            if (file_exists('views/admin/dashboard.php')) {
                include 'views/admin/dashboard.php';
            } else {
                echo '<div class="section-box"><h2>File dashboard.php belum dibuat di folder views/admin/</h2></div>';
            }
        } else {
            // Memuat tampilan khusus guru dari file terpisah
            if (file_exists('views/teacher/dashboard.php')) {
                include 'views/teacher/dashboard.php';
            } else {
                echo '<div class="section-box"><h2>File dashboard.php belum dibuat di folder views/teacher/</h2></div>';
            }
        }
        ?>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>