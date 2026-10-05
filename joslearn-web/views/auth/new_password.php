<?php
/**
 * views/auth/new_password.php
 * Langkah 3 dari 3: Buat kata sandi baru (Portal Guru JosLearn)
 *
 * Variabel dari AuthController::showNewPassword():
 *   $csrfToken   string  token CSRF
 *   $errors      array   daftar pesan error dari server
 *   $success     bool    true jika kata sandi berhasil diubah
 *   $teacher     array   ['name' => ..., 'nip' => ...]
 *   $updatedAt   string  waktu pembaruan (sudah diformat WIB)
 */
$errors    = $errors    ?? [];
$success   = $success   ?? false;
$teacher   = $teacher   ?? ['name' => '-', 'nip' => '-'];
$updatedAt = $updatedAt ?? '';

if (defined('BASE_URL')) {
    $baseUrl = BASE_URL;
} else {
    $root    = str_replace('\\', '/', realpath(__DIR__ . '/../..'));
    $docRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
    $baseUrl = rtrim(substr($root, strlen($docRoot)), '/');
}

if (($_GET['preview'] ?? '') === 'success') {
    $success   = true;
    $teacher   = ['name' => 'Pak Budi Prasetyo, S.Pd', 'nip' => '19820415 200801 1 007'];
    $updatedAt = '24 September 2026, 08:42 WIB';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $success ? 'Kata Sandi Berhasil Diubah' : 'Buat Kata Sandi Baru' ?> - JosLearn</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/stylenewpw.css">
</head>
<body class="np-body">

<header class="np-brand">
    <img src="<?= $baseUrl ?>/assets/img/logo.png" alt="Logo JosLearn" class="np-brand__logo">
    <div>
        <div class="np-brand__title">JosLearn <span class="np-chip">PORTAL</span></div>
        <div class="np-brand__sub">SMA Negeri 1 Rejoso Nganjuk</div>
    </div>
</header>

<main class="np-main">

<?php if ($success): ?>
    <!-- ================= TAMPILAN SUKSES ================= -->
    <section class="np-card np-card--success" aria-live="polite">
        <div class="np-success-icon">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>
        </div>
        <span class="np-chip np-chip--dot">Akun Berhasil Diamankan</span>
        <h1 class="np-title np-title--sm">Kata Sandi Berhasil Diubah</h1>
        <p class="np-desc">Kata sandi Anda telah berhasil diperbarui. Silakan masuk menggunakan kata sandi baru untuk mengakses Portal Guru JosLearn.</p>

        <div class="np-info">
    <div class="np-info__row">
        <svg class="np-info__icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>
        <div>
            <div class="np-info__label">IDENTITAS AKUN</div>
            <div class="np-info__value"><?= htmlspecialchars($teacher['name']) ?></div>
            <div class="np-info__muted">NIP: <?= htmlspecialchars($teacher['nip']) ?></div>
        </div>
    </div>
    <div class="np-info__row">
        <svg class="np-info__icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
        <div>
            <div class="np-info__label">WAKTU PEMBARUAN</div>
            <div class="np-info__value np-info__value--sm"><?= htmlspecialchars($updatedAt) ?></div>
        </div>
    </div>
    <div class="np-info__row np-info__row--teal">
        <svg class="np-info__icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6l8-3z"/><path d="M8.5 12l2.5 2.5 4.5-5"/></svg>
        <span>Sesi Sebelumnya Ditutup Demi Keamanan</span>
    </div>
</div>

        <a href="<?= $baseUrl ?>/index.php?page=login" class="np-btn">KEMBALI KE LOGIN &rarr;</a>
        <p class="np-note">Setelah login, Anda akan langsung diarahkan ke Dashboard Guru SMA Negeri 1 Rejoso.</p>
    </section>

<?php else: ?>
    <!-- ================= FORM KATA SANDI BARU ================= -->
    <section class="np-card">
        <div class="np-lock-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="26" height="26" fill="#0b4fd6"><path d="M12 2a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V7a5 5 0 0 0-5-5zm-3 8V7a3 3 0 0 1 6 0v3H9zm2 3h2v2h2v2h-2v2h-2v-2H9v-2h2v-2z"/></svg>
        </div>
        <span class="np-chip">LANGKAH 3 DARI 3: AMANKAN AKUN GURU</span>
        <h1 class="np-title">Buat Kata Sandi Baru</h1>
        <p class="np-desc">Buat kata sandi baru untuk mengamankan akun Anda.</p>

        <?php if ($errors): ?>
            <div class="np-alert" role="alert">
                <?php foreach ($errors as $err): ?>
                    <div><?= htmlspecialchars($err) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form id="npForm" method="POST" action="<?= $baseUrl ?>/index.php?page=new_password" novalidate>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">

            <!-- Kata sandi baru -->
            <label class="np-label" for="npPassword">Kata Sandi Baru</label>
            <div class="np-field">
                <span class="np-field__icon" aria-hidden="true">&#128274;</span>
                <input type="password" id="npPassword" name="password" class="np-input"
                       autocomplete="new-password" minlength="8" maxlength="64" required
                       placeholder="Masukkan kata sandi baru">
                <button type="button" class="np-eye" data-target="npPassword" aria-label="Tampilkan atau sembunyikan kata sandi">
                    <svg class="np-eye__open" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg class="np-eye__off" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" hidden><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/><path d="M3 3l18 18"/></svg>
                </button>
            </div>

            <!-- Indikator kekuatan -->
            <div class="np-strength" aria-live="polite">
                <div class="np-strength__head">
                    <span>Kekuatan Kata Sandi</span>
                    <span id="npStrengthText" class="np-strength__text">-</span>
                </div>
                <div class="np-bar"><div id="npStrengthBar" class="np-bar__fill"></div></div>
            </div>

            <!-- Aturan keamanan -->
            <div class="np-rules">
                <div class="np-rules__title">ATURAN KEAMANAN SANDI</div>
                <ul>
                    <li data-rule="length"><i class="np-tick"></i>Minimal 8 karakter <em>(belum terpenuhi)</em></li>
                    <li data-rule="mix"><i class="np-tick"></i>Gunakan kombinasi huruf dan angka <em>(belum terpenuhi)</em></li>
                    <li data-rule="common"><i class="np-tick"></i>Jangan gunakan password yang mudah ditebak <em>(belum terpenuhi)</em></li>
                </ul>
            </div>

            <!-- Konfirmasi -->
            <label class="np-label" for="npConfirm">Konfirmasi Kata Sandi</label>
            <div class="np-field">
                <span class="np-field__icon" aria-hidden="true">&#8635;</span>
                <input type="password" id="npConfirm" name="password_confirm" class="np-input"
                       autocomplete="new-password" maxlength="64" required
                       placeholder="Ulangi kata sandi baru">
                <button type="button" class="np-eye" data-target="npConfirm" aria-label="Tampilkan atau sembunyikan konfirmasi">
                    <svg class="np-eye__open" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg class="np-eye__off" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" hidden><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/><path d="M3 3l18 18"/></svg>
                </button>
            </div>
            <div id="npMatchMsg" class="np-match" hidden></div>

            <button type="submit" id="npSubmit" class="np-btn" disabled>SIMPAN KATA SANDI &rarr;</button>
            <a href="<?= $baseUrl ?>/index.php?page=login" class="np-back">&larr; Kembali ke Login</a>
        </form>
    </section>
<?php endif; ?>

</main>

<footer class="np-footer">
    <div><strong>JosLearn</strong> &nbsp;&bull;&nbsp; SMA Negeri 1 Rejoso Nganjuk</div>
    <div>Butuh bantuan cepat? <a href="#" target="_blank" rel="noopener">Hubungi Operator Dapodik Sekolah</a></div>
</footer>

<script src="<?= $baseUrl ?>/assets/js/main.js"></script>
</body>
</html>
?>
