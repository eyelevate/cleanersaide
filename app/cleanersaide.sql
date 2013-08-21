-- MySQL dump 10.13  Distrib 5.1.70, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: cleanersaide
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
) ENGINE=InnoDB AUTO_INCREMENT=405 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_permissions`
--

LOCK TABLES `acl_permissions` WRITE;
/*!40000 ALTER TABLE `acl_permissions` DISABLE KEYS */;
INSERT INTO `acl_permissions` VALUES (332,'controllers/Access/index',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(333,'controllers/Access/initializeAccessControl',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(334,'controllers/Access/add',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(335,'controllers/Access/edit',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(336,'controllers/Access/view',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(337,'controllers/Access/delete',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(338,'controllers/Admins/login',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(339,'controllers/Admins/logout',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(340,'controllers/Admins/index',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(341,'controllers/Admins/search_customers',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(342,'controllers/Admins/add',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(343,'controllers/Admins/edit',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(344,'controllers/Admins/view',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(345,'controllers/Admins/delete',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(346,'controllers/Groups/index',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(347,'controllers/Groups/view',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(348,'controllers/Groups/initializeAcl',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(349,'controllers/Groups/add',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(350,'controllers/Groups/edit',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(351,'controllers/Groups/delete',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(352,'controllers/Inventories/index',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(353,'controllers/Inventories/add',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(354,'controllers/Inventories/edit',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(355,'controllers/Inventories/view',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(356,'controllers/Inventories/delete',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(357,'controllers/InventoryItems/index',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(358,'controllers/InventoryItems/add',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(359,'controllers/InventoryItems/edit',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(360,'controllers/InventoryItems/view',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(361,'controllers/InventoryItems/delete',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(362,'controllers/Invoices/index',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(363,'controllers/Invoices/dropoff',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(364,'controllers/Invoices/pickup',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(365,'controllers/Invoices/process_dropoff',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(366,'controllers/Invoices/process_pickup',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(367,'controllers/Invoices/add',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(368,'controllers/Invoices/edit',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(369,'controllers/Invoices/view',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(370,'controllers/Invoices/delete',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(371,'controllers/Menus/index',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(372,'controllers/Menus/view',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(373,'controllers/Menus/add',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(374,'controllers/Menus/edit',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(375,'controllers/Menus/delete',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(376,'controllers/Menus/request',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(377,'controllers/Pages/index',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(378,'controllers/Pages/home',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(379,'controllers/Pages/hotels_attractions',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(380,'controllers/Pages/add',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(381,'controllers/Pages/delete',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(382,'controllers/Pages/validate_form',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(383,'controllers/Pages/view',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(384,'controllers/Pages/edit',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(385,'controllers/Pages/edit_home',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(386,'controllers/Pages/logout',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(387,'controllers/Pages/preview',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(388,'controllers/Pages/url',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(389,'controllers/Pages/publish',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(390,'controllers/Pages/test',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(391,'controllers/Taxes/index',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(392,'controllers/Taxes/add',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(393,'controllers/Taxes/edit',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(394,'controllers/Taxes/view',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(395,'controllers/Taxes/delete',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(396,'controllers/Users/index',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(397,'controllers/Users/view',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(398,'controllers/Users/add',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(399,'controllers/Users/edit',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(400,'controllers/Users/delete',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(401,'controllers/Users/forgot',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(402,'controllers/Users/reset',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(403,'controllers/Users/new_customers',1,'2013-08-21 10:15:10','2013-08-21 10:15:10'),(404,'controllers/DebugKit',1,'2013-08-21 10:15:10','2013-08-21 10:15:10');
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
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acos`
--

