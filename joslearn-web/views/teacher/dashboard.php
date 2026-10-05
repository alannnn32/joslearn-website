<?php
/**
 * views/teacher/dashboard.php
 * Dashboard Portal Guru JosLearn
 * UI statis sementara, belum menggunakan database.
 */

$pageTitle = 'Dashboard Guru';
$activeMenu = 'dashboard';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar_teacher.php';
?>

<style>
/* CSS khusus konten dashboard, tidak mengubah sidebar kelompok */
.jl-dashboard {
    font-family: 'Inter', sans-serif;
    color: #172b4d;
}

.jl-dashboard .dash-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}

.jl-dashboard .dash-heading h1 {
    font-size: 25px;
    font-weight: 800;
    margin: 0 0 5px;
}

.jl-dashboard .dash-heading p {
    color: #718096;
    font-size: 12px;
    margin: 0;
}

.jl-dashboard .live-label {
    background: #e8f7ef;
    color: #168451;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
}

.jl-dashboard .welcome-panel {
    background: linear-gradient(115deg, #173caa, #2859d9);
    color: white;
    border-radius: 13px;
    padding: 25px 27px;
    margin-bottom: 18px;
    box-shadow: 0 5px 14px rgba(35, 71, 184, .15);
}

.jl-dashboard .welcome-panel .eyebrow {
    display: inline-block;
    background: rgba(255,255,255,.15);
    border-radius: 20px;
    padding: 5px 9px;
    font-size: 9px;
    margin-bottom: 12px;
}

.jl-dashboard .welcome-panel h2 {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 7px;
}

.jl-dashboard .welcome-panel p {
    font-size: 11px;
    line-height: 1.7;
    max-width: 650px;
    margin-bottom: 14px;
    color: #e5edff;
}

.jl-dashboard .welcome-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
}

.jl-dashboard .welcome-tags span {
    font-size: 9px;
    padding: 5px 9px;
    background: rgba(255,255,255,.13);
    border-radius: 20px;
}

.jl-dashboard .stat-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 12px;
    margin-bottom: 18px;
}

.jl-dashboard .stat-card {
    background: #fff;
    border: 1px solid #edf0f7;
    border-radius: 12px;
    padding: 16px;
    min-width: 0;
}

.jl-dashboard .stat-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.jl-dashboard .stat-label {
    font-size: 9px;
    color: #78859b;
    font-weight: 700;
}

.jl-dashboard .stat-icon {
    display: grid;
    place-items: center;
    width: 34px;
    height: 34px;
    border-radius: 9px;
    background: #e8efff;
    color: #2859d9;
    font-size: 16px;
    flex-shrink: 0;
}

.jl-dashboard .stat-value {
    font-size: 25px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 7px;
}

.jl-dashboard .stat-note {
    font-size: 9px;
    color: #7a879b;
}

.jl-dashboard .dashboard-columns {
    display: grid;
    grid-template-columns: minmax(0, 1.25fr) minmax(270px, .85fr);
    gap: 16px;
    align-items: start;
}

.jl-dashboard .dash-card {
    background: #fff;
    border: 1px solid #edf0f7;
    border-radius: 12px;
    padding: 17px;
    margin-bottom: 16px;
    min-width: 0;
}

.jl-dashboard .card-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
}

.jl-dashboard .card-heading h3 {
    font-size: 13px;
    font-weight: 800;
    margin: 0 0 4px;
}

.jl-dashboard .card-heading p {
    color: #8792a5;
    font-size: 9px;
    margin: 0;
}

.jl-dashboard .small-pill {
    background: #edf2ff;
    color: #315cc7;
    border-radius: 20px;
    padding: 5px 8px;
    font-size: 9px;
    white-space: nowrap;
}

.jl-dashboard .schedule-row {
    display: grid;
    grid-template-columns: 68px minmax(0, 1fr) auto;
    gap: 10px;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f0f2f7;
}

.jl-dashboard .schedule-row:last-child {
    border-bottom: 0;
}

.jl-dashboard .schedule-time {
    background: #eef3ff;
    color: #2859d9;
    padding: 9px 5px;
    border-radius: 7px;
    font-size: 9px;
    font-weight: 800;
    text-align: center;
}

