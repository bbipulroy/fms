-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2017 at 07:17 AM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shaiful_arm_fms`
--

-- --------------------------------------------------------

--
-- Table structure for table `fms_history`
--

CREATE TABLE IF NOT EXISTS `fms_history` (
  `id` int(11) NOT NULL,
  `controller` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `table_id` int(11) NOT NULL,
  `table_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_history_hack`
--

CREATE TABLE IF NOT EXISTS `fms_history_hack` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `controller` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Active',
  `action_id` int(11) DEFAULT '99',
  `other_info` text COLLATE utf8_unicode_ci,
  `date_created` int(11) DEFAULT '0',
  `date_created_string` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_setup_assign_file_user_group`
--

CREATE TABLE IF NOT EXISTS `fms_setup_assign_file_user_group` (
  `id` int(11) NOT NULL,
  `user_group_id` int(11) DEFAULT NULL,
  `id_file` int(11) DEFAULT NULL,
  `action1` tinyint(1) NOT NULL,
  `action2` tinyint(1) NOT NULL,
  `action3` tinyint(1) NOT NULL,
  `status` varchar(10) DEFAULT 'Active',
  `user_created` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fms_setup_file_category`
--

CREATE TABLE IF NOT EXISTS `fms_setup_file_category` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `status` varchar(15) DEFAULT 'Active',
  `ordering` tinyint(4) DEFAULT '99',
  `remarks` text,
  `date_created` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fms_setup_file_class`
--

CREATE TABLE IF NOT EXISTS `fms_setup_file_class` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `status` varchar(15) DEFAULT 'Active',
  `ordering` tinyint(4) DEFAULT '99',
  `remarks` text,
  `date_created` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fms_setup_file_hc_location`
--

CREATE TABLE IF NOT EXISTS `fms_setup_file_hc_location` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(11) DEFAULT 'Active',
  `ordering` tinyint(4) DEFAULT '99',
  `remarks` text,
  `date_created` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fms_setup_file_name`
--

CREATE TABLE IF NOT EXISTS `fms_setup_file_name` (
  `id` int(11) NOT NULL,
  `name` text,
  `id_type` int(11) DEFAULT NULL,
  `id_hc_location` int(11) DEFAULT NULL,
  `date_start` int(11) DEFAULT NULL,
  `date_end` int(11) DEFAULT NULL,
  `status` varchar(15) DEFAULT 'Active',
  `ordering` tinyint(4) DEFAULT '99',
  `remarks` text,
  `id_office` int(11) DEFAULT NULL,
  `id_department` int(11) DEFAULT NULL,
  `employee_responsible` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fms_setup_file_type`
--

CREATE TABLE IF NOT EXISTS `fms_setup_file_type` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `id_class` int(11) DEFAULT NULL,
  `status` varchar(15) DEFAULT 'Active',
  `ordering` tinyint(4) DEFAULT '99',
  `remarks` text,
  `date_created` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fms_system_assigned_group`
--

CREATE TABLE IF NOT EXISTS `fms_system_assigned_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_group` int(11) NOT NULL,
  `revision` int(4) NOT NULL DEFAULT '1',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fms_system_assigned_group`
--

INSERT INTO `fms_system_assigned_group` (`id`, `user_id`, `user_group`, `revision`, `date_created`, `user_created`) VALUES
(1, 1, 1, 1, 1480737271, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fms_system_site_offline`
--

CREATE TABLE IF NOT EXISTS `fms_system_site_offline` (
  `id` int(11) NOT NULL,
  `status` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_system_task`
--

CREATE TABLE IF NOT EXISTS `fms_system_task` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'TASK',
  `parent` int(11) NOT NULL DEFAULT '0',
  `controller` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `ordering` smallint(6) NOT NULL DEFAULT '9999',
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'menu.png',
  `status` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fms_system_task`
--

INSERT INTO `fms_system_task` (`id`, `name`, `type`, `parent`, `controller`, `ordering`, `icon`, `status`, `date_created`, `user_created`, `date_updated`, `user_updated`) VALUES
(1, 'System Settings', 'MODULE', 0, '', 1, 'menu.png', 'Active', 1480737271, 1, NULL, NULL),
(2, 'Module & Task', 'TASK', 1, 'Sys_module_task', 1, 'menu.png', 'Active', 1480737271, 1, NULL, NULL),
(3, 'User Role', 'TASK', 1, 'Sys_user_role', 2, 'menu.png', 'Active', 1480737271, 1, NULL, NULL),
(4, 'User Group', 'TASK', 1, 'Sys_user_group', 3, 'menu.png', 'Active', 1480737271, 1, NULL, NULL),
(5, 'Assign User To Group', 'TASK', 1, 'Sys_assign_user_group', 4, 'menu.png', 'Active', 1480737271, 1, NULL, NULL),
(6, 'Site Offline', 'TASK', 1, 'Sys_site_offline', 5, 'menu.png', 'Active', 1480737271, 1, NULL, NULL),
(33, 'Setup', 'MODULE', 0, '', 2, 'menu.png', 'Active', 1480741106, 94, NULL, NULL),
(34, 'File Category', 'TASK', 33, 'Setup_file_category', 1, 'menu.png', 'Active', 1480741206, 94, 1483328034, 2),
(35, 'File Class', 'TASK', 33, 'Setup_file_class', 2, 'menu.png', 'Active', 1480741261, 94, 1483329287, 2),
(36, 'File Type', 'TASK', 33, 'Setup_file_type', 3, 'menu.png', 'Active', 1480741283, 94, 1483329293, 2),
(37, 'File Name', 'TASK', 33, 'Setup_file_name', 4, 'menu.png', 'Active', 1480741300, 94, 1483329299, 2),
(38, 'Hardcopy Location', 'TASK', 33, 'Setup_file_hc_location', 5, 'menu.png', 'Active', 1480741331, 94, 1480926874, 94),
(39, 'Assign File to User Group', 'TASK', 33, 'Setup_assign_file_user_group', 6, 'menu.png', 'Active', 1480741356, 94, 1481172281, 94),
(40, 'Tasks', 'MODULE', 0, '', 3, 'menu.png', 'Active', 1480741497, 94, 1480741506, 94),
(41, 'File Entry', 'TASK', 40, 'Tasks_file_entry', 1, 'menu.png', 'Active', 1480741552, 94, 1482544391, 94),
(42, 'Report', 'MODULE', 0, '', 4, 'menu.png', 'Active', 1480741573, 94, NULL, NULL),
(43, 'File View', 'TASK', 42, 'Report_file_view', 1, 'menu.png', 'Active', 1480741594, 94, 1483948860, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fms_system_user_group`
--

CREATE TABLE IF NOT EXISTS `fms_system_user_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `ordering` tinyint(4) NOT NULL DEFAULT '99',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fms_system_user_group`
--

INSERT INTO `fms_system_user_group` (`id`, `name`, `status`, `ordering`, `date_created`, `user_created`, `date_updated`, `user_updated`) VALUES
(1, 'Super Admin', 'Active', 1, 1480737271, 1, NULL, NULL),
(2, 'Admin', 'Active', 1, 1480737271, 1, 1481010826, 94),
(3, 'Accounting - General', 'Active', 2, 1481010819, 94, 1481010858, 94),
(4, 'Accounting - Check', 'Active', 3, 1481010887, 94, NULL, NULL),
(5, 'For Test', 'Active', 4, 1482047999, 94, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fms_system_user_group_role`
--

CREATE TABLE IF NOT EXISTS `fms_system_user_group_role` (
  `id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `action0` tinyint(2) DEFAULT '0',
  `action1` tinyint(2) DEFAULT '0',
  `action2` tinyint(2) DEFAULT '0',
  `action3` tinyint(2) DEFAULT '0',
  `action4` tinyint(2) DEFAULT '0',
  `action5` tinyint(2) DEFAULT '0',
  `action6` tinyint(2) DEFAULT '0',
  `revision` int(11) NOT NULL DEFAULT '1',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=137 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fms_system_user_group_role`
--

INSERT INTO `fms_system_user_group_role` (`id`, `user_group_id`, `task_id`, `action0`, `action1`, `action2`, `action3`, `action4`, `action5`, `action6`, `revision`, `date_created`, `user_created`) VALUES
(1, 1, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(2, 1, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(3, 1, 4, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(4, 1, 5, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(5, 1, 6, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(6, 1, 34, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(7, 1, 35, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(8, 1, 36, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(9, 1, 37, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(10, 1, 38, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(11, 1, 39, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(12, 1, 41, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(13, 1, 43, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fms_tasks_digital_file`
--

CREATE TABLE IF NOT EXISTS `fms_tasks_digital_file` (
  `id` int(11) NOT NULL,
  `name` text,
  `id_file_name` int(11) DEFAULT NULL,
  `mime_type` text,
  `remarks` text,
  `status` varchar(10) DEFAULT 'Active',
  `date_entry` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fms_history`
--
ALTER TABLE `fms_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_history_hack`
--
ALTER TABLE `fms_history_hack`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_setup_assign_file_user_group`
--
ALTER TABLE `fms_setup_assign_file_user_group`
  ADD PRIMARY KEY (`id`), ADD KEY `user_group_id` (`user_group_id`);

--
-- Indexes for table `fms_setup_file_category`
--
ALTER TABLE `fms_setup_file_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_setup_file_class`
--
ALTER TABLE `fms_setup_file_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_setup_file_hc_location`
--
ALTER TABLE `fms_setup_file_hc_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_setup_file_name`
--
ALTER TABLE `fms_setup_file_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_setup_file_type`
--
ALTER TABLE `fms_setup_file_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_system_assigned_group`
--
ALTER TABLE `fms_system_assigned_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_system_site_offline`
--
ALTER TABLE `fms_system_site_offline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_system_task`
--
ALTER TABLE `fms_system_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_system_user_group`
--
ALTER TABLE `fms_system_user_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_system_user_group_role`
--
ALTER TABLE `fms_system_user_group_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_tasks_digital_file`
--
ALTER TABLE `fms_tasks_digital_file`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fms_history`
--
ALTER TABLE `fms_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fms_history_hack`
--
ALTER TABLE `fms_history_hack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fms_setup_assign_file_user_group`
--
ALTER TABLE `fms_setup_assign_file_user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fms_setup_file_category`
--
ALTER TABLE `fms_setup_file_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fms_setup_file_class`
--
ALTER TABLE `fms_setup_file_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fms_setup_file_hc_location`
--
ALTER TABLE `fms_setup_file_hc_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fms_setup_file_name`
--
ALTER TABLE `fms_setup_file_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fms_setup_file_type`
--
ALTER TABLE `fms_setup_file_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fms_system_assigned_group`
--
ALTER TABLE `fms_system_assigned_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fms_system_site_offline`
--
ALTER TABLE `fms_system_site_offline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fms_system_task`
--
ALTER TABLE `fms_system_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `fms_system_user_group`
--
ALTER TABLE `fms_system_user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fms_system_user_group_role`
--
ALTER TABLE `fms_system_user_group_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=137;
--
-- AUTO_INCREMENT for table `fms_tasks_digital_file`
--
ALTER TABLE `fms_tasks_digital_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
