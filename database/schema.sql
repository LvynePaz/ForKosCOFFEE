-- Database Schema for ForKos Coffee
CREATE DATABASE IF NOT EXISTS forkos_coffee;
USE forkos_coffee;

CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price INT NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


USE forkos_coffee;

INSERT INTO menu (name, category, price, stock) VALUES 
('Espresso', 'Minuman', 18000, 50),
('Cafe Latte', 'Minuman', 25000, 40),
('Americano', 'Minuman', 20000, 45),
('Matcha Latte', 'Minuman', 26000, 30),
('Croissant Butter', 'Makanan', 22000, 20);