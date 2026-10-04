<?php
session_start();

$settings = [
    'sekolah' => [
        'nama_resmi' => 'SMA Negeri 1 Rejoso Nganjuk',
        'npsn' => '20539120',
        'akreditasi' => 'A (Unggul)',
        'alamat' => 'Jalan Yos Sudarso, Desa Sidokare, Kec. Rejoso, Kab. Nganjuk, Jawa Timur 64453',
        'telepon' => '(0358) 321890',
        'email' => 'sman1rejoso.nganjuk@gmail.com'
    ],
    'semester' => [
        'tahun_ajaran' => '2026/2027',
        'pilihan_aktif' => 'Ganjil (Fase F) [Aktif]',
        'batas_kunci' => '18 Desember 2026, 23:59 WIB',
        'sisa_hari' => 'H-12 Hari Tersisa'
    ],
    'database' => [
        'ukuran_total' => '148.4 MB',
        'terakhir_sinkron' => 'Hari ini, 06:00 WIB',
        'alokasi' => '148.4 MB / 10.0 GB (1.48%)',
        'integritas' => '99.98% Integritas Data'
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - JosLearn SMAN 1 Rejoso</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            display: flex;
            background-color: #f4f7fe;
            color: #1e293b;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
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
            padding: 0 8px 24px 8px;
        }

        .brand-logo {
            width: 38px;
            height: 38px;
            background-color: #0c4a6e;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 800;
            font-size: 20px;
        }

        .brand-text .brand-title {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }

        .brand-text .brand-sub {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.5px;
        }

        .menu-category {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.8px;
            padding: 0 12px 10px 12px;
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
            padding: 10px 14px;
            color: #475569;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .menu-item a:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .menu-item.active a {
            background-color: #1d4ed8;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(29, 78, 216, 0.25);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            color: #ef4444;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            border-radius: 10px;
            margin-top: auto;
        }

        .logout-btn:hover {
            background-color: #fef2f2;
        }

        /* Main Section */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .top-header {
            background-color: #ffffff;
            height: 68px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
        }

        .search-bar {
            position: relative;
            width: 300px;
        }

        .search-bar input {
            width: 100%;
            padding: 8px 16px 8px 38px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            font-size: 12px;
            outline: none;
        }

        .search-bar i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .header-badges {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .badge-pill {
            background-color: #eff6ff;
            color: #1d4ed8;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .top-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-left: 16px;
            border-left: 1px solid #e2e8f0;
        }

        .top-user-avatar {
            width: 38px;
            height: 38px;
            background-color: #1e3a8a;
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .top-user-text .name {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
        }

        .top-user-text .role {
            font-size: 11px;
            color: #64748b;
        }

        .content-body {
            padding: 28px 32px;
            flex: 1;
        }

        .hero-banner {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hero-tags {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
        }

        .hero-tag {
            font-size: 10px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
        }

        .tag-blue { background-color: #dbeafe; color: #1e40af; }
        .tag-status { background-color: #e0e7ff; color: #3730a3; }

        .hero-title {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .hero-desc {
            font-size: 13px;
            color: #64748b;
        }

        .hero-actions {
            display: flex;
            gap: 10px;
        }

        .btn-banner {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }

        .btn-light { background-color: #f1f5f9; color: #334155; }
        .btn-primary { background-color: #1d4ed8; color: #ffffff; }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            display: flex;
            flex-direction: column;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .card-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .icon-box {
            width: 42px;
            height: 42px;
            background-color: #eff6ff;
            color: #1d4ed8;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-subtitle {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        .badge-small {
            font-size: 10px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .badge-akreditasi { background-color: #dbeafe; color: #1e40af; }
        .badge-ta { background-color: #dbeafe; color: #1e40af; }
        .badge-role { background-color: #eff6ff; color: #2563eb; }
        .badge-sync { background-color: #dcfce7; color: #15803d; }

        .info-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 16px;
        }

        .info-box-light {
            background-color: #f8fafc;
            padding: 12px 14px;
            border-radius: 8px;
        }

        .info-label {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .info-val {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
        }

        .full-info-box {
            background-color: #f8fafc;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .select-box {
            width: 100%;
            padding: 10px 14px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 16px;
            outline: none;
        }

        .alert-box-danger {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .role-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 16px;
        }

        .role-item {
            background-color: #f8fafc;
            padding: 10px 14px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .role-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge-level {
            font-size: 10px;
            font-weight: 800;
            background-color: #1e3a8a;
            color: #ffffff;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .role-title {
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
        }

        .role-desc {
            font-size: 11px;
            color: #64748b;
        }

        .db-stat-container {
            display: flex;
            align-items: baseline;
            gap: 8px;
            margin-bottom: 8px;
        }

        .db-big-stat {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
        }

        .db-sub-stat {
            font-size: 12px;
            color: #64748b;
        }

        .progress-bar-bg {
            height: 8px;
            background-color: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 12px;
        }

        .progress-bar-fill {
            height: 100%;
            width: 1.48%;
            background-color: #1d4ed8;
        }

        .integrity-box {
            background-color: #eff6ff;
            border-radius: 8px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 20px;
        }

        .bottom-banner {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .bottom-banner-img {
            width: 180px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .bottom-banner-title {
            font-size: 10px;
            font-weight: 800;
            color: #1d4ed8;
            text-transform: uppercase;
        }

        .bottom-banner-heading {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
            margin: 2px 0;
        }

        .bottom-banner-desc {
            font-size: 12px;
            color: #64748b;
        }

        .footer-info {
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #94a3b8;
        }

        .btn-full {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div>
            <div class="brand">
                <div class="brand-logo">J</div>
                <div class="brand-text">
                    <div class="brand-title">JosLearn</div>
                    <div class="brand-sub">SMAN 1 REJOSO</div>
                </div>
            </div>

            <div class="menu-category">Menu Utama</div>
            <ul class="menu-list">
                <li class="menu-item"><a href="#"><i data-lucide="layout-dashboard" style="width:16px;"></i> Dashboard</a></li>
                <li class="menu-item"><a href="#"><i data-lucide="users" style="width:16px;"></i> Data Siswa</a></li>
                <li class="menu-item"><a href="#"><i data-lucide="user-check" style="width:16px;"></i> Data Guru</a></li>
                <li class="menu-item"><a href="#"><i data-lucide="building-2" style="width:16px;"></i> Data Kelas</a></li>
                <li class="menu-item"><a href="#"><i data-lucide="book-open" style="width:16px;"></i> Mata Pelajaran</a></li>
                <li class="menu-item"><a href="#"><i data-lucide="file-spreadsheet" style="width:16px;"></i> Penugasan Guru</a></li>
                <li class="menu-item"><a href="#"><i data-lucide="user-cog" style="width:16px;"></i> Penugasan Wali Kelas</a></li>
                <li class="menu-item"><a href="#"><i data-lucide="map-pin" style="width:16px;"></i> Geofencing Absensi</a></li>
                <li class="menu-item"><a href="#"><i data-lucide="graduation-cap" style="width:16px;"></i> Kurikulum</a></li>
                <li class="menu-item"><a href="#"><i data-lucide="calendar" style="width:16px;"></i> Tahun Ajaran</a></li>
                <li class="menu-item active"><a href="#"><i data-lucide="settings" style="width:16px;"></i> Pengaturan</a></li>
            </ul>
        </div>

        <a href="#" class="logout-btn">
            <i data-lucide="log-out" style="width:16px;"></i>
            <span>Keluar Sistem</span>
        </a>
    </aside>

    <div class="main-wrapper">

        <header class="top-header">
            <div class="search-bar">
                <i data-lucide="search" style="width:14px;"></i>
                <input type="text" placeholder="Cari siswa, guru, modul...">
            </div>

            <div class="header-badges">
                <div class="badge-pill">
                    <i data-lucide="database" style="width:12px;"></i>
                    Dapodik Terhubung
                </div>
                <div class="badge-pill" style="background-color: #f1f5f9; color: #475569;">
                    <i data-lucide="calendar" style="width:12px;"></i>
                    T.A. 2026/2027 + SEMESTER GANJIL
                </div>

                <div class="top-user">
                    <div class="top-user-avatar">HW</div>
                    <div class="top-user-text">
                        <div class="name">Drs. Hendro Wibowo, M.Pd</div>
                        <div class="role">Admin Sistem & Kurikulum</div>
                    </div>
                </div>
            </div>
        </header>

        <main class="content-body">

            <div class="hero-banner">
                <div>
                    <div class="hero-tags">
                        <span class="hero-tag tag-blue">CORE ARCHITECTURE</span>
                        <span class="hero-tag tag-status">• Status Enkripsi: TLS 1.3 Active</span>
                    </div>
                    <h1 class="hero-title">Pengaturan Sistem</h1>
                    <p class="hero-desc">Konfigurasi profil institusi, semester aktif, manajemen hak akses, dan pencadangan data SMAN 1 Rejoso.</p>
                </div>
                <div class="hero-actions">
                    <button class="btn-banner btn-light">
                        <i data-lucide="scroll-text" style="width:14px;"></i> Log Audit Sistem
                    </button>
                    <button class="btn-banner btn-primary">
                        <i data-lucide="sliders" style="width:14px;"></i>
                    </button>
                </div>
            </div>

            <div class="cards-grid">

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="icon-box"><i data-lucide="shield" style="width:20px;"></i></div>
                            <div>
                                <div class="card-subtitle">IDENTITAS LEMBAGA</div>
                                <div class="card-title"><?php echo $settings['sekolah']['nama_resmi']; ?></div>
                            </div>
                        </div>
                        <span class="badge-small badge-akreditasi">Akreditasi <?php echo $settings['sekolah']['akreditasi']; ?></span>
                    </div>

                    <div class="info-group">
                        <div class="info-box-light">
                            <div class="info-label">Nama Resmi Institusi</div>
                            <div class="info-val"><?php echo $settings['sekolah']['nama_resmi']; ?></div>
                        </div>
                        <div class="info-box-light">
                            <div class="info-label">Nomor Pokok Sekolah Nasional (NPSN)</div>
                            <div class="info-val"><?php echo $settings['sekolah']['npsn']; ?></div>
                        </div>
                    </div>

                    <div class="full-info-box">
                        <i data-lucide="map-pin" style="width:16px; color:#64748b; margin-top:2px;"></i>
                        <div>
                            <div class="info-label">ALAMAT KAMPUS</div>
                            <div class="info-val" style="font-size: 12px; font-weight:600;"><?php echo $settings['sekolah']['alamat']; ?></div>
                        </div>
                    </div>

                    <div class="contact-grid">
                        <div class="full-info-box" style="margin:0;">
                            <i data-lucide="phone" style="width:16px; color:#64748b;"></i>
                            <div>
                                <div class="info-label">TELEPON KANTOR</div>
                                <div class="info-val" style="font-size: 12px;"><?php echo $settings['sekolah']['telepon']; ?></div>
                            </div>
                        </div>
                        <div class="full-info-box" style="margin:0;">
                            <i data-lucide="mail" style="width:16px; color:#64748b;"></i>
                            <div>
                                <div class="info-label">EMAIL KORESPONDENSI</div>
                                <div class="info-val" style="font-size: 12px;"><?php echo $settings['sekolah']['email']; ?></div>
                            </div>
                        </div>
                    </div>

                    <button class="btn-full btn-light" style="margin-top:auto;">
                        <i data-lucide="edit-3" style="width:14px;"></i> Edit Profil Sekolah
                    </button>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="icon-box"><i data-lucide="calendar" style="width:20px;"></i></div>
                            <div>
                                <div class="card-subtitle">KALENDER AKADEMIK</div>
                                <div class="card-title">Semester Settings</div>
                            </div>
                        </div>
                        <span class="badge-small badge-ta">• T.A. <?php echo $settings['semester']['tahun_ajaran']; ?></span>
                    </div>

                    <div style="font-size:11px; font-weight:700; color:#64748b; margin-bottom:6px;">CURRENT SEMESTER (PILIHAN SEMESTER)</div>
                    <select class="select-box">
                        <option><?php echo $settings['semester']['pilihan_aktif']; ?></option>
                    </select>

                    <div class="alert-box-danger">
                        <div>
                            <div style="font-size:10px; font-weight:800; text-transform:uppercase;">BATAS KUNCI PENGISIAN NILAI GURU</div>
                            <div style="font-size:13px; font-weight:800; margin-top:2px; display:flex; align-items:center; gap:6px;">
                                <i data-lucide="lock" style="width:14px;"></i> <?php echo $settings['semester']['batas_kunci']; ?>
                            </div>
                        </div>
                        <span style="font-size:10px; font-weight:800; background:#fca5a5; color:#7f1d1d; padding:2px 6px; border-radius:4px;">
                            <?php echo $settings['semester']['sisa_hari']; ?>
                        </span>
                    </div>

                    <div style="font-size:12px; color:#64748b; line-height:1.4; margin-bottom:20px;">
                        Siklus akademik berjalan menentukan periode penilaian, pelaporan e-Rapor, dan sinkronisasi presensi harian seluruh tingkatan kelas.
                    </div>

                    <button class="btn-full btn-primary" style="margin-top:auto;">
                        <i data-lucide="check-circle" style="width:14px;"></i> Simpan Status Semester
                    </button>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="icon-box"><i data-lucide="shield-check" style="width:20px;"></i></div>
                            <div>
                                <div class="card-subtitle">TATA KELOLA AKSES (RBAC)</div>
                                <div class="card-title">User Roles & Matrix</div>
                            </div>
                        </div>
                        <span class="badge-small badge-role">3 Peran Terdaftar</span>
                    </div>

                    <div class="role-list">
                        <div class="role-item">
                            <div class="role-left">
                                <span class="badge-level">Level 1</span>
                                <div>
                                    <div class="role-title">ADMINISTRATOR <i data-lucide="check-circle-2" style="width:12px; color:#2563eb; display:inline;"></i></div>
                                    <div class="role-desc">Akses Penuh Master Data, Penugasan, Kurikulum, & Konfig</div>
                                </div>
                            </div>
                        </div>
                        <div class="role-item">
                            <div class="role-left">
                                <span class="badge-level" style="background:#2563eb;">Level 2</span>
                                <div>
                                    <div class="role-title">GURU / PENGAJAR</div>
                                    <div class="role-desc">Akses Kelas Diampu, Input Nilai Harian/UTS/UAS, Kelola A</div>
                                </div>
                            </div>
                        </div>
                        <div class="role-item">
                            <div class="role-left">
                                <span class="badge-level" style="background:#64748b;">Level 3</span>
                                <div>
                                    <div class="role-title">SISWA</div>
                                    <div class="role-desc">Akses Jadwal, Nilai Raport Pribadi, Presensi Geofence Mo</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="full-info-box" style="background-color:#eff6ff; border:1px solid #dbeafe;">
                        <i data-lucide="info" style="width:16px; color:#1d4ed8;"></i>
                        <div style="font-size:11px; color:#1e40af; line-height:1.4;">
                            <strong>Catatan Kebijakan:</strong> Admin tidak menginput nilai dan tidak mempublikasikan rapor. Wewenang berada penuh di Dewan Guru dan Wali Kelas.
                        </div>
                    </div>

                    <button class="btn-full btn-light" style="margin-top:auto;">
                        <i data-lucide="sliders" style="width:14px;"></i> Matriks Delegasi & Akses Detail
                    </button>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="icon-box"><i data-lucide="hard-drive" style="width:20px;"></i></div>
                            <div>
                                <div class="card-subtitle">KETAHANAN DATA & CADANGAN</div>
                                <div class="card-title">Database Cluster</div>
                            </div>
                        </div>
                        <span class="badge-small badge-sync">• Cloud Sync OK</span>
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:8px;">
                        <div>
                            <div class="info-label" style="text-transform:uppercase;">UKURAN DATABASE TOTAL</div>
                            <div class="db-stat-container">
                                <span class="db-big-stat"><?php echo explode(' ', $settings['database']['ukuran_total'])[0]; ?></span>
                                <span class="db-sub-stat">MB</span>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <div class="info-label" style="text-transform:uppercase;">SINKRONISASI TERAKHIR</div>
                            <div style="font-size:12px; font-weight:700; color:#0f172a;"><?php echo $settings['database']['terakhir_sinkron']; ?></div>
                        </div>
                    </div>

                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill"></div>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:10px; font-weight:700; color:#64748b; margin-bottom:16px;">
                        <span>Alokasi Penyimpanan Dedicated</span>
                        <span><?php echo $settings['database']['alokasi']; ?></span>
                    </div>

                    <div class="integrity-box">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <i data-lucide="check-circle" style="width:16px;"></i>
                            <span><?php echo $settings['database']['integritas']; ?></span>
                        </div>
                        <span style="font-size:10px; font-weight:500; color:#3b82f6;">Checksum snapshot diverifikasi</span>
                    </div>

                    <div style="display:flex; gap:10px; margin-top:auto;">
                        <button class="btn-full btn-primary" style="flex:1;">
                            <i data-lucide="database" style="width:14px;"></i> Backup Sekarang
                        </button>
                        <button class="btn-full btn-light" style="flex:1;">
                            <i data-lucide="rotate-ccw" style="width:14px;"></i> Restore Data
                        </button>
                    </div>
                </div>

            </div>

            <div class="bottom-banner">
                <img src="https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=400" class="bottom-banner-img" alt="School">
                <div>
                    <div class="bottom-banner-title"><i data-lucide="globe" style="width:12px; display:inline;"></i> SMAN 1 REJOSO ENTERPRISE NETWORK</div>
                    <div class="bottom-banner-heading">Pusat Kendali Ekosistem Pembelajaran Digital Terintegrasi</div>
                    <div class="bottom-banner-desc">
                        Seluruh transaksi data akademik, absensi geofence, dan e-rapor diproses secara terenkripsi dan dicadangkan secara rutin ke server cadangan nasional.
                    </div>
                </div>
            </div>

            <footer class="footer-info">
                <div><i data-lucide="server" style="width:12px; display:inline;"></i> JosLearn Cloud Engine v4.2.8 • Terintegrasi dengan Server Dapodik Kemendikbudristek RI</div>
                <div>Zona Waktu: Asia/Jakarta (WIB) • Latency: 18ms</div>
            </footer>

        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
