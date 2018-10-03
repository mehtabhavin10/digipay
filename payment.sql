-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 26, 2018 at 02:31 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id5124201_payment`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` varchar(100) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sender_username` varchar(100) NOT NULL,
  `receiver_username` varchar(100) NOT NULL,
  `sender_acc_no` varchar(20) NOT NULL,
  `receiver_acc_no` varchar(20) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `date_time`, `sender_username`, `receiver_username`, `sender_acc_no`, `receiver_acc_no`, `amount`) VALUES
('0q85U2HBjv', '2018-03-21 10:22:10', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 5000),
('1tvHnZdvZw', '2018-03-12 11:55:04', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('2DzJQHx4ry', '2018-03-12 14:05:45', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('2gA5wMjo4K', '2018-03-19 02:34:46', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 1000),
('3TZXmTnrWE', '2018-03-12 13:42:11', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('408QvrXy5Q', '2018-03-17 04:35:11', 'abc', 'mbm', '2011140089861436', '6181868798867665', 25000),
('5QfIMLwUYP', '2018-03-17 12:33:28', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 15000),
('7Zoi993pfV', '2018-03-17 02:32:47', 'mbm', 'ykm', '6181868798867665', '6769424061008666', 1000),
('80AG0IrNnI', '2018-03-19 05:16:33', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 100),
('87QwgQeBVP', '2018-03-12 11:55:04', 'nsh', 'mbm', '4243108727920399', '6181868798867665', 1000),
('9SUqg7R2cg', '2018-03-12 14:09:56', 'nsh', 'mbm', '4243108727920399', '6181868798867665', 1000),
('ALshiDAx85', '2018-03-12 11:55:04', 'nsh', 'mbm', '4243108727920399', '6181868798867665', 1000),
('AvJudQ9Fjn', '2018-03-12 11:56:17', 'mbm', 'ykm', '6181868798867665', '6769424061008666', 1000),
('AYFe8Z5JAz', '2018-03-12 11:55:04', 'nsh', 'mbm', '4243108727920399', '6181868798867665', 10000),
('b4GoiL3A8r', '2018-03-16 13:30:03', 'nsh', 'mbm', '4243108727920399', '6181868798867665', 1000),
('BCFNUolZxR', '2018-03-12 11:55:04', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('C3Sb4GoiL3', '2018-03-12 13:41:03', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('CkVwH4qEUn', '2018-03-12 14:00:23', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('cTNEgR8f7t', '2018-03-20 13:18:38', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 9000),
('EvtFGge18W', '2018-03-12 14:00:36', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('fdwJzPzPfU', '2018-03-21 10:34:29', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 5000),
('fsKDuYWRyg', '2018-03-19 08:44:28', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 1000),
('FSsHIXXZCN', '2018-03-19 05:20:04', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 100),
('jcYCjBX8tP', '2018-03-12 11:55:04', 'nsh', 'mbm', '4243108727920399', '6181868798867665', 1000),
('jrAzswdxZO', '2018-03-19 03:59:01', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 100),
('kiHky8LFMB', '2018-03-17 04:26:32', 'abc', 'ykm', '2011140089861436', '6769424061008666', 20000),
('LeajVPgD1f', '2018-03-12 11:55:04', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('lji1upXSR0', '2018-03-17 12:04:43', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 10000),
('ltYWtRu19l', '2018-03-12 11:55:04', 'nsh', 'mbm', '4243108727920399', '6181868798867665', 10000),
('MadtSG1j8J', '2018-03-12 11:55:04', 'nsh', 'mbm', '4243108727920399', '6181868798867665', 1000),
('mq3dQsdSXy', '2018-03-20 12:56:54', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 15000),
('Mxzye3VAlg', '2018-03-21 11:50:14', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 5000),
('o7zZA5V5n7', '2018-03-12 11:55:04', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('otEYImRLgS', '2018-03-16 15:22:10', 'mbm', 'ykm', '6181868798867665', '6769424061008666', 5000),
('OXTXDxOInn', '2018-03-19 05:53:33', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 100),
('PEqygP10tO', '2018-03-12 11:55:04', 'nsh', 'mbm', '4243108727920399', '6181868798867665', 1000),
('pJmycHieiF', '2018-03-19 15:15:11', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 15000),
('Qt8IKEhgj9', '2018-03-19 04:21:03', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 100),
('qyzMhnzBGB', '2018-03-12 11:55:04', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('R4dKv7hKRA', '2018-03-12 11:55:04', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('REjZR1iCbW', '2018-03-19 05:47:56', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 100),
('S1hpAuwTLQ', '2018-03-12 11:55:04', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('TNX0w2lw6F', '2018-03-12 11:55:04', 'mbm', 'ykm', '6181868798867665', '6769424061008666', 1000),
('tsAgvgRrcn', '2018-03-17 02:21:02', 'mbm', 'ykm', '6181868798867665', '6769424061008666', 1000),
('uxpjy8mY07', '2018-03-17 12:19:54', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 10000),
('VnJ518fddr', '2018-03-20 13:04:04', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 4000),
('vZwMzhFX7P', '2018-03-21 11:48:11', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 5000),
('wB1aQNZ10a', '2018-03-17 12:48:19', 'merchant@test.com', 'customer@test.com', '8039932207454729', '4732668128192818', 1000),
('WzOZj9xyAi', '2018-03-12 11:55:04', 'nsh', 'mbm', '4243108727920399', '6181868798867665', 1000),
('xAT7jsNaUw', '2018-03-12 13:59:43', 'nsh', 'ykm', '4243108727920399', '6769424061008666', 1000),
('xvmOWun2Jx', '2018-03-19 11:27:30', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 5000),
('YzNbqt1tTp', '2018-03-17 12:30:52', 'customer@test.com', 'merchant@test.com', '4732668128192818', '8039932207454729', 10000),
('zU2afTsiOA', '2018-03-12 14:10:24', 'nsh', 'mbm', '4243108727920399', '6181868798867665', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `id` varchar(100) NOT NULL,
  `acc_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `type`, `name`, `id`, `acc_no`) VALUES
