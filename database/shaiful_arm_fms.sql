-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2016 at 10:25 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fms_history`
--

INSERT INTO `fms_history` (`id`, `controller`, `table_id`, `table_name`, `data`, `user_id`, `action`, `date`) VALUES
(1, 'sys_user_role', 2, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":2,"user_group_id":"2","user_created":"1","date_created":1480740873}', '1', 'INSERT', 1480740873),
(2, 'sys_user_role', 3, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":3,"user_group_id":"2","user_created":"1","date_created":1480740873}', '1', 'INSERT', 1480740873),
(3, 'sys_user_role', 4, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":4,"user_group_id":"2","user_created":"1","date_created":1480740873}', '1', 'INSERT', 1480740873),
(4, 'sys_user_role', 5, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":5,"user_group_id":"2","user_created":"1","date_created":1480740873}', '1', 'INSERT', 1480740873),
(5, 'sys_user_role', 6, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":6,"user_group_id":"2","user_created":"1","date_created":1480740873}', '1', 'INSERT', 1480740873),
(6, 'sys_user_role', 7, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":2,"user_group_id":"1","user_created":"1","date_created":1480740903}', '1', 'INSERT', 1480740903),
(7, 'sys_user_role', 8, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":3,"user_group_id":"1","user_created":"1","date_created":1480740903}', '1', 'INSERT', 1480740903),
(8, 'sys_user_role', 9, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":4,"user_group_id":"1","user_created":"1","date_created":1480740903}', '1', 'INSERT', 1480740903),
(9, 'sys_user_role', 10, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":5,"user_group_id":"1","user_created":"1","date_created":1480740903}', '1', 'INSERT', 1480740903),
(10, 'sys_user_role', 11, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":6,"user_group_id":"1","user_created":"1","date_created":1480740903}', '1', 'INSERT', 1480740903),
(11, 'sys_assign_user_group', 2, 'fms_system_assigned_group', '{"user_id":"2","user_group":"2","user_created":"1","date_created":1480740935,"revision":1}', '1', 'INSERT', 1480740935),
(12, 'sys_assign_user_group', 3, 'fms_system_assigned_group', '{"user_id":"94","user_group":"2","user_created":"1","date_created":1480740944,"revision":1}', '1', 'INSERT', 1480740944),
(13, 'sys_module_task', 33, 'fms_system_task', '{"name":"Setup","type":"MODULE","parent":"0","controller":"","ordering":"2","status":"Active","user_created":"94","date_created":1480741106}', '94', 'INSERT', 1480741106),
(14, 'sys_module_task', 34, 'fms_system_task', '{"name":"File Category","type":"TASK","parent":"33","controller":"None","ordering":"1","status":"Active","user_created":"94","date_created":1480741206}', '94', 'INSERT', 1480741206),
(15, 'sys_module_task', 35, 'fms_system_task', '{"name":"File Class","type":"TASK","parent":"33","controller":"None","ordering":"2","status":"Active","user_created":"94","date_created":1480741261}', '94', 'INSERT', 1480741261),
(16, 'sys_module_task', 36, 'fms_system_task', '{"name":"File Type","type":"TASK","parent":"33","controller":"None","ordering":"3","status":"Active","user_created":"94","date_created":1480741283}', '94', 'INSERT', 1480741283),
(17, 'sys_module_task', 37, 'fms_system_task', '{"name":"File Name","type":"TASK","parent":"33","controller":"None","ordering":"4","status":"Active","user_created":"94","date_created":1480741300}', '94', 'INSERT', 1480741300),
(18, 'sys_module_task', 38, 'fms_system_task', '{"name":"Hardcopy Location","type":"TASK","parent":"33","controller":"None","ordering":"5","status":"Active","user_created":"94","date_created":1480741331}', '94', 'INSERT', 1480741331),
(19, 'sys_module_task', 39, 'fms_system_task', '{"name":"Assign File to User","type":"TASK","parent":"33","controller":"None","ordering":"6","status":"Active","user_created":"94","date_created":1480741356}', '94', 'INSERT', 1480741356),
(20, 'sys_user_role', 12, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":2,"user_group_id":"2","user_created":"94","date_created":1480741467}', '94', 'INSERT', 1480741467),
(21, 'sys_user_role', 13, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":3,"user_group_id":"2","user_created":"94","date_created":1480741467}', '94', 'INSERT', 1480741467),
(22, 'sys_user_role', 14, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":4,"user_group_id":"2","user_created":"94","date_created":1480741467}', '94', 'INSERT', 1480741467),
(23, 'sys_user_role', 15, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":5,"user_group_id":"2","user_created":"94","date_created":1480741467}', '94', 'INSERT', 1480741467),
(24, 'sys_user_role', 16, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":6,"user_group_id":"2","user_created":"94","date_created":1480741467}', '94', 'INSERT', 1480741467),
(25, 'sys_user_role', 17, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":34,"user_group_id":"2","user_created":"94","date_created":1480741467}', '94', 'INSERT', 1480741467),
(26, 'sys_user_role', 18, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":35,"user_group_id":"2","user_created":"94","date_created":1480741467}', '94', 'INSERT', 1480741467),
(27, 'sys_user_role', 19, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":36,"user_group_id":"2","user_created":"94","date_created":1480741467}', '94', 'INSERT', 1480741467),
(28, 'sys_user_role', 20, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":37,"user_group_id":"2","user_created":"94","date_created":1480741467}', '94', 'INSERT', 1480741467),
(29, 'sys_user_role', 21, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":38,"user_group_id":"2","user_created":"94","date_created":1480741467}', '94', 'INSERT', 1480741467),
(30, 'sys_user_role', 22, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":39,"user_group_id":"2","user_created":"94","date_created":1480741467}', '94', 'INSERT', 1480741467),
(31, 'sys_module_task', 40, 'fms_system_task', '{"name":"Task","type":"MODULE","parent":"0","controller":"","ordering":"3","status":"Active","user_created":"94","date_created":1480741497}', '94', 'INSERT', 1480741497),
(32, 'sys_module_task', 40, 'fms_system_task', '{"name":"Tasks","type":"MODULE","parent":"0","controller":"","ordering":"3","status":"Active","user_updated":"94","date_updated":1480741506}', '94', 'UPDATE', 1480741506),
(33, 'sys_module_task', 41, 'fms_system_task', '{"name":"File Upload","type":"TASK","parent":"40","controller":"None","ordering":"1","status":"Active","user_created":"94","date_created":1480741552}', '94', 'INSERT', 1480741552),
(34, 'sys_module_task', 42, 'fms_system_task', '{"name":"Report","type":"MODULE","parent":"0","controller":"","ordering":"4","status":"Active","user_created":"94","date_created":1480741573}', '94', 'INSERT', 1480741573),
(35, 'sys_module_task', 43, 'fms_system_task', '{"name":"File View","type":"TASK","parent":"42","controller":"None","ordering":"1","status":"Active","user_created":"94","date_created":1480741594}', '94', 'INSERT', 1480741594),
(36, 'sys_user_role', 23, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":2,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(37, 'sys_user_role', 24, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":3,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(38, 'sys_user_role', 25, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":4,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(39, 'sys_user_role', 26, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":5,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(40, 'sys_user_role', 27, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":6,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(41, 'sys_user_role', 28, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":34,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(42, 'sys_user_role', 29, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":35,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(43, 'sys_user_role', 30, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":36,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(44, 'sys_user_role', 31, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":37,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(45, 'sys_user_role', 32, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":38,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(46, 'sys_user_role', 33, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":39,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(47, 'sys_user_role', 34, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":41,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(48, 'sys_user_role', 35, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":43,"user_group_id":"2","user_created":"94","date_created":1480741605}', '94', 'INSERT', 1480741605),
(49, 'sys_user_role', 36, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":2,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(50, 'sys_user_role', 37, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":3,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(51, 'sys_user_role', 38, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":4,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(52, 'sys_user_role', 39, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":5,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(53, 'sys_user_role', 40, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":6,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(54, 'sys_user_role', 41, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":34,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(55, 'sys_user_role', 42, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":35,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(56, 'sys_user_role', 43, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":36,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(57, 'sys_user_role', 44, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":37,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(58, 'sys_user_role', 45, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":38,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(59, 'sys_user_role', 46, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":39,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(60, 'sys_user_role', 47, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":41,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(61, 'sys_user_role', 48, 'fms_system_user_group_role', '{"action0":1,"action1":1,"action2":1,"action3":1,"action4":1,"action5":1,"action6":1,"task_id":43,"user_group_id":"1","user_created":"1","date_created":1480741763}', '1', 'INSERT', 1480741763),
(62, 'sys_module_task', 34, 'fms_system_task', '{"name":"File Category","type":"TASK","parent":"33","controller":"Setup_file_category","ordering":"1","status":"Active","user_updated":"94","date_updated":1480754757}', '94', 'UPDATE', 1480754757),
(63, 'setup_file_category', 1, 'fms_setup_file_category', '{"name":"Bank Check","ordering":"1","user_created":"94","date_created":1480755723}', '94', 'INSERT', 1480755723),
(64, 'setup_file_category', 1, 'fms_setup_file_category', '{"name":"Bank Check New","ordering":"1","user_updated":"94","date_updated":1480755934}', '94', 'UPDATE', 1480755934),
(65, 'setup_file_category', 2, 'fms_setup_file_category', '{"name":"My Test 1","ordering":"99","user_created":"94","date_created":1480755981}', '94', 'INSERT', 1480755981),
(66, 'setup_file_category', 3, 'fms_setup_file_category', '{"name":"My Test 2","ordering":"99","user_created":"94","date_created":1480755994}', '94', 'INSERT', 1480755994),
(67, 'setup_file_category', 4, 'fms_setup_file_category', '{"name":"My Test 3","ordering":"99","user_created":"94","date_created":1480756001}', '94', 'INSERT', 1480756001),
(68, 'setup_file_category', 4, 'fms_setup_file_category', '{"name":"My Test 3","ordering":"99","user_updated":"94","date_updated":1480756010}', '94', 'UPDATE', 1480756010),
(69, 'setup_file_category', 5, 'fms_setup_file_category', '{"name":"My Test 4","ordering":"99","user_created":"94","date_created":1480756018}', '94', 'INSERT', 1480756018);

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
-- Table structure for table `fms_setup_file_category`
--

CREATE TABLE IF NOT EXISTS `fms_setup_file_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'Active',
  `ordering` tinyint(4) NOT NULL DEFAULT '99',
  `date_created` int(11) NOT NULL,
  `user_created` int(11) NOT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fms_setup_file_category`
--

INSERT INTO `fms_setup_file_category` (`id`, `name`, `status`, `ordering`, `date_created`, `user_created`, `date_updated`, `user_updated`) VALUES
(1, 'Bank Check New', 'Active', 1, 1480755723, 94, 1480755934, 94),
(2, 'My Test 1', 'Active', 99, 1480755981, 94, NULL, NULL),
(3, 'My Test 2', 'Active', 99, 1480755994, 94, NULL, NULL),
(4, 'My Test 3', 'Active', 99, 1480756001, 94, 1480756010, 94),
(5, 'My Test 4', 'Active', 99, 1480756018, 94, NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fms_system_assigned_group`
--