.jl-dashboard .schedule-time.current {
    background: #2156d8;
    color: #fff;
}

.jl-dashboard .schedule-info strong {
    display: block;
    font-size: 10px;
    margin-bottom: 4px;
}

.jl-dashboard .schedule-info span {
    color: #7b879b;
    font-size: 9px;
    line-height: 1.5;
}

.jl-dashboard .status-pill {
    border-radius: 20px;
    padding: 5px 7px;
    font-size: 8px;
    font-weight: 700;
    white-space: nowrap;
}

.jl-dashboard .status-done {
    color: #168451;
    background: #e7f8ef;
}

.jl-dashboard .status-live {
    color: #2456cf;
    background: #e9efff;
}

.jl-dashboard .status-wait {
    color: #8a6b16;
    background: #fff5d7;
}

.jl-dashboard .progress-item {
    margin-bottom: 17px;
}

.jl-dashboard .progress-title {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    font-size: 10px;
    margin-bottom: 7px;
}

.jl-dashboard .progress-title strong {
    font-weight: 700;
}

.jl-dashboard .progress-title span {
    color: #2859d9;
    font-weight: 800;
}

.jl-dashboard .progress {
    height: 6px;
    border-radius: 10px;
    background: #e9edf5;
    overflow: hidden;
}

.jl-dashboard .progress-bar {
    border-radius: 10px;
    background: #2860e8;
}

.jl-dashboard .progress-caption {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    color: #8591a5;
    font-size: 8px;
    margin-top: 6px;
}

.jl-dashboard .quick-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 15px;
}

.jl-dashboard .quick-actions a {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    font-size: 10px;
    font-weight: 700;
    padding: 9px 11px;
    border-radius: 7px;
    background: #214ab7;
    color: #fff;
}

.jl-dashboard .quick-actions a.secondary {
    background: #edf2ff;
    color: #214ab7;
}

.jl-dashboard .activity-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 9px;
}

.jl-dashboard .activity-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: #f5f7fc;
    border-radius: 8px;
    padding: 11px;
    min-width: 0;
}

.jl-dashboard .activity-icon {
    display: grid;
    place-items: center;
    width: 28px;
    height: 28px;
    border-radius: 7px;
    background: #e1ebff;
    color: #2859d9;
    flex-shrink: 0;
}

.jl-dashboard .activity-item strong {
    display: block;
    font-size: 9px;
    margin-bottom: 4px;
}

.jl-dashboard .activity-item p {
    color: #7b879b;
    font-size: 9px;
    line-height: 1.5;
    margin: 0;
}

.jl-dashboard .activity-time {
    color: #8994a7;
    font-size: 8px;
    white-space: nowrap;
    margin-left: auto;
}

.jl-dashboard .text-link {
    color: #2859d9;
    font-size: 9px;
    text-decoration: none;
    font-weight: 700;
}