LOCK TABLES `acos` WRITE;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
INSERT INTO `acos` VALUES (1,NULL,NULL,NULL,'controllers',1,224),(2,1,NULL,NULL,'Access',2,15),(3,2,NULL,NULL,'index',3,4),(4,2,NULL,NULL,'initializeAccessControl',5,6),(5,2,NULL,NULL,'add',7,8),(6,2,NULL,NULL,'edit',9,10),(7,2,NULL,NULL,'view',11,12),(8,2,NULL,NULL,'delete',13,14),(9,1,NULL,NULL,'Admins',16,33),(10,9,NULL,NULL,'login',17,18),(11,9,NULL,NULL,'logout',19,20),(12,9,NULL,NULL,'index',21,22),(13,9,NULL,NULL,'search_customers',23,24),(14,9,NULL,NULL,'add',25,26),(15,9,NULL,NULL,'edit',27,28),(16,9,NULL,NULL,'view',29,30),(17,9,NULL,NULL,'delete',31,32),(18,1,NULL,NULL,'Deliveries',34,45),(19,18,NULL,NULL,'index',35,36),(20,18,NULL,NULL,'view',37,38),(21,18,NULL,NULL,'add',39,40),(22,18,NULL,NULL,'edit',41,42),(23,18,NULL,NULL,'delete',43,44),(24,1,NULL,NULL,'Groups',46,59),(25,24,NULL,NULL,'index',47,48),(26,24,NULL,NULL,'view',49,50),(27,24,NULL,NULL,'initializeAcl',51,52),(28,24,NULL,NULL,'add',53,54),(29,24,NULL,NULL,'edit',55,56),(30,24,NULL,NULL,'delete',57,58),(31,1,NULL,NULL,'Inventories',60,71),(32,31,NULL,NULL,'index',61,62),(33,31,NULL,NULL,'add',63,64),(34,31,NULL,NULL,'edit',65,66),(35,31,NULL,NULL,'view',67,68),(36,31,NULL,NULL,'delete',69,70),(37,1,NULL,NULL,'InventoryItems',72,83),(38,37,NULL,NULL,'index',73,74),(39,37,NULL,NULL,'add',75,76),(40,37,NULL,NULL,'edit',77,78),(41,37,NULL,NULL,'view',79,80),(42,37,NULL,NULL,'delete',81,82),(43,1,NULL,NULL,'Invoices',84,103),(44,43,NULL,NULL,'index',85,86),(45,43,NULL,NULL,'dropoff',87,88),(46,43,NULL,NULL,'pickup',89,90),(47,43,NULL,NULL,'process_dropoff',91,92),(48,43,NULL,NULL,'process_pickup',93,94),(49,43,NULL,NULL,'add',95,96),(50,43,NULL,NULL,'edit',97,98),(51,43,NULL,NULL,'view',99,100),(52,43,NULL,NULL,'delete',101,102),(53,1,NULL,NULL,'Menus',104,117),(54,53,NULL,NULL,'index',105,106),(55,53,NULL,NULL,'view',107,108),(56,53,NULL,NULL,'add',109,110),(57,53,NULL,NULL,'edit',111,112),(58,53,NULL,NULL,'delete',113,114),(59,53,NULL,NULL,'request',115,116),(60,1,NULL,NULL,'Pages',118,147),(61,60,NULL,NULL,'index',119,120),(62,60,NULL,NULL,'home',121,122),(63,60,NULL,NULL,'hotels_attractions',123,124),(64,60,NULL,NULL,'add',125,126),(65,60,NULL,NULL,'delete',127,128),(66,60,NULL,NULL,'validate_form',129,130),(67,60,NULL,NULL,'view',131,132),(68,60,NULL,NULL,'edit',133,134),(69,60,NULL,NULL,'edit_home',135,136),(70,60,NULL,NULL,'logout',137,138),(71,60,NULL,NULL,'preview',139,140),(72,60,NULL,NULL,'url',141,142),(73,60,NULL,NULL,'publish',143,144),(74,60,NULL,NULL,'test',145,146),(75,1,NULL,NULL,'Reports',148,179),(76,75,NULL,NULL,'daily_accounting',149,150),(77,75,NULL,NULL,'download',151,152),(78,75,NULL,NULL,'vouchers',153,154),(79,75,NULL,NULL,'request_voucher_list',155,156),(80,75,NULL,NULL,'request_voucher_pdf',157,158),(81,75,NULL,NULL,'room_nights_report',159,160),(82,75,NULL,NULL,'booking_report',161,162),(83,75,NULL,NULL,'request_bookings',163,164),(84,75,NULL,NULL,'accounting',165,166),(85,75,NULL,NULL,'request_room_nights',167,168),(86,75,NULL,NULL,'index',169,170),(87,75,NULL,NULL,'add',171,172),(88,75,NULL,NULL,'edit',173,174),(89,75,NULL,NULL,'delete',175,176),(90,75,NULL,NULL,'view',177,178),(91,1,NULL,NULL,'Taxes',180,191),(92,91,NULL,NULL,'index',181,182),(93,91,NULL,NULL,'add',183,184),(94,91,NULL,NULL,'edit',185,186),(95,91,NULL,NULL,'view',187,188),(96,91,NULL,NULL,'delete',189,190),(97,1,NULL,NULL,'Users',192,209),(98,97,NULL,NULL,'index',193,194),(99,97,NULL,NULL,'view',195,196),(100,97,NULL,NULL,'add',197,198),(101,97,NULL,NULL,'edit',199,200),(102,97,NULL,NULL,'delete',201,202),(103,97,NULL,NULL,'forgot',203,204),(104,97,NULL,NULL,'reset',205,206),(105,97,NULL,NULL,'new_customers',207,208),(106,1,NULL,NULL,'DebugKit',210,223),(107,106,NULL,NULL,'',211,222),(108,107,NULL,NULL,'add',212,213),(109,107,NULL,NULL,'edit',214,215),(110,107,NULL,NULL,'index',216,217),(111,107,NULL,NULL,'view',218,219),(112,107,NULL,NULL,'delete',220,221);
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
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros_acos`
--

LOCK TABLES `aros_acos` WRITE;
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
INSERT INTO `aros_acos` VALUES (1,1,1,'-1','-1','-1','-1'),(2,1,3,'1','1','1','1'),(3,1,4,'1','1','1','1'),(4,1,5,'1','1','1','1'),(5,1,6,'1','1','1','1'),(6,1,7,'1','1','1','1'),(7,1,8,'1','1','1','1'),(8,1,10,'1','1','1','1'),(9,1,11,'1','1','1','1'),(10,1,12,'1','1','1','1'),(11,1,13,'1','1','1','1'),(12,1,14,'1','1','1','1'),(13,1,15,'1','1','1','1'),(14,1,16,'1','1','1','1'),(15,1,17,'1','1','1','1'),(16,1,25,'1','1','1','1'),(17,1,26,'1','1','1','1'),(18,1,27,'1','1','1','1'),(19,1,28,'1','1','1','1'),(20,1,29,'1','1','1','1'),(21,1,30,'1','1','1','1'),(22,1,32,'1','1','1','1'),(23,1,33,'1','1','1','1'),(24,1,34,'1','1','1','1'),(25,1,35,'1','1','1','1'),(26,1,36,'1','1','1','1'),(27,1,38,'1','1','1','1'),(28,1,39,'1','1','1','1'),(29,1,40,'1','1','1','1'),(30,1,41,'1','1','1','1'),(31,1,42,'1','1','1','1'),(32,1,44,'1','1','1','1'),(33,1,45,'1','1','1','1'),(34,1,46,'1','1','1','1'),(35,1,47,'1','1','1','1'),(36,1,48,'1','1','1','1'),(37,1,49,'1','1','1','1'),(38,1,50,'1','1','1','1'),(39,1,51,'1','1','1','1'),(40,1,52,'1','1','1','1'),(41,1,54,'1','1','1','1'),(42,1,55,'1','1','1','1'),(43,1,56,'1','1','1','1'),(44,1,57,'1','1','1','1'),(45,1,58,'1','1','1','1'),(46,1,59,'1','1','1','1'),(47,1,61,'1','1','1','1'),(48,1,62,'1','1','1','1'),(49,1,63,'1','1','1','1'),(50,1,64,'1','1','1','1'),(51,1,65,'1','1','1','1'),(52,1,66,'1','1','1','1'),(53,1,67,'1','1','1','1'),(54,1,68,'1','1','1','1'),(55,1,69,'1','1','1','1'),(56,1,70,'1','1','1','1'),(57,1,71,'1','1','1','1'),(58,1,72,'1','1','1','1'),(59,1,73,'1','1','1','1'),(60,1,74,'1','1','1','1'),(61,1,92,'1','1','1','1'),(62,1,93,'1','1','1','1'),(63,1,94,'1','1','1','1'),(64,1,95,'1','1','1','1'),(65,1,96,'1','1','1','1'),(66,1,98,'1','1','1','1'),(67,1,99,'1','1','1','1'),(68,1,100,'1','1','1','1'),(69,1,101,'1','1','1','1'),(70,1,102,'1','1','1','1'),(71,1,103,'1','1','1','1'),(72,1,104,'1','1','1','1'),(73,1,105,'1','1','1','1'),(74,1,106,'1','1','1','1'),(75,2,1,'-1','-1','-1','-1'),(76,3,1,'-1','-1','-1','-1'),(77,4,1,'-1','-1','-1','-1'),(78,5,1,'-1','-1','-1','-1');
/*!40000 ALTER TABLE `aros_acos` ENABLE KEYS */;
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
INSERT INTO `groups` VALUES (1,'Super Administrator','2013-06-24 09:16:33','2013-08-21 10:15:10'),(2,'Administrator','2013-06-24 09:16:41','2013-06-24 09:16:41'),(3,'Manager','2013-06-24 09:16:53','2013-06-24 09:16:53'),(4,'Employee','2013-06-24 09:17:03','2013-06-24 09:17:03'),(5,'Member','2013-06-24 09:17:09','2013-06-24 09:17:09');
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
INSERT INTO `inventories` VALUES (1,'Dry Clean','All dry clean items','2013-08-21 11:50:56','2013-08-21 11:50:56'),(2,'Laundry','All laundered Items','2013-08-21 11:51:14','2013-08-21 11:51:24');
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
  `inventory_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(11,2) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_items`
--

LOCK TABLES `inventory_items` WRITE;
/*!40000 ALTER TABLE `inventory_items` DISABLE KEYS */;
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
INSERT INTO `menu_items` VALUES (3,'Main Menu',1,'Main Header',1,'icon-th-large','2013-08-01 02:11:22','2013-08-01 02:11:22'),(3,'Home',2,'/admins/index',2,'NULL','2013-08-01 02:11:22','2013-08-01 02:11:22'),(3,'Inventory Template',2,'Sub Header',5,'NULL','2013-08-01 02:11:23','2013-08-01 02:11:23'),(3,'Drop Off / Pick Up',2,'/admins/main_menu',3,'NULL','2013-08-01 02:11:23','2013-08-01 02:11:23'),(3,'Setup',1,'Main Header',4,'icon-cog','2013-08-01 02:11:23','2013-08-01 02:11:23'),(3,'View Inventory Groups',3,'/inventories/index',6,'NULL','2013-08-01 02:11:24','2013-08-01 02:11:24'),(3,'Add Inventory Group',3,'/inventories/add',7,'NULL','2013-08-01 02:11:24','2013-08-01 02:11:24'),(3,'Inventory Items Template',2,'Sub Header',8,'NULL','2013-08-01 02:11:24','2013-08-01 02:11:24'),(3,'View Inventory Items',3,'/inventory_items/index',9,'NULL','2013-08-01 02:11:24','2013-08-01 02:11:24'),(3,'Add Inventory Items',3,'/inventory_items/add',10,'NULL','2013-08-01 02:11:25','2013-08-01 02:11:25'),(3,'Taxes Template',2,'Sub Header',11,'NULL','2013-08-01 02:11:25','2013-08-01 02:11:25'),(3,'View Taxes',3,'/taxes/index',12,'NULL','2013-08-01 02:11:25','2013-08-01 02:11:25'),(3,'Add Tax',3,'/taxes/add',13,'NULL','2013-08-01 02:11:25','2013-08-01 02:11:25'),(3,'Menu Template',2,'Sub Header',14,'NULL','2013-08-01 02:11:26','2013-08-01 02:11:26'),(3,'View Menus',3,'/menus/index',15,'NULL','2013-08-01 02:11:26','2013-08-01 02:11:26'),(3,'Create Menu',3,'/menus/add',16,'NULL','2013-08-01 02:11:26','2013-08-01 02:11:26'),(3,'Delivery',1,'Main Header',17,'icon-road','2013-08-01 02:11:27','2013-08-01 02:11:27'),(3,'Accounts',1,'Main Header',18,'icon-folder-open','2013-08-01 02:11:27','2013-08-01 02:11:27'),(3,'Customers',1,'Main Header',19,'icon-user','2013-08-01 02:11:27','2013-08-01 02:11:27'),(3,'Customer Template',2,'Sub Header',20,'NULL','2013-08-01 02:11:27','2013-08-01 02:11:27'),(3,'View Customers',3,'/users/index',21,'NULL','2013-08-01 02:11:28','2013-08-01 02:11:28'),(3,'Add New Customer',3,'/users/new_customers',22,'NULL','2013-08-01 02:11:28','2013-08-01 02:11:28'),(3,'Web Page',1,'Main Header',23,'icon-globe','2013-08-01 02:11:28','2013-08-01 02:11:28'),(3,'Page Template',2,'Sub Header',24,'NULL','2013-08-01 02:11:28','2013-08-01 02:11:28'),(3,'View Pages',3,'/pages/view',25,'NULL','2013-08-01 02:11:28','2013-08-01 02:11:28'),(3,'Add Page',3,'/pages/add',26,'NULL','2013-08-01 02:11:28','2013-08-01 02:11:28');
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
INSERT INTO `menus` VALUES (3,'Admin','\n			\n			\n			\n			\n			\n			\n			\n\n		<li label=\"Main Menu\" icon=\"icon-th-large\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-th-large\" chosen=\"icon-th-large\"></i> Main Menu - Main Header</span></span><button id=\"removeMenuRow\" name=\"Main Menu\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li class=\"\" style=\"\" label=\"Home\" icon=\"\" url=\"/admins/index\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Home - /admins/index</span></span><button id=\"removeMenuRow\" name=\"Home\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li label=\"Drop Off / Pick Up\" icon=\"\" url=\"/admins/main_menu\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Drop Off / Pick Up - /admins/main_menu</span></span><button id=\"removeMenuRow\" name=\"Drop Off / Pick Up\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li label=\"Setup\" icon=\"icon-cog\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-cog\" chosen=\"icon-cog\"></i> Setup - Main Header</span></span><button id=\"removeMenuRow\" name=\"Setup\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li class=\"\" style=\"\" label=\"Inventory Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Inventory Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Inventory Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Inventory Groups\" icon=\"\" url=\"/inventories/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Inventory Groups - /inventories/index</span></span><button id=\"removeMenuRow\" name=\"View Inventory Groups\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Add Inventory Group\" icon=\"\" url=\"/inventories/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add Inventory Group - /inventories/add</span></span><button id=\"removeMenuRow\" name=\"Add Inventory Group\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li class=\"\" style=\"\" label=\"Inventory Items Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Inventory Items Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Inventory Items Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Inventory Items\" icon=\"\" url=\"/inventory_items/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Inventory Items - /inventory_items/index</span></span><button id=\"removeMenuRow\" name=\"View Inventory Items\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Add Inventory Items\" icon=\"\" url=\"/inventory_items/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add Inventory Items - /inventory_items/add</span></span><button id=\"removeMenuRow\" name=\"Add Inventory Items\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li class=\"\" style=\"\" label=\"Taxes Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Taxes Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Taxes Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Taxes\" icon=\"\" url=\"/taxes/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Taxes - /taxes/index</span></span><button id=\"removeMenuRow\" name=\"View Taxes\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Add Tax\" icon=\"\" url=\"/taxes/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add Tax - /taxes/add</span></span><button id=\"removeMenuRow\" name=\"Add Tax\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li class=\"\" style=\"\" label=\"Menu Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Menu Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Menu Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Menus\" icon=\"\" url=\"/menus/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Menus - /menus/index</span></span><button id=\"removeMenuRow\" name=\"View Menus\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Create Menu\" icon=\"\" url=\"/menus/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Create Menu - /menus/add</span></span><button id=\"removeMenuRow\" name=\"Create Menu\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li></ol></li><li label=\"Delivery\" icon=\"icon-road\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-road\" chosen=\"icon-road\"></i> Delivery - Main Header</span></span><button id=\"removeMenuRow\" name=\"Delivery\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li label=\"Accounts\" icon=\"icon-folder-open\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-folder-open\" chosen=\"icon-folder-open\"></i> Accounts - Main Header</span></span><button id=\"removeMenuRow\" name=\"Accounts\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li>				<li label=\"Customers\" icon=\"icon-user\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-user\" chosen=\"icon-user\"></i> Customers - Main Header</span></span><button id=\"removeMenuRow\" name=\"Customers\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li class=\"\" style=\"\" label=\"Customer Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Customer Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Customer Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Customers\" icon=\"\" url=\"/users/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Customers - /users/index</span></span><button id=\"removeMenuRow\" name=\"View Customers\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li label=\"Add New Customer\" icon=\"\" url=\"/users/new_customers\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add New Customer - /users/new_customers</span></span><button id=\"removeMenuRow\" name=\"Add New Customer\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li></ol></li>						<li label=\"Web Page\" icon=\"icon-globe\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-globe\" chosen=\"icon-globe\"></i> Web Page - Main Header</span></span><button id=\"removeMenuRow\" name=\"Web Page\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li class=\"\" style=\"\" label=\"Page Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Page Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Page Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Pages\" icon=\"\" url=\"/pages/view\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Pages - /pages/view</span></span><button id=\"removeMenuRow\" name=\"View Pages\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Add Page\" icon=\"\" url=\"/pages/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add Page - /pages/add</span></span><button id=\"removeMenuRow\" name=\"Add Page\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li></ol></li>				','2013-07-17 03:11:17','2013-08-01 02:11:21');
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

-- Dump completed on 2013-08-21 21:03:17
