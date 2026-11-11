<?php
$title = "Login - ForKos Coffee";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $phone = trim($_POST["phone"] ?? "");
    $otpArray = $_POST["otp"] ?? [];
    $otp = implode("", $otpArray);

    if (empty($phone)) {
        $message = "Nomor telepon wajib diisi.";
    } elseif (strlen($otp) < 6) {
        $message = "Kode OTP harus 6 digit lengkap.";
    } else {
        // Simpan sesi autentikasi pengguna
        $_SESSION['user_phone'] = $phone;
        $_SESSION['user_name']  = "Cikocut";
        $_SESSION['user_id']    = 1;
        header("Location: index.php?page=home");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <!-- Bootstrap 5 CDN & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Penataan Khusus Kartu Login Responsif */
        .login-wrapper {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border: 1.5px solid #ececec;
            border-radius: 24px;
            padding: 32px 28px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        }

        .brand-logo-box-login {
            width: 60px;
            height: 60px;
            background-color: var(--tomoro-orange, #fa5a00);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px auto;
            box-shadow: 0 6px 16px rgba(250, 90, 0, 0.28);
        }

        .brand-logo-box-login svg {
            width: 30px;
            height: 30px;
            fill: #ffffff;
        }

        .brand-title-login {
            font-size: 1.35rem;
            font-weight: 800;
            line-height: 1.15;
            color: #111827;
            margin-bottom: 4px;
        }

        .brand-title-login span {
            color: var(--tomoro-orange, #fa5a00);
        }

        .brand-tagline-login {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        .input-group-phone-custom {
            display: flex;
            align-items: center;
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            padding: 4px 14px;
            background-color: #ffffff;
            height: 48px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-group-phone-custom:focus-within {
            border-color: var(--tomoro-orange, #fa5a00);
            box-shadow: 0 0 0 3px rgba(250, 90, 0, 0.12);
        }

        .prefix-phone {
            font-size: 0.9rem;
            font-weight: 700;
            color: #111827;
            padding-right: 12px;
            border-right: 1.5px solid #e5e7eb;
            user-select: none;
        }

        .input-phone-field {
            border: none;
            outline: none;
            padding-left: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
            width: 100%;
            background: transparent;
        }

        .btn-otp-action {
            width: 100%;
            height: 46px;
            background-color: var(--tomoro-orange, #fa5a00);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            font-size: 0.88rem;
            font-weight: 700;
            margin-top: 10px;
            box-shadow: 0 4px 14px rgba(250, 90, 0, 0.25);
            transition: all 0.2s ease;
        }

        .btn-otp-action:hover {
            background-color: var(--tomoro-orange-hover, #e04e00);
            transform: translateY(-1px);
        }

        .otp-inputs-wrapper {
            display: flex;
            justify-content: space-between;
            gap: 6px;
        }

        .otp-digit-box {
            width: 48px;
            height: 50px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            text-align: center;
            font-size: 1.15rem;
            font-weight: 700;
            color: #111827;
            outline: none;
            background-color: #ffffff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .otp-digit-box:focus {
            border-color: var(--tomoro-orange, #fa5a00);
            box-shadow: 0 0 0 3px rgba(250, 90, 0, 0.12);
        }

        .btn-verify-action {
            width: 100%;
            height: 46px;
            background-color: #111827;
            color: #ffffff;
            border: none;
            border-radius: 14px;
            font-size: 0.9rem;
            font-weight: 700;
            transition: background-color 0.2s ease;
        }

        .btn-verify-action:hover {
            background-color: #000000;
        }

        /* Penyesuaian Kotak OTP untuk Layar Ponsel Sempit */
        @media (max-width: 380px) {
            .otp-digit-box {
                width: 42px;
                height: 46px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body class="app-body">

    <!-- Top Navbar Serasi dengan Halaman Home -->
    <nav class="navbar navbar-light bg-white border-bottom sticky-top py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center gap-2 m-0" href="index.php?page=home">
                <div class="brand-mini-icon">
                    <i class="bi bi-cup-hot-fill text-white"></i>
                </div>
                <span class="fw-bold fs-6 brand-text">FORKOS <span class="text-orange">COFFEE</span></span>
            </a>
            
            <a href="index.php?page=home" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </nav>

    <!-- Area Kartu Login Responsif -->
    <div class="login-wrapper">
        <div class="login-card">
            
            <!-- Badge Identifikasi Mockup SDD UI-001 -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge-ui">UI-001</span>
            </div>

            <!-- Logo & Identitas Brand -->
            <div class="text-center mb-4">
                <div class="brand-logo-box-login">
                    <svg viewBox="0 0 24 24">
                        <path d="M2 19h18v2H2v-2zm16-14h-1V3H3v10c0 2.21 1.79 4 4 4h6c2.21 0 4-1.79 4-4v-3h1c1.66 0 3-1.34 3-3s-1.34-3-3-3zm-3 8c0 1.1-.9 2-2 2H7c-1.1 0-2-.9-2-2V5h10v6zm3-3h-1V5h1c.55 0 1 .45 1 1s-.45 1-1 1z"/>
                    </svg>
                </div>
                <h1 class="brand-title-login">FORKOS<br><span>COFFEE</span></h1>
                <p class="brand-tagline-login">Ngopi sambil sniff parfume!</p>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert alert-danger py-2 small text-center mb-3">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <!-- Form Autentikasi No. HP & Kode OTP -->
            <form method="POST" action="index.php?page=login">
                <!-- Input Nomor Telepon -->
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.82rem;">Nomor telepon</label>
                    <div class="input-group-phone-custom">
                        <span class="prefix-phone">+62</span>
                        <input type="tel" name="phone" class="input-phone-field" placeholder="812 3456 7890" value="812 3456 7890" required>
                    </div>
                    <button type="button" class="btn-otp-action">Kirim OTP</button>
                </div>

                <!-- Input 6 Digit Kotak OTP -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark mb-2" style="font-size: 0.82rem;">Masukkan kode OTP</label>
                    <div class="otp-inputs-wrapper">
                        <input type="text" name="otp[]" maxlength="1" class="otp-digit-box" value="1" autofocus>
                        <input type="text" name="otp[]" maxlength="1" class="otp-digit-box" value="2">
                        <input type="text" name="otp[]" maxlength="1" class="otp-digit-box" value="3">
                        <input type="text" name="otp[]" maxlength="1" class="otp-digit-box" value="4">
                        <input type="text" name="otp[]" maxlength="1" class="otp-digit-box" value="5">
                        <input type="text" name="otp[]" maxlength="1" class="otp-digit-box" value="6">
                    </div>
                </div>

                <!-- Tombol Submit Verifikasi -->
                <button type="submit" class="btn-verify-action mb-2">Verifikasi</button>
                <p class="text-center text-muted small mb-0" style="font-size: 0.72rem;">Validasi Berhasil setelah verifikasi</p>
            </form>

        </div>
    </div>

    <!-- Script Otomatis Pindah Kotak Input OTP -->
    <script>
        const otpInputs = document.querySelectorAll('.otp-digit-box');
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });
    </script>
</body>
</html>