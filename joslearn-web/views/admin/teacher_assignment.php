<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!function_exists('as_e')) {
    function as_e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('as_url')) {
    function as_url(string $path = ''): string {
        $root = realpath(__DIR__ . '/../..');
        $doc  = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
        $base = '';
        if ($root && $doc) {
            $root = str_replace('\\', '/', $root);
            $doc  = str_replace('\\', '/', $doc);
            if (stripos($root, $doc) === 0) $base = rtrim(substr($root, strlen($doc)), '/');
        }
        return $base . '/' . ltrim($path, '/');
    }
}
if (!function_exists('as_icon')) {
    function as_icon(string $n, int $s = 18): string {
        $p = [
            'home' => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/>',
            'users' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8"/>',
            'user' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
            'grid' => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M3 15h18M9 3v18M15 3v18"/>',
            'check' => '<path d="M20 6L9 17l-5-5"/>',
            'list' => '<path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>',
            'file' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/>',
            'columns' => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18M15 3v18"/>',
            'clock' => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
            'sliders' => '<path d="M4 21v-7M4 10V3M12 21v-9M12 8V3M20 21v-5M20 12V3M1 14h6M9 8h6M17 16h6"/>',
            'search' => '<circle cx="11" cy="11" r="8"/><path d="M21 21l-4.3-4.3"/>',
            'bell' => '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/>',
            'plus' => '<path d="M12 5v14M5 12h14"/>',
            'edit' => '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4z"/>',
            'trash' => '<path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>',
            'left' => '<path d="M15 18l-6-6 6-6"/>',
            'right' => '<path d="M9 18l6-6-6-6"/>',
            'ok' => '<circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-6"/>',
        ][$n] ?? '';
        return '<svg width="'.$s.'" height="'.$s.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$p.'</svg>';
    }
}

