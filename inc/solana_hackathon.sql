-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2022 at 09:29 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `solana_hackathon`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `account_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `country_id`, `account_name`) VALUES
(1, 1, 'bKash'),
(2, 1, 'Nagad'),
(3, 1, 'Bank_BD'),
(4, 2, 'Paytm'),
(5, 2, 'UPI'),
(6, 1, 'Paysum Account_BD'),
(7, 2, 'Paysum Account_INDIA'),
(8, 4, 'Wise'),
(9, 4, 'Osko'),
(10, 4, 'Bank_Australia'),
(11, 4, 'LinePay');

-- --------------------------------------------------------

--
-- Table structure for table `blockchain_transactions`
--

CREATE TABLE `blockchain_transactions` (
  `blockchain_transactions_id` int(11) NOT NULL,
  `transaction_hash` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_block` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_from` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_to` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_amount` int(11) NOT NULL,
  `transaction_amount_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `country_name`, `country_currency`) VALUES
(1, 'Bangladesh', 'BDT'),
(2, 'India', 'INR'),
(3, 'Pakistan', 'PKR'),
(4, 'Australia', 'AUD');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_dob` date DEFAULT NULL,
  `customer_phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_gender` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_address` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_country_id` int(10) DEFAULT NULL,
  `customer_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_dob`, `customer_phone`, `customer_gender`, `customer_address`, `customer_country_id`, `customer_email`, `customer_username`, `customer_password`, `registration_datetime`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 1, 'rokanchowdhury@ymail.com', 'rokan', '12345678', '2022-08-04 15:56:00'),
(2, NULL, NULL, NULL, NULL, NULL, 2, 'testone@gmail.com', 'testone', '12345678', '2022-08-09 23:05:39'),
(3, NULL, NULL, NULL, NULL, NULL, 4, 'test3@gmail.com', 'test3', '12345678', '2022-08-12 01:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `notification_to` int(11) NOT NULL,
  `notification_text` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_seen` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `notification_date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `notification_to`, `notification_text`, `notification_seen`, `notification_date_time`) VALUES
(1, 1, 'Testing...', '0', '2022-08-12 12:07:09');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `transaction_type` enum('deposit','transfer','withdraw') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'deposit, withdraw, transfer',
  `transaction_hash` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_signature` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_customer_id` int(11) NOT NULL,
  `to_customer_id` int(11) NOT NULL,
  `transaction_amount` int(11) NOT NULL,
  `transaction_amount_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_from_country_id` int(11) NOT NULL,
  `transaction_to_country_id` int(11) NOT NULL,
  `transaction_charge` int(11) NOT NULL,
  `transaction_date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `transaction_type`, `transaction_hash`, `transaction_signature`, `from_customer_id`, `to_customer_id`, `transaction_amount`, `transaction_amount_type`, `transaction_from_country_id`, `transaction_to_country_id`, `transaction_charge`, `transaction_date_time`) VALUES
(1, 'deposit', NULL, NULL, 1, 1, 1000, 'BDT', 1, 1, 0, '2022-08-10 15:38:28'),
(2, 'deposit', NULL, NULL, 6, 1, 200, 'BDT', 1, 1, 0, '2022-08-10 15:53:23'),
(3, 'deposit', NULL, NULL, 4, 2, 500, 'INR', 2, 2, 0, '2022-08-10 15:56:32'),
(4, 'deposit', NULL, NULL, 3, 1, 300, 'BDT', 1, 1, 0, '2022-08-10 16:15:49'),
(5, 'withdraw', NULL, NULL, 1, 1, 100, 'BDT', 1, 1, 0, '2022-08-11 00:53:49'),
(6, 'transfer', NULL, NULL, 1, 2, 100, 'BDT', 1, 2, 0, '2022-08-11 01:31:17'),
(7, 'transfer', NULL, NULL, 2, 1, 100, 'INR', 2, 1, 0, '2022-08-11 01:36:10'),
(8, 'transfer', NULL, NULL, 1, 2, 300, 'BDT', 1, 2, 0, '2022-08-11 01:43:13'),
(9, 'deposit', NULL, NULL, 10, 3, 200, 'AUD', 4, 4, 0, '2022-08-12 01:15:36'),
(10, 'transfer', NULL, NULL, 3, 1, 20, 'AUD', 4, 1, 0, '2022-08-12 01:16:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `blockchain_transactions`
--
ALTER TABLE `blockchain_transactions`
  ADD PRIMARY KEY (`blockchain_transactions_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `blockchain_transactions`
--
ALTER TABLE `blockchain_transactions`
  MODIFY `blockchain_transactions_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