@media (max-width: 1100px) {
    .jl-dashboard .stat-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .jl-dashboard .dashboard-columns {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 575px) {
    .jl-dashboard .dash-heading {
        align-items: flex-start;
    }

    .jl-dashboard .welcome-panel {
        padding: 20px;
    }

    .jl-dashboard .welcome-panel h2 {
        font-size: 20px;
    }

    .jl-dashboard .stat-grid {
        gap: 8px;
    }

    .jl-dashboard .stat-card {
        padding: 12px;
    }

    .jl-dashboard .stat-value {
        font-size: 21px;
    }

    .jl-dashboard .schedule-row {
        grid-template-columns: 57px minmax(0, 1fr);
    }

    .jl-dashboard .schedule-row > .status-pill {
        grid-column: 2;
        justify-self: start;
    }

    .jl-dashboard .activity-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="jl-dashboard">

    <!-- Judul dashboard -->
    <div class="dash-heading">
        <div>
            <h1>Dashboard <span class="live-label">● Live Data</span></h1>
            <p>Selamat datang kembali, Bapak/Ibu Guru di Portal Akademik SMAN 1 Rejoso</p>
        </div>
        <span class="small-pill">
            <i class="bi bi-calendar3"></i>
            T.A. 2026/2027 · Semester Ganjil
        </span>
    </div>

    <!-- Banner sambutan -->
    <section class="welcome-panel">
        <span class="eyebrow">
            <i class="bi bi-mortarboard"></i>
            TAHUN AJARAN 2026/2027 GANJIL · KURIKULUM MERDEKA
        </span>

        <h2>Selamat Datang, Bapak Ahmad<br>Fauzi, M.Pd</h2>

        <p>
            Portal Akademik Guru Mata Pelajaran Matematika dan Wali Kelas XI-3
            SMAN 1 Rejoso. Kelola agenda pembelajaran, presensi digital,
            dan validasi capaian rapor secara efisien.
        </p>

        <div class="welcome-tags">
            <span><i class="bi bi-person-workspace"></i> Guru Matematika (Fase E & F)</span>
            <span><i class="bi bi-people"></i> Wali Kelas XI-3</span>
            <span><i class="bi bi-check-circle"></i> Status Akun: Aktif</span>
        </div>
    </section>

    <!-- Ringkasan statistik -->
    <section class="stat-grid">

        <article class="stat-card">
            <div class="stat-top">
                <span class="stat-label">KELAS DIAMPU</span>
                <span class="stat-icon"><i class="bi bi-people-fill"></i></span>
            </div>
            <div class="stat-value">4 Rombel</div>
            <div class="stat-note">Kelas aktif semester ini</div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <span class="stat-label">TOTAL SISWA</span>
                <span class="stat-icon"><i class="bi bi-person-vcard"></i></span>
            </div>
            <div class="stat-value">128 Siswa</div>
            <div class="stat-note">Total siswa bimbingan</div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <span class="stat-label">ABSENSI HARI INI</span>
                <span class="stat-icon"><i class="bi bi-person-check"></i></span>
            </div>
            <div class="stat-value">3 Kelas Aktif</div>
            <div class="stat-note">2 selesai, 1 berlangsung</div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <span class="stat-label">PROGRES INPUT NILAI</span>
                <span class="stat-icon"><i class="bi bi-file-earmark-check"></i></span>
            </div>
            <div class="stat-value">88%</div>
            <div class="progress">
                <div class="progress-bar" style="width:88%"></div>
            </div>
            <div class="stat-note mt-2">112 dari 128 siswa</div>
        </article>

    </section>

    <!-- Jadwal dan progres nilai -->
    <section class="dashboard-columns">

        <div>
            <article class="dash-card">
                <div class="card-heading">
                    <div>
                        <h3><i class="bi bi-calendar-week text-primary"></i> Jadwal Mengajar Hari Ini</h3>
                        <p>Senin, 28 September 2026 · 8 Jam Pelajaran (JP)</p>
                    </div>
                    <span class="small-pill">Ruang Guru A-12</span>
                </div>

                <div class="schedule-row">
                    <div class="schedule-time">07.00–08.30</div>
                    <div class="schedule-info">
                        <strong>Kelas X-3 · Matematika Wajib</strong>
                        <span>2 JP · Pagi</span>
                    </div>
                    <span class="status-pill status-done">✓ Selesai</span>
                </div>

                <div class="schedule-row">
                    <div class="schedule-time current">09.00–10.30</div>
                    <div class="schedule-info">
                        <strong>Kelas X-5 · Ruang 105</strong>
                        <span>Matematika Wajib · Sistem Persamaan</span>
                    </div>
                    <span class="status-pill status-live">Berlangsung</span>
                </div>

                <div class="schedule-row">
                    <div class="schedule-time">11.00–12.30</div>
                    <div class="schedule-info">
                        <strong>Kelas XI-3 · Matematika Lanjut</strong>
                        <span>Ruang 203 · Transformasi</span>
                    </div>
                    <span class="status-pill status-wait">Menunggu</span>
                </div>

                <div class="schedule-row">
                    <div class="schedule-time">13.15–14.45</div>
                    <div class="schedule-info">
                        <strong>Kelas XII-6 · Matematika Lanjut</strong>
                        <span>Ruang 206 · Persamaan</span>
                    </div>
                    <span class="status-pill status-wait">Menunggu</span>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="text-secondary" style="font-size:9px">
                        Total beban tatap muka: 8 JP/hari
                    </span>
                    <a href="<?= e(jl_url('teacher/attendance_manage')) ?>"
                       class="text-link">Lihat Absensi <i class="bi bi-arrow-right"></i></a>
                </div>
            </article>
        </div>

        <div>
            <article class="dash-card">
                <div class="card-heading">
                    <div>
                        <h3><i class="bi bi-clipboard-data text-primary"></i> Progres Penilaian Rapor</h3>
                        <p>Rekap formatif dan sumatif per kelas</p>
                    </div>
                    <span class="small-pill">E-Rapor</span>
                </div>

                <div class="progress-item">
                    <div class="progress-title">
                        <strong>Kelas X-3 · Matematika Wajib</strong>
                        <span>95%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width:95%"></div>
                    </div>
                    <div class="progress-caption">
                        <span>30 dari 32 siswa lengkap</span>
                        <span>Siap 2 remedial</span>
                    </div>
                </div>

                <div class="progress-item">
                    <div class="progress-title">
                        <strong>Kelas X-5 · Matematika Wajib</strong>
                        <span>85%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width:85%"></div>
                    </div>
                    <div class="progress-caption">
                        <span>27 dari 32 siswa lengkap</span>
                        <span>5 belum masuk</span>
                    </div>
                </div>

                <div class="progress-item">
                    <div class="progress-title">
                        <strong>Kelas XI-3 · Wali Kelas</strong>
                        <span>100%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width:100%"></div>
                    </div>
                    <div class="progress-caption">
                        <span>32/32 tuntas terverifikasi</span>
                        <span>Siap cetak rapor</span>
                    </div>
                </div>

                <div class="progress-item">
                    <div class="progress-title">
                        <strong>Kelas XII-6 · Matematika Lanjut</strong>
                        <span>72%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width:72%"></div>
                    </div>
                    <div class="progress-caption">
                        <span>23 dari 32 siswa lengkap</span>
                        <span>TP-4 belum masuk</span>
                    </div>
                </div>

                <div class="quick-actions">
                    <a href="<?= e(jl_url('teacher/report_subject_grades')) ?>">
                        <i class="bi bi-pencil-square"></i> Input Nilai Cepat
                    </a>
                    <a class="secondary" href="<?= e(jl_url('teacher/report_class_select')) ?>">
                        <i class="bi bi-patch-check"></i> Validasi Rapor XI-3
                    </a>
                </div>
            </article>
        </div>

    </section>

    <!-- Aktivitas terbaru -->
    <section class="dash-card">
        <div class="card-heading">
            <div>
                <h3><i class="bi bi-clock-history text-primary"></i> Aktivitas & Log Akademik Terbaru</h3>
                <p>Jejak rekaman sistem akademik, presensi, dan nilai</p>
            </div>
            <a href="#" class="text-link">Lihat Semua Log Audit ›</a>
        </div>

        <div class="activity-grid">

            <div class="activity-item">
                <span class="activity-icon"><i class="bi bi-check-circle"></i></span>
                <div>
                    <strong>Absensi Kelas X-3 Terkirim</strong>
                    <p>Data kehadiran berhasil tersinkronisasi otomatis ke server.</p>
                </div>
                <span class="activity-time">08.35 WIB</span>
            </div>

            <div class="activity-item">
                <span class="activity-icon"><i class="bi bi-file-earmark-check"></i></span>
                <div>
                    <strong>Nilai Formatif TP-3 XI-3 Disimpan Draft</strong>
                    <p>Matematika Tingkat Lanjut · Draft siap ditinjau.</p>
                </div>
                <span class="activity-time">07.15 WIB</span>
            </div>

            <div class="activity-item">
                <span class="activity-icon"><i class="bi bi-shield-lock"></i></span>
                <div>
                    <strong>3 Siswa XI-3 Mengajukan Surat Sakit</strong>
                    <p>Lampiran surat dokter diterima dan menunggu verifikasi.</p>
                </div>
                <span class="activity-time">Kemarin</span>
            </div>

            <div class="activity-item">
                <span class="activity-icon"><i class="bi bi-people"></i></span>
                <div>
                    <strong>Rapat Koordinasi Kurikulum Merdeka</strong>
                    <p>Penyelarasan modul ajar dan persiapan asesmen sumatif.</p>
                </div>
                <span class="activity-time">Jumat</span>
            </div>

        </div>
    </section>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
```