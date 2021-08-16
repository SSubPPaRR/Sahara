-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 06, 2020 at 12:59 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saharadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `Admin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_Name` text NOT NULL,
  `Password` text NOT NULL,
  `Name` text NOT NULL,
  PRIMARY KEY (`Admin_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_ID`, `User_Name`, `Password`, `Name`) VALUES
(1, 'admin', 'password', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `Cat_ID` int(100) NOT NULL AUTO_INCREMENT,
  `Cat_Title` text NOT NULL,
  PRIMARY KEY (`Cat_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Cat_ID`, `Cat_Title`) VALUES
(1, 'Fashion'),
(2, 'Electronics'),
(3, 'Furnitures'),
(19, 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `Product_ID` int(11) NOT NULL,
  `Image_Path` text NOT NULL,
  KEY `Product_ID` (`Product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`Product_ID`, `Image_Path`) VALUES
(1, 'images\\Iphone11.jpg'),
(3, 'images\\Piano.jpg'),
(2, 'images\\Laptop.jpg'),
(4, 'images\\dress4women.jpg'),
(5, 'images\\grey_sofa.jpg'),
(6, 'images\\hp_inkjet.jpg'),
(7, 'images\\Spallding_basketball.jpg'),
(20, '../images/Jellyfish.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `Product_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` text NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `Vendor_ID` int(11) NOT NULL,
  `Description` text NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Base_Price` decimal(10,2) NOT NULL,
  `Discount` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Keywords` text NOT NULL,
  PRIMARY KEY (`Product_ID`),
  UNIQUE KEY `Product_ID` (`Product_ID`),
  KEY `Cat_ID` (`Cat_ID`),
  KEY `Vendor_ID` (`Vendor_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Title`, `Cat_ID`, `Vendor_ID`, `Description`, `Quantity`, `Base_Price`, `Discount`, `Price`, `Keywords`) VALUES
(1, 'Iphone 11', 2, 3, 'new iphone', 10, '800.00', 0, '800.00', 'apple,iphone11 '),
(2, 'HP gaming Laptop ', 2, 1, 'Gaming laptop', 15, '799.00', 0, '799.00', 'hp,gaming,laptop'),
(3, 'Samsung Piano', 2, 2, 'electric keyboard music pog', 5, '499.00', 0, '499.00', 'samsung,music,piano,keyboard'),
(4, 'Floral Vintage Dress Elegant ', 1, 5, 'Perfect Wedding Guest Dress for Autumn,Winter and Early Spring Seasons.', 10, '25.99', 0, '25.99', 'dress,clothes,women,woman,floral,vintage,apparel,simple apparel'),
(5, 'Walsunny Convertible Sofa ', 3, 6, 'comfy bro', 3, '214.99', 0, '0.00', 'walsunny,convertible,sofa,furniture,indoors'),
(6, 'HP OfficeJet Pro 8025 All-in-One Wireless Printer', 2, 1, 'Print remotely using HP smart app access your printer and Scanner, monitor ink levels, and Print, copy, and scan on the go with our highly-rated HP smart app', 300, '119.99', 0, '119.99', 'HP,printer,all-in-one,wireless,office-jet,pro,8025'),
(7, 'Spalding NBA Street Outdoor Basketball', 19, 7, 'Official NBA size and weight: Size 7, 29.5 inches', 300, '11.51', 0, '11.51', 'Spalding,NBA,Street,Outdoor,Basketball'),
(20, 'test product2', 1, 1, 'qwertzxcv', 123, '800.00', 31, '552.00', 'test,product,2');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

DROP TABLE IF EXISTS `shoppingcart`;
CREATE TABLE IF NOT EXISTS `shoppingcart` (
  `User_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  KEY `User_ID` (`User_ID`,`Product_ID`),
  KEY `Product_ID` (`Product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supportbox`
--

DROP TABLE IF EXISTS `supportbox`;
CREATE TABLE IF NOT EXISTS `supportbox` (
  `Support_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Subject` text NOT NULL,
  `Description` text NOT NULL,
  `Attachment` text DEFAULT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Readmsg` tinyint(1) NOT NULL DEFAULT 0,
  `Replied` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Support_ID`),
  KEY `supportbox_ibfk_1` (`User_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supportbox`
--

INSERT INTO `supportbox` (`Support_ID`, `User_ID`, `Subject`, `Description`, `Attachment`, `Date`, `Readmsg`, `Replied`) VALUES
(14, 5, 'Support Test', 'this is a test', 'Support_Attachments/Koala.jpg', '2020-01-05', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` text NOT NULL,
  `First_Name` text NOT NULL,
  `Last_Name` text NOT NULL,
  `Addres` text NOT NULL,
  `Password` text NOT NULL,
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `Email`, `First_Name`, `Last_Name`, `Addres`, `Password`) VALUES
(3, 'Test.mail@gmail.com', 'Steven', 'Sparks', 'genovasplittway ST. 235', '1234'),
(4, 'johnny@jomail.com', 'John', 'Jones', 'qwertyokm', 'GoldenExp10'),
(5, 'clayton.olaria@hotmail.com', 'Steven', 'Sparks', 'qwertyokmewhe', 'Test123');

-- --------------------------------------------------------

--
-- Table structure for table `userinbox`
--

DROP TABLE IF EXISTS `userinbox`;
CREATE TABLE IF NOT EXISTS `userinbox` (
  `Support_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Subject` text NOT NULL,
  `Msg` text NOT NULL,
  `Readmsg` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Support_ID`),
  KEY `userinbox_ibfk_1` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userinbox`
--

INSERT INTO `userinbox` (`Support_ID`, `User_ID`, `Date`, `Subject`, `Msg`, `Readmsg`) VALUES
(14, 5, '2020-01-05', 'Support Test(reply)', 'this is a test reply', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

DROP TABLE IF EXISTS `vendor`;
CREATE TABLE IF NOT EXISTS `vendor` (
  `Vendor_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Vendor_Name` text NOT NULL,
  `User_Name` text DEFAULT NULL,
  `Password` text DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `Phone_Number` int(15) DEFAULT NULL,
  PRIMARY KEY (`Vendor_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`Vendor_ID`, `Vendor_Name`, `User_Name`, `Password`, `Address`, `Phone_Number`) VALUES
(1, 'HP', 'hp', 'hp123', NULL, NULL),
(2, 'Samsung', NULL, NULL, NULL, NULL),
(3, 'Apple', NULL, NULL, NULL, NULL),
(4, 'LG', NULL, NULL, NULL, NULL),
(5, 'Simple Apparel', NULL, NULL, NULL, NULL),
(6, 'Walsunny ', NULL, NULL, NULL, NULL),
(7, 'Spalding', NULL, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`cat_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`Vendor_ID`) REFERENCES `vendor` (`Vendor_ID`) ON DELETE NO ACTION;

--
-- Constraints for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD CONSTRAINT `shoppingcart_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`) ON DELETE NO ACTION,
  ADD CONSTRAINT `shoppingcart_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE NO ACTION;

--
-- Constraints for table `supportbox`
--
ALTER TABLE `supportbox`
  ADD CONSTRAINT `supportbox_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE NO ACTION;

--
-- Constraints for table `userinbox`
--
ALTER TABLE `userinbox`
  ADD CONSTRAINT `userinbox_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
