-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2022 at 05:11 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plant_cart`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `total_price` float(10,2) NOT NULL DEFAULT 0.00,
  `order_status` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `first_name`, `last_name`, `email`, `address`, `address2`, `country`, `state`, `zipcode`, `total_price`, `order_status`, `created_at`, `updated_at`) VALUES
(6, 'lakshitha', 'dilshan', 'laki@gma.com', '5eg jhckj', '5eg jhckj', 'Sri Lanka', 'Kurunegala', '55566', 1700.00, 'confirmed', '2022-04-10 18:41:54', '2022-04-10 18:41:54'),
(7, 'lakshitha', 'dilshan', 'am@abc.com', 'dalugama,kelaniya', 'dalugama,kelaniya', 'Sri Lanka', 'Colombo', '6896', 2550.00, 'confirmed', '2022-04-11 16:55:03', '2022-04-11 16:55:03'),
(8, 'abc', 'cdf', 'abc@bbc.com', 'No:567/C,Ritz Tower,Colombo 08,Sri Lanka.', 'No:567/C,Ritz Tower,Colombo 08,Sri Lanka.', 'Sri Lanka', 'Colombo', '5365', 599.00, 'confirmed', '2022-04-11 16:59:44', '2022-04-11 16:59:44'),
(9, 'nimal', 'jayasiri', 'nimal@abc.com', 'No:437/C,Ritz Tower,Colombo 07,Sri Lanka.', 'No:437/C,Ritz Tower,Colombo 07,Sri Lanka.', 'Sri Lanka', 'Colombo', '7466', 800.00, 'confirmed', '2022-04-11 17:08:51', '2022-04-11 17:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `product_price` float(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `total_price` double(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `product_name`, `product_price`, `qty`, `total_price`) VALUES
(6, 6, 2, 'Jade Succulent', 850.00, 2, 1700.00),
(7, 7, 7, 'Croton Petra', 950.00, 1, 950.00),
(8, 7, 6, 'Aurora k', 800.00, 2, 1600.00),
(9, 8, 12, 'Sago Palm', 599.00, 1, 599.00),
(10, 9, 6, 'Aurora k', 800.00, 1, 800.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_slug` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `full_description` text DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_slug`, `short_description`, `full_description`, `price`, `is_featured`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'European Cypress', 'European-Cypress', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.\r\n\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.\r\n\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 750.00, 1, 1, '2022-04-10 22:02:17', '2022-04-10 22:02:17'),
(2, 'Jade Succulent', 'Jade-Succulent', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 850.00, 1, 1, '2022-04-10 22:02:17', '2022-04-10 22:02:17'),
(3, 'Devil’s Ivy', 'Devil’s-Ivy', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 900.00, 1, 1, '2022-04-10 22:02:17', '2022-04-10 22:02:17'),
(4, 'ZZ Plant', 'ZZ-Plant', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 999.00, 1, 1, '2022-04-10 22:02:17', '2022-04-10 22:02:17'),
(5, 'Aloe g', 'Aloe-g', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.\r\n\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.\r\n\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 650.00, 0, 1, '2022-04-10 22:02:17', '2022-04-10 22:02:17'),
(6, 'Aurora k', 'Aurora-k', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 800.00, 0, 1, '2022-04-10 22:02:17', '2022-04-10 22:02:17'),
(7, 'Croton Petra', 'Croton-Petra', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 950.00, 0, 1, '2022-04-10 22:02:17', '2022-04-10 22:02:17'),
(8, 'Echeveria Succulent', 'Echeveria-Succulent', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 699.00, 0, 1, '2022-04-10 22:02:17', '2022-04-10 22:02:17'),
(9, 'Kangaroo Paw', 'Kangaroo-Paw', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 750.00, 0, 1, '2022-04-10 22:02:17', '2022-04-10 22:02:17'),
(10, 'Palm green', 'Palm-green', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 900.00, 0, 1, '2022-04-10 22:02:17', '2022-04-10 22:02:17'),
(11, 'Pink Dragon', 'Pink-Dragon', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 650.00, 0, 1, '2022-04-10 22:02:17', '2022-04-10 22:02:17'),
(12, 'Sago Palm', 'Sago-Palm', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 599.00, 0, 1, '2022-04-10 22:02:17', '2022-04-10 22:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `img`, `display_order`, `is_featured`) VALUES
(1, 1, 'European-Cypress.jpg', 1, 1),
(2, 2, 'Jade-Succulent.jpg', 1, 1),
(3, 3, 'Devil’s-Ivy.jpg', 1, 1),
(4, 4, 'ZZ-Plant.jpg', 1, 1),
(5, 5, 'Aloe-g.jpg', 1, 1),
(6, 6, 'Aurora-k.jpg', 1, 1),
(7, 7, 'Croton-Petra.jpg', 1, 1),
(8, 8, 'Echeveria-Succulent.jpg', 1, 1),
(9, 9, 'Kangaroo-Paw.jpg', 1, 1),
(10, 10, 'Palm-green.jpg', 1, 1),
(11, 11, 'Pink-Dragon.jpg', 1, 1),
(12, 12, 'Sago-Palm.jpg', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
