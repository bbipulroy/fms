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
  `action1` tinyint(1) NOT NULL,
  `action2` tinyint(1) NOT NULL,
  `action3` tinyint(1) NOT NULL,
  `status` varchar(10) DEFAULT 'Active',
  `user_created` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_group_id` (`user_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_setup_assign_file_user_group`
--

LOCK TABLES `fms_setup_assign_file_user_group` WRITE;
/*!40000 ALTER TABLE `fms_setup_assign_file_user_group` DISABLE KEYS */;
INSERT INTO `fms_setup_assign_file_user_group` VALUES (1,1,1,1,1,1,'Active',1,1485670905,NULL,NULL),(2,1,4,1,1,1,'Active',1,1485670905,NULL,NULL),(3,1,2,1,1,1,'Active',1,1485670905,NULL,NULL),(4,1,3,1,1,1,'Active',1,1485670905,NULL,NULL),(5,2,1,1,1,1,'Active',1,1485670932,NULL,NULL),(6,2,4,1,1,0,'Active',1,1485670932,NULL,NULL),(7,2,2,1,1,1,'Active',1,1485670932,NULL,NULL),(8,2,3,1,1,1,'Active',1,1485670932,NULL,NULL),(9,3,1,0,1,1,'Active',1,1485670962,1485670976,1),(10,3,4,1,1,0,'Active',1,1485670962,1485670976,1),(11,3,3,1,0,1,'Active',1,1485670962,1485670976,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_setup_file_category`
--

