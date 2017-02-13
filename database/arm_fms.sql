-- MySQL dump 10.13  Distrib 5.6.24, for Win32 (x86)
--
-- Host: localhost    Database: arm_fms
-- ------------------------------------------------------
-- Server version	5.6.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `fms_setup_assign_file_user_group`
--

DROP TABLE IF EXISTS `fms_setup_assign_file_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_setup_assign_file_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) DEFAULT NULL,
  `id_file` int(11) DEFAULT NULL,
  `action0` tinyint(1) DEFAULT '0',
  `action1` tinyint(1) DEFAULT '0',
  `action2` tinyint(1) DEFAULT '0',
  `action3` tinyint(1) DEFAULT '0',
  `revision` tinyint(1) NOT NULL DEFAULT '1',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_created` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_group_id` (`user_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_setup_assign_file_user_group`
--

LOCK TABLES `fms_setup_assign_file_user_group` WRITE;
/*!40000 ALTER TABLE `fms_setup_assign_file_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `fms_setup_assign_file_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_setup_file_category`
--

DROP TABLE IF EXISTS `fms_setup_file_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_setup_file_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `status` varchar(15) DEFAULT 'Active',
  `ordering` tinyint(4) DEFAULT '99',
  `remarks` text,
  `date_created` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_setup_file_category`
--

