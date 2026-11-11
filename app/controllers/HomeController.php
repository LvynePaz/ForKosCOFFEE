<?php
/**
 * Controller HomeController
 * Arsitektur: MVC - Controller Layer
 * Dokumen SDD: Bab 1.4 & Bab 5.2.2 (UI-002 Halaman Utama)
 */

require_once dirname(__DIR__) . '/models/Outlet.php';

class HomeController {
    private Outlet $outletModel;

    public function __construct(?Outlet $outlet = null) {
        $this->outletModel = $outlet ?? new Outlet();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Menampilkan Halaman Utama (Home UI-002)
     */
    public function index(): void {
        $userName = $_SESSION['user_name'] ?? 'Cikocut';
        $outlets  = $this->outletModel->findAll();

        $this->renderView('home', [
            'userName' => $userName,
            'outlets'  => $outlets
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
