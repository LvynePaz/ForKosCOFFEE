<?php
require_once __DIR__ . '/config/database.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->execute([$id]);
$menu = $stmt->fetch();

if (!$menu) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price    = (int)($_POST['price'] ?? 0);
    $stock    = (int)($_POST['stock'] ?? 0);

    if ($name === '' || $category === '' || $price <= 0) {
        $error = 'Name, category, and price are required and must be valid!';
    } else {
        $updateStmt = $pdo->prepare("UPDATE menu SET name = ?, category = ?, price = ?, stock = ? WHERE id = ?");
        $updateStmt->execute([$name, $category, $price, $stock, $id]);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - ForKos Coffee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-coffee shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">☕ ForKos Coffee</a>
        </div>
    </nav>

    <div class="container" style="max-width: 600px;">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Edit Coffee Menu</h5>
            </div>
            <div class="card-body p-4">
                <?php if ($error): ?>
                    <div class="alert alert-danger py-2"><?= htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="edit.php?id=<?= $id; ?>">
                    <div class="mb-3">
                        <label class="form-label">Item Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($menu['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            <?php
                            $categoryList = ['Signature', 'Hot Coffee', 'Iced Coffee', 'Non-Coffee'];
                            foreach ($categoryList as $cat):
                            ?>
                                <option value="<?= $cat; ?>" <?= $menu['category'] === $cat ? 'selected' : ''; ?>>
                                    <?= $cat; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price (IDR)</label>
                            <input type="number" name="price" class="form-control" value="<?= (int)$menu['price']; ?>" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" value="<?= (int)$menu['stock']; ?>" min="0">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="index.php" class="btn btn-outline-secondary">Back</a>
                        <button type="submit" class="btn btn-coffee">Update Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
