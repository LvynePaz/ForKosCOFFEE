-- =====================================================
-- Sample Data for ForKos Coffee
-- Proyek: Aplikasi ForKos Coffee (Tugas Modul 2 PPPL)
-- Digunakan untuk mengisi data awal / pengujian aplikasi
-- =====================================================

USE forkos_coffee;

-- Bersihkan data lama jika diperlukan (opsional)
-- TRUNCATE TABLE menu;

INSERT INTO menu (name, category, price, stock) VALUES
('Kopi Susu ForKos', 'Coffee', 18000, 50),
('Americano Double Shot', 'Coffee', 15000, 40),
('Caramel Macchiato', 'Coffee', 24000, 30),
('Espresso Single', 'Coffee', 12000, 25),
('Matcha Green Tea Latte', 'Non-Coffee', 22000, 35),
('Signature Chocolate', 'Non-Coffee', 20000, 45),
('Earl Grey Milk Tea', 'Non-Coffee', 19000, 30),
('Croissant Butter', 'Snack', 16000, 20),
('French Fries Truffle', 'Snack', 18000, 25),
('Roti Bakar Cokelat Keju', 'Snack', 15000, 20);

