-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2012 at 07:28 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_address`
--

CREATE TABLE IF NOT EXISTS `rrtable_address` (
  `addressID` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL DEFAULT '0',
  `houseNum` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `street` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `zip` int(5) NOT NULL DEFAULT '12345',
  PRIMARY KEY (`addressID`),
  KEY `userID` (`userID`),
  KEY `zip` (`zip`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rrtable_address`
--

INSERT INTO `rrtable_address` (`addressID`, `userID`, `houseNum`, `street`, `zip`) VALUES
(1, 1, '4284', 'Steep Rd', 54501);

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_billing`
--

CREATE TABLE IF NOT EXISTS `rrtable_billing` (
  `billID` int(10) NOT NULL AUTO_INCREMENT,
  `orderID` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`billID`),
  KEY `orderID` (`orderID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_cart`
--

CREATE TABLE IF NOT EXISTS `rrtable_cart` (
  `userID` int(10) NOT NULL DEFAULT '0',
  `prodID` int(10) NOT NULL DEFAULT '0',
  `quantity` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`,`prodID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rrtable_cart`
--

INSERT INTO `rrtable_cart` (`userID`, `prodID`, `quantity`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_citystate`
--

CREATE TABLE IF NOT EXISTS `rrtable_citystate` (
  `zip` int(5) NOT NULL DEFAULT '12345',
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`zip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rrtable_citystate`
--

INSERT INTO `rrtable_citystate` (`zip`, `city`, `state`) VALUES
(54501, 'Rhinelander', 'WI');

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_name`
--

CREATE TABLE IF NOT EXISTS `rrtable_name` (
  `userID` int(10) NOT NULL DEFAULT '0',
  `first` varchar(50) NOT NULL,
  `last` varchar(50) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rrtable_name`
--

INSERT INTO `rrtable_name` (`userID`, `first`, `last`) VALUES
(1, 'Jordan', 'Rhode');

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_order`
--

CREATE TABLE IF NOT EXISTS `rrtable_order` (
  `orderID` int(10) NOT NULL AUTO_INCREMENT,
  `transID` int(10) NOT NULL DEFAULT '0',
  `orderDate` date NOT NULL DEFAULT '0000-00-00',
  `sAddressID` int(10) NOT NULL DEFAULT '0',
  `sZip` int(5) NOT NULL DEFAULT '12345',
  `bAddressID` int(10) NOT NULL DEFAULT '0',
  `bZip` int(5) NOT NULL DEFAULT '12345',
  `subtotal` float NOT NULL DEFAULT '0',
  `shipCost` float NOT NULL DEFAULT '0',
  `tax` float NOT NULL DEFAULT '0',
  `total` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`orderID`,`transID`),
  KEY `sAddressID` (`sAddressID`),
  KEY `sZip` (`sZip`),
  KEY `bAddressID` (`bAddressID`),
  KEY `bZip` (`bZip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_shipping`
--

CREATE TABLE IF NOT EXISTS `rrtable_shipping` (
  `shipID` int(10) NOT NULL AUTO_INCREMENT,
  `orderID` int(10) NOT NULL DEFAULT '0',
  `dateShipped` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`shipID`),
  KEY `orderID` (`orderID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_transactions`
--

CREATE TABLE IF NOT EXISTS `rrtable_transactions` (
  `transID` int(10) NOT NULL DEFAULT '0',
  `lineNum` int(10) NOT NULL DEFAULT '0',
  `userID` int(10) NOT NULL DEFAULT '0',
  `prodID` int(10) NOT NULL DEFAULT '0',
  `quantity` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transID`,`lineNum`,`userID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_user`
--

CREATE TABLE IF NOT EXISTS `rrtable_user` (
  `userID` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(15) DEFAULT '000-000-0000',
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userID` (`userID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rrtable_user`
--

INSERT INTO `rrtable_user` (`userID`, `email`, `password`, `phone`) VALUES
(1, 'rhode.jordan@gmail.com', 'R4niAhBJXFSPU', '715-555-1234');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rrtable_address`
--
ALTER TABLE `rrtable_address`
  ADD CONSTRAINT `rrtable_address_ibfk_2` FOREIGN KEY (`zip`) REFERENCES `rrtable_citystate` (`zip`),
  ADD CONSTRAINT `rrtable_address_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `rrtable_user` (`userID`);

--
-- Constraints for table `rrtable_billing`
--
ALTER TABLE `rrtable_billing`
  ADD CONSTRAINT `rrtable_billing_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `rrtable_order` (`orderID`);

--
-- Constraints for table `rrtable_cart`
--
ALTER TABLE `rrtable_cart`
  ADD CONSTRAINT `rrtable_cart_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `rrtable_user` (`userID`);

--
-- Constraints for table `rrtable_name`
--
ALTER TABLE `rrtable_name`
  ADD CONSTRAINT `rrtable_name_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `rrtable_user` (`userID`);

--
-- Constraints for table `rrtable_order`
--
ALTER TABLE `rrtable_order`
  ADD CONSTRAINT `rrtable_order_ibfk_1` FOREIGN KEY (`sAddressID`) REFERENCES `rrtable_address` (`addressID`),
  ADD CONSTRAINT `rrtable_order_ibfk_2` FOREIGN KEY (`sZip`) REFERENCES `rrtable_citystate` (`zip`),
  ADD CONSTRAINT `rrtable_order_ibfk_3` FOREIGN KEY (`bAddressID`) REFERENCES `rrtable_address` (`addressID`),
  ADD CONSTRAINT `rrtable_order_ibfk_4` FOREIGN KEY (`bZip`) REFERENCES `rrtable_citystate` (`zip`);

--
-- Constraints for table `rrtable_shipping`
--
ALTER TABLE `rrtable_shipping`
  ADD CONSTRAINT `rrtable_shipping_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `rrtable_order` (`orderID`);

--
-- Constraints for table `rrtable_transactions`
--
ALTER TABLE `rrtable_transactions`
  ADD CONSTRAINT `rrtable_transactions_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `rrtable_user` (`userID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
