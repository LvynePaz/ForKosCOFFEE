<?php
/**
 * View: Halaman Login & Verifikasi OTP (UI-001)
 * Arsitektur: MVC - View Layer (Flat View)
 * Dokumen SDD: Bab 5.2.1 (UI-001)
 * 
 * @var string $title
 * @var string $message
 */
$title   = $title ?? 'Login - ForKos Coffee';
$message = $message ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background-color: #1a1a1a;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px 12px;
        }

        .phone-mockup {
            width: 100%;
            max-width: 380px;
            background-color: #ffffff;
            border-radius: 36px;
            padding: 32px 24px 28px 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45);
            position: relative;
        }

        .badge-ui {
            display: inline-block;
            border: 1px solid #d1d5db;
            color: #6b7280;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 6px;
            margin-bottom: 24px;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-icon-box {
            width: 62px;
            height: 62px;
            background-color: #FA5A00;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px auto;
            box-shadow: 0 8px 18px rgba(250, 90, 0, 0.28);
        }

        .brand-icon-box svg {
            width: 32px;
            height: 32px;
            fill: #ffffff;
        }

        .brand-title {
            font-size: 22px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: 0.5px;
            color: #111827;
        }

        .brand-title span {
            color: #FA5A00;
        }

        .brand-tagline {
            font-size: 12.5px;
            color: #6b7280;
            margin-top: 6px;
            font-weight: 500;
        }

        .input-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .phone-group {
            display: flex;
            align-items: center;
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            padding: 4px 14px;
            background-color: #ffffff;
            height: 48px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .phone-group:focus-within {
            border-color: #FA5A00;
            box-shadow: 0 0 0 3px rgba(250, 90, 0, 0.12);
        }

        .phone-prefix {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            padding-right: 12px;
            border-right: 1.5px solid #e5e7eb;
            user-select: none;
        }

        .phone-input {
            border: none;
            outline: none;
            padding-left: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            width: 100%;
            background: transparent;
        }

        .btn-kirim-otp {
            width: 100%;
            height: 48px;
            background-color: #FA5A00;
            color: #ffffff;
            border: none;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 700;
            margin-top: 12px;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(250, 90, 0, 0.28);
            transition: all 0.2s ease;
        }

        .btn-kirim-otp:hover {
            background-color: #e04e00;
            transform: translateY(-1px);
        }

        .otp-section {
            margin-top: 24px;
            margin-bottom: 24px;
        }

        .otp-container {
            display: flex;
            justify-content: space-between;
            gap: 6px;
        }

        .otp-box {
            width: 46px;
            height: 50px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            text-align: center;
            font-size: 17px;
            font-weight: 700;
            color: #111827;
            outline: none;
            background-color: #ffffff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .otp-box:focus {
            border-color: #FA5A00;
            box-shadow: 0 0 0 3px rgba(250, 90, 0, 0.12);
        }

        .btn-verifikasi {
            width: 100%;
            height: 48px;
            background-color: #111827;
            color: #ffffff;
            border: none;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-verifikasi:hover {
            background-color: #000000;
        }

        .footer-caption {
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            margin-top: 12px;
            font-weight: 500;
        }

        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #dc2626;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 12px;
            margin-bottom: 16px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="phone-mockup">
        <div>
            <span class="badge-ui">UI-001</span>
        </div>

        <div class="brand-header">
            <div class="brand-icon-box">
                <svg viewBox="0 0 24 24">
                    <path d="M2 19h18v2H2v-2zm16-14h-1V3H3v10c0 2.21 1.79 4 4 4h6c2.21 0 4-1.79 4-4v-3h1c1.66 0 3-1.34 3-3s-1.34-3-3-3zm-3 8c0 1.1-.9 2-2 2H7c-1.1 0-2-.9-2-2V5h10v6zm3-3h-1V5h1c.55 0 1 .45 1 1s-.45 1-1 1z"/>
                </svg>
            </div>
            <h1 class="brand-title">FORKOS<br><span>COFFEE</span></h1>
            <p class="brand-tagline">Ngopi sambil sniff parfume!</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert-error">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=login">
            <div>
                <label class="input-label">Nomor telepon</label>
                <div class="phone-group">
                    <span class="phone-prefix">+62</span>
                    <input type="tel" name="phone" class="phone-input" placeholder="812 3456 7890" value="812 3456 7890" required>
                </div>
                <button type="button" class="btn-kirim-otp">Kirim OTP</button>
            </div>

            <div class="otp-section">
                <label class="input-label">Masukkan kode OTP</label>
                <div class="otp-container">
                    <input type="text" name="otp[]" maxlength="1" class="otp-box" value="1" autofocus>
                    <input type="text" name="otp[]" maxlength="1" class="otp-box">
                    <input type="text" name="otp[]" maxlength="1" class="otp-box">
                    <input type="text" name="otp[]" maxlength="1" class="otp-box">
                    <input type="text" name="otp[]" maxlength="1" class="otp-box">
                    <input type="text" name="otp[]" maxlength="1" class="otp-box">
                </div>
            </div>

            <button type="submit" class="btn-verifikasi">Verifikasi</button>
            <p class="footer-caption">Validasi Berhasil setelah verifikasi</p>
            <div class="text-center mt-3">
                <a href="index.php" class="text-muted small text-decoration-none">Kembali ke Home</a>
            </div>
        </form>
    </div>

    <script>
        const otpInputs = document.querySelectorAll('.otp-box');
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

