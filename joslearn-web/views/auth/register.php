<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - JosLearn Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F5F7FF;
            color: #111827;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin: 0;
        }
        .register-wrapper {
            width: 100%;
            max-width: 380px;
            margin: 32px auto;
            padding: 0 16px;
        }
        .brand-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .brand-logo-container {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #FFFFFF;
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid #D9DEE8;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            margin-bottom: 8px;
        }
        .brand-logo-box {
            background: #0B5FCB;
            color: #FFFFFF;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            font-weight: bold;
            font-size: 13px;
        }
        .register-card {
            background: #FFFFFF;
            border: 1px solid #D9DEE8;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(11, 95, 203, 0.04);
            padding: 24px;
        }
        .role-option {
            border: 1px solid #D9DEE8;
            border-radius: 8px;
            padding: 10px 12px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s ease;
            background: #FFFFFF;
        }
        .role-option.active {
            border-color: #0B5FCB;
            background: #EAF3FF;
            color: #0B5FCB;
        }
        .form-label {
            font-size: 11.5px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 4px;
        }
        .form-control {
            font-size: 12px;
            padding: 9px 12px;
            border: 1px solid #D9DEE8;
            border-radius: 6px;
            color: #111827;
            background-color: #FFFFFF;
        }
        .form-control:focus {
            border-color: #0B5FCB;
            box-shadow: 0 0 0 3px rgba(11, 95, 203, 0.12);
        }
        .btn-primary-custom {
            background-color: #0B5FCB;
            border: none;
            color: #FFFFFF;
            font-weight: 600;
            font-size: 13px;
            padding: 10px;
            border-radius: 6px;
            width: 100%;
            transition: background-color 0.2s;
        }
        .btn-primary-custom:hover {
            background-color: #063B86;
        }
        .footer-portal {
            text-align: center;
            padding: 20px 16px;
            font-size: 11.5px;
            color: #64748B;
            border-top: 1px solid #E2E8F0;
            background: #F5F7FF;
        }
        .footer-portal a {
            color: #0B5FCB;
            text-decoration: none;
            font-weight: 500;
        }
        .footer-portal a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-wrapper">
        <!-- HEADER / LOGO -->
        <div class="brand-header">
            <div class="brand-logo-container">
                <div class="brand-logo-box">J</div>
                <span class="fw-bold text-dark" style="font-size: 13.5px;">JosLearn</span>
                <span class="badge bg-light text-primary border" style="font-size: 9px; padding: 2px 5px;">PORTAL</span>
            </div>
            <div class="text-muted" style="font-size: 11px; font-weight: 500; letter-spacing: 0.2px;">SMAN NEGERI 1 REJOSO NGANJUK</div>
        </div>

        <!-- REGISTER CARD -->
        <div class="register-card">
            <div class="text-center mb-3">
                <h1 class="fw-bold text-dark mb-1" style="font-size: 18px;">Daftar Akun</h1>
                <p class="text-muted mb-0" style="font-size: 12px;">Pilih jenis akun yang akan dibuat</p>
            </div>

            <!-- Form Register -->
            <form action="index.php?controller=auth&action=register_process" method="POST" id="registerForm">
                <!-- Pilihan Role (Admin / Guru) -->
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="role-option active" id="roleAdminBtn" onclick="selectRole('admin')">
                            <div class="fw-bold" style="font-size: 11.5px;">ADMIN</div>
                            <div style="font-size: 9.5px; color: #64748B;">Pengelola sistem</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="role-option" id="roleGuruBtn" onclick="selectRole('guru')">
                            <div class="fw-bold" style="font-size: 11.5px;">GURU</div>
                            <div style="font-size: 9.5px; color: #64748B;">Pengelola nilai</div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="role" id="selectedRole" value="admin">

                <!-- Nama Lengkap -->
                <div class="mb-2">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" placeholder="Nama lengkap" required>
                </div>

                <!-- Email Sekolah -->
                <div class="mb-2">
                    <label class="form-label">Email Sekolah</label>
                    <input type="email" class="form-control" name="email" placeholder="Email sekolah" required>
                </div>

                <!-- Nomor Identitas / NIP -->
                <div class="mb-2">
                    <label class="form-label">Nomor Identitas / NIP</label>
                    <input type="text" class="form-control" name="nomor_identitas" placeholder="Nomor identitas / NIP" required>
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Konfirmasi password" required>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary-custom mb-3" id="submitBtn">
                    DAFTAR AKUN →
                </button>

                <!-- Login Link -->
                <div class="text-center" style="font-size: 12px;">
                    <span class="text-muted">Sudah punya akun?</span> 
                    <a href="index.php?controller=auth&action=login" class="text-primary fw-semibold text-decoration-none">Masuk</a>
                </div>
            </form>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer-portal">
        <div class="mb-1">JosLearn • SMA Negeri 1 Rejoso Nganjuk</div>
        <div>Butuh bantuan cepat? <a href="#" target="_blank">Hubungi Operator Dapodik Sekolah</a></div>
    </div>

    <!-- Script Interaksi Pilihan Role -->
    <script>
        function selectRole(role) {
            document.getElementById('selectedRole').value = role;
            const adminBtn = document.getElementById('roleAdminBtn');
            const guruBtn = document.getElementById('roleGuruBtn');
            
            if (role === 'admin') {
                adminBtn.classList.add('active');
                guruBtn.classList.remove('active');
            } else {
                guruBtn.classList.add('active');
                adminBtn.classList.remove('active');
            }
        }

        // Loading state saat submit
        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerText = 'Memproses...';
        });

        lucide.createIcons();
    </script>
</body>
</html>