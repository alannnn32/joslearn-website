<?php
/**
 * Modul Data Raport Admin - JosLearn
 * Terintegrasi penuh dengan struktur MVC, Session, dan Layout existing.
 */

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
    <!-- Google Fonts Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Admin Layout CSS -->
    <link href="/joslearn-website/joslearn-web/assets/css/admin-layout.css" rel="stylesheet">
    <style>
        /* Report-specific styles */
        .filter-card {
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            padding: 20px;
            margin-bottom: 24px;
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

    <!-- SIDEBAR -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/joslearn-website/joslearn-web/views/partials/sidebar_admin.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- HEADER -->
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/joslearn-website/joslearn-web/views/partials/header_admin.php'; ?>

        <!-- CONTENT BODY -->
        <div class="content-body">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1 class="page-title">Data Raport</h1>
                <p class="page-subtitle">Manajemen dan rekapitulasi nilai akademik raport siswa</p>
            </div>

            <!-- FILTER DATA -->
            <div class="filter-card">
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

    <!-- FOOTER -->
    <div class="admin-footer">
        <span>© 2025 JosLearn. Hak Cipta Dilindungi.</span>
        <span>Absensi & Nilai Raport Real Time</span>
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