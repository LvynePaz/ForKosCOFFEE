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
        $orderData = [
            'id_pesanan'       => 'TMR-240217-0832',
            'outlet'           => 'ForKos GC',
            'status'           => 'Sedang Dibuat',
            'estimasi'         => 'Barista sedang meracik kopimu',
            'pick_up_code'     => 'A 127',
            'item_nama'        => 'Caramel Macchiato',
            'kuantitas'        => 1,
            'kustomisasi'      => 'Reguler, Normal Ice, Less Sugar',
            'total_harga'      => 28000
        ];

        $this->renderView('pesanan', [
            'order' => $orderData
        ]);
    }

    public function tracking(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $productId = filter_var($_POST['item_id'] ?? null, FILTER_VALIDATE_INT);
            $quantity = filter_var($_POST['quantity'] ?? null, FILTER_VALIDATE_INT);
            $payment = $_POST['pembayaran'] ?? '';
            $outletId = $_POST['outlet'] ?? 'gc';

            if (
                $productId === false || $productId === null ||
                $quantity === false || $quantity === null || $quantity < 1 ||
                !in_array($payment, ['ewallet', 'qris', 'transfer'], true) ||
                !in_array($outletId, ['gc', 'batu_ampar'], true)
            ) {
                http_response_code(400);
                echo 'Data checkout tidak valid. Silakan kembali ke katalog dan pilih menu lagi.';
                return;
            }

            $productModel = $this->productModel ?? new Product();
            $products = $productModel->getCatalog();
            $product = null;
            foreach ($products as $candidate) {
                if ($candidate['id'] === $productId) {
                    $product = $candidate;
                    break;
                }
            }

            if ($product === null) {
                http_response_code(404);
                echo 'Menu yang dipilih tidak ditemukan.';
                return;
            }

            $outlets = [
                'gc' => 'TOMORO Coffee GC',
                'batu_ampar' => 'TOMORO Coffee Batu Ampar'
            ];
            $_SESSION['active_order'] = [
                'id_pesanan' => 'TMR-' . date('ymd') . '-' . random_int(1000, 9999),
                'outlet' => $outlets[$outletId],
                'status' => 'Sedang Dibuat',
                'estimasi' => 'Barista sedang meracik pesananmu',
                'pick_up_code' => 'A 127',
                'outlet_id' => $outletId,
                'item_id' => $product['id'],
                'item_nama' => $product['nama'],
                'kuantitas' => $quantity,
                'kustomisasi' => 'Reguler, Gula Normal',
                'total_harga' => $product['harga'] * $quantity,
                'pembayaran' => $payment
            ];

            header('Location: index.php?page=pelacakan', true, 303);
            exit;
        }

        $order = $_SESSION['active_order'] ?? [
            'id_pesanan' => 'TMR-240217-0832',
            'outlet' => 'TOMORO Coffee GC',
            'status' => 'Sedang Dibuat',
            'estimasi' => 'Barista sedang meracik kopimu',
            'pick_up_code' => 'A 127',
            'outlet_id' => 'gc',
            'item_id' => 1,
            'item_nama' => 'Caramel Macchiato',
            'kuantitas' => 1,
            'kustomisasi' => 'Reguler, Normal Ice, Less Sugar',
            'total_harga' => 28000
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
