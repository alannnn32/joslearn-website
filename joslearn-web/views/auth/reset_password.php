<?php
/**
 * views/auth/reset_password.php
 * Langkah 1 dari 3: Identifikasi akun (Lupa Kata Sandi) - Portal Guru JosLearn
 *
 * Alur: reset_password.php -> verify_otp.php -> new_password.php
 * Halaman ini berdiri sendiri (tanpa includes/header.php) karena dibuka sebelum login.
 * DEV_MODE (config/constants.php) = true  -> database & email dilewati, untuk menguji tampilan.
 */
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$constants = __DIR__ . '/../../config/constants.php';
if (!defined('DEV_MODE') && file_exists($constants)) { require_once $constants; }
$dev = defined('DEV_MODE') ? (bool)DEV_MODE : true;

if (!function_exists('rp_e')) {
    function rp_e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('rp_base')) {
    /** Alamat folder joslearn-web di browser, mis. /joslearn-website/joslearn-web */
    function rp_base(): string {
        if (defined('BASE_URL')) { return rtrim(BASE_URL, '/'); }
        $root = realpath(__DIR__ . '/../..');
        $doc  = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
        if (!$root || !$doc) { return ''; }
        $root = str_replace('\\', '/', $root);
        $doc  = str_replace('\\', '/', $doc);
        return stripos($root, $doc) === 0 ? rtrim(substr($root, strlen($doc)), '/') : '';
    }
}
if (!function_exists('rp_mask')) {
    /** budi@sman1rejoso.sch.id -> bu***@sman1rejoso.sch.id */
    function rp_mask(string $email): string {
        $parts = explode('@', $email, 2) + ['', ''];
        $keep  = strlen($parts[0]) > 3 ? 2 : 1;
        return substr($parts[0], 0, $keep) . '***@' . $parts[1];
    }
}
if (!function_exists('rp_icon')) {
    function rp_icon(string $n, int $s = 16): string {
        $p = [
            'mail'   => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
            'shield' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
            'user'   => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>',
            'right'  => '<path d="M5 12h14M12 5l7 7-7 7"/>',
            'left'   => '<path d="M19 12H5M12 19l-7-7 7-7"/>',
            'help'   => '<circle cx="12" cy="12" r="10"/><path d="M9.1 9a3 3 0 0 1 5.8 1c0 2-3 3-3 3M12 17h.01"/>',
            'ext'    => '<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/>',
        ][$n] ?? '';
        return '<svg width="' . $s . '" height="' . $s . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $p . '</svg>';
    }
}

