<?php
require_once __DIR__ . '/config/database.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;

