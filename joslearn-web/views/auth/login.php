<?php
session_start();

$error_message = '';$success_message = '';

// Memproses data saat form dikirimkan (Method POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil dan membersihkan input data
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';$password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $remember = isset($_POST['remember']) ? true : false;

    if (empty($username) || empty($password)) {$error_message = 'Silakan isi Nama Pengguna dan Kata Sandi!';
    } else {
        if ($username === 'admin' && $password === '123456') {$_SESSION['user_logged_in'] = true;
            $_SESSION['username'] =$username;

            if ($remember) {
                setcookie('user_login', $username, time() + (86400 * 30), "/");
            }

            // ke halaman dashboard
            header('Location: dashboard.php');
            exit();
        } else {
            $error_message = 'Nama pengguna atau kata sandi salah!';
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
    <!-- Import Google Font Inter & Lucide Icons -->
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

        /* --- SISI KIRI --- */
        .sidebar {
            width: 40%;
            background: linear-gradient(180deg, #1e6bf2 0%, #0d47a1 100%);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 0.5px;
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
        }

        .sidebar-content {
            margin-top: auto;
            margin-bottom: auto;
            max-width: 420px;
        }

        .main-logo-box {
            width: 80px;
            height: 80px;
            background: #ffffff;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .sidebar-content h1 {
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .sidebar-content p.subtitle {
            font-size: 18px;
            font-weight: 400;
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

        /* --- SISI KANAN --- */
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
            max-width: 440px;
            margin: auto 0;
        }

        .form-header {
            margin-bottom: 28px;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 6px;
        }

        .form-header p {
            font-size: 15px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .form-header span {
            font-size: 11px;
            color: #9ca3af;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i, .toggle-btn {
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
            justify-content: center;
            padding: 0;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 42px 12px 42px;
            font-size: 14px;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
            border-radius: 10px;
            outline: none;
            transition: all 0.2s ease;
        }

        .input-wrapper input:focus {
            background-color: #ffffff;
            border-color: #1e6bf2;
            box-shadow: 0 0 0 4px rgba(30, 107, 242, 0.1);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            cursor: pointer;
            font-size: 11px;
        }

        .remember-me input {
            accent-color: #1e6bf2;
            cursor: pointer;
        }

        .forgot-pass {
            color: #1e6bf2;
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-pass:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
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
            transition: background-color 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #0a48b0;
        }

        .register-text {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: #6b7280;
        }

        .register-text a {
            color: #1e6bf2;
            text-decoration: none;
            font-weight: 600;
        }

        .register-text a:hover {
            text-decoration: underline;
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
            .sidebar {
                width: 100%;
                padding: 30px 20px;
            }
            .main-container {
                width: 100%;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Sisi Kiri (Gradient & Informasi) -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="logo-icon">
                <i data-lucide="graduation-cap" style="width: 20px; height: 20px;"></i>
            </div>
            <span>JOSLEARN</span>
        </div>

        <div class="sidebar-content">
            <div class="main-logo-box">
                <i data-lucide="graduation-cap" style="width: 44px; height: 44px; color: #1e6bf2;"></i>
            </div>
            <h1>JosLearn</h1>
            <p class="subtitle">Absensi & Nilai Raport Real Time</p>

            <ul class="feature-list">
                <li class="feature-item">
                    <div class="check-icon">
                        <i data-lucide="check" style="width: 14px; height: 14px; color: #ffffff;"></i>
                    </div>
                    <span>Pemantauan kehadiran siswa otomatis & akurat</span>
                </li>
                <li class="feature-item">
                    <div class="check-icon">
                        <i data-lucide="check" style="width: 14px; height: 14px; color: #ffffff;"></i>
                    </div>
                    <span>Pengolahan nilai raport terpadu & transparan</span>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            © <?php echo date('Y'); ?> JosLearn. Hak Cipta Dilindungi.
        </div>
    </div>

    <!-- Sisi Kanan (Form Login) -->
    <div class="main-container">
        <div></div>

        <div class="form-wrapper">
            <div class="form-header">
                <h2>Selamat Datang</h2>
                <p>Masuk ke JosLearn</p>
                <span>Gunakan akun Siswa atau Guru yang terdaftar</span>
            </div>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-error">
                    <i data-lucide="alert-circle" style="width: 18px; height: 18px;"></i>
                    <span><?php echo htmlspecialchars($error_message); ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success">
                    <i data-lucide="check-circle" style="width: 18px; height: 18px;"></i>
                    <span><?php echo htmlspecialchars($success_message); ?></span>
                </div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label for="username">Nama Pengguna</label>
                    <div class="input-wrapper">
                        <i data-lucide="user" class="input-icon-left" style="width: 18px; height: 18px;"></i>
                        <input type="text" id="username" name="username" placeholder="Masukkan Nama Pengguna atau NIS/NIP" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <i data-lucide="lock" class="input-icon-left" style="width: 18px; height: 18px;"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi Anda" required>
                        <button type="button" id="togglePasswordBtn" class="toggle-btn">
                            <i data-lucide="eye" id="togglePasswordIcon" style="width: 18px; height: 18px;"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" <?php echo isset($_POST['remember']) ? 'checked' : ''; ?>> Ingat saya
                    </label>
                    <a href="forgot-password.php" class="forgot-pass">Lupa Kata Sandi?</a>
                </div>

                <button type="submit" class="btn-submit">
                    Masuk
                    <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
                </button>
            </form>

            <p class="register-text">
                Belum punya akun? <a href="register.php">Daftar akun</a>
            </p>
        </div>

        <div class="help-text">
            Memerlukan bantuan akses? Hubungi administrator sekolah
        </div>
    </div>

    <script>
        lucide.createIcons();

        const togglePasswordBtn = document.querySelector('#togglePasswordBtn');
        const passwordInput = document.querySelector('#password');

        if (togglePasswordBtn && passwordInput) {
            togglePasswordBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                const nextType = isPassword ? 'text' : 'password';
                const nextIcon = isPassword ? 'eye-off' : 'eye';

                passwordInput.setAttribute('type', nextType);

                this.innerHTML = `<i data-lucide="${nextIcon}" style="width: 18px; height: 18px;"></i>`;
                lucide.createIcons();
            });
        }
    </script>
</body>
</html>
