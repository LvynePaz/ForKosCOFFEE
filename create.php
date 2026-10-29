<?php
/**
 * Modul Create - Tambah Menu Kopi Baru
 * Proyek: ForKos Coffee (Tugas Modul 2 PPPL)
 * Pengembang: Ciko (Anggota 2)
 * Deskripsi: Form input data menu baru beserta validasi & logika INSERT ke database.
 */

// 1. Muat koneksi database
if (file_exists(__DIR__ . '/config/database.php')) {
    require_once __DIR__ . '/config/database.php';
} elseif (file_exists(__DIR__ . '/config/database.example.php')) {
    require_once __DIR__ . '/config/database.example.php';
}

$errorMessage = '';
$oldInput = [
    'name'     => '',
    'category' => '',
    'price'    => '',
    'stock'    => ''
];

// 2. Tangani pengiriman form (Metode POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil dan bersihkan data input
    $name     = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price    = trim($_POST['price'] ?? '');
    $stock    = trim($_POST['stock'] ?? '');

    // Simpan data lama untuk kenyamanan user jika terjadi kesalahan validasi
    $oldInput = [
        'name'     => $name,
        'category' => $category,
        'price'    => $price,
        'stock'    => $stock
    ];

    // Validasi input
    if (empty($name) || empty($category) || $price === '' || $stock === '') {
        $errorMessage = 'Semua bidang formulir wajib diisi!';
    } elseif (!is_numeric($price) || (int)$price < 0) {
        $errorMessage = 'Harga menu harus berupa angka positif!';
    } elseif (!is_numeric($stock) || (int)$stock < 0) {
        $errorMessage = 'Stok menu harus berupa angka minimal 0!';
    } else {
        // 3. Eksekusi query INSERT dengan Prepared Statement (Aman dari SQL Injection)
        try {
            if (!isset($pdo)) {
                throw new Exception("Koneksi database belum tersedia. Pastikan config/database.php sudah dikonfigurasi.");
            }

            $sql = "INSERT INTO menu (name, category, price, stock) VALUES (:name, :category, :price, :stock)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name'     => $name,
                ':category' => $category,
                ':price'    => (int)$price,
                ':stock'    => (int)$stock
            ]);

            // Redirect ke index.php setelah berhasil menambahkan data
            header('Location: index.php?status=success_add');
            exit;
        } catch (PDOException $e) {
            $errorMessage = 'Gagal menyimpan menu ke database: ' . $e->getMessage();
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu Kopi - ForKos Coffee</title>
    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-dark navbar-coffee shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-cup-hot-fill me-2"></i>ForKos Coffee
            </a>
            <span class="navbar-text text-light small">
                Modul 2 PPPL - Praktik Kolaborasi Git
            </span>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                <div class="card card-coffee">
                    <div class="card-header card-header-coffee py-3">
                        <h5 class="card-title mb-0 fw-semibold">
                            <i class="bi bi-plus-circle-fill me-2"></i>Tambah Menu Kopi Baru
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <!-- Alert Pesan Error jika Validasi Gagal -->
                        <?php if (!empty($errorMessage)): ?>
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                                <div><?= htmlspecialchars($errorMessage); ?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Form Input Menu -->
                        <form action="create.php" method="POST" autocomplete="off">
                            
                            <!-- Nama Menu -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nama Menu / Kopi <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       placeholder="Contoh: Kopi Susu Aren, Americano, Matcha Latte" 
                                       value="<?= htmlspecialchars($oldInput['name']); ?>" 
                                       required>
                            </div>

                            <!-- Kategori -->
                            <div class="mb-3">
                                <label for="category" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="" disabled <?= empty($oldInput['category']) ? 'selected' : ''; ?>>-- Pilih Kategori --</option>
                                    <option value="Signature Coffee" <?= $oldInput['category'] === 'Signature Coffee' ? 'selected' : ''; ?>>Signature Coffee</option>
                                    <option value="Espresso Based" <?= $oldInput['category'] === 'Espresso Based' ? 'selected' : ''; ?>>Espresso Based</option>
                                    <option value="Manual Brew" <?= $oldInput['category'] === 'Manual Brew' ? 'selected' : ''; ?>>Manual Brew</option>
                                    <option value="Non-Coffee" <?= $oldInput['category'] === 'Non-Coffee' ? 'selected' : ''; ?>>Non-Coffee</option>
                                    <option value="Snack & Bakery" <?= $oldInput['category'] === 'Snack & Bakery' ? 'selected' : ''; ?>>Snack & Bakery</option>
                                </select>
                            </div>

                            <div class="row">
                                <!-- Harga (IDR) -->
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label fw-semibold">Harga (IDR) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               class="form-control" 
                                               id="price" 
                                               name="price" 
                                               placeholder="20000" 
                                               min="0" 
                                               step="500"
                                               value="<?= htmlspecialchars($oldInput['price']); ?>" 
                                               required>
                                    </div>
                                </div>

                                <!-- Stok -->
                                <div class="col-md-6 mb-3">
                                    <label for="stock" class="form-label fw-semibold">Stok Awal <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="stock" 
                                           name="stock" 
                                           placeholder="50" 
                                           min="0" 
                                           value="<?= htmlspecialchars($oldInput['stock'] !== '' ? $oldInput['stock'] : '0'); ?>" 
                                           required>
                                </div>
                            </div>

                            <hr class="my-3 text-secondary">

                            <!-- Tombol Aksi -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="index.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-coffee px-4">
                                    <i class="bi bi-save2-fill me-1"></i> Simpan Menu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

