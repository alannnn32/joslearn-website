<?php
/**
 * Halaman Data Siswa (Student Master) - Admin
 * Menampilkan daftar semua siswa dengan fitur CRUD
 */

// Ambil data filter dari parameter GET
$filter_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

// Contoh data siswa (sementara, nanti dari database)
$students = [
    [
        'id' => 1,
        'nisn' => '0012345678',
        'nama' => 'Andi Pratama',
        'kelas' => 'X IPA 1',
        'jenis_kelamin' => 'L',
        'status' => 'Aktif',
        'inisial' => 'AP'
    ],
    [
        'id' => 2,
        'nisn' => '0012345679',
        'nama' => 'Siti Nurhaliza',
        'kelas' => 'X IPA 1',
        'jenis_kelamin' => 'P',
        'status' => 'Aktif',
        'inisial' => 'SN'
    ],
    [
        'id' => 3,
        'nisn' => '0012345680',
        'nama' => 'Budi Santoso',
        'kelas' => 'X IPA 2',
        'jenis_kelamin' => 'L',
        'status' => 'Aktif',
        'inisial' => 'BS'
    ],
    [
        'id' => 4,
        'nisn' => '0012345681',
        'nama' => 'Dewi Lestari',
        'kelas' => 'X IPA 2',
        'jenis_kelamin' => 'P',
        'status' => 'Tidak Aktif',
        'inisial' => 'DL'
    ],
    [
        'id' => 5,
        'nisn' => '0012345682',
        'nama' => 'Rizki Maulana',
        'kelas' => 'X IPS 1',
        'jenis_kelamin' => 'L',
        'status' => 'Aktif',
        'inisial' => 'RM'
    ]
];

// Hitung total siswa
$total_siswa = count($students);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Admin JosLearn</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Admin Layout CSS -->
    <link href="/joslearn-website/joslearn-web/assets/css/admin-layout.css" rel="stylesheet">
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
                <h1 class="page-title">Data Siswa</h1>
                <p class="page-subtitle">Manajemen data master siswa sekolah</p>
            </div>

            <!-- STATISTICS CARDS -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card dashboard-card border-0 shadow-sm p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="d-block text-uppercase text-muted fw-bold mb-1" style="font-size: 11px;">Total Siswa</span>
                                <h3 class="fw-bold text-dark mb-0" style="font-size: 24px;"><?= $total_siswa ?></h3>
                            </div>
                            <div class="p-2 rounded bg-light text-primary">
                                <i data-lucide="users" style="width: 20px; height: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card dashboard-card border-0 shadow-sm p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="d-block text-uppercase text-muted fw-bold mb-1" style="font-size: 11px;">Siswa Aktif</span>
                                <h3 class="fw-bold text-success mb-0" style="font-size: 24px;"><?= count(array_filter($students, fn($s) => $s['status'] == 'Aktif')) ?></h3>
                            </div>
                            <div class="p-2 rounded bg-light text-success">
                                <i data-lucide="user-check" style="width: 20px; height: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card dashboard-card border-0 shadow-sm p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="d-block text-uppercase text-muted fw-bold mb-1" style="font-size: 11px;">Laki-laki</span>
                                <h3 class="fw-bold text-dark mb-0" style="font-size: 24px;"><?= count(array_filter($students, fn($s) => $s['jenis_kelamin'] == 'L')) ?></h3>
                            </div>
                            <div class="p-2 rounded bg-light text-primary">
                                <i data-lucide="user" style="width: 20px; height: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card dashboard-card border-0 shadow-sm p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="d-block text-uppercase text-muted fw-bold mb-1" style="font-size: 11px;">Perempuan</span>
                                <h3 class="fw-bold text-dark mb-0" style="font-size: 24px;"><?= count(array_filter($students, fn($s) => $s['jenis_kelamin'] == 'P')) ?></h3>
                            </div>
                            <div class="p-2 rounded bg-light text-primary">
                                <i data-lucide="user" style="width: 20px; height: 20px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILTER SECTION -->
            <div class="filter-card">
                <div class="filter-header">
                    <i data-lucide="filter" style="width: 14px; height: 14px;"></i> FILTER DATA
                </div>
                <form method="GET" action="index.php">
                    <input type="hidden" name="controller" value="admin">
                    <input type="hidden" name="action" value="student_master">
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label-custom">Kelas</label>
                            <select class="form-select form-select-sm" name="kelas">
                                <option value="">Semua Kelas</option>
                                <option value="X IPA 1" <?= ($filter_kelas == 'X IPA 1') ? 'selected' : '' ?>>X IPA 1</option>
                                <option value="X IPA 2" <?= ($filter_kelas == 'X IPA 2') ? 'selected' : '' ?>>X IPA 2</option>
                                <option value="X IPS 1" <?= ($filter_kelas == 'X IPS 1') ? 'selected' : '' ?>>X IPS 1</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-custom">Status</label>
                            <select class="form-select form-select-sm" name="status">
                                <option value="">Semua Status</option>
                                <option value="Aktif" <?= ($filter_status == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                                <option value="Tidak Aktif" <?= ($filter_status == 'Tidak Aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-sm me-2">
                                <i data-lucide="search" style="width: 14px; height: 14px;" class="me-1"></i> Filter
                            </button>
                            <a href="index.php?controller=admin&action=student_master" class="btn btn-outline-secondary btn-sm">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- TABLE SECTION -->
            <div class="card">
                <div class="table-card-header">
                    <div class="d-flex align-items-center">
                        <h2 class="table-title">Daftar Siswa</h2>
                        <span class="badge-total">Total: <?= $total_siswa ?></span>
                    </div>
                    <div>
                        <button class="btn btn-primary btn-sm">
                            <i data-lucide="plus" style="width: 14px; height: 14px;" class="me-1"></i> Tambah Siswa
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jenis Kelamin</th>
                                <th>Status</th>
                                <th style="width: 100px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($students)): ?>
                                <?php foreach ($students as $index => $student): ?>
                                    <tr>
                                        <td class="fw-semibold text-secondary"><?= $index + 1 ?></td>
                                        <td class="text-muted" style="font-size: 12px;"><?= htmlspecialchars($student['nisn']) ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="student-avatar"><?= htmlspecialchars($student['inisial']) ?></div>
                                                <div class="fw-semibold"><?= htmlspecialchars($student['nama']) ?></div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($student['kelas']) ?></td>
                                        <td>
                                            <span class="badge bg-light text-dark" style="font-size: 11px;">
                                                <?= $student['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php 
                                                $statusClass = $student['status'] == 'Aktif' ? 'badge-diterbitkan' : 'badge-revisi';
                                            ?>
                                            <span class="badge-status <?= $statusClass ?>"><?= htmlspecialchars($student['status']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn-action" title="Edit">
                                                <i data-lucide="pencil" style="width: 14px; height: 14px;"></i>
                                            </a>
                                            <a href="#" class="btn-action ms-1" title="Hapus">
                                                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Tidak ada data siswa</td>
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
            <span>Sistem Manajemen Sekolah</span>
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
