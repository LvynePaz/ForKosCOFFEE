<?php
/**
 * Controller OrderController
 * Arsitektur: MVC - Controller Layer
 * Dokumen SDD: Bab 1.4 & Bab 5.2.5 (UI-005 Halaman Detail Pelacakan Status Pesanan & Pick-up Code)
 */

require_once dirname(__DIR__) . '/models/Product.php';

class OrderController {
    private ?Product $productModel;

    public function __construct(?Product $productModel = null) {
        $this->productModel = $productModel;
    }

    /**
     * Menampilkan halaman pelacakan status pesanan aktif (UI-005)
     */
    public function index(): void {
        $this->tracking();
    }

    public function tracking(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $payment = $_POST['pembayaran'] ?? 'qris';
            $outletId = $_POST['outlet'] ?? 'gc';
            $outlets = [
                'gc' => 'ForKos Coffee GC',
                'batu_ampar' => 'ForKos Coffee Batu Ampar'
            ];
            $outletName = $outlets[$outletId] ?? 'ForKos Coffee GC';

            $orderItems = [];
            $subtotal = 0;

            // Prioritaskan mengambil semua item dari keranjang session
            if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $c) {
                    $qty = max(1, (int)($c['quantity'] ?? 1));
                    $hrg = (int)($c['harga'] ?? 0);
                    $subtotal += $hrg * $qty;
                    $orderItems[] = [
                        'id' => $c['id'] ?? 0,
                        'nama' => $c['nama'] ?? 'Item',
                        'quantity' => $qty,
                        'harga' => $hrg,
                        'kustomisasi' => $c['kustomisasi'] ?? 'Reguler • Gula Normal'
                    ];
                }
            } else {
                // Fallback untuk checkout single item langsung dari POST
                $productId = filter_var($_POST['item_id'] ?? null, FILTER_VALIDATE_INT);
                $quantity = filter_var($_POST['quantity'] ?? 1, FILTER_VALIDATE_INT);
                if ($productId) {
                    $productModel = $this->productModel ?? new Product();
                    $products = $productModel->getCatalog();
                    foreach ($products as $candidate) {
                        if ($candidate['id'] === $productId) {
                            $subtotal = (int)$candidate['harga'] * $quantity;
                            $orderItems[] = [
                                'id' => $candidate['id'],
                                'nama' => $candidate['nama'],
                                'quantity' => $quantity,
                                'harga' => (int)$candidate['harga'],
                                'kustomisasi' => 'Reguler, Gula Normal'
                            ];
                            break;
                        }
                    }
                }
            }

            if (empty($orderItems)) {
                $orderItems[] = [
                    'id' => 1,
                    'nama' => 'Cafe Latte',
                    'quantity' => 1,
                    'harga' => 25000,
                    'kustomisasi' => 'Reguler, Gula Normal'
                ];
                $subtotal = 25000;
            }

            $serviceFee = 2000;
            $totalHarga = $subtotal + $serviceFee;

            $_SESSION['active_order'] = [
                'id_pesanan' => 'FKS-' . date('ymd') . '-' . random_int(1000, 9999),
                'outlet' => $outletName,
                'status' => 'Sedang Dibuat',
                'estimasi' => 'Barista sedang meracik pesananmu',
                'pick_up_code' => 'A 127',
                'outlet_id' => $outletId,
                'items' => $orderItems,
                'item_id' => $orderItems[0]['id'],
                'item_nama' => $orderItems[0]['nama'],
                'kuantitas' => $orderItems[0]['quantity'],
                'kustomisasi' => $orderItems[0]['kustomisasi'],
                'subtotal' => $subtotal,
                'biaya_layanan' => $serviceFee,
                'total_harga' => $totalHarga,
                'pembayaran' => $payment
            ];

            // Kosongkan keranjang setelah order dibuat
            $_SESSION['cart'] = [];

            header('Location: index.php?page=pelacakan', true, 303);
            exit;
        }

        $order = $_SESSION['active_order'] ?? [
            'id_pesanan' => 'FKS-240517-0832',
            'outlet' => 'ForKos GC',
            'status' => 'Sedang Dibuat',
            'estimasi' => 'Barista sedang meracik kopimu',
            'pick_up_code' => 'A 127',
            'outlet_id' => 'gc',
            'items' => [
                [
                    'id' => 1,
                    'nama' => 'Caramel Macchiato',
                    'quantity' => 1,
                    'harga' => 28000,
                    'kustomisasi' => 'Reguler • Gula Normal'
                ]
            ],
            'item_id' => 1,
            'item_nama' => 'Caramel Macchiato',
            'kuantitas' => 1,
            'kustomisasi' => 'Reguler, Normal Ice, Less Sugar',
            'subtotal' => 28000,
            'biaya_layanan' => 2000,
            'total_harga' => 30000
        ];

        $this->renderView('pelacakan', ['order' => $order]);
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