LOCK TABLES `fms_setup_file_category` WRITE;
/*!40000 ALTER TABLE `fms_setup_file_category` DISABLE KEYS */;
INSERT INTO `fms_setup_file_category` VALUES (1,'Category 1','Active',1,'',1485657197,1,NULL,NULL),(2,'Category 2','Active',2,'',1485657214,1,NULL,NULL),(3,'Category 3','Active',3,'',1485657227,1,1485657232,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_setup_file_class`
--

LOCK TABLES `fms_setup_file_class` WRITE;
/*!40000 ALTER TABLE `fms_setup_file_class` DISABLE KEYS */;
INSERT INTO `fms_setup_file_class` VALUES (1,'Class 1',1,'Active',99,'',1485658428,1,NULL,NULL),(2,'Class 2',2,'Active',99,'',1485658454,1,NULL,NULL),(3,'Class 3',3,'Active',99,'',1485658462,1,1485658491,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_setup_file_hc_location`
--

LOCK TABLES `fms_setup_file_hc_location` WRITE;
/*!40000 ALTER TABLE `fms_setup_file_hc_location` DISABLE KEYS */;
INSERT INTO `fms_setup_file_hc_location` VALUES (1,'Hardcopy Location 1','Active',99,'',1485666431,1,1485666671,1),(2,'Hardcopy Location 2','Active',99,'',1485666446,1,NULL,NULL),(3,'Hardcopy Location 3','Active',99,'',1485666450,1,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_setup_file_name`
--

LOCK TABLES `fms_setup_file_name` WRITE;
/*!40000 ALTER TABLE `fms_setup_file_name` DISABLE KEYS */;
INSERT INTO `fms_setup_file_name` VALUES (1,'Name 1',1,1,1485626400,NULL,'Active',1,'First File',1,2,21,1485666725,1,1485667593,1),(2,'Name 2',2,2,1485712800,NULL,'Active',2,'Second File',2,5,52,1485667586,1,NULL,NULL),(3,'Name 3',3,3,1485799200,NULL,'Active',3,'Third File',3,1,2,1485667651,1,NULL,NULL),(4,'Name 4',1,1,1485885600,NULL,'Active',4,'Fourth FIle',1,3,94,1485669808,1,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_setup_file_type`
--

LOCK TABLES `fms_setup_file_type` WRITE;
/*!40000 ALTER TABLE `fms_setup_file_type` DISABLE KEYS */;
INSERT INTO `fms_setup_file_type` VALUES (1,'Type 1',1,'Active',99,'',1485659204,1,1485659274,1),(2,'Type 2',2,'Active',99,'',1485659216,1,NULL,NULL),(3,'Type 3',3,'Active',99,'',1485659230,1,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_system_assigned_group`
--

LOCK TABLES `fms_system_assigned_group` WRITE;
/*!40000 ALTER TABLE `fms_system_assigned_group` DISABLE KEYS */;
INSERT INTO `fms_system_assigned_group` VALUES (1,1,1,1,0,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=171 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_system_history`
--

LOCK TABLES `fms_system_history` WRITE;
/*!40000 ALTER TABLE `fms_system_history` DISABLE KEYS */;
INSERT INTO `fms_system_history` VALUES (1,'sys_module_task',7,'fms_system_task','{\"name\":\"Setup\",\"type\":\"MODULE\",\"parent\":\"0\",\"controller\":\"\",\"ordering\":\"2\",\"status\":\"Active\",\"user_created\":\"1\",\"date_created\":1485656658}','1','INSERT',1485656658),(2,'sys_module_task',8,'fms_system_task','{\"name\":\"File Category\",\"type\":\"TASK\",\"parent\":\"7\",\"controller\":\"Setup_file_category\",\"ordering\":\"1\",\"status\":\"Active\",\"user_created\":\"1\",\"date_created\":1485656709}','1','INSERT',1485656709),(3,'sys_user_role',12,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":2,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485656724}','1','INSERT',1485656724),(4,'sys_user_role',13,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":3,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485656724}','1','INSERT',1485656724),(5,'sys_user_role',14,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":4,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485656724}','1','INSERT',1485656724),(6,'sys_user_role',15,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":5,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485656724}','1','INSERT',1485656724),(7,'sys_user_role',16,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":6,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485656724}','1','INSERT',1485656724),(8,'sys_user_role',17,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":8,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485656724}','1','INSERT',1485656724),(9,'setup_file_category',1,'fms_setup_file_category','{\"name\":\"Category 1\",\"ordering\":\"1\",\"remarks\":\"\",\"user_created\":\"1\",\"date_created\":1485657197}','1','INSERT',1485657197),(10,'setup_file_category',2,'fms_setup_file_category','{\"name\":\"Category 2\",\"ordering\":\"2\",\"remarks\":\"\",\"user_created\":\"1\",\"date_created\":1485657214}','1','INSERT',1485657214),(11,'setup_file_category',3,'fms_setup_file_category','{\"name\":\"Category 4\",\"ordering\":\"3\",\"remarks\":\"\",\"user_created\":\"1\",\"date_created\":1485657227}','1','INSERT',1485657227),(12,'setup_file_category',3,'fms_setup_file_category','{\"name\":\"Category 3\",\"ordering\":\"3\",\"remarks\":\"\",\"user_updated\":\"1\",\"date_updated\":1485657232}','1','UPDATE',1485657233),(13,'sys_module_task',9,'fms_system_task','{\"name\":\"File Class\",\"type\":\"TASK\",\"parent\":\"7\",\"controller\":\"Setup_file_class\",\"ordering\":\"2\",\"status\":\"Active\",\"user_created\":\"1\",\"date_created\":1485657265}','1','INSERT',1485657265),(14,'sys_user_role',18,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":2,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485657279}','1','INSERT',1485657279),(15,'sys_user_role',19,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":3,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485657279}','1','INSERT',1485657279),(16,'sys_user_role',20,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":4,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485657279}','1','INSERT',1485657279),(17,'sys_user_role',21,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":5,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485657279}','1','INSERT',1485657279),(18,'sys_user_role',22,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":6,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485657279}','1','INSERT',1485657279),(19,'sys_user_role',23,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":8,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485657279}','1','INSERT',1485657279),(20,'sys_user_role',24,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":9,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485657279}','1','INSERT',1485657279),(21,'setup_file_class',1,'fms_setup_file_class','{\"id_category\":\"1\",\"name\":\"Class 1\",\"ordering\":\"99\",\"remarks\":\"\",\"user_created\":\"1\",\"date_created\":1485658428}','1','INSERT',1485658428),(22,'setup_file_class',2,'fms_setup_file_class','{\"id_category\":\"2\",\"name\":\"Class 2\",\"ordering\":\"99\",\"remarks\":\"\",\"user_created\":\"1\",\"date_created\":1485658454}','1','INSERT',1485658454),(23,'setup_file_class',3,'fms_setup_file_class','{\"id_category\":\"3\",\"name\":\"Class 3\",\"ordering\":\"99\",\"remarks\":\"\",\"user_created\":\"1\",\"date_created\":1485658462}','1','INSERT',1485658462),(24,'setup_file_class',3,'fms_setup_file_class','{\"id_category\":\"2\",\"name\":\"Class 4\",\"ordering\":\"99\",\"remarks\":\"\",\"user_updated\":\"1\",\"date_updated\":1485658483}','1','UPDATE',1485658484),(25,'setup_file_class',3,'fms_setup_file_class','{\"id_category\":\"3\",\"name\":\"Class 3\",\"ordering\":\"99\",\"remarks\":\"\",\"user_updated\":\"1\",\"date_updated\":1485658491}','1','UPDATE',1485658491),(26,'sys_module_task',10,'fms_system_task','{\"name\":\"File Type\",\"type\":\"TASK\",\"parent\":\"7\",\"controller\":\"Setup_file_type\",\"ordering\":\"3\",\"status\":\"Active\",\"user_created\":\"1\",\"date_created\":1485659147}','1','INSERT',1485659147),(27,'sys_user_role',25,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":2,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485659163}','1','INSERT',1485659163),(28,'sys_user_role',26,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":3,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485659163}','1','INSERT',1485659163),(29,'sys_user_role',27,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":4,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485659163}','1','INSERT',1485659163),(30,'sys_user_role',28,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":5,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485659163}','1','INSERT',1485659163),(31,'sys_user_role',29,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":6,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485659163}','1','INSERT',1485659163),(32,'sys_user_role',30,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":8,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485659163}','1','INSERT',1485659163),(33,'sys_user_role',31,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":9,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485659163}','1','INSERT',1485659163),(34,'sys_user_role',32,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":10,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485659163}','1','INSERT',1485659163),(35,'setup_file_type',1,'fms_setup_file_type','{\"id_class\":\"1\",\"name\":\"type 1\",\"ordering\":\"99\",\"remarks\":\"\",\"user_created\":\"1\",\"date_created\":1485659204}','1','INSERT',1485659204),(36,'setup_file_type',2,'fms_setup_file_type','{\"id_class\":\"2\",\"name\":\"Type 2\",\"ordering\":\"99\",\"remarks\":\"\",\"user_created\":\"1\",\"date_created\":1485659216}','1','INSERT',1485659216),(37,'setup_file_type',3,'fms_setup_file_type','{\"id_class\":\"3\",\"name\":\"Type 3\",\"ordering\":\"99\",\"remarks\":\"\",\"user_created\":\"1\",\"date_created\":1485659230}','1','INSERT',1485659230),(38,'setup_file_type',1,'fms_setup_file_type','{\"id_class\":\"1\",\"name\":\"Type 1\",\"ordering\":\"99\",\"remarks\":\"\",\"user_updated\":\"1\",\"date_updated\":1485659274}','1','UPDATE',1485659274),(39,'sys_module_task',11,'fms_system_task','{\"name\":\"File Name\",\"type\":\"TASK\",\"parent\":\"7\",\"controller\":\"Setup_file_name\",\"ordering\":\"4\",\"status\":\"Active\",\"user_created\":\"1\",\"date_created\":1485660656}','1','INSERT',1485660656),(40,'sys_user_role',33,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":2,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485660669}','1','INSERT',1485660669),(41,'sys_user_role',34,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":3,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485660669}','1','INSERT',1485660669),(42,'sys_user_role',35,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":4,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485660669}','1','INSERT',1485660669),(43,'sys_user_role',36,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":5,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485660669}','1','INSERT',1485660669),(44,'sys_user_role',37,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":6,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485660669}','1','INSERT',1485660669),(45,'sys_user_role',38,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":8,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485660669}','1','INSERT',1485660669),(46,'sys_user_role',39,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":9,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485660669}','1','INSERT',1485660669),(47,'sys_user_role',40,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":10,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485660669}','1','INSERT',1485660669),(48,'sys_user_role',41,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":11,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485660669}','1','INSERT',1485660669),(49,'sys_module_task',12,'fms_system_task','{\"name\":\"Hardcopy Location\",\"type\":\"TASK\",\"parent\":\"7\",\"controller\":\"Setup_file_hc_location\",\"ordering\":\"5\",\"status\":\"Active\",\"user_created\":\"1\",\"date_created\":1485666393}','1','INSERT',1485666393),(50,'sys_user_role',42,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":2,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485666405}','1','INSERT',1485666405),(51,'sys_user_role',43,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":3,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485666405}','1','INSERT',1485666405),(52,'sys_user_role',44,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":4,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485666405}','1','INSERT',1485666405),(53,'sys_user_role',45,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":5,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485666405}','1','INSERT',1485666405),(54,'sys_user_role',46,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":6,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485666405}','1','INSERT',1485666405),(55,'sys_user_role',47,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":8,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485666405}','1','INSERT',1485666405),(56,'sys_user_role',48,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":9,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485666405}','1','INSERT',1485666405),(57,'sys_user_role',49,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":10,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485666405}','1','INSERT',1485666405),(58,'sys_user_role',50,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":11,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485666405}','1','INSERT',1485666405),(59,'sys_user_role',51,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":12,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485666405}','1','INSERT',1485666405),(60,'setup_file_hc_location',1,'fms_setup_file_hc_location','{\"name\":\"Hardcopy Location 1\",\"ordering\":\"99\",\"remarks\":\"\",\"user_created\":\"1\",\"date_created\":1485666431}','1','INSERT',1485666431),(61,'setup_file_hc_location',2,'fms_setup_file_hc_location','{\"name\":\"Hardcopy Location 2\",\"ordering\":\"99\",\"remarks\":\"\",\"user_created\":\"1\",\"date_created\":1485666446}','1','INSERT',1485666446),(62,'setup_file_hc_location',3,'fms_setup_file_hc_location','{\"name\":\"Hardcopy Location 3\",\"ordering\":\"99\",\"remarks\":\"\",\"user_created\":\"1\",\"date_created\":1485666450}','1','INSERT',1485666450),(63,'setup_file_hc_location',1,'fms_setup_file_hc_location','{\"name\":\"Hardcopy Location 1 f\",\"ordering\":\"99\",\"remarks\":\"\",\"user_updated\":\"1\",\"date_updated\":1485666461}','1','UPDATE',1485666461),(64,'setup_file_hc_location',1,'fms_setup_file_hc_location','{\"name\":\"Hardcopy Location 1\",\"ordering\":\"99\",\"remarks\":\"\",\"user_updated\":\"1\",\"date_updated\":1485666671}','1','UPDATE',1485666671),(65,'setup_file_name',1,'fms_setup_file_name','{\"id_office\":\"1\",\"id_department\":\"1\",\"employee_responsible\":\"21\",\"id_type\":\"1\",\"id_hc_location\":\"1\",\"name\":\"Name 1\",\"ordering\":\"1\",\"date_start\":1485626400,\"remarks\":\"First\",\"user_created\":\"1\",\"date_created\":1485666725}','1','INSERT',1485666725),(66,'setup_file_name',1,'fms_setup_file_name','{\"id_office\":\"1\",\"id_department\":\"2\",\"employee_responsible\":\"21\",\"id_type\":\"1\",\"id_hc_location\":\"1\",\"name\":\"Name 1\",\"ordering\":\"1\",\"date_start\":1485626400,\"remarks\":\"First\",\"user_updated\":\"1\",\"date_updated\":1485667519}','1','UPDATE',1485667519),(67,'setup_file_name',2,'fms_setup_file_name','{\"id_office\":\"2\",\"id_department\":\"5\",\"employee_responsible\":\"52\",\"id_type\":\"2\",\"id_hc_location\":\"2\",\"name\":\"Name 2\",\"ordering\":\"2\",\"date_start\":1485712800,\"remarks\":\"Second File\",\"user_created\":\"1\",\"date_created\":1485667586}','1','INSERT',1485667586),(68,'setup_file_name',1,'fms_setup_file_name','{\"id_office\":\"1\",\"id_department\":\"2\",\"employee_responsible\":\"21\",\"id_type\":\"1\",\"id_hc_location\":\"1\",\"name\":\"Name 1\",\"ordering\":\"1\",\"date_start\":1485626400,\"remarks\":\"First File\",\"user_updated\":\"1\",\"date_updated\":1485667593}','1','UPDATE',1485667593),(69,'setup_file_name',3,'fms_setup_file_name','{\"id_office\":\"3\",\"id_department\":\"1\",\"employee_responsible\":\"2\",\"id_type\":\"3\",\"id_hc_location\":\"3\",\"name\":\"Name 3\",\"ordering\":\"3\",\"date_start\":1485799200,\"remarks\":\"Third File\",\"user_created\":\"1\",\"date_created\":1485667651}','1','INSERT',1485667651),(70,'sys_module_task',13,'fms_system_task','{\"name\":\"Assign File to User Group\",\"type\":\"TASK\",\"parent\":\"7\",\"controller\":\"Setup_assign_file_user_group\",\"ordering\":\"6\",\"status\":\"Active\",\"user_created\":\"1\",\"date_created\":1485668128}','1','INSERT',1485668128),(71,'sys_user_role',52,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":2,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485668139}','1','INSERT',1485668139),(72,'sys_user_role',53,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":3,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485668139}','1','INSERT',1485668139),(73,'sys_user_role',54,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":4,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485668139}','1','INSERT',1485668139),(74,'sys_user_role',55,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":5,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485668139}','1','INSERT',1485668139),(75,'sys_user_role',56,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":6,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485668139}','1','INSERT',1485668139),(76,'sys_user_role',57,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":8,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485668139}','1','INSERT',1485668139),(77,'sys_user_role',58,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":9,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485668139}','1','INSERT',1485668139),(78,'sys_user_role',59,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":10,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485668139}','1','INSERT',1485668139),(79,'sys_user_role',60,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":11,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485668139}','1','INSERT',1485668139),(80,'sys_user_role',61,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":12,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485668139}','1','INSERT',1485668139),(81,'sys_user_role',62,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":13,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485668139}','1','INSERT',1485668139),(82,'setup_file_name',4,'fms_setup_file_name','{\"id_office\":\"1\",\"id_department\":\"3\",\"employee_responsible\":\"94\",\"id_type\":\"1\",\"id_hc_location\":\"1\",\"name\":\"Name 4\",\"ordering\":\"4\",\"date_start\":1485885600,\"remarks\":\"Fourth FIle\",\"user_created\":\"1\",\"date_created\":1485669808}','1','INSERT',1485669808),(83,'setup_assign_file_user_group',1,'fms_setup_assign_file_user_group','{\"id_file\":1,\"user_group_id\":\"2\",\"user_created\":\"1\",\"date_created\":1485670173,\"action1\":1,\"action2\":1,\"action3\":0,\"status\":\"Active\"}','1','INSERT',1485670173),(84,'setup_assign_file_user_group',2,'fms_setup_assign_file_user_group','{\"id_file\":4,\"user_group_id\":\"2\",\"user_created\":\"1\",\"date_created\":1485670173,\"action1\":1,\"action2\":1,\"action3\":0,\"status\":\"Active\"}','1','INSERT',1485670173),(85,'setup_assign_file_user_group',3,'fms_setup_assign_file_user_group','{\"id_file\":1,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485670280,\"action1\":1,\"action2\":1,\"action3\":0,\"status\":\"Active\"}','1','INSERT',1485670280),(86,'setup_assign_file_user_group',4,'fms_setup_assign_file_user_group','{\"id_file\":4,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485670280,\"action1\":1,\"action2\":1,\"action3\":0,\"status\":\"Active\"}','1','INSERT',1485670280),(87,'setup_assign_file_user_group',5,'fms_setup_assign_file_user_group','{\"id_file\":2,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485670280,\"action1\":1,\"action2\":1,\"action3\":0,\"status\":\"Active\"}','1','INSERT',1485670280),(88,'setup_assign_file_user_group',1,'fms_setup_assign_file_user_group','{\"user_updated\":\"1\",\"date_updated\":1485670796,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','UPDATE',1485670796),(89,'setup_assign_file_user_group',2,'fms_setup_assign_file_user_group','{\"user_updated\":\"1\",\"date_updated\":1485670796,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','UPDATE',1485670796),(90,'setup_assign_file_user_group',6,'fms_setup_assign_file_user_group','{\"id_file\":2,\"user_group_id\":\"2\",\"user_created\":\"1\",\"date_created\":1485670796,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670796),(91,'setup_assign_file_user_group',7,'fms_setup_assign_file_user_group','{\"id_file\":3,\"user_group_id\":\"2\",\"user_created\":\"1\",\"date_created\":1485670796,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670796),(92,'setup_assign_file_user_group',3,'fms_setup_assign_file_user_group','{\"user_updated\":\"1\",\"date_updated\":1485670812,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','UPDATE',1485670812),(93,'setup_assign_file_user_group',4,'fms_setup_assign_file_user_group','{\"user_updated\":\"1\",\"date_updated\":1485670812,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','UPDATE',1485670812),(94,'setup_assign_file_user_group',5,'fms_setup_assign_file_user_group','{\"user_updated\":\"1\",\"date_updated\":1485670812,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','UPDATE',1485670812),(95,'setup_assign_file_user_group',3,'fms_setup_assign_file_user_group','{\"user_updated\":\"1\",\"date_updated\":1485670823,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','UPDATE',1485670823),(96,'setup_assign_file_user_group',4,'fms_setup_assign_file_user_group','{\"user_updated\":\"1\",\"date_updated\":1485670823,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','UPDATE',1485670823),(97,'setup_assign_file_user_group',5,'fms_setup_assign_file_user_group','{\"user_updated\":\"1\",\"date_updated\":1485670823,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','UPDATE',1485670823),(98,'setup_assign_file_user_group',8,'fms_setup_assign_file_user_group','{\"id_file\":3,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485670823,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670823),(99,'sys_user_group',3,'fms_system_user_group','{\"name\":\"Marketing\",\"ordering\":\"99\",\"user_created\":\"1\",\"date_created\":1485670854}','1','INSERT',1485670854),(100,'setup_assign_file_user_group',9,'fms_setup_assign_file_user_group','{\"id_file\":1,\"user_group_id\":\"3\",\"user_created\":\"1\",\"date_created\":1485670873,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670873),(101,'setup_assign_file_user_group',10,'fms_setup_assign_file_user_group','{\"id_file\":4,\"user_group_id\":\"3\",\"user_created\":\"1\",\"date_created\":1485670873,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670873),(102,'setup_assign_file_user_group',11,'fms_setup_assign_file_user_group','{\"id_file\":2,\"user_group_id\":\"3\",\"user_created\":\"1\",\"date_created\":1485670873,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670873),(103,'setup_assign_file_user_group',12,'fms_setup_assign_file_user_group','{\"id_file\":3,\"user_group_id\":\"3\",\"user_created\":\"1\",\"date_created\":1485670873,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670873),(104,'setup_assign_file_user_group',1,'fms_setup_assign_file_user_group','{\"id_file\":1,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485670905,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670905),(105,'setup_assign_file_user_group',2,'fms_setup_assign_file_user_group','{\"id_file\":4,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485670905,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670905),(106,'setup_assign_file_user_group',3,'fms_setup_assign_file_user_group','{\"id_file\":2,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485670905,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670905),(107,'setup_assign_file_user_group',4,'fms_setup_assign_file_user_group','{\"id_file\":3,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485670905,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670905),(108,'setup_assign_file_user_group',5,'fms_setup_assign_file_user_group','{\"id_file\":1,\"user_group_id\":\"2\",\"user_created\":\"1\",\"date_created\":1485670932,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670932),(109,'setup_assign_file_user_group',6,'fms_setup_assign_file_user_group','{\"id_file\":4,\"user_group_id\":\"2\",\"user_created\":\"1\",\"date_created\":1485670932,\"action1\":1,\"action2\":1,\"action3\":0,\"status\":\"Active\"}','1','INSERT',1485670932),(110,'setup_assign_file_user_group',7,'fms_setup_assign_file_user_group','{\"id_file\":2,\"user_group_id\":\"2\",\"user_created\":\"1\",\"date_created\":1485670932,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670932),(111,'setup_assign_file_user_group',8,'fms_setup_assign_file_user_group','{\"id_file\":3,\"user_group_id\":\"2\",\"user_created\":\"1\",\"date_created\":1485670932,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670932),(112,'setup_assign_file_user_group',9,'fms_setup_assign_file_user_group','{\"id_file\":1,\"user_group_id\":\"3\",\"user_created\":\"1\",\"date_created\":1485670962,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670962),(113,'setup_assign_file_user_group',10,'fms_setup_assign_file_user_group','{\"id_file\":4,\"user_group_id\":\"3\",\"user_created\":\"1\",\"date_created\":1485670962,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670962),(114,'setup_assign_file_user_group',11,'fms_setup_assign_file_user_group','{\"id_file\":3,\"user_group_id\":\"3\",\"user_created\":\"1\",\"date_created\":1485670962,\"action1\":1,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','INSERT',1485670962),(115,'setup_assign_file_user_group',9,'fms_setup_assign_file_user_group','{\"user_updated\":\"1\",\"date_updated\":1485670976,\"action1\":0,\"action2\":1,\"action3\":1,\"status\":\"Active\"}','1','UPDATE',1485670976),(116,'setup_assign_file_user_group',10,'fms_setup_assign_file_user_group','{\"user_updated\":\"1\",\"date_updated\":1485670976,\"action1\":1,\"action2\":1,\"action3\":0,\"status\":\"Active\"}','1','UPDATE',1485670976),(117,'setup_assign_file_user_group',11,'fms_setup_assign_file_user_group','{\"user_updated\":\"1\",\"date_updated\":1485670976,\"action1\":1,\"action2\":0,\"action3\":1,\"status\":\"Active\"}','1','UPDATE',1485670976),(118,'sys_module_task',14,'fms_system_task','{\"name\":\"Tasks\",\"type\":\"MODULE\",\"parent\":\"0\",\"controller\":\"\",\"ordering\":\"3\",\"status\":\"Active\",\"user_created\":\"1\",\"date_created\":1485671027}','1','INSERT',1485671027),(119,'sys_module_task',15,'fms_system_task','{\"name\":\"File Entry\",\"type\":\"TASK\",\"parent\":\"14\",\"controller\":\"Tasks_file_entry\",\"ordering\":\"1\",\"status\":\"Active\",\"user_created\":\"1\",\"date_created\":1485671068}','1','INSERT',1485671068),(120,'sys_user_role',63,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":2,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485671091}','1','INSERT',1485671091),(121,'sys_user_role',64,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":3,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485671091}','1','INSERT',1485671091),(122,'sys_user_role',65,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":4,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485671091}','1','INSERT',1485671091),(123,'sys_user_role',66,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":5,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485671091}','1','INSERT',1485671091),(124,'sys_user_role',67,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":6,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485671091}','1','INSERT',1485671091),(125,'sys_user_role',68,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":8,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485671091}','1','INSERT',1485671091),(126,'sys_user_role',69,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":9,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485671091}','1','INSERT',1485671091),(127,'sys_user_role',70,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":10,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485671091}','1','INSERT',1485671091),(128,'sys_user_role',71,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":11,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485671091}','1','INSERT',1485671091),(129,'sys_user_role',72,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":12,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485671091}','1','INSERT',1485671091),(130,'sys_user_role',73,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":13,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485671091}','1','INSERT',1485671091),(131,'sys_user_role',74,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":15,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485671091}','1','INSERT',1485671091),(132,'tasks_file_entry',1,'fms_tasks_digital_file','{\"id_file_name\":\"1\",\"date_created\":1485682083,\"user_created\":\"1\",\"date_entry\":1485626400,\"remarks\":\"Korla\",\"mime_type\":\"image\\/jpeg\",\"name\":\"Ajanta-_Copy.JPG\"}','1','INSERT',1485682083),(133,'tasks_file_entry',2,'fms_tasks_digital_file','{\"id_file_name\":\"1\",\"date_created\":1485682168,\"user_created\":\"1\",\"date_entry\":1485712800,\"remarks\":\"Gajor\",\"mime_type\":\"image\\/jpeg\",\"name\":\"New_Kuroda.JPG\"}','1','INSERT',1485682168),(134,'tasks_file_entry',1,'fms_tasks_digital_file','{\"date_entry\":1485799200}','1','UPDATE',1485682283),(135,'tasks_file_entry',1,'fms_tasks_digital_file','{\"remarks\":\"Begun\"}','1','UPDATE',1485682283),(136,'tasks_file_entry',2,'fms_tasks_digital_file','{\"name\":\"New_Kuroda.JPG\",\"user_updated\":\"1\",\"date_updated\":1485682282,\"status\":\"Deleted\"}','1','UPDATE',1485682283),(137,'tasks_file_entry',3,'fms_tasks_digital_file','{\"id_file_name\":\"1\",\"date_created\":1485682282,\"user_created\":\"1\",\"date_entry\":0,\"remarks\":null,\"mime_type\":\"image\\/jpeg\",\"name\":\"Green_Ball_-_Copy.JPG\"}','1','INSERT',1485682283),(138,'tasks_file_entry',4,'fms_tasks_digital_file','{\"id_file_name\":\"2\",\"date_created\":1485682453,\"user_created\":\"1\",\"date_entry\":1485626400,\"remarks\":\"Patakopi\",\"mime_type\":\"image\\/jpeg\",\"name\":\"Atlas-70.JPG\"}','1','INSERT',1485682453),(139,'tasks_file_entry',5,'fms_tasks_digital_file','{\"id_file_name\":\"3\",\"date_created\":1485682511,\"user_created\":\"1\",\"date_entry\":1485626400,\"remarks\":\"\",\"mime_type\":\"image\\/png\",\"name\":\"Evergreen.png\"}','1','INSERT',1485682511),(140,'tasks_file_entry',1,'fms_tasks_digital_file','{\"id_file_name\":\"1\",\"date_created\":1485746795,\"user_created\":\"1\",\"date_entry\":1485712800,\"remarks\":\"Korla\",\"mime_type\":\"image\\/jpeg\",\"name\":\"Ajanta-_Copy.JPG\"}','1','INSERT',1485746795),(141,'tasks_file_entry',2,'fms_tasks_digital_file','{\"id_file_name\":\"1\",\"date_created\":1485746795,\"user_created\":\"1\",\"date_entry\":1485799200,\"remarks\":\"Begun\",\"mime_type\":\"image\\/jpeg\",\"name\":\"Lalita.JPG\"}','1','INSERT',1485746795),(142,'tasks_file_entry',1,'fms_tasks_digital_file','{\"date_entry\":1485972000}','1','UPDATE',1485746977),(143,'tasks_file_entry',1,'fms_tasks_digital_file','{\"remarks\":\"Gajor\"}','1','UPDATE',1485746977),(144,'tasks_file_entry',2,'fms_tasks_digital_file','{\"name\":\"Lalita.JPG\",\"user_updated\":\"1\",\"date_updated\":1485746977,\"status\":\"Deleted\"}','1','UPDATE',1485746977),(145,'tasks_file_entry',3,'fms_tasks_digital_file','{\"id_file_name\":\"1\",\"date_created\":1485746977,\"user_created\":\"1\",\"date_entry\":0,\"remarks\":null,\"mime_type\":\"image\\/jpeg\",\"name\":\"New_Kuroda.JPG\"}','1','INSERT',1485746977),(146,'tasks_file_entry',4,'fms_tasks_digital_file','{\"id_file_name\":\"1\",\"date_created\":1485746977,\"user_created\":\"1\",\"date_entry\":1485885600,\"remarks\":\"Patakopi\",\"mime_type\":\"image\\/jpeg\",\"name\":\"Atlas-70.JPG\"}','1','INSERT',1485746977),(147,'tasks_file_entry',2,'fms_tasks_digital_file','{\"name\":\"Lalita.JPG\",\"user_updated\":\"1\",\"date_updated\":1485746988,\"status\":\"Deleted\"}','1','UPDATE',1485746988),(148,'tasks_file_entry',5,'fms_tasks_digital_file','{\"id_file_name\":\"1\",\"date_created\":1485746988,\"user_created\":\"1\",\"date_entry\":0,\"remarks\":null,\"mime_type\":\"image\\/jpeg\",\"name\":\"New_Kuroda1.JPG\"}','1','INSERT',1485746988),(149,'tasks_file_entry',6,'fms_tasks_digital_file','{\"id_file_name\":\"1\",\"date_created\":1485746988,\"user_created\":\"1\",\"date_entry\":1485885600,\"remarks\":\"Patakopi\",\"mime_type\":\"image\\/jpeg\",\"name\":\"Atlas-701.JPG\"}','1','INSERT',1485746988),(150,'tasks_file_entry',7,'fms_tasks_digital_file','{\"id_file_name\":\"2\",\"date_created\":1485747498,\"user_created\":\"1\",\"date_entry\":1485712800,\"remarks\":\"Patakopi\",\"mime_type\":\"image\\/jpeg\",\"name\":\"Atlas-70.JPG\"}','1','INSERT',1485747498),(151,'tasks_file_entry',8,'fms_tasks_digital_file','{\"id_file_name\":\"2\",\"date_created\":1485747498,\"user_created\":\"1\",\"date_entry\":1485799200,\"remarks\":\"Korla\",\"mime_type\":\"image\\/jpeg\",\"name\":\"Ajanta-_Copy.JPG\"}','1','INSERT',1485747498),(152,'tasks_file_entry',7,'fms_tasks_digital_file','{\"name\":\"Atlas-70.JPG\",\"user_updated\":\"1\",\"date_updated\":1485747561,\"status\":\"Deleted\"}','1','UPDATE',1485747561),(153,'tasks_file_entry',8,'fms_tasks_digital_file','{\"name\":\"Ajanta-_Copy.JPG\",\"user_updated\":\"1\",\"date_updated\":1485747561,\"status\":\"Deleted\"}','1','UPDATE',1485747561),(154,'tasks_file_entry',9,'fms_tasks_digital_file','{\"id_file_name\":\"2\",\"date_created\":1485747561,\"user_created\":\"1\",\"date_entry\":1485885600,\"remarks\":\"Begun\",\"mime_type\":\"image\\/jpeg\",\"name\":\"Lalita.JPG\"}','1','INSERT',1485747561),(155,'tasks_file_entry',10,'fms_tasks_digital_file','{\"id_file_name\":\"2\",\"date_created\":1485747593,\"user_created\":\"1\",\"date_entry\":1485972000,\"remarks\":\"Korla\",\"mime_type\":\"image\\/jpeg\",\"name\":\"Lucky_-_Copy.jpg\"}','1','INSERT',1485747593),(156,'sys_module_task',16,'fms_system_task','{\"name\":\"Report\",\"type\":\"MODULE\",\"parent\":\"0\",\"controller\":\"\",\"ordering\":\"4\",\"status\":\"Active\",\"user_created\":\"1\",\"date_created\":1485747685}','1','INSERT',1485747685),(157,'sys_module_task',17,'fms_system_task','{\"name\":\"File View\",\"type\":\"TASK\",\"parent\":\"16\",\"controller\":\"Report_file_view\",\"ordering\":\"1\",\"status\":\"Active\",\"user_created\":\"1\",\"date_created\":1485747718}','1','INSERT',1485747718),(158,'sys_user_role',75,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":2,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726),(159,'sys_user_role',76,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":3,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726),(160,'sys_user_role',77,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":4,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726),(161,'sys_user_role',78,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":5,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726),(162,'sys_user_role',79,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":6,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726),(163,'sys_user_role',80,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":8,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726),(164,'sys_user_role',81,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":9,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726),(165,'sys_user_role',82,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":10,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726),(166,'sys_user_role',83,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":11,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726),(167,'sys_user_role',84,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":12,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726),(168,'sys_user_role',85,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":13,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726),(169,'sys_user_role',86,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":15,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726),(170,'sys_user_role',87,'fms_system_user_group_role','{\"action0\":1,\"action1\":1,\"action2\":1,\"action3\":1,\"action4\":1,\"action5\":1,\"action6\":1,\"task_id\":17,\"user_group_id\":\"1\",\"user_created\":\"1\",\"date_created\":1485747726}','1','INSERT',1485747726);
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
INSERT INTO `fms_system_task` VALUES (1,'System Settings','MODULE',0,'',1,'menu.png','Active',1455625924,1,1455625924,1),(2,'Module & Task','TASK',1,'Sys_module_task',1,'menu.png','Active',1455625924,1,1455625924,1),(3,'User Role','TASK',1,'Sys_user_role',2,'menu.png','Active',1455625924,1,1455625924,1),(4,'User Group','TASK',1,'Sys_user_group',3,'menu.png','Active',1455625924,1,1455625924,1),(5,'Assign User To Group','TASK',1,'Sys_assign_user_group',4,'menu.png','Active',1466929864,1,NULL,NULL),(6,'Site Offline','TASK',1,'Sys_site_offline',5,'menu.png','Active',1466929894,1,NULL,NULL),(7,'Setup','MODULE',0,'',2,'menu.png','Active',1485656658,1,NULL,NULL),(8,'File Category','TASK',7,'Setup_file_category',1,'menu.png','Active',1485656709,1,NULL,NULL),(9,'File Class','TASK',7,'Setup_file_class',2,'menu.png','Active',1485657265,1,NULL,NULL),(10,'File Type','TASK',7,'Setup_file_type',3,'menu.png','Active',1485659147,1,NULL,NULL),(11,'File Name','TASK',7,'Setup_file_name',4,'menu.png','Active',1485660656,1,NULL,NULL),(12,'Hardcopy Location','TASK',7,'Setup_file_hc_location',5,'menu.png','Active',1485666393,1,NULL,NULL),(13,'Assign File to User Group','TASK',7,'Setup_assign_file_user_group',6,'menu.png','Active',1485668128,1,NULL,NULL),(14,'Tasks','MODULE',0,'',3,'menu.png','Active',1485671027,1,NULL,NULL),(15,'File Entry','TASK',14,'Tasks_file_entry',1,'menu.png','Active',1485671068,1,NULL,NULL),(16,'Report','MODULE',0,'',4,'menu.png','Active',1485747685,1,NULL,NULL),(17,'File View','TASK',16,'Report_file_view',1,'menu.png','Active',1485747718,1,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_system_user_group`
--

LOCK TABLES `fms_system_user_group` WRITE;
/*!40000 ALTER TABLE `fms_system_user_group` DISABLE KEYS */;
INSERT INTO `fms_system_user_group` VALUES (1,'Super Admin','Active',1,1455625924,1,1455625924,1),(2,'Admin','Active',2,1455777728,1,NULL,NULL),(3,'Marketing','Active',99,1485670854,1,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_system_user_group_role`
--

LOCK TABLES `fms_system_user_group_role` WRITE;
/*!40000 ALTER TABLE `fms_system_user_group_role` DISABLE KEYS */;
INSERT INTO `fms_system_user_group_role` VALUES (1,1,2,1,1,1,1,1,1,1,9,1476271159,1),(2,1,3,1,1,1,1,1,1,1,9,1476271159,1),(3,1,4,1,1,1,1,1,1,1,9,1476271159,1),(4,1,5,1,1,1,1,1,1,1,9,1476271159,1),(5,1,6,1,1,1,1,1,1,1,9,1476271159,1),(12,1,2,1,1,1,1,1,1,1,8,1485656724,1),(13,1,3,1,1,1,1,1,1,1,8,1485656724,1),(14,1,4,1,1,1,1,1,1,1,8,1485656724,1),(15,1,5,1,1,1,1,1,1,1,8,1485656724,1),(16,1,6,1,1,1,1,1,1,1,8,1485656724,1),(17,1,8,1,1,1,1,1,1,1,8,1485656724,1),(18,1,2,1,1,1,1,1,1,1,7,1485657279,1),(19,1,3,1,1,1,1,1,1,1,7,1485657279,1),(20,1,4,1,1,1,1,1,1,1,7,1485657279,1),(21,1,5,1,1,1,1,1,1,1,7,1485657279,1),(22,1,6,1,1,1,1,1,1,1,7,1485657279,1),(23,1,8,1,1,1,1,1,1,1,7,1485657279,1),(24,1,9,1,1,1,1,1,1,1,7,1485657279,1),(25,1,2,1,1,1,1,1,1,1,6,1485659163,1),(26,1,3,1,1,1,1,1,1,1,6,1485659163,1),(27,1,4,1,1,1,1,1,1,1,6,1485659163,1),(28,1,5,1,1,1,1,1,1,1,6,1485659163,1),(29,1,6,1,1,1,1,1,1,1,6,1485659163,1),(30,1,8,1,1,1,1,1,1,1,6,1485659163,1),(31,1,9,1,1,1,1,1,1,1,6,1485659163,1),(32,1,10,1,1,1,1,1,1,1,6,1485659163,1),(33,1,2,1,1,1,1,1,1,1,5,1485660669,1),(34,1,3,1,1,1,1,1,1,1,5,1485660669,1),(35,1,4,1,1,1,1,1,1,1,5,1485660669,1),(36,1,5,1,1,1,1,1,1,1,5,1485660669,1),(37,1,6,1,1,1,1,1,1,1,5,1485660669,1),(38,1,8,1,1,1,1,1,1,1,5,1485660669,1),(39,1,9,1,1,1,1,1,1,1,5,1485660669,1),(40,1,10,1,1,1,1,1,1,1,5,1485660669,1),(41,1,11,1,1,1,1,1,1,1,5,1485660669,1),(42,1,2,1,1,1,1,1,1,1,4,1485666405,1),(43,1,3,1,1,1,1,1,1,1,4,1485666405,1),(44,1,4,1,1,1,1,1,1,1,4,1485666405,1),(45,1,5,1,1,1,1,1,1,1,4,1485666405,1),(46,1,6,1,1,1,1,1,1,1,4,1485666405,1),(47,1,8,1,1,1,1,1,1,1,4,1485666405,1),(48,1,9,1,1,1,1,1,1,1,4,1485666405,1),(49,1,10,1,1,1,1,1,1,1,4,1485666405,1),(50,1,11,1,1,1,1,1,1,1,4,1485666405,1),(51,1,12,1,1,1,1,1,1,1,4,1485666405,1),(52,1,2,1,1,1,1,1,1,1,3,1485668139,1),(53,1,3,1,1,1,1,1,1,1,3,1485668139,1),(54,1,4,1,1,1,1,1,1,1,3,1485668139,1),(55,1,5,1,1,1,1,1,1,1,3,1485668139,1),(56,1,6,1,1,1,1,1,1,1,3,1485668139,1),(57,1,8,1,1,1,1,1,1,1,3,1485668139,1),(58,1,9,1,1,1,1,1,1,1,3,1485668139,1),(59,1,10,1,1,1,1,1,1,1,3,1485668139,1),(60,1,11,1,1,1,1,1,1,1,3,1485668139,1),(61,1,12,1,1,1,1,1,1,1,3,1485668139,1),(62,1,13,1,1,1,1,1,1,1,3,1485668139,1),(63,1,2,1,1,1,1,1,1,1,2,1485671091,1),(64,1,3,1,1,1,1,1,1,1,2,1485671091,1),(65,1,4,1,1,1,1,1,1,1,2,1485671091,1),(66,1,5,1,1,1,1,1,1,1,2,1485671091,1),(67,1,6,1,1,1,1,1,1,1,2,1485671091,1),(68,1,8,1,1,1,1,1,1,1,2,1485671091,1),(69,1,9,1,1,1,1,1,1,1,2,1485671091,1),(70,1,10,1,1,1,1,1,1,1,2,1485671091,1),(71,1,11,1,1,1,1,1,1,1,2,1485671091,1),(72,1,12,1,1,1,1,1,1,1,2,1485671091,1),(73,1,13,1,1,1,1,1,1,1,2,1485671091,1),(74,1,15,1,1,1,1,1,1,1,2,1485671091,1),(75,1,2,1,1,1,1,1,1,1,1,1485747726,1),(76,1,3,1,1,1,1,1,1,1,1,1485747726,1),(77,1,4,1,1,1,1,1,1,1,1,1485747726,1),(78,1,5,1,1,1,1,1,1,1,1,1485747726,1),(79,1,6,1,1,1,1,1,1,1,1,1485747726,1),(80,1,8,1,1,1,1,1,1,1,1,1485747726,1),(81,1,9,1,1,1,1,1,1,1,1,1485747726,1),(82,1,10,1,1,1,1,1,1,1,1,1485747726,1),(83,1,11,1,1,1,1,1,1,1,1,1485747726,1),(84,1,12,1,1,1,1,1,1,1,1,1485747726,1),(85,1,13,1,1,1,1,1,1,1,1,1485747726,1),(86,1,15,1,1,1,1,1,1,1,1,1485747726,1),(87,1,17,1,1,1,1,1,1,1,1,1485747726,1);
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
  `remarks` text,
  `status` varchar(10) DEFAULT 'Active',
  `date_entry` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `date_updated` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fms_tasks_digital_file`
--

LOCK TABLES `fms_tasks_digital_file` WRITE;
/*!40000 ALTER TABLE `fms_tasks_digital_file` DISABLE KEYS */;
INSERT INTO `fms_tasks_digital_file` VALUES (1,'Ajanta-_Copy.JPG',1,'image/jpeg','Gajor','Active',1485972000,1485746795,1,NULL,NULL),(2,'Lalita.JPG',1,'image/jpeg','Begun','Deleted',1485799200,1485746795,1,1485746988,1),(3,'New_Kuroda.JPG',1,'image/jpeg',NULL,'Active',0,1485746977,1,NULL,NULL),(4,'Atlas-70.JPG',1,'image/jpeg','Patakopi','Active',1485885600,1485746977,1,NULL,NULL),(5,'New_Kuroda1.JPG',1,'image/jpeg',NULL,'Active',0,1485746988,1,NULL,NULL),(6,'Atlas-701.JPG',1,'image/jpeg','Patakopi','Active',1485885600,1485746988,1,NULL,NULL),(7,'Atlas-70.JPG',2,'image/jpeg','Patakopi','Deleted',1485712800,1485747498,1,1485747561,1),(8,'Ajanta-_Copy.JPG',2,'image/jpeg','Korla','Deleted',1485799200,1485747498,1,1485747561,1),(9,'Lalita.JPG',2,'image/jpeg','Begun','Active',1485885600,1485747561,1,NULL,NULL),(10,'Lucky_-_Copy.jpg',2,'image/jpeg','Korla','Active',1485972000,1485747593,1,NULL,NULL);
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

-- Dump completed on 2017-01-30 12:15:39
