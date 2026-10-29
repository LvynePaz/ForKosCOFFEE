<?php
require_once 'config/database.php';

// Memastikan ID tersedia
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_GET['id'];
$errors = [];

// Mengambil data menu berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM menu WHERE id = :id");
$stmt->execute(['id' => $id]);
$menu = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika menu tidak ditemukan
if (!$menu) {
    header('Location: index.php');
    exit;
}

// Memproses form ketika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';

    // Validasi input
    if ($name === '') {
        $errors[] = 'Nama menu wajib diisi.';
    }

    if ($category === '') {
        $errors[] = 'Kategori wajib diisi.';
    }

    if ($price === '' || !ctype_digit((string) $price) || (int) $price < 0) {
        $errors[] = 'Harga harus berupa angka dan tidak boleh negatif.';
    }

    if ($stock === '' || !ctype_digit((string) $stock)) {
        $errors[] = 'Stok harus berupa bilangan bulat dan tidak boleh negatif.';
    }

    // Memperbarui data jika valid
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "UPDATE menu
             SET name = :name,
                 category = :category,
                 price = :price,
                 stock = :stock
             WHERE id = :id"
        );

        $stmt->execute([
            'name' => $name,
            'category' => $category,
            'price' => (int) $price,
            'stock' => (int) $stock,
            'id' => $id
        ]);

        header('Location: index.php?status=updated');
        exit;
    }

    // Menampilkan kembali input jika validasi gagal
    $menu['name'] = $name;
    $menu['category'] = $category;
    $menu['price'] = $price;
    $menu['stock'] = $stock;
}

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - ForKos Coffee</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Edit Menu</h4>
                </div>

                <div class="card-body">

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= e($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="edit.php?id=<?= $id ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nama Menu
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control"
                                value="<?= e($menu['name']) ?>"
                                maxlength="100"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">
                                Kategori
                            </label>
                            <input
                                type="text"
                                name="category"
                                id="category"
                                class="form-control"
                                value="<?= e($menu['category']) ?>"
                                maxlength="50"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">
                                Harga (Rp)
                            </label>
                            <input
                                type="number"
                                name="price"
                                id="price"
                                class="form-control"
                                value="<?= e($menu['price']) ?>"
                                min="0"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">
                                Stok
                            </label>
                            <input
                                type="number"
                                name="stock"
                                id="stock"
                                class="form-control"
                                value="<?= e($menu['stock']) ?>"
                                min="0"
                                required
                            >
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>