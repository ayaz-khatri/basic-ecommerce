/* -------------------------------------------------------------------------- */
/*                                Database File                               */
/* -------------------------------------------------------------------------- */

DROP DATABASE IF EXISTS `basic_ecommerce`;          -- Removes database if already exists
CREATE DATABASE `basic_ecommerce`;                  -- creates new database
USE `basic_ecommerce`;                              -- selects the database for further actions

/* ------------------------------- Users table ------------------------------ */
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `role` char(1) NOT NULL DEFAULT 'u',
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
);

/* ------------------------------- Categories table ------------------------------ */
CREATE TABLE `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
);

/* ------------------------------- Products table ------------------------------ */
CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT DEFAULT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `stock` INT NOT NULL DEFAULT 0,
  `is_available` CHAR(1) NOT NULL DEFAULT '1',
  `image` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
);

/* -------------------------------------------------------------------------- */
/*                                  Data Dump                                 */
/* -------------------------------------------------------------------------- */


/* ------------------------------- users data ------------------------------- */
INSERT INTO `users` (`id`, `username`, `email`, `role`, `password`)
VALUES
(1, 'Admin', 'admin@example.com', 'a', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS'),
(2, 'John Doe', 'john@example.com', 'u', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS'),
(3, 'Jane Smith', 'jane@example.com', 'u', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS'),
(4, 'Alice Johnson', 'alice@example.com', 'u', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS'),
(5, 'Bob Brown', 'bob@example.com', 'u', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS'),
(6, 'Carol Davis', 'carol@example.com', 'u', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS'),
(7, 'David Miller', 'david@example.com', 'u', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS'),
(8, 'Eva Wilson', 'eva@example.com', 'u', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS'),
(9, 'Frank Moore', 'frank@example.com', 'u', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS'),
(10, 'Grace Taylor', 'grace@example.com', 'u', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS'),
(11, 'Henry Kent', 'henry@example.com', 'u', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS');


/* ---------------------------- categories data ---------------------------- */
INSERT INTO `categories` (`id`, `name`, `description`)
VALUES
(1, 'Electronics', 'Devices and gadgets including phones, laptops, and accessories.'),
(2, 'Clothing', 'Apparel for men, women, and children including shirts, pants, and accessories.'),
(3, 'Home & Kitchen', 'Household items, furniture, and kitchen appliances.'),
(4, 'Books', 'A wide range of books across different genres.'),
(5, 'Toys', 'Toys for children of all ages, including educational and recreational toys.');


/* ---------------------------- products data ---------------------------- */
INSERT INTO `products` (`category_id`, `name`, `description`, `price`, `stock`)
VALUES
(1, 'Smartphone X', 'Latest smartphone with high-end features.', 699.99, 50),
(1, 'Laptop Pro 15', 'High-performance laptop for professionals.', 1299.99, 30),
(1, 'Wireless Earbuds', 'Noise-canceling wireless earbuds.', 199.99, 100),
(1, 'Gaming Console', 'Next-gen gaming console with 4K support.', 499.99, 20),

(2, 'Mens Leather Jacket', 'Stylish leather jacket for men.', 149.99, 25),
(2, 'Womens Winter Coat', 'Warm and comfortable winter coat.', 179.99, 35),
(2, 'Casual T-Shirt', 'Cotton t-shirt available in multiple colors.', 19.99, 80),
(2, 'Running Shoes', 'Lightweight running shoes for athletes.', 59.99, 60),

(3, 'Air Fryer', 'Healthy cooking with an advanced air fryer.', 129.99, 15),
(3, 'Coffee Maker', 'Automatic coffee maker with multiple settings.', 79.99, 40),
(3, 'LED Desk Lamp', 'Adjustable LED lamp with multiple brightness levels.', 39.99, 70),
(3, 'Vacuum Cleaner', 'High-suction vacuum cleaner for deep cleaning.', 149.99, 25),

(4, 'Mystery Novel', 'Thrilling mystery novel with unexpected twists.', 14.99, 100),
(4, 'Science Fiction Book', 'An epic sci-fi adventure.', 18.99, 80),
(4, 'Self-Help Guide', 'Improve your life with practical advice.', 12.99, 90),
(4, 'History Encyclopedia', 'Comprehensive guide to world history.', 34.99, 30),

(5, 'Building Blocks Set', 'Creative and fun building blocks for kids.', 29.99, 120),
(5, 'Remote Control Car', 'High-speed RC car for children.', 49.99, 50),
(5, 'Plush Teddy Bear', 'Soft and cuddly teddy bear.', 19.99, 150),
(5, 'Educational Puzzle', 'Brain-stimulating puzzle game.', 24.99, 90);