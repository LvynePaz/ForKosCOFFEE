<?php
/**
 * Single Front Controller (Entry Point Tunggal)
 * Arsitektur: Pure MVC Pattern
 * Dokumen SDD: Bab 2.1 & Bab 2.2
 * 
 * Seluruh permintaan HTTP dari klien diarahkan ke file ini,
 * kemudian diteruskan ke Controller dan Action yang sesuai.
 */

// Muat controller yang dibutuhkan
require_once __DIR__ . '/app/controllers/HomeController.php';
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/controllers/KatalogController.php';
require_once __DIR__ . '/app/controllers/MenuController.php';
require_once __DIR__ . '/app/controllers/OrderController.php';
require_once __DIR__ . '/app/controllers/VoucherController.php';
require_once __DIR__ . '/app/controllers/CheckoutController.php';

// Tangkap parameter rute halaman
$page   = $_GET['page'] ?? 'home';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

switch ($page) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;

    case 'katalog':
        $controller = new KatalogController();
        $controller->index();
        break;

    case 'menu-tambah':
        $controller = new MenuController();
        if ($method === 'POST') {
            $controller->store();
        } else {
            $controller->create();
        }
        break;

    case 'menu-edit':
        $controller = new MenuController();
        if ($method === 'POST') {
            $controller->update();
        } else {
            $controller->edit();
        }
        break;

    case 'menu-hapus':
        $controller = new MenuController();
        $controller->delete();
        break;

    case 'login':
        $controller = new AuthController();
        if ($method === 'POST') {
            $controller->login();
        } else {
            $controller->showLoginForm();
        }
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'pesanan':
        $controller = new OrderController();
        $controller->index();
        break;

    case 'checkout':
        $controller = new CheckoutController();
        $controller->index();
        break;

    case 'pelacakan':
        $controller = new OrderController();
        $controller->tracking();
        break;

    case 'voucher':
        $controller = new VoucherController();
        $controller->index();
        break;

    default:
        // Rute tidak dikenal, arahkan kembali ke home
        header('Location: index.php');
        exit;
}
