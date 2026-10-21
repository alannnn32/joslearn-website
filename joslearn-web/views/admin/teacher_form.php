<?php
// Lokasi: joslearn-web/views/admin/teacher_form.php  (tambah & edit guru)
// Mode edit: sediakan $guru (array dari model Teacher). Mode tambah: biarkan kosong.
$web = str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '', str_replace('\\', '/', dirname(__DIR__, 2)));
$guru = $guru ?? null;
if (!$guru && isset($_GET['id'])) {   // mode edit dari tombol Edit; nanti ambil dari model Teacher
    foreach (require __DIR__ . '/teacher_sample.php' as $r) if ($r['id'] == (int)$_GET['id']) $guru = $r;
}
$edit  = !empty($guru);
$guru  = $guru ?? [];
$title = $edit ? 'Edit Guru' : 'Tambah Guru';
$v = fn($k) => htmlspecialchars($guru[$k] ?? '');

// PENTING: samakan include ini dengan yang dipakai teacher_master.php milik teman
// (jika di sana ada include sidebar_admin.php, tambahkan juga di sini)
include __DIR__ . '/../includes/header.php';
?>
<link rel="stylesheet" href="<?= $web ?>/assets/css/teacher_form.css">

<div class="tf">
  <div class="head">
    <div><h2><?= $title ?></h2><p>Lengkapi data akun dan biodata guru.</p></div>
    <a class="back" href="teacher_master.php">← Kembali</a>
  </div>

  <?php if (!empty($error)): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>

  <form class="panel" method="POST" action="<?= htmlspecialchars($formAction ?? '') ?>">
    <div class="grid">
      <div class="field"><label>Nama Lengkap</label><input name="nama_lengkap" value="<?= $v('nama_lengkap') ?>" required></div>
      <div class="field"><label>NIP</label><input name="nip" value="<?= $v('nip') ?>" required></div>
      <div class="field"><label>Email</label><input type="email" name="email" value="<?= $v('email') ?>" required></div>
      <div class="field"><label>Username</label><input name="username" value="<?= $v('username') ?>" required></div>
      <div class="field"><label>Tempat Lahir</label><input name="tempat_lahir" value="<?= $v('tempat_lahir') ?>"></div>
      <div class="field"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" value="<?= $v('tanggal_lahir') ?>"></div>
      <div class="field"><label>No. HP</label><input type="tel" name="no_hp" value="<?= $v('no_hp') ?>"></div>
      <div class="field"><label>Mata Pelajaran</label><input name="mata_pelajaran" value="<?= $v('mata_pelajaran') ?>"></div>
      <div class="field"><label>Jenis Kelamin</label>
        <select name="jenis_kelamin">
          <option value="L" <?= ($guru['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
          <option value="P" <?= ($guru['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option>
        </select></div>
      <?php if (!$edit): ?>
      <div class="field"><label>Kata Sandi Awal</label><input type="password" name="password" minlength="8" required></div>
      <?php endif; ?>
      <div class="field full"><label>Alamat</label><textarea name="alamat" rows="3"><?= $v('alamat') ?></textarea></div>
    </div>
    <div class="actions"><button class="btn">Simpan data guru</button><a class="btn ghost" href="teacher_master.php">Batal</a></div>
  </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
