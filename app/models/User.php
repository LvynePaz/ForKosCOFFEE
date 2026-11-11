<?php
/**
 * Model User
 * Arsitektur: MVC - Model Layer
 * Dokumen SDD: Bab 4.1 & Bab 4.3 (Tabel pengguna)
 */

require_once dirname(__DIR__) . '/config/Database.php';

class User {
    private PDO $db;

    public function __construct(?PDO $dbConnection = null) {
        $this->db = $dbConnection ?? Database::getConnection();
    }

    /**
     * Memverifikasi login berbasis nomor telepon & OTP (Sesuai SDD UI-001)
     */
    public function verifyPhoneAndOtp(string $phone, string $otp): bool {
        // Pada fase demo / prototype, memvalidasi nomor telepon dan kecukupan panjang OTP
        if (empty($phone) || strlen($otp) < 4) {
            return false;
        }

        // Cek atau inisialisasi sesi pengguna
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['user_phone'] = $phone;
        $_SESSION['user_name']  = 'Cikocut';
        $_SESSION['user_id']    = 1;

        return true;
    }

    /**
     * Mengambil profil pengguna saat ini dari sesi
     */
    public static function getCurrentUser(): ?array {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_phone'])) {
            return null;
        }

        return [
            'id'    => $_SESSION['user_id'] ?? 1,
            'name'  => $_SESSION['user_name'] ?? 'Pelanggan',
            'phone' => $_SESSION['user_phone']
        ];
    }
}

