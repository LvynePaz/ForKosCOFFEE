<?php
/**
 * Controller CheckoutController
 * Arsitektur: MVC - Controller Layer
 */

require_once dirname(__DIR__) . '/models/Product.php';
require_once dirname(__DIR__) . '/models/Voucher.php';

class CheckoutController {
    private Product $productModel;
    private Voucher $voucherModel;

    public function __construct(?Product $productModel = null, ?Voucher $voucherModel = null) {
        $this->productModel = $productModel ?? new Product();
        $this->voucherModel = $voucherModel ?? new Voucher();
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

        // Validasi voucher yang dipilih, lalu simpan ke session agar tetap terbawa ke checkout.
        if (isset($_GET['voucher'])) {
            $requestedCode = is_string($_GET['voucher']) ? trim($_GET['voucher']) : '';
            $voucher = $this->voucherModel->findActive($requestedCode);

            if ($voucher === null) {
                $_SESSION['checkout_voucher_message'] = 'Kode voucher tidak valid.';
                $_SESSION['checkout_voucher_message_type'] = 'danger';
            } elseif (!$this->voucherModel->isEligible($voucher, $subtotal)) {
                $_SESSION['checkout_voucher_message'] = $subtotal === 0
                    ? 'Tambahkan menu ke keranjang sebelum memakai voucher.'
                    : 'Voucher ini belum memenuhi minimum belanja Rp' . number_format((int)$voucher['minimum'], 0, ',', '.') . '.';
                $_SESSION['checkout_voucher_message_type'] = 'danger';
            } else {
                $_SESSION['checkout_voucher'] = $voucher['kode'];
                $_SESSION['checkout_voucher_message'] = 'Voucher berhasil digunakan.';
                $_SESSION['checkout_voucher_message_type'] = 'success';
            }

            header('Location: index.php?page=checkout&outlet=' . urlencode($outletId));
            exit;
        }

        if (isset($_GET['remove_voucher'])) {
            unset($_SESSION['checkout_voucher']);
            $_SESSION['checkout_voucher_message'] = 'Voucher dihapus.';
            $_SESSION['checkout_voucher_message_type'] = 'success';
            header('Location: index.php?page=checkout&outlet=' . urlencode($outletId));
            exit;
        }

        $selectedVoucher = null;
        $selectedVoucherCode = $_SESSION['checkout_voucher'] ?? '';
        if (is_string($selectedVoucherCode) && $selectedVoucherCode !== '') {
            $selectedVoucher = $this->voucherModel->findActive($selectedVoucherCode);
            if ($selectedVoucher === null) {
                unset($_SESSION['checkout_voucher']);
            }
        }

        $serviceFee = !empty($cart) ? 2000 : 0;
        // Hitung diskon dari subtotal keranjang tanpa mengurangi biaya layanan.
        $discount = $selectedVoucher !== null
            ? $this->voucherModel->calculateDiscount($selectedVoucher, $subtotal)
            : 0;
        $total = max(0, $subtotal + $serviceFee - $discount);

        $voucherMessage = $_SESSION['checkout_voucher_message'] ?? null;
        $voucherMessageType = $_SESSION['checkout_voucher_message_type'] ?? 'success';
        unset($_SESSION['checkout_voucher_message'], $_SESSION['checkout_voucher_message_type']);

        if ($selectedVoucher !== null && !$this->voucherModel->isEligible($selectedVoucher, $subtotal)) {
            $voucherMessage = 'Voucher belum memenuhi minimum belanja Rp' . number_format((int)$selectedVoucher['minimum'], 0, ',', '.') . '.';
            $voucherMessageType = 'warning';
        }

        $firstItem = !empty($cart) ? reset($cart) : ['nama' => 'Menu Kopi', 'harga' => 25000];

        $this->renderView('checkout', [
            'item'       => $firstItem,
            'cart'       => $cart,
            'subtotal'   => $subtotal,
            'serviceFee' => $serviceFee,
            'selectedVoucher' => $selectedVoucher,
            'discount'   => $discount,
            'total'      => $total,
            'voucherMessage' => $voucherMessage,
            'voucherMessageType' => $voucherMessageType,
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
