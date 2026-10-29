<?php
require_once __DIR__ . '/config/database.php';

$stmt = $pdo->query("SELECT * FROM menu ORDER BY id DESC");
$menus = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForKos Coffee - Menu Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-coffee shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">☕ ForKos Coffee</a>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">Coffee Menu List</h3>
                <small class="text-muted">Order coffee at outlet without queueing</small>
            </div>
            <a href="create.php" class="btn btn-coffee">+ Add New Menu</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 60px;">#</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center" style="width: 170px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($menus)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No menu items found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($menus as $idx => $item): ?>
                                    <tr>
                                        <td class="text-center text-muted"><?= $idx + 1; ?></td>
                                        <td class="fw-semibold"><?= htmlspecialchars($item['name']); ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($item['category']); ?></span></td>
                                        <td>Rp <?= number_format($item['price'], 0, ',', '.'); ?></td>
                                        <td class="text-center"><?= (int)$item['stock']; ?> cups</td>
                                        <td class="text-center">
                                            <a href="edit.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                            <a href="delete.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
