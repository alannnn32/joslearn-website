<?php
/**
 * views/teacher/report_subject_grades.php
 * Halaman : Input Nilai Siswa (Guru Mapel) - Portal Guru JosLearn
 *
 * CATATAN INTEGRASI (hapus setelah terhubung):
 * - Jika controller sudah mengirim variabel $students, $rombelList, $tahunList,
 *   $mapel, $rombelAktif, $tahunAktif, halaman ini memakainya.
 *   Jika belum, dipakai DATA CONTOH di bawah supaya tampilan bisa dites.
 * - Format satu baris $students:
 *   ['id'=>1,'nama'=>'...','gender'=>'Laki-laki','absen'=>1,'nisn'=>'...',
 *    'foto'=>null|'url','harian'=>88,'uts'=>85,'uas'=>90,'kuis'=>85]
 */

// ---------------------------------------------------------------
// 1. KONFIGURASI
// ---------------------------------------------------------------
$pageTitle  = 'Input Nilai Siswa';
$activeMenu = 'input_nilai';   // dibaca header.php/sidebar untuk menandai menu aktif

$KKM   = 75;
$BOBOT = ['harian' => 40, 'uts' => 25, 'uas' => 25, 'kuis' => 10]; // total harus 100

if (!function_exists('e')) {
    function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}

function hitung_nilai_akhir(array $n, array $bobot): float
{
    $total = 0;
    foreach ($bobot as $k => $b) {
        $total += ((float)($n[$k] ?? 0)) * $b / 100;
    }
    return round($total, 1);
}

// Batas predikat (sesuaikan dengan ketentuan sekolah)
function tentukan_predikat(float $nilai): string
{
    if ($nilai >= 85) return 'A';
    if ($nilai >= 80) return 'B';
    if ($nilai >= 75) return 'C';
    return 'D';
}

function inisial_nama(string $nama): string
{
    $parts = preg_split('/\s+/', trim($nama));
    $in = strtoupper(substr($parts[0] ?? '', 0, 1) . substr($parts[1] ?? '', 0, 1));
    return $in ?: '?';
}

// ---------------------------------------------------------------
// 2. DATA (ganti dengan hasil model Grade.php / ReportController.php)
// ---------------------------------------------------------------
$mapel       = $mapel       ?? 'Matematika Lanjut';
$fase        = $fase        ?? 'Fase F (Kurikulum Merdeka)';
$rombelList  = $rombelList  ?? ['Kelas XI-3 (MIPA)', 'Kelas XI-1 (MIPA)', 'Kelas XI-2 (MIPA)'];
$tahunList   = $tahunList   ?? ['Ganjil 2026/2027', 'Genap 2025/2026'];
$rombelAktif = $rombelAktif ?? $rombelList[0];
$tahunAktif  = $tahunAktif  ?? $tahunList[0];
$formAction  = $formAction  ?? '';   // TODO: isi dengan route ReportController (aksi simpan nilai)