LOCK TABLES `fms_setup_file_category` WRITE;
/*!40000 ALTER TABLE `fms_setup_file_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `fms_setup_file_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_setup_file_class`
--

DROP TABLE IF EXISTS `fms_setup_file_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_setup_file_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `status` varchar(15) DEFAULT 'Active',
  `ordering` tinyint(4) DEFAULT '99',
  `remarks` text,
  `date_created` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_setup_file_class`
--

LOCK TABLES `fms_setup_file_class` WRITE;
/*!40000 ALTER TABLE `fms_setup_file_class` DISABLE KEYS */;
/*!40000 ALTER TABLE `fms_setup_file_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_setup_file_hc_location`
--

DROP TABLE IF EXISTS `fms_setup_file_hc_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_setup_file_hc_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(11) DEFAULT 'Active',
  `ordering` tinyint(4) DEFAULT '99',
  `remarks` text,
  `date_created` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_setup_file_hc_location`
--

LOCK TABLES `fms_setup_file_hc_location` WRITE;
/*!40000 ALTER TABLE `fms_setup_file_hc_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `fms_setup_file_hc_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_setup_file_name`
--

DROP TABLE IF EXISTS `fms_setup_file_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_setup_file_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_setup_file_name`
--

LOCK TABLES `fms_setup_file_name` WRITE;
/*!40000 ALTER TABLE `fms_setup_file_name` DISABLE KEYS */;
/*!40000 ALTER TABLE `fms_setup_file_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_setup_file_type`
--

DROP TABLE IF EXISTS `fms_setup_file_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_setup_file_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `id_class` int(11) DEFAULT NULL,
  `status` varchar(15) DEFAULT 'Active',
  `ordering` tinyint(4) DEFAULT '99',
  `remarks` text,
  `date_created` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_setup_file_type`
--

LOCK TABLES `fms_setup_file_type` WRITE;
/*!40000 ALTER TABLE `fms_setup_file_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `fms_setup_file_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_system_assigned_group`
--

DROP TABLE IF EXISTS `fms_system_assigned_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_system_assigned_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_group` int(11) NOT NULL,
  `revision` int(4) NOT NULL DEFAULT '1',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_system_assigned_group`
--

LOCK TABLES `fms_system_assigned_group` WRITE;
/*!40000 ALTER TABLE `fms_system_assigned_group` DISABLE KEYS */;
INSERT INTO `fms_system_assigned_group` VALUES (1,1,1,1,0,0),(2,2,2,1,0,0);
/*!40000 ALTER TABLE `fms_system_assigned_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_system_history`
--

DROP TABLE IF EXISTS `fms_system_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_system_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `table_id` int(11) NOT NULL,
  `table_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_system_history`
--

LOCK TABLES `fms_system_history` WRITE;
/*!40000 ALTER TABLE `fms_system_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `fms_system_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_system_history_hack`
--

DROP TABLE IF EXISTS `fms_system_history_hack`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_system_history_hack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `controller` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Active',
  `action_id` int(11) DEFAULT '99',
  `other_info` text COLLATE utf8_unicode_ci,
  `date_created` int(11) DEFAULT '0',
  `date_created_string` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_system_history_hack`
--

LOCK TABLES `fms_system_history_hack` WRITE;
/*!40000 ALTER TABLE `fms_system_history_hack` DISABLE KEYS */;
/*!40000 ALTER TABLE `fms_system_history_hack` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_system_site_offline`
--

DROP TABLE IF EXISTS `fms_system_site_offline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_system_site_offline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_system_site_offline`
--

LOCK TABLES `fms_system_site_offline` WRITE;
/*!40000 ALTER TABLE `fms_system_site_offline` DISABLE KEYS */;
/*!40000 ALTER TABLE `fms_system_site_offline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_system_task`
--

DROP TABLE IF EXISTS `fms_system_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_system_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'TASK',
  `parent` int(11) NOT NULL DEFAULT '0',
  `controller` varchar(500) NOT NULL,
  `ordering` smallint(6) NOT NULL DEFAULT '9999',
  `icon` varchar(255) NOT NULL DEFAULT 'menu.png',
  `status` varchar(11) NOT NULL DEFAULT 'Active',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_system_task`
--

LOCK TABLES `fms_system_task` WRITE;
/*!40000 ALTER TABLE `fms_system_task` DISABLE KEYS */;
INSERT INTO `fms_system_task` VALUES (1,'System Settings','MODULE',0,'',1,'menu.png','Active',1455625924,1,1485931698,1),(2,'Module & Task','TASK',1,'Sys_module_task',1,'menu.png','Active',1455625924,1,1455625924,1),(3,'User Role','TASK',1,'Sys_user_role',2,'menu.png','Active',1455625924,1,1455625924,1),(4,'User Group','TASK',1,'Sys_user_group',3,'menu.png','Active',1455625924,1,1455625924,1),(5,'Assign User To Group','TASK',1,'Sys_assign_user_group',4,'menu.png','Active',1466929864,1,NULL,NULL),(6,'Site Offline','TASK',1,'Sys_site_offline',5,'menu.png','Active',1466929894,1,NULL,NULL),(7,'Setup','MODULE',0,'',2,'menu.png','Active',1485656658,1,NULL,NULL),(8,'File Category','TASK',7,'Setup_file_category',1,'menu.png','Active',1485656709,1,NULL,NULL),(9,'File Class','TASK',7,'Setup_file_class',2,'menu.png','Active',1485657265,1,NULL,NULL),(10,'File Type','TASK',7,'Setup_file_type',3,'menu.png','Active',1485659147,1,NULL,NULL),(11,'File Name','TASK',7,'Setup_file_name',4,'menu.png','Active',1485660656,1,NULL,NULL),(12,'Hardcopy Location','TASK',7,'Setup_file_hc_location',5,'menu.png','Active',1485666393,1,NULL,NULL),(13,'Assign File to User Group','TASK',7,'Setup_assign_file_user_group',6,'menu.png','Active',1485668128,1,NULL,NULL),(14,'Tasks','MODULE',0,'',3,'menu.png','Active',1485671027,1,NULL,NULL),(15,'File Entry','TASK',14,'Tasks_file_entry',1,'menu.png','Active',1485671068,1,NULL,NULL),(16,'Report','MODULE',0,'',4,'menu.png','Active',1485747685,1,NULL,NULL),(17,'File View','TASK',16,'Report_file_view',1,'menu.png','Active',1485747718,1,NULL,NULL);
/*!40000 ALTER TABLE `fms_system_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_system_user_group`
--

DROP TABLE IF EXISTS `fms_system_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_system_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'Active',
  `ordering` tinyint(4) NOT NULL DEFAULT '99',
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_created` int(11) NOT NULL DEFAULT '0',
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_system_user_group`
--

LOCK TABLES `fms_system_user_group` WRITE;
/*!40000 ALTER TABLE `fms_system_user_group` DISABLE KEYS */;
INSERT INTO `fms_system_user_group` VALUES (1,'Super Admin','Active',1,1455625924,1,NULL,NULL),(2,'Admin','Active',2,1455777728,1,NULL,NULL);
/*!40000 ALTER TABLE `fms_system_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_system_user_group_role`
--

DROP TABLE IF EXISTS `fms_system_user_group_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_system_user_group_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_created` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_system_user_group_role`
--

LOCK TABLES `fms_system_user_group_role` WRITE;
/*!40000 ALTER TABLE `fms_system_user_group_role` DISABLE KEYS */;
INSERT INTO `fms_system_user_group_role` VALUES (1,1,2,1,1,1,1,1,1,1,1,0,0),(2,1,3,1,1,1,1,1,1,1,1,0,0);
/*!40000 ALTER TABLE `fms_system_user_group_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fms_tasks_digital_file`
--

DROP TABLE IF EXISTS `fms_tasks_digital_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fms_tasks_digital_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `id_file_name` int(11) DEFAULT NULL,
  `mime_type` text,
  `type` varchar(20) DEFAULT NULL,
  `remarks` text,
  `status` varchar(10) DEFAULT 'Active',
  `date_entry` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_tasks_digital_file`
--

LOCK TABLES `fms_tasks_digital_file` WRITE;
/*!40000 ALTER TABLE `fms_tasks_digital_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `fms_tasks_digital_file` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-13 10:25:20
