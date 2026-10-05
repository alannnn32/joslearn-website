<?php
/**
 * controllers/AuthController.php
 *
 * Jika file Anda sudah punya method login/OTP dari teman, JANGAN dihapus:
 * tempel method showNewPassword(), saveNewPassword(), dan semua method
 * private di bawah ini ke dalam class AuthController yang sudah ada.
 *
 * Asumsi alur asli (DEV_MODE = false):
 *  - verify_otp.php yang sukses mengisi: $_SESSION['reset_teacher_id'],
 *    $_SESSION['otp_verified'] = true, $_SESSION['otp_verified_at'] = time()
 *  - tabel `teachers`: id, name, nip, password, password_changed_at
 *  - config/database.php menyediakan getConnection() yang mengembalikan PDO
 */

require_once __DIR__ . '/../config/constants.php';

// Database hanya dimuat jika bukan mode pengujian
if (!(defined('DEV_MODE') && DEV_MODE)) {
    require_once __DIR__ . '/../config/database.php';
}

class AuthController
{
    private const OTP_VALID_SECONDS = 600; // izin buat sandi berlaku 10 menit
    private const COMMON_PASSWORDS  = [
        '12345678', '123456789', '1234567890', 'password', 'password1', 'password123',
        'qwerty123', 'qwertyuiop', 'abc12345', 'admin123', 'guru12345', 'iloveyou1',
        'sekolah123', 'joslearn123', 'rejoso123', '11111111', '00000000',
    ];

    /* ===================== TAMPIL HALAMAN ===================== */
    public function showNewPassword(): void
    {
        $this->requireOtpVerified();

        // Tampilan sukses (setelah redirect PRG)
        if (!empty($_SESSION['password_success'])) {
            $flash = $_SESSION['password_success'];
            unset($_SESSION['password_success']);
            $this->clearResetSession(); // izin hanya berlaku sekali

            $success   = true;
            $errors    = [];
            $teacher   = ['name' => $flash['name'], 'nip' => $flash['nip']];
            $updatedAt = $flash['time'];
            $csrfToken = '';
            require __DIR__ . '/../views/auth/new_password.php';
            return;
        }

        $success   = false;
        $errors    = [];
        $teacher   = ['name' => '', 'nip' => ''];
        $updatedAt = '';
        $csrfToken = $this->csrfToken();
        require __DIR__ . '/../views/auth/new_password.php';
    }

    /* ===================== SIMPAN KATA SANDI ===================== */
    public function saveNewPassword(): void
    {
        $this->requireOtpVerified();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('new_password');
        }

        $dev    = defined('DEV_MODE') && DEV_MODE;
        $errors = [];

        // 1. CSRF
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            $errors[] = 'Sesi formulir tidak valid. Muat ulang halaman lalu coba lagi.';
        }

        $password = (string)($_POST['password'] ?? '');
        $confirm  = (string)($_POST['password_confirm'] ?? '');

        // 2. Data guru (data contoh jika DEV_MODE)
        if ($dev) {
            $pdo     = null;
            $teacher = ['id' => 0, 'name' => 'Pak Budi Prasetyo, S.Pd', 'nip' => '19820415 200801 1 007'];
        } else {
            $pdo  = getConnection();
            $stmt = $pdo->prepare('SELECT id, name, nip FROM teachers WHERE id = :id LIMIT 1');
            $stmt->execute([':id' => $_SESSION['reset_teacher_id']]);
            $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$teacher) {
                $this->clearResetSession();
                $this->redirect('login');
            }
        }

        // 3. Validasi aturan kata sandi
        $errors = array_merge($errors, $this->validatePassword($password, $confirm, $teacher));

        if ($errors) {
            $success   = false;
            $teacher   = ['name' => '', 'nip' => ''];
            $updatedAt = '';
            $csrfToken = $this->csrfToken();
            require __DIR__ . '/../views/auth/new_password.php';
            return;
        }

        // 4. Simpan ke database (dilewati saat DEV_MODE)
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        if (!$dev) {
            $hash = defined('PASSWORD_ARGON2ID')
                ? password_hash($password, PASSWORD_ARGON2ID)
                : password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

            $update = $pdo->prepare(
                'UPDATE teachers SET password = :pw, password_changed_at = :at WHERE id = :id'
            );
            $update->execute([':pw' => $hash, ':at' => $now, ':id' => $teacher['id']]);
        }

        // 5. Tutup sesi lama demi keamanan
        $flash = [
            'name' => $teacher['name'],
            'nip'  => $teacher['nip'],
            'time' => $this->formatIndoDate($now) . ' WIB',
        ];
        $this->clearResetSession();
        session_regenerate_id(true);
        $_SESSION = [];
        $_SESSION['password_success'] = $flash;
        $_SESSION['otp_verified']     = true;
        $_SESSION['reset_teacher_id'] = $teacher['id'];
        $_SESSION['otp_verified_at']  = time();

        // 6. Post-Redirect-Get
        $this->redirect('new_password');
    }

    /* ===================== HELPER ===================== */
    private function validatePassword(string $pw, string $confirm, array $teacher): array
    {
        $e = [];
        if (strlen($pw) < 8)  $e[] = 'Kata sandi minimal 8 karakter.';
        if (strlen($pw) > 64) $e[] = 'Kata sandi maksimal 64 karakter.';
        if (!preg_match('/[A-Za-z]/', $pw) || !preg_match('/\d/', $pw)) {
            $e[] = 'Gunakan kombinasi huruf dan angka.';
        }
        if (in_array(strtolower($pw), self::COMMON_PASSWORDS, true)) {
            $e[] = 'Kata sandi terlalu mudah ditebak.';
        }
        $nipDigits = preg_replace('/\D/', '', $teacher['nip'] ?? '');
        if ($nipDigits !== '' && strpos($pw, $nipDigits) !== false) {
            $e[] = 'Kata sandi tidak boleh mengandung NIP Anda.';
        }
        if ($pw !== $confirm) $e[] = 'Konfirmasi kata sandi tidak sama.';
        return $e;
    }

    private function requireOtpVerified(): void
    {
        if (defined('DEV_MODE') && DEV_MODE) return; // lewati OTP saat pengujian

        $ok = !empty($_SESSION['otp_verified'])
           && !empty($_SESSION['reset_teacher_id'])
           && (time() - ($_SESSION['otp_verified_at'] ?? 0)) <= self::OTP_VALID_SECONDS;

        if (!$ok) {
            $this->clearResetSession();
            $this->redirect('login');
        }
    }

    private function clearResetSession(): void
    {
        unset($_SESSION['otp_verified'], $_SESSION['reset_teacher_id'],
              $_SESSION['otp_verified_at'], $_SESSION['csrf_token']);
    }

    private function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    private function formatIndoDate(string $datetime): string
    {
        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                  'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $t = strtotime($datetime);
        return date('j', $t) . ' ' . $bulan[(int)date('n', $t)] . ' ' . date('Y, H:i', $t);
    }

    private function redirect(string $page): void
    {
        header('Location: ' . (defined('BASE_URL') ? BASE_URL : '') . '/index.php?page=' . $page);
        exit;
    }
}