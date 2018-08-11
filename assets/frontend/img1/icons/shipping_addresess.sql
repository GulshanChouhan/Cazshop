-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2018 at 09:15 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_marketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresess`
--

CREATE TABLE `shipping_addresess` (
  `shipping_address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping_addresess`
--

INSERT INTO `shipping_addresess` (`shipping_address_id`, `user_id`, `first_name`, `last_name`, `email_id`, `country`, `state`, `city`, `zip_code`, `address`, `phone_no`, `status`, `created_at`, `updated_at`) VALUES
(1, 30, 'dsjfhkj', 'khkjhdfkjh', 'jkhfdkj@gmail.com', '101', '4', '319', '2344234', 'fgzghkjhgkjdzh', '8871452569', 1, '2018-01-31 18:58:29', '0000-00-00 00:00:00'),
(2, 50, 'sadik', 'sheikh', 'sadik.chapter247@gmail.com', '101', '21', '2229', '452001', 'yhdyhmuyp,uhjnfop, u7o,k cj-o0k,ujnmfgjrdns5t ', '1234567891', 1, '2018-02-01 11:28:58', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shipping_addresess`
--
ALTER TABLE `shipping_addresess`
  ADD PRIMARY KEY (`shipping_address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shipping_addresess`
--
ALTER TABLE `shipping_addresess`
  MODIFY `shipping_address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
