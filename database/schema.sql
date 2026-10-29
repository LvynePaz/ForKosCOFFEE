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

-- Seed / Sample Data
INSERT INTO menu (name, category, price, stock) VALUES
('Espresso', 'Hot Coffee', 15000, 50),
('Iced Americano', 'Iced Coffee', 18000, 40),
('ForKos Signature Milk Coffee', 'Signature', 22000, 100),
('Caramel Macchiato', 'Signature', 26000, 30),
('Matcha Latte', 'Non-Coffee', 24000, 25);
