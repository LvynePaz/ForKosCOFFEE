<?php
require_once __DIR__ . '/config/database.php';

if (isset($pdo) && $pdo instanceof PDO) {
    $stmt = $pdo->query('SELECT id, name, category, price, stock FROM menu ORDER BY id DESC');
    $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif (isset($koneksi) && $koneksi instanceof mysqli) {
    $result = $koneksi->query('SELECT id, name, category, price, stock FROM menu ORDER BY id DESC');
    $menus = [];

    while ($menu = $result->fetch_assoc()) {
        $menus[] = $menu;
    }
} else {
    throw new RuntimeException('Koneksi database tidak tersedia.');
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu - ForKos Coffee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-coffee shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-cup-hot-fill me-2"></i>ForKos Coffee
        </div>
    </nav>

    <main class="container py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1">Daftar Menu</h1>
                <p class="text-muted mb-0">Kelola menu dan stok ForKos Coffee.</p>
            </div>
            <a href="create.php" class="btn btn-coffee">
                <i class="bi bi-plus-lg me-1"></i>Tambah Menu
            </a>
        </div>

        <div class="card card-coffee">
            <div class="table-responsive">
                <table class="table table-coffee mb-0">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Menu</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Stok</th>
                            <th scope="col" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($menus): ?>
                            <?php foreach ($menus as $index => $menu): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td class="fw-semibold"><?= e($menu['name']) ?></td>
                                    <td><span class="badge-coffee"><?= e($menu['category']) ?></span></td>
                                    <td>Rp <?= number_format((int) $menu['price'], 0, ',', '.') ?></td>
                                    <td><?= e($menu['stock']) ?></td>
                                    <td class="text-end text-nowrap">
                                        <a href="edit.php?id=<?= (int) $menu['id'] ?>" class="btn btn-sm btn-coffee-outline">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </a>
                                        <a
                                            href="delete.php?id=<?= (int) $menu['id'] ?>"
                                            class="btn btn-sm btn-coffee-danger"
                                            onclick="return confirm('Yakin ingin menghapus menu ini?')"
                                        >
                                            <i class="bi bi-trash me-1"></i>Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    Belum ada menu. Silakan tambahkan menu baru.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
