<?php
/**
 * Controller AuthController
 * Arsitektur: MVC - Controller Layer
 * Dokumen SDD: Bab 1.4 & Bab 3.2 (SEQ-001 Autentikasi Pengguna)
 */

require_once dirname(__DIR__) . '/models/User.php';

class AuthController {
    private User $userModel;

    public function __construct(?User $model = null) {
        $this->userModel = $model ?? new User();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Menampilkan formulir login (UI-001)
     */
    public function showLoginForm(string $message = ""): void {
        if (isset($_SESSION['user_phone'])) {
            header("Location: index.php");
            exit;
        }

        $this->renderView('login', [
            'title'   => 'Login - ForKos Coffee',
            'message' => $message
        ]);
    }

    /**
     * Memproses verifikasi login dan OTP
     */
    public function login(): void {
        $phone = trim($_POST["phone"] ?? "");
        $otpArray = $_POST["otp"] ?? [];
        $otp = is_array($otpArray) ? implode("", $otpArray) : (string)$otpArray;

        if (empty($phone)) {
            $this->showLoginForm("Nomor telepon wajib diisi.");
            return;
        }

        if (strlen($otp) < 4) {
            $this->showLoginForm("Kode OTP minimal 4 digit.");
            return;
        }

        $isVerified = $this->userModel->verifyPhoneAndOtp($phone, $otp);

        if ($isVerified) {
            header("Location: index.php");
            exit;
        } else {
            $this->showLoginForm("Kode verifikasi OTP salah atau kedaluwarsa.");
        }
    }

    /**
     * Keluar dari sesi (Logout)
     */
    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }

    private function renderView(string $viewName, array $data = []): void {
        extract($data);
        $fullPath = dirname(__DIR__) . '/views/' . $viewName . '.php';

        if (!file_exists($fullPath)) {
            die("File view tidak ditemukan: " . htmlspecialchars($fullPath));
        }

        require $fullPath;
    }
}
