<?php
/**
 * Controller CheckoutController
 * Arsitektur: MVC - Controller Layer
 */

require_once dirname(__DIR__) . '/models/Product.php';

class CheckoutController {
    private Product $productModel;

    public function __construct(?Product $productModel = null) {
        $this->productModel = $productModel ?? new Product();
    }

    public function index(): void {
        $outlets = [
            'gc' => 'TOMORO Coffee GC',
            'batu_ampar' => 'TOMORO Coffee Batu Ampar'
        ];
        $outletId = $_GET['outlet'] ?? 'gc';
        $outletId = is_string($outletId) && isset($outlets[$outletId]) ? $outletId : 'gc';

        $products = $this->productModel->getCatalog();
        $productId = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
        $product = null;

        foreach ($products as $candidate) {
            if ($productId !== false && $productId !== null && $candidate['id'] === $productId) {
                $product = $candidate;
                break;
            }
        }

        if ($product === null && !isset($_GET['id'])) {
            $product = $products[0] ?? null;
        }

        if ($product === null) {
            http_response_code(404);
            echo 'Menu yang dipilih tidak ditemukan.';
            return;
        }

        $this->renderView('checkout', [
            'item' => $product,
            'outlet' => $outlets[$outletId],
            'outletId' => $outletId
        ]);
    }

    private function renderView(string $viewName, array $data = []): void {
        extract($data);
        $fullPath = dirname(__DIR__) . '/views/' . $viewName . '.php';

        if (!file_exists($fullPath)) {
            die("File view tidak ditemukan: " . htmlspecialchars($fullPath));
        }

        require $fullPath;
    }
}
