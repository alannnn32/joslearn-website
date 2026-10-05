<?php
/**
 * views/teacher/attendance_manage.php
 * Halaman Kelola Absensi Siswa (Portal Guru).
 *
 * Data yang diharapkan dari AttendanceController (jika belum ada, dipakai data contoh):
 *   $rombel, $listRombel   rombel terpilih & daftar pilihan
 *   $tanggal               'Y-m-d'
 *   $jamKe, $jamMulai, $jamSelesai, $sesiAktif (bool)
 *   $radiusGeofence        meter (default dari konstanta GEOFENCE_RADIUS jika ada)
 *   $terakhirUpdate        teks, mis. 'Hari ini pukul 11.05 WIB oleh Bpk. Ahmad Fauzi'
 *   $siswaList             tiap item: id, nama, nisn, jk ('L'|'P'), absen, foto (opsional),
 *                          status ('hadir'|'izin'|'sakit'|'alpha'), waktu (mis. '10.58' atau null),
 *                          geofence_ok (bool), catatan, bukti (nama file di uploads/, opsional)
 *
 * TODO: ganti data contoh dengan hasil Attendance::getByClassAndDate() sesuai Attendance.php tim.
 * TODO: proses POST (action = save) di AttendanceController.
 */

$pageTitle  = 'Kelola Absensi Siswa';
$activeMenu = 'absensi';

// ---------- Data contoh (hapus setelah terhubung ke Attendance.php) ----------
$rombel         = $rombel         ?? 'Kelas XI-3 (Matematika Lanjut)';
$listRombel     = $listRombel     ?? ['Kelas XI-3 (Matematika Lanjut)', 'Kelas XI-4 (Matematika Lanjut)', 'Kelas XII-1 (Matematika Lanjut)'];
$tanggal        = $tanggal        ?? date('Y-m-d');
$jamKe          = $jamKe          ?? '3 s/d 4';
$jamMulai       = $jamMulai       ?? '11.00';
$jamSelesai     = $jamSelesai     ?? '12.30';
$sesiAktif      = $sesiAktif      ?? true;
$radiusGeofence = $radiusGeofence ?? (defined('GEOFENCE_RADIUS') ? GEOFENCE_RADIUS : 80);
$terakhirUpdate = $terakhirUpdate ?? 'Hari ini pukul 11.05 WIB oleh Bpk. Ahmad Fauzi';
$tahunAktif     = $tahunAjaranAktif ?? '2026/2027';
$siswaList      = $siswaList      ?? (function () {
    $d = [
        ['Ahmad Fauzan Rasyid','0861293849','L','hadir','10.58','Tepat waktu di kelas',null],
        ['Siti Aisyah Azzahra','0861293848','P','hadir','10.56','',null],
        ['Budi Santoso','0871284910','L','izin',null,'Dispensasi Tim Putsal','surat_dispensasi.pdf'],
        ['Dewi Anggraini Putri','0871284911','P','hadir','10.55','Tepat waktu',null],
        ['Dimas Prasetya','0861293850','L','sakit',null,'Surat Keterangan Sakit','surat_sakit.pdf'],
        ['Fajar Nugroho','0861275828','L','hadir','11.02','',null],
        ['Nadia Zahra Ramadhani','0861275821','P','hadir','10.57','',null],
        ['Rizky Pratama','0861275822','L','hadir','11.01','',null],
        ['Rudiansyah','0861293847','L','hadir','10.59','',null],
        ['Tri Wulandari','0861293855','P','hadir','11.00','',null],
    ];
    $out = [];
    foreach ($d as $i => $r) {
        $out[] = ['id' => $i + 1, 'nama' => $r[0], 'nisn' => $r[1], 'jk' => $r[2], 'absen' => $i + 1, 'status' => $r[3],
                  'waktu' => $r[4], 'geofence_ok' => $r[4] !== null, 'catatan' => $r[5], 'bukti' => $r[6]];
    }
    return $out;
})();

