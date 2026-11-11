<?php
/**
 * View: Form Edit Menu Kopi (Modul Update)
 * Arsitektur: MVC - View Layer (Flat View)
 * Dokumen SDD: Bab 5
 * 
 * @var array $menu
 * @var array $errors
 */
$menu   = $menu ?? ['id' => 0, 'name' => '', 'category' => '', 'price' => 0, 'stock' => 0];
$errors = $errors ?? [];

if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - ForKos Coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .mobile-frame-edit {
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

<div class="mobile-frame-edit">
    
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <a href="index.php?page=katalog" class="btn-back-link" title="Kembali ke Katalog">
            <i class="bi bi-chevron-left"></i>
        </a>
        <h6 class="fw-bold mb-0 text-dark">Edit Menu Kopi</h6>
        <span class="badge-ui">CRUD</span>
    </div>

    <!-- Alert Error Validasi -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show py-2 px-3 small" role="alert">
            <ul class="mb-0 ps-3">
                <?php foreach ($errors as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close small" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form Edit Menu -->
    <form method="POST" action="index.php?page=menu-edit&id=<?= (int)$menu['id'] ?>" class="mt-3">
        
        <div class="mb-3">
            <label for="name" class="form-label small fw-bold text-secondary mb-1">
                Nama Menu Kopi <span class="text-danger">*</span>
            </label>
            <input type="text"
                   name="name"
                   id="name"
                   class="form-control"
                   value="<?= e($menu['name']) ?>"
                   maxlength="100"
                   required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label small fw-bold text-secondary mb-1">
                Kategori <span class="text-danger">*</span>
            </label>
            <input type="text"
                   name="category"
                   id="category"
                   class="form-control"
                   value="<?= e($menu['category']) ?>"
                   maxlength="50"
                   required>
        </div>

        <div class="row g-2 mb-4">
            <div class="col-7">
                <label for="price" class="form-label small fw-bold text-secondary mb-1">
                    Harga (Rp) <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted small">Rp</span>
                    <input type="number"
                           name="price"
                           id="price"
                           class="form-control"
                           value="<?= e($menu['price']) ?>"
                           min="0"
                           step="500"
                           required>
                </div>
            </div>

            <div class="col-5">
                <label for="stock" class="form-label small fw-bold text-secondary mb-1">
                    Stok <span class="text-danger">*</span>
                </label>
                <input type="number"
                       name="stock"
                       id="stock"
                       class="form-control"
                       value="<?= e($menu['stock']) ?>"
                       min="0"
                       required>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-coffee-submit shadow-sm flex-grow-1">
                <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
            </button>
            <a href="index.php?page=menu-hapus&id=<?= (int)$menu['id'] ?>" 
               class="btn btn-outline-danger px-3 rounded-4 d-flex align-items-center"
               onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')"
               title="Hapus Menu">
                <i class="bi bi-trash"></i>
            </a>
        </div>

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

