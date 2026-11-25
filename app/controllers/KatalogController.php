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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $outletId = $_GET['outlet'] ?? 'gc';
        $outletNames = [
            'gc' => 'ForKos Coffee GC',
            'batu_ampar' => 'ForKos Coffee Batu Ampar'
        ];
        $outletId = is_string($outletId) && isset($outletNames[$outletId]) ? $outletId : 'gc';
        $outletName = $outletNames[$outletId];

        // Handle tambah item ke keranjang
        $action = $_GET['action'] ?? '';
        if ($action === 'add') {
            $productId = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
            if ($productId) {
                $catalog = $this->productModel->getCatalog();
                foreach ($catalog as $item) {
                    if ($item['id'] === $productId) {
                        if (isset($_SESSION['cart'][$productId])) {
                            $_SESSION['cart'][$productId]['quantity'] += 1;
                        } else {
                            $_SESSION['cart'][$productId] = [
                                'id'          => $item['id'],
                                'nama'        => $item['nama'],
                                'harga'       => (int)$item['harga'],
                                'kategori'    => $item['kategori'] ?? 'Kopi',
                                'gambar'      => $item['gambar'] ?? '',
                                'quantity'    => 1,
                                'kustomisasi' => 'Reguler • Gula Normal • Tanpa topping'
                            ];
                        }
                        break;
                    }
                }
            }
            header('Location: index.php?page=katalog&outlet=' . urlencode($outletId) . '&added=1');
            exit;
        }

        $cartCount = 0;
        $cartTotal = 0;
        foreach ($_SESSION['cart'] as $c) {
            $cartCount += (int)$c['quantity'];
            $cartTotal += (int)$c['harga'] * (int)$c['quantity'];
        }

        $produkList = $this->productModel->getCatalog();
        $kategori   = ['Semua', 'Kopi', 'Non-Kopi', 'Makanan', 'Snack'];

        $this->renderView('katalog', [
            'outlet'     => $outletName,
            'outletName' => $outletName,
            'outletId'   => $outletId,
            'produk'     => $produkList,
            'menuList'   => $produkList,
            'kategori'   => $kategori,
            'cartCount'  => $cartCount,
            'cartTotal'  => $cartTotal
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
