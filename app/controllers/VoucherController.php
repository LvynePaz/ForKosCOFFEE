<?php
/**
 * Controller VoucherController
 * Arsitektur: MVC - Controller Layer
 * Dokumen SDD: Bab 1.4 & Bab 4.1 (Voucher & DiskonStrategy)
 */

require_once dirname(__DIR__) . '/models/Voucher.php';

class VoucherController {
    private Voucher $voucherModel;

    public function __construct(?Voucher $voucherModel = null) {
        $this->voucherModel = $voucherModel ?? new Voucher();
    }

    /**
     * Menampilkan daftar voucher dan promo aktif
     */
    public function index(): void {
        $outletId = $_GET['outlet'] ?? 'gc';
        $outletId = in_array($outletId, ['gc', 'batu_ampar'], true) ? $outletId : 'gc';

        $this->renderView('voucher', [
            'vouchers' => $this->voucherModel->getActive(),
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
