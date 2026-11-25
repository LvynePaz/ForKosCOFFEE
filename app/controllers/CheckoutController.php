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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $outlets = [
            'gc' => 'ForKos Coffee GC',
            'batu_ampar' => 'ForKos Coffee Batu Ampar'
        ];
        $outletId = $_GET['outlet'] ?? 'gc';
        $outletId = is_string($outletId) && isset($outlets[$outletId]) ? $outletId : 'gc';

        // Jika user klik menu tertentu langsung lewat query ?id=X dan keranjang kosong
        $singleId = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
        if ($singleId && empty($_SESSION['cart'])) {
            $catalog = $this->productModel->getCatalog();
            foreach ($catalog as $item) {
                if ($item['id'] === $singleId) {
                    $_SESSION['cart'][$singleId] = [
                        'id'          => $item['id'],
                        'nama'        => $item['nama'],
                        'harga'       => (int)$item['harga'],
                        'kategori'    => $item['kategori'] ?? 'Kopi',
                        'gambar'      => $item['gambar'] ?? '',
                        'quantity'    => 1,
                        'kustomisasi' => 'Reguler • Gula Normal • Tanpa topping'
                    ];
                    break;
                }
            }
        }

        // Handle kuantitas tambah / kurang lewat action
        $action = $_GET['action'] ?? '';
        $targetId = filter_var($_GET['item_id'] ?? null, FILTER_VALIDATE_INT);
        if ($targetId && isset($_SESSION['cart'][$targetId])) {
            if ($action === 'inc') {
                $_SESSION['cart'][$targetId]['quantity'] += 1;
            } elseif ($action === 'dec') {
                $_SESSION['cart'][$targetId]['quantity'] -= 1;
                if ($_SESSION['cart'][$targetId]['quantity'] <= 0) {
                    unset($_SESSION['cart'][$targetId]);
                }
            }
            header('Location: index.php?page=checkout&outlet=' . urlencode($outletId));
            exit;
        }

        $cart = $_SESSION['cart'];
        $subtotal = 0;
        foreach ($cart as $c) {
            $subtotal += (int)$c['harga'] * (int)$c['quantity'];
        }

        $serviceFee = !empty($cart) ? 2000 : 0;
        $discount = 0;
        $total = max(0, $subtotal + $serviceFee - $discount);

        $firstItem = !empty($cart) ? reset($cart) : ['nama' => 'Menu Kopi', 'harga' => 25000];

        $this->renderView('checkout', [
            'item'       => $firstItem,
            'cart'       => $cart,
            'subtotal'   => $subtotal,
            'serviceFee' => $serviceFee,
            'discount'   => $discount,
            'total'      => $total,
            'outlet'     => $outlets[$outletId],
            'outletId'   => $outletId
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
