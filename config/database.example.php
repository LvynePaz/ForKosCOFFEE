<?php
/**
 * Konfigurasi Koneksi Database (PDO MySQL)
 * Proyek: ForKos Coffee
 * 
 * Petunjuk untuk Anggota Tim:
 * 1. Salin file ini menjadi `config/database.php`
 * 2. Sesuaikan kredensial MySQL lokal masing-masing jika berbeda (default XAMPP: user 'root', password '')
 */

$host    = 'localhost';
$port    = '3306';
$db      = 'forkos_coffee';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Koneksi database MySQL gagal: " . $e->getMessage());
}
