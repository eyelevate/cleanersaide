-- MySQL dump 10.13  Distrib 5.1.70, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: cleanersaide2
-- ------------------------------------------------------
-- Server version	5.1.70-0ubuntu0.10.04.1-log

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
-- Table structure for table `acl_permissions`
--

DROP TABLE IF EXISTS `acl_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=488 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_permissions`
--

LOCK TABLES `acl_permissions` WRITE;
/*!40000 ALTER TABLE `acl_permissions` DISABLE KEYS */;
INSERT INTO `acl_permissions` VALUES (405,'controllers/Access/index',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(406,'controllers/Access/initializeAccessControl',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(407,'controllers/Access/add',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(408,'controllers/Access/edit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(409,'controllers/Access/view',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(410,'controllers/Access/delete',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(411,'controllers/Admins/login',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(412,'controllers/Admins/logout',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(413,'controllers/Admins/index',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(414,'controllers/Admins/search_customers',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(415,'controllers/Admins/add',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(416,'controllers/Admins/edit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(417,'controllers/Admins/view',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(418,'controllers/Admins/delete',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(419,'controllers/Companies/index',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(420,'controllers/Companies/add',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(421,'controllers/Companies/edit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(422,'controllers/Companies/view',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(423,'controllers/Companies/delete',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(424,'controllers/Deliveries/index',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(425,'controllers/Deliveries/view',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(426,'controllers/Deliveries/add',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(427,'controllers/Deliveries/edit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(428,'controllers/Deliveries/delete',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(429,'controllers/Groups/index',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(430,'controllers/Groups/view',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(431,'controllers/Groups/initializeAcl',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(432,'controllers/Groups/add',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(433,'controllers/Groups/edit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(434,'controllers/Groups/delete',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(435,'controllers/Inventories/index',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(436,'controllers/Inventories/add',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(437,'controllers/Inventories/edit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(438,'controllers/Inventories/view',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(439,'controllers/Inventories/delete',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(440,'controllers/InventoryItems/index',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(441,'controllers/InventoryItems/add',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(442,'controllers/InventoryItems/edit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(443,'controllers/InventoryItems/view',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(444,'controllers/InventoryItems/delete',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(445,'controllers/Invoices/index',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(446,'controllers/Invoices/dropoff',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(447,'controllers/Invoices/pickup',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(448,'controllers/Invoices/process_dropoff',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(449,'controllers/Invoices/process_pickup',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(450,'controllers/Invoices/add',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(451,'controllers/Invoices/edit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(452,'controllers/Invoices/view',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(453,'controllers/Invoices/delete',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(454,'controllers/Menus/index',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(455,'controllers/Menus/view',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(456,'controllers/Menus/add',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(457,'controllers/Menus/edit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(458,'controllers/Menus/delete',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(459,'controllers/Menus/request',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(460,'controllers/Pages/index',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(461,'controllers/Pages/home',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(462,'controllers/Pages/hotels_attractions',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(463,'controllers/Pages/add',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(464,'controllers/Pages/delete',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(465,'controllers/Pages/validate_form',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(466,'controllers/Pages/view',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(467,'controllers/Pages/edit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(468,'controllers/Pages/edit_home',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(469,'controllers/Pages/logout',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(470,'controllers/Pages/preview',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(471,'controllers/Pages/url',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(472,'controllers/Pages/publish',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(473,'controllers/Pages/test',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(474,'controllers/Taxes/index',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(475,'controllers/Taxes/add',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(476,'controllers/Taxes/edit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(477,'controllers/Taxes/view',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(478,'controllers/Taxes/delete',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(479,'controllers/Users/index',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(480,'controllers/Users/view',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(481,'controllers/Users/add',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(482,'controllers/Users/edit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(483,'controllers/Users/delete',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(484,'controllers/Users/forgot',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(485,'controllers/Users/reset',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(486,'controllers/Users/new_customers',1,'2013-08-21 16:20:42','2013-08-21 16:20:42'),(487,'controllers/DebugKit',1,'2013-08-21 16:20:42','2013-08-21 16:20:42');
/*!40000 ALTER TABLE `acl_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acos`
--

DROP TABLE IF EXISTS `acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acos`
--

LOCK TABLES `acos` WRITE;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
INSERT INTO `acos` VALUES (1,NULL,NULL,NULL,'controllers',1,236),(2,1,NULL,NULL,'Access',2,15),(3,2,NULL,NULL,'index',3,4),(4,2,NULL,NULL,'initializeAccessControl',5,6),(5,2,NULL,NULL,'add',7,8),(6,2,NULL,NULL,'edit',9,10),(7,2,NULL,NULL,'view',11,12),(8,2,NULL,NULL,'delete',13,14),(9,1,NULL,NULL,'Admins',16,33),(10,9,NULL,NULL,'login',17,18),(11,9,NULL,NULL,'logout',19,20),(12,9,NULL,NULL,'index',21,22),(13,9,NULL,NULL,'search_customers',23,24),(14,9,NULL,NULL,'add',25,26),(15,9,NULL,NULL,'edit',27,28),(16,9,NULL,NULL,'view',29,30),(17,9,NULL,NULL,'delete',31,32),(18,1,NULL,NULL,'Companies',34,45),(19,18,NULL,NULL,'index',35,36),(20,18,NULL,NULL,'add',37,38),(21,18,NULL,NULL,'edit',39,40),(22,18,NULL,NULL,'view',41,42),(23,18,NULL,NULL,'delete',43,44),(24,1,NULL,NULL,'Deliveries',46,57),(25,24,NULL,NULL,'index',47,48),(26,24,NULL,NULL,'view',49,50),(27,24,NULL,NULL,'add',51,52),(28,24,NULL,NULL,'edit',53,54),(29,24,NULL,NULL,'delete',55,56),(30,1,NULL,NULL,'Groups',58,71),(31,30,NULL,NULL,'index',59,60),(32,30,NULL,NULL,'view',61,62),(33,30,NULL,NULL,'initializeAcl',63,64),(34,30,NULL,NULL,'add',65,66),(35,30,NULL,NULL,'edit',67,68),(36,30,NULL,NULL,'delete',69,70),(37,1,NULL,NULL,'Inventories',72,83),(38,37,NULL,NULL,'index',73,74),(39,37,NULL,NULL,'add',75,76),(40,37,NULL,NULL,'edit',77,78),(41,37,NULL,NULL,'view',79,80),(42,37,NULL,NULL,'delete',81,82),(43,1,NULL,NULL,'InventoryItems',84,95),(44,43,NULL,NULL,'index',85,86),(45,43,NULL,NULL,'add',87,88),(46,43,NULL,NULL,'edit',89,90),(47,43,NULL,NULL,'view',91,92),(48,43,NULL,NULL,'delete',93,94),(49,1,NULL,NULL,'Invoices',96,115),(50,49,NULL,NULL,'index',97,98),(51,49,NULL,NULL,'dropoff',99,100),(52,49,NULL,NULL,'pickup',101,102),(53,49,NULL,NULL,'process_dropoff',103,104),(54,49,NULL,NULL,'process_pickup',105,106),(55,49,NULL,NULL,'add',107,108),(56,49,NULL,NULL,'edit',109,110),(57,49,NULL,NULL,'view',111,112),(58,49,NULL,NULL,'delete',113,114),(59,1,NULL,NULL,'Menus',116,129),(60,59,NULL,NULL,'index',117,118),(61,59,NULL,NULL,'view',119,120),(62,59,NULL,NULL,'add',121,122),(63,59,NULL,NULL,'edit',123,124),(64,59,NULL,NULL,'delete',125,126),(65,59,NULL,NULL,'request',127,128),(66,1,NULL,NULL,'Pages',130,159),(67,66,NULL,NULL,'index',131,132),(68,66,NULL,NULL,'home',133,134),(69,66,NULL,NULL,'hotels_attractions',135,136),(70,66,NULL,NULL,'add',137,138),(71,66,NULL,NULL,'delete',139,140),(72,66,NULL,NULL,'validate_form',141,142),(73,66,NULL,NULL,'view',143,144),(74,66,NULL,NULL,'edit',145,146),(75,66,NULL,NULL,'edit_home',147,148),(76,66,NULL,NULL,'logout',149,150),(77,66,NULL,NULL,'preview',151,152),(78,66,NULL,NULL,'url',153,154),(79,66,NULL,NULL,'publish',155,156),(80,66,NULL,NULL,'test',157,158),(81,1,NULL,NULL,'Reports',160,191),(82,81,NULL,NULL,'daily_accounting',161,162),(83,81,NULL,NULL,'download',163,164),(84,81,NULL,NULL,'vouchers',165,166),(85,81,NULL,NULL,'request_voucher_list',167,168),(86,81,NULL,NULL,'request_voucher_pdf',169,170),(87,81,NULL,NULL,'room_nights_report',171,172),(88,81,NULL,NULL,'booking_report',173,174),(89,81,NULL,NULL,'request_bookings',175,176),(90,81,NULL,NULL,'accounting',177,178),(91,81,NULL,NULL,'request_room_nights',179,180),(92,81,NULL,NULL,'index',181,182),(93,81,NULL,NULL,'add',183,184),(94,81,NULL,NULL,'edit',185,186),(95,81,NULL,NULL,'delete',187,188),(96,81,NULL,NULL,'view',189,190),(97,1,NULL,NULL,'Taxes',192,203),(98,97,NULL,NULL,'index',193,194),(99,97,NULL,NULL,'add',195,196),(100,97,NULL,NULL,'edit',197,198),(101,97,NULL,NULL,'view',199,200),(102,97,NULL,NULL,'delete',201,202),(103,1,NULL,NULL,'Users',204,221),(104,103,NULL,NULL,'index',205,206),(105,103,NULL,NULL,'view',207,208),(106,103,NULL,NULL,'add',209,210),(107,103,NULL,NULL,'edit',211,212),(108,103,NULL,NULL,'delete',213,214),(109,103,NULL,NULL,'forgot',215,216),(110,103,NULL,NULL,'reset',217,218),(111,103,NULL,NULL,'new_customers',219,220),(112,1,NULL,NULL,'DebugKit',222,235),(113,112,NULL,NULL,'',223,234),(114,113,NULL,NULL,'add',224,225),(115,113,NULL,NULL,'edit',226,227),(116,113,NULL,NULL,'index',228,229),(117,113,NULL,NULL,'view',230,231),(118,113,NULL,NULL,'delete',232,233);
/*!40000 ALTER TABLE `acos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aros`
--

DROP TABLE IF EXISTS `aros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros`
--

LOCK TABLES `aros` WRITE;
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;
INSERT INTO `aros` VALUES (1,NULL,'Group',1,NULL,1,6),(2,NULL,'Group',2,NULL,7,8),(3,NULL,'Group',3,NULL,9,10),(4,NULL,'Group',4,NULL,11,12),(5,NULL,'Group',5,NULL,13,18),(6,1,'User',1,NULL,2,3),(7,1,'User',7524,NULL,4,5),(8,5,'User',7525,NULL,14,15),(9,5,'User',7526,NULL,16,17);
/*!40000 ALTER TABLE `aros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aros_acos`
--

DROP TABLE IF EXISTS `aros_acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros_acos`
--

LOCK TABLES `aros_acos` WRITE;
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
INSERT INTO `aros_acos` VALUES (1,1,1,'-1','-1','-1','-1'),(2,1,3,'1','1','1','1'),(3,1,4,'1','1','1','1'),(4,1,5,'1','1','1','1'),(5,1,6,'1','1','1','1'),(6,1,7,'1','1','1','1'),(7,1,8,'1','1','1','1'),(8,1,10,'1','1','1','1'),(9,1,11,'1','1','1','1'),(10,1,12,'1','1','1','1'),(11,1,13,'1','1','1','1'),(12,1,14,'1','1','1','1'),(13,1,15,'1','1','1','1'),(14,1,16,'1','1','1','1'),(15,1,17,'1','1','1','1'),(16,1,19,'1','1','1','1'),(17,1,20,'1','1','1','1'),(18,1,21,'1','1','1','1'),(19,1,22,'1','1','1','1'),(20,1,23,'1','1','1','1'),(21,1,25,'1','1','1','1'),(22,1,26,'1','1','1','1'),(23,1,27,'1','1','1','1'),(24,1,28,'1','1','1','1'),(25,1,29,'1','1','1','1'),(26,1,31,'1','1','1','1'),(27,1,32,'1','1','1','1'),(28,1,33,'1','1','1','1'),(29,1,34,'1','1','1','1'),(30,1,35,'1','1','1','1'),(31,1,36,'1','1','1','1'),(32,1,38,'1','1','1','1'),(33,1,39,'1','1','1','1'),(34,1,40,'1','1','1','1'),(35,1,41,'1','1','1','1'),(36,1,42,'1','1','1','1'),(37,1,44,'1','1','1','1'),(38,1,45,'1','1','1','1'),(39,1,46,'1','1','1','1'),(40,1,47,'1','1','1','1'),(41,1,48,'1','1','1','1'),(42,1,50,'1','1','1','1'),(43,1,51,'1','1','1','1'),(44,1,52,'1','1','1','1'),(45,1,53,'1','1','1','1'),(46,1,54,'1','1','1','1'),(47,1,55,'1','1','1','1'),(48,1,56,'1','1','1','1'),(49,1,57,'1','1','1','1'),(50,1,58,'1','1','1','1'),(51,1,60,'1','1','1','1'),(52,1,61,'1','1','1','1'),(53,1,62,'1','1','1','1'),(54,1,63,'1','1','1','1'),(55,1,64,'1','1','1','1'),(56,1,65,'1','1','1','1'),(57,1,67,'1','1','1','1'),(58,1,68,'1','1','1','1'),(59,1,69,'1','1','1','1'),(60,1,70,'1','1','1','1'),(61,1,71,'1','1','1','1'),(62,1,72,'1','1','1','1'),(63,1,73,'1','1','1','1'),(64,1,74,'1','1','1','1'),(65,1,75,'1','1','1','1'),(66,1,76,'1','1','1','1'),(67,1,77,'1','1','1','1'),(68,1,78,'1','1','1','1'),(69,1,79,'1','1','1','1'),(70,1,80,'1','1','1','1'),(71,1,98,'1','1','1','1'),(72,1,99,'1','1','1','1'),(73,1,100,'1','1','1','1'),(74,1,101,'1','1','1','1'),(75,1,102,'1','1','1','1'),(76,1,104,'1','1','1','1'),(77,1,105,'1','1','1','1'),(78,1,106,'1','1','1','1'),(79,1,107,'1','1','1','1'),(80,1,108,'1','1','1','1'),(81,1,109,'1','1','1','1'),(82,1,110,'1','1','1','1'),(83,1,111,'1','1','1','1'),(84,1,112,'1','1','1','1'),(85,2,1,'-1','-1','-1','-1'),(86,3,1,'-1','-1','-1','-1'),(87,4,1,'-1','-1','-1','-1'),(88,5,1,'-1','-1','-1','-1');
/*!40000 ALTER TABLE `aros_acos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `street` varchar(250) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(5) DEFAULT NULL,
  `owner` varchar(100) DEFAULT NULL,
  `password` char(40) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'Jays Cleaners','','','WA','','wondollaballa','f7161854aacd9a831dd7fb2d35dc3afc0f6b50ab','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Super Administrator','2013-06-24 09:16:33','2013-08-21 16:20:42'),(2,'Administrator','2013-06-24 09:16:41','2013-06-24 09:16:41'),(3,'Manager','2013-06-24 09:16:53','2013-06-24 09:16:53'),(4,'Employee','2013-06-24 09:17:03','2013-06-24 09:17:03'),(5,'Member','2013-06-24 09:17:09','2013-06-24 09:17:09');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventories`
--

DROP TABLE IF EXISTS `inventories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventories`
--

LOCK TABLES `inventories` WRITE;
/*!40000 ALTER TABLE `inventories` DISABLE KEYS */;
INSERT INTO `inventories` VALUES (1,1,'Dry Clean','All dry clean items','2013-08-21 11:50:56','2013-08-21 11:50:56'),(2,1,'Laundry','All laundered Items','2013-08-21 11:51:14','2013-08-21 11:51:24');
/*!40000 ALTER TABLE `inventories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_items`
--

DROP TABLE IF EXISTS `inventory_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(11,2) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_items`
--

LOCK TABLES `inventory_items` WRITE;
/*!40000 ALTER TABLE `inventory_items` DISABLE KEYS */;
INSERT INTO `inventory_items` VALUES (1,1,1,'Dry Clean Shirt','Test Dry Clean ','5.50','/img/inventory/shirtsDC_black.png','2013-08-26 22:57:51','2013-08-26 22:57:51'),(2,1,1,'Dress','Test','7.50','/img/inventory/dressShort_pink.png','2013-08-28 01:53:51','2013-08-28 01:53:51');
/*!40000 ALTER TABLE `inventory_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_id` int(11) DEFAULT NULL,
  `invoice_id` int(6) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `colors` varchar(50) DEFAULT NULL,
  `pretax` decimal(11,2) DEFAULT NULL,
  `tax` decimal(11,2) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_items`
--

LOCK TABLES `invoice_items` WRITE;
/*!40000 ALTER TABLE `invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(6) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `pretax` decimal(11,2) DEFAULT NULL,
  `tax` decimal(11,2) DEFAULT NULL,
  `discount` decimal(11,2) DEFAULT NULL,
  `discount_id` int(11) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_items` (
  `menu_id` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `tier` int(3) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `orders` int(3) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (3,'Main Menu',1,'Main Header',1,'icon-th-large','2013-08-21 12:04:59','2013-08-21 12:04:59'),(3,'Drop Off / Pickup',2,'/invoices/index',3,'NULL','2013-08-21 12:04:59','2013-08-21 12:04:59'),(3,'Setup',1,'Main Header',4,'icon-cog','2013-08-21 12:04:59','2013-08-21 12:04:59'),(3,'View Inventory Groups',3,'/inventories/index',6,'NULL','2013-08-21 12:05:00','2013-08-21 12:05:00'),(3,'Home',2,'/admins/index',2,'NULL','2013-08-21 12:05:00','2013-08-21 12:05:00'),(3,'Inventory Template',2,'Sub Header',5,'NULL','2013-08-21 12:05:00','2013-08-21 12:05:00'),(3,'Add Inventory Group',3,'/inventories/add',7,'NULL','2013-08-21 12:05:01','2013-08-21 12:05:01'),(3,'Inventory Items Template',2,'Sub Header',8,'NULL','2013-08-21 12:05:01','2013-08-21 12:05:01'),(3,'View Inventory Items',3,'/inventory_items/index',9,'NULL','2013-08-21 12:05:01','2013-08-21 12:05:01'),(3,'Add Inventory Items',3,'/inventory_items/add',10,'NULL','2013-08-21 12:05:02','2013-08-21 12:05:02'),(3,'Taxes Template',2,'Sub Header',11,'NULL','2013-08-21 12:05:02','2013-08-21 12:05:02'),(3,'View Taxes',3,'/taxes/index',12,'NULL','2013-08-21 12:05:02','2013-08-21 12:05:02'),(3,'Add Tax',3,'/taxes/add',13,'NULL','2013-08-21 12:05:02','2013-08-21 12:05:02'),(3,'Menu Template',2,'Sub Header',14,'NULL','2013-08-21 12:05:03','2013-08-21 12:05:03'),(3,'View Menus',3,'/menus/index',15,'NULL','2013-08-21 12:05:03','2013-08-21 12:05:03'),(3,'Create Menu',3,'/menus/add',16,'NULL','2013-08-21 12:05:03','2013-08-21 12:05:03'),(3,'Delivery',1,'Main Header',17,'icon-road','2013-08-21 12:05:04','2013-08-21 12:05:04'),(3,'Accounts',1,'Main Header',18,'icon-folder-open','2013-08-21 12:05:04','2013-08-21 12:05:04'),(3,'Customers',1,'Main Header',19,'icon-user','2013-08-21 12:05:04','2013-08-21 12:05:04'),(3,'Customer Template',2,'Sub Header',20,'NULL','2013-08-21 12:05:04','2013-08-21 12:05:04'),(3,'View Customers',3,'/users/index',21,'NULL','2013-08-21 12:05:05','2013-08-21 12:05:05'),(3,'Add New Customer',3,'/users/new_customers',22,'NULL','2013-08-21 12:05:05','2013-08-21 12:05:05'),(3,'Web Page',1,'Main Header',23,'icon-globe','2013-08-21 12:05:05','2013-08-21 12:05:05'),(3,'Page Template',2,'Sub Header',24,'NULL','2013-08-21 12:05:05','2013-08-21 12:05:05'),(3,'View Pages',3,'/pages/view',25,'NULL','2013-08-21 12:05:05','2013-08-21 12:05:05'),(3,'Add Page',3,'/pages/add',26,'NULL','2013-08-21 12:05:05','2013-08-21 12:05:05');
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `edit_menu` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (3,'Admin','\n			\n			\n			\n			\n			\n			\n			\n			\n\n		<li label=\"Main Menu\" icon=\"icon-th-large\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-th-large\" chosen=\"icon-th-large\"></i> Main Menu - Main Header</span></span><button id=\"removeMenuRow\" name=\"Main Menu\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li class=\"\" style=\"\" label=\"Home\" icon=\"\" url=\"/admins/index\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Home - /admins/index</span></span><button id=\"removeMenuRow\" name=\"Home\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li label=\"Drop Off / Pickup\" icon=\"\" url=\"/invoices/index\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Drop Off / Pickup - /invoices/index</span></span><button id=\"removeMenuRow\" name=\"Drop Off / Pickup\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li label=\"Setup\" icon=\"icon-cog\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-cog\" chosen=\"icon-cog\"></i> Setup - Main Header</span></span><button id=\"removeMenuRow\" name=\"Setup\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li class=\"\" style=\"\" label=\"Inventory Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Inventory Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Inventory Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Inventory Groups\" icon=\"\" url=\"/inventories/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Inventory Groups - /inventories/index</span></span><button id=\"removeMenuRow\" name=\"View Inventory Groups\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Add Inventory Group\" icon=\"\" url=\"/inventories/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add Inventory Group - /inventories/add</span></span><button id=\"removeMenuRow\" name=\"Add Inventory Group\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li class=\"\" style=\"\" label=\"Inventory Items Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Inventory Items Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Inventory Items Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Inventory Items\" icon=\"\" url=\"/inventory_items/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Inventory Items - /inventory_items/index</span></span><button id=\"removeMenuRow\" name=\"View Inventory Items\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Add Inventory Items\" icon=\"\" url=\"/inventory_items/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add Inventory Items - /inventory_items/add</span></span><button id=\"removeMenuRow\" name=\"Add Inventory Items\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li class=\"\" style=\"\" label=\"Taxes Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Taxes Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Taxes Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Taxes\" icon=\"\" url=\"/taxes/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Taxes - /taxes/index</span></span><button id=\"removeMenuRow\" name=\"View Taxes\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Add Tax\" icon=\"\" url=\"/taxes/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add Tax - /taxes/add</span></span><button id=\"removeMenuRow\" name=\"Add Tax\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li class=\"\" style=\"\" label=\"Menu Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Menu Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Menu Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Menus\" icon=\"\" url=\"/menus/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Menus - /menus/index</span></span><button id=\"removeMenuRow\" name=\"View Menus\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Create Menu\" icon=\"\" url=\"/menus/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Create Menu - /menus/add</span></span><button id=\"removeMenuRow\" name=\"Create Menu\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li></ol></li><li label=\"Delivery\" icon=\"icon-road\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-road\" chosen=\"icon-road\"></i> Delivery - Main Header</span></span><button id=\"removeMenuRow\" name=\"Delivery\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li label=\"Accounts\" icon=\"icon-folder-open\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-folder-open\" chosen=\"icon-folder-open\"></i> Accounts - Main Header</span></span><button id=\"removeMenuRow\" name=\"Accounts\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li>				<li label=\"Customers\" icon=\"icon-user\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-user\" chosen=\"icon-user\"></i> Customers - Main Header</span></span><button id=\"removeMenuRow\" name=\"Customers\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li class=\"\" style=\"\" label=\"Customer Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Customer Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Customer Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Customers\" icon=\"\" url=\"/users/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Customers - /users/index</span></span><button id=\"removeMenuRow\" name=\"View Customers\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li label=\"Add New Customer\" icon=\"\" url=\"/users/new_customers\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add New Customer - /users/new_customers</span></span><button id=\"removeMenuRow\" name=\"Add New Customer\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li></ol></li>						<li label=\"Web Page\" icon=\"icon-globe\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-globe\" chosen=\"icon-globe\"></i> Web Page - Main Header</span></span><button id=\"removeMenuRow\" name=\"Web Page\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li class=\"\" style=\"\" label=\"Page Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Page Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Page Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Pages\" icon=\"\" url=\"/pages/view\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Pages - /pages/view</span></span><button id=\"removeMenuRow\" name=\"View Pages\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Add Page\" icon=\"\" url=\"/pages/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add Page - /pages/add</span></span><button id=\"removeMenuRow\" name=\"Add Page\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li></ol></li>						','2013-07-17 03:11:17','2013-08-21 12:04:57');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_contents`
--

DROP TABLE IF EXISTS `page_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_contents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `html` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_contents`
--

LOCK TABLES `page_contents` WRITE;
/*!40000 ALTER TABLE `page_contents` DISABLE KEYS */;
/*!40000 ALTER TABLE `page_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) DEFAULT NULL,
  `relationship` int(1) DEFAULT NULL,
  `page_name` varchar(100) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `keywords` text,
  `description` text,
  `layout` varchar(50) DEFAULT NULL,
  `menu_id` int(3) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxes`
--

DROP TABLE IF EXISTS `taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `country` varchar(10) DEFAULT NULL,
  `rate` decimal(11,2) DEFAULT NULL,
  `per_basis` varchar(10) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxes`
--

LOCK TABLES `taxes` WRITE;
/*!40000 ALTER TABLE `taxes` DISABLE KEYS */;
/*!40000 ALTER TABLE `taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` char(40) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_initial` varchar(1) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `contact_address` varchar(150) DEFAULT NULL,
  `contact_city` varchar(100) DEFAULT NULL,
  `contact_state` varchar(50) DEFAULT NULL,
  `contact_country` varchar(10) DEFAULT NULL,
  `contact_email` varchar(150) DEFAULT NULL,
  `contact_zip` varchar(20) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `token` varchar(8) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7527 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (7524,1,'wondollaballa','f7161854aacd9a831dd7fb2d35dc3afc0f6b50ab','onedough83@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-08-01 02:08:05','2013-08-01 02:08:05'),(7525,5,NULL,NULL,NULL,'Wondo',NULL,'Choung',NULL,'2406 24th ave East','seattle','WA',NULL,'onedough83@gmail.com','98112','2069315327',NULL,'2013-08-01 02:12:12','2013-08-01 02:12:12'),(7526,5,NULL,NULL,NULL,'Young-do',NULL,'Choung',NULL,'2406 24th ave East','seattle','WA',NULL,'onedough83@gmail.com','98112','2063209107',NULL,'2013-08-01 02:21:52','2013-08-01 02:21:52');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-08-29  0:34:24
