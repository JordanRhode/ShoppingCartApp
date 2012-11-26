-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2012 at 11:45 PM
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
  `houseNum` varchar(30) NOT NULL,
  `street` varchar(50) NOT NULL,
  `zip` int(5) NOT NULL DEFAULT '12345',
  PRIMARY KEY (`addressID`),
  KEY `userID` (`userID`),
  KEY `zip` (`zip`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rrtable_address`
--

INSERT INTO `rrtable_address` (`addressID`, `userID`, `houseNum`, `street`, `zip`) VALUES
(1, 1, '7691', 'Carver School Rd', 53120);

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_billing`
--

CREATE TABLE IF NOT EXISTS `rrtable_billing` (
  `billID` int(10) NOT NULL AUTO_INCREMENT,
  `addressID` int(10) NOT NULL DEFAULT '0',
  `orderID` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`billID`),
  KEY `addressID` (`addressID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_cart`
--

CREATE TABLE IF NOT EXISTS `rrtable_cart` (
  `userID` int(10) NOT NULL DEFAULT '0',
  `prodID` int(10) NOT NULL DEFAULT '0',
  `quantity` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`,`prodID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_citystate`
--

CREATE TABLE IF NOT EXISTS `rrtable_citystate` (
  `zip` int(5) NOT NULL DEFAULT '12345',
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`zip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rrtable_citystate`
--

INSERT INTO `rrtable_citystate` (`zip`, `city`, `state`) VALUES
(53120, 'East Troy', 'Wisconsin');

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_name`
--

CREATE TABLE IF NOT EXISTS `rrtable_name` (
  `userID` int(10) NOT NULL DEFAULT '0',
  `first` varchar(50) NOT NULL,
  `last` varchar(50) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rrtable_name`
--

INSERT INTO `rrtable_name` (`userID`, `first`, `last`) VALUES
(1, 'Peter', 'Rose');

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_order`
--

CREATE TABLE IF NOT EXISTS `rrtable_order` (
  `orderID` int(10) NOT NULL AUTO_INCREMENT,
  `transID` int(10) NOT NULL DEFAULT '0',
  `orderDate` date NOT NULL DEFAULT '0000-00-00',
  `shipID` int(10) NOT NULL DEFAULT '0',
  `billID` int(10) NOT NULL DEFAULT '0',
  `subtotal` float NOT NULL DEFAULT '0',
  `shipCost` float NOT NULL DEFAULT '0',
  `total` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`orderID`,`transID`),
  KEY `billID` (`billID`),
  KEY `shipID` (`shipID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_shipping`
--

CREATE TABLE IF NOT EXISTS `rrtable_shipping` (
  `shipID` int(10) NOT NULL AUTO_INCREMENT,
  `addressID` int(10) NOT NULL DEFAULT '0',
  `orderID` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`shipID`),
  KEY `addressID` (`addressID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_transactions`
--

CREATE TABLE IF NOT EXISTS `rrtable_transactions` (
  `transID` int(10) NOT NULL DEFAULT '0',
  `lineNum` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL DEFAULT '0',
  `prodID` int(10) NOT NULL DEFAULT '0',
  `quantity` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transID`,`lineNum`,`userID`),
  KEY `userID` (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rrtable_user`
--

CREATE TABLE IF NOT EXISTS `rrtable_user` (
  `userID` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(15) DEFAULT '000-000-0000',
  `numTransactions` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userID` (`userID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rrtable_user`
--

INSERT INTO `rrtable_user` (`userID`, `email`, `password`, `phone`, `numTransactions`) VALUES
(1, 'rosepeter24@gmail.com', 'R4Y.dNd5FfkFs', '262-206-7491', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
