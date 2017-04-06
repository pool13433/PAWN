-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2017 at 06:21 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pawn`
--

-- --------------------------------------------------------

--
-- Table structure for table `interest`
--

CREATE TABLE `interest` (
  `int_id` int(11) NOT NULL,
  `int_money_begin` int(11) NOT NULL,
  `int_money_end` int(11) NOT NULL,
  `int_duration` int(3) NOT NULL,
  `int_value` int(11) NOT NULL,
  `create_date` date NOT NULL,
  `create_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `interest`
--

INSERT INTO `interest` (`int_id`, `int_money_begin`, `int_money_end`, `int_duration`, `int_value`, `create_date`, `create_by`) VALUES
(2, 0, 10000, 10, 5, '2017-03-12', 1),
(5, 10001, 20000, 15, 10, '2017-03-12', 1),
(6, 20001, 30000, 20, 15, '2017-03-12', 1),
(7, 30001, 40000, 20, 20, '2017-03-12', 1),
(8, 40001, 50000, 25, 25, '2017-03-12', 1),
(9, 50001, 60000, 30, 30, '2017-03-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `mem_id` int(11) NOT NULL,
  `mem_username` varchar(30) NOT NULL,
  `mem_password` varchar(100) NOT NULL,
  `mem_fname` varchar(50) NOT NULL,
  `mem_lname` varchar(50) NOT NULL,
  `mem_idcard` varchar(20) NOT NULL,
  `mem_age` int(2) NOT NULL,
  `mem_gender` enum('MALE','FEMALE') NOT NULL,
  `mem_mobile` varchar(15) NOT NULL,
  `mem_email` varchar(50) NOT NULL,
  `mem_address` text NOT NULL,
  `mem_status` enum('admin','customer','employee') NOT NULL,
  `create_date` date NOT NULL,
  `create_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`mem_id`, `mem_username`, `mem_password`, `mem_fname`, `mem_lname`, `mem_idcard`, `mem_age`, `mem_gender`, `mem_mobile`, `mem_email`, `mem_address`, `mem_status`, `create_date`, `create_by`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'admin', '1111111111111', 99, 'MALE', '0800000000', 'admin@gmail.com', 'admin@gmail.com', 'admin', '2017-03-09', 1),
(2, 'user', '81dc9bdb52d04dc20036dbd8313ed055', 'user', 'user', '1234567888888', 78, 'MALE', '1111111111', 'user@gmail.com', 'user', 'customer', '2017-03-11', 2),
(3, 'test', '2e99bf4e42962410038bc6fa4ce40d97', 'test', 'test', '1111111111111', 11, 'FEMALE', '1111111111', 'test@gmail.com', 'test', 'customer', '2017-03-11', 1),
(4, 'pisit', 'f15478148ee64990628825ac893cb067', 'pisit', 'pisit', '1111111111111', 100, 'MALE', '1111111111', 'pisit@gmail.com', 'สระแก้ว', 'customer', '2017-03-12', 1),
(5, 'RETEST', '81dc9bdb52d04dc20036dbd8313ed055', 'RETEST', 'RETEST', '1222222222222', 23, 'FEMALE', '9999999999', 'RETEST@gmail.com', 'RETEST', 'customer', '2017-03-12', 1),
(6, 'CUSTOMER', '81dc9bdb52d04dc20036dbd8313ed055', 'CUSTOMER', 'CUSTOMER', '1234567890121', 56, 'FEMALE', '2324242424', 'CUSTOMER@gmail.com', 'CUSTOMER', 'customer', '2017-03-12', 1),
(7, 'PISIT', '81dc9bdb52d04dc20036dbd8313ed055', 'Pisit', 'Krinkajorn', '9876444444444', 35, 'FEMALE', '0901111111', 'pisit@gmail.com', 'Pisit', 'customer', '2017-03-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `news_desc` text NOT NULL,
  `news_date_start` date NOT NULL,
  `news_date_end` date NOT NULL,
  `create_date` date NOT NULL,
  `create_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_title`, `news_desc`, `news_date_start`, `news_date_end`, `create_date`, `create_by`) VALUES
(1, 'สินค้าหลุดจำนำ', 'สินค้าหลุดจำนำ', '2017-03-01', '2017-03-01', '2017-03-10', 1),
(2, 'สินค้าลดราคา', 'สินค้าลดราคา', '2017-03-16', '2017-03-30', '2017-03-10', 1),
(4, 'รายชื่อสินค้าหลุดนำจำล่าสุด', 'รายชื่อสินค้าหลุดนำจำล่าสุด', '2017-03-01', '2017-03-31', '2017-03-10', 1),
(5, 'ประชาสัมพันธ์', 'ประชาสัมพันธ์', '2017-03-07', '2017-03-31', '2017-03-10', 1),
(6, 'ข่าวหน้า 1', 'ข่าวหน้า 1', '2017-03-01', '2017-03-31', '2017-03-10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pawn`
--

CREATE TABLE `pawn` (
  `pawn_id` int(11) NOT NULL COMMENT 'เลขจำนำ',
  `pawn_code` varchar(50) NOT NULL COMMENT 'รหัสจำนำ',
  `product_name` varchar(150) NOT NULL COMMENT 'ชื่อสินค้า',
  `product_price` int(11) NOT NULL COMMENT 'ราคาสินค้า',
  `product_image` varchar(255) NOT NULL COMMENT 'ภาพสินค้า',
  `type_id` int(11) NOT NULL COMMENT 'ประเภทสินค้า',
  `int_value` int(11) NOT NULL COMMENT 'ดอกเบี้ย',
  `int_duration` int(11) NOT NULL COMMENT 'ระยะเวลาไถ่ถอน',
  `pawn_date_get` datetime NOT NULL COMMENT 'วันที่มาจำนำ',
  `pawn_date_return` datetime NOT NULL COMMENT 'วันที่ไถ่ถอน',
  `pawn_date_reduce` datetime DEFAULT NULL,
  `pawn_total` int(11) NOT NULL DEFAULT '0',
  `pawn_pay` int(11) NOT NULL DEFAULT '0' COMMENT 'ยอดชำระไถ่ถอน',
  `sta_id` int(11) NOT NULL COMMENT 'สถานะ',
  `mem_id` int(11) NOT NULL,
  `create_date` date NOT NULL COMMENT 'วันที่สร้าง',
  `create_by` int(11) NOT NULL COMMENT 'สร้างโดย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pawn_status`
--

CREATE TABLE `pawn_status` (
  `sta_id` int(11) NOT NULL,
  `sta_name` varchar(100) NOT NULL,
  `sta_desc` text NOT NULL,
  `create_date` date NOT NULL,
  `create_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pawn_status`
--

INSERT INTO `pawn_status` (`sta_id`, `sta_name`, `sta_desc`, `create_date`, `create_by`) VALUES
(2, 'FAIL', 'เกิดข้อผิดพลาด\r\n', '2017-03-16', 1),
(3, 'PAWN-PROCESS', 'กำลังอยู่ในช่วงจำนำ รอไถ่ถอน', '2017-03-10', 1),
(5, 'SALE-FINISH', 'จบการขาย', '2017-03-10', 1),
(6, 'PAWN-EXPIRE', 'หมดระยะเวลาไถ่ถอน', '2017-03-10', 1),
(7, 'SALE-WAITING', 'สินค้าหลุดจำนำรอขาย', '2017-03-10', 1),
(8, 'PAWN-REDUCE', 'จ่ายลดดอกเบี้ย ,เงินต้น หรือ ต่อระยะเวลาการไถ่ถอน', '2017-03-13', 1),
(9, 'PAWN-FINSIH', 'ไถ่ถอนสินค้า เรียบร้อย', '2017-03-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `type_desc` text NOT NULL,
  `create_date` date NOT NULL,
  `create_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`type_id`, `type_name`, `type_desc`, `create_date`, `create_by`) VALUES
(1, 'กระเป๋า', 'กระเป๋า', '2017-03-10', 1),
(2, 'โทรศัพท์มือถือ', 'โทรศัพท์มือถือ เช่น i-Phone , I-Pad เป็นต้น', '2017-03-10', 1),
(4, 'มอเตอร์ไซต์', 'มอเตอร์ไซต์ เช่น Auto Matic, 2 T เป็นต้น', '2017-03-10', 1),
(5, 'เครื่องมือช่าง', 'เครื่องมือช่าง เช่น สว่าน เลื่อย หินเจีย กบไสไม้ เป็นต้น', '2017-03-10', 1),
(6, 'รถยนต์', 'รถยนต์', '2017-03-12', 1),
(7, 'เครื่องใช้ไฟฟ้า', 'เครื่องใช้ไฟฟ้า', '2017-03-16', 1),
(8, 'คอมพิวเตอร์', 'คอมพิวเตอร์', '2017-03-20', 1),
(9, 'ยาเสพติด', 'ยาเสพติด', '2017-03-20', 1),
(10, 'เครื่องครัว', 'เครื่องครัว', '2017-03-20', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `interest`
--
ALTER TABLE `interest`
  ADD PRIMARY KEY (`int_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`mem_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `pawn`
--
ALTER TABLE `pawn`
  ADD PRIMARY KEY (`pawn_id`);

--
-- Indexes for table `pawn_status`
--
ALTER TABLE `pawn_status`
  ADD PRIMARY KEY (`sta_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `interest`
--
ALTER TABLE `interest`
  MODIFY `int_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `mem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pawn`
--
ALTER TABLE `pawn`
  MODIFY `pawn_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'เลขจำนำ';
--
-- AUTO_INCREMENT for table `pawn_status`
--
ALTER TABLE `pawn_status`
  MODIFY `sta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
