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
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
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
(10, 'Grace Taylor', 'grace@example.com', 'u', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS');
(11, 'Dolly Kent', 'dolly@example.com', 'u', '$2y$10$Cg/BMCRs5/xlBMQzezxX7eHArHN46rtkX60/64n89/4yvi7f/KKbS');
