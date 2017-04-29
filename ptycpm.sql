-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2017 at 10:31 AM
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
  `total` int(255) NOT NULL,
  PRIMARY KEY (`idBorrowDevice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `borrow_device_detail`
--

CREATE TABLE IF NOT EXISTS `borrow_device_detail` (
  `idBorrowDeviceDetail` int(255) NOT NULL AUTO_INCREMENT,
  `idBorrowDevice` int(255) NOT NULL,
  `idUser` varchar(20) NOT NULL,
  `dateBorrow` datetime NOT NULL,
  `dateReturn` datetime DEFAULT NULL,
  PRIMARY KEY (`idBorrowDeviceDetail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `device_info`
--

CREATE TABLE IF NOT EXISTS `device_info` (
  `idDevice` int(255) NOT NULL AUTO_INCREMENT,
  `idProducer` int(255) NOT NULL,
  `idImg` int(11) NOT NULL,
  `nameDevice` varchar(255) NOT NULL,
  `status` varchar(128) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `pricing` int(255) NOT NULL,
  `total` int(128) NOT NULL,
  `dateImport` datetime NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`idDevice`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `device_info`
--

INSERT INTO `device_info` (`idDevice`, `idProducer`, `idImg`, `nameDevice`, `status`, `currency`, `pricing`, `total`, `dateImport`, `description`) VALUES
(1, 1, 1, 'Arduino ESP8266', 'Rất tốt', 'cái', 0, 100, '2017-04-29 00:00:00', 'Mạch nhúng nền tảng Arduino với kêt nối wifi bằng ESP 8266'),
(2, 1, 3, 'Relay 1 kênh', 'Rất tốt', 'cái', 0, 200, '2017-04-29 00:00:00', 'Relay 1 kênh, chức năng như công tắc một thiết bị'),
(3, 1, 3, 'NanoPC', 'Rất tốt', 'cái', 0, 20, '2017-04-29 00:00:00', 'Máy tính nhúng loại nhỏ, cấu hình khá, dùng cho nhiều công việc khác nhau');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`idImg`, `url`, `type`, `size`, `dateUploaded`) VALUES
(1, 'view/images/arduino.jpg', 'jpg', 75516, '2017-04-27 11:34:50'),
(2, 'view/images/nanopc.jpg', 'jpg', 94690, '2017-04-27 11:38:52'),
(3, 'view/images/relay.jpg', 'jpg', 76988, '2017-04-27 11:38:52'),
(4, 'view/images/nanopc.jpg', 'jpg', 94690, '2017-04-27 11:38:52'),
(5, 'view/images/relay.jpg', 'jpg', 76988, '2017-04-27 11:38:52'),
(6, 'view/images/10406613_780239582049618_8993255793532770531_n.jpg', 'jpg', 75481, '2017-04-27 14:13:54'),
(7, 'view/images/397223_480437501989313_1569799592_n_zpswawrpjqt.jpg', 'jpg', 72017, '2017-04-27 14:20:25'),
(8, 'view/images/397223_480437501989313_1569799592_n_zpswawrpjqt.jpg', 'jpg', 72017, '2017-04-27 14:21:35'),
(9, 'view/images/13266110_268194050199807_7747286166517989092_n.jpg', 'jpg', 81382, '2017-04-27 14:27:19'),
(10, 'view/images/6935849763_2dc2b6d68d_b.jpg', 'jpg', 2032264, '2017-04-27 14:27:41'),
(11, 'view/images/6789712628_397f199f0c_b.jpg', 'jpg', 204336, '2017-04-27 14:28:49'),
(12, 'view/images/12064345676_f2c20fc113_k.jpg', 'jpg', 1079482, '2017-04-27 14:39:06'),
(14, 'view/images/397223_480437501989313_1569799592_n_zpswawrpjqt.jpg', 'jpg', 72017, '2017-04-27 14:55:59'),
(15, 'view/images/6789727848_2604928cb0_b.jpg', 'jpg', 257566, '2017-04-27 14:56:14'),
(16, 'view/images/6789751646_fc1aa3c492_b.jpg', 'jpg', 281928, '2017-04-27 14:56:33'),
(17, 'view/images/397223_480437501989313_1569799592_n_zpswawrpjqt.jpg', 'jpg', 72017, '2017-04-27 15:02:06'),
(18, 'view/images/397223_480437501989313_1569799592_n_zpswawrpjqt.jpg', 'jpg', 72017, '2017-04-27 15:06:25'),
(19, 'view/images/10406613_780239582049618_8993255793532770531_n.jpg', 'jpg', 75481, '2017-04-27 15:06:25'),
(20, 'view/images/10645282_787378618002381_7125152812983723406_n.jpg', 'jpg', 28897, '2017-04-27 15:06:25'),
(21, 'view/images/13266110_268194050199807_7747286166517989092_n.jpg', 'jpg', 81382, '2017-04-27 15:06:25'),
(22, 'view/images/6789702260_989292e8ff_z.jpg', 'jpg', 180369, '2017-04-27 15:06:25'),
(23, 'view/images/6789712628_397f199f0c_b.jpg', 'jpg', 204336, '2017-04-27 15:06:25'),
(24, 'view/images/6789727848_2604928cb0_b.jpg', 'jpg', 257566, '2017-04-27 15:06:25'),
(25, 'view/images/6789751646_fc1aa3c492_b.jpg', 'jpg', 281928, '2017-04-27 15:06:25'),
(26, 'view/images/397223_480437501989313_1569799592_n_zpswawrpjqt.jpg', 'jpg', 72017, '2017-04-28 21:59:05'),
(27, 'view/images/397223_480437501989313_1569799592_n_zpswawrpjqt.jpg', 'jpg', 72017, '2017-04-29 08:57:20'),
(28, 'view/images/397223_480437501989313_1569799592_n_zpswawrpjqt.jpg', 'jpg', 72017, '2017-04-29 08:57:40'),
(29, 'view/images/397223_480437501989313_1569799592_n_zpswawrpjqt.jpg', 'jpg', 72017, '2017-04-29 08:58:03'),
(30, 'view/images/10406613_780239582049618_8993255793532770531_n.jpg', 'jpg', 75481, '2017-04-29 12:15:21'),
(31, 'view/images/6789751646_fc1aa3c492_b.jpg', 'jpg', 281928, '2017-04-29 12:16:43'),
(32, 'view/images/arduino.jpg', 'jpg', 75516, '2017-04-29 12:44:58'),
(33, 'view/images/arduino.jpg', 'jpg', 75516, '2017-04-29 12:45:45');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lab_info`
--

INSERT INTO `lab_info` (`idLab`, `nameLab`, `unit`, `phone`, `address`, `location`) VALUES
(1, 'PTN Phân tích hiệu năng phần mềm', 'BM Công nghệ phần mềm', '07103711777', 'Khoa CNTT&TT', 'không có'),
(2, 'PTN Hệ thống thông tin tích hợp', 'BM Hệ thống thông tin', '07103712711', 'Khoa CNTT&TT', 'không có'),
(3, 'PTN Mạng di động', 'BM Mạng máy tính và truyền thông', '07103712712', 'Khoa CNTT&TT', 'không có'),
(4, 'PTN Chuyên sâu', 'Phòng Quản lý CSVC', '07103777111', 'Trường ĐH Cần Thơ', 'không có');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `idOption` int(255) NOT NULL,
  `nameOption` varchar(255) NOT NULL,
  `valueOption` longtext,
  `statusOption` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idOption`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`idOption`, `nameOption`, `valueOption`, `statusOption`) VALUES
