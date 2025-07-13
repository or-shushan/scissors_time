CREATE DATABASE IF NOT EXISTS `scissors_time` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `scissors_time`;

--מסד הנתונים הנ"ל כולל נתונים שהוכנסו למערכת עד לתאריך 09/06/2025--

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: יוני 10, 2025 בזמן 02:09 PM
-- גרסת שרת: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scissors_time`
--

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `barber_id` int(11) DEFAULT NULL,
  `appointment_date` datetime DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `service` varchar(100) DEFAULT NULL,
  `status` enum('עתידי','הושלם','בוטל') DEFAULT 'עתידי'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- הוצאת מידע עבור טבלה `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `barber_id`, `appointment_date`, `appointment_time`, `service`, `status`) VALUES
(1, 9, 25, '2025-06-04 00:00:00', '14:00:00', 'תספורת וזקן', ''),
(2, 9, 2, '2025-06-11 00:00:00', '16:30:00', 'תספורת גברים', 'בוטל'),
(3, 9, 25, '2025-06-11 00:00:00', '16:30:00', 'תספורת גברים', 'בוטל'),
(4, 9, 29, '2025-06-04 00:00:00', '11:30:00', 'תספורת גברים', ''),
(5, 9, 2, '2025-06-04 00:00:00', '11:30:00', 'תספורת וזקן', ''),
(6, 9, 33, '2025-06-06 00:00:00', '14:00:00', 'תספורת וזקן', 'בוטל'),
(7, 9, 32, '2025-06-05 00:00:00', '16:30:00', 'עיצוב זקן', ''),
(8, 28, 33, '2025-06-12 00:00:00', '17:00:00', 'עיצוב זקן', 'בוטל'),
(9, 25, 32, '2025-06-10 00:00:00', '16:30:00', 'תספורת וזקן', ''),
(10, 25, 29, '2025-06-05 00:00:00', '12:00:00', 'תספורת גברים', ''),
(11, 9, 33, '2025-06-18 00:00:00', '16:30:00', 'תספורת וזקן', ''),
(12, 9, 32, '2025-07-17 00:00:00', '12:00:00', 'תספורת גברים', ''),
(13, 9, 32, '2025-08-20 00:00:00', '14:00:00', 'עיצוב זקן', ''),
(14, 9, 32, '2025-07-14 00:00:00', '16:30:00', 'תספורת וזקן', ''),
(15, 9, 33, '2025-07-01 00:00:00', '11:30:00', 'תספורת גברים', ''),
(16, 9, 33, '2025-07-05 00:00:00', '12:00:00', 'תספורת וזקן', ''),
(17, 9, 2, '2025-06-11 00:00:00', '14:00:00', 'תספורת וזקן', ''),
(18, 9, 2, '2025-06-18 00:00:00', '14:30:00', 'תספורת גברים', ''),
(19, 9, 2, '2025-06-18 00:00:00', '16:30:00', 'תספורת וזקן', ''),
(20, 9, 2, '2025-06-20 00:00:00', '19:00:00', 'עיצוב זקן', ''),
(21, 9, 29, '2025-06-06 00:00:00', '09:00:00', 'תספורת גברים', ''),
(22, 9, 29, '2025-06-27 00:00:00', '17:30:00', 'תספורת וזקן', ''),
(23, 9, 29, '2025-06-12 00:00:00', '19:00:00', 'תספורת גברים', ''),
(24, 9, 29, '2025-06-11 00:00:00', '14:00:00', 'תספורת גברים', ''),
(25, 9, 33, '2025-06-17 00:00:00', '14:30:00', 'עיצוב זקן', '');

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- הוצאת מידע עבור טבלה `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(63, 9, 17, 1, '2025-06-10 11:40:59'),
(64, 9, 24, 1, '2025-06-10 11:41:01'),
(65, 9, 27, 1, '2025-06-10 11:41:02');

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- הוצאת מידע עבור טבלה `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `created_at`) VALUES
(9, 9, 312.80, '2025-06-05 13:50:09'),
(10, 9, 604.80, '2025-06-05 13:56:14'),
(11, 9, 144.80, '2025-06-05 13:56:53'),
(12, 9, 464.60, '2025-06-05 13:59:16'),
(13, 9, 404.00, '2025-06-08 09:44:40'),
(14, 9, 992.60, '2025-06-08 15:40:19'),
(15, 9, 503.90, '2025-06-08 15:52:49'),
(16, 9, 469.40, '2025-06-08 16:17:38'),
(17, 2, 323.70, '2025-06-08 16:18:26'),
(18, 9, 164.00, '2025-06-08 16:19:50'),
(19, 9, 293.00, '2025-06-08 20:38:27');

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- הוצאת מידע עבור טבלה `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 9, 16, 2, 89.00),
(2, 9, 28, 1, 44.90),
(3, 9, 24, 1, 24.90),
(4, 9, 18, 1, 65.00),
(5, 10, 17, 1, 75.00),
(6, 10, 18, 2, 65.00),
(7, 10, 25, 1, 359.90),
(8, 10, 27, 1, 39.90),
(9, 11, 17, 1, 75.00),
(10, 11, 24, 1, 24.90),
(11, 11, 28, 1, 44.90),
(12, 12, 24, 1, 24.90),
(13, 12, 25, 1, 359.90),
(14, 12, 27, 2, 39.90),
(15, 13, 17, 1, 75.00),
(16, 13, 18, 3, 65.00),
(17, 13, 19, 1, 79.00),
(18, 13, 21, 1, 55.00),
(19, 14, 17, 1, 75.00),
(20, 14, 18, 1, 65.00),
(21, 14, 19, 1, 79.00),
(22, 14, 25, 1, 359.90),
(23, 14, 24, 1, 24.90),
(24, 14, 21, 1, 55.00),
(25, 14, 20, 1, 249.00),
(26, 14, 28, 1, 44.90),
(27, 14, 27, 1, 39.90),
(28, 15, 18, 1, 65.00),
(29, 15, 19, 1, 79.00),
(30, 15, 25, 1, 359.90),
(31, 16, 29, 1, 65.00),
(32, 16, 28, 3, 44.90),
(33, 16, 27, 3, 39.90),
(34, 16, 26, 3, 50.00),
(35, 17, 17, 1, 75.00),
(36, 17, 21, 1, 55.00),
(37, 17, 19, 1, 79.00),
(38, 17, 24, 1, 24.90),
(39, 17, 28, 2, 44.90),
(40, 18, 16, 1, 89.00),
(41, 18, 17, 1, 75.00),
(42, 19, 16, 2, 89.00),
(43, 19, 29, 1, 65.00),
(44, 19, 26, 1, 50.00);

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- הוצאת מידע עבור טבלה `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `description`, `image`, `price`, `quantity`, `created_at`) VALUES
(16, 'פומייד לשיער', 'עיצוב', 'פומייד לאחיזה חזקה המעניק ברק טבעי ושליטה בעיצוב לאורך כל היום.', 'images/uploads/pomid.webp', 89.00, 30, '2025-05-26 11:54:37'),
(17, 'שמן זקן', 'טיפוח זקן', 'שמן זקן מלחלח שמרכך את שיער הפנים ומזין את העור שמתחתיו.', 'images/uploads/oil zakan.webp', 75.00, 30, '2025-05-26 11:56:27'),
(18, 'קרם גילוח', 'גילוח', 'קרם גילוח יוקרתי לגילוח קרוב וחלק ללא גירוי.', 'images/uploads/shave gel.jpeg', 65.00, 30, '2025-05-26 11:57:36'),
(19, 'חימר לשיער', 'עיצוב', 'חימר לאחיזה בינונית עם גימור מט, מושלם לסגנונות מרקם.', 'images/uploads/hair hemar.jpeg', 79.00, 30, '2025-05-26 11:58:34'),
(20, 'מספריים מקצועיים', 'כלים', 'מספריים ברמה מקצועית לחיתוך ועיצוב מדויק.', 'images/uploads/misparaim.jpeg', 249.00, 10, '2025-05-26 11:59:23'),
(21, 'סרום לזקן', 'טיפוח זקן', 'סרום לעיצוב שמרכך ומסדר שיער זקן תוך מתן אחיזה קלה.', 'images/uploads/serom.jpeg', 55.00, 30, '2025-05-26 12:00:54'),
(24, 'מסרק טקסטורה', 'כלים', 'מסרק טקסטורה לעיצוב השיער ומתן מראה ייחודי', 'images/uploads/comb.webp', 24.90, 20, '2025-06-05 08:15:50'),
(25, 'מכונת תספורת', 'כלים', 'מכונת תספורת מקצועית הכוללת מספרים לעיצוב השיער והזקן', 'images/uploads/Hairdressing machine.jpeg', 359.90, 7, '2025-06-05 08:18:27'),
(26, 'אלכוהול לחיטוי', 'כלים', 'אלכוהול לחיטוי למניעת גירוי ואדמומיות', 'images/uploads/Alcohol.jpeg', 50.00, 25, '2025-06-05 08:21:58'),
(27, 'צבע לשער לגבר', 'עיצוב', 'צבע לשיער לגבר למתן מראה צעיר וזוהר', 'images/uploads/hair color.jpeg', 39.90, 15, '2025-06-05 08:24:59'),
(28, 'ערכה לטיפוח הזקן', 'טיפוח זקן', 'ערכה לעיצוב, טיפוח וסירוק הזקן.', 'images/uploads/Beard brush.jpeg', 44.90, 15, '2025-06-05 08:28:46'),
(29, 'סכין גילוח (תער)', 'גילוח', 'למראה חד ונקי\r\nהערכה כוללת ידית רב פעמית ו 10 סכינים.', 'images/uploads/shave knife.jpeg', 65.00, 25, '2025-06-05 13:34:39');

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('לקוח','ספר','מנהל') DEFAULT 'לקוח',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- הוצאת מידע עבור טבלה `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `role`, `created_at`, `image`) VALUES
(2, 'דר', 'צבאן', 'y1@gmail.com', '$2y$10$vbKc7bHoNXBz1dKgq8HR0OV5F9ZTJZ5gD09oWVC0FYB4Esp5Y4bqG', '054', 'ספר', '2025-05-20 12:10:12', 'picturs\\shay12.JPG'),
(9, 'אור', 'שושן', 'orshu12@gmail.com', '$2y$10$vbKc7bHoNXBz1dKgq8HR0OV5F9ZTJZ5gD09oWVC0FYB4Esp5Y4bqG', '0526606261', 'מנהל', '2025-05-21 07:21:28', '1748339795_or.JPG'),
(25, 'רן', 'ברסימנטוב', 'hjg@kjb.com', '$2y$10$iYVnhGCMSbk9n.Wmn6Dxs.IuImHtQl4JbSlEa08QozKG5.WTvMt02', '123456', 'ספר', '2025-05-21 14:32:24', 'picturs\\ran.JPG'),
(28, 'בדיקה', 'בדיקה', 'b@g.com', '$2y$10$.tGNPJrSyZ3CJF937xKWFOQ9AyhMAZwl0mTOYFZSOtUBfI1DlWuhC', '456', 'לקוח', '2025-05-21 15:47:47', NULL),
(29, 'אור', 'שושן', 'ss@g.com', '12345', '421', 'ספר', '2025-05-25 17:39:22', 'picturs\\or.JPG'),
(32, 'נגוסו', 'אקלו', 'NA@gmail.com', '12345', '123', 'ספר', '2025-06-03 15:51:41', 'picturs\\akalo.JPG'),
(33, 'ליאור', 'טקצ\'נקו', 'lt@gmail.com', '12345', '123', 'ספר', '2025-06-03 15:52:29', 'picturs\\lior.JPG');

--
-- Indexes for dumped tables
--

--
-- אינדקסים לטבלה `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `barber_id` (`barber_id`);

--
-- אינדקסים לטבלה `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- אינדקסים לטבלה `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- אינדקסים לטבלה `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- אינדקסים לטבלה `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- אינדקסים לטבלה `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- הגבלות לטבלאות שהוצאו
--

--
-- הגבלות לטבלה `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`barber_id`) REFERENCES `users` (`id`);

--
-- הגבלות לטבלה `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- הגבלות לטבלה `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- הגבלות לטבלה `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
