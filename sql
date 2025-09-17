-- --------------------------------------------------------
-- Database: cmotorparts
-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS cmotorparts;
USE cmotorparts;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'customer') DEFAULT 'customer'
);

-- Insert default admin account
INSERT INTO users (name, email, password, role) VALUES
('Administrator', 'admin@cmotor.com',
'$2y$10$EIXu1cCkOvP5dP6sC9E61uSmPPoVJBboCE2E61A0QX7QWq1hRZNiS', -- password = admin123
'admin');

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS products;
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  image VARCHAR(255) DEFAULT NULL
);

-- Example products
INSERT INTO products (name, description, price, stock, image) VALUES
('Engine Oil', 'High performance synthetic engine oil', 450.00, 100, 'engine_oil.jpg'),
('Brake Pads', 'Durable ceramic brake pads for motorbikes', 350.00, 50, 'brake_pads.jpg'),
('Spark Plug', 'Standard spark plug for motorcycles', 120.00, 200, 'spark_plug.jpg');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  status ENUM('pending','completed','cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ----------------------------
-- Table structure for order_items
-- ----------------------------
DROP TABLE IF EXISTS order_items;
CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
