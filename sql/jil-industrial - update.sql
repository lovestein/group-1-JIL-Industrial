-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2022 at 12:05 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jil-industrial`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

CREATE TABLE `accessories` (
  `acc_id` int(11) NOT NULL,
  `acc_type_id` int(11) DEFAULT NULL,
  `ref_id` varchar(100) NOT NULL,
  `acc_name` varchar(50) DEFAULT NULL,
  `acc_on_hand` int(11) DEFAULT NULL,
  `acc_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`acc_id`, `acc_type_id`, `ref_id`, `acc_name`, `acc_on_hand`, `acc_price`) VALUES
(1, 1, 'ref-62e59741deb08-62e59741deb0b', 'Nut 1', 50, 300);

-- --------------------------------------------------------

--
-- Table structure for table `accessories_type`
--

CREATE TABLE `accessories_type` (
  `acc_type_id` int(11) NOT NULL,
  `acc_type_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accessories_type`
--

INSERT INTO `accessories_type` (`acc_type_id`, `acc_type_name`) VALUES
(1, 'Nuts'),
(2, 'Nozzles'),
(3, 'Gauges'),
(4, 'Tip & Vectors'),
(5, 'Mixers'),
(6, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cust_id` int(11) NOT NULL,
  `tank_id` int(11) NOT NULL,
  `cust_type` int(11) DEFAULT NULL,
  `cust_name` varchar(50) DEFAULT NULL,
  `cust_address` varchar(50) DEFAULT NULL,
  `cust_contact_no` varchar(11) DEFAULT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `tank_deposited` int(11) DEFAULT NULL,
  `tank_on_hand` int(11) DEFAULT NULL,
  `cash_deposited` int(11) DEFAULT NULL,
  `price_rent` int(11) DEFAULT NULL,
  `content_price` int(11) NOT NULL,
  `total_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cust_id`, `tank_id`, `cust_type`, `cust_name`, `cust_address`, `cust_contact_no`, `start_date`, `tank_deposited`, `tank_on_hand`, `cash_deposited`, `price_rent`, `content_price`, `total_amount`) VALUES
(2, 0, 2, 'Orly', '09', '50', '2022-07-30 21:54:51', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_type`
--

CREATE TABLE `customer_type` (
  `cust_type_id` int(11) NOT NULL,
  `cust_type_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_type`
--

INSERT INTO `customer_type` (`cust_type_id`, `cust_type_name`) VALUES
(1, 'Walk-in'),
(2, 'Person'),
(3, 'Establishment');

-- --------------------------------------------------------

--
-- Table structure for table `point_of_sales`
--

CREATE TABLE `point_of_sales` (
  `trans_id` int(11) NOT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `no_of_items` int(11) DEFAULT NULL,
  `sub_total` int(11) DEFAULT NULL,
  `cash_paid` float DEFAULT NULL,
  `cash_change` float NOT NULL,
  `total_sales` int(11) DEFAULT NULL,
  `date_of_transaction` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `point_of_sales`
--

INSERT INTO `point_of_sales` (`trans_id`, `cust_id`, `no_of_items`, `sub_total`, `cash_paid`, `cash_change`, `total_sales`, `date_of_transaction`) VALUES
(1, NULL, 1, 1500, 2000, 500, 1500, '2022-07-31'),
(2, NULL, 1, 2000, 2000, 0, 2000, '2022-07-31'),
(3, NULL, 1, 5000, 5000, 0, 5000, '2022-07-01'),
(4, NULL, 1, 2250, 2250, 0, 2250, '2022-07-01');

-- --------------------------------------------------------

--
-- Table structure for table `point_of_sales_product`
--

CREATE TABLE `point_of_sales_product` (
  `pos_product_id` int(11) NOT NULL,
  `pos_id` int(11) NOT NULL,
  `ref_id` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `point_of_sales_product`
--

INSERT INTO `point_of_sales_product` (`pos_product_id`, `pos_id`, `ref_id`, `price`, `quantity`, `total`) VALUES
(1, 1, 'ref-62e5972d46e7b-62e5972d46e7e', 300, 5, 1500),
(2, 2, 'ref-62e59741deb08-62e59741deb0b', 400, 5, 2000),
(3, 3, 'ref-62e5972d6f94f-62e5972d6f953', 500, 10, 5000),
(4, 4, 'ref-62e5972d46e7b-62e5972d46e7e', 450, 5, 2250);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prod_id` int(11) NOT NULL,
  `prod_type` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `ref_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `prod_type`, `type`, `ref_id`) VALUES
(1, 1, 1, 'ref-62e5972d46e7b-62e5972d46e7e'),
(2, 1, 1, 'ref-62e5972d6f94f-62e5972d6f953'),
(3, 2, 1, 'ref-62e59741deb08-62e59741deb0b');

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `prod_type_id` int(11) NOT NULL,
  `prod_type_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`prod_type_id`, `prod_type_name`) VALUES
(1, 'Tanks'),
(2, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `store_expenses`
--

CREATE TABLE `store_expenses` (
  `exp_id` int(11) NOT NULL,
  `total_expenses` int(11) DEFAULT NULL,
  `total` float NOT NULL,
  `date_made` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store_expenses`
--

INSERT INTO `store_expenses` (`exp_id`, `total_expenses`, `total`, `date_made`) VALUES
(1, 2, 26500, '2022-07-31');

-- --------------------------------------------------------

--
-- Table structure for table `store_expenses_item`
--

CREATE TABLE `store_expenses_item` (
  `store_exp_item` int(11) NOT NULL,
  `exp_id` int(11) NOT NULL,
  `expenses` varchar(100) NOT NULL,
  `exp_cash` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store_expenses_item`
--

INSERT INTO `store_expenses_item` (`store_exp_item`, `exp_id`, `expenses`, `exp_cash`) VALUES
(1, 1, 'Vihicle Gasoline', 1500),
(2, 1, 'Vehicle Maintenance', 25000);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `sup_id` int(11) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tank`
--

CREATE TABLE `tank` (
  `tank_id` int(11) NOT NULL,
  `tank_name` varchar(200) NOT NULL,
  `date_inserted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tank`
--

INSERT INTO `tank` (`tank_id`, `tank_name`, `date_inserted`) VALUES
(1, 'LPG', '2022-07-30 20:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `tank_type`
--

CREATE TABLE `tank_type` (
  `tank_type_id` int(11) NOT NULL,
  `tank_id` int(11) NOT NULL,
  `ref_id` varchar(100) NOT NULL,
  `tank_type_name` varchar(100) NOT NULL,
  `type_quantity_stock` int(11) NOT NULL,
  `type_size` varchar(100) NOT NULL,
  `type_on_hand` int(11) NOT NULL,
  `type_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tank_type`
--

INSERT INTO `tank_type` (`tank_type_id`, `tank_id`, `ref_id`, `tank_type_name`, `type_quantity_stock`, `type_size`, `type_on_hand`, `type_price`) VALUES
(1, 1, 'ref-62e5972d46e7b-62e5972d46e7e', 'Standard', 53, '11 KG', 47, 450),
(2, 1, 'ref-62e5972d6f94f-62e5972d6f953', 'Flask Type', 62, '50 KG', 52, 500);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_report`
--

CREATE TABLE `transaction_report` (
  `trans_id` int(11) DEFAULT NULL,
  `exp_id` int(11) DEFAULT NULL,
  `trans_date` varchar(50) DEFAULT NULL,
  `total_cash_sales` int(11) DEFAULT NULL,
  `total_cash_expense` int(11) DEFAULT NULL,
  `total_income` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_supplies`
--

CREATE TABLE `transaction_supplies` (
  `trans_id` int(11) NOT NULL,
  `sup_id` int(11) DEFAULT NULL,
  `date_delivered` date DEFAULT current_timestamp(),
  `prod_quantity` int(11) DEFAULT NULL,
  `delivery_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction_supplies`
--

INSERT INTO `transaction_supplies` (`trans_id`, `sup_id`, `date_delivered`, `prod_quantity`, `delivery_price`) VALUES
(1, NULL, '2022-07-31', 1, 15600),
(2, NULL, '2022-07-31', 1, 1500),
(3, NULL, '2022-07-31', 1, 1200),
(4, NULL, '2022-07-31', 1, 1200),
(5, NULL, '2022-07-31', 1, 1800),
(6, NULL, '2022-07-31', 1, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_supplies_product`
--

CREATE TABLE `transaction_supplies_product` (
  `ts_product_id` int(11) NOT NULL,
  `trans_id` int(11) NOT NULL,
  `ref_id` varchar(100) NOT NULL,
  `quantity_before` int(11) NOT NULL,
  `quantity_after` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction_supplies_product`
--

INSERT INTO `transaction_supplies_product` (`ts_product_id`, `trans_id`, `ref_id`, `quantity_before`, `quantity_after`, `quantity`) VALUES
(1, 1, '', 0, 52, 52),
(2, 2, '', 0, 5, 5),
(3, 3, 'ref-62e5972d46e7b-62e5972d46e7e', 44, 48, 4),
(4, 4, 'ref-62e59741deb08-62e59741deb0b', 36, 40, 4),
(5, 5, 'ref-62e5972d46e7b-62e5972d46e7e', 48, 52, 4),
(6, 6, 'ref-62e59741deb08-62e59741deb0b', 40, 50, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`acc_id`),
  ADD KEY `acc_type_id` (`acc_type_id`);

--
-- Indexes for table `accessories_type`
--
ALTER TABLE `accessories_type`
  ADD PRIMARY KEY (`acc_type_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cust_id`),
  ADD KEY `cust_type` (`cust_type`),
  ADD KEY `tank_deposited` (`tank_deposited`);

--
-- Indexes for table `customer_type`
--
ALTER TABLE `customer_type`
  ADD PRIMARY KEY (`cust_type_id`);

--
-- Indexes for table `point_of_sales`
--
ALTER TABLE `point_of_sales`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `pos_ibfk_2` (`cust_id`);

--
-- Indexes for table `point_of_sales_product`
--
ALTER TABLE `point_of_sales_product`
  ADD PRIMARY KEY (`pos_product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `prod_type` (`prod_type`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`prod_type_id`);

--
-- Indexes for table `store_expenses`
--
ALTER TABLE `store_expenses`
  ADD PRIMARY KEY (`exp_id`);

--
-- Indexes for table `store_expenses_item`
--
ALTER TABLE `store_expenses_item`
  ADD PRIMARY KEY (`store_exp_item`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`sup_id`);

--
-- Indexes for table `tank`
--
ALTER TABLE `tank`
  ADD PRIMARY KEY (`tank_id`);

--
-- Indexes for table `tank_type`
--
ALTER TABLE `tank_type`
  ADD PRIMARY KEY (`tank_type_id`);

--
-- Indexes for table `transaction_report`
--
ALTER TABLE `transaction_report`
  ADD KEY `fin_ibfk_1` (`trans_id`),
  ADD KEY `fin_ibfk_2` (`exp_id`);

--
-- Indexes for table `transaction_supplies`
--
ALTER TABLE `transaction_supplies`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `trans_ibfk_1` (`sup_id`);

--
-- Indexes for table `transaction_supplies_product`
--
ALTER TABLE `transaction_supplies_product`
  ADD PRIMARY KEY (`ts_product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `accessories_type`
--
ALTER TABLE `accessories_type`
  MODIFY `acc_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_type`
--
ALTER TABLE `customer_type`
  MODIFY `cust_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `point_of_sales`
--
ALTER TABLE `point_of_sales`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `point_of_sales_product`
--
ALTER TABLE `point_of_sales_product`
  MODIFY `pos_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `prod_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `store_expenses`
--
ALTER TABLE `store_expenses`
  MODIFY `exp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_expenses_item`
--
ALTER TABLE `store_expenses_item`
  MODIFY `store_exp_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `sup_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tank`
--
ALTER TABLE `tank`
  MODIFY `tank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tank_type`
--
ALTER TABLE `tank_type`
  MODIFY `tank_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction_supplies`
--
ALTER TABLE `transaction_supplies`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaction_supplies_product`
--
ALTER TABLE `transaction_supplies_product`
  MODIFY `ts_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessories`
--
ALTER TABLE `accessories`
  ADD CONSTRAINT `accessories_ibfk_1` FOREIGN KEY (`acc_type_id`) REFERENCES `accessories_type` (`acc_type_id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`cust_type`) REFERENCES `customer_type` (`cust_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customers_ibfk_2` FOREIGN KEY (`cust_type`) REFERENCES `customer_type` (`cust_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customers_ibfk_4` FOREIGN KEY (`cust_type`) REFERENCES `customer_type` (`cust_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customers_ibfk_6` FOREIGN KEY (`cust_type`) REFERENCES `customer_type` (`cust_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `point_of_sales`
--
ALTER TABLE `point_of_sales`
  ADD CONSTRAINT `pos_ibfk_2` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`prod_type`) REFERENCES `product_type` (`prod_type_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`prod_type`) REFERENCES `product_type` (`prod_type_id`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`prod_type`) REFERENCES `product_type` (`prod_type_id`);

--
-- Constraints for table `transaction_report`
--
ALTER TABLE `transaction_report`
  ADD CONSTRAINT `fin_ibfk_1` FOREIGN KEY (`trans_id`) REFERENCES `point_of_sales` (`trans_id`),
  ADD CONSTRAINT `fin_ibfk_2` FOREIGN KEY (`exp_id`) REFERENCES `store_expenses` (`exp_id`);

--
-- Constraints for table `transaction_supplies`
--
ALTER TABLE `transaction_supplies`
  ADD CONSTRAINT `trans_ibfk_1` FOREIGN KEY (`sup_id`) REFERENCES `supplier` (`sup_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
