<?php
/**
 * View: Form Tambah Menu Kopi Baru (Modul Create)
 * Arsitektur: MVC - View Layer (Flat View)
 * Dokumen SDD: Bab 5 (UI Presentation Only)
 * 
 * @var string $errorMessage
 * @var array  $oldInput
 */
$errorMessage = $errorMessage ?? '';
$oldInput     = $oldInput ?? ['name' => '', 'category' => '', 'price' => '', 'stock' => '0'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu Kopi - ForKos Coffee</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body.mobile-viewport-body {
            background-color: #2b2b2b;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px 10px;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .mobile-frame-create {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 32px;
            padding: 28px 22px;
            box-shadow: 0 20px 48px rgba(0, 0, 0, 0.45);
        }

        .btn-coffee-submit {
            background-color: var(--tomoro-orange, #fa5a00);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            font-weight: 700;
            padding: 12px 16px;
            width: 100%;
            transition: all 0.2s ease;
        }

        .btn-coffee-submit:hover {
            background-color: var(--tomoro-orange-hover, #e04e00);
            color: #ffffff;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 1.5px solid #e5e7eb;
            padding: 10px 14px;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--tomoro-orange, #fa5a00);
            box-shadow: 0 0 0 0.2rem rgba(250, 90, 0, 0.15);
        }

        .btn-back-link {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1px solid #e3e5e8;
            background: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #1f242d;
            text-decoration: none;
        }
    </style>
</head>
<body class="mobile-viewport-body">

    <div class="mobile-frame-create">
        
        <!-- Header Navigasi -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <a href="index.php?page=katalog" class="btn-back-link" title="Kembali ke Katalog">
                <i class="bi bi-chevron-left"></i>
            </a>
            <h6 class="fw-bold mb-0 text-dark">Tambah Menu Baru</h6>
            <span class="badge-ui">CRUD</span>
        </div>

        <!-- Alert Pesan Error jika Validasi Gagal -->
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center py-2 px-3 small" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div><?= $errorMessage ?></div>
                <button type="button" class="btn-close small" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Formulir Input Menu -->
        <form action="index.php?page=menu-tambah" method="POST" autocomplete="off" class="mt-3">
            
            <!-- Nama Menu -->
            <div class="mb-3">
                <label for="name" class="form-label small fw-bold text-secondary mb-1">
                    Nama Kopi / Produk <span class="text-danger">*</span>
                </label>
                <input type="text" 
                       class="form-control" 
                       id="name" 
                       name="name" 
                       placeholder="Contoh: Caramel Macchiato" 
                       value="<?= htmlspecialchars($oldInput['name'] ?? ''); ?>" 
                       required>
            </div>

            <!-- Kategori -->
            <div class="mb-3">
                <label for="category" class="form-label small fw-bold text-secondary mb-1">
                    Kategori <span class="text-danger">*</span>
                </label>
                <select class="form-select" id="category" name="category" required>
                    <option value="" disabled <?= empty($oldInput['category']) ? 'selected' : ''; ?>>-- Pilih Kategori --</option>
                    <option value="Kopi" <?= ($oldInput['category'] ?? '') === 'Kopi' ? 'selected' : ''; ?>>Kopi</option>
                    <option value="Non-Kopi" <?= ($oldInput['category'] ?? '') === 'Non-Kopi' ? 'selected' : ''; ?>>Non-Kopi</option>
                    <option value="Makanan" <?= ($oldInput['category'] ?? '') === 'Makanan' ? 'selected' : ''; ?>>Makanan</option>
                    <option value="Snack" <?= ($oldInput['category'] ?? '') === 'Snack' ? 'selected' : ''; ?>>Snack</option>
                </select>
            </div>

            <!-- Harga & Stok -->
            <div class="row g-2 mb-4">
                <div class="col-7">
                    <label for="price" class="form-label small fw-bold text-secondary mb-1">
                        Harga (Rp) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted small">Rp</span>
                        <input type="number" 
                               class="form-control" 
                               id="price" 
                               name="price" 
                               placeholder="25000" 
                               min="1000" 
                               step="500"
                               value="<?= htmlspecialchars((string)($oldInput['price'] ?? '')); ?>" 
                               required>
                    </div>
                </div>

                <div class="col-5">
                    <label for="stock" class="form-label small fw-bold text-secondary mb-1">
                        Stok <span class="text-danger">*</span>
                    </label>
                    <input type="number" 
                           class="form-control" 
                           id="stock" 
                           name="stock" 
                           placeholder="50" 
                           min="0" 
                           value="<?= htmlspecialchars((string)($oldInput['stock'] ?? '0')); ?>" 
                           required>
                </div>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn-coffee-submit shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Simpan Menu
            </button>
            
            <div class="text-center mt-3">
                <a href="index.php?page=katalog" class="text-muted text-decoration-none small">
                    Batal dan kembali
                </a>
            </div>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

