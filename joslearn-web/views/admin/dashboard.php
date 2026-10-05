<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - JosLearn</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F5F8FC;
            color: #111827;
            overflow-x: hidden;
        }
        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: #075CCB;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-brand .logo-box {
            background: #ffffff;
            color: #075CCB;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: bold;
            font-size: 18px;
        }
        .sidebar-menu {
            padding: 0 16px;
            flex-grow: 1;
        }
        .menu-category {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.6);
            margin: 16px 0 8px 12px;
            font-weight: 600;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13.5px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            background: #ffffff;
            color: #075CCB;
            font-weight: 600;
        }
        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        /* Main Content Wrapper */
        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
        }
        /* Top Header Styling */
        .top-header {
            background: #ffffff;
            border-bottom: 1px solid #E2E8F0;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dashboard-card {
            border-radius: 12px;
            background: #FFFFFF;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR KIRI -->
    <div class="sidebar">
        <div>
            <!-- Brand / Logo -->
            <div class="sidebar-brand">
                <div class="logo-box">J</div>
                <span class="fw-bold fs-5 text-white">JosLearn</span>
            </div>

            <!-- Menu List -->
            <div class="sidebar-menu">
                <div class="menu-category">Menu Utama</div>
                <a href="#" class="nav-link active">
                    <i data-lucide="layout-dashboard" style="width: 18px; height: 18px;"></i> Dashboard
                </a>

                <div class="menu-category">Data Master</div>
                <a href="#" class="nav-link">
                    <i data-lucide="users" style="width: 18px; height: 18px;"></i> Data Siswa
                </a>
                <a href="#" class="nav-link">
                    <i data-lucide="user-check" style="width: 18px; height: 18px;"></i> Data Guru
                </a>
                <a href="#" class="nav-link">
                    <i data-lucide="grid" style="width: 18px; height: 18px;"></i> Penugasan
                </a>

                <div class="menu-category">Absensi</div>
                <a href="#" class="nav-link">
                    <i data-lucide="check-square" style="width: 18px; height: 18px;"></i> Pengajuan Izin
                </a>
                <a href="#" class="nav-link">
                    <i data-lucide="file-spreadsheet" style="width: 18px; height: 18px;"></i> Rekap Absensi
                </a>

                <div class="menu-category">Rapor</div>
                <a href="#" class="nav-link">
                    <i data-lucide="file-check" style="width: 18px; height: 18px;"></i> Verifikasi Rapor
                </a>
                <a href="#" class="nav-link">
                    <i data-lucide="folder-kanban" style="width: 18px; height: 18px;"></i> Data Rapor
                </a>

                <div class="menu-category">Sistem</div>
                <a href="#" class="nav-link">
                    <i data-lucide="history" style="width: 18px; height: 18px;"></i> Log Aktivitas
                </a>
                <a href="#" class="nav-link">
                    <i data-lucide="settings" style="width: 18px; height: 18px;"></i> Pengaturan
                </a>
            </div>
        </div>

        <!-- Sidebar Footer Profile -->
        <div class="sidebar-footer">
            <div class="bg-white text-primary rounded-circle fw-bold d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 13px;">
                AS
            </div>
            <div style="line-height: 1.2;">
                <span class="d-block fw-bold" style="font-size: 13px;">Admin Sekolah</span>
                <span class="text-white-50" style="font-size: 11px;">Administrator</span>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT KANAN -->
    <div class="main-content">
        <!-- TOP HEADER -->
        <div class="top-header">
            <div>
                <span class="text-primary fw-bold" style="font-size: 11.5px; letter-spacing: 0.3px;">TAHUN AJARAN 2024/2025 • SEMESTER GENAP</span>
                <div class="text-muted" style="font-size: 12.5px;">Senin, 24 Februari 2025</div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="input-group" style="width: 240px;">
                    <span class="input-group-text bg-light border-0 py-1 px-2"><i data-lucide="search" style="width: 15px; height: 15px;" class="text-muted"></i></span>
                    <input type="text" class="form-control form-control-sm bg-light border-0 text-muted" placeholder="Cari data siswa, kelas..." style="font-size: 12.5px;">
                </div>
                <button class="btn btn-light btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i data-lucide="bell" style="width: 16px; height: 16px;" class="text-secondary"></i>
                </button>
                <div class="d-flex align-items-center gap-2 border-start ps-3">
                    <div class="bg-light text-primary rounded-circle fw-bold d-flex align-items-center justify-content-center border" style="width: 34px; height: 34px; font-size: 12px;">
                        AS
                    </div>
                    <div style="line-height: 1.2;">
                        <span class="d-block fw-bold text-dark" style="font-size: 12.5px;">Admin Sekolah</span>
                        <span class="text-muted" style="font-size: 10.5px;">Super Admin</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- DASHBOARD BODY CONTENT -->
        <div class="p-4">
            <!-- PAGE HEADER -->
            <div class="mb-4">
                <h1 class="h3 fw-bold text-dark mb-1">Dashboard</h1>
                <p class="text-muted mb-0" style="font-size: 13.5px;">Ringkasan data akademik dan aktivitas sistem hari ini</p>
            </div>

            <!-- STATISTIC CARDS (4 Kolom) -->
            <div class="row g-3 mb-4">
                <!-- Card 1: Total Siswa -->
                <div class="col-xl-3 col-md-6">
                    <div class="card dashboard-card border-0 shadow-sm p-3 h-100">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="d-block text-uppercase text-muted fw-bold mb-1" style="font-size: 11px;">Total Siswa</span>
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 26px;">120</h3>
                                <div class="text-success fw-semibold" style="font-size: 12px;">
                                    <i data-lucide="arrow-up" style="width: 14px; height: 14px;"></i> Aktif terdaftar
                                </div>
                            </div>
                            <div class="p-2 rounded bg-light text-primary">
                                <i data-lucide="users" style="width: 24px; height: 24px;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Total Guru -->
                <div class="col-xl-3 col-md-6">
                    <div class="card dashboard-card border-0 shadow-sm p-3 h-100">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="d-block text-uppercase text-muted fw-bold mb-1" style="font-size: 11px;">Total Guru</span>
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 26px;">15</h3>
                                <span class="text-muted" style="font-size: 12px;">Tenaga Pendidik</span>
                            </div>
                            <div class="p-2 rounded bg-light text-primary">
                                <i data-lucide="user-check" style="width: 24px; height: 24px;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Pengajuan Menunggu -->
                <div class="col-xl-3 col-md-6">
                    <div class="card dashboard-card border-0 shadow-sm p-3 h-100">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="d-block text-uppercase text-muted fw-bold mb-1" style="font-size: 11px;">Pengajuan Menunggu</span>
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 26px;">8</h3>
                                <span class="text-muted" style="font-size: 12px;">Perlu diperiksa</span>
                            </div>
                            <div class="p-2 rounded bg-light text-primary">
                                <i data-lucide="building-2" style="width: 24px; height: 24px;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Absensi Hari Ini -->
                <div class="col-xl-3 col-md-6">
                    <div class="card dashboard-card border-0 shadow-sm p-3 h-100 text-white" style="background: linear-gradient(135deg, #075CCB 0%, #032380 100%);">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="d-block text-uppercase fw-bold mb-1 opacity-75" style="font-size: 11px;">Absensi Hari Ini</span>
                                <h3 class="fw-bold mb-2" style="font-size: 26px;">96%</h3>
                                <div class="badge bg-white bg-opacity-25 text-white px-2 py-1 fw-normal" style="font-size: 11px;">
                                    <i data-lucide="check" style="width: 12px; height: 12px;"></i> 115 Hadir + 5 Izin/Sakit
                                </div>
                            </div>
                            <div class="p-2 rounded bg-white bg-opacity-25 text-white">
                                <i data-lucide="pie-chart" style="width: 24px; height: 24px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATUS RAPOR SECTION -->
            <div class="card dashboard-card border-0 shadow-sm mb-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">Status Rapor</h5>
                        <span class="text-muted" style="font-size: 12.5px;">Semester 1 — 2026/2027</span>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded border-0">
                            <span class="text-muted d-block mb-1" style="font-size: 12px;">Sudah diterbitkan</span>
                            <h4 class="fw-bold text-dark mb-0" style="font-size: 18px;">97 Siswa</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded border-0">
                            <span class="text-muted d-block mb-1" style="font-size: 12px;">Menunggu verifikasi</span>
                            <h4 class="fw-bold text-dark mb-0" style="font-size: 18px;">28 Siswa</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded border-0">
                            <span class="text-muted d-block mb-1" style="font-size: 12px;">Perlu Revisi</span>
                            <h4 class="fw-bold text-danger mb-0" style="font-size: 18px;">3 Siswa</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AKTIVITAS TERBARU SECTION -->
            <div class="card dashboard-card border-0 shadow-sm p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">Aktivitas Terbaru</h5>
                        <span class="text-muted" style="font-size: 12.5px;">Pemantauan log operasional akademik real-time</span>
                    </div>
                    <a href="#" class="text-primary fw-semibold text-decoration-none" style="font-size: 13px;">Lihat Semua Log</a>
                </div>

                <div class="d-flex flex-column gap-3">
                    <!-- Aktivitas 1 -->
                    <div class="p-3 bg-light rounded d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 bg-primary bg-opacity-10 text-primary rounded">
                                <i data-lucide="file-text" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 13.5px;">Guru Matematika menginput nilai raport Kelas VII-A</h6>
                                <div class="text-muted" style="font-size: 12px;">
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-0.5">Raport Selesai</span> • Oleh: Bpk. Bambang Pamungkas, S.Pd
                                </div>
                            </div>
                        </div>
                        <span class="text-muted" style="font-size: 12px;">10 menit lalu</span>
                    </div>

                    <!-- Aktivitas 2 -->
                    <div class="p-3 bg-light rounded d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 bg-primary bg-opacity-10 text-primary rounded">
                                <i data-lucide="clipboard-check" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 13.5px;">Absensi harian Kelas VIII-B telah diselesaikan</h6>
                                <div class="text-muted" style="font-size: 12px;">
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-0.5">Presensi Harian</span> • Kehadiran 100% (30 Siswa)
                                </div>
                            </div>
                        </div>
                        <span class="text-muted" style="font-size: 12px;">35 menit lalu</span>
                    </div>

                    <!-- Aktivitas 3 -->
                    <div class="p-3 bg-light rounded d-flex align-items-center justify-content-between">
                        <div class="_d-flex align-items-center gap-3">
                            <div class="p-2 bg-primary bg-opacity-10 text-primary rounded">
                                <i data-lucide="megaphone" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 13.5px;">Pengumuman jadwal ujian semester dipublikasikan</h6>
                                <div class="text-muted" style="font-size: 12px;">
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-0.5">Publikasi Sekolah</span> • Terdistribusi ke 8 kelas
                                </div>
                            </div>
                        </div>
                        <span class="text-muted" style="font-size: 12px;">2 jam lalu</span>
                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="text-muted d-flex justify-content-between align-items-center py-3 border-top" style="font-size: 12px;">
                <span>© 2025 JosLearn. Hak Cipta Dilindungi.</span>
                <span>Absensi & Nilai Raport Real Time</span>
            </div>
        </div>
    </div>

    <!-- Script Inisialisasi Icon Lucide -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>