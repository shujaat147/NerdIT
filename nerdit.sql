-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS `nerdit`;
USE `nerdit`;

-- backticks `` are used in SQL queries to enclose identifiers
-- such as table names and column names.

-- Tiny text used to store 255 bytes
-- Table structure for table `products`
CREATE TABLE IF NOT EXISTS `products` (
  `p_id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_code` VARCHAR(50) NOT NULL UNIQUE,
  `product_name` VARCHAR(50) NOT NULL,
  `product_desc` TINYTEXT NOT NULL,
  `product_img_name` VARCHAR(60) NOT NULL,
  `qty` INT(5) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL
);

-- table `users`
CREATE TABLE IF NOT EXISTS `users` (
  `u_id` INT AUTO_INCREMENT PRIMARY KEY,
  `fname` VARCHAR(50) NOT NULL,
  `lname` VARCHAR(50) NOT NULL,
  `address` VARCHAR(100) NOT NULL,
  `city` VARCHAR(50) NOT NULL,
  `pin` INT(6) NOT NULL,
  `email` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(25) NOT NULL,
  `type` VARCHAR(20) NOT NULL DEFAULT 'user'
);

-- table `orders`
CREATE TABLE IF NOT EXISTS `orders` (
  `o_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `units` INT(5) NOT NULL,
  `tax` DECIMAL(10, 2) NOT NULL,
  `discount` DECIMAL(10, 2) NOT NULL,
  `total` DECIMAL(10, 2) NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`p_id`) ON DELETE CASCADE
);

-- Insert data into `products` table
INSERT INTO `products` (`product_code`, `product_name`, `product_desc`, `product_img_name`, `qty`, `price`)
VALUES
  ('WATCH1', 'Apple Watch SE', 'Powerful sensors for insights about your health and fitness. Innovative safety features. Convenient ways to stay connected. A faster dual-core processor for added performance. Apple Watch SE is feature-packed, and it is a better value than ever.', 'watch1.jpg', 40, 249.99),
  ('WATCH2', 'Apple Watch Ultra', 'Meet the most rugged and capable Apple Watch ever. With a robust titanium case, precision dual-frequency GPS, up to 36 hours of battery life, the freedom of cellular, and three specialized bands made for athletes and adventurers of all kinds.', 'watch2.jpg', 20, 799.99),
  ('WATCH3', 'Apple Watch Series 8', 'Smooth and seamless. The edge of design. Apple Watch Series 8 features a big, brilliant Always On display. Narrow borders push the screen right to the edge, resulting in an elegant integration with the curvature of the case.', 'watch3.jpg', 34, 399.99),
  ('PHONE1', 'iPhone 14', 'The iPhone 14 is a powerful and sleek smartphone that features a 6.1-inch Super Retina XDR display, a powerful A16 Bionic chip, and a triple-lens rear camera system. It also comes with iOS 16, which includes new features like Live Text and Visual Look Up.', 'phone1.jpg', 64, 799.99),
  ('PHONE2', 'iPhone 13', 'The iPhone 13 is a sleek, powerful smartphone with a 6.1-inch Super Retina XDR display, an A15 Bionic chip, and a dual-lens rear camera system. It offers a longer battery life, a cinematic mode for video recording, and a more durable design.', 'phone2.jpg', 44, 599.99),
  ('PHONE3', 'iPhone SE', 'The iPhone SE is a compact and affordable smartphone with a 4.7-inch Retina HD display, an A15 Bionic chip, and a 12MP rear camera. It offers a great balance of features and performance making it a great choice for users who want a more affordable iPhone.', 'phone3.jpg', 50, 429.99),
  ('TABLET1', 'iPad Pro', 'The iPad Pro is a powerful and versatile tablet with an 11 or 12.9-inch Liquid Retina XDR display, an M1 chip, and a 12MP rear camera and 12MP Ultra-Wide front camera with Center Stage. It has a battery life of 10 to 12 hours of video playback.', 'tablet1.png', 30, 799.99),
  ('TABLET2', 'iPad Air', 'The iPad Air is a powerful and versatile tablet with a 10.9-inch Liquid Retina display, an M1 chip, and a 12MP Ultra-Wide front camera with Center Stage. It is perfect for work, play, and creativity, and it is available in a variety of colors.', 'tablet2.png', 0, 599.99),
  ('TABLET3', 'iPad mini', 'The iPad Mini is a powerful and portable tablet with an 8.3-inch Liquid Retina display, an A15 Bionic chip, and up to 10 hours of battery life. It is perfect for students, creative professionals, and anyone who wants a versatile and stylish tablet.', 'tablet3.png', 20, 499.99);

-- Insert  data into `users` table
INSERT INTO `users` (`fname`, `lname`, `address`, `city`, `pin`, `email`, `password`, `type`)
VALUES
  ('Shujaat', 'Hussain', 'Infinite Loop', 'USA', 95014, 'shujaathussain147@gmail.com', '12345678', 'user'),
  ('Admin', 'Webmaster', 'Internet', 'New York', 101010, 'admin@admin.com', 'admin', 'admin');
