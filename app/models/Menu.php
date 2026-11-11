<?php
/**
 * Model Menu
 * Arsitektur: MVC - Model Layer (Data Access & Business Logic)
 * Dokumen SDD: Bab 2.2 & Bab 4.1
 * Tanggung Jawab: Operasi CRUD tabel menu dengan PDO Prepared Statements
 */

require_once dirname(__DIR__) . '/config/Database.php';

class Menu {
    private PDO $db;

    public function __construct(?PDO $dbConnection = null) {
        $this->db = $dbConnection ?? Database::getConnection();
    }

    /**
     * Menyimpan data menu baru (Create)
     */
    public function create(array $data): bool {
        $sql = "INSERT INTO menu (name, category, price, stock) 
                VALUES (:name, :category, :price, :stock)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name'     => trim($data['name']),
            ':category' => trim($data['category']),
            ':price'    => (int)$data['price'],
            ':stock'    => (int)($data['stock'] ?? 0)
        ]);
    }

    /**
     * Memperbarui data menu yang sudah ada (Update)
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE menu 
                SET name = :name, 
                    category = :category, 
                    price = :price, 
                    stock = :stock 
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id'       => $id,
            ':name'     => trim($data['name']),
            ':category' => trim($data['category']),
            ':price'    => (int)$data['price'],
            ':stock'    => (int)($data['stock'] ?? 0)
        ]);
    }

    /**
     * Menghapus data menu berdasarkan ID (Delete)
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM menu WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Mengambil satu data menu berdasarkan ID
     */
    public function findById(int $id): ?array {
        $sql = "SELECT * FROM menu WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    /**
     * Mengambil seluruh data menu kopi
     */
    public function findAll(): array {
        $sql = "SELECT * FROM menu ORDER BY id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Validasi data input menu
     */
    public function validate(array $data): array {
        $errors = [];

        $name     = trim($data['name'] ?? '');
        $category = trim($data['category'] ?? '');
        $price    = $data['price'] ?? '';
        $stock    = $data['stock'] ?? '';

        if (empty($name)) {
            $errors[] = "Nama menu kopi wajib diisi.";
        } elseif (strlen($name) > 100) {
            $errors[] = "Nama menu tidak boleh lebih dari 100 karakter.";
        }

        if (empty($category)) {
            $errors[] = "Kategori menu wajib diisi/dipilih.";
        }

        if ($price === '' || !is_numeric($price)) {
            $errors[] = "Harga harus berupa angka.";
        } elseif ((int)$price < 0) {
            $errors[] = "Harga menu tidak boleh negatif.";
        }

        if ($stock === '' || !is_numeric($stock)) {
            $errors[] = "Stok harus berupa bilangan bulat.";
        } elseif ((int)$stock < 0) {
            $errors[] = "Stok menu tidak boleh negatif.";
        }

        return $errors;
    }
}
