<?php
/**
 * Controller MenuController
 * Arsitektur: MVC - Controller Layer
 * Dokumen SDD: Bab 1.4 & Bab 2.2
 * Pengembang Backend: Chiko Dhiva Pramana (10241017)
 */

require_once dirname(__DIR__) . '/models/Menu.php';

class MenuController {
    private Menu $menuModel;

    public function __construct(?Menu $model = null) {
        $this->menuModel = $model ?? new Menu();
    }

    /**
     * Menampilkan formulir tambah menu baru (HTTP GET)
     */
    public function create(): void {
        $errorMessage = '';
        $oldInput = [
            'name'     => '',
            'category' => '',
            'price'    => '',
            'stock'    => '0'
        ];

        $this->renderView('menu_create', [
            'errorMessage' => $errorMessage,
            'oldInput'     => $oldInput
        ]);
    }

    /**
     * Memproses penyimpanan menu baru (HTTP POST)
     */
    public function store(): void {
        $input = [
            'name'     => trim($_POST['name'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'price'    => trim($_POST['price'] ?? ''),
            'stock'    => trim($_POST['stock'] ?? '')
        ];

        $errors = $this->menuModel->validate($input);

        if (!empty($errors)) {
            $this->renderView('menu_create', [
                'errorMessage' => implode('<br>', $errors),
                'oldInput'     => $input
            ]);
            return;
        }

        try {
            $this->menuModel->create($input);
            header('Location: index.php?page=katalog&status=success_add');
            exit;
        } catch (Exception $e) {
            $this->renderView('menu_create', [
                'errorMessage' => 'Gagal menyimpan menu: ' . htmlspecialchars($e->getMessage()),
                'oldInput'     => $input
            ]);
        }
    }

    /**
     * Menampilkan formulir edit menu (HTTP GET)
     */
    public function edit(): void {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: index.php?page=katalog');
            exit;
        }

        $menu = $this->menuModel->findById($id);

        if (!$menu) {
            header('Location: index.php?page=katalog');
            exit;
        }

        $this->renderView('menu_edit', [
            'menu'   => $menu,
            'errors' => []
        ]);
    }

    /**
     * Memproses pembaruan menu (HTTP POST)
     */
    public function update(): void {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: index.php?page=katalog');
            exit;
        }

        $menu = $this->menuModel->findById($id);
        if (!$menu) {
            header('Location: index.php?page=katalog');
            exit;
        }

        $input = [
            'name'     => trim($_POST['name'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'price'    => trim($_POST['price'] ?? ''),
            'stock'    => trim($_POST['stock'] ?? '')
        ];

        $errors = $this->menuModel->validate($input);

        if (!empty($errors)) {
            $menu['name']     = $input['name'];
            $menu['category'] = $input['category'];
            $menu['price']    = $input['price'];
            $menu['stock']    = $input['stock'];

            $this->renderView('menu_edit', [
                'menu'   => $menu,
                'errors' => $errors
            ]);
            return;
        }

        try {
            $this->menuModel->update($id, $input);
            header('Location: index.php?page=katalog&status=updated');
            exit;
        } catch (Exception $e) {
            $this->renderView('menu_edit', [
                'menu'   => $menu,
                'errors' => ['Gagal memperbarui menu: ' . $e->getMessage()]
            ]);
        }
    }

    /**
     * Memproses penghapusan menu (HTTP GET / POST)
     */
    public function delete(): void {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            try {
                $this->menuModel->delete($id);
            } catch (Exception $e) {
                error_log("Gagal menghapus menu: " . $e->getMessage());
            }
        }

        header('Location: index.php?page=katalog&status=deleted');
        exit;
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