$base  = rp_base();
$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Masukkan alamat email yang valid.';
    } elseif ($dev) {
        // Mode uji tampilan: lanjut ke langkah 2 tanpa cek database / kirim email.
        $_SESSION['reset_email']        = $email;
        $_SESSION['reset_email_masked'] = rp_mask($email);
        unset($_SESSION['otp_verified']);
        header('Location: ' . $base . '/views/auth/verify_otp.php');
        exit;
    } else {
        $error = 'Pengiriman kode belum terhubung ke database dan email.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lupa Kata Sandi | JosLearn</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
.rp-body,.rp-body *{box-sizing:border-box}
.rp-body{margin:0;min-height:100vh;display:flex;flex-direction:column;align-items:center;position:relative;overflow-x:hidden;background:#f8faff;color:#334155;font:14px/1.45 'Inter',system-ui,sans-serif}
.rp-bg{position:fixed;inset:0;z-index:0;pointer-events:none;background:radial-gradient(420px 320px at 5% 5%,#dbeafe 0,transparent 70%),radial-gradient(520px 420px at 100% 90%,#dbeafe 0,transparent 70%)}
.rp-brand,.rp-wrap,.rp-foot{position:relative;z-index:1}
.rp-brand{display:flex;align-items:center;gap:12px;margin-top:32px}
.rp-logo{display:grid;place-items:center;width:44px;height:44px;border-radius:12px;background:#fff;color:#2563eb;font-weight:800;font-size:22px;box-shadow:0 2px 10px rgba(15,23,42,.08)}
.rp-brand-row{display:flex;align-items:center;gap:6px}
.rp-brand b{font-size:22px;font-weight:600;color:#0757c9}
.rp-brand small{font-size:11px;font-weight:500;letter-spacing:.04em;color:#64748b}
.rp-tag{background:#dbe6fb;color:#0757c9;font-size:10px;font-weight:700;padding:2px 6px;border-radius:4px}
.rp-wrap{flex:1;display:flex;align-items:center;justify-content:center;width:100%;padding:32px 16px}
.rp-card{width:100%;max-width:480px;background:#fff;border-radius:20px;padding:40px;text-align:center;box-shadow:0 18px 40px rgba(15,23,42,.1)}
.rp-hero{position:relative;display:grid;place-items:center;width:64px;height:64px;margin:0 auto;border-radius:16px;background:#eaf2ff;color:#0757c9}
.rp-badge{position:absolute;right:-8px;bottom:-8px;display:grid;place-items:center;width:24px;height:24px;border-radius:50%;background:#0757c9;color:#fff;border:2px solid #fff}
.rp-step{display:flex;width:fit-content;align-items:center;gap:6px;margin:14px auto 18px;padding:4px 12px;border-radius:999px;background:#eaf2ff;color:#0757c9;font-size:11px;font-weight:600}
.rp-card h1{margin:0;font-size:30px;font-weight:800;letter-spacing:-.02em;color:#0f172a}
.rp-lead{margin:8px 0 24px}
.rp-form{text-align:left}
.rp-label{display:block;margin-bottom:8px;font-size:13px;font-weight:600;color:#0f172a}
.rp-field{display:flex;align-items:center;gap:10px;padding:0 14px;border:1.5px solid transparent;border-radius:12px;background:#f1f5fd;color:#64748b;transition:.15s}
.rp-field:focus-within{background:#fff;border-color:#2563eb;box-shadow:0 4px 12px rgba(37,99,235,.18)}
.rp-field.rp-bad{border-color:#ef4444;background:#fff5f5}
.rp-field input{flex:1;min-width:0;height:50px;border:0;outline:0;background:none;font:500 15px 'Inter',sans-serif;color:#0f172a}
.rp-field input::placeholder{color:#94a3b8}
.rp-msg{min-height:20px;margin:8px 0 14px;font-size:12px;font-weight:500;color:#ef4444}
.rp-submit{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;height:48px;border:0;border-radius:12px;background:#2563eb;color:#fff;font:700 15px 'Inter',sans-serif;cursor:pointer;box-shadow:0 4px 12px rgba(37,99,235,.28)}
.rp-submit:hover{background:#1d4fd8}
.rp-links{display:flex;justify-content:space-between;margin-top:32px;font-size:12px}
.rp-links a{display:inline-flex;align-items:center;gap:6px;color:#334155;text-decoration:none}
.rp-links .rp-help{color:#0e6f8c}
.rp-foot{padding:0 16px 24px;text-align:center;font-size:12px;line-height:1.8;color:#64748b}
.rp-foot b{font-weight:600;color:#0f172a}
.rp-foot i{display:inline-block;width:4px;height:4px;margin:0 6px;border-radius:50%;background:#cbd5e1;vertical-align:middle}
.rp-foot a{font-weight:600;color:#0757c9;text-decoration:none;display:inline-flex;align-items:center;gap:3px}
.rp-body svg{flex-shrink:0}
@media(max-width:520px){.rp-card{padding:28px 20px}}
</style>
</head>
<body class="rp-body">
<div class="rp-bg"></div>

<header class="rp-brand">
  <span class="rp-logo">J</span>
  <div>
    <div class="rp-brand-row"><b>JosLearn</b><span class="rp-tag">PORTAL</span></div>
    <small>SMA NEGERI 1 REJOSO NGANJUK</small>
  </div>
</header>

<main class="rp-wrap">
  <section class="rp-card">
    <div class="rp-hero"><?= rp_icon('mail', 30) ?><span class="rp-badge"><?= rp_icon('shield', 12) ?></span></div>
    <div class="rp-step"><?= rp_icon('user', 13) ?> Langkah 1 dari 3: Identifikasi Akun</div>

    <h1>Lupa Kata Sandi?</h1>
    <p class="rp-lead">Masukkan email kedinasan Anda. Kami akan mengirimkan kode keamanan 6 digit untuk verifikasi.</p>

    <form class="rp-form" method="post" action="" autocomplete="off" novalidate>
      <label class="rp-label" for="rpEmail">Email Guru</label>
      <div class="rp-field <?= $error ? 'rp-bad' : '' ?>">
        <?= rp_icon('mail', 18) ?>
        <input type="email" id="rpEmail" name="email" value="<?= rp_e($email) ?>"
               placeholder="nama@sman1rejoso.sch.id" required autofocus>
      </div>
      <p class="rp-msg" role="alert"><?= rp_e($error) ?></p>
      <button class="rp-submit" type="submit">KIRIM KODE <?= rp_icon('right') ?></button>
    </form>

    <div class="rp-links">
      <a href="<?= rp_e($base) ?>/views/auth/login.php"><?= rp_icon('left', 14) ?> Kembali ke Login</a>
      <a href="#" class="rp-help"><?= rp_icon('help', 15) ?> Bantuan Guru</a>
    </div>
  </section>
</main>

<footer class="rp-foot">
  <div><b>JosLearn</b> <i></i> SMA Negeri 1 Rejoso Nganjuk</div>
  <div>Butuh bantuan cepat? <a href="#">Hubungi Operator Dapodik Sekolah <?= rp_icon('ext', 12) ?></a></div>
</footer>
</body>
</html>
