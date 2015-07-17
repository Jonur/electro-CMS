-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2013 at 10:11 AM
-- Server version: 5.6.11-log
-- PHP Version: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `electro`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `A_ID` varchar(20) NOT NULL,
  `A_TITLE` varchar(255) NOT NULL,
  `A_FURL` varchar(255) NOT NULL,
  `A_INFO` varchar(255) DEFAULT NULL,
  `MI_ID` varchar(20) NOT NULL,
  `A_BODY` text NOT NULL,
  `A_RANK` int(4) NOT NULL DEFAULT '0',
  `A_VISIBLE` tinyint(1) NOT NULL DEFAULT '1',
  `A_DIRECT` tinyint(1) NOT NULL DEFAULT '1',
  `A_DATEADDED` datetime DEFAULT NULL,
  `A_DELETED` tinyint(1) NOT NULL DEFAULT '0',
  `A_META_DESCRIPTION` varchar(160) DEFAULT NULL,
  `A_META_KEYWORDS` text,
  PRIMARY KEY (`A_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `articles-files`
--

CREATE TABLE IF NOT EXISTS `articles-files` (
  `A_ID` varchar(20) NOT NULL,
  `F_ID` varchar(20) NOT NULL,
  PRIMARY KEY (`A_ID`,`F_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `articles-galleries`
--

CREATE TABLE IF NOT EXISTS `articles-galleries` (
  `A_ID` varchar(20) NOT NULL,
  `G_ID` varchar(20) NOT NULL,
  PRIMARY KEY (`A_ID`,`G_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `articles-languages`
--

CREATE TABLE IF NOT EXISTS `articles-languages` (
  `A_ID` varchar(20) NOT NULL,
  `L_ID` varchar(20) NOT NULL,
  PRIMARY KEY (`A_ID`,`L_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `basic_settings`
--

CREATE TABLE IF NOT EXISTS `basic_settings` (
  `BS_ID` varchar(10) NOT NULL DEFAULT '',
  `BS_TITLE` varchar(255) NOT NULL,
  `BS_BASEPATH` varchar(255) DEFAULT NULL,
  `BS_FAVICO` varchar(255) DEFAULT NULL,
  `BS_DESCRIPTION` varchar(160) DEFAULT NULL,
  `BS_KEYWORDS` text,
  `BS_REVISIT_AFTER` enum('1 hour','1 day','7 days','1 month','1 year') NOT NULL DEFAULT '7 days',
  `BS_AUTHOR` varchar(255) DEFAULT NULL,
  `BS_DCTERMS_ABSTRACT` varchar(255) DEFAULT NULL,
  `BS_RATING` enum('general','mature','restricted','14 years','safe for kids') NOT NULL DEFAULT 'general',
  `BS_MS_VALIDATE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`BS_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `basic_settings`
--

INSERT INTO `basic_settings` (`BS_ID`, `BS_TITLE`, `BS_BASEPATH`, `BS_FAVICO`, `BS_DESCRIPTION`, `BS_KEYWORDS`, `BS_REVISIT_AFTER`, `BS_AUTHOR`, `BS_DCTERMS_ABSTRACT`, `BS_RATING`, `BS_MS_VALIDATE`) VALUES
('KNQJBHCHMI', 'IT Support, Web Solutions, Graphic Design, Corporate Identity', '', 'favicon.ico', '', '', '7 days', '', '', 'general', '');

-- --------------------------------------------------------

--
-- Table structure for table `contestants`
--

CREATE TABLE IF NOT EXISTS `contestants` (
  `C_ID` varchar(20) NOT NULL,
  `C_NAME` varchar(255) NOT NULL,
  `C_INFO` text NOT NULL,
  `C_URL` varchar(255) NOT NULL,
  PRIMARY KEY (`C_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `electro_log`
--

CREATE TABLE IF NOT EXISTS `electro_log` (
  `ELOG_ID` varchar(20) NOT NULL,
  `ELOG_DATE` datetime NOT NULL,
  `EU_ID` varchar(20) NOT NULL,
  `ELOG_ACTION` text NOT NULL,
  PRIMARY KEY (`ELOG_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `electro_release_notes`
--

CREATE TABLE IF NOT EXISTS `electro_release_notes` (
  `RN_VERSION` varchar(100) NOT NULL,
  `RN_DATE` date NOT NULL,
  `RN_INFO` text NOT NULL,
  PRIMARY KEY (`RN_VERSION`),
  UNIQUE KEY `RN_DATE` (`RN_DATE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `electro_release_notes`
--

INSERT INTO `electro_release_notes` (`RN_VERSION`, `RN_DATE`, `RN_INFO`) VALUES
('1.5', '2013-07-16', '<ul class = "rn">\n	<li>Βελτίωση στον τρόπο παρουσίασης των λιστών οντοτήτων.</li>\n	<li>Προσθήκη "Βασικών Ρυθμίσεων" για την ιστοσελίδα.</li>\n	<li>Βελτίωση των φορμών καταχώρησης και ανανέωσης οντοτήτων με προσθήκη Tooltip και προεπισκόπιση εικόνας.</li>\n	<li>Αλλαγή της οντότητας "Χρήστες Ιστότοπου".</li>\n	<li>Αλλαγή και εμπλουτισμός των "Ανανέωση RSS XML" και "Ανανέωση XML περιεχομένου".</li>\n	<li>Προσθήκη επιλογής προεπιλεγμένου Στοιχείου Μενού και Γλώσσας.</li>\n	<li>Προσθήκη γραμμής εργαλείων πάνω από τις λίστες οντοτήτων.</li>\n	<li>Γενική βελτίωση κώδικα και διόρθωση λαθών.</li>\n</ul>');

-- --------------------------------------------------------

--
-- Table structure for table `electro_users`
--

CREATE TABLE IF NOT EXISTS `electro_users` (
  `EU_ID` varchar(20) NOT NULL,
  `EU_USERNAME` varchar(100) NOT NULL,
  `EU_PASSWORD` varchar(255) NOT NULL,
  `EU_EMAIL` varchar(255) DEFAULT NULL,
  `EU_LEVEL` enum('0','1','2') NOT NULL DEFAULT '0',
  `EU_LASTLOGIN` datetime DEFAULT NULL,
  PRIMARY KEY (`EU_ID`),
  UNIQUE KEY `EU_USERNAME` (`EU_USERNAME`),
  UNIQUE KEY `EU_EMAIL` (`EU_EMAIL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `electro_users`
--

INSERT INTO `electro_users` (`EU_ID`, `EU_USERNAME`, `EU_PASSWORD`, `EU_EMAIL`, `EU_LEVEL`, `EU_LASTLOGIN`) VALUES
('g0IiZFSRcg', 'laxris', '21232f297a57a5a743894a0e4a801fc3', 'laxris@hotmail.com', '1', '0000-00-00 00:00:00'),
('S2nzfVnoXG', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'info@cmagnet.gr', '2', '2013-10-30 11:09:47'),
('TpRy1HeYD2', 'passases', 'd0b1f51cbb7cd78f8e0241a626963f7b', 'passases@yahoo.com', '0', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `F_ID` varchar(20) NOT NULL,
  `F_NAME` varchar(255) DEFAULT NULL,
  `F_FILENAME` varchar(255) NOT NULL,
  `F_FILETYPE` varchar(100) NOT NULL,
  `F_RANK` int(4) NOT NULL DEFAULT '0',
  `MI_ID` varchar(20) DEFAULT NULL,
  `F_DELETED` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`F_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE IF NOT EXISTS `galleries` (
  `G_ID` varchar(20) NOT NULL,
  `MI_ID` varchar(20) DEFAULT NULL,
  `G_RANK` int(4) DEFAULT '0',
  `G_VISIBLE` tinyint(1) NOT NULL DEFAULT '1',
  `G_DELETED` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`G_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `galleries-files`
--

CREATE TABLE IF NOT EXISTS `galleries-files` (
  `G_ID` varchar(20) NOT NULL,
  `F_ID` varchar(20) NOT NULL,
  `GF_RANK` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`G_ID`,`F_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `galleries-languages`
--

CREATE TABLE IF NOT EXISTS `galleries-languages` (
  `G_ID` varchar(20) NOT NULL,
  `L_ID` varchar(20) NOT NULL,
  `GL_ALIAS` varchar(255) NOT NULL,
  PRIMARY KEY (`G_ID`,`L_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `image_captions`
--

CREATE TABLE IF NOT EXISTS `image_captions` (
  `F_ID` varchar(20) NOT NULL,
  `L_ID` varchar(20) NOT NULL,
  `IC_ALIAS` varchar(255) NOT NULL,
  PRIMARY KEY (`F_ID`,`L_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `L_ID` varchar(20) NOT NULL,
  `L_NAME` varchar(255) NOT NULL,
  `L_ABBREVIATION` varchar(4) NOT NULL,
  `L_RANK` int(4) NOT NULL DEFAULT '0',
  `L_VISIBLE` tinyint(1) NOT NULL DEFAULT '1',
  `L_DEFAULT` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`L_ID`),
  UNIQUE KEY `L_NAME` (`L_NAME`),
  UNIQUE KEY `L_ABBREVIATION` (`L_ABBREVIATION`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`L_ID`, `L_NAME`, `L_ABBREVIATION`, `L_RANK`, `L_VISIBLE`, `L_DEFAULT`) VALUES
('4v7LNGw7ob', 'English', 'EN', 20, 1, 0),
('BNFZi5CEde', 'Italiano', 'IT', 40, 0, 0),
('dI16NAA9Kp', 'Norsk', 'NO', 90, 0, 0),
('gc7WnGXegM', 'Pу́сский', 'RU', 80, 0, 0),
('HGteXCKMwx', 'Português', 'PT', 70, 0, 0),
('KXcvoMzcfv', 'Español', 'ES', 50, 0, 0),
('sQDT0JNHxT', 'Français', 'FR', 30, 0, 0),
('UW0MYZiwRS', 'Ελληνικά', 'EL', 10, 1, 1),
('uWDn2ngrja', 'Deutsch', 'DE', 60, 0, 0),
('VYIyur0GcH', 'Svenska', 'SWE', 100, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu_groups`
--

CREATE TABLE IF NOT EXISTS `menu_groups` (
  `MG_ID` varchar(20) NOT NULL,
  `MG_RANK` int(4) NOT NULL DEFAULT '0',
  `MG_VISIBLE` tinyint(1) NOT NULL DEFAULT '1',
  `MG_DELETED` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`MG_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_groups-languages`
--

CREATE TABLE IF NOT EXISTS `menu_groups-languages` (
  `MG_ID` varchar(20) NOT NULL,
  `L_ID` varchar(20) NOT NULL,
  `MGL_ALIAS` varchar(255) NOT NULL,
  PRIMARY KEY (`MG_ID`,`L_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_groups-menu_items`
--

CREATE TABLE IF NOT EXISTS `menu_groups-menu_items` (
  `MG_ID` varchar(20) NOT NULL,
  `MI_ID` varchar(20) NOT NULL,
  PRIMARY KEY (`MG_ID`,`MI_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE IF NOT EXISTS `menu_items` (
  `MI_ID` varchar(20) NOT NULL,
  `MI_MOTHER` varchar(20) DEFAULT '0',
  `MI_RANK` int(4) NOT NULL DEFAULT '0',
  `MT_ID` varchar(20) NOT NULL,
  `MI_EXTRAINFO` varchar(255) DEFAULT NULL,
  `MI_PHOTO` varchar(255) DEFAULT NULL,
  `MI_VISIBLE` tinyint(1) NOT NULL DEFAULT '1',
  `MI_DELETED` tinyint(1) NOT NULL DEFAULT '0',
  `MI_DEFAULT` tinyint(1) NOT NULL DEFAULT '0',
  `MI_META_DESCRIPTION` varchar(160) DEFAULT NULL,
  `MI_META_KEYWORDS` text,
  PRIMARY KEY (`MI_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items-languages`
--

CREATE TABLE IF NOT EXISTS `menu_items-languages` (
  `MI_ID` varchar(20) NOT NULL,
  `L_ID` varchar(20) NOT NULL,
  `MIL_ALIAS` varchar(255) NOT NULL,
  `MIL_FURL` varchar(255) NOT NULL,
  PRIMARY KEY (`MI_ID`,`L_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_types`
--

CREATE TABLE IF NOT EXISTS `menu_types` (
  `MT_ID` varchar(20) NOT NULL,
  `MT_TYPE` varchar(255) NOT NULL,
  PRIMARY KEY (`MT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_types`
--

INSERT INTO `menu_types` (`MT_ID`, `MT_TYPE`) VALUES
('8BPTpENdPB', 'Άρθρα'),
('EKatjWfxOt', 'Γκαλερί'),
('ZgdFQVeUSS', 'Φόρμες'),
('ZS4z2y9E5F', 'Αρχεία');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_members`
--

CREATE TABLE IF NOT EXISTS `newsletter_members` (
  `NM_ID` varchar(20) NOT NULL,
  `NM_NAME` varchar(255) DEFAULT NULL,
  `NM_SURNAME` varchar(255) DEFAULT NULL,
  `NM_EMAIL` varchar(255) NOT NULL,
  `NM_TEL` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`NM_ID`),
  UNIQUE KEY `NM_EMAIL` (`NM_EMAIL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE IF NOT EXISTS `polls` (
  `P_ID` varchar(20) NOT NULL,
  `P_TITLE` varchar(255) NOT NULL,
  `P_INFO` text,
  `P_STARTDATE` date DEFAULT NULL,
  `P_ENDDATE` date DEFAULT NULL,
  PRIMARY KEY (`P_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `polls-contestants`
--

CREATE TABLE IF NOT EXISTS `polls-contestants` (
  `P_ID` varchar(20) NOT NULL,
  `C_ID` varchar(20) NOT NULL,
  `PC_VOTES` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`P_ID`,`C_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poll_voters`
--

CREATE TABLE IF NOT EXISTS `poll_voters` (
  `P_ID` varchar(20) NOT NULL,
  `NM_EMAIL` varchar(255) NOT NULL,
  `PV_COUNT` smallint(1) NOT NULL DEFAULT '0',
  `PV_CODE` varchar(100) DEFAULT NULL,
  `C_ID` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`P_ID`,`NM_EMAIL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `website_users`
--

CREATE TABLE IF NOT EXISTS `website_users` (
  `WU_ID` varchar(20) NOT NULL,
  `WU_USERNAME` varchar(100) NOT NULL,
  `WU_PASSWORD` varchar(255) NOT NULL,
  `WU_BRANDNAME` varchar(255) DEFAULT NULL,
  `WU_FNAME` varchar(255) DEFAULT NULL,
  `WU_LNAME` varchar(255) DEFAULT NULL,
  `WU_ADDRESS` varchar(255) DEFAULT NULL,
  `WU_ZIPCODE` varchar(100) DEFAULT NULL,
  `WU_CITY` varchar(255) DEFAULT NULL,
  `WU_COUNTRY` varchar(255) DEFAULT NULL,
  `WU_TEL` varchar(100) DEFAULT NULL,
  `WU_CEL` varchar(100) DEFAULT NULL,
  `WU_FAX` varchar(100) DEFAULT NULL,
  `WU_EMAIL` varchar(255) NOT NULL,
  `WU_AFM` varchar(255) DEFAULT NULL,
  `WU_COMMENTS` text,
  `WU_DATESTART` date DEFAULT NULL,
  `WU_DATEEXPIRE` date DEFAULT NULL,
  `WU_LASTLOGIN` datetime DEFAULT NULL,
  `WU_ACTIVE` tinyint(1) NOT NULL DEFAULT '1',
  `WU_DELETED` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`WU_ID`),
  UNIQUE KEY `WU_USERNAME` (`WU_USERNAME`),
  UNIQUE KEY `WU_EMAIL` (`WU_EMAIL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
