<?php
// Mencegah Notice session ganda
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';$db   = 'db_sekolah_login';
$user = 'root';$pass = '';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_user = trim($_POST['username']);
    $input_pass = trim($_POST['password']);

    if (empty($input_user) || empty($input_pass)) {$error_message = 'Silakan isi Nama Pengguna dan Kata Sandi!';
    } else {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user,$pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            // Mencari user berdasarkan username, NIP, atau email sekolah agar lebih fleksibel
            $stmt =$pdo->prepare("SELECT * FROM users WHERE username = ? OR nip = ? OR email_sekolah = ? LIMIT 1");
            $stmt->execute([$input_user, $input_user,$input_user]);
            $user_data =$stmt->fetch();

            $db_pass = '';
            if ($user_data) {$db_pass = $user_data['password'] ?? $user_data['password_hash'] ?? '';
            }

            $is_password_valid = false;
            if ($user_data && !empty($db_pass)) {
                // Mendukung password teks biasa maupun password ter-hash dari register.php
                if ($input_pass === $db_pass || password_verify($input_pass, $db_pass)) {$is_password_valid = true;
                }
            }

            // Normalisasi role menjadi standar: 'admin' atau 'guru'
            $role = strtolower($user_data['role'] ?? '');
            if ($role === 'teacher') {$role = 'guru';
            }

            // Validasi hanya role 'admin' atau 'guru' yang boleh masuk
            if ($is_password_valid) {
                if (in_array($role, ['admin', 'guru'])) {$_SESSION['user_logged_in'] = true;
                    $_SESSION['user_id']        =$user_data['id'];
                    $_SESSION['username']       =$user_data['username'];
                    $_SESSION['nama_lengkap']   =$user_data['nama_lengkap'];
                    $_SESSION['role']           =$role;

                    header('Location: ../../index.php');
                    exit();
                } else {
                    $error_message = 'Akses ditolak: Akun Anda tidak memiliki otoritas Admin atau Guru!';
                }
            } else {
                $error_message = 'Nama pengguna atau kata sandi salah!';
            }
        } catch (Exception $e) {
            $error_message = 'Terjadi kesalahan sistem: ' .$e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOSLEARN - Masuk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #ffffff;
            color: #333333;
        }

        .sidebar {
            width: 40%;
            background: linear-gradient(180deg, #1e6bf2 0%, #0d47a1 100%);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 18px;
        }

        .sidebar-brand .logo-icon {
            width: 36px;
            height: 36px;
            background: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e6bf2;
            font-weight: bold;
        }

        .sidebar-content {
            margin: auto 0;
            max-width: 420px;
        }

        .main-logo-box {
            width: 72px;
            height: 72px;
            background: #ffffff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            color: #1e6bf2;
            font-weight: bold;
            font-size: 32px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .sidebar-content h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .sidebar-content p.subtitle {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 32px;
        }

        .feature-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            opacity: 0.95;
        }

        .check-icon {
            width: 22px;
            height: 22px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-footer {
            font-size: 12px;
            opacity: 0.6;
        }

        .main-container {
            width: 60%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 40px;
        }

        .form-wrapper {
            width: 100%;
            max-width: 420px;
            margin: auto 0;
        }

        .form-header {
            margin-bottom: 24px;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
        }

        .form-header p {
            font-size: 14px;
            color: #4b5563;
        }

        .form-sub-hint {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 2px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i,
        .toggle-btn {
            position: absolute;
            color: #9ca3af;
        }

        .input-icon-left {
            left: 14px;
        }

        .toggle-btn {
            right: 14px;
            cursor: pointer;
            background: none;
            border: none;
            display: flex;
            align-items: center;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            font-size: 14px;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
            border-radius: 10px;
            outline: none;
        }

        .input-wrapper input:focus {
            background-color: #ffffff;
            border-color: #1e6bf2;
            box-shadow: 0 0 0 4px rgba(30, 107, 242, 0.1);
        }

        .form-row-extra {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #4b5563;
            cursor: pointer;
        }

        .remember-me input {
            width: 16px;
            height: 16px;
            accent-color: #0c56d0;
            cursor: pointer;
        }

        .forgot-pass {
            color: #0c56d0;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background-color: #0c56d0;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background-color: #0a48b0;
        }

        .signup-link {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-top: 20px;
        }

        .signup-link a {
            color: #0c56d0;
            text-decoration: none;
            font-weight: 600;
        }

        .help-text {
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
        }

        @media (max-width: 900px) {
            body {
                flex-direction: column;
            }

            .sidebar,
            .main-container {
                width: 100%;
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="logo-icon">J</div>
            <span>JOSLEARN</span>
        </div>
        <div class="sidebar-content">
            <div class="main-logo-box">J</div>
            <h1>JosLearn</h1>
            <p class="subtitle">Absensi & Nilai Raport Real Time</p>
            <ul class="feature-list">
                <li class="feature-item">
                    <div class="check-icon"><i data-lucide="check"
                            style="width: 14px; height: 14px; color: #ffffff;"></i></div><span>Pemantauan kehadiran
                        siswa otomatis & akurat</span>
                </li>
                <li class="feature-item">
                    <div class="check-icon"><i data-lucide="check"
                            style="width: 14px; height: 14px; color: #ffffff;"></i></div><span>Pengolahan nilai raport
                        terpadu & transparan</span>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer">© <?php echo date('Y'); ?> JosLearn. Hak Cipta Dilindungi.</div>
    </div>

    <div class="main-container">
        <div></div>
        <div class="form-wrapper">
            <div class="form-header">
                <h2>Selamat Datang</h2>
                <p>Masuk ke JosLearn</p>
                <div class="form-sub-hint">Gunakan akun Admin atau Guru yang terdaftar</div>
            </div>

            <?php if (!empty($error_message)): ?>
                <div class="alert"><i data-lucide="alert-circle"
                        style="width: 18px; height: 18px;"></i><span><?php echo htmlspecialchars($error_message); ?></span>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Nama Pengguna</label>
                    <div class="input-wrapper">
                        <i data-lucide="user" class="input-icon-left" style="width: 18px; height: 18px;"></i>
                        <input type="text" id="username" name="username"
                            placeholder="Masukkan NIP atau Email"
                            value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <i data-lucide="lock" class="input-icon-left" style="width: 18px; height: 18px;"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi Anda"
                            required>
                        <button type="button" id="togglePasswordBtn" class="toggle-btn"><i data-lucide="eye"
                                id="togglePasswordIcon" style="width: 18px; height: 18px;"></i></button>
                    </div>
                </div>

                <div class="form-row-extra">
                    <label class="remember-me">
                        <input type="checkbox" name="remember"> Ingat saya
                    </label>
                    <a href="reset_password.php" class="forgot-pass">Lupa Kata Sandi?</a>
                </div>

                <button type="submit" class="btn-submit">Masuk <i data-lucide="arrow-right"
                        style="width: 18px; height: 18px;"></i></button>
            </form>

            <div class="signup-link">
                Belum punya akun? <a href="register.php">Daftar akun</a>
            </div>
        </div>

        <div class="help-text">Memerlukan bantuan akses? Hubungi administrator sekolah</div>
    </div>

    <script>
        lucide.createIcons();
        const toggleBtn = document.querySelector('#togglePasswordBtn');
        const passwordInput = document.querySelector('#password');
        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', function () {
                const isPass = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPass ? 'text' : 'password');
                this.innerHTML = `<i data-lucide="${isPass ? 'eye-off' : 'eye'}" style="width: 18px; height: 18px;"></i>`;
                lucide.createIcons();
            });
        }
    </script>
</body>

</html>