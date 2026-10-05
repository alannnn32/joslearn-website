<?php

define('AS_LIB', true);
require_once __DIR__ . '/teacher_assignment.php';

$fields = [
    ['guru',  'Pilih Guru',      ['Rina Wulandari, M.Pd.', 'Siti Nurhaliza', 'Ahmad Fauzi']],
    ['kelas', 'Pilih Kelas',     ['XII IPA 1', 'X IPA 1', 'X IPA 2', 'XI IPA 1', 'XII IPS 1']],
    ['mapel', 'Mata Pelajaran',  ['Matematika Lanjutan', 'Matematika', 'IPA', 'Bahasa Indonesia', 'Bahasa Inggris']],
    ['peran', 'Peran Penugasan', ['Guru Pengampu', 'Wali Kelas']],
];

as_shell_top('Tambah Penugasan Guru', 'penugasan');
?>
<div class="as-head">
  <div>
    <div class="as-crumb">PENUGASAN GURU <i></i> <span>T.A. 2026/2027</span></div>
    <h1 class="as-title">Tambah Penugasan Guru</h1>
    <p class="as-sub">Hubungkan guru pengampu dengan kelas dan mata pelajaran</p>
  </div>
</div>

<form class="as-card as-form" method="get" action="<?= as_e(as_url('views/admin/teacher_assignment.php')) ?>">
  <input type="hidden" name="saved" value="1">
  <?php foreach ($fields as [$name, $label, $opts]): ?>
    <div class="as-field">
      <label for="as_<?= $name ?>"><?= as_e($label) ?></label>
      <select id="as_<?= $name ?>" name="<?= $name ?>" class="as-select" required>
        <?php foreach ($opts as $o): ?><option><?= as_e($o) ?></option><?php endforeach; ?>
      </select>
    </div>
  <?php endforeach; ?>

  <div class="as-note"><b>Catatan:</b> Penugasan ini menentukan hak akses guru terhadap rekap nilai dan absensi siswa di kelas terkait.</div>

  <div class="as-actions">
    <a class="as-btn as-btn-ghost" href="<?= as_e(as_url('views/admin/teacher_assignment.php')) ?>">Batal</a>
    <button class="as-btn as-btn-primary" type="submit">Simpan Penugasan</button>
  </div>
</form>
<?php as_shell_bottom(); ?>