$students = $students ?? [
    ['id'=>1, 'nama'=>'Ahmad Fauzan Rasyid', 'gender'=>'Laki-laki', 'absen'=>1,  'nisn'=>'0081293849', 'foto'=>null, 'harian'=>88, 'uts'=>85, 'uas'=>90, 'kuis'=>85],
    ['id'=>2, 'nama'=>'Siti Aisyah Azzahra', 'gender'=>'Perempuan', 'absen'=>2,  'nisn'=>'0081293848', 'foto'=>null, 'harian'=>92, 'uts'=>90, 'uas'=>94, 'kuis'=>95],
    ['id'=>3, 'nama'=>'Budi Santoso',        'gender'=>'Laki-laki', 'absen'=>3,  'nisn'=>'0071284910', 'foto'=>null, 'harian'=>76, 'uts'=>74, 'uas'=>78, 'kuis'=>80],
    ['id'=>4, 'nama'=>'Dewi Anggraini Putri','gender'=>'Perempuan', 'absen'=>4,  'nisn'=>'0071284911', 'foto'=>null, 'harian'=>85, 'uts'=>82, 'uas'=>88, 'kuis'=>90],
    ['id'=>5, 'nama'=>'Dimas Prasetya',      'gender'=>'Laki-laki', 'absen'=>5,  'nisn'=>'0081293850', 'foto'=>null, 'harian'=>68, 'uts'=>70, 'uas'=>72, 'kuis'=>65],
    ['id'=>6, 'nama'=>'Fajar Nugroho',       'gender'=>'Laki-laki', 'absen'=>6,  'nisn'=>'0061275820', 'foto'=>null, 'harian'=>84, 'uts'=>80, 'uas'=>85, 'kuis'=>80],
    ['id'=>7, 'nama'=>'Nadia Zahra Ramadhani','gender'=>'Perempuan','absen'=>7,  'nisn'=>'0061275821', 'foto'=>null, 'harian'=>90, 'uts'=>88, 'uas'=>92, 'kuis'=>90],
    ['id'=>8, 'nama'=>'Rizky Pratama',       'gender'=>'Laki-laki', 'absen'=>8,  'nisn'=>'0061275822', 'foto'=>null, 'harian'=>78, 'uts'=>75, 'uas'=>76, 'kuis'=>80],
    ['id'=>9, 'nama'=>'Rudiansyah',          'gender'=>'Laki-laki', 'absen'=>9,  'nisn'=>'0081293847', 'foto'=>null, 'harian'=>89, 'uts'=>86, 'uas'=>91, 'kuis'=>88],
    ['id'=>10,'nama'=>'Tri Wulandari',       'gender'=>'Perempuan', 'absen'=>10, 'nisn'=>'0081293855', 'foto'=>null, 'harian'=>85, 'uts'=>84, 'uas'=>86, 'kuis'=>85],
];

// Ringkasan awal (diperbarui otomatis oleh JS saat nilai diedit)
$totalSiswa = count($students);
$tuntas = 0; $sumAkhir = 0;
foreach ($students as $i => $s) {
    $students[$i]['akhir'] = hitung_nilai_akhir($s, $BOBOT);
    $sumAkhir += $students[$i]['akhir'];
    if ($students[$i]['akhir'] >= $KKM) $tuntas++;
}
$remedial   = $totalSiswa - $tuntas;
$ketuntasan = $totalSiswa ? round($tuntas / $totalSiswa * 100, 1) : 0;
$rataRata   = $totalSiswa ? round($sumAkhir / $totalSiswa, 1) : 0;

// ---------------------------------------------------------------
// 3. TAMPILAN
// ---------------------------------------------------------------
// header.php sudah memuat sidebar (sesuai role) + topbar. footer.php menutup layout.
include __DIR__ . '/../includes/header.php';
?>

