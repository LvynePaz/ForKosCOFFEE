<?php
/**
 * Controller KatalogController
 * Arsitektur: MVC - Controller Layer
 * Dokumen SDD: Bab 1.4 & Bab 5.2.3 (UI-003 Katalog Menu & Kustomisasi)
 */

require_once dirname(__DIR__) . '/models/Product.php';
require_once dirname(__DIR__) . '/models/Outlet.php';

class KatalogController {
    private Product $productModel;
    private Outlet $outletModel;

    public function __construct(?Product $prod = null, ?Outlet $outlet = null) {
        $this->productModel = $prod ?? new Product();
        $this->outletModel  = $outlet ?? new Outlet();
    }

    /**
     * Menampilkan katalog menu kopi
     */
    public function index(): void {
        $outletId = $_GET['outlet'] ?? 'gc';
        $outletNames = [
            'gc' => 'TOMORO Coffee GC',
            'batu_ampar' => 'TOMORO Coffee Batu Ampar'
        ];
        $outletId = is_string($outletId) && isset($outletNames[$outletId]) ? $outletId : 'gc';
        $outletName = $outletNames[$outletId];
        $produkList = $this->productModel->getCatalog();
        $kategori   = ['Semua', 'Kopi', 'Non-Kopi', 'Makanan', 'Snack'];

        $this->renderView('katalog', [
            'outlet'   => $outletName,
            'outletId' => $outletId,
            'produk'   => $produkList,
            'kategori' => $kategori
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
