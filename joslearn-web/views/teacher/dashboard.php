```php
<?php
$baseUrl = '/joslearn-website/joslearn-web';
$logoPath = $baseUrl . '/assets/img/logo.png';

$classes = [
    [
        'number' => '10',
        'name' => 'X MIPA 1',
        'subject' => 'Biologi Peminatan',
        'total' => 32,
        'status' => 'Sedang Berlangsung',
        'status_class' => 'ongoing',
        'attendance' => [
            ['count' => 27, 'label' => 'Hadir'],
            ['count' => 2, 'label' => 'Izin'],
            ['count' => 3, 'label' => 'Belum']
        ]
    ],
    [
        'number' => '10',
        'name' => 'X MIPA 2',
        'subject' => 'Kimia Dasar',
        'total' => 34,
        'status' => 'Selesai',
        'status_class' => 'done',
        'attendance' => [
            ['count' => 30, 'label' => 'Hadir'],
            ['count' => 3, 'label' => 'Sakit'],
            ['count' => 1, 'label' => 'Alpa']
        ]
    ],
    [
        'number' => '11',
        'name' => 'XI IPS 1',
        'subject' => 'Sosiologi',
        'total' => 32,
        'status' => 'Selesai',
        'status_class' => 'done',
        'attendance' => [
            ['count' => 27, 'label' => 'Hadir'],
            ['count' => 5, 'label' => 'Izin'],
            ['count' => 0, 'label' => 'Alpa']
        ]
    ]
];

$grades = [
    [
        'class' => 'X MIPA 1',
        'subject' => 'Biologi & Kimia',
        'percent' => 85,
        'filled' => '32 dari 38 siswa terisi lengkap',
        'note' => 'Nilai TP 1 - TP 2 Selesai',
        'color' => 'blue'
    ],
    [
        'class' => 'X MIPA 2',
        'subject' => 'Kimia',
        'percent' => 72,
        'filled' => '25 dari 34 siswa terisi lengkap',
        'note' => 'Tersisa 9 Siswa',
        'color' => 'teal'
    ],
    [
        'class' => 'XI IPS 1',
        'subject' => 'Sosiologi & Geografi',
        'percent' => 90,
        'filled' => '29 dari 32 siswa terisi lengkap',
        'note' => 'Hampir Lengkap',
        'color' => 'dark'
    ]
];

$activities = [
    [
        'icon' => '✓',
        'type' => 'check',
        'title' => 'Absensi X MIPA 1 berhasil dibuat',
        'description' => 'Hari ini, 07:00 WIB · Sesi pagi dibuka via portal'
    ],
    [
        'icon' => '✎',
        'type' => 'pencil',
        'title' => 'Nilai X MIPA 2 diperbarui',
        'description' => 'Kemarin, 14:20 WIB · Input nilai TP 2 (34 siswa)'
    ],
    [
        'icon' => '✓',
        'type' => 'check',
        'title' => 'Absensi XI IPS 1 selesai',
        'description' => 'Kemarin, 08:00 WIB · Rekapitulasi absensi selesai'
    ],
    [
        'icon' => '⌖',
        'type' => 'pin',
        'title' => 'Verifikasi presensi geofence aktif',
        'description' => '22 Sep 2026 · Radius gerbang SMAN 1 Rejoso'
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2563eb">

    <title>Dashboard Guru | JosLearn</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Path CSS disesuaikan dengan alamat localhost -->
    <link rel="stylesheet"
          href="<?= $baseUrl ?>/assets/css/dashboard.css?v=2">
</head>
<body>

<div class="app-shell">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <a href="#dashboard" class="brand">
            <img
                src="<?= htmlspecialchars($logoPath) ?>"
                alt="Logo JosLearn"
                class="brand-logo"
                onerror="this.style.display='none';this.nextElementSibling.style.display='grid'"
            >
            <span class="brand-fallback">J</span>

            <span class="brand-copy">
                <strong>JosLearn</strong>
                <small>SMAN 1 Rejoso</small>
            </span>
        </a>

        <div class="portal-label">
            <span class="portal-dot"></span>
            PORTAL GURU
        </div>

        <nav class="side-nav">
            <a href="#dashboard" class="nav-item active">
                <span class="nav-icon">▦</span>
                <span>Dashboard</span>
            </a>

            <a href="attendance_manage.php" class="nav-item">
                <span class="nav-icon">◷</span>
                <span>Absensi</span>
            </a>

            <a href="report_class_select.php" class="nav-item">
                <span class="nav-icon">▤</span>
                <span>Rapor</span>
            </a>

            <a href="#profil" class="nav-item">
                <span class="nav-icon">♙</span>
                <span>Profil</span>
            </a>

            <a href="#pengaturan" class="nav-item">
                <span class="nav-icon">⚙</span>
                <span>Pengaturan</span>
            </a>
        </nav>

        <a href="#keluar" class="logout-link">
            <span>↪</span> Keluar Portal
        </a>
    </aside>

    <!-- AREA DASHBOARD -->
    <main class="main-area" id="dashboard">

        <!-- HEADER -->
        <header class="topbar">
            <div class="school-title">
                <strong>SMA NEGERI 1 REJOSO NGANJUK</strong>
                <span>T.A. 2026/2027 · SEMESTER GANJIL</span>
            </div>

            <label class="search-box">
                <span class="search-icon">⌕</span>
                <input
                    type="search"
                    id="dashboardSearch"
                    placeholder="Cari data siswa, presensi, rapor..."
                    autocomplete="off"
                >
            </label>

            <div class="cloud-status">
                <span class="status-dot"></span>
                <span>
                    <b>Terhubung</b>
                    <small>Cloud</small>
                </span>
            </div>

            <button
                class="notification"
                type="button"
                aria-label="Notifikasi"
                title="Notifikasi"
            >
                ♟<i></i>
            </button>

            <div class="profile-mini">
                <span class="avatar">BP</span>
                <span class="profile-text">
                    <strong>Pak Budi Prasetyo, S.Pd</strong>
                    <small>Guru SMAN 1 Rejoso</small>
                </span>
                <span class="profile-caret">⌄</span>
            </div>
        </header>

        <!-- SAPAAN -->
        <section class="welcome-row">
            <div class="welcome-copy">
                <div class="title-line">
                    <h1>Dashboard</h1>
                    <span class="live-pill">
                        <i></i> Live Data
                    </span>
                </div>

                <p>
                    Selamat datang kembali, Bapak/Ibu Guru di Portal Akademik SMAN 1 Rejoso
                </p>
            </div>

            <div class="semester-pill">
                <span>▣</span>
                T.A. 2026/2027 · Semester Ganjil
            </div>
        </section>

        <!-- KARTU STATISTIK -->
        <section class="stats-grid">

            <article class="stat-card">
                <div class="stat-label">KELAS DIAMPU</div>
                <div class="stat-content">
                    <strong>4 <small>Kelas</small></strong>
                    <span class="stat-icon violet">▣</span>
                </div>
                <p><span class="mini-tag">Aktif</span> Kelas aktif semester ini</p>
            </article>

            <article class="stat-card">
                <div class="stat-label">JUMLAH SISWA</div>
                <div class="stat-content">
                    <strong>129 <small>Siswa</small></strong>
                    <span class="stat-icon teal">☷</span>
                </div>
                <p>Total siswa bimbingan SMAN 1</p>
            </article>

            <article class="stat-card">
                <div class="stat-label">ABSENSI HARI INI</div>
                <div class="stat-content">
                    <strong>3 <small>Aktif</small></strong>
                    <span class="stat-icon blue">✓</span>
                </div>
                <p><span class="blue-dot"></span> Dari 4 sesi jadwal tatap muka</p>
            </article>

            <article class="stat-card">
                <div class="stat-label">NILAI RAPOR</div>
                <div class="stat-content">
                    <strong class="percent">85% <small>Terisi</small></strong>
                    <span class="stat-icon lavender">▤</span>
                </div>
                <p><b class="small-blue">322</b> dari 376 kompetensi terpenuhi</p>
            </article>

        </section>

        <!-- KOLOM DASHBOARD -->
        <div class="dashboard-columns">

            <!-- KOLOM KIRI -->
            <div class="left-column">

                <!-- ABSENSI -->
                <section class="panel">
                    <div class="panel-heading">
                        <div>
                            <h2>
                                <span class="heading-dot"></span>
                                Absensi Hari Ini
                            </h2>
                            <p>
                                Pantau absensi siswa dari kelas yang Anda ampu secara real-time.
                            </p>
                        </div>

                        <span class="geofence-tag">
                            ⌖ Rejoso Campus<br>Geofence
                        </span>
                    </div>

                    <div class="class-list">
                        <?php foreach ($classes as $index => $class): ?>
                            <article class="class-row searchable-row">
                                <span class="class-number class-number-<?= $index ?>">
                                    <?= htmlspecialchars($class['number']) ?>
                                </span>

                                <div class="class-detail">
                                    <strong>
                                        <?= htmlspecialchars($class['name']) ?>

                                        <span class="state <?= htmlspecialchars($class['status_class']) ?>">
                                            <?= htmlspecialchars($class['status']) ?>
                                        </span>
                                    </strong>

                                    <small>
                                        <?= $class['total'] ?> Siswa Terdaftar
                                        · <?= htmlspecialchars($class['subject']) ?>
                                    </small>
                                </div>

                                <div class="attendance-counts">
                                    <?php foreach ($class['attendance'] as $attendance): ?>
                                        <span>
                                            <b><?= $attendance['count'] ?></b>
                                            <?= htmlspecialchars($attendance['label']) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="panel-footer">
                        <small>
                            Data contoh dashboard SMAN 1 Rejoso
                        </small>

                        <a class="primary-button" href="attendance_manage.php">
                            ♧ Kelola Absensi
                        </a>
                    </div>
                </section>

                <!-- RAPOR -->
                <section class="panel grades-panel">
                    <div class="panel-heading">
                        <div>
                            <h2>
                                <span class="heading-dot"></span>
                                Nilai Rapor
                            </h2>
                            <p>
                                Kelola dan pantau nilai rapor setiap capaian kompetensi siswa.
                            </p>
                        </div>

                        <span class="target-date">
                            Target Input: 15 Okt 2026
                        </span>
                    </div>

                    <div class="grades-list">
                        <?php foreach ($grades as $grade): ?>
                            <article class="grade-item searchable-row">
                                <div class="grade-title">
                                    <strong>
                                        <?= htmlspecialchars($grade['class']) ?>
                                        <small>
                                            (<?= htmlspecialchars($grade['subject']) ?>)
                                        </small>
                                    </strong>

                                    <b><?= $grade['percent'] ?>%</b>
                                </div>

                                <div class="progress-track">
                                    <span
                                        class="progress-<?= htmlspecialchars($grade['color']) ?>"
                                        style="width: <?= $grade['percent'] ?>%"
                                    ></span>
                                </div>

                                <div class="grade-meta">
                                    <span><?= htmlspecialchars($grade['filled']) ?></span>
                                    <b><?= htmlspecialchars($grade['note']) ?></b>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="grades-footer">
                        <span>ⓘ Format Kurikulum Merdeka 2026/2027</span>
                        <a class="soft-button" href="report_class_select.php">
                            ♧ Input Nilai
                        </a>
                    </div>
                </section>

            </div>

            <!-- KOLOM KANAN -->
            <div class="right-column">

                <!-- JADWAL -->
                <section class="schedule-card">
                    <div class="schedule-top">
                        <span>▣ Jadwal Berikutnya</span>
                        <time>09:45 - 11:15 WIB</time>
                    </div>

                    <small>JAM KE-5 · SMAN 1 REJOSO</small>

                    <h2>X MIPA 3 — Biologi Praktikum</h2>

                    <p>⌖ Laboratorium IPA (Gedung B · Lt. 2)</p>

                    <div class="schedule-bottom">
                        <span>Materi: Struktur Jaringan Tumbuhan</span>
                        <span>→</span>
                    </div>
                </section>

                <!-- AKTIVITAS -->
                <section class="panel activity-panel">
                    <div class="activity-heading">
                        <div>
                            <h2>Aktivitas Terbaru</h2>
                            <p>Pembaruan sistem akademik hari ini</p>
                        </div>
                        <span>◷</span>
                    </div>

                    <div class="activity-list">
                        <?php foreach ($activities as $activity): ?>
                            <article class="activity-item searchable-row">
                                <span class="activity-icon <?= htmlspecialchars($activity['type']) ?>">
                                    <?= htmlspecialchars($activity['icon']) ?>
                                </span>

                                <div>
                                    <strong>
                                        <?= htmlspecialchars($activity['title']) ?>
                                    </strong>

                                    <p>
                                        <?= htmlspecialchars($activity['description']) ?>
                                    </p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>

            </div>
        </div>

        <footer class="page-footer">
            © 2026 JosLearn · Portal Akademik SMAN 1 Rejoso
        </footer>

    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('dashboardSearch');
    const searchableRows = document.querySelectorAll('.searchable-row');

    if (!searchInput) {
        return;
    }

    searchInput.addEventListener('input', function () {
        const keyword = this.value.trim().toLowerCase();

        searchableRows.forEach(function (row) {
            const content = row.textContent.toLowerCase();
            row.hidden = keyword !== '' && !content.includes(keyword);
        });
    });
});
</script>

</body>
</html>
```
