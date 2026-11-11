-- =====================================================
-- Sample Data / Seeder for ForKos Coffee
-- Target DBMS: MySQL / MariaDB (XAMPP)
-- Digunakan untuk testing 3 Fitur Utama SDD & Modul CRUD
-- =====================================================

USE forkos_coffee;

SET FOREIGN_KEY_CHECKS = 0;

-- Bersihkan data lama
TRUNCATE TABLE pembayaran;
TRUNCATE TABLE detail_pesanan;
TRUNCATE TABLE pesanan;
TRUNCATE TABLE item_keranjang;
TRUNCATE TABLE keranjang;
TRUNCATE TABLE voucher;
TRUNCATE TABLE addon;
TRUNCATE TABLE produk;
TRUNCATE TABLE outlet;
TRUNCATE TABLE kasir;
TRUNCATE TABLE pengguna;
TRUNCATE TABLE menu;

-- 1. Data Kasir
INSERT INTO kasir (id_kasir, nama) VALUES 
(1, 'Barista Patra'),
(2, 'Barista Faris');

-- 2. Data Pengguna (Password: 'password123' ter-hash MD5)
INSERT INTO pengguna (id_pengguna, nama, email, password, no_telepon) VALUES 
(1, 'Ciko Pelanggan', 'ciko@example.com', MD5('password123'), '081234567890'),
(2, 'Yiesan Pelanggan', 'yiesan@example.com', MD5('password123'), '081298765432');

-- 3. Data Outlet (Sesuai Mockup UI-002 & UI-003 di SDD)
INSERT INTO outlet (id_outlet, nama_outlet, lokasi) VALUES 
(1, 'ForKos Coffee GC', 'Jl. Grand City No. 12, Balikpapan (0.4 km)'),
(2, 'ForKos Coffee Batu Ampar', 'Jl. Soekarno Hatta Km. 4, Balikpapan (1.2 km)');

-- 4. Data Produk (Katalog Menu Kopi & Non-Kopi SDD)
INSERT INTO produk (id_produk, id_outlet, nama_produk, harga) VALUES 
(1, 1, 'Caramel Macchiato', 26000),
(2, 1, 'Coffee Aren Latte', 24000),
(3, 1, 'Caffe Latte', 25000),
(4, 1, 'Americano', 20000),
(5, 1, 'Cappuccino', 26000),
(6, 1, 'Matcha Oat Latte', 28000),
(7, 2, 'Caramel Macchiato', 26000),
(8, 2, 'Coffee Aren Latte', 24000),
(9, 2, 'Americano', 20000);

-- 5. Data Add-on / Opsi Kustomisasi
INSERT INTO addon (id_addon, nama_addon, harga_tambahan) VALUES 
(1, 'Normal Ice & Normal Sugar', 0),
(2, 'Less Ice & Less Sugar', 0),
(3, 'Extra Espresso Shot', 5000),
(4, 'Oat Milk Upgrade', 6000),
(5, 'Caramel Drizzle Topping', 4000);

-- 6. Data Voucher Promo (Untuk Strategy Pattern Diskon)
INSERT INTO voucher (id_voucher, id_kasir, kode_voucher, nilai_diskon, status_aktif) VALUES 
(1, 1, 'FORKOSHEMAT', 5000, 1),
(2, 1, 'DISKON10K', 10000, 1),
(3, 1, 'DISKONEXPIRED', 15000, 0);

-- 7. Data Sample Keranjang Belanja Aktif (Untuk Pengguna 1)
INSERT INTO keranjang (id_keranjang, id_pengguna) VALUES 
(1, 1);

INSERT INTO item_keranjang (id_item, id_keranjang, id_produk, id_addon, kuantitas, subtotal) VALUES 
(1, 1, 1, 3, 1, 31000); -- Caramel Macchiato (26.000) + Extra Shot (5.000)

-- 8. Data Sample Transaksi Pesanan & Pelacakan (Untuk Pengguna 1)
INSERT INTO pesanan (id_pesanan, id_pengguna, id_outlet, id_voucher, id_kasir, total_harga, status_pesanan, kode_pengambilan) VALUES 
(1, 1, 1, 1, 1, 26000, 'Sedang Dibuat', 'A-127');

INSERT INTO detail_pesanan (id_detail, id_pesanan, id_produk, id_addon, kuantitas, subtotal) VALUES 
(1, 1, 1, 3, 1, 31000);

INSERT INTO pembayaran (id_pembayaran, id_pesanan, metode_pembayaran, status_pembayaran) VALUES 
(1, 1, 'QRIS', 'Success');

-- 9. Data Legacy Menu (Agar CRUD index.php dkk tetap bisa menampilkan data)
INSERT INTO menu (name, category, price, stock) VALUES 
('Espresso', 'Minuman', 18000, 50),
('Cafe Latte', 'Minuman', 25000, 40),
('Americano', 'Minuman', 20000, 45),
('Matcha Latte', 'Minuman', 26000, 30),
('Croissant Butter', 'Makanan', 22000, 20);

SET FOREIGN_KEY_CHECKS = 1;