('merchant@test.com', '$2y$10$1EEHXS3bKQD5REe7QeXvgeqCs0LPYCjCHAnKkIKRXrh6E47sLO6Dy', 2, 'merchant', '114vbdL03HTQtr4INSnQ', '8039932207454729'),
('Admin@admin.com', '$2y$10$T.CNViwFsM5u8tCMg/JldeBHsKc9hTH50A.xBryMWDMCBp5bDGHXG', 3, 'Admin', 'aOSs04V6AIkyxsrhUx7g', '00'),
('jigaravalani4699@gmail.com', '$2y$10$2zTdEg3LFA0AQuLvPk90fegvmsol6VqyFaYJ8fK9QP4d.8FFp/XKe', 2, 'Mobicity', 'F6o2MBIvIqjKOTUdUQYm', '1139056776642005'),
('customer@test.com', '$2y$10$mZ5tsdDOt2uY6QvkxYAWquO48Z.CBSLZUa.PUkUkxoaImkjJelkeG', 1, 'customer', 'h79MRasZs1zRvJHd0Wyp', '4732668128192818'),
('mehta.yash919@gmail.com', '$2y$10$Bvnb8MTEWTi6/bu/Te2sKu0lS/Myci/lyVZeNY6MYlgkSvU6e1Uzu', 1, 'yash.', 'iZSP62W7zKM4OFkeM1VS', '0186116340740017');

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `id` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `acc_no` varchar(20) NOT NULL,
  `paytm` double NOT NULL,
  `net_banking` double NOT NULL,
  `debit_card` double NOT NULL,
  `credit_card` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`id`, `username`, `acc_no`, `paytm`, `net_banking`, `debit_card`, `credit_card`) VALUES
('114vbdL03HTQtr4INSnQ', 'merchant@test.com', '8039932207454729', 45000, 20000, 40000, 20000),
('F6o2MBIvIqjKOTUdUQYm', 'jigaravalani4699@gmail.com', '1139056776642005', 10000, 10000, 10000, 10000),
('h79MRasZs1zRvJHd0Wyp', 'customer@test.com', '4732668128192818', 30000, 40000, 20000, 20000),
('iZSP62W7zKM4OFkeM1VS', 'mehta.yash919@gmail.com', '0186116340740017', 50000, 50000, 50000, 50000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `acc_no` (`acc_no`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `acc_no` (`acc_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