(1, 'nameSite', 'Hệ thống quản lý thiết bị nhúng', NULL),
(2, 'descriptionSite', 'Hệ thống quản lý thiết bị nhúng', NULL),
(3, 'keyword', 'IoT,Embedded,Hệ thống quản lý thiết bị nhúng,ĐH Cần Thơ, Khoa CNTT&TT,ptycpm,Phân tích yêu cầu phần mềm,CT241,Thiết bị nhúng', NULL),
(4, 'goAna', 'UA-84266655-1', NULL),
(5, 'footerSite', 'Copyright © 2017 - Product of Team 5.', NULL),
(6, 'siteIcon', 'view/icon/admin-icon.png', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `partner_info`
--

INSERT INTO `partner_info` (`idProducer`, `nameProducer`, `service`, `address`, `phone`, `email`) VALUES
(1, 'Hshop', 'Linh kiện', 'TP Hồ Chí Minh', '01234567890', 'sales@hshop.vn'),
(2, 'Fablab Cần Thơ', 'Phòng Lab', 'Cần Thơ', '07103771117', 'technical@fablabcantho.org');

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

--
-- Dumping data for table `project_info`
--

INSERT INTO `project_info` (`idProject`, `idLab`, `nameProject`, `nameUser`, `nameStaff`, `dateStart`) VALUES
(1, 0, 'Hệ thống Theo dõi Thời tiết khoa CNTT&TT', 'Huỳnh Quang Nghi', 'Tự nghiên cứu', '2017-04-29 00:00:00'),
(2, 0, 'Giải pháp Điều khiển Nhà ở qua Wifi', 'Trần Văn Hoàng', 'Tự nghiên cứu', '2017-04-25 00:00:00'),
(3, 0, 'Hệ thống Theo dõi Môi trường Ao nuôi cá', 'Lê Minh Luân', 'Trần Văn Hoàng', '2017-04-27 00:00:00'),
(4, 1, 'Hệ thống phân tích mã nhị phân', 'Nguyễn Thiện Minh', 'Trần Văn Hoàng', '2017-04-28 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `project_info_detail`
--

CREATE TABLE IF NOT EXISTS `project_info_detail` (
  `idDetailProject` int(255) NOT NULL AUTO_INCREMENT,
  `idProject` int(255) NOT NULL,
  `idUser` varchar(20) NOT NULL,
  PRIMARY KEY (`idDetailProject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `roles_cp`
--

INSERT INTO `roles_cp` (`idRole`, `roleName`, `rolesGroup`, `roleDesc`) VALUES
(1, 'Owner', 'fullcontrol,device,borrowDevice,members,project,labs,profile,search,adminCP,addDevice,removeDevice,addMember,removeMember,addProject,removeProject,addLabs,removeLab,addPartner,removePartner,deviceCP,borrowDeviceCP,membersCP,projectCP,labsCP,partnerCP,imagesCP,rolesCP,profileCP,rolesAD,settingCP', 'Tất cả quyền'),
(2, 'Admin', 'fullcontrol,device,borrowDevice,members,project,labs,profile,search,adminCP,addDevice,removeDevice,addMember,removeMember,addProject,removeProject,addLabs,removeLab,addPartner,removePartner,deviceCP,borrowDeviceCP,membersCP,projectCP,labsCP,partnerCP,imagesCP,rolesCP,profileCP', 'Tất cả quyền (trừ quyền cài đặt và quản lý nhóm quyền)'),
(3, 'Member', 'device,borrowDevice,members,project,labs,profile,search', 'Chỉ nhóm quyền xem và không truy cập AdminCP'),
(4, 'Manager', 'device,borrowDevice,members,project,labs,profile,search,adminCP,addDevice,addMember,addProject,addLabs,addPartner,deviceCP,borrowDeviceCP,membersCP,projectCP,labsCP,partnerCP', 'Nhóm quyền xem, quyền quản lý cơ bản');

-- --------------------------------------------------------

--
-- Table structure for table `staff_user`
--

CREATE TABLE IF NOT EXISTS `staff_user` (
  `idStaff` varchar(20) NOT NULL,
  `idUser` varchar(20) NOT NULL,
  PRIMARY KEY (`idStaff`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_user`
--

CREATE TABLE IF NOT EXISTS `student_user` (
  `idStudent` varchar(20) NOT NULL,
  `idUser` varchar(20) NOT NULL,
  PRIMARY KEY (`idStudent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE IF NOT EXISTS `user_auth` (
  `idUser` varchar(20) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rolesName` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_auth`
--

INSERT INTO `user_auth` (`idUser`, `pwd`, `email`, `rolesName`, `status`) VALUES
('2678', '123456', 'hqnghi@cit.ctu.edu.vn', 'Admin', '1'),
('2709', 'tvhoang', 'tvhoang@cit.ctu.edu.vn', 'Owner', '1'),
('B1400704', '123456', 'luanb1400704@student.ctu.edu.vn', 'Admin', '1'),
('B1400706', '123456', 'minhb1400706@student.ctu.edu.vn', 'Admin', '1'),
('B1400731', '123456', 'thucb1400731@student.ctu.edu.vn', 'Admin', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `idUser` varchar(20) NOT NULL,
  `idImg` int(11) NOT NULL,
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

INSERT INTO `user_info` (`idUser`, `idImg`, `fullName`, `phone`, `email`, `website`, `social`, `address`, `position`, `level`, `unit`, `type`) VALUES
('2678', 20, 'Huỳnh Quang Nghi', '0919191919', 'hqnghi@cit.ctu.edu.vn', 'không có', 'không có', 'ĐH Cần Thơ', 'Giảng viên', 'Tiến sĩ', 'Khoa CNTT&TT', '1'),
('2709', 31, 'Trần Văn Hoàng', '0909090909', 'tvhoang@cit.ctu.edu.vn', 'không có', 'không có', 'Xuân Khánh, Cần Thơ', 'Giảng viên', 'Thạc sĩ', 'BM Công nghệ phần mềm', '1'),
('B1400704', 20, 'Lê Minh Luân', '0977177771', 'luanb1400704@student.ctu.edu.vn', 'không có', 'không có', 'ĐH Cần Thơ', 'Thực tập sinh', 'Đại học', 'Khoa CNTT&TT', '0'),
('B1400706', 20, 'Nguyễn Thiện Minh', '01676776677', 'minhb1400706@student.ctu.edu.vn', 'không có', 'không có', 'ĐH Cần Thơ', 'Thực tập sinh', 'Đại học', 'Khoa CNTT&TT', '0'),
('B1400731', 19, 'Lê Nguyên Thức', '01678911202', 'thucb1400731@student.ctu.edu.vn', 'https://ngthuc.com/', 'https://fb.com/lenguyenthuc/', 'Hưng Lợi, Cần Thơ', 'Thực tập sinh', 'Đại học', 'BM Công nghệ phần mềm', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
