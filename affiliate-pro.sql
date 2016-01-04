-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 23, 2015 at 09:29 PM
-- Server version: 5.6.23-cll-lve
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jdwebdes_apfresh`
--

-- --------------------------------------------------------

--
-- Table structure for table `ap_banners`
--

CREATE TABLE IF NOT EXISTS `ap_banners` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `filetype` varchar(50) NOT NULL,
  `adsize` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ap_banners`
--

INSERT INTO `ap_banners` (`id`, `filename`, `filetype`, `adsize`) VALUES
(3, 'aplogo.png', 'png', 0),
(4, '4246643106022989569.png', 'png', 4);

-- --------------------------------------------------------

--
-- Table structure for table `ap_commission_settings`
--

CREATE TABLE IF NOT EXISTS `ap_commission_settings` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `percentage` int(3) NOT NULL,
  `sales_from` decimal(10,2) NOT NULL,
  `sales_to` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `ap_commission_settings`
--

INSERT INTO `ap_commission_settings` (`id`, `percentage`, `sales_from`, `sales_to`) VALUES
(1, 5, '0.00', '200.00'),
(5, 12, '200.00', '201.00'),
(6, 15, '201.00', '202.00'),
(7, 20, '202.00', '299.00'),
(8, 3, '0.01', '50.00');

-- --------------------------------------------------------

--
-- Table structure for table `ap_earnings`
--

CREATE TABLE IF NOT EXISTS `ap_earnings` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(15) NOT NULL,
  `product` varchar(255) NOT NULL,
  `comission` int(3) NOT NULL,
  `sale_amount` decimal(8,2) NOT NULL,
  `net_earnings` decimal(8,2) NOT NULL,
  `recurring` varchar(15) NOT NULL,
  `recurring_fee` int(10) NOT NULL,
  `last_reoccurance` datetime NOT NULL,
  `stop_recurring` int(1) NOT NULL,
  `datetime` datetime NOT NULL,
  `void` int(1) NOT NULL,
  `refund` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ap_leads`
--

CREATE TABLE IF NOT EXISTS `ap_leads` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(15) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `epl` decimal(10,6) NOT NULL,
  `converted` int(1) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ap_members`
--

CREATE TABLE IF NOT EXISTS `ap_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `forgot_pin` varchar(255) NOT NULL,
  `forgot_key` varchar(60) NOT NULL,
  `terms` int(1) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `balance` decimal(20,6) NOT NULL,
  `sponsor` int(15) NOT NULL,
  `admin_user` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ap_members`
--

INSERT INTO `ap_members` (`id`, `username`, `fullname`, `email`, `password`, `forgot_pin`, `forgot_key`, `terms`, `browser`, `balance`, `sponsor`, `admin_user`) VALUES
(2, 'demo', 'John Doe', 'demos@joshuawebdesign.com', '$2y$10$5dEfCStEuUlB3k54ZDxqlOUwfT.3r3qYp12JNAnmVJPazQw.UP1ae', '', '', 1, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36', '0.000000', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ap_multi_tier_transactions`
--

CREATE TABLE IF NOT EXISTS `ap_multi_tier_transactions` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(15) NOT NULL,
  `transaction_id` int(15) NOT NULL,
  `tier` int(2) NOT NULL,
  `commission` int(3) NOT NULL,
  `mt_earnings` decimal(10,2) NOT NULL,
  `datetime` datetime NOT NULL,
  `reversed` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ap_other_commissions`
--

CREATE TABLE IF NOT EXISTS `ap_other_commissions` (
  `id` int(1) NOT NULL,
  `sv_on` int(1) NOT NULL,
  `cpc_on` int(1) NOT NULL,
  `rc_on` int(1) NOT NULL,
  `mt_on` int(1) NOT NULL,
  `epc` decimal(10,6) NOT NULL,
  `lc_on` int(1) NOT NULL,
  `epl` decimal(10,6) NOT NULL,
  `tier2` int(3) NOT NULL,
  `tier3` int(3) NOT NULL,
  `tier4` int(3) NOT NULL,
  `tier5` int(3) NOT NULL,
  `tier6` int(3) NOT NULL,
  `tier7` int(3) NOT NULL,
  `tier8` int(3) NOT NULL,
  `tier9` int(3) NOT NULL,
  `tier10` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ap_other_commissions`
--

INSERT INTO `ap_other_commissions` (`id`, `sv_on`, `cpc_on`, `rc_on`, `mt_on`, `epc`, `lc_on`, `epl`, `tier2`, `tier3`, `tier4`, `tier5`, `tier6`, `tier7`, `tier8`, `tier9`, `tier10`) VALUES
(1, 1, 1, 1, 1, '0.004000', 1, '1.000000', 4, 2, 1, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ap_payouts`
--

CREATE TABLE IF NOT EXISTS `ap_payouts` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(15) NOT NULL,
  `payment_method` int(1) NOT NULL,
  `payment_email` varchar(255) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zip` int(10) NOT NULL,
  `bn` varchar(255) NOT NULL,
  `an` varchar(255) NOT NULL,
  `rn` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ap_recurring_history`
--

CREATE TABLE IF NOT EXISTS `ap_recurring_history` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(15) NOT NULL,
  `transaction_id` int(15) NOT NULL,
  `recurring_earnings` decimal(10,2) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ap_referral_traffic`
--

CREATE TABLE IF NOT EXISTS `ap_referral_traffic` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(15) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `ip` varchar(60) NOT NULL,
  `host_name` varchar(255) NOT NULL,
  `landing_page` varchar(255) NOT NULL,
  `cpc_earnings` decimal(10,6) NOT NULL,
  `void` int(1) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ap_settings`
--

CREATE TABLE IF NOT EXISTS `ap_settings` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `site_email` varchar(255) NOT NULL,
  `default_commission` int(3) NOT NULL,
  `min_payout` decimal(8,2) NOT NULL,
  `currency_fmt` varchar(3) NOT NULL,
  `paypal` int(1) NOT NULL,
  `stripe` int(1) NOT NULL,
  `skrill` int(1) NOT NULL,
  `wire` int(1) NOT NULL,
  `checks` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ap_settings`
--

INSERT INTO `ap_settings` (`id`, `meta_title`, `meta_description`, `site_title`, `site_email`, `default_commission`, `min_payout`, `currency_fmt`, `paypal`, `stripe`, `skrill`, `wire`, `checks`) VALUES
(1, 'Affiliate Pro', 'Affiliate Pro | PHP Affiliate Tracking Software', 'Affiliate Pro', 'demos@jdwebdesigner.com', 10, '25.00', 'USD', 1, 1, 1, 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
