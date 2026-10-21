<?php
// Lokasi: joslearn-web/views/teacher/profil_guru.php
// Alamat folder web (/joslearn-website/joslearn-web), tetap benar walau dibuka lewat router maupun langsung
$web = str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '', str_replace('\\', '/', dirname(__DIR__, 2)));

// Data contoh. Nanti diganti data dari model Teacher berdasarkan $_SESSION['user_id']
$guru = $guru ?? ['nama_lengkap'=>'Pak Budi Prasetyo, S.Pd','nip'=>'198204152008011007','jenis_kelamin'=>'L',
  'tempat_lahir'=>'Nganjuk','tanggal_lahir'=>'1982-04-15','alamat'=>'Jl. Raya Rejoso No. 12, Nganjuk',
  'no_hp'=>'081234567890','mata_pelajaran'=>'Matematika','email'=>'budi@sman1rejoso.sch.id','username'=>'budi','status'=>'aktif'];
$g = fn($k) => htmlspecialchars($guru[$k] ?? '-');

include __DIR__ . '/../includes/header.php';   // header milik kelompok
?>
<link rel="stylesheet" href="<?= $web ?>/assets/css/teacher_profile.css">

<div class="tp">
  <div class="head"><h2>Profil Guru</h2><p>Informasi akun dan biodata Anda.</p></div>
  <div class="prof">
    <div class="panel me">
      <div class="av"><?= strtoupper(substr(preg_replace('/^(Pak|Bu)\s+/i', '', $guru['nama_lengkap']), 0, 1)) ?></div>
      <b><?= $g('nama_lengkap') ?></b>
      <p><?= $g('mata_pelajaran') ?></p>
      <span class="badge"><?= ucfirst($guru['status']) ?></span><br>
      <a class="btn" href="<?= $web ?>/views/auth/reset_password.php">Ubah kata sandi</a>
    </div>
    <div class="panel">
      <h3>Biodata</h3>
      <div class="kv">
        <div><small>NIP</small><span class="chip"><?= $g('nip') ?></span></div>
        <div><small>Jenis Kelamin</small><b><?= ($guru['jenis_kelamin'] ?? '') === 'L' ? 'Laki-laki' : 'Perempuan' ?></b></div>
        <div><small>Tempat, Tanggal Lahir</small><b><?= $g('tempat_lahir') ?>, <?= !empty($guru['tanggal_lahir']) ? date('d M Y', strtotime($guru['tanggal_lahir'])) : '-' ?></b></div>
        <div><small>No. HP</small><b><?= $g('no_hp') ?></b></div>
        <div><small>Email</small><b><?= $g('email') ?></b></div>
        <div><small>Username</small><b><?= $g('username') ?></b></div>
        <div class="full"><small>Alamat</small><b><?= $g('alamat') ?></b></div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
