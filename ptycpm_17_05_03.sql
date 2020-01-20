-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 03, 2017 at 12:29 PM
-- Server version: 5.6.13
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ptycpm`
--
CREATE DATABASE IF NOT EXISTS `ngthucco_ptycpm` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ngthucco_ptycpm`;

-- --------------------------------------------------------

--
-- Table structure for table `borrow_device`
--

CREATE TABLE IF NOT EXISTS `borrow_device` (
  `idBorrowDevice` int(255) NOT NULL AUTO_INCREMENT,
  `idDevice` int(255) NOT NULL,
  `idProject` int(255) NOT NULL,
  `totalBorrow` int(255) NOT NULL,
  PRIMARY KEY (`idBorrowDevice`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `borrow_device_detail`
--

CREATE TABLE IF NOT EXISTS `borrow_device_detail` (
  `idBorrowDeviceDetail` int(255) NOT NULL AUTO_INCREMENT,
  `idUser` varchar(20) NOT NULL,
  `statusBorrow` char(1) DEFAULT NULL,
  `dateBorrow` datetime DEFAULT NULL,
  `dateReturn` datetime DEFAULT NULL,
  PRIMARY KEY (`idBorrowDeviceDetail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `device_info`
--

CREATE TABLE IF NOT EXISTS `device_info` (
  `idDevice` int(255) NOT NULL AUTO_INCREMENT,
  `idProducer` int(255) NOT NULL,
  `urlImg` longtext NOT NULL,
  `nameDevice` varchar(255) NOT NULL,
  `status` varchar(128) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `pricing` int(255) DEFAULT NULL,
  `total` int(128) NOT NULL,
  `borrow_temp` int(255) DEFAULT NULL,
  `dateImport` datetime NOT NULL,
  `description` longtext NOT NULL,
  `displayDevice` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idDevice`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `idImg` int(11) NOT NULL AUTO_INCREMENT,
  `url` longtext COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `dateUploaded` datetime NOT NULL,
  PRIMARY KEY (`idImg`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `lab_info`
--

CREATE TABLE IF NOT EXISTS `lab_info` (
  `idLab` int(255) NOT NULL AUTO_INCREMENT,
  `nameLab` varchar(255) NOT NULL,
  `unit` longtext NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `location` longtext,
  PRIMARY KEY (`idLab`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `idOption` int(255) NOT NULL AUTO_INCREMENT,
  `nameOption` varchar(255) NOT NULL,
  `valueOption` longtext,
  `statusOption` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idOption`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`idOption`, `nameOption`, `valueOption`, `statusOption`) VALUES
(0, 'siteIcon', 'view/icon/default/admin-icon.png', NULL),
(1, 'nameSite', 'Hệ thống quản lý thiết bị nhúng', NULL),
(2, 'descriptionSite', 'Hệ thống quản lý thiết bị nhúng', NULL),
(3, 'keyword', 'IoT,Embedded,Hệ thống quản lý thiết bị nhúng,ĐH Cần Thơ, Khoa CNTT&TT,ptycpm,Phân tích yêu cầu phần mềm,CT241,Thiết bị nhúng', NULL),
(4, 'goAna', 'UA-84266655-1', NULL),
(5, 'footerSite', 'Copyright © 2017 - Product of Team 5.', NULL),
(6, 'limitBorrow', '15', NULL),
(7, 'avatarDefault', 'view/icon/default/user.png', NULL),
(8, 'iconDefault', 'view/icon/default/admin-icon.png', NULL),
(9, 'imgDeviceDefault', 'view/icon/default/40118655-chip-wallpapers.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `partner_info`
--

CREATE TABLE IF NOT EXISTS `partner_info` (
  `idProducer` int(255) NOT NULL AUTO_INCREMENT,
  `nameProducer` varchar(255) NOT NULL,
  `service` varchar(128) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`idProducer`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_info`
--

CREATE TABLE IF NOT EXISTS `project_info` (
  `idProject` int(255) NOT NULL AUTO_INCREMENT,
  `idLab` int(255) NOT NULL,
  `nameProject` varchar(255) NOT NULL,
  `nameUser` varchar(128) NOT NULL,
  `nameStaff` varchar(255) NOT NULL,
  `dateStart` datetime NOT NULL,
  PRIMARY KEY (`idProject`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_info_detail`
--

CREATE TABLE IF NOT EXISTS `project_info_detail` (
  `idDetailProject` int(255) NOT NULL AUTO_INCREMENT,
  `idProject` int(255) NOT NULL,
  `idUser` varchar(20) NOT NULL,
  PRIMARY KEY (`idDetailProject`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles_cp`
--

CREATE TABLE IF NOT EXISTS `roles_cp` (
  `idRole` int(12) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(255) NOT NULL,
  `rolesGroup` longtext NOT NULL,
  `roleDesc` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `roles_cp`
--

INSERT INTO `roles_cp` (`idRole`, `roleName`, `rolesGroup`, `roleDesc`) VALUES
(1, 'Owner', 'fullcontrol,device,borrowDevice,members,project,labs,profile,search,dashboard,account,mailCP,urlCP,addDevice,removeDevice,addMember,removeMember,addProject,removeProject,addLabs,removeLab,addPartner,removePartner,deviceCP,borrowDeviceCP,membersCP,projectCP,labsCP,producerCP,imagesCP,rolesCP,profileCP,rolesAD,settingCP', 'Tất cả quyền'),
(2, 'Admin', 'fullcontrol,device,borrowDevice,members,project,labs,profile,search,dashboard,addDevice,removeDevice,addMember,removeMember,addProject,removeProject,addLabs,removeLab,addPartner,removePartner,deviceCP,borrowDeviceCP,membersCP,projectCP,labsCP,producerCP,imagesCP,rolesCP,profileCP', 'Tất cả quyền (trừ quyền cài đặt và quản lý nhóm quyền)'),
(3, 'Member', 'device,borrowDevice,members,project,labs,profile,search', 'Chỉ nhóm quyền xem và không truy cập AdminCP'),
(4, 'Manager', 'device,borrowDevice,members,project,labs,profile,search,dashboard,addDevice,addMember,addProject,addLabs,addPartner,deviceCP,borrowDeviceCP,membersCP,projectCP,labsCP,producerCP', 'Nhóm quyền xem, quyền quản lý cơ bản'),
(6, 'Deny', 'profile', 'Bị cấm toàn hệ thống');

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE IF NOT EXISTS `user_auth` (
  `idUser` varchar(20) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `roleName` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1',
  `dateCreate` datetime NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_auth`
--

INSERT INTO `user_auth` (`idUser`, `pwd`, `email`, `roleName`, `status`, `dateCreate`) VALUES
('2678', '123123', 'hqnghi@cit.ctu.edu.vn', 'Manager', '1', '2017-05-01 08:29:28'),
('2709', '123123', 'tvhoang@cit.ctu.edu.vn', 'Owner', '1', '2017-05-01 08:29:28'),
('B1400696', '123123', 'khanhb1400696@student.ctu.edu.vn', 'Admin', '0', '2017-05-01 08:29:28'),
('B1400700', '123123', 'langb1400700@student.ctu.edu.vn', 'Deny', '1', '2017-05-01 08:29:28'),
('B1400704', '123123', 'luanb1400704@student.ctu.edu.vn', 'Admin', '1', '2017-05-01 08:29:28'),
('B1400706', '123123', 'minhb1400706@student.ctu.edu.vn', 'Member', '1', '2017-05-01 08:29:28'),
('B1400713', '123123', 'nhutb1400713@student.ctu.edu.vn', 'Member', '0', '2017-05-01 08:29:28'),
('B1400729', '123123', 'thob1400729@student.ctu.edu.vn', 'Member', '1', '2017-05-01 08:29:28'),
('admin', '123123', 'admin@student.ctu.edu.vn', 'Admin', '1', '2017-05-01 08:29:28'),
('B1400734', '123123', 'toanb1400734@student.ctu.edu.vn', 'Deny', '1', '2017-05-01 08:29:28'),
('B1400797', '123123', 'tiepb1400797@student.ctu.edu.vn', 'Member', '1', '2017-05-01 08:29:29'),
('tester', '123123', 'tester@test.dev', 'Admin', '1', '2017-05-01 11:04:51'),
('tester3', '123123', 'testerss@test.dev', 'Admin', '0', '2017-05-01 11:06:45');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `idUser` varchar(20) NOT NULL,
  `urlImg` longtext NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `social` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `type` char(1) NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`idUser`, `urlImg`, `fullName`, `phone`, `email`, `website`, `social`, `address`, `position`, `level`, `unit`, `type`) VALUES
('2678', 'view/icon/default/user.png', 'Huỳnh Quang Nghi', '0919191919', 'hqnghi@cit.ctu.edu.vn', 'không có', 'không có', 'ĐH Cần Thơ', 'Giảng viên', 'Tiến sĩ', 'Khoa CNTT&TT', '1'),
('2709', 'view/icon/default/user.png', 'Trần Văn Hoàng', '0909090909', 'tvhoang@cit.ctu.edu.vn', 'không có', 'không có', 'Xuân Khánh, Cần Thơ', 'Giảng viên', 'Thạc sĩ', 'BM Công nghệ phần mềm', '1'),
('B1400704', 'view/icon/default/user.png', 'Lê Minh Luân', '0977177771', 'luanb1400704@student.ctu.edu.vn', 'không có', 'không có', 'ĐH Cần Thơ', 'Thực tập sinh', 'Đại học', 'Khoa CNTT&TT', '0'),
('B1400706', 'view/icon/default/user.png', 'Nguyễn Thiện Minh', '01676776677', 'minhb1400706@student.ctu.edu.vn', 'không có', 'không có', 'ĐH Cần Thơ', 'Thực tập sinh', 'Đại học', 'Khoa CNTT&TT', '0'),
('admin', 'view/icon/default/user.png', 'Admin', '01234567890', 'admin@student.ctu.edu.vn', 'https://ngthuc.com/', 'https://fb.com/lenguyenthuc/', 'Hưng Lợi, Cần Thơ', 'Thực tập sinh', 'Đại học', 'BM Công nghệ phần mềm', '0'),
('B1400797', 'view/icon/default/user.png', 'Trác Mẫn Tiệp', '01677889911', 'tiepb1400797@student.ctu.edu.vn', 'không có', 'không có', 'ĐH Cần Thơ', 'Thực tập sinh', 'Đại học', 'Khoa CNTT&TT', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