if (!function_exists('as_shell_top')) {
    function as_shell_top(string $title, string $active = 'penugasan'): void {
        $hari  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $tgl   = $hari[(int)date('w')] . ', ' . date('j') . ' ' . $bulan[(int)date('n')] . ' ' . date('Y');
        $menu  = [
            'MENU UTAMA'  => [['dashboard','Dashboard','home','#']],
            'DATA MASTER' => [['siswa','Data Siswa','users','#'], ['guru','Data Guru','user','#'],
                              ['penugasan','Penugasan','grid', as_url('views/admin/teacher_assignment.php')]],
            'ABSENSI'     => [['izin','Pengajuan Izin','check','#'], ['rekap','Rekap Absensi','list','#']],
            'RAPOR'       => [['verifikasi','Verifikasi Rapor','file','#'], ['rapor','Data Rapor','columns','#']],
            'SISTEM'      => [['log','Log Aktivitas','clock','#'], ['pengaturan','Pengaturan','sliders','#']],
        ];
        ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= as_e($title) ?> | JosLearn</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* Semua class berawalan .as- dan hanya aktif di <body class="as-body"> */
:root{--as-blue:#2563eb;--as-deep:#0757c9;--as-ink:#0f172a;--as-text:#334155;--as-muted:#64748b;--as-line:#e2e8f0}
.as-body,.as-body *{box-sizing:border-box}
.as-body{margin:0;display:flex;min-height:100vh;background:#f8faff;color:var(--as-text);font:14px/1.45 'Inter',system-ui,sans-serif}
.as-body a{color:inherit;text-decoration:none}
.as-body h1,.as-body p{margin:0}
.as-side{position:sticky;top:0;align-self:flex-start;display:flex;flex-direction:column;flex-shrink:0;width:239px;height:100vh;padding:28px 17px 0;overflow-y:auto;background:var(--as-deep);color:#dbe8ff}
.as-brand{display:flex;align-items:center;gap:12px;padding:0 11px 22px;color:#fff}
.as-brand-mark{display:grid;place-items:center;width:36px;height:36px;border-radius:10px;background:#fff;color:var(--as-deep);font-weight:800;font-size:18px}
.as-brand-name{font-weight:700;font-size:19px}
.as-nav-group{padding:18px 11px 8px;font-size:10px;font-weight:500;letter-spacing:.08em;color:#9fc0f5}
.as-nav-item{display:flex;align-items:center;gap:12px;height:40px;padding:0 11px;border-radius:10px;font-size:13px;font-weight:500;color:#e4eeff}
.as-nav-item:hover{background:rgba(255,255,255,.1)}
.as-nav-item.is-active{background:#fff;color:var(--as-deep);font-weight:700}
.as-side-user{position:sticky;bottom:0;display:flex;align-items:center;gap:10px;margin:auto -17px 0;padding:18px 24px;border-top:1px solid rgba(255,255,255,.18);background:var(--as-deep);color:#fff}
.as-side-user strong{display:block;font-size:12px}
.as-side-user small{font-size:10px;color:#b7d0f7}
.as-main{display:flex;flex-direction:column;flex:1;min-width:0}
.as-top{display:flex;justify-content:space-between;align-items:center;gap:16px;height:80px;padding:0 32px;background:#fff;border-bottom:1px solid var(--as-line)}
.as-top-term{font-size:11px;font-weight:700;letter-spacing:.05em;color:var(--as-blue)}
.as-top-date{margin-top:2px;font-size:14px;font-weight:500;color:var(--as-ink)}
.as-top-right{display:flex;align-items:center;gap:16px}
.as-icon-btn{position:relative;display:grid;place-items:center;width:42px;height:42px;border:1px solid var(--as-line);border-radius:12px;background:#fff;color:var(--as-ink);cursor:pointer}
.as-dot{position:absolute;top:8px;right:9px;width:8px;height:8px;border-radius:50%;background:var(--as-blue);border:2px solid #fff}
.as-top-user{display:flex;align-items:center;gap:10px;padding-left:16px;border-left:1px solid var(--as-line)}
.as-top-user strong{display:block;font-size:14px;color:var(--as-ink)}
.as-role{display:inline-block;padding:1px 6px;border-radius:4px;background:#eaf2ff;color:var(--as-blue);font-size:10px;font-weight:600}
.as-content{flex:1;padding:36px 32px}
.as-footer{display:flex;justify-content:space-between;gap:12px;padding:16px 32px;border-top:1px solid var(--as-line);background:#fff;font-size:12px;color:var(--as-muted)}
.as-avatar{display:inline-grid;place-items:center;width:32px;height:32px;border-radius:50%;background:#eaf2ff;color:var(--as-blue);font-size:11px;font-weight:700}
.as-avatar-lg{width:40px;height:40px;border:1px solid #d6e4fb;font-size:13px;color:var(--as-deep)}
.as-avatar-light{width:36px;height:36px;background:#e6eefc;color:var(--as-deep)}
.as-head{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:28px}
.as-crumb{margin-bottom:6px;font-size:12px;font-weight:600;color:var(--as-blue)}
.as-crumb i{display:inline-block;width:4px;height:4px;margin:0 6px;border-radius:50%;background:#cbd5e1;vertical-align:middle}
.as-crumb span{font-weight:500;color:var(--as-muted)}
.as-title{font-size:26px;font-weight:800;letter-spacing:-.02em;color:var(--as-ink)}
.as-sub{margin-top:4px;color:var(--as-muted)}
.as-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;height:40px;padding:0 20px;border:1px solid transparent;border-radius:10px;font:600 13px 'Inter',sans-serif;white-space:nowrap;cursor:pointer}
.as-btn-primary{background:var(--as-blue);color:#fff!important;box-shadow:0 4px 12px rgba(37,99,235,.28)}
.as-btn-primary:hover{background:#1d4fd8}
.as-btn-ghost{background:#fff;border-color:var(--as-line);color:var(--as-ink)}
.as-btn-ghost:hover{background:#f1f5f9}
.as-alert{display:flex;align-items:center;gap:10px;margin-bottom:16px;padding:12px 16px;border:1px solid #b7ebcb;border-radius:12px;background:#ecfdf3;color:#166534;font-weight:500}
.as-card{overflow:hidden;border:1px solid var(--as-line);border-radius:16px;background:#fff;box-shadow:0 1px 3px rgba(15,23,42,.04)}
.as-tools{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:20px}
.as-search{display:flex;align-items:center;gap:8px;width:320px;max-width:100%;height:38px;margin:0;padding:0 14px;border:1px solid #94a3b8;border-radius:10px;background:#fff;color:var(--as-muted)}
.as-search input{width:100%;border:0;outline:0;background:none;font:13px 'Inter',sans-serif;color:var(--as-ink)}
.as-search-top{width:256px;border-color:var(--as-line);background:#f8fafc}
.as-pill{padding:6px 12px;border-radius:8px;background:#eaf2ff;color:var(--as-deep);font-size:12px;font-weight:600;white-space:nowrap}
.as-table-wrap{overflow-x:auto}
.as-table{width:100%;border-collapse:collapse}
.as-table th{padding:16px 30px;background:#f8fafc;text-align:left;font-size:11px;font-weight:700;letter-spacing:.04em;color:var(--as-ink);white-space:nowrap}
.as-table td{padding:18px 30px;vertical-align:middle}
.as-table tbody tr:hover{background:#fafcff}
.as-table .as-c{text-align:center}
.as-strong{font-weight:600;color:var(--as-ink)}
.as-mono{font:12px ui-monospace,Menlo,monospace;color:var(--as-ink)}
.as-nowrap{white-space:nowrap}
.as-person{display:flex;align-items:center;gap:12px}
.as-person b{font-weight:700;color:var(--as-ink)}
.as-chip{display:inline-block;padding:3px 10px;border-radius:6px;font-size:12px;font-weight:500}
.as-chip-line{border:1px solid var(--as-line);background:#fff;color:var(--as-ink)}
.as-chip-blue{background:#eaf2ff;color:var(--as-blue)}
.as-act{display:inline-grid;place-items:center;width:32px;height:32px;border:0;border-radius:8px;background:none;cursor:pointer}
.as-act:hover{background:#f1f5f9}
.as-edit{color:var(--as-blue)} .as-del{color:#ef4444}
.as-foot{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:20px 24px;font-size:12px;color:var(--as-muted)}
.as-foot b{color:var(--as-ink)}
.as-pager{display:flex;gap:8px}
.as-pg{display:grid;place-items:center;width:32px;height:32px;border:0;border-radius:8px;background:#f1f5f9;color:var(--as-muted);font:600 12px 'Inter',sans-serif}
.as-pg:disabled{opacity:.6}
.as-pg-on{background:#3b6fc9;color:#fff}
.as-form{max-width:1064px;padding:24px 25px}
.as-field{margin-bottom:18px}
.as-field label{display:block;margin-bottom:8px;font-size:12px;font-weight:700;color:var(--as-ink)}
.as-select{display:block;width:100%;height:42px;padding:0 40px 0 16px;border:1px solid #cbd5e1;border-radius:10px;font:13px 'Inter',sans-serif;color:var(--as-ink);appearance:none;background:#f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' stroke='%2364748b' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 16px center}
.as-select:focus{outline:0;border-color:var(--as-blue);box-shadow:0 0 0 3px rgba(37,99,235,.15);background-color:#fff}
.as-note{margin:8px 0 24px;padding:12px 16px;border:1px solid #d6e4fb;border-radius:12px;background:#eff6ff;color:#1e40af;font-size:13px}
.as-actions{display:flex;justify-content:flex-end;gap:16px}
.as-actions .as-btn{min-width:220px;height:34px;font-size:12px}
@media(max-width:900px){
.as-body{flex-direction:column}.as-side{position:static;width:100%;height:auto}.as-side-user{display:none}
.as-top{height:auto;padding:14px 16px;flex-wrap:wrap}.as-search-top{display:none}.as-content{padding:24px 16px}
.as-head{flex-direction:column}.as-tools{flex-direction:column;align-items:stretch}.as-search{width:100%}
.as-actions{flex-direction:column-reverse}.as-actions .as-btn{min-width:0;width:100%}.as-table th,.as-table td{padding:14px 16px}}
</style>
</head>
<body class="as-body">
<aside class="as-side">
  <a class="as-brand" href="<?= as_e(as_url('views/admin/teacher_assignment.php')) ?>"><span class="as-brand-mark">J</span><span class="as-brand-name">JosLearn</span></a>
  <nav>
    <?php foreach ($menu as $group => $items): ?>
      <div class="as-nav-group"><?= as_e($group) ?></div>
      <?php foreach ($items as [$key, $label, $ic, $href]): ?>
        <a class="as-nav-item <?= $active === $key ? 'is-active' : '' ?>" href="<?= as_e($href) ?>"><?= as_icon($ic) ?><span><?= as_e($label) ?></span></a>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </nav>
  <div class="as-side-user"><span class="as-avatar as-avatar-light">AD</span><div><strong>Admin Sekolah</strong><small>Administrator</small></div></div>
</aside>
<div class="as-main">
  <header class="as-top">
    <div><div class="as-top-term">TAHUN AJARAN 2024/2025 • SEMESTER GENAP</div><div class="as-top-date"><?= as_e($tgl) ?></div></div>
    <div class="as-top-right">
      <label class="as-search as-search-top"><?= as_icon('search', 16) ?><input type="search" placeholder="Cari data siswa, kelas..."></label>
      <button class="as-icon-btn" type="button" aria-label="Notifikasi"><?= as_icon('bell') ?><span class="as-dot"></span></button>
      <div class="as-top-user"><span class="as-avatar as-avatar-lg">AS</span><div><strong>Admin Sekolah</strong><span class="as-role">Super Admin</span></div></div>
    </div>
  </header>
  <main class="as-content">
<?php
    }
}
if (!function_exists('as_shell_bottom')) {
    function as_shell_bottom(): void {
        ?>
  </main>
  <footer class="as-footer"><span>© 2025 JosLearn. Hak Cipta Dilindungi.</span><span>Absensi &amp; Nilai Raport Real Time</span></footer>
</div>
<script>
(function () {

  document.querySelectorAll('[data-as-filter]').forEach(function (input) {
    var rows = document.querySelectorAll('#' + input.dataset.asFilter + ' tbody tr');
    input.addEventListener('input', function () {
      var q = input.value.toLowerCase();
      rows.forEach(function (r) { r.style.display = r.textContent.toLowerCase().indexOf(q) > -1 ? '' : 'none'; });
    });
  });

  document.querySelectorAll('[data-as-confirm]').forEach(function (btn) {
    btn.addEventListener('click', function () { if (confirm(btn.dataset.asConfirm)) btn.closest('tr').remove(); });
  });
})();
</script>
</body>
</html>
<?php
    }
}

if (defined('AS_LIB')) { return; }

$assignments = [
    ['nama' => 'Siti Nurhaliza', 'kelas' => 'X IPA 1', 'mapel' => 'Matematika', 'periode' => '2026/2027'],
    ['nama' => 'Ahmad Fauzi',    'kelas' => 'X IPA 2', 'mapel' => 'IPA',        'periode' => '2026/2027'],
];
$initials = function (string $n): string {
    $w = preg_split('/\s+/', trim($n));
    return strtoupper(substr($w[0], 0, 1) . substr(end($w), 0, 1));
};

as_shell_top('Penugasan Guru', 'penugasan');
?>
<div class="as-head">
  <div>
    <div class="as-crumb">PENUGASAN GURU <i></i> <span>T.A. 2026/2027</span></div>
    <h1 class="as-title">Penugasan Guru</h1>
    <p class="as-sub">Manajemen penugasan mengajar dan alokasi mata pelajaran guru</p>
  </div>
  <a class="as-btn as-btn-primary" href="<?= as_e(as_url('views/admin/teacher_assignment_form.php')) ?>"><?= as_icon('plus') ?> Tambah Penugasan</a>
</div>

<?php if (isset($_GET['saved'])): ?>
  <div class="as-alert"><?= as_icon('ok') ?> Penugasan berhasil disimpan.</div>
<?php endif; ?>

<section class="as-card">
  <div class="as-tools">
    <label class="as-search"><?= as_icon('search', 16) ?>
      <input type="search" placeholder="Cari nama guru, kelas, atau mata pelajaran" data-as-filter="asTable"></label>
    <span class="as-pill">Total Penugasan: <?= count($assignments) ?></span>
  </div>
  <div class="as-table-wrap">
    <table class="as-table" id="asTable">
      <thead><tr><th>NO</th><th>NAMA GURU</th><th>KELAS</th><th>MATA PELAJARAN</th><th>PERIODE</th><th class="as-c">AKSI</th></tr></thead>
      <tbody>
      <?php foreach ($assignments as $i => $a): ?>
        <tr>
          <td class="as-strong"><?= $i + 1 ?></td>
          <td><span class="as-person"><span class="as-avatar"><?= as_e($initials($a['nama'])) ?></span><b><?= as_e($a['nama']) ?></b></span></td>
          <td><span class="as-chip as-chip-line"><?= as_e($a['kelas']) ?></span></td>
          <td><span class="as-chip as-chip-blue"><?= as_e($a['mapel']) ?></span></td>
          <td class="as-mono"><?= as_e($a['periode']) ?></td>
          <td class="as-c as-nowrap">
            <a class="as-act as-edit" href="<?= as_e(as_url('views/admin/teacher_assignment_form.php?id=' . ($i + 1))) ?>" title="Ubah"><?= as_icon('edit', 17) ?></a>
            <button class="as-act as-del" type="button" title="Hapus" data-as-confirm="Hapus penugasan <?= as_e($a['nama']) ?>?"><?= as_icon('trash', 17) ?></button>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="as-foot">
    <span>Menampilkan <b>1-<?= count($assignments) ?></b> dari <b><?= count($assignments) ?></b> penugasan</span>
    <div class="as-pager">
      <button class="as-pg" disabled aria-label="Sebelumnya"><?= as_icon('left', 16) ?></button>
      <button class="as-pg as-pg-on">1</button>
      <button class="as-pg" disabled aria-label="Berikutnya"><?= as_icon('right', 16) ?></button>
    </div>
  </div>
</section>
<?php as_shell_bottom(); ?>