$statusOpsi = ['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpha' => 'Alpha'];

include __DIR__ . '/../includes/header.php';
?>

<style>
    .ab-chip { display:inline-flex; align-items:center; gap:6px; border-radius:6px; padding:3px 10px; font-size:.7rem; font-weight:700; background:#eaf0ff; color:var(--jl-blue); }
    .ab-card { background:#fff; border:1px solid var(--jl-border); border-radius:14px; }
    .ab-sum { padding:14px 16px; height:100%; }
    .ab-sum small { display:block; font-size:.66rem; font-weight:700; color:var(--jl-muted); }
    .ab-sum b { font-size:1.7rem; font-weight:800; line-height:1.2; }
    .ab-sum .sub { font-size:.72rem; color:var(--jl-muted); }
    .ab-sum.total { background:var(--jl-blue-dark); border-color:var(--jl-blue-dark); color:#fff; }
    .ab-sum.total small, .ab-sum.total .sub { color:#cfdbff; }
    .ab-bar { height:5px; border-radius:99px; background:#e3e8f0; overflow:hidden; margin-top:8px; }
    .ab-bar i { display:block; height:100%; background:var(--jl-blue); transition:width .2s; }
    .ab-session { background:#eaf0ff; border:1px solid #dbe5ff; border-radius:10px; padding:8px 14px; font-size:.78rem; }
    .ab-table { margin:0; font-size:.82rem; }
    .ab-table th { font-size:.66rem; font-weight:700; color:var(--jl-muted); background:#f8fafc; white-space:nowrap; padding:10px 8px; }
    .ab-table td { vertical-align:middle; padding:10px 8px; }
    .ab-avatar { width:34px; height:34px; border-radius:50%; background:#eaf0ff; color:var(--jl-blue); font-weight:700; font-size:.75rem; display:inline-grid; place-items:center; flex:none; object-fit:cover; }
    .ab-seg { display:inline-flex; gap:4px; }
    .ab-seg input { position:absolute; opacity:0; pointer-events:none; }
    .ab-seg label { border:1px solid var(--jl-border); border-radius:6px; padding:3px 10px; font-size:.72rem; font-weight:600; color:#344054; cursor:pointer; background:#fff; margin:0; }
    .ab-seg input:focus-visible + label { outline:2px solid var(--jl-blue); outline-offset:1px; }
    .ab-seg input:checked + label.s-hadir { background:var(--jl-blue-dark); border-color:var(--jl-blue-dark); color:#fff; }
    .ab-seg input:checked + label.s-izin  { background:#b54708; border-color:#b54708; color:#fff; }
    .ab-seg input:checked + label.s-sakit { background:#7a2e9e; border-color:#7a2e9e; color:#fff; }
    .ab-seg input:checked + label.s-alpha { background:var(--jl-red); border-color:var(--jl-red); color:#fff; }
    .ab-time { display:inline-flex; align-items:center; gap:6px; background:#eaf0ff; color:var(--jl-blue); border-radius:8px; padding:3px 10px; font-size:.72rem; font-weight:600; white-space:nowrap; }
    .ab-note { border:1px solid transparent; background:transparent; border-radius:6px; padding:4px 6px; width:100%; min-width:170px; font-size:.8rem; }
    .ab-note:hover { border-color:var(--jl-border); }
    .ab-note:focus { outline:none; border-color:var(--jl-blue); background:#fff; box-shadow:0 0 0 3px rgba(35,71,184,.12); }
    .ab-savebar { position:fixed; left:var(--jl-sidebar-w); right:0; bottom:0; z-index:1020; background:#fff; border-top:1px solid var(--jl-border);
                  padding:12px 24px; display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
    .ab-wrap { padding-bottom:84px; }
    .ab-btn-main { background:var(--jl-blue-dark); border-color:var(--jl-blue-dark); color:#fff; font-weight:600; }
    .ab-btn-main:hover { background:var(--jl-blue); color:#fff; }
    @media (max-width: 991.98px) { .ab-savebar { left:0; padding:10px 14px; } }
</style>

<div class="ab-wrap">
    <form method="post" action="<?= e(jl_url('teacher/attendance_manage')) ?>" id="formAbsen" novalidate>
        <input type="hidden" name="action" value="save">

        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
            <div>
                <div class="mb-2"><span class="ab-chip"><i class="bi bi-geo-alt-fill"></i>Geofence radius: aktif (<?= e($radiusGeofence) ?> m)</span></div>
                <h1 class="h3 fw-bold mb-1">Kelola Absensi Siswa</h1>
                <p class="text-secondary small mb-0" style="max-width:560px">Pencatatan presensi tatap muka per jam pelajaran terintegrasi dengan sensor GPS geofencing sekolah dan notifikasi real-time portal wali murid.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnSemuaHadir"><i class="bi bi-check2-all me-1"></i>Tandai Semua Hadir</button>
                <!-- Tampilan saja: butuh handler ekspor, menunggu persetujuan -->
                <button type="button" class="btn btn-outline-secondary btn-sm" disabled title="Belum aktif"><i class="bi bi-download me-1"></i>Unduh Rekap</button>
                <button type="submit" class="btn ab-btn-main btn-sm"><i class="bi bi-floppy me-1"></i>Simpan Absensi</button>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-3 align-items-end mb-3">
            <div>
                <label class="form-label small fw-semibold mb-1" for="selRombel">Pilih rombel</label>
                <select class="form-select form-select-sm" id="selRombel" name="rombel">
                    <?php foreach ($listRombel as $r): ?><option <?= $r === $rombel ? 'selected' : '' ?>><?= e($r) ?></option><?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="form-label small fw-semibold mb-1" for="tgl">Tanggal presensi</label>
                <input type="date" class="form-control form-control-sm" id="tgl" name="tanggal" value="<?= e($tanggal) ?>">
            </div>
            <div class="ab-session ms-lg-auto">
                <b>Jam pelajaran ke-<?= e($jamKe) ?> (<?= e($jamMulai) ?> - <?= e($jamSelesai) ?> WIB)</b><br>
                <span class="text-secondary">Status: <?= $sesiAktif ? 'sesi aktif berlangsung' : 'sesi tidak aktif' ?></span>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-6 col-lg"><div class="ab-card ab-sum"><small>HADIR</small><b id="sumHadir">0</b> <span class="small text-primary fw-semibold" id="sumPersen"></span><div class="ab-bar"><i id="barHadir" style="width:0"></i></div></div></div>
            <div class="col-6 col-lg"><div class="ab-card ab-sum"><small>IZIN DISPENSASI</small><b id="sumIzin">0</b> <span class="small">Siswa</span><div class="sub" id="subIzin"></div></div></div>
            <div class="col-6 col-lg"><div class="ab-card ab-sum"><small>SAKIT</small><b id="sumSakit">0</b> <span class="small">Siswa</span><div class="sub" id="subSakit"></div></div></div>
            <div class="col-6 col-lg"><div class="ab-card ab-sum"><small>TANPA KETERANGAN</small><b id="sumAlpha">0</b> <span class="small">Siswa</span><div class="sub" id="subAlpha"></div></div></div>
            <div class="col-12 col-lg"><div class="ab-card ab-sum total"><small>TOTAL SISWA <?= e(preg_replace('/^Kelas\s+(\S+).*$/', '$1', $rombel)) ?></small><b><?= count($siswaList) ?></b> <span class="small">Siswa aktif</span><div class="sub">Sinkron Dapodik <?= e($tahunAktif) ?></div></div></div>
        </div>

        <div class="ab-card overflow-hidden">
            <div class="d-flex flex-wrap justify-content-between align-items-center px-3 py-2 border-bottom gap-2">
                <div class="fw-bold small"><i class="bi bi-list-check me-1"></i>Daftar presensi murid
                    <span class="ab-chip ms-1"><?= count($siswaList) ?> siswa ditampilkan</span></div>
                <input type="search" class="form-control form-control-sm" id="cariSiswa" placeholder="Cari nama atau NISN..." style="max-width:240px">
            </div>
            <div class="table-responsive">
                <table class="table ab-table" id="tabelAbsen">
                    <thead><tr>
                        <th>NO</th><th>FOTO &amp; NAMA SISWA</th><th>NISN</th><th>STATUS KEHADIRAN</th><th>WAKTU PRESENSI</th><th>KETERANGAN &amp; CATATAN GURU</th>
                    </tr></thead>
                    <tbody>
                    <?php foreach ($siswaList as $i => $s):
                        $id = $s['id'];
                        $ini = strtoupper(substr(preg_replace('/[^A-Za-z ]/', '', $s['nama']), 0, 1) . (strpos($s['nama'], ' ') !== false ? substr(strrchr($s['nama'], ' '), 1, 1) : '')); ?>
                        <tr data-nama="<?= e(strtolower($s['nama'])) ?>" data-nisn="<?= e($s['nisn']) ?>">
                            <td><?= e(str_pad($i + 1, 2, '0', STR_PAD_LEFT)) ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <?php if (!empty($s['foto'])): ?><img src="<?= e($s['foto']) ?>" alt="" class="ab-avatar">
                                    <?php else: ?><span class="ab-avatar"><?= e($ini) ?></span><?php endif; ?>
                                    <div class="lh-sm"><div class="fw-semibold"><?= e($s['nama']) ?></div>
                                        <small class="text-secondary"><?= $s['jk'] === 'L' ? 'Laki-laki' : 'Perempuan' ?> &bull; Absen <?= e(str_pad($s['absen'], 2, '0', STR_PAD_LEFT)) ?></small></div>
                                </div>
                            </td>
                            <td class="text-secondary"><?= e($s['nisn']) ?></td>
                            <td>
                                <div class="ab-seg" role="radiogroup" aria-label="Status <?= e($s['nama']) ?>">
                                    <?php foreach ($statusOpsi as $val => $lbl): $rid = "st{$id}_{$val}"; ?>
                                        <input type="radio" name="absen[<?= e($id) ?>][status]" id="<?= e($rid) ?>" value="<?= $val ?>" <?= $s['status'] === $val ? 'checked' : '' ?>>
                                        <label for="<?= e($rid) ?>" class="s-<?= $val ?>"><?= $lbl ?></label>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td>
                                <?php if (!empty($s['waktu'])): ?>
                                    <span class="ab-time"><i class="bi bi-geo-alt"></i><?= e($s['waktu']) ?> WIB <?= !empty($s['geofence_ok']) ? '(Geofence OK)' : '(Di luar radius)' ?></span>
                                <?php else: ?><span class="text-secondary">-</span><?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <input type="text" class="ab-note" name="absen[<?= e($id) ?>][catatan]" value="<?= e($s['catatan']) ?>" maxlength="150" placeholder="Tambah catatan" aria-label="Catatan <?= e($s['nama']) ?>">
                                    <?php if (!empty($s['bukti'])): ?>
                                        <a href="<?= e(jl_url('uploads/' . $s['bukti'])) ?>" target="_blank" rel="noopener" class="text-primary" title="Lihat bukti surat"><i class="bi bi-paperclip"></i></a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div id="kosong" class="text-center text-secondary small py-4 d-none">Tidak ada siswa yang cocok dengan pencarian.</div>
            <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top flex-wrap gap-2">
                <small class="text-secondary" id="infoHal"></small>
                <ul class="pagination pagination-sm mb-0" id="paging"></ul>
            </div>
        </div>

        <div class="ab-savebar">
            <i class="bi bi-arrow-repeat text-primary"></i>
            <div class="me-auto small"><b>Tersinkronisasi otomatis dengan server absensi pusat &amp; portal orang tua</b><br>
                <span class="text-secondary">Terakhir diperbarui: <?= e($terakhirUpdate) ?></span></div>
            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnReset">Reset Form</button>
            <button type="submit" class="btn ab-btn-main btn-sm"><i class="bi bi-check-circle me-1"></i>Simpan Presensi Harian</button>
        </div>
    </form>
</div>

<script>
(function () {
    var PER_PAGE = 10, page = 1;
    var rows = Array.prototype.slice.call(document.querySelectorAll('#tabelAbsen tbody tr'));
    var form = document.getElementById('formAbsen');
    var $ = function (id) { return document.getElementById(id); };

    function status(tr) {
        var c = tr.querySelector('input[type=radio]:checked');
        return c ? c.value : '';
    }

    function ringkas() {
        var n = { hadir: 0, izin: 0, sakit: 0, alpha: 0 };
        rows.forEach(function (tr) { var s = status(tr); if (n[s] !== undefined) n[s]++; });
        var total = rows.length || 1;
        $('sumHadir').textContent = n.hadir;
        $('sumPersen').textContent = (n.hadir / total * 100).toFixed(1).replace('.', ',') + '%';
        $('barHadir').style.width = (n.hadir / total * 100) + '%';
        $('sumIzin').textContent = n.izin;   $('sumSakit').textContent = n.sakit;   $('sumAlpha').textContent = n.alpha;
        $('subIzin').textContent  = n.izin  ? 'Ada surat dispensasi' : 'Tidak ada';
        $('subSakit').textContent = n.sakit ? 'Ada surat keterangan sakit' : 'Tidak ada';
        $('subAlpha').textContent = n.alpha ? 'Perlu tindak lanjut' : 'Semua terdata rapi';
    }

    function tampil() {
        var q = $('cariSiswa').value.trim().toLowerCase();
        var cocok = rows.filter(function (tr) { return !q || tr.dataset.nama.indexOf(q) > -1 || tr.dataset.nisn.indexOf(q) > -1; });
        var hal = Math.max(1, Math.ceil(cocok.length / PER_PAGE));
        page = Math.min(page, hal);
        rows.forEach(function (tr) { tr.style.display = 'none'; });
        cocok.slice((page - 1) * PER_PAGE, page * PER_PAGE).forEach(function (tr) { tr.style.display = ''; });
        $('kosong').classList.toggle('d-none', cocok.length > 0);
        var b = Math.min(page * PER_PAGE, cocok.length);
        $('infoHal').textContent = 'Halaman ' + page + ' dari ' + hal + ' (menampilkan ' + (cocok.length ? b - ((page - 1) * PER_PAGE) : 0) + ' siswa)';
        var ul = $('paging'); ul.innerHTML = '';
        for (var i = 1; i <= hal; i++) {
            var li = document.createElement('li'); li.className = 'page-item' + (i === page ? ' active' : '');
            var a = document.createElement('a'); a.className = 'page-link'; a.href = '#'; a.textContent = i;
            a.addEventListener('click', (function (n) { return function (ev) { ev.preventDefault(); page = n; tampil(); }; })(i));
            li.appendChild(a); ul.appendChild(li);
        }
    }

    $('btnSemuaHadir').addEventListener('click', function () {
        if (!confirm('Tandai semua siswa hadir? Status yang sudah diisi akan ditimpa.')) return;
        rows.forEach(function (tr) { tr.querySelector('input[value=hadir]').checked = true; });
        ringkas();
    });
    $('btnReset').addEventListener('click', function () {
        if (!confirm('Kembalikan semua isian ke kondisi awal?')) return;
        form.reset(); ringkas();
    });
    $('tabelAbsen').addEventListener('change', ringkas);
    $('cariSiswa').addEventListener('input', function () { page = 1; tampil(); });

    ringkas(); tampil();
})();
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>