<style>
    /* ===== Halaman Input Nilai (prefix ipn- agar tidak bentrok dengan style lain) ===== */
    .ipn-wrap { --ipn-blue:#2347b8; --ipn-blue-soft:#eaf0ff; --ipn-red:#d92d20; --ipn-red-soft:#fff1f0; --ipn-green:#12a150; --ipn-border:#e3e8f0; --ipn-muted:#667085; padding: 0 0 96px; }
    .ipn-subject-bar { background:#eef3ff; border:1px solid #d9e3ff; border-radius:8px; padding:6px 12px; font-size:.78rem; display:inline-flex; gap:10px; align-items:center; }
    .ipn-subject-bar .tag { background:var(--ipn-blue); color:#fff; font-weight:700; border-radius:4px; padding:2px 8px; letter-spacing:.02em; }
    .ipn-title { font-weight:800; font-size:1.7rem; margin:.6rem 0 .2rem; }
    .ipn-stat { background:#fff; border:1px solid var(--ipn-border); border-radius:12px; padding:10px 16px; min-width:110px; }
    .ipn-stat .lbl { font-size:.65rem; font-weight:700; color:var(--ipn-muted); letter-spacing:.04em; text-transform:uppercase; }
    .ipn-stat .val { font-size:1.35rem; font-weight:800; line-height:1.2; }
    .ipn-stat .val small { font-size:.7rem; font-weight:600; color:var(--ipn-muted); }
    .ipn-formula { background:#f2f5fb; border:1px solid var(--ipn-border); border-radius:10px; padding:10px 14px; font-size:.82rem; display:flex; flex-wrap:wrap; gap:10px; align-items:center; }
    .ipn-formula .sigma { background:var(--ipn-blue-soft); color:var(--ipn-blue); width:26px; height:26px; border-radius:6px; display:grid; place-items:center; font-weight:700; }
    .ipn-formula code { background:#fff; border-radius:6px; padding:3px 8px; color:#344054; }
    .ipn-formula .bobot { background:var(--ipn-blue); color:#fff; border-radius:999px; padding:2px 10px; font-size:.7rem; font-weight:700; }
    .ipn-card { background:#fff; border:1px solid var(--ipn-border); border-radius:12px; }
    .ipn-card-head { padding:12px 16px; display:flex; flex-wrap:wrap; justify-content:space-between; gap:8px; align-items:center; border-bottom:1px solid var(--ipn-border); font-size:.82rem; }
    .ipn-card-head .count { background:var(--ipn-blue-soft); color:var(--ipn-blue); border-radius:999px; padding:1px 10px; font-size:.7rem; font-weight:700; margin-left:6px; }
    .ipn-legend { font-size:.72rem; color:var(--ipn-muted); display:flex; gap:14px; flex-wrap:wrap; }
    .ipn-legend i { display:inline-block; width:10px; height:10px; border-radius:2px; background:var(--ipn-blue); margin-right:5px; }
    .ipn-table-wrap { overflow-x:auto; }
    table.ipn-table { width:100%; min-width:980px; border-collapse:collapse; font-size:.85rem; }
    .ipn-table thead th { background:#f8fafc; color:var(--ipn-muted); font-size:.68rem; letter-spacing:.05em; text-transform:uppercase; padding:10px 12px; white-space:nowrap; border-bottom:1px solid var(--ipn-border); }
    .ipn-table thead th.col-edit { background:var(--ipn-blue-soft); color:var(--ipn-blue); text-align:center; }
    .ipn-table tbody td { padding:10px 12px; border-bottom:1px solid #f0f3f8; vertical-align:middle; }
    .ipn-table tbody tr.is-low { background:var(--ipn-red-soft); }
    .ipn-student { display:flex; align-items:center; gap:10px; }
    .ipn-avatar { width:34px; height:34px; border-radius:50%; background:var(--ipn-blue-soft); color:var(--ipn-blue); display:grid; place-items:center; font-weight:700; font-size:.78rem; overflow:hidden; flex:none; }
    .ipn-avatar img { width:100%; height:100%; object-fit:cover; }
    .is-low .ipn-avatar { background:#ffe0dd; color:var(--ipn-red); }
    .ipn-student .nm { font-weight:700; line-height:1.15; }
    .ipn-student .sub { font-size:.7rem; color:var(--ipn-muted); }
    .is-low .ipn-student .sub { color:var(--ipn-red); font-weight:600; }
    .ipn-input { width:62px; text-align:center; font-weight:600; border:1px solid transparent; background:var(--ipn-blue-soft); color:#1d2939; border-radius:8px; padding:5px 0; }
    .ipn-input:focus { outline:none; border-color:var(--ipn-blue); background:#fff; box-shadow:0 0 0 3px rgba(35,71,184,.15); }
    .is-low .ipn-input { background:#fff; color:var(--ipn-red); }
    .ipn-final { text-align:center; font-weight:800; background:#f4f7ff; }
    .is-low .ipn-final { color:var(--ipn-red); background:transparent; }
    .ipn-dot { display:inline-block; width:8px; height:8px; border-radius:50%; background:var(--ipn-green); margin-right:6px; }
    .is-low .ipn-dot { background:var(--ipn-red); }
    .ipn-card-foot { padding:10px 16px; display:flex; justify-content:space-between; align-items:center; font-size:.75rem; color:var(--ipn-muted); }
    .ipn-card-foot .pagination { margin:0; }
    .ipn-card-foot .page-link { border:none; border-radius:6px; margin:0 2px; color:#344054; padding:2px 9px; cursor:pointer; }
    .ipn-card-foot .page-item.active .page-link { background:var(--ipn-blue); color:#fff; }
    .ipn-savebar { position:fixed; left:0; right:0; bottom:0; z-index:1030; background:#fff; border-top:1px solid var(--ipn-border); padding:12px 24px; display:flex; flex-wrap:wrap; gap:12px; justify-content:space-between; align-items:center; box-shadow:0 -4px 16px rgba(16,24,40,.06); }
    .ipn-savebar .info { font-size:.82rem; line-height:1.25; }
    .ipn-savebar .info b { display:block; }
    .ipn-savebar .info span { color:var(--ipn-muted); }
    .btn-ipn-primary { background:var(--ipn-blue); border-color:var(--ipn-blue); color:#fff; font-weight:600; }
    .btn-ipn-primary:hover { background:#1a3896; border-color:#1a3896; color:#fff; }
    @media (min-width: 992px) { .ipn-savebar { left:240px; } } /* sesuaikan lebar sidebar */
</style>

<div class="container-fluid ipn-wrap"
     id="ipnRoot"
     data-kkm="<?= (int)$KKM ?>"
     data-b-harian="<?= (int)$BOBOT['harian'] ?>"
     data-b-uts="<?= (int)$BOBOT['uts'] ?>"
     data-b-uas="<?= (int)$BOBOT['uas'] ?>"
     data-b-kuis="<?= (int)$BOBOT['kuis'] ?>"
     data-draft-key="joslearn-nilai-<?= e($mapel . '|' . $rombelAktif . '|' . $tahunAktif) ?>">

    <!-- Mata pelajaran -->
    <div class="ipn-subject-bar">
        <span class="tag">MATA PELAJARAN: <?= e(strtoupper($mapel)) ?></span>
        <span><?= e($fase) ?></span>
    </div>

    <!-- Judul + ringkasan -->
    <div class="row g-3 align-items-start mt-0">
        <div class="col-lg-7">
            <h1 class="ipn-title">Input Nilai Siswa</h1>
            <p class="text-secondary mb-0">Kelola asesmen formatif dan sumatif Kurikulum Merdeka untuk perhitungan nilai akhir rapor otomatis secara real-time.</p>
        </div>
        <div class="col-lg-5">
            <div class="d-flex gap-2 justify-content-lg-end flex-wrap">
                <div class="ipn-stat"><div class="lbl">KKM Sekolah</div><div class="val"><?= (int)$KKM ?> <small>Skala 100</small></div></div>
                <div class="ipn-stat"><div class="lbl">Ketuntasan</div><div class="val text-success" id="statKetuntasan"><?= e($ketuntasan) ?>%</div></div>
                <div class="ipn-stat"><div class="lbl">Rata-rata Kelas</div><div class="val"><span id="statRata"><?= e($rataRata) ?></span> <small id="statRataPredikat">/B+</small></div></div>
            </div>
        </div>
    </div>

    <!-- Rumus -->
    <div class="ipn-formula mt-3">
        <span class="sigma">Σ</span>
        <strong>Rumus Aktif:</strong>
        <code>Nilai Akhir = (<?= $BOBOT['harian']/100 ?>×Harian) + (<?= $BOBOT['uts']/100 ?>×UTS) + (<?= $BOBOT['uas']/100 ?>×UAS) + (<?= $BOBOT['kuis']/100 ?>×Kuis)</code>
        <span class="bobot">Bobot Total: <?= array_sum($BOBOT) ?>%</span>
        <span class="ms-auto small text-secondary"><i class="bi bi-circle-fill text-primary" style="font-size:.5rem"></i> Sinkronisasi Otomatis TP &amp; LM</span>
    </div>

    <!-- Filter -->
    <form method="get" class="ipn-card mt-3 p-3" id="filterForm">
        <?php /* TODO: tambahkan hidden input route/page jika router index.php membutuhkannya */ ?>
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-secondary mb-1">Rombongan Belajar</label>
                <select name="rombel" class="form-select form-select-sm" onchange="this.form.submit()">
                    <?php foreach ($rombelList as $r): ?>
                        <option value="<?= e($r) ?>" <?= $r === $rombelAktif ? 'selected' : '' ?>><?= e($r) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-secondary mb-1">Tahun Ajaran</label>
                <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()">
                    <?php foreach ($tahunList as $t): ?>
                        <option value="<?= e($t) ?>" <?= $t === $tahunAktif ? 'selected' : '' ?>><?= e($t) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 d-flex gap-2 justify-content-md-end flex-wrap">
                <!-- TODO: arahkan ke aksi ReportController (unduh template / impor / ekspor) -->
                <a href="#" class="btn btn-sm btn-outline-secondary" data-action="template"><i class="bi bi-file-earmark-excel"></i> Template Excel</a>
                <a href="#" class="btn btn-sm btn-outline-secondary" data-action="import"><i class="bi bi-upload"></i> Impor Nilai</a>
                <a href="#" class="btn btn-sm btn-outline-primary" data-action="export"><i class="bi bi-table"></i> Ekspor Leger</a>
            </div>
            <div class="col-md-6 mt-2">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="search" id="searchSiswa" class="form-control" placeholder="Cari nama siswa atau NISN...">
                </div>
            </div>
        </div>
    </form>

    <!-- Form nilai -->
    <form method="post" action="<?= e($formAction) ?>" id="formNilai" class="mt-3">
        <input type="hidden" name="mapel" value="<?= e($mapel) ?>">
        <input type="hidden" name="rombel" value="<?= e($rombelAktif) ?>">
        <input type="hidden" name="tahun" value="<?= e($tahunAktif) ?>">
        <?php /* TODO: tambahkan token CSRF jika proyek sudah memakainya */ ?>

        <div class="ipn-card">
            <div class="ipn-card-head">
                <div><strong>Daftar Hasil Penilaian Asesmen</strong><span class="count">Total <?= $totalSiswa ?> Siswa</span></div>
                <div class="ipn-legend">
                    <span><i></i>Kolom Interaktif (Bisa Diedit Langsung)</span>
                    <span><i class="bi bi-keyboard" style="background:none;width:auto"></i>Tab / Enter untuk pindah kolom</span>
                </div>
            </div>

            <div class="ipn-table-wrap">
                <table class="ipn-table" id="tabelNilai">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto &amp; Nama Siswa</th>
                            <th>NISN</th>
                            <th class="col-edit">Harian (<?= $BOBOT['harian'] ?>%)</th>
                            <th class="col-edit">UTS (<?= $BOBOT['uts'] ?>%)</th>
                            <th class="col-edit">UAS (<?= $BOBOT['uas'] ?>%)</th>
                            <th class="col-edit">Kuis (<?= $BOBOT['kuis'] ?>%)</th>
                            <th class="text-center">Nilai Akhir</th>
                            <th class="text-center">Predikat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($students as $idx => $s):
                        $akhir = $s['akhir'];
                        $low   = $akhir < $KKM;
                        $sid   = (int)$s['id'];
                    ?>
                        <tr class="<?= $low ? 'is-low' : '' ?>" data-nama="<?= e(strtolower($s['nama'])) ?>" data-nisn="<?= e($s['nisn']) ?>">
                            <td class="col-no"><?= $idx + 1 ?></td>
                            <td>
                                <div class="ipn-student">
                                    <div class="ipn-avatar">
                                        <?php if (!empty($s['foto'])): ?>
                                            <img src="<?= e($s['foto']) ?>" alt="<?= e($s['nama']) ?>">
                                        <?php else: ?>
                                            <?= e(inisial_nama($s['nama'])) ?>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="nm"><?= e($s['nama']) ?></div>
                                        <div class="sub">
                                            <?php if ($low): ?>Di Bawah KKM (<?= (int)$KKM ?>)<?php else: ?><?= e($s['gender']) ?> • Absen <?= str_pad((int)$s['absen'], 2, '0', STR_PAD_LEFT) ?><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-secondary"><?= e($s['nisn']) ?></td>
                            <?php foreach (['harian','uts','uas','kuis'] as $f): ?>
                                <td class="text-center">
                                    <input type="number" inputmode="numeric" min="0" max="100" step="1"
                                           class="ipn-input" data-field="<?= $f ?>"
                                           name="nilai[<?= $sid ?>][<?= $f ?>]"
                                           value="<?= e($s[$f]) ?>" aria-label="<?= strtoupper($f) ?> <?= e($s['nama']) ?>">
                                </td>
                            <?php endforeach; ?>
                            <td class="ipn-final" data-out="akhir"><?= number_format($akhir, 1) ?></td>
                            <td class="text-center fw-bold" data-out="predikat"><?= tentukan_predikat($akhir) ?></td>
                            <td class="text-nowrap" data-out="status"><span class="ipn-dot"></span><span class="small"><?= $low ? 'Remedial' : 'Tuntas' ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$students): ?>
                        <tr><td colspan="10" class="text-center text-secondary py-4">Belum ada data siswa pada rombongan belajar ini.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="ipn-card-foot">
                <span id="infoTampil">Menampilkan 0 dari 0 data siswa</span>
                <ul class="pagination pagination-sm" id="pager"></ul>
            </div>
        </div>

        <!-- Bar simpan -->
        <div class="ipn-savebar">
            <div class="info">
                <i class="bi bi-cloud-check text-primary me-1"></i>
                <b id="draftInfo">Draft otomatis belum tersimpan</b>
                <span><span id="sumTuntas"><?= $tuntas ?></span> Siswa Tuntas, <span id="sumRemedial"><?= $remedial ?></span> Perlu Remedial</span>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" name="aksi" value="draft" class="btn btn-outline-secondary"><i class="bi bi-save me-1"></i> Simpan Draft</button>
                <button type="submit" name="aksi" value="sinkron" class="btn btn-ipn-primary"><i class="bi bi-arrow-repeat me-1"></i> Simpan Nilai &amp; Sinkronkan Rapor</button>
            </div>
        </div>
    </form>
</div>

<script>
(function () {
    var root   = document.getElementById('ipnRoot');
    var KKM    = parseFloat(root.dataset.kkm);
    var B      = { harian: +root.dataset.bHarian, uts: +root.dataset.bUts, uas: +root.dataset.bUas, kuis: +root.dataset.bKuis };
    var KEY    = root.dataset.draftKey;
    var PER    = 10;                      // baris per halaman
    var rows   = Array.prototype.slice.call(document.querySelectorAll('#tabelNilai tbody tr[data-nisn]'));
    var page   = 1;
    var timer  = null;

    function predikat(n) { return n >= 85 ? 'A' : n >= 80 ? 'B' : n >= 75 ? 'C' : 'D'; } // samakan dengan PHP
    function clamp(v) { v = parseFloat(v); if (isNaN(v)) return 0; return Math.min(100, Math.max(0, v)); }

    function hitungBaris(tr) {
        var total = 0;
        tr.querySelectorAll('.ipn-input').forEach(function (inp) {
            total += clamp(inp.value) * B[inp.dataset.field] / 100;
        });
        total = Math.round(total * 10) / 10;
        var low = total < KKM;
        tr.classList.toggle('is-low', low);
        tr.querySelector('[data-out="akhir"]').textContent = total.toFixed(1);
        tr.querySelector('[data-out="predikat"]').textContent = predikat(total);
        tr.querySelector('[data-out="status"] span.small').textContent = low ? 'Remedial' : 'Tuntas';
        var sub = tr.querySelector('.ipn-student .sub');
        if (low) { sub.dataset.orig = sub.dataset.orig || sub.textContent; sub.textContent = 'Di Bawah KKM (' + KKM + ')'; }
        else if (sub.dataset.orig) { sub.textContent = sub.dataset.orig; }
        return total;
    }

    function hitungRingkasan() {
        var sum = 0, tuntas = 0;
        rows.forEach(function (tr) {
            var n = parseFloat(tr.querySelector('[data-out="akhir"]').textContent) || 0;
            sum += n; if (n >= KKM) tuntas++;
        });
        var total = rows.length || 1;
        var rata = Math.round(sum / total * 10) / 10;
        document.getElementById('statKetuntasan').textContent = (Math.round(tuntas / total * 1000) / 10) + '%';
        document.getElementById('statRata').textContent = rata;
        document.getElementById('statRataPredikat').textContent = '/' + predikat(rata);
        document.getElementById('sumTuntas').textContent = tuntas;
        document.getElementById('sumRemedial').textContent = rows.length - tuntas;
    }

    // ---- Filter + paginasi sisi klien (semua baris tetap ikut terkirim saat disimpan) ----
    function render() {
        var q = document.getElementById('searchSiswa').value.trim().toLowerCase();
        var match = rows.filter(function (tr) { return !q || tr.dataset.nama.indexOf(q) > -1 || tr.dataset.nisn.indexOf(q) > -1; });
        var pages = Math.max(1, Math.ceil(match.length / PER));
        if (page > pages) page = pages;
        var start = (page - 1) * PER, end = start + PER;
        rows.forEach(function (tr) { tr.style.display = 'none'; });
        match.forEach(function (tr, i) { if (i >= start && i < end) tr.style.display = ''; });

        document.getElementById('infoTampil').textContent =
            'Menampilkan ' + Math.min(PER, Math.max(0, match.length - start)) + ' dari ' + match.length + ' data siswa';

        var pager = document.getElementById('pager');
        pager.innerHTML = '';
        function item(label, p, active, disabled) {
            var li = document.createElement('li');
            li.className = 'page-item' + (active ? ' active' : '') + (disabled ? ' disabled' : '');
            var a = document.createElement('a'); a.className = 'page-link'; a.textContent = label;
            a.addEventListener('click', function () { if (!disabled) { page = p; render(); } });
            li.appendChild(a); pager.appendChild(li);
        }
        item('‹', page - 1, false, page === 1);
        for (var p = 1; p <= pages; p++) item(String(p), p, p === page, false);
        item('›', page + 1, false, page === pages);
    }

    // ---- Draft otomatis (localStorage) ----
    function simpanDraft() {
        var data = {};
        document.querySelectorAll('.ipn-input').forEach(function (i) { data[i.name] = i.value; });
        try { localStorage.setItem(KEY, JSON.stringify({ t: Date.now(), data: data })); } catch (e) {}
        updateDraftInfo(Date.now());
    }
    function updateDraftInfo(t) {
        var el = document.getElementById('draftInfo');
        if (!t) return;
        var m = Math.floor((Date.now() - t) / 60000);
        el.textContent = 'Draft otomatis disimpan ' + (m < 1 ? 'baru saja' : m + ' menit yang lalu');
    }
    function pulihDraft() {
        var raw; try { raw = localStorage.getItem(KEY); } catch (e) { return; }
        if (!raw) return;
        var d = JSON.parse(raw);
        if (confirm('Ada draft nilai yang belum disimpan ke server. Pulihkan draft tersebut?')) {
            document.querySelectorAll('.ipn-input').forEach(function (i) { if (d.data[i.name] !== undefined) i.value = d.data[i.name]; });
            rows.forEach(hitungBaris); hitungRingkasan();
        }
        updateDraftInfo(d.t);
    }

    // ---- Event ----
    document.getElementById('tabelNilai').addEventListener('input', function (ev) {
        var inp = ev.target; if (!inp.classList.contains('ipn-input')) return;
        if (inp.value !== '') inp.value = clamp(inp.value);          // batasi 0-100
        hitungBaris(inp.closest('tr')); hitungRingkasan();
        clearTimeout(timer); timer = setTimeout(simpanDraft, 800);
    });

    // Enter = pindah ke baris berikutnya pada kolom yang sama
    document.getElementById('tabelNilai').addEventListener('keydown', function (ev) {
        if (ev.key !== 'Enter' || !ev.target.classList.contains('ipn-input')) return;
        ev.preventDefault();
        var tr = ev.target.closest('tr'), next = tr.nextElementSibling;
        while (next && next.style.display === 'none') next = next.nextElementSibling;
        if (next) next.querySelector('[data-field="' + ev.target.dataset.field + '"]').focus();
    });

    document.getElementById('searchSiswa').addEventListener('input', function () { page = 1; render(); });
    document.getElementById('formNilai').addEventListener('submit', function (ev) {
        var invalid = Array.prototype.some.call(document.querySelectorAll('.ipn-input'), function (i) { return i.value === ''; });
        if (invalid && ev.submitter && ev.submitter.value === 'sinkron' &&
            !confirm('Ada kolom nilai yang masih kosong (dihitung 0). Tetap simpan dan sinkronkan ke rapor?')) {
            ev.preventDefault(); return;
        }
        try { localStorage.removeItem(KEY); } catch (e) {}
    });
    setInterval(function () { try { var r = JSON.parse(localStorage.getItem(KEY)); if (r) updateDraftInfo(r.t); } catch (e) {} }, 60000);

    rows.forEach(hitungBaris); hitungRingkasan(); render(); pulihDraft();
})();
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>