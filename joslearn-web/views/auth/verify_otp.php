<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!function_exists('otp_e')) {
    function otp_e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('otp_url')) {
    function otp_url(string $path = ''): string {
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
if (!function_exists('otp_icon')) {
    function otp_icon(string $n, int $s = 16): string {
        $p = [
            'mail'  => '<path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h9"/><path d="M22 6l-10 7L2 6M16 19l2 2 4-4"/>',
            'shield'=> '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
            'timer' => '<circle cx="12" cy="13" r="8"/><path d="M12 9v4l2 2M9 2h6"/>',
            'ok'    => '<circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-6"/>',
            'right' => '<path d="M5 12h14M12 5l7 7-7 7"/>',
            'left'  => '<path d="M19 12H5M12 19l-7-7 7-7"/>',
            'help'  => '<circle cx="12" cy="12" r="10"/><path d="M9.1 9a3 3 0 0 1 5.8 1c0 2-3 3-3 3M12 17h.01"/>',
            'ext'   => '<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/>',
        ][$n] ?? '';
        return '<svg width="'.$s.'" height="'.$s.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$p.'</svg>';
    }
}

$emailMasked = $_SESSION['reset_email_masked'] ?? 'bu***@sman1rejoso.sch.id'; 
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = preg_replace('/\D/', '', $_POST['otp'] ?? '');

    $constants = __DIR__ . '/../../config/constants.php';
    if (!defined('DEV_MODE') && file_exists($constants)) { require_once $constants; }
    $dev = defined('DEV_MODE') ? (bool)DEV_MODE : true;

    if (strlen($otp) !== 6) {
        $error = 'Masukkan 6 digit kode terlebih dahulu.';
    } elseif ($dev) {

        $_SESSION['otp_verified']     = true;
        $_SESSION['reset_teacher_id'] = $_SESSION['reset_teacher_id'] ?? 1;
        $_SESSION['otp_verified_at']  = time();
        header('Location: ' . otp_url('index.php?page=new_password'));
        exit;
    } else {
        $error = 'Verifikasi OTP belum terhubung ke database.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Verifikasi Akun | JosLearn</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
.otp-body,.otp-body *{box-sizing:border-box}
.otp-body{margin:0;min-height:100vh;display:flex;flex-direction:column;align-items:center;position:relative;overflow-x:hidden;background:#f8faff;color:#334155;font:14px/1.45 'Inter',system-ui,sans-serif}
.otp-bg{position:fixed;inset:0;z-index:0;pointer-events:none;background:radial-gradient(420px 320px at 5% 5%,#dbeafe 0,transparent 70%),radial-gradient(520px 420px at 100% 90%,#dbeafe 0,transparent 70%)}
.otp-brand,.otp-wrap,.otp-foot{position:relative;z-index:1}
.otp-brand{display:flex;align-items:center;gap:12px;margin-top:32px}
.otp-logo{display:grid;place-items:center;width:44px;height:44px;border-radius:12px;background:#fff;color:#2563eb;font-weight:800;font-size:22px;box-shadow:0 2px 10px rgba(15,23,42,.08)}
.otp-brand-row{display:flex;align-items:center;gap:6px}
.otp-brand b{font-size:22px;font-weight:600;color:#0757c9}
.otp-brand small{font-size:11px;font-weight:500;letter-spacing:.04em;color:#64748b}
.otp-tag{background:#dbe6fb;color:#0757c9;font-size:10px;font-weight:700;padding:2px 6px;border-radius:4px}
.otp-wrap{flex:1;display:flex;align-items:center;justify-content:center;width:100%;padding:32px 16px}
.otp-card{width:100%;max-width:480px;background:#fff;border-radius:20px;padding:40px;text-align:center;box-shadow:0 18px 40px rgba(15,23,42,.1)}
.otp-hero{position:relative;display:grid;place-items:center;width:64px;height:64px;margin:0 auto;border-radius:16px;background:#eaf2ff;color:#0757c9}
.otp-badge{position:absolute;right:-8px;bottom:-8px;display:grid;place-items:center;width:24px;height:24px;border-radius:50%;background:#0757c9;color:#fff;border:2px solid #fff}
.otp-step{display:flex;width:fit-content;align-items:center;gap:6px;margin:14px auto 18px;padding:4px 12px;border-radius:999px;background:#eaf2ff;color:#0757c9;font-size:11px;font-weight:600}
.otp-card h1{margin:0;font-size:30px;font-weight:800;letter-spacing:-.02em;color:#0f172a}
.otp-lead{margin:8px 0 18px}
.otp-email{display:inline-flex;align-items:center;gap:8px;margin-bottom:26px;padding:8px 16px;border-radius:999px;background:#f1f5fd;color:#0757c9}
.otp-email b{font-weight:600;color:#0f172a}
.otp-email small{font-size:10px;font-weight:600;letter-spacing:.04em;color:#64748b}
.otp-boxes{display:flex;justify-content:space-between;gap:10px;margin-bottom:10px}
.otp-boxes input{width:56px;height:58px;padding:0;border:1.5px solid transparent;border-radius:12px;background:#f1f5fd;text-align:center;font:700 26px 'Inter',sans-serif;color:#0f172a;transition:.15s}
.otp-boxes input:focus{outline:0;background:#fff;border-color:#2563eb;box-shadow:0 4px 12px rgba(37,99,235,.18)}
.otp-boxes.otp-bad input{border-color:#ef4444;background:#fff5f5}
.otp-msg{min-height:20px;margin:0 0 10px;font-size:12px;font-weight:500}
.otp-err{color:#ef4444}
.otp-submit{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;height:48px;border:0;border-radius:12px;background:#2563eb;color:#fff;font:700 15px 'Inter',sans-serif;cursor:pointer;box-shadow:0 4px 12px rgba(37,99,235,.28)}
.otp-submit:hover{background:#1d4fd8}
.otp-q{margin:22px 0 0;font-size:12px}
.otp-resend{display:flex;justify-content:center;align-items:center;gap:10px;margin-top:8px}
.otp-resend button{border:0;background:none;font:600 14px 'Inter',sans-serif;color:#64748b;cursor:not-allowed}
.otp-resend button:not(:disabled){color:#2563eb;cursor:pointer}
.otp-timer{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:999px;background:#eaf2ff;color:#0e6f8c;font-size:11px;font-weight:500}
.otp-timer b{font-weight:700}
.otp-links{display:flex;justify-content:space-between;margin-top:44px;font-size:12px}
.otp-links a{display:inline-flex;align-items:center;gap:6px;color:inherit;text-decoration:none}
.otp-links .otp-help{color:#0e6f8c}
.otp-foot{padding:0 16px 24px;text-align:center;font-size:12px;line-height:1.8;color:#64748b}
.otp-foot b{font-weight:600;color:#0f172a}
.otp-foot i{display:inline-block;width:4px;height:4px;margin:0 6px;border-radius:50%;background:#cbd5e1;vertical-align:middle}
.otp-foot a{font-weight:600;color:#0757c9;text-decoration:none;display:inline-flex;align-items:center;gap:3px}
.otp-body svg{flex-shrink:0}
@media(max-width:520px){.otp-card{padding:28px 20px}.otp-boxes input{width:44px;height:50px;font-size:22px}}
</style>
</head>
<body class="otp-body">
<div class="otp-bg"></div>

<header class="otp-brand">
  <span class="otp-logo">J</span>
  <div>
    <div class="otp-brand-row"><b>JosLearn</b><span class="otp-tag">PORTAL</span></div>
    <small>SMA NEGERI 1 REJOSO NGANJUK</small>
  </div>
</header>

<main class="otp-wrap">
  <section class="otp-card">
    <div class="otp-hero"><?= otp_icon('mail', 30) ?><span class="otp-badge"><?= otp_icon('shield', 12) ?></span></div>
    <div class="otp-step"><?= otp_icon('timer', 13) ?> Langkah 2 dari 3: Verifikasi Kode Keamanan</div>

    <h1>Verifikasi Akun</h1>
    <p class="otp-lead">Kami telah mengirimkan 6 digit kode keamanan ke email kedinasan Anda:</p>
    <div class="otp-email"><?= otp_icon('ok') ?> <b><?= otp_e($emailMasked) ?></b> <small>TERVALIDASI</small></div>

    <form id="otpForm" method="post" action="" autocomplete="off">
      <input type="hidden" name="otp" id="otpValue">
      <div class="otp-boxes" id="otpBoxes">
        <?php for ($i = 1; $i <= 6; $i++): ?>
          <input type="text" inputmode="numeric" maxlength="1" aria-label="Digit <?= $i ?>">
        <?php endfor; ?>
      </div>
      <p class="otp-msg <?= $error ? 'otp-err' : '' ?>" id="otpMsg" role="status"><?= otp_e($error) ?></p>
      <button class="otp-submit" type="submit">VERIFIKASI KODE <?= otp_icon('right') ?></button>
    </form>

    <p class="otp-q">Belum menerima kode verifikasi?</p>
    <div class="otp-resend">
      <button type="button" id="otpResend" disabled>Kirim ulang kode</button>
      <span class="otp-timer" id="otpTimer"><?= otp_icon('timer', 12) ?> Kirim ulang dalam <b id="otpCount">00:45</b></span>
    </div>

    <div class="otp-links">
      <a href="<?= otp_e(otp_url('index.php?page=login')) ?>"><?= otp_icon('left', 14) ?> Kembali ke Login</a>
      <a href="#" class="otp-help"><?= otp_icon('help', 15) ?> Bantuan Guru</a>
    </div>
  </section>
</main>

<footer class="otp-foot">
  <div><b>JosLearn</b> <i></i> SMA Negeri 1 Rejoso Nganjuk</div>
  <div>Butuh bantuan cepat? <a href="#">Hubungi Operator Dapodik Sekolah <?= otp_icon('ext', 12) ?></a></div>
</footer>

<script>
(function () {
  var wrap = document.getElementById('otpBoxes');
  var boxes = wrap.querySelectorAll('input');
  var msg = document.getElementById('otpMsg');
  var hidden = document.getElementById('otpValue');
  boxes[0].focus();

  boxes.forEach(function (box, i) {
    box.addEventListener('input', function () {
      box.value = box.value.replace(/\D/g, '').slice(0, 1);
      wrap.classList.remove('otp-bad'); msg.textContent = ''; msg.className = 'otp-msg';
      if (box.value && i < boxes.length - 1) boxes[i + 1].focus();
    });
    box.addEventListener('keydown', function (e) {
      if (e.key === 'Backspace' && !box.value && i > 0) boxes[i - 1].focus();
      if (e.key === 'ArrowLeft' && i > 0) boxes[i - 1].focus();
      if (e.key === 'ArrowRight' && i < boxes.length - 1) boxes[i + 1].focus();
    });
    box.addEventListener('paste', function (e) {
      e.preventDefault();
      var d = ((e.clipboardData || window.clipboardData).getData('text') || '').replace(/\D/g, '').slice(0, 6);
      d.split('').forEach(function (c, k) { boxes[k].value = c; });
      boxes[Math.min(d.length, 5)].focus();
    });
  });

  document.getElementById('otpForm').addEventListener('submit', function (e) {
    var code = Array.prototype.map.call(boxes, function (b) { return b.value; }).join('');
    hidden.value = code;
    if (code.length < 6) {
      e.preventDefault();
      wrap.classList.add('otp-bad');
      msg.className = 'otp-msg otp-err';
      msg.textContent = 'Masukkan 6 digit kode terlebih dahulu.';
    }
  });

  var btn = document.getElementById('otpResend'), pill = document.getElementById('otpTimer'), out = document.getElementById('otpCount');
  function start() {
    var left = 45; btn.disabled = true; pill.style.display = ''; out.textContent = '00:45';
    var t = setInterval(function () {
      left--; out.textContent = '00:' + String(left).padStart(2, '0');
      if (left <= 0) { clearInterval(t); btn.disabled = false; pill.style.display = 'none'; }
    }, 1000);
  }
  btn.addEventListener('click', start);
  start();
})();
</script>
</body>
</html>