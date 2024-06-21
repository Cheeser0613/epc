-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2024-06-21 16:57:52
-- 服务器版本： 10.4.27-MariaDB
-- PHP 版本： 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `epc`
--

-- --------------------------------------------------------

--
-- 表的结构 `account`
--

CREATE TABLE `account` (
  `username` varchar(90) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `role` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `account`
--

INSERT INTO `account` (`username`, `hashed_password`, `role`) VALUES
('admin', '$2y$10$rK1x642LtLXxSTsjT.dgyetleDxvmZgKnua95wDy1gQrEl/eDT.8K', 'admin');

-- --------------------------------------------------------

--
-- 表的结构 `cart_admin`
--

CREATE TABLE `cart_admin` (
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `order_list`
--

CREATE TABLE `order_list` (
  `order_id` int(10) NOT NULL,
  `order_owner` varchar(90) NOT NULL,
  `order_status` varchar(20) NOT NULL,
  `order_date` int(6) NOT NULL,
  `receiver_name` varchar(50) NOT NULL,
  `receiver_phone_number` int(20) NOT NULL,
  `receiver_address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `product_list`
--

CREATE TABLE `product_list` (
  `product_id` int(10) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_price` int(10) NOT NULL,
  `product_image` varchar(200) NOT NULL,
  `product_quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转储表的索引
--

--
-- 表的索引 `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`);

--
-- 表的索引 `cart_admin`
--
ALTER TABLE `cart_admin`
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_owner` (`order_owner`);

--
-- 表的索引 `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`product_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `order_list`
--
ALTER TABLE `order_list`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `product_list`
--
ALTER TABLE `product_list`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 限制导出的表
--

--
-- 限制表 `cart_admin`
--
ALTER TABLE `cart_admin`
  ADD CONSTRAINT `cart_admin_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`product_id`);

--
-- 限制表 `order_list`
--
ALTER TABLE `order_list`
  ADD CONSTRAINT `order_list_ibfk_1` FOREIGN KEY (`order_owner`) REFERENCES `account` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
