-- MySQL dump 10.13  Distrib 5.5.23, for Win32 (x86)
--
-- Host: localhost    Database: athena
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
  `status` varchar(25) NOT NULL DEFAULT '',
  `cmt` varchar(255) NOT NULL DEFAULT '',
  `do_usr` int(10) NOT NULL DEFAULT '0',
  `cli_nm` varchar(64) NOT NULL DEFAULT '',
  `do_dttm` datetime NOT NULL,
  `pu_dttm` datetime NOT NULL,
  `pu_usr` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`asgn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assigns`
--

LOCK TABLES `assigns` WRITE;
/*!40000 ALTER TABLE `assigns` DISABLE KEYS */;
INSERT INTO `assigns` VALUES (2,3,1,'Pending','dsfd',4,'','2014-08-05 16:06:00','2014-01-01 00:00:00',4),(3,3,3,'Pending','Finish this!',4,'','2014-08-05 16:09:00','2014-01-01 00:00:00',4),(4,2,5,'Overdue','Please finish this!',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(5,3,4,'Complete','This one is finished',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(6,2,1,'Pending','',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(7,2,1,'Pending','',0,'','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(8,2,1,'Pending','&&&&',4,'','2014-01-01 00:00:00','1999-11-30 00:00:00',1),(9,2,1,'Pending','&&&&',4,'','2014-01-01 00:00:00','1999-11-30 00:00:00',1),(12,2,6,'Complete','%$%$%$',4,'','2014-08-05 10:03:00','2014-11-05 10:03:00',1),(14,2,1,'Complete','DSSDS',2,'','2014-08-05 10:16:00','2025-11-12 09:11:00',4);
/*!40000 ALTER TABLE `assigns` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cases`
--

LOCK TABLES `cases` WRITE;
/*!40000 ALTER TABLE `cases` DISABLE KEYS */;
INSERT INTO `cases` VALUES (2,2,2,1,6,'Complete','2014-12-05 13:06:00','Hope This works'),(3,2,1,2,11,'Pending','2014-08-04 13:48:00','sfdsf'),(4,2,1,3,4,'Pending','2014-08-04 13:35:00','Completed Case'),(5,2,1,1,2,'Complete','2014-08-04 13:34:00','This case is new'),(6,2,1,1,6,'Pending','2014-08-04 11:51:00','new datetime!'),(7,2,1,1,4,'Pending','2014-08-04 14:09:00','user-created case'),(8,2,1,1,4,'Pending','2014-08-04 14:09:00','user-created case');
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
INSERT INTO `cli_site` VALUES (1,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,1,'ddd','ddd','dddsss','05878003d02eed82c5171a7c6f2cd460','sds@sds','543545','23432','');
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
INSERT INTO `company` VALUES (1,1,'Test Company 1','555 Somewhere Street','Portland','OR','98225'),(2,1,'Company 2','Company 2','sdf','sdf','sdf'),(3,1,'dddddddd','ddddddd','dddd','ddd','ddd');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
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
  UNIQUE KEY `doc_id` (`doc_id`,`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doc_site`
--

LOCK TABLES `doc_site` WRITE;
/*!40000 ALTER TABLE `doc_site` DISABLE KEYS */;
INSERT INTO `doc_site` VALUES (1,1),(1,2),(2,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctors`
--

LOCK TABLES `doctors` WRITE;
/*!40000 ALTER TABLE `doctors` DISABLE KEYS */;
INSERT INTO `doctors` VALUES (1,1,'Gotta Be Someone\r\n'),(2,1,'Jim Jom Jim');
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
INSERT INTO `dst_cmp` VALUES (1,1),(2,1),(2,2),(3,1);
/*!40000 ALTER TABLE `dst_cmp` ENABLE KEYS */;
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
  PRIMARY KEY (`inst_id`),
  UNIQUE KEY `partno` (`partno`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruments`
--

LOCK TABLES `instruments` WRITE;
/*!40000 ALTER TABLE `instruments` DISABLE KEYS */;
INSERT INTO `instruments` VALUES (1,'Band-aid','666666'),(2,'Stethiscope','4444'),(3,'Pliers','333');
/*!40000 ALTER TABLE `instruments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `procinsts`
--

DROP TABLE IF EXISTS `procinsts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `procinsts` (
  `proc_id` int(10) NOT NULL,
  `inst_id` int(10) NOT NULL,
  `quant` int(4) NOT NULL DEFAULT '1',
  UNIQUE KEY `proc_id` (`proc_id`,`inst_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procinsts`
--

LOCK TABLES `procinsts` WRITE;
/*!40000 ALTER TABLE `procinsts` DISABLE KEYS */;
INSERT INTO `procinsts` VALUES (1,1,343),(1,2,2232);
/*!40000 ALTER TABLE `procinsts` ENABLE KEYS */;
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
  PRIMARY KEY (`proc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procs`
--

LOCK TABLES `procs` WRITE;
/*!40000 ALTER TABLE `procs` DISABLE KEYS */;
INSERT INTO `procs` VALUES (1,'Procedure 1'),(2,'Procedure 2'),(3,'Procedure 3');
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
  PRIMARY KEY (`reg_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regions`
--

LOCK TABLES `regions` WRITE;
/*!40000 ALTER TABLE `regions` DISABLE KEYS */;
INSERT INTO `regions` VALUES (4,'North Jersey','','NJ'),(5,'Central Jersey','','NJ'),(6,'South Jersey','','NJ');
/*!40000 ALTER TABLE `regions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_region`
--

DROP TABLE IF EXISTS `site_region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_region` (
  `site_id` int(10) NOT NULL,
  `region` varchar(40) NOT NULL,
  UNIQUE KEY `site_id` (`site_id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_region`
--

LOCK TABLES `site_region` WRITE;
/*!40000 ALTER TABLE `site_region` DISABLE KEYS */;
INSERT INTO `site_region` VALUES (1,'Region 1'),(1,'Region 2'),(2,'Region 1');
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sites`
--

LOCK TABLES `sites` WRITE;
/*!40000 ALTER TABLE `sites` DISABLE KEYS */;
INSERT INTO `sites` VALUES (4,1,'BLOOMFIELD SURGERY CTR.     ','1255 Broad Street','Bloomfield','NJ','07003','2014839152'),(5,1,'ENDO SURGICAL','999 Clifton Avenue','Clifton ','NJ','07013','2014839152'),(6,1,'EXCEL SURGERY CENTER','321 Essex Street','Hackensack','NJ','07601','2014839152'),(7,1,'FAIRLAWN AMBULATORY SURG CTR','15-01 Pollitt Drive','Fair Lawn','NJ','07410','2014839152'),(8,1,'GARDEN STATE SURG CTR       ','28-06 Broadway','Fair Lawn','NJ','07410','2014839152'),(9,1,'HACKENSACK UNIV. MED CTR CAS','30 Prospect Street','Hackensack','NJ','07601','2014839152'),(10,1,'JERSEY CITY MEDICAL CENTER','101 Jersey Avenue','Jersey City','NJ','07302','2014839152'),(11,1,'LIBERTY AMBULATORY SURGERY  ','377 Jersey Avenue ','Jersey City','NJ','07302','2014839152'),(12,1,'LUCKOW PAVILLION','223 North Van Dien Ave','Ridgewood','NJ','07450','2014839152');
/*!40000 ALTER TABLE `sites` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (2,'Super Team','Portland','OR',1,4),(3,'Another Team','Washington','WA',3,2),(5,'sad','asd','as',1,1);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
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
  `state` varchar(20) NOT NULL DEFAULT 'Present',
  `cmt` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `tray_id` (`tray_id`,`inst_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traycont`
--

LOCK TABLES `traycont` WRITE;
/*!40000 ALTER TABLE `traycont` DISABLE KEYS */;
INSERT INTO `traycont` VALUES (1,1,8888,'Removed','This comment was modified by a driver'),(1,2,2343,'Present','it\'s alive ;;;;'),(1,3,44,'Present',''),(5,1,54,'Present',''),(5,2,3453,'Present',''),(5,3,3453,'Present','');
/*!40000 ALTER TABLE `traycont` ENABLE KEYS */;
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
  `site_id` int(10) NOT NULL DEFAULT '0',
  `loan_team` int(10) NOT NULL DEFAULT '0',
  `status` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`tray_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trays`
--

LOCK TABLES `trays` WRITE;
/*!40000 ALTER TABLE `trays` DISABLE KEYS */;
INSERT INTO `trays` VALUES (1,'Tray 1',1,2,4,5,'Loaned'),(3,'dfds',1,2,5,3,'Scheduled'),(5,'Tray 4',1,2,4,2,'Scheduled'),(6,'NewestTray',1,2,10,2,'Scheduled'),(7,'ReturnedTray',1,2,12,2,'Loaned');
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
  `to_team` int(10) NOT NULL,
  `from_usr` int(10) NOT NULL DEFAULT '0',
  `to_usr` int(10) NOT NULL DEFAULT '0',
  `case_id` int(10) NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT '',
  `dttm` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cmt` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`tran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traytrans`
--

LOCK TABLES `traytrans` WRITE;
/*!40000 ALTER TABLE `traytrans` DISABLE KEYS */;
/*!40000 ALTER TABLE `traytrans` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,1,'BossMan','Bill','BBilly','15de21c670ae7c3f6f3f1f37029303c9','80299434','342342','3423423',''),(2,1,1,'Johnny','Bill','JBill','9b49d796554287efd41ce49b6e7590c5','Fogerty','343242','324234',''),(3,1,2,'sdf','sdf','sdfdf','177a713ab085b249c7131ffed46528b4','sdf','sdf','sdf',''),(4,1,2,'test','user','testuser','testuser','ddd','4535','34534','');
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
INSERT INTO `usr_cmp` VALUES (1,3,'Employee'),(2,1,'Employee'),(2,3,'Employee'),(4,1,'Employee'),(4,2,'Distributor');
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

-- Dump completed on 2014-08-05 16:48:14
