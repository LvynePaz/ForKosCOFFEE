<?php
// Memuat koneksi database dari folder config
if (file_exists(__DIR__ . '/config/database.php')) {
    require_once __DIR__ . '/config/database.php';
} elseif (file_exists(__DIR__ . '/config/database.local.php')) {
    require_once __DIR__ . '/config/database.local.php';
}

// Mengambil dan memvalidasi ID dari URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    try {
        // Eksekusi penghapusan data (kompatibel dengan PDO maupun mysqli)
        if (isset($pdo)) {
            $stmt = $pdo->prepare("DELETE FROM menu WHERE id = :id");
            $stmt->execute(['id' => $id]);
        } elseif (isset($conn) && $conn instanceof mysqli) {
            $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
    } catch (Exception $e) {
        error_log("Gagal menghapus data menu: " . $e->getMessage());
    }
}

// Redirect kembali ke halaman utama katalog menu
header("Location: index.php");
exit;