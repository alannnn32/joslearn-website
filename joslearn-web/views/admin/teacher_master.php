<?php
// Lokasi: joslearn-web/views/admin/teacher_master.php  (daftar guru)
// CADANGKAN dulu file lama dengan nama yang sama sebelum menimpa.
$web   = str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '', str_replace('\\', '/', dirname(__DIR__, 2)));
$daftarGuru = $daftarGuru ?? require __DIR__ . '/teacher_sample.php';   // nanti: data dari model Teacher
$aktif = count(array_filter($daftarGuru, fn($g) => $g['status'] === 'aktif'));
$ic = ['users'=>'<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
 'ucheck'=>'<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="m16 11 2 2 4-4"/>',
 'user'=>'<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
 'file'=>'<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h8"/>'];
$s = fn($k) => '<svg viewBox="0 0 24 24">' . $ic[$k] . '</svg>';

include __DIR__ . '/../includes/header.php';   // samakan dengan include di halaman admin lain (mis. dashboard.php)
?>
<link rel="stylesheet" href="<?= $web ?>/assets/css/teacher_master.css">

<div class="tm">
  <div class="head">
    <div><h2>Data Guru</h2><p>Kelola akun dan biodata guru yang terdaftar.</p></div>
    <a class="btn" href="teacher_form.php">+ Tambah Guru</a>
  </div>

  <div class="stats">
    <div class="stat"><small>TOTAL GURU</small><b><?= count($daftarGuru) ?></b><span class="up">↑ Terdaftar</span><div class="ic"><?= $s('users') ?></div></div>
    <div class="stat"><small>GURU AKTIF</small><b><?= $aktif ?></b><span class="n">Dapat login</span><div class="ic"><?= $s('ucheck') ?></div></div>
    <div class="stat"><small>NONAKTIF</small><b><?= count($daftarGuru) - $aktif ?></b><span class="n">Perlu diperiksa</span><div class="ic"><?= $s('user') ?></div></div>
    <div class="stat hl"><small>MATA PELAJARAN</small><b><?= count(array_unique(array_column($daftarGuru, 'mata_pelajaran'))) ?></b><span class="n">Terdaftar di sistem</span><div class="ic"><?= $s('file') ?></div></div>
  </div>

  <div class="panel">
    <input class="search" id="cari" placeholder="Cari nama guru atau NIP...">
    <table>
      <thead><tr><th>NO</th><th>NAMA GURU</th><th>NIP</th><th>MATA PELAJARAN</th><th>STATUS</th><th class="r">AKSI</th></tr></thead>
      <tbody id="isi">
      <?php foreach ($daftarGuru as $n => $g):
        $p = explode(' ', $g['nama_lengkap']); $ini = strtoupper($p[0][0] . ($p[1][0] ?? '')); ?>
        <tr>
          <td><?= $n + 1 ?></td>
          <td><div class="who"><div class="av"><?= $ini ?></div><div><?= htmlspecialchars($g['nama_lengkap']) ?><small><?= $g['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?> • <?= htmlspecialchars($g['email']) ?></small></div></div></td>
          <td><span class="chip"><?= htmlspecialchars($g['nip']) ?></span></td>
          <td><?= htmlspecialchars($g['mata_pelajaran']) ?></td>
          <td><span class="badge <?= $g['status'] === 'aktif' ? '' : 'off' ?>"><?= ucfirst($g['status']) ?></span></td>
          <td><div class="acts">
            <a class="btn sm ghost" href="teacher_form.php?id=<?= (int)$g['id'] ?>">Edit</a>
            <a class="btn sm red" href="#" data-id="<?= (int)$g['id'] ?>" data-nama="<?= htmlspecialchars($g['nama_lengkap']) ?>" onclick="return hapus(this)">Hapus</a>
          </div></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <div class="pg"><span>Menampilkan <b><?= count($daftarGuru) ?></b> guru</span><b class="on">1</b></div>
  </div>
</div>

<script>
// Pencarian langsung di tabel
document.getElementById('cari').oninput = function () {
  document.querySelectorAll('#isi tr').forEach(r => r.hidden = !r.textContent.toLowerCase().includes(this.value.toLowerCase()));
};
// Hapus: konfirmasi dulu. Saat ini hanya menghapus baris di layar (belum ke database).
// Nanti ganti dengan: location.href = 'teacher_delete.php?id=' + el.dataset.id  (atau fetch ke controller)
function hapus(el) {
  if (confirm('Hapus guru "' + el.dataset.nama + '" beserta akunnya?')) el.closest('tr').remove();
  return false;
}
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