INSERT INTO `fms_system_assigned_group` (`id`, `user_id`, `user_group`, `revision`, `date_created`, `user_created`) VALUES
(1, 1, 1, 1, 1480737271, 1),
(2, 2, 2, 1, 1480740935, 1),
(3, 94, 2, 1, 1480740944, 1);

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
(34, 'File Category', 'TASK', 33, 'Setup_file_category', 1, 'menu.png', 'Active', 1480741206, 94, 1480754757, 94),
(35, 'File Class', 'TASK', 33, 'None', 2, 'menu.png', 'Active', 1480741261, 94, NULL, NULL),
(36, 'File Type', 'TASK', 33, 'None', 3, 'menu.png', 'Active', 1480741283, 94, NULL, NULL),
(37, 'File Name', 'TASK', 33, 'None', 4, 'menu.png', 'Active', 1480741300, 94, NULL, NULL),
(38, 'Hardcopy Location', 'TASK', 33, 'None', 5, 'menu.png', 'Active', 1480741331, 94, NULL, NULL),
(39, 'Assign File to User', 'TASK', 33, 'None', 6, 'menu.png', 'Active', 1480741356, 94, NULL, NULL),
(40, 'Tasks', 'MODULE', 0, '', 3, 'menu.png', 'Active', 1480741497, 94, 1480741506, 94),
(41, 'File Upload', 'TASK', 40, 'None', 1, 'menu.png', 'Active', 1480741552, 94, NULL, NULL),
(42, 'Report', 'MODULE', 0, '', 4, 'menu.png', 'Active', 1480741573, 94, NULL, NULL),
(43, 'File View', 'TASK', 42, 'None', 1, 'menu.png', 'Active', 1480741594, 94, NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fms_system_user_group`
--

INSERT INTO `fms_system_user_group` (`id`, `name`, `status`, `ordering`, `date_created`, `user_created`, `date_updated`, `user_updated`) VALUES
(1, 'Super Admin', 'Active', 1, 1480737271, 1, NULL, NULL),
(2, 'Admin', 'Active', 2, 1480737271, 1, NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fms_system_user_group_role`
--

INSERT INTO `fms_system_user_group_role` (`id`, `user_group_id`, `task_id`, `action0`, `action1`, `action2`, `action3`, `action4`, `action5`, `action6`, `revision`, `date_created`, `user_created`) VALUES
(1, 1, 3, 1, 1, 1, 1, 1, 1, 1, 3, 1480737271, 1),
(2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 3, 1480740873, 1),
(3, 2, 3, 1, 1, 1, 1, 1, 1, 1, 3, 1480740873, 1),
(4, 2, 4, 1, 1, 1, 1, 1, 1, 1, 3, 1480740873, 1),
(5, 2, 5, 1, 1, 1, 1, 1, 1, 1, 3, 1480740873, 1),
(6, 2, 6, 1, 1, 1, 1, 1, 1, 1, 3, 1480740873, 1),
(7, 1, 2, 1, 1, 1, 1, 1, 1, 1, 2, 1480740903, 1),
(8, 1, 3, 1, 1, 1, 1, 1, 1, 1, 2, 1480740903, 1),
(9, 1, 4, 1, 1, 1, 1, 1, 1, 1, 2, 1480740903, 1),
(10, 1, 5, 1, 1, 1, 1, 1, 1, 1, 2, 1480740903, 1),
(11, 1, 6, 1, 1, 1, 1, 1, 1, 1, 2, 1480740903, 1),
(12, 2, 2, 1, 1, 1, 1, 1, 1, 1, 2, 1480741467, 94),
(13, 2, 3, 1, 1, 1, 1, 1, 1, 1, 2, 1480741467, 94),
(14, 2, 4, 1, 1, 1, 1, 1, 1, 1, 2, 1480741467, 94),
(15, 2, 5, 1, 1, 1, 1, 1, 1, 1, 2, 1480741467, 94),
(16, 2, 6, 1, 1, 1, 1, 1, 1, 1, 2, 1480741467, 94),
(17, 2, 34, 1, 1, 1, 1, 1, 1, 1, 2, 1480741467, 94),
(18, 2, 35, 1, 1, 1, 1, 1, 1, 1, 2, 1480741467, 94),
(19, 2, 36, 1, 1, 1, 1, 1, 1, 1, 2, 1480741467, 94),
(20, 2, 37, 1, 1, 1, 1, 1, 1, 1, 2, 1480741467, 94),
(21, 2, 38, 1, 1, 1, 1, 1, 1, 1, 2, 1480741467, 94),
(22, 2, 39, 1, 1, 1, 1, 1, 1, 1, 2, 1480741467, 94),
(23, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(24, 2, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(25, 2, 4, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(26, 2, 5, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(27, 2, 6, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(28, 2, 34, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(29, 2, 35, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(30, 2, 36, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(31, 2, 37, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(32, 2, 38, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(33, 2, 39, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(34, 2, 41, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(35, 2, 43, 1, 1, 1, 1, 1, 1, 1, 1, 1480741605, 94),
(36, 1, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(37, 1, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(38, 1, 4, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(39, 1, 5, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(40, 1, 6, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(41, 1, 34, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(42, 1, 35, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(43, 1, 36, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(44, 1, 37, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(45, 1, 38, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(46, 1, 39, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(47, 1, 41, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1),
(48, 1, 43, 1, 1, 1, 1, 1, 1, 1, 1, 1480741763, 1);

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
-- Indexes for table `fms_setup_file_category`
--
ALTER TABLE `fms_setup_file_category`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fms_history`
--
ALTER TABLE `fms_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `fms_history_hack`
--
ALTER TABLE `fms_history_hack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fms_setup_file_category`
--
ALTER TABLE `fms_setup_file_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fms_system_assigned_group`
--
ALTER TABLE `fms_system_assigned_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fms_system_user_group_role`
--
ALTER TABLE `fms_system_user_group_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
