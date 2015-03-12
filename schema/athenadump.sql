-- MySQL dump 10.13  Distrib 5.5.23, for Win32 (x86)
--
-- Host: localhost    Database: Athena
-- ------------------------------------------------------
-- Server version	5.5.23

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
-- Table structure for table `assigns`
--

DROP TABLE IF EXISTS `assigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assigns` (
  `asgn_id` int(10) NOT NULL AUTO_INCREMENT,
  `case_id` int(10) NOT NULL,
  `tray_id` int(10) NOT NULL,
  `do_usr` int(10) NOT NULL DEFAULT '0',
  `pu_usr` int(10) NOT NULL DEFAULT '0',
  `cli_nm` varchar(64) NOT NULL DEFAULT '',
  `do_dttm` datetime NOT NULL,
  `pu_dttm` datetime NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT '',
  `cmt` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`asgn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assigns`
--

LOCK TABLES `assigns` WRITE;
/*!40000 ALTER TABLE `assigns` DISABLE KEYS */;
INSERT INTO `assigns` VALUES (24,14,1,1,0,'','2014-07-21 14:23:00','2014-09-01 00:00:00','Complete',''),(25,14,2,0,1,'','2014-08-22 13:40:00','2014-09-01 00:00:00','Complete',''),(26,15,1,0,0,'','2014-08-21 14:12:00','2014-09-01 07:03:00','Complete',''),(27,15,2,0,0,'','2014-08-22 14:12:00','2014-09-13 05:00:00','Complete',''),(28,16,1,0,0,'','2014-08-22 16:24:00','2014-08-22 21:24:00','Complete',''),(29,16,2,1,1,'','2014-08-22 16:24:00','2014-08-22 17:24:00','Complete',''),(30,17,1,1,1,'','2014-09-04 15:42:00','2014-09-07 10:47:00','Complete',''),(31,17,2,1,1,'','2014-09-04 15:42:00','2014-09-05 10:47:00','Complete',''),(32,18,5,1,0,'','2014-09-06 11:07:00','2014-09-07 11:07:00','Complete',''),(33,18,1,0,0,'','2014-09-08 11:10:00','2014-09-10 11:10:00','Complete',''),(34,19,2,1,0,'','2014-09-08 11:21:00','2014-09-07 11:21:00','Complete',''),(35,19,4,0,0,'','2014-09-06 11:21:00','2014-09-07 11:21:00','Complete',''),(36,19,5,1,0,'','2014-09-07 11:22:00','2014-09-08 11:22:00','Complete',''),(37,20,1,1,1,'','2014-09-05 15:15:00','2014-09-07 13:38:00','Complete',''),(38,20,2,1,0,'','2014-09-05 13:38:00','2014-09-08 13:38:00','Complete',''),(39,33,1,1,1,'','2014-09-24 10:23:00','2014-09-26 10:23:00','Pending',''),(40,33,1,1,2,'','2014-09-24 10:23:00','2014-09-25 10:23:00','Pending','');
/*!40000 ALTER TABLE `assigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `case_ttyp`
--

DROP TABLE IF EXISTS `case_ttyp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `case_ttyp` (
  `case_id` int(10) NOT NULL,
  `ttyp_id` int(10) NOT NULL,
  `cmt` varchar(255) NOT NULL DEFAULT '',
  `tray_id` int(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `case_id` (`case_id`,`ttyp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `case_ttyp`
--

LOCK TABLES `case_ttyp` WRITE;
/*!40000 ALTER TABLE `case_ttyp` DISABLE KEYS */;
INSERT INTO `case_ttyp` VALUES (33,1,'Shoulder',1),(33,2,'Zombie',1),(33,3,'Foot',0),(35,1,'',0),(35,2,'',0);
/*!40000 ALTER TABLE `case_ttyp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cases`
--

DROP TABLE IF EXISTS `cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cases` (
  `case_id` int(10) NOT NULL AUTO_INCREMENT,
  `team_id` int(10) NOT NULL DEFAULT '0',
  `doc_id` int(10) NOT NULL DEFAULT '0',
  `proc_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL DEFAULT '0',
  `status` varchar(40) NOT NULL DEFAULT '',
  `dttm` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cmt` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cases`
--

LOCK TABLES `cases` WRITE;
/*!40000 ALTER TABLE `cases` DISABLE KEYS */;
INSERT INTO `cases` VALUES (7,1,1,1,1,'Complete','2014-07-21 14:33:00',''),(9,1,1,1,2,'Complete','2014-08-20 14:49:34',''),(12,1,1,3,2,'Complete','2014-09-07 03:03:00','Gimmie it now!'),(13,1,1,2,2,'Complete','2014-09-21 12:32:00',''),(14,1,1,1,1,'Complete','2014-09-21 13:39:00',''),(15,1,1,3,2,'Complete','2014-08-23 14:12:00',''),(16,1,1,1,1,'Complete','2014-08-22 15:23:00',''),(17,1,1,1,1,'Complete','2014-09-06 10:46:00',''),(18,1,1,3,1,'Complete','2014-09-07 11:04:00',''),(19,1,1,2,2,'Complete','2014-09-09 11:21:00',''),(20,1,1,2,2,'Complete','2014-09-05 13:38:00',''),(22,1,1,1,1,'Complete','2014-09-08 16:45:00',''),(23,1,1,1,1,'Complete','2014-09-12 10:52:00',''),(33,1,1,1,1,'Pending','2014-09-24 18:23:00',''),(34,1,1,1,1,'Pending','2014-09-15 13:33:00','');
/*!40000 ALTER TABLE `cases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cli_site`
--

DROP TABLE IF EXISTS `cli_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cli_site` (
  `cli_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  UNIQUE KEY `cli_id` (`cli_id`,`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cli_site`
--

LOCK TABLES `cli_site` WRITE;
/*!40000 ALTER TABLE `cli_site` DISABLE KEYS */;
INSERT INTO `cli_site` VALUES (1,1),(2,1);
/*!40000 ALTER TABLE `cli_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `cli_id` int(10) NOT NULL AUTO_INCREMENT,
  `active` int(1) NOT NULL DEFAULT '1',
  `fname` varchar(255) NOT NULL DEFAULT '',
  `lname` varchar(255) NOT NULL DEFAULT '',
  `uname` varchar(36) NOT NULL DEFAULT '',
  `pwd` varchar(36) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(25) NOT NULL DEFAULT '',
  `sms` varchar(25) NOT NULL DEFAULT '',
  `perm` varchar(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`cli_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (2,1,'testclient','zzzz','testclient','testclient','someone@someone.com','555-5555','777-7777','');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `cmp_id` int(10) NOT NULL AUTO_INCREMENT,
  `active` int(1) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(255) NOT NULL DEFAULT '',
  `zip` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cmp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,1,'Company 1','','','','55555'),(2,1,'Company 2','','','',''),(3,1,'Company 3','','','','');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doc_cmp`
--

DROP TABLE IF EXISTS `doc_cmp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doc_cmp` (
  `doc_id` int(10) NOT NULL,
  `cmp_id` int(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `doc_id` (`doc_id`,`cmp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doc_cmp`
--

LOCK TABLES `doc_cmp` WRITE;
/*!40000 ALTER TABLE `doc_cmp` DISABLE KEYS */;
INSERT INTO `doc_cmp` VALUES (1,1);
/*!40000 ALTER TABLE `doc_cmp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doc_site`
--

DROP TABLE IF EXISTS `doc_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doc_site` (
  `doc_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `cmp_id` int(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `doc_id` (`doc_id`,`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doc_site`
--

LOCK TABLES `doc_site` WRITE;
/*!40000 ALTER TABLE `doc_site` DISABLE KEYS */;
INSERT INTO `doc_site` VALUES (1,1,0),(1,2,0);
/*!40000 ALTER TABLE `doc_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctors` (
  `doc_id` int(10) NOT NULL AUTO_INCREMENT,
  `active` int(1) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`doc_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctors`
--

LOCK TABLES `doctors` WRITE;
/*!40000 ALTER TABLE `doctors` DISABLE KEYS */;
INSERT INTO `doctors` VALUES (1,1,'Dr. Joe');
/*!40000 ALTER TABLE `doctors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dst_cmp`
--

DROP TABLE IF EXISTS `dst_cmp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dst_cmp` (
  `dst_id` int(10) NOT NULL,
  `cmp_id` int(10) NOT NULL,
  UNIQUE KEY `dst_id` (`dst_id`,`cmp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dst_cmp`
--

LOCK TABLES `dst_cmp` WRITE;
/*!40000 ALTER TABLE `dst_cmp` DISABLE KEYS */;
INSERT INTO `dst_cmp` VALUES (1,1);
/*!40000 ALTER TABLE `dst_cmp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_assigns`
--

DROP TABLE IF EXISTS `h_assigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_assigns` (
  `h_asgn_id` int(10) NOT NULL AUTO_INCREMENT,
  `asgn_id` int(10) NOT NULL,
  `action` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `from_usr` int(10) NOT NULL,
  `to_usr` int(10) NOT NULL,
  `dttm` datetime NOT NULL,
  PRIMARY KEY (`h_asgn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_assigns`
--

LOCK TABLES `h_assigns` WRITE;
/*!40000 ALTER TABLE `h_assigns` DISABLE KEYS */;
INSERT INTO `h_assigns` VALUES (1,42,'Dropoff','Pending',1,1,'2014-09-05 15:58:49'),(2,42,'Pickup','Pending',1,2,'2014-09-05 15:58:49'),(3,42,'Dropoff','Pending',1,1,'2014-09-05 15:58:49'),(4,39,'Dropoff','Pending',1,1,'2014-09-10 10:56:27'),(5,39,'Pickup','Pending',1,2,'2014-09-10 10:56:27'),(6,40,'Dropoff','Pending',1,1,'2014-09-11 10:38:25'),(7,40,'Pickup','Pending',1,0,'2014-09-11 10:38:25'),(8,41,'Dropoff','Pending',1,1,'2014-09-11 11:01:22'),(9,41,'Pickup','Pending',1,2,'2014-09-11 11:01:22'),(10,42,'Dropoff','Pending',1,1,'2014-09-11 11:02:05'),(11,42,'Pickup','Pending',1,2,'2014-09-11 11:02:05'),(12,43,'Dropoff','Pending',1,1,'2014-09-11 11:03:30'),(13,43,'Pickup','Pending',1,0,'2014-09-11 11:03:30'),(14,44,'Dropoff','Pending',1,1,'2014-09-11 11:04:15'),(15,44,'Pickup','Pending',1,0,'2014-09-11 11:04:15'),(16,45,'Dropoff','Pending',1,1,'2014-09-11 11:11:02'),(17,45,'Pickup','Pending',1,0,'2014-09-11 11:11:02'),(18,46,'Dropoff','Pending',1,1,'2014-09-11 11:14:08'),(19,46,'Pickup','Pending',1,0,'2014-09-11 11:14:08'),(20,40,'Dropoff','Pending',1,1,'2014-09-12 13:33:01'),(21,40,'Pickup','Pending',1,2,'2014-09-12 13:33:01'),(22,41,'Dropoff','Pending',1,0,'2014-09-12 13:33:43'),(23,41,'Pickup','Pending',1,0,'2014-09-12 13:33:43'),(24,39,'Dropoff','Pending',1,1,'2014-09-23 10:23:54'),(25,39,'Pickup','Pending',1,1,'2014-09-23 10:23:54'),(26,40,'Dropoff','Pending',1,1,'2014-09-23 10:24:06'),(27,40,'Pickup','Pending',1,2,'2014-09-23 10:24:06');
/*!40000 ALTER TABLE `h_assigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_traycont`
--

DROP TABLE IF EXISTS `h_traycont`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_traycont` (
  `asgn_id` int(10) NOT NULL DEFAULT '0',
  `tray_id` int(10) NOT NULL,
  `inst_id` int(10) NOT NULL,
  `quant` int(4) NOT NULL DEFAULT '1',
  `state` varchar(20) NOT NULL DEFAULT 'p',
  `cmt` varchar(255) NOT NULL DEFAULT '',
  `dttm` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_traycont`
--

LOCK TABLES `h_traycont` WRITE;
/*!40000 ALTER TABLE `h_traycont` DISABLE KEYS */;
INSERT INTO `h_traycont` VALUES (0,5,1,342,'Present','Please Log this!','2014-08-19 13:27:22'),(0,5,1,3543,'Missing','Log!','2014-08-19 13:46:01'),(0,5,1,3333,'Present','LOG22222','2014-08-19 13:49:21'),(0,5,1,7878,'Removed','LOG 444444','2014-08-19 13:49:30'),(0,1,1,333,'Present','dsfs','2014-08-19 15:45:06'),(0,1,1,222,'Present','sssssss','2014-08-19 15:47:21'),(0,1,1,7777,'Removed','fdgdfg','2014-09-03 11:08:36'),(0,1,1,444,'Present','gdf','2014-09-03 11:12:42'),(0,1,1,333,'Present','dfs','2014-09-03 11:14:29'),(0,1,1,4234,'Present','dsfdsf','2014-09-03 11:22:12'),(0,1,1,3333,'Present','fdgdf','2014-09-03 11:24:45'),(0,1,1,444,'Present','ds','2014-09-03 11:26:00'),(0,2,1,333,'Present','sdf','2014-09-03 11:26:21'),(0,2,2,777,'Present','fgr','2014-09-03 11:26:26'),(0,1,1,3334,'Present','ggggggg','2014-09-03 11:26:54'),(0,1,1,222,'Present','dfd','2014-09-03 11:30:50'),(0,2,1,222,'Broken','sds','2014-09-03 11:31:02');
/*!40000 ALTER TABLE `h_traycont` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `h_traystor`
--

DROP TABLE IF EXISTS `h_traystor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `h_traystor` (
  `tray_id` int(10) NOT NULL,
  `stor_id` int(10) NOT NULL DEFAULT '0',
  `usr_id` int(10) NOT NULL DEFAULT '0',
  `dttm` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `h_traystor`
--

LOCK TABLES `h_traystor` WRITE;
/*!40000 ALTER TABLE `h_traystor` DISABLE KEYS */;
INSERT INTO `h_traystor` VALUES (3,1,1,'2014-08-19 12:35:21'),(3,1,1,'2014-08-19 12:41:11'),(3,1,1,'2014-08-20 12:24:27'),(3,1,1,'2014-08-20 12:25:20'),(2,1,1,'2014-08-20 12:33:50'),(3,1,1,'2014-08-20 12:33:55'),(1,1,1,'2014-08-20 14:29:22'),(3,1,1,'2014-08-20 14:47:13'),(4,1,1,'2014-08-20 14:47:18'),(5,1,1,'2014-08-20 14:47:22'),(1,1,2,'2014-08-20 15:22:21'),(1,1,2,'2014-08-20 15:22:35'),(2,1,2,'2014-08-20 15:22:40'),(1,1,1,'2014-08-20 15:33:25'),(1,1,1,'2014-08-20 16:05:30'),(1,1,1,'2014-08-20 16:06:32'),(1,1,1,'2014-08-21 13:32:29'),(2,1,1,'2014-08-21 13:32:33'),(1,1,1,'2014-08-21 13:39:41'),(2,1,1,'2014-08-21 13:39:45'),(1,1,1,'2014-08-21 13:41:02'),(1,1,1,'2014-08-21 13:45:51'),(2,1,1,'2014-08-21 13:46:17'),(1,1,1,'2014-08-21 14:14:09'),(2,1,1,'2014-08-21 14:14:12'),(1,1,1,'2014-08-22 13:25:37'),(2,1,1,'2014-08-22 13:25:40'),(1,1,1,'2014-09-02 11:05:31'),(1,1,1,'2014-09-03 10:43:14'),(2,1,1,'2014-09-03 10:43:14'),(1,1,1,'2014-09-03 10:46:04'),(2,1,1,'2014-09-03 10:46:04'),(1,1,1,'2014-09-03 11:31:07'),(2,1,1,'2014-09-03 11:31:07'),(1,1,1,'2014-09-04 11:32:11'),(2,1,1,'2014-09-04 11:32:11'),(4,1,1,'2014-09-04 11:32:11'),(5,1,1,'2014-09-04 11:32:11'),(1,1,1,'2014-09-05 10:21:41'),(2,1,1,'2014-09-05 10:21:41'),(1,1,1,'2014-09-10 11:20:16'),(1,1,1,'2014-09-11 15:46:26'),(1,1,1,'2014-09-11 15:48:36'),(1,1,1,'2014-09-11 15:48:51'),(1,1,1,'2014-09-11 15:56:01'),(2,1,1,'2014-09-11 15:56:01'),(3,1,1,'2014-09-11 15:56:01'),(1,1,1,'2014-09-11 16:01:18');
/*!40000 ALTER TABLE `h_traystor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instruments`
--

DROP TABLE IF EXISTS `instruments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instruments` (
  `inst_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `partno` varchar(255) NOT NULL,
  `cmp_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`inst_id`),
  UNIQUE KEY `partno` (`partno`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruments`
--

LOCK TABLES `instruments` WRITE;
/*!40000 ALTER TABLE `instruments` DISABLE KEYS */;
INSERT INTO `instruments` VALUES (1,'Instrument 1','777777',1),(2,'Instrument 2','222',2),(3,'Instrument 3','333',3),(4,'Instrument 4','4343',0);
/*!40000 ALTER TABLE `instruments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proc_inst`
--

DROP TABLE IF EXISTS `proc_inst`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proc_inst` (
  `proc_id` int(10) NOT NULL,
  `inst_id` int(10) NOT NULL,
  `quant` int(4) NOT NULL DEFAULT '1',
  UNIQUE KEY `proc_id` (`proc_id`,`inst_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proc_inst`
--

LOCK TABLES `proc_inst` WRITE;
/*!40000 ALTER TABLE `proc_inst` DISABLE KEYS */;
INSERT INTO `proc_inst` VALUES (1,1,5656),(1,2,555);
/*!40000 ALTER TABLE `proc_inst` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proc_tag`
--

DROP TABLE IF EXISTS `proc_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proc_tag` (
  `proc_id` int(10) NOT NULL,
  `tag` varchar(80) NOT NULL,
  UNIQUE KEY `tag` (`tag`,`proc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proc_tag`
--

LOCK TABLES `proc_tag` WRITE;
/*!40000 ALTER TABLE `proc_tag` DISABLE KEYS */;
INSERT INTO `proc_tag` VALUES (1,'3'),(1,'New tag 2'),(1,'New Tag 22'),(1,'Shoulder Replacement'),(1,'Tag2');
/*!40000 ALTER TABLE `proc_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `procs`
--

DROP TABLE IF EXISTS `procs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `procs` (
  `proc_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `cmp_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`proc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procs`
--

LOCK TABLES `procs` WRITE;
/*!40000 ALTER TABLE `procs` DISABLE KEYS */;
INSERT INTO `procs` VALUES (1,'Procedure 1',1),(2,'Procedure 2',2),(3,'Procedure 3',3);
/*!40000 ALTER TABLE `procs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pwdresets`
--

DROP TABLE IF EXISTS `pwdresets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pwdresets` (
  `rst_id` int(10) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL,
  `typ` int(1) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'new',
  `code` varchar(25) NOT NULL,
  `dttm` datetime NOT NULL,
  PRIMARY KEY (`rst_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pwdresets`
--

LOCK TABLES `pwdresets` WRITE;
/*!40000 ALTER TABLE `pwdresets` DISABLE KEYS */;
/*!40000 ALTER TABLE `pwdresets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regions` (
  `reg_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(2) NOT NULL,
  `cmp_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reg_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regions`
--

LOCK TABLES `regions` WRITE;
/*!40000 ALTER TABLE `regions` DISABLE KEYS */;
INSERT INTO `regions` VALUES (1,'North Jersey','Jersey City\r\n','NJ',1),(3,'South jersey','SouthTown','NJ',1),(5,'Region 4','FourTown','KY',0);
/*!40000 ALTER TABLE `regions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `sess_id` int(10) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `touched` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sid` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`sess_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sevents`
--

DROP TABLE IF EXISTS `sevents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sevents` (
  `evt_id` int(10) NOT NULL AUTO_INCREMENT,
  `u_id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `item` varchar(512) NOT NULL,
  `was` varchar(512) NOT NULL,
  `now` varchar(512) NOT NULL,
  `dttm` datetime NOT NULL,
  PRIMARY KEY (`evt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sevents`
--

LOCK TABLES `sevents` WRITE;
/*!40000 ALTER TABLE `sevents` DISABLE KEYS */;
INSERT INTO `sevents` VALUES (1,1,'change.case','team_id','1','1','2014-08-19 15:09:09'),(2,1,'change.case','team_id','Team 1','Team 2','2014-08-19 15:41:38'),(3,1,'change.case','team_id','Team 2','Team 1','2014-08-19 15:43:31'),(4,1,'change.case','cmt','','Log this new comment!','2014-08-19 15:43:48'),(5,1,'change.case','site_id','Site 1','2','2014-08-19 15:44:09'),(6,1,'change.case','team_id','Team 1','','2014-08-19 15:44:21'),(7,1,'change.trayContents','Instrument 1','434','333','2014-08-19 15:45:06'),(8,1,'change.trayContents','Instrument 1','Present','Present','2014-08-19 15:45:06'),(9,1,'change.trayContents','Instrument 1','32dsf','dsfs','2014-08-19 15:45:06'),(10,1,'change.trayContents','Instrument 1','333','222','2014-08-19 15:47:21'),(11,1,'change.trayContents','Instrument 1','dsfs','sssssss','2014-08-19 15:47:21'),(12,1,'change.assignment','pu_usr','testuser2','testuser2','2014-08-19 15:52:45'),(13,1,'change.assignment','status','Pending','Overdue','2014-08-19 15:54:01'),(14,1,'change.region','city','','Jersey City\r\n','2014-08-19 15:57:09'),(15,1,'change.tray','loan_team','Team 1','','2014-08-19 16:02:20'),(16,1,'change.tray','loan_team','','Team 2','2014-08-19 16:04:02'),(17,1,'change.tray','partno','','11133','2014-08-19 16:06:14'),(18,1,'change.tray','partno','','5656','2014-08-19 16:06:27'),(19,1,'change.tray','partno','5656','777777','2014-08-19 16:06:48'),(20,1,'change.teams','state','NJ','NY','2014-08-19 16:10:27'),(21,1,'change.doctors','active','1','','2014-08-19 16:12:55'),(22,1,'change.doctors','active','0','','2014-08-19 16:12:57'),(23,1,'change.doctors','active','1','','2014-08-19 16:13:48'),(24,1,'change.doctors','active','0','','2014-08-19 16:13:50'),(25,1,'change.doctors','active','1','1','2014-08-19 16:14:37'),(26,1,'change.doctors','active','0','0','2014-08-19 16:14:38'),(27,1,'change.clients','active','1','0','2014-08-19 16:16:47'),(28,1,'change.clients','active','0','1','2014-08-19 16:16:49'),(29,1,'change.clients','active','1','Inactive','2014-08-19 16:17:16'),(30,1,'change.clients','active','0','Active','2014-08-19 16:17:17'),(31,1,'change.clients','sms','','55555555','2014-08-19 16:18:14'),(32,1,'change.company','zip','','55555','2014-08-19 16:26:00'),(33,1,'change.tray','loan_team','Team 2','','2014-08-20 12:52:57'),(34,1,'change.tray','loan_team','Team 2','','2014-08-20 12:53:00'),(35,1,'change.tray','loan_team','Team 2','','2014-08-20 12:55:15'),(36,1,'change.tray','loan_team','Team 2','Team 1','2014-08-20 12:55:33'),(37,1,'change.tray','loan_team','Team 2','','2014-08-20 12:58:16'),(38,1,'change.tray','team_id','Team 2','Team 1','2014-08-20 13:04:14'),(39,1,'change.assignment','pu_usr','testuser2','testuser','2014-08-20 14:12:55'),(40,1,'change.assignment','pu_usr','testuser2','','2014-08-20 14:13:23'),(41,1,'change.assignment','pu_usr','testuser2','testuser','2014-08-20 14:14:38'),(42,1,'change.assignment','pu_usr','testuser2','testuser','2014-08-20 14:15:46'),(43,1,'change.assignment','pu_usr','testuser','','2014-08-20 14:15:59'),(44,1,'change.assignment','pu_usr','','testuser','2014-08-20 14:16:20'),(45,1,'change.case','status','Complete','Pending','2014-08-20 14:49:46'),(46,1,'change.users','team_id','Team 2','Team 1','2014-08-20 15:13:00'),(47,1,'change.users','team_id','Team 2','Team 1','2014-08-20 15:13:52'),(48,1,'change.users','team_id','Team 2','Team 1','2014-08-20 15:14:16'),(49,1,'change.users','team_id','Team 2','Team 1','2014-08-20 15:17:10'),(50,1,'change.users','team_id','Team 1','','2014-08-20 15:20:05'),(51,1,'change.users','team_id','','Team 1','2014-08-20 15:20:08'),(52,1,'change.assignment','do_dttm','2014-08-20 14:03:00','','2014-08-20 15:31:11'),(53,1,'pickup.site','Tray 1','testuser','With testuser','2014-08-20 16:04:47'),(54,1,'dropoff.site','Tray 1','testuser','Site 2','2014-08-20 16:05:06'),(55,1,'pickup.site','Tray 1','testuser','With testuser','2014-08-20 16:05:24'),(56,1,'dropoff.storage','Tray 1','testuser','Storage 1','2014-08-20 16:05:30'),(57,1,'pickup.site','Tray 1','testuser','With testuser','2014-08-20 16:06:06'),(58,1,'dropoff.site','Tray 1','With testuser','Site 2','2014-08-20 16:06:13'),(59,1,'pickup.site','Tray 1','testuser','With testuser','2014-08-20 16:06:28'),(60,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-08-20 16:06:32'),(61,1,'change.users','lname','','','2014-08-21 11:29:20'),(62,1,'change.users','email','','','2014-08-21 11:29:31'),(63,1,'change.users','phone','','','2014-08-21 11:29:56'),(64,1,'change.users','sms','','','2014-08-21 11:30:00'),(65,1,'change.users','lname','LName\r\n','','2014-08-21 11:32:03'),(66,2,'change.clients','lname','','','2014-08-21 12:28:31'),(67,2,'change.clients','lname','','','2014-08-21 12:29:01'),(68,2,'change.clients','lname','','','2014-08-21 12:29:07'),(69,2,'change.clients','lname','','','2014-08-21 12:29:46'),(70,2,'change.clients','lname','dfd','dfd','2014-08-21 12:36:36'),(71,2,'change.clients','lname','dfd','zzzz','2014-08-21 12:36:50'),(72,2,'change.clients','lname','dfd','zzz','2014-08-21 12:37:27'),(73,2,'change.clients','lname','dfd','zzzz','2014-08-21 12:38:09'),(74,2,'change.clients','lname','dfd','zzz','2014-08-21 12:38:23'),(75,2,'change.clients','lname','dfd','zzz','2014-08-21 12:39:23'),(76,2,'change.clients','lname','zzz','zzzzzz','2014-08-21 12:39:54'),(77,2,'change.clients','lname','zzzzzz','zzz','2014-08-21 12:40:08'),(78,2,'change.clients','lname','zzz','zzzz','2014-08-21 12:40:15'),(79,2,'change.clients','email','','someone@someone.com','2014-08-21 12:40:23'),(80,2,'change.clients','phone','','555-5555','2014-08-21 12:40:29'),(81,2,'change.clients','sms','55555555','777-7777','2014-08-21 12:40:35'),(82,1,'change.users','fname','testuser','Johnny Joe','2014-08-21 13:11:05'),(83,1,'pickup.site','Tray 1','At site','With testuser','2014-08-21 13:24:53'),(84,1,'pickup.site','Tray 2','At site','With testuser','2014-08-21 13:24:59'),(85,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-08-21 13:32:29'),(86,1,'dropoff.storage','Tray 2','With testuser','Storage 1','2014-08-21 13:32:33'),(87,1,'pickup.site','Tray 1','At site','With testuser','2014-08-21 13:37:04'),(88,1,'pickup.site','Tray 2','At site','With testuser','2014-08-21 13:37:08'),(89,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-08-21 13:39:41'),(90,1,'dropoff.storage','Tray 2','With testuser','Storage 1','2014-08-21 13:39:45'),(91,1,'pickup.site','Tray 1','At site','With testuser','2014-08-21 13:40:51'),(92,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-08-21 13:41:02'),(93,1,'change.assignment','status','Complete','Pending','2014-08-21 13:41:06'),(94,1,'pickup.site','Tray 1','At site','With testuser','2014-08-21 13:41:36'),(95,1,'pickup.site','Tray 2','At site','With testuser','2014-08-21 13:41:42'),(96,1,'dropoff.site','Tray 1','With testuser','Site 1','2014-08-21 13:42:18'),(97,1,'pickup.site','Tray 1','At site','With testuser','2014-08-21 13:43:03'),(98,1,'dropoff.site','Tray 2','With testuser','Site 1','2014-08-21 13:43:16'),(99,1,'pickup.site','Tray 2','At site','With testuser','2014-08-21 13:43:41'),(100,1,'dropoff.site','Tray 1','With testuser','Site 1','2014-08-21 13:44:35'),(101,1,'pickup.site','Tray 1','At site','With testuser','2014-08-21 13:44:44'),(102,1,'pickup.site','Tray 1','At site','With testuser','2014-08-21 13:45:19'),(103,1,'pickup.site','Tray 1','At site','With testuser','2014-08-21 13:45:23'),(104,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-08-21 13:45:51'),(105,1,'dropoff.site','Tray 2','With testuser','Site 1','2014-08-21 13:45:59'),(106,1,'pickup.site','Tray 2','At site','With testuser','2014-08-21 13:46:09'),(107,1,'dropoff.storage','Tray 2','With testuser','Storage 1','2014-08-21 13:46:18'),(108,1,'pickup.site','Tray 1','At site','With testuser','2014-08-21 14:13:15'),(109,1,'pickup.site','Tray 2','At site','With testuser','2014-08-21 14:13:19'),(110,1,'dropoff.site','Tray 1','With testuser','Site 1','2014-08-21 14:13:31'),(111,1,'dropoff.site','Tray 2','With testuser','Site 2','2014-08-21 14:13:40'),(112,1,'pickup.site','Tray 1','At site','With testuser','2014-08-21 14:13:57'),(113,1,'pickup.site','Tray 2','At site','With testuser','2014-08-21 14:14:00'),(114,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-08-21 14:14:09'),(115,1,'dropoff.storage','Tray 2','With testuser','Storage 1','2014-08-21 14:14:12'),(116,1,'change.assignment','do_dttm','2014-08-22 13:39:00','2014-07-21 14:23:00','2014-08-21 14:23:09'),(117,1,'change.case','dttm','2014-08-20 13:03:26','2014-07-21 14:33:00','2014-08-21 14:33:13'),(118,2,'change.clients','perm','admin+','','2014-08-21 15:27:06'),(119,1,'pickup.site','Tray 1','At site','With testuser','2014-08-22 13:24:33'),(120,1,'pickup.site','Tray 2','At site','With testuser','2014-08-22 13:24:37'),(121,1,'dropoff.site','Tray 1','With testuser','Site 1','2014-08-22 13:25:05'),(122,1,'dropoff.site','Tray 2','With testuser','Site 1','2014-08-22 13:25:18'),(123,1,'pickup.site','Tray 1','At site','With testuser','2014-08-22 13:25:26'),(124,1,'pickup.site','Tray 2','At site','With testuser','2014-08-22 13:25:29'),(125,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-08-22 13:25:37'),(126,1,'dropoff.storage','Tray 2','With testuser','Storage 1','2014-08-22 13:25:40'),(127,1,'pickup.site','Tray 1','At site','With testuser','2014-09-02 11:05:21'),(128,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-09-02 11:05:31'),(129,1,'pickup.site','Tray 1','At site','With testuser','2014-09-02 11:55:34'),(130,1,'pickup.site','Tray 2','At site','With testuser','2014-09-02 12:01:21'),(131,1,'dropoff.site','Tray 1','With testuser','Site 1','2014-09-02 12:01:28'),(132,1,'dropoff.site','Tray 2','With testuser','Site 1','2014-09-02 12:01:34'),(133,1,'pickup.site','Tray 1','At site','With testuser','2014-09-03 10:28:05'),(134,1,'pickup.site','Tray 2','At site','With testuser','2014-09-03 10:28:17'),(135,1,'dropoff.site','','With testuser','','2014-09-03 10:28:29'),(136,1,'dropoff.site','','With testuser','','2014-09-03 10:28:29'),(137,1,'change.tray','atnow','site','stor','2014-09-03 10:29:59'),(138,1,'change.tray','atnow','stor','stor','2014-09-03 10:30:02'),(139,1,'change.tray','atnow','site','stor','2014-09-03 10:30:12'),(140,1,'change.tray','stor_id','','','2014-09-03 10:31:22'),(141,1,'change.tray','stor_id','','','2014-09-03 10:31:29'),(142,1,'pickup.site','','At site','With testuser','2014-09-03 10:31:41'),(143,1,'pickup.site','','At site','With testuser','2014-09-03 10:31:41'),(144,1,'dropoff.site','','With testuser','','2014-09-03 10:38:58'),(145,1,'dropoff.site','','With testuser','','2014-09-03 10:38:58'),(146,1,'change.tray','atnow','site','stor','2014-09-03 10:39:55'),(147,1,'change.tray','stor_id','','','2014-09-03 10:39:58'),(148,1,'change.tray','atnow','site','stor','2014-09-03 10:40:04'),(149,1,'change.tray','stor_id','','','2014-09-03 10:40:06'),(150,1,'pickup.site','','At site','With testuser','2014-09-03 10:40:21'),(151,1,'pickup.site','','At site','With testuser','2014-09-03 10:40:21'),(152,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-09-03 10:43:14'),(153,1,'dropoff.storage','Tray 2','With testuser','Storage 1','2014-09-03 10:43:15'),(154,1,'pickup.site','','At site','With testuser','2014-09-03 10:43:30'),(155,1,'pickup.site','','At site','With testuser','2014-09-03 10:43:30'),(156,1,'dropoff.site','Tray 1','With testuser','Site 1','2014-09-03 10:43:56'),(157,1,'dropoff.site','Tray 2','With testuser','Site 1','2014-09-03 10:43:56'),(158,1,'pickup.site','Tray 1','At site','With testuser','2014-09-03 10:45:55'),(159,1,'pickup.site','Tray 2','At site','With testuser','2014-09-03 10:45:55'),(160,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-09-03 10:46:04'),(161,1,'dropoff.storage','Tray 2','With testuser','Storage 1','2014-09-03 10:46:04'),(162,1,'pickup.site','Tray 1','At site','With testuser','2014-09-03 10:48:24'),(163,1,'pickup.site','Tray 2','At site','With testuser','2014-09-03 10:48:24'),(164,1,'dropoff.site','Tray 1','With testuser','Site 1','2014-09-03 10:57:42'),(165,1,'dropoff.site','Tray 2','With testuser','Site 1','2014-09-03 10:57:43'),(166,1,'pickup.site','Tray 1','At site','With testuser','2014-09-03 10:57:55'),(167,1,'pickup.site','Tray 2','At site','With testuser','2014-09-03 10:57:55'),(168,1,'change.trayContents','Instrument 1','','333','2014-09-03 11:07:08'),(169,1,'change.trayContents','Instrument 1','','Removed','2014-09-03 11:07:08'),(170,1,'change.trayContents','Instrument 1','','New comment!','2014-09-03 11:07:08'),(171,1,'change.trayContents','Instrument 1','222','7777','2014-09-03 11:08:36'),(172,1,'change.trayContents','Instrument 1','Present','Removed','2014-09-03 11:08:36'),(173,1,'change.trayContents','Instrument 1','sssssss','fdgdfg','2014-09-03 11:08:36'),(174,1,'change.trayContents','Instrument 1','7777','444','2014-09-03 11:12:41'),(175,1,'change.trayContents','Instrument 1','Removed','Present','2014-09-03 11:12:42'),(176,1,'change.trayContents','Instrument 1','fdgdfg','gdf','2014-09-03 11:12:42'),(177,1,'change.trayContents','Instrument 1','444','333','2014-09-03 11:14:29'),(178,1,'change.trayContents','Instrument 1','gdf','dfs','2014-09-03 11:14:29'),(179,1,'change.trayContents','Instrument 1','','444','2014-09-03 11:21:29'),(180,1,'change.trayContents','Instrument 1','','Present','2014-09-03 11:21:29'),(181,1,'change.trayContents','Instrument 1','','dfgd','2014-09-03 11:21:29'),(182,1,'change.trayContents','Instrument 1','333','4234','2014-09-03 11:22:11'),(183,1,'change.trayContents','Instrument 1','dfs','dsfdsf','2014-09-03 11:22:12'),(184,1,'change.trayContents','Instrument 1','4234','3333','2014-09-03 11:24:45'),(185,1,'change.trayContents','Instrument 1','dsfdsf','fdgdf','2014-09-03 11:24:45'),(186,1,'change.trayContents','Instrument 1','3333','444','2014-09-03 11:26:00'),(187,1,'change.trayContents','Instrument 1','fdgdf','ds','2014-09-03 11:26:00'),(188,1,'change.trayContents','Instrument 1','444','3334','2014-09-03 11:26:53'),(189,1,'change.trayContents','Instrument 1','ds','ggggggg','2014-09-03 11:26:54'),(190,1,'change.trayContents','Instrument 1','3334','222','2014-09-03 11:30:50'),(191,1,'change.trayContents','Instrument 1','ggggggg','dfd','2014-09-03 11:30:50'),(192,1,'change.trayContents','Instrument 1','333','222','2014-09-03 11:31:01'),(193,1,'change.trayContents','Instrument 1','Present','Broken','2014-09-03 11:31:02'),(194,1,'change.trayContents','Instrument 1','sdf','sds','2014-09-03 11:31:02'),(195,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-09-03 11:31:07'),(196,1,'dropoff.storage','Tray 2','With testuser','Storage 1','2014-09-03 11:31:07'),(197,1,'pickup.site','Tray 1','At site','With testuser','2014-09-04 11:10:37'),(198,1,'pickup.site','Tray 5','At site','With testuser','2014-09-04 11:10:37'),(199,1,'dropoff.site','Tray 1','With testuser','Site 1','2014-09-04 11:10:59'),(200,1,'dropoff.site','Tray 5','With testuser','Site 1','2014-09-04 11:10:59'),(201,1,'pickup.site','Tray 1','At site','With testuser','2014-09-04 11:11:14'),(202,1,'pickup.site','Tray 5','At site','With testuser','2014-09-04 11:11:14'),(203,1,'pickup.site','Tray 2','At site','With testuser','2014-09-04 11:22:36'),(204,1,'pickup.site','Tray 4','At site','With testuser','2014-09-04 11:22:37'),(205,1,'dropoff.site','Tray 2','With testuser','Site 2','2014-09-04 11:23:02'),(206,1,'dropoff.site','Tray 4','With testuser','Site 2','2014-09-04 11:23:02'),(207,1,'dropoff.site','Tray 5','With testuser','Site 2','2014-09-04 11:23:19'),(208,1,'pickup.site','Tray 2','At site','With testuser','2014-09-04 11:28:50'),(209,1,'pickup.site','Tray 4','At site','With testuser','2014-09-04 11:28:50'),(210,1,'pickup.site','Tray 5','At site','With testuser','2014-09-04 11:31:01'),(211,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-09-04 11:32:11'),(212,1,'dropoff.storage','Tray 2','With testuser','Storage 1','2014-09-04 11:32:11'),(213,1,'dropoff.storage','Tray 4','With testuser','Storage 1','2014-09-04 11:32:11'),(214,1,'dropoff.storage','Tray 5','With testuser','Storage 1','2014-09-04 11:32:11'),(215,1,'change.assignment','do_dttm','2014-09-04 10:47:00','2014-09-04 15:42:00','2014-09-04 13:42:43'),(216,1,'change.assignment','do_dttm','2014-09-04 10:47:00','2014-09-04 15:42:00','2014-09-04 13:42:52'),(217,1,'pickup.site','Tray 1','At site','With testuser','2014-09-04 14:37:58'),(218,1,'change.assignment','pu_usr','','testuser','2014-09-04 15:10:39'),(219,1,'change.assignment','pu_usr','','testuser','2014-09-04 15:11:18'),(220,1,'change.assignment','pu_usr','','testuser','2014-09-04 15:14:40'),(221,1,'change.assignment','do_dttm','2014-09-05 13:38:00','2014-09-08 15:15:00','2014-09-04 15:15:38'),(222,1,'change.assignment','do_dttm','2014-09-08 15:15:00','2014-09-05 15:15:00','2014-09-04 15:15:55'),(223,1,'pickup.site','Tray 2','At site','With testuser','2014-09-05 10:05:41'),(224,1,'dropoff.site','Tray 1','With testuser','Site 2','2014-09-05 10:06:05'),(225,1,'dropoff.site','Tray 2','With testuser','Site 2','2014-09-05 10:06:05'),(226,1,'pickup.site','Tray 1','At site','With testuser','2014-09-05 10:21:22'),(227,1,'pickup.site','Tray 2','At site','With testuser','2014-09-05 10:21:22'),(228,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-09-05 10:21:41'),(229,1,'dropoff.storage','Tray 2','With testuser','Storage 1','2014-09-05 10:21:41'),(230,1,'change.region','cmp_id','0','1','2014-09-05 14:02:14'),(231,1,'change.tray','cmp_id','','1','2014-09-05 15:17:44'),(232,1,'change.tray','cmp_id','0','1','2014-09-05 15:18:11'),(233,1,'change.tray','cmp_id','0','2','2014-09-05 15:18:19'),(234,1,'change.tray','cmp_id','0','3','2014-09-05 15:18:25'),(235,1,'change.tray','cmp_id','0','0','2014-09-05 15:18:37'),(236,1,'change.procedure','cmp_id','0','1','2014-09-05 15:32:58'),(237,1,'change.procedure','cmp_id','0','0','2014-09-05 15:33:05'),(238,1,'change.procedure','cmp_id','0','2','2014-09-05 15:33:08'),(239,1,'change.procedure','cmp_id','0','3','2014-09-05 15:33:14'),(240,1,'change.procedure','cmp_id','','2','2014-09-09 14:23:59'),(241,1,'change.case','status','Complete','Pending','2014-09-10 10:58:40'),(242,1,'pickup.site','Tray 1','At site','With testuser','2014-09-10 11:01:18'),(243,1,'dropoff.site','Tray 1','With testuser','Site 1','2014-09-10 11:01:36'),(244,1,'pickup.site','Tray 1','At site','With testuser','2014-09-10 11:03:28'),(245,1,'dropoff.site','Tray 1','With testuser','Site 1','2014-09-10 11:04:04'),(246,1,'change.assignment','pu_usr','testuser2','','2014-09-10 11:17:22'),(247,1,'change.assignment','pu_usr','','testuser2','2014-09-10 11:17:42'),(248,1,'change.assignment','pu_usr','testuser2','','2014-09-10 11:18:17'),(249,1,'pickup.site','Tray 1','At site','With testuser','2014-09-10 11:20:02'),(250,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-09-10 11:20:16'),(251,1,'change.assignment','pu_usr','testuser2','testuser','2014-09-11 11:02:23'),(252,1,'change.assignment','pu_dttm','2014-09-13 11:00:00','2014-09-16 11:03:00','2014-09-11 11:03:08'),(253,1,'change.case','team_id','','Team 1','2014-09-11 13:49:22'),(254,1,'create.case','Procedure 1','','','2014-09-11 14:03:48'),(255,1,'create.case','Procedure 1','','','2014-09-11 14:05:53'),(256,1,'create.case','Procedure 1','','','2014-09-11 14:06:30'),(257,1,'create.case','Procedure 1','','','2014-09-11 14:13:11'),(258,1,'pickup.site','Tray 1','At site','With testuser','2014-09-11 15:46:15'),(259,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-09-11 15:46:26'),(260,1,'pickup.site','Tray 1','At site','With testuser','2014-09-11 15:47:59'),(261,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-09-11 15:48:36'),(262,1,'pickup.site','Tray 1','At site','With testuser','2014-09-11 15:48:39'),(263,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-09-11 15:48:51'),(264,1,'pickup.site','Tray 1','At site','With testuser','2014-09-11 15:54:21'),(265,1,'pickup.site','Tray 2','At site','With testuser','2014-09-11 15:54:21'),(266,1,'pickup.site','Tray 3','At site','With testuser','2014-09-11 15:54:21'),(267,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-09-11 15:56:01'),(268,1,'dropoff.storage','Tray 2','With testuser','Storage 1','2014-09-11 15:56:01'),(269,1,'dropoff.storage','Tray 3','With testuser','Storage 1','2014-09-11 15:56:01'),(270,1,'pickup.site','Tray 1','At site','With testuser','2014-09-11 16:01:13'),(271,1,'dropoff.storage','Tray 1','With testuser','Storage 1','2014-09-11 16:01:18'),(272,1,'change.tray','loan_team','Team 2','','2014-09-15 10:54:59'),(273,1,'change.teams','head_id','testuser','testuser2','2014-09-15 11:35:36'),(274,1,'change.teams','head_id','testuser2','testuser','2014-09-15 11:37:01'),(275,1,'create.case','Procedure 1','','','2014-09-15 13:33:30'),(276,1,'new.request','Shoulder Surgery','','','2014-09-15 13:37:04'),(277,1,'new.request','Shoulder Surgery','','','2014-09-15 13:37:26'),(278,1,'new.request','Shoulder Surgery','','','2014-09-15 13:39:03'),(279,1,'new.request','Shoulder Surgery','','','2014-09-15 13:39:16'),(280,1,'new.request','Shoulder Surgery','','','2014-09-15 13:41:11'),(281,1,'fulfilled.request','Tray 1','','','2014-09-15 16:05:10'),(282,1,'fulfilled.request','Tray 1','','','2014-09-15 16:06:55'),(283,1,'fulfilled.request','Tray 1','','','2014-09-15 16:07:21'),(284,1,'fulfilled.request','Tray 1','','','2014-09-15 16:08:06'),(285,1,'new.request','Zombie Surgery\r\n','','','2014-09-15 16:08:37'),(286,1,'fulfilled.request','Tray 1','','','2014-09-15 16:08:43'),(287,1,'change.tray','loan_team','Team 1','','2014-09-15 16:09:17'),(288,2,'new.request','Shoulder Surgery','','','2014-09-15 16:10:06'),(289,1,'change.users','team_id','Team 1','0','2014-09-15 16:10:33'),(290,1,'change.users','team_id','','2','2014-09-15 16:10:36'),(291,2,'new.request','Foot Replacement','','','2014-09-15 16:13:15'),(292,1,'fulfilled.request','Tray 5','','','2014-09-15 16:13:32'),(293,1,'change.case','dttm','2014-09-12 13:41:00','2014-09-24 18:23:00','2014-09-23 10:23:36'),(294,1,'pickup.site','Tray 6','At site','With testuser','2015-02-11 16:00:49'),(295,1,'dropoff.site','Tray 6','With testuser','Site 2','2015-02-11 16:20:10'),(296,1,'pickup.site','Tray 6','At site','With testuser','2015-02-11 16:20:17');
/*!40000 ALTER TABLE `sevents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_region`
--

DROP TABLE IF EXISTS `site_region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_region` (
  `site_id` int(10) NOT NULL,
  `reg_id` int(10) NOT NULL,
  `cmp_id` int(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `site_id` (`site_id`,`reg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_region`
--

LOCK TABLES `site_region` WRITE;
/*!40000 ALTER TABLE `site_region` DISABLE KEYS */;
INSERT INTO `site_region` VALUES (1,1,0),(2,1,0);
/*!40000 ALTER TABLE `site_region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sites`
--

DROP TABLE IF EXISTS `sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites` (
  `site_id` int(10) NOT NULL AUTO_INCREMENT,
  `active` int(1) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `fax` varchar(10) NOT NULL,
  PRIMARY KEY (`site_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sites`
--

LOCK TABLES `sites` WRITE;
/*!40000 ALTER TABLE `sites` DISABLE KEYS */;
INSERT INTO `sites` VALUES (1,1,'Site 1','','','','',''),(2,1,'Site 2','','','','','');
/*!40000 ALTER TABLE `sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `storage`
--

DROP TABLE IF EXISTS `storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `storage` (
  `stor_id` int(10) NOT NULL AUTO_INCREMENT,
  `cmp_id` int(10) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(255) NOT NULL DEFAULT '',
  `zip` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`stor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `storage`
--

LOCK TABLES `storage` WRITE;
/*!40000 ALTER TABLE `storage` DISABLE KEYS */;
INSERT INTO `storage` VALUES (1,1,1,'Storage 1','555 Somewhere Street','Jersey City','NJ','98225');
/*!40000 ALTER TABLE `storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `tag` varchar(80) NOT NULL,
  `cmp_id` int(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `tag` (`tag`,`cmp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES ('Bionic Arm',0),('Brain Replacement',1),('Company 1 Tag',1),('Company 2 Tag',2),('Foot Surgery',2),('Hip Replacement',0),('Includes bone saw',1),('Power Drill',2),('Shoulder Replacement',0),('Zombie surgery',1);
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `team_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `region` varchar(40) NOT NULL DEFAULT '',
  `state` varchar(3) NOT NULL,
  `cmp_id` int(10) NOT NULL DEFAULT '0',
  `head_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'Team 1','North Jersey','NY',1,1),(2,'Team 2','North Jersey','',1,2);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tray_tag`
--

DROP TABLE IF EXISTS `tray_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tray_tag` (
  `tray_id` int(10) NOT NULL,
  `tag` varchar(80) NOT NULL,
  UNIQUE KEY `tray_id` (`tray_id`,`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tray_tag`
--

LOCK TABLES `tray_tag` WRITE;
/*!40000 ALTER TABLE `tray_tag` DISABLE KEYS */;
INSERT INTO `tray_tag` VALUES (1,'Brain Replacement'),(1,'Company 1 Tag'),(1,'Shoulder Replacement'),(2,'Bionic Arm'),(2,'Shoulder Replacement'),(3,'Power Drill'),(3,'Zombie surgery'),(4,'Hip Replacement'),(5,'Company 2 Tag'),(5,'Includes bone saw'),(5,'Power Drill');
/*!40000 ALTER TABLE `tray_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `traycont`
--

DROP TABLE IF EXISTS `traycont`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `traycont` (
  `tray_id` int(10) NOT NULL,
  `inst_id` int(10) NOT NULL,
  `quant` int(4) NOT NULL DEFAULT '1',
  `state` varchar(20) NOT NULL DEFAULT 'p',
  `cmt` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `tray_id` (`tray_id`,`inst_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traycont`
--

LOCK TABLES `traycont` WRITE;
/*!40000 ALTER TABLE `traycont` DISABLE KEYS */;
INSERT INTO `traycont` VALUES (1,1,222,'Present','dfd'),(1,2,231,'Present',''),(1,3,444,'Missing','dsfs'),(2,1,222,'Broken','sds'),(2,2,777,'Present','fgr'),(3,1,13,'Missing','Its gone!'),(3,2,22,'Present',''),(3,3,33,'Present',''),(5,1,7878,'Removed','LOG 444444');
/*!40000 ALTER TABLE `traycont` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trayreq`
--

DROP TABLE IF EXISTS `trayreq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trayreq` (
  `req_id` int(10) NOT NULL AUTO_INCREMENT,
  `ttyp_id` int(10) NOT NULL,
  `usr_id` int(10) NOT NULL,
  `team_id` int(10) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Pending',
  `cmt` varchar(1024) NOT NULL DEFAULT '',
  `dttm` datetime NOT NULL,
  PRIMARY KEY (`req_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trayreq`
--

LOCK TABLES `trayreq` WRITE;
/*!40000 ALTER TABLE `trayreq` DISABLE KEYS */;
INSERT INTO `trayreq` VALUES (1,1,1,1,'2014-09-15 13:37:00','2014-09-15 13:37:00','Loaned','dfgdsfsdf','2014-09-15 13:39:03'),(2,1,1,1,'2014-09-15 13:39:00','2014-09-15 13:39:00','Loaned','fgdfg','2014-09-15 13:39:16'),(3,1,1,1,'2014-09-15 13:39:00','2014-09-15 13:39:00','Loaned','fgdfg','2014-09-15 13:39:16'),(4,1,1,1,'2014-09-15 13:41:00','2014-09-15 13:41:00','Loaned','dfdsfds','2014-09-15 13:41:11'),(5,2,1,1,'2014-09-16 16:08:00','2014-09-19 16:08:00','Loaned','gfh','2014-09-15 16:08:37'),(7,3,2,2,'2014-09-15 16:13:00','2014-09-16 16:13:00','Loaned','Need!','2014-09-15 16:13:15');
/*!40000 ALTER TABLE `trayreq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trayresp`
--

DROP TABLE IF EXISTS `trayresp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trayresp` (
  `req_id` int(10) NOT NULL,
  `usr_id` int(10) NOT NULL,
  `team_id` int(10) NOT NULL,
  `tray_id` int(10) NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL DEFAULT 'Sent',
  `dttm` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cmt` varchar(1024) NOT NULL DEFAULT '',
  UNIQUE KEY `req_id` (`req_id`,`usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trayresp`
--

LOCK TABLES `trayresp` WRITE;
/*!40000 ALTER TABLE `trayresp` DISABLE KEYS */;
INSERT INTO `trayresp` VALUES (1,1,1,1,'Sent','2014-09-15 16:05:10','Loaned!'),(2,1,1,1,'Sent','2014-09-15 16:06:55','ddd'),(3,1,1,1,'Sent','2014-09-15 16:07:21','sddsf'),(4,1,1,1,'Sent','2014-09-15 16:08:06','dfsd'),(5,1,1,1,'Sent','2014-09-15 16:08:43','fgf'),(7,1,1,5,'Sent','2014-09-15 16:13:32','Here ya go');
/*!40000 ALTER TABLE `trayresp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trays`
--

DROP TABLE IF EXISTS `trays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trays` (
  `tray_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `cmp_id` int(10) NOT NULL,
  `team_id` int(10) NOT NULL,
  `atnow` varchar(20) NOT NULL DEFAULT 'unk',
  `usr_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL DEFAULT '0',
  `stor_id` int(10) NOT NULL DEFAULT '0',
  `loan_team` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tray_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trays`
--

LOCK TABLES `trays` WRITE;
/*!40000 ALTER TABLE `trays` DISABLE KEYS */;
INSERT INTO `trays` VALUES (1,'Tray 1',1,1,'stor',0,0,1,0),(2,'Tray 2',1,1,'stor',0,0,1,0),(3,'Tray 3',1,1,'stor',0,0,1,0),(4,'Tray 4',1,1,'stor',0,0,1,0),(5,'Tray 5',1,1,'stor',0,0,1,2),(6,'Tray 6',2,1,'usr',0,0,0,0);
/*!40000 ALTER TABLE `trays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `traytrans`
--

DROP TABLE IF EXISTS `traytrans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `traytrans` (
  `tran_id` int(10) NOT NULL AUTO_INCREMENT,
  `tray_id` int(10) NOT NULL,
  `signer` varchar(25) NOT NULL,
  `site_id` int(10) NOT NULL,
  `from_usr` int(10) NOT NULL DEFAULT '0',
  `to_usr` int(10) NOT NULL DEFAULT '0',
  `case_id` int(10) NOT NULL,
  `dttm` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traytrans`
--

LOCK TABLES `traytrans` WRITE;
/*!40000 ALTER TABLE `traytrans` DISABLE KEYS */;
INSERT INTO `traytrans` VALUES (1,5,'Johnny',1,1,2,2,'2014-08-20 12:32:35'),(2,1,'Mr. Pickup',1,1,2,7,'2014-08-20 13:14:07'),(3,1,'testuser',2,1,2,9,'2014-08-20 14:58:23'),(4,2,'TestUser',2,1,2,9,'2014-08-20 14:58:34'),(5,1,'dsds',2,1,2,9,'2014-08-20 14:59:57'),(6,2,'sadas',2,1,2,9,'2014-08-20 15:00:03'),(7,1,'rere',2,1,2,9,'2014-08-20 16:05:06'),(8,1,'tr',2,1,2,9,'2014-08-20 16:06:13'),(9,1,'ddd',1,1,0,14,'2014-08-21 13:42:18'),(10,1,'tyt',1,1,0,14,'2014-08-21 13:44:35'),(11,1,'sds',1,1,0,14,'2014-08-21 14:13:31'),(12,1,'eee',1,1,0,14,'2014-08-22 13:25:05'),(13,2,'eee',1,1,1,16,'2014-08-22 13:25:18'),(14,1,'sss',1,1,0,14,'2014-09-02 12:01:27'),(15,2,'fdfd',1,1,1,16,'2014-09-02 12:01:34'),(16,1,'ffff',1,1,0,14,'2014-09-03 10:43:56'),(17,2,'ffff',1,1,1,16,'2014-09-03 10:43:56'),(18,1,'sss',1,1,0,17,'2014-09-03 10:57:42'),(19,2,'sss',1,1,0,17,'2014-09-03 10:57:43'),(20,1,'please work!',1,1,0,17,'2014-09-04 11:10:59'),(21,5,'please work!',1,1,0,18,'2014-09-04 11:10:59'),(22,2,'ttt',2,1,0,19,'2014-09-04 11:23:02'),(23,5,'tt56',2,1,0,19,'2014-09-04 11:23:19'),(24,1,'sss',2,1,1,20,'2014-09-05 10:06:05'),(25,2,'sss',2,1,0,19,'2014-09-05 10:06:05'),(26,1,'yyy',1,1,2,23,'2014-09-10 11:01:35'),(27,1,'ttt',1,1,2,23,'2014-09-10 11:04:04');
/*!40000 ALTER TABLE `traytrans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ttyp`
--

DROP TABLE IF EXISTS `ttyp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ttyp` (
  `ttyp_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `cmp_id` int(10) NOT NULL,
  `team_id` int(10) NOT NULL,
  PRIMARY KEY (`ttyp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ttyp`
--

LOCK TABLES `ttyp` WRITE;
/*!40000 ALTER TABLE `ttyp` DISABLE KEYS */;
INSERT INTO `ttyp` VALUES (1,'Shoulder Surgery',1,1),(2,'Zombie Surgery\r\n',1,1),(3,'Foot Replacement',2,1);
/*!40000 ALTER TABLE `ttyp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ttyp_tag`
--

DROP TABLE IF EXISTS `ttyp_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ttyp_tag` (
  `ttyp_id` int(10) NOT NULL,
  `tag` varchar(80) NOT NULL,
  UNIQUE KEY `ttyp_id` (`ttyp_id`,`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ttyp_tag`
--

LOCK TABLES `ttyp_tag` WRITE;
/*!40000 ALTER TABLE `ttyp_tag` DISABLE KEYS */;
INSERT INTO `ttyp_tag` VALUES (1,'Power Drill'),(1,'Shoulder Replacement'),(2,'Brain Replacement'),(2,'Zombie surgery'),(3,'Foot Surgery'),(3,'Includes bone saw');
/*!40000 ALTER TABLE `ttyp_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unotifs`
--

DROP TABLE IF EXISTS `unotifs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unotifs` (
  `un_id` int(10) NOT NULL AUTO_INCREMENT,
  `usr_id` int(10) NOT NULL,
  `not_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `hidden` int(10) NOT NULL DEFAULT '0',
  `msg` varchar(255) NOT NULL,
  `dttm` datetime NOT NULL,
  `evdttm` datetime NOT NULL,
  `vwdttm` datetime NOT NULL,
  PRIMARY KEY (`un_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unotifs`
--

LOCK TABLES `unotifs` WRITE;
/*!40000 ALTER TABLE `unotifs` DISABLE KEYS */;
INSERT INTO `unotifs` VALUES (1,1,3,2,0,'Tray 1 picked up by: testuser','2014-09-11 16:01:13','2014-09-11 16:01:13','2014-09-11 16:01:20'),(2,0,6,2,0,'Dropoff for Tray 1 is unassigned.','2014-09-12 13:33:44','2014-09-12 13:33:44','2014-09-15 13:42:20'),(3,0,6,2,1,'Pickup for Tray 1 is unassigned.','2014-09-12 13:33:44','2014-09-12 13:33:44','2014-09-15 13:42:21'),(4,0,6,2,1,'Dropoff for Tray 1 is unassigned.','2014-09-12 13:33:44','2014-09-12 13:33:44','2014-09-15 13:42:21'),(5,1,7,3,0,'Case created by: testuser','2014-09-15 13:33:30','2014-09-15 13:33:30','2014-09-15 13:39:42'),(6,0,1,2,1,'Shoulder Surgery requested by testuser','2014-09-15 13:37:04','2014-09-15 13:37:04','2014-09-15 13:42:21'),(7,0,1,2,0,'Shoulder Surgery requested by testuser','2014-09-15 13:37:26','2014-09-15 13:37:26','2014-09-15 13:42:21'),(8,0,1,2,1,'Shoulder Surgery requested by testuser','2014-09-15 13:39:03','2014-09-15 13:39:03','2014-09-15 13:42:21'),(9,0,1,2,1,'Shoulder Surgery requested by testuser','2014-09-15 13:39:16','2014-09-15 13:39:16','2014-09-15 13:42:21'),(10,0,1,2,1,'Shoulder Surgery requested by testuser','2014-09-15 13:41:11','2014-09-15 13:41:11','2014-09-15 13:42:21'),(11,0,1,2,0,'Shoulder Surgery requested by testuser','2014-09-15 13:41:11','2014-09-15 13:41:11','2014-09-15 13:42:21'),(12,1,2,2,0,'Tray 1 loaned to Team 1','2014-09-15 16:05:10','2014-09-15 16:05:10','2014-09-15 16:05:22'),(13,1,2,2,0,'Tray 1 received on loan from Team 1<br/> Loaned!','2014-09-15 16:05:10','2014-09-15 16:05:10','2014-09-15 16:05:22'),(14,1,2,2,0,'Tray 1 loaned to Team 1','2014-09-15 16:06:55','2014-09-15 16:06:55','2014-09-16 10:09:43'),(15,1,2,2,0,'Tray 1 received on loan from Team 1<br/> ddd','2014-09-15 16:06:55','2014-09-15 16:06:55','2014-09-16 10:09:43'),(16,1,2,2,0,'Tray 1 loaned to Team 1','2014-09-15 16:07:21','2014-09-15 16:07:21','2014-09-16 10:09:43'),(17,1,2,2,0,'Tray 1 received on loan from Team 1<br/> sddsf','2014-09-15 16:07:21','2014-09-15 16:07:21','2014-09-16 10:09:43'),(18,1,2,2,0,'Tray 1 loaned to Team 1','2014-09-15 16:08:06','2014-09-15 16:08:06','2014-09-16 10:09:43'),(19,1,2,2,0,'Tray 1 received on loan from Team 1<br/> dfsd','2014-09-15 16:08:06','2014-09-15 16:08:06','2014-09-16 10:09:43'),(20,0,1,2,0,'Zombie Surgery\r\n requested by testuser','2014-09-15 16:08:37','2014-09-15 16:08:37','2014-09-15 16:13:52'),(21,1,2,2,0,'Tray 1 loaned to Team 1','2014-09-15 16:08:43','2014-09-15 16:08:43','2014-09-16 10:09:43'),(22,1,2,2,0,'Tray 1 received on loan from Team 1<br/> fgf','2014-09-15 16:08:43','2014-09-15 16:08:43','2014-09-16 10:09:43'),(23,0,1,2,0,'Shoulder Surgery requested by testuser2','2014-09-15 16:10:06','2014-09-15 16:10:06','2014-09-15 16:13:52'),(24,0,1,2,0,'Foot Replacement requested by testuser2','2014-09-15 16:13:16','2014-09-15 16:13:16','2014-09-15 16:13:52'),(25,1,2,2,0,'Tray 5 loaned to Team 2','2014-09-15 16:13:32','2014-09-15 16:13:32','2014-09-16 10:09:43'),(26,2,2,2,0,'Tray 5 received on loan from Team 1<br/> Here ya go','2014-09-15 16:13:32','2014-09-15 16:13:32','2014-09-15 16:13:52'),(27,1,3,2,0,'Tray 6 picked up by: testuser','2015-02-11 16:00:50','2015-02-11 16:00:50','2015-02-11 16:19:52'),(28,1,3,2,0,'Tray 6 picked up by: testuser','2015-02-11 16:20:17','2015-02-11 16:20:17','2015-02-11 16:20:19');
/*!40000 ALTER TABLE `unotifs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `usr_id` int(10) NOT NULL AUTO_INCREMENT,
  `active` int(1) NOT NULL DEFAULT '1',
  `team_id` int(10) NOT NULL DEFAULT '0',
  `fname` varchar(255) NOT NULL DEFAULT '',
  `lname` varchar(255) NOT NULL DEFAULT '',
  `uname` varchar(36) NOT NULL DEFAULT '',
  `pwd` varchar(36) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(25) NOT NULL DEFAULT '',
  `sms` varchar(25) NOT NULL DEFAULT '',
  `perm` varchar(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,1,'Johnny Joe','LName','testuser','testuser','somewhere@cool.com','555-5555','666-6666','admin+'),(2,1,2,'testuser2','','testuser2','testuser2','','','','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usr_cmp`
--

DROP TABLE IF EXISTS `usr_cmp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usr_cmp` (
  `usr_id` int(10) NOT NULL,
  `cmp_id` int(10) NOT NULL,
  `rel` varchar(20) NOT NULL DEFAULT 'emp',
  UNIQUE KEY `usr_id` (`usr_id`,`cmp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usr_cmp`
--

LOCK TABLES `usr_cmp` WRITE;
/*!40000 ALTER TABLE `usr_cmp` DISABLE KEYS */;
INSERT INTO `usr_cmp` VALUES (1,1,'Employee'),(1,2,'Distributor'),(2,2,'Employee');
/*!40000 ALTER TABLE `usr_cmp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-12 10:03:20
