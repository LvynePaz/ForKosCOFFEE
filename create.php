<?php
require_once __DIR__ . '/config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price    = (int)($_POST['price'] ?? 0);
    $stock    = (int)($_POST['stock'] ?? 0);

    if ($name === '' || $category === '' || $price <= 0) {
        $error = 'Name, category, and price are required and must be valid!';
    } else {
        $stmt = $pdo->prepare("INSERT INTO menu (name, category, price, stock) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $category, $price, $stock]);
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
    <title>Add Menu - ForKos Coffee</title>
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
                <h5 class="mb-0">Add New Coffee Menu</h5>
            </div>
            <div class="card-body p-4">
                <?php if ($error): ?>
                    <div class="alert alert-danger py-2"><?= htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="create.php">
                    <div class="mb-3">
                        <label class="form-label">Item Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Palm Sugar Milk Coffee" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            <option value="Signature">Signature</option>
                            <option value="Hot Coffee">Hot Coffee</option>
                            <option value="Iced Coffee">Iced Coffee</option>
                            <option value="Non-Coffee">Non-Coffee</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price (IDR)</label>
                            <input type="number" name="price" class="form-control" placeholder="18000" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" placeholder="50" min="0" value="0">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="index.php" class="btn btn-outline-secondary">Back</a>
                        <button type="submit" class="btn btn-coffee">Save Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
