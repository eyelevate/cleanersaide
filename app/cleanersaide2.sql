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
) ENGINE=InnoDB AUTO_INCREMENT=1555 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_permissions`
--

LOCK TABLES `acl_permissions` WRITE;
/*!40000 ALTER TABLE `acl_permissions` DISABLE KEYS */;
INSERT INTO `acl_permissions` VALUES (1398,'controllers/Access',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1399,'controllers/Admins',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1400,'controllers/Companies',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1401,'controllers/Deliveries',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1402,'controllers/Discounts',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1403,'controllers/Groups',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1404,'controllers/Inventories',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1405,'controllers/InventoryItems',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1406,'controllers/Invoices',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1407,'controllers/Menus',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1408,'controllers/Pages',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1409,'controllers/Reports',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1410,'controllers/Rewards',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1411,'controllers/Schedules',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1412,'controllers/Taxes',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1413,'controllers/Transactions',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1414,'controllers/Users',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1415,'controllers/DebugKit',2,'2013-10-23 00:44:39','2013-10-23 00:44:39'),(1416,'controllers/Access/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1417,'controllers/Access/initializeAccessControl',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1418,'controllers/Access/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1419,'controllers/Access/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1420,'controllers/Access/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1421,'controllers/Access/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1422,'controllers/Admins/login',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1423,'controllers/Admins/logout',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1424,'controllers/Admins/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1425,'controllers/Admins/search_customers',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1426,'controllers/Admins/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1427,'controllers/Admins/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1428,'controllers/Admins/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1429,'controllers/Admins/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1430,'controllers/Companies',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1431,'controllers/Deliveries/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1432,'controllers/Deliveries/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1433,'controllers/Deliveries/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1434,'controllers/Deliveries/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1435,'controllers/Deliveries/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1436,'controllers/Deliveries/schedule',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1437,'controllers/Deliveries/process_sad',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1438,'controllers/Deliveries/process_login',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1439,'controllers/Deliveries/form',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1440,'controllers/Deliveries/request_date_time',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1441,'controllers/Deliveries/confirmation',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1442,'controllers/Discounts/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1443,'controllers/Discounts/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1444,'controllers/Discounts/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1445,'controllers/Discounts/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1446,'controllers/Discounts/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1447,'controllers/Groups/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1448,'controllers/Groups/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1449,'controllers/Groups/initializeAcl',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1450,'controllers/Groups/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1451,'controllers/Groups/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1452,'controllers/Groups/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1453,'controllers/Inventories/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1454,'controllers/Inventories/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1455,'controllers/Inventories/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1456,'controllers/Inventories/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1457,'controllers/Inventories/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1458,'controllers/InventoryItems/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1459,'controllers/InventoryItems/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1460,'controllers/InventoryItems/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1461,'controllers/InventoryItems/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1462,'controllers/InventoryItems/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1463,'controllers/Invoices/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1464,'controllers/Invoices/dropoff',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1465,'controllers/Invoices/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1466,'controllers/Invoices/rack',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1467,'controllers/Invoices/pickup',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1468,'controllers/Invoices/process_pickup',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1469,'controllers/Invoices/process_dropoff_no_copy',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1470,'controllers/Invoices/process_dropoff_copy',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1471,'controllers/Invoices/process_edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1472,'controllers/Invoices/process_rack',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1473,'controllers/Invoices/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1474,'controllers/Invoices/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1475,'controllers/Invoices/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1476,'controllers/Menus/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1477,'controllers/Menus/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1478,'controllers/Menus/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1479,'controllers/Menus/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1480,'controllers/Menus/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1481,'controllers/Menus/request',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1482,'controllers/Pages/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1483,'controllers/Pages/home',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1484,'controllers/Pages/hotels_attractions',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1485,'controllers/Pages/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1486,'controllers/Pages/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1487,'controllers/Pages/validate_form',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1488,'controllers/Pages/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1489,'controllers/Pages/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1490,'controllers/Pages/edit_home',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1491,'controllers/Pages/logout',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1492,'controllers/Pages/preview',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1493,'controllers/Pages/url',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1494,'controllers/Pages/publish',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1495,'controllers/Pages/test',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1496,'controllers/Reports/daily_accounting',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1497,'controllers/Reports/download',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1498,'controllers/Reports/vouchers',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1499,'controllers/Reports/request_voucher_list',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1500,'controllers/Reports/request_voucher_pdf',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1501,'controllers/Reports/room_nights_report',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1502,'controllers/Reports/booking_report',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1503,'controllers/Reports/request_bookings',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1504,'controllers/Reports/accounting',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1505,'controllers/Reports/request_room_nights',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1506,'controllers/Reports/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1507,'controllers/Reports/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1508,'controllers/Reports/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1509,'controllers/Reports/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1510,'controllers/Reports/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1511,'controllers/Rewards/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1512,'controllers/Rewards/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1513,'controllers/Rewards/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1514,'controllers/Rewards/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1515,'controllers/Rewards/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1516,'controllers/Rewards/activate',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1517,'controllers/Rewards/deactivate',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1518,'controllers/Schedules/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1519,'controllers/Schedules/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1520,'controllers/Schedules/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1521,'controllers/Schedules/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1522,'controllers/Schedules/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1523,'controllers/Schedules/preview',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1524,'controllers/Schedules/print_vmanifest',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1525,'controllers/Schedules/print_pmanifest',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1526,'controllers/Schedules/print_hap_report',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1527,'controllers/Schedules/download_customs',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1528,'controllers/Schedules/download_emails',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1529,'controllers/Schedules/send_customs',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1530,'controllers/Schedules/request_edit_check',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1531,'controllers/Schedules/request',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1532,'controllers/Schedules/getJson',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1533,'controllers/Taxes/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1534,'controllers/Taxes/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1535,'controllers/Taxes/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1536,'controllers/Taxes/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1537,'controllers/Taxes/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1538,'controllers/Transactions/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1539,'controllers/Transactions/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1540,'controllers/Transactions/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1541,'controllers/Transactions/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1542,'controllers/Transactions/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1543,'controllers/Users/index',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1544,'controllers/Users/view',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1545,'controllers/Users/add',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1546,'controllers/Users/edit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1547,'controllers/Users/delete',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1548,'controllers/Users/forgot',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1549,'controllers/Users/reset',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1550,'controllers/Users/new_customers',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1551,'controllers/Users/redirect_new_frontend_customer',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1552,'controllers/Users/frontend_logout',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1553,'controllers/Users/process_frontend_new_user',1,'2013-10-23 00:44:50','2013-10-23 00:44:50'),(1554,'controllers/DebugKit',1,'2013-10-23 00:44:50','2013-10-23 00:44:50');
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
) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acos`
--

LOCK TABLES `acos` WRITE;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
INSERT INTO `acos` VALUES (1,NULL,NULL,NULL,'controllers',1,336),(2,1,NULL,NULL,'Access',2,15),(3,2,NULL,NULL,'index',3,4),(4,2,NULL,NULL,'initializeAccessControl',5,6),(5,2,NULL,NULL,'add',7,8),(6,2,NULL,NULL,'edit',9,10),(7,2,NULL,NULL,'view',11,12),(8,2,NULL,NULL,'delete',13,14),(9,1,NULL,NULL,'Admins',16,33),(10,9,NULL,NULL,'login',17,18),(11,9,NULL,NULL,'logout',19,20),(12,9,NULL,NULL,'index',21,22),(13,9,NULL,NULL,'search_customers',23,24),(14,9,NULL,NULL,'add',25,26),(15,9,NULL,NULL,'edit',27,28),(16,9,NULL,NULL,'view',29,30),(17,9,NULL,NULL,'delete',31,32),(18,1,NULL,NULL,'Companies',34,45),(19,18,NULL,NULL,'index',35,36),(20,18,NULL,NULL,'add',37,38),(21,18,NULL,NULL,'edit',39,40),(22,18,NULL,NULL,'view',41,42),(23,18,NULL,NULL,'delete',43,44),(24,1,NULL,NULL,'Deliveries',46,69),(25,24,NULL,NULL,'index',47,48),(26,24,NULL,NULL,'view',49,50),(27,24,NULL,NULL,'add',51,52),(28,24,NULL,NULL,'edit',53,54),(29,24,NULL,NULL,'delete',55,56),(30,24,NULL,NULL,'schedule',57,58),(31,24,NULL,NULL,'process_sad',59,60),(32,24,NULL,NULL,'process_login',61,62),(33,24,NULL,NULL,'form',63,64),(34,24,NULL,NULL,'request_date_time',65,66),(35,24,NULL,NULL,'confirmation',67,68),(36,1,NULL,NULL,'Discounts',70,81),(37,36,NULL,NULL,'index',71,72),(38,36,NULL,NULL,'view',73,74),(39,36,NULL,NULL,'add',75,76),(40,36,NULL,NULL,'edit',77,78),(41,36,NULL,NULL,'delete',79,80),(42,1,NULL,NULL,'Groups',82,95),(43,42,NULL,NULL,'index',83,84),(44,42,NULL,NULL,'view',85,86),(45,42,NULL,NULL,'initializeAcl',87,88),(46,42,NULL,NULL,'add',89,90),(47,42,NULL,NULL,'edit',91,92),(48,42,NULL,NULL,'delete',93,94),(49,1,NULL,NULL,'Inventories',96,107),(50,49,NULL,NULL,'index',97,98),(51,49,NULL,NULL,'add',99,100),(52,49,NULL,NULL,'edit',101,102),(53,49,NULL,NULL,'view',103,104),(54,49,NULL,NULL,'delete',105,106),(55,1,NULL,NULL,'InventoryItems',108,119),(56,55,NULL,NULL,'index',109,110),(57,55,NULL,NULL,'add',111,112),(58,55,NULL,NULL,'edit',113,114),(59,55,NULL,NULL,'view',115,116),(60,55,NULL,NULL,'delete',117,118),(61,1,NULL,NULL,'Invoices',120,147),(62,61,NULL,NULL,'index',121,122),(63,61,NULL,NULL,'dropoff',123,124),(64,61,NULL,NULL,'edit',125,126),(65,61,NULL,NULL,'rack',127,128),(66,61,NULL,NULL,'pickup',129,130),(67,61,NULL,NULL,'process_pickup',131,132),(68,61,NULL,NULL,'process_dropoff_no_copy',133,134),(69,61,NULL,NULL,'process_dropoff_copy',135,136),(70,61,NULL,NULL,'process_edit',137,138),(71,61,NULL,NULL,'process_rack',139,140),(72,61,NULL,NULL,'add',141,142),(73,61,NULL,NULL,'view',143,144),(74,61,NULL,NULL,'delete',145,146),(75,1,NULL,NULL,'Menus',148,161),(76,75,NULL,NULL,'index',149,150),(77,75,NULL,NULL,'view',151,152),(78,75,NULL,NULL,'add',153,154),(79,75,NULL,NULL,'edit',155,156),(80,75,NULL,NULL,'delete',157,158),(81,75,NULL,NULL,'request',159,160),(82,1,NULL,NULL,'Pages',162,191),(83,82,NULL,NULL,'index',163,164),(84,82,NULL,NULL,'home',165,166),(85,82,NULL,NULL,'hotels_attractions',167,168),(86,82,NULL,NULL,'add',169,170),(87,82,NULL,NULL,'delete',171,172),(88,82,NULL,NULL,'validate_form',173,174),(89,82,NULL,NULL,'view',175,176),(90,82,NULL,NULL,'edit',177,178),(91,82,NULL,NULL,'edit_home',179,180),(92,82,NULL,NULL,'logout',181,182),(93,82,NULL,NULL,'preview',183,184),(94,82,NULL,NULL,'url',185,186),(95,82,NULL,NULL,'publish',187,188),(96,82,NULL,NULL,'test',189,190),(97,1,NULL,NULL,'Reports',192,223),(98,97,NULL,NULL,'daily_accounting',193,194),(99,97,NULL,NULL,'download',195,196),(100,97,NULL,NULL,'vouchers',197,198),(101,97,NULL,NULL,'request_voucher_list',199,200),(102,97,NULL,NULL,'request_voucher_pdf',201,202),(103,97,NULL,NULL,'room_nights_report',203,204),(104,97,NULL,NULL,'booking_report',205,206),(105,97,NULL,NULL,'request_bookings',207,208),(106,97,NULL,NULL,'accounting',209,210),(107,97,NULL,NULL,'request_room_nights',211,212),(108,97,NULL,NULL,'index',213,214),(109,97,NULL,NULL,'add',215,216),(110,97,NULL,NULL,'edit',217,218),(111,97,NULL,NULL,'delete',219,220),(112,97,NULL,NULL,'view',221,222),(113,1,NULL,NULL,'Rewards',224,239),(114,113,NULL,NULL,'index',225,226),(115,113,NULL,NULL,'view',227,228),(116,113,NULL,NULL,'add',229,230),(117,113,NULL,NULL,'edit',231,232),(118,113,NULL,NULL,'delete',233,234),(119,113,NULL,NULL,'activate',235,236),(120,113,NULL,NULL,'deactivate',237,238),(121,1,NULL,NULL,'Schedules',240,271),(122,121,NULL,NULL,'index',241,242),(123,121,NULL,NULL,'add',243,244),(124,121,NULL,NULL,'edit',245,246),(125,121,NULL,NULL,'delete',247,248),(126,121,NULL,NULL,'view',249,250),(127,121,NULL,NULL,'preview',251,252),(128,121,NULL,NULL,'print_vmanifest',253,254),(129,121,NULL,NULL,'print_pmanifest',255,256),(130,121,NULL,NULL,'print_hap_report',257,258),(131,121,NULL,NULL,'download_customs',259,260),(132,121,NULL,NULL,'download_emails',261,262),(133,121,NULL,NULL,'send_customs',263,264),(134,121,NULL,NULL,'request_edit_check',265,266),(135,121,NULL,NULL,'request',267,268),(136,121,NULL,NULL,'getJson',269,270),(137,1,NULL,NULL,'Taxes',272,283),(138,137,NULL,NULL,'index',273,274),(139,137,NULL,NULL,'add',275,276),(140,137,NULL,NULL,'edit',277,278),(141,137,NULL,NULL,'view',279,280),(142,137,NULL,NULL,'delete',281,282),(143,1,NULL,NULL,'Transactions',284,295),(144,143,NULL,NULL,'index',285,286),(145,143,NULL,NULL,'view',287,288),(146,143,NULL,NULL,'add',289,290),(147,143,NULL,NULL,'edit',291,292),(148,143,NULL,NULL,'delete',293,294),(149,1,NULL,NULL,'Users',296,321),(150,149,NULL,NULL,'index',297,298),(151,149,NULL,NULL,'view',299,300),(152,149,NULL,NULL,'add',301,302),(153,149,NULL,NULL,'edit',303,304),(154,149,NULL,NULL,'delete',305,306),(155,149,NULL,NULL,'forgot',307,308),(156,149,NULL,NULL,'reset',309,310),(157,149,NULL,NULL,'new_customers',311,312),(158,149,NULL,NULL,'process_delete_profile',313,314),(159,149,NULL,NULL,'redirect_new_frontend_customer',315,316),(160,149,NULL,NULL,'frontend_logout',317,318),(161,149,NULL,NULL,'process_frontend_new_user',319,320),(162,1,NULL,NULL,'DebugKit',322,335),(163,162,NULL,NULL,'',323,334),(164,163,NULL,NULL,'add',324,325),(165,163,NULL,NULL,'edit',326,327),(166,163,NULL,NULL,'index',328,329),(167,163,NULL,NULL,'view',330,331),(168,163,NULL,NULL,'delete',332,333);
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
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros`
--

LOCK TABLES `aros` WRITE;
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;
INSERT INTO `aros` VALUES (1,NULL,'Group',1,NULL,1,8),(2,NULL,'Group',2,NULL,9,10),(3,NULL,'Group',3,NULL,11,12),(4,NULL,'Group',4,NULL,13,14),(5,NULL,'Group',5,NULL,15,76),(6,1,'User',1,NULL,2,3),(7,1,'User',7524,NULL,4,5),(8,5,'User',7525,NULL,16,17),(9,5,'User',7526,NULL,18,19),(10,NULL,'User',7527,NULL,77,78),(11,NULL,'User',7528,NULL,79,80),(12,NULL,'User',7529,NULL,81,82),(13,5,'User',7530,NULL,20,21),(14,5,'User',7531,NULL,22,23),(15,5,'User',7532,NULL,24,25),(16,5,'User',7533,NULL,26,27),(17,5,'User',7534,NULL,28,29),(18,5,'User',7535,NULL,30,31),(19,5,'User',7536,NULL,32,33),(20,5,'User',7537,NULL,34,35),(21,5,'User',7538,NULL,36,37),(22,5,'User',7539,NULL,38,39),(23,5,'User',7540,NULL,40,41),(24,5,'User',7541,NULL,42,43),(25,5,'User',7542,NULL,44,45),(26,5,'User',7543,NULL,46,47),(27,5,'User',7544,NULL,48,49),(28,5,'User',7545,NULL,50,51),(29,5,'User',7546,NULL,52,53),(30,5,'User',7547,NULL,54,55),(31,5,'User',7548,NULL,56,57),(32,5,'User',7549,NULL,58,59),(33,5,'User',7550,NULL,60,61),(34,5,'User',7551,NULL,62,63),(35,5,'User',7552,NULL,64,65),(36,5,'User',7553,NULL,66,67),(37,5,'User',7554,NULL,68,69),(38,5,'User',7555,NULL,70,71),(39,5,'User',7556,NULL,72,73),(40,5,'User',7557,NULL,74,75),(41,1,'User',7558,NULL,6,7);
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
) ENGINE=MyISAM AUTO_INCREMENT=163 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros_acos`
--

LOCK TABLES `aros_acos` WRITE;
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
INSERT INTO `aros_acos` VALUES (1,1,1,'-1','-1','-1','-1'),(2,1,3,'1','1','1','1'),(3,1,4,'1','1','1','1'),(4,1,5,'1','1','1','1'),(5,1,6,'1','1','1','1'),(6,1,7,'1','1','1','1'),(7,1,8,'1','1','1','1'),(8,1,10,'1','1','1','1'),(9,1,11,'1','1','1','1'),(10,1,12,'1','1','1','1'),(11,1,13,'1','1','1','1'),(12,1,14,'1','1','1','1'),(13,1,15,'1','1','1','1'),(14,1,16,'1','1','1','1'),(15,1,17,'1','1','1','1'),(16,1,18,'1','1','1','1'),(17,1,25,'1','1','1','1'),(18,1,26,'1','1','1','1'),(19,1,27,'1','1','1','1'),(20,1,28,'1','1','1','1'),(21,1,29,'1','1','1','1'),(22,1,30,'1','1','1','1'),(23,1,31,'1','1','1','1'),(24,1,32,'1','1','1','1'),(25,1,33,'1','1','1','1'),(26,1,34,'1','1','1','1'),(27,1,35,'1','1','1','1'),(28,1,37,'1','1','1','1'),(29,1,38,'1','1','1','1'),(30,1,39,'1','1','1','1'),(31,1,40,'1','1','1','1'),(32,1,41,'1','1','1','1'),(33,1,43,'1','1','1','1'),(34,1,44,'1','1','1','1'),(35,1,45,'1','1','1','1'),(36,1,46,'1','1','1','1'),(37,1,47,'1','1','1','1'),(38,1,48,'1','1','1','1'),(39,1,50,'1','1','1','1'),(40,1,51,'1','1','1','1'),(41,1,52,'1','1','1','1'),(42,1,53,'1','1','1','1'),(43,1,54,'1','1','1','1'),(44,1,56,'1','1','1','1'),(45,1,57,'1','1','1','1'),(46,1,58,'1','1','1','1'),(47,1,59,'1','1','1','1'),(48,1,60,'1','1','1','1'),(49,1,62,'1','1','1','1'),(50,1,63,'1','1','1','1'),(51,1,64,'1','1','1','1'),(52,1,65,'1','1','1','1'),(53,1,66,'1','1','1','1'),(54,1,67,'1','1','1','1'),(55,1,68,'1','1','1','1'),(56,1,69,'1','1','1','1'),(57,1,70,'1','1','1','1'),(58,1,71,'1','1','1','1'),(59,1,72,'1','1','1','1'),(60,1,73,'1','1','1','1'),(61,1,74,'1','1','1','1'),(62,1,76,'1','1','1','1'),(63,1,77,'1','1','1','1'),(64,1,78,'1','1','1','1'),(65,1,79,'1','1','1','1'),(66,1,80,'1','1','1','1'),(67,1,81,'1','1','1','1'),(68,1,83,'1','1','1','1'),(69,1,84,'1','1','1','1'),(70,1,85,'1','1','1','1'),(71,1,86,'1','1','1','1'),(72,1,87,'1','1','1','1'),(73,1,88,'1','1','1','1'),(74,1,89,'1','1','1','1'),(75,1,90,'1','1','1','1'),(76,1,91,'1','1','1','1'),(77,1,92,'1','1','1','1'),(78,1,93,'1','1','1','1'),(79,1,94,'1','1','1','1'),(80,1,95,'1','1','1','1'),(81,1,96,'1','1','1','1'),(82,1,98,'1','1','1','1'),(83,1,99,'1','1','1','1'),(84,1,100,'1','1','1','1'),(85,1,101,'1','1','1','1'),(86,1,102,'1','1','1','1'),(87,1,103,'1','1','1','1'),(88,1,104,'1','1','1','1'),(89,1,105,'1','1','1','1'),(90,1,106,'1','1','1','1'),(91,1,107,'1','1','1','1'),(92,1,108,'1','1','1','1'),(93,1,109,'1','1','1','1'),(94,1,110,'1','1','1','1'),(95,1,111,'1','1','1','1'),(96,1,112,'1','1','1','1'),(97,1,114,'1','1','1','1'),(98,1,115,'1','1','1','1'),(99,1,116,'1','1','1','1'),(100,1,117,'1','1','1','1'),(101,1,118,'1','1','1','1'),(102,1,119,'1','1','1','1'),(103,1,120,'1','1','1','1'),(104,1,122,'1','1','1','1'),(105,1,123,'1','1','1','1'),(106,1,124,'1','1','1','1'),(107,1,125,'1','1','1','1'),(108,1,126,'1','1','1','1'),(109,1,127,'1','1','1','1'),(110,1,128,'1','1','1','1'),(111,1,129,'1','1','1','1'),(112,1,130,'1','1','1','1'),(113,1,131,'1','1','1','1'),(114,1,132,'1','1','1','1'),(115,1,133,'1','1','1','1'),(116,1,134,'1','1','1','1'),(117,1,135,'1','1','1','1'),(118,1,136,'1','1','1','1'),(119,1,138,'1','1','1','1'),(120,1,139,'1','1','1','1'),(121,1,140,'1','1','1','1'),(122,1,141,'1','1','1','1'),(123,1,142,'1','1','1','1'),(124,1,144,'1','1','1','1'),(125,1,145,'1','1','1','1'),(126,1,146,'1','1','1','1'),(127,1,147,'1','1','1','1'),(128,1,148,'1','1','1','1'),(129,1,150,'1','1','1','1'),(130,1,151,'1','1','1','1'),(131,1,152,'1','1','1','1'),(132,1,153,'1','1','1','1'),(133,1,154,'1','1','1','1'),(134,1,155,'1','1','1','1'),(135,1,156,'1','1','1','1'),(136,1,157,'1','1','1','1'),(137,1,159,'1','1','1','1'),(138,1,160,'1','1','1','1'),(139,1,161,'1','1','1','1'),(140,1,162,'1','1','1','1'),(141,2,1,'-1','-1','-1','-1'),(142,2,2,'1','1','1','1'),(143,2,9,'1','1','1','1'),(144,2,18,'1','1','1','1'),(145,2,24,'1','1','1','1'),(146,2,36,'1','1','1','1'),(147,2,42,'1','1','1','1'),(148,2,49,'1','1','1','1'),(149,2,55,'1','1','1','1'),(150,2,61,'1','1','1','1'),(151,2,75,'1','1','1','1'),(152,2,82,'1','1','1','1'),(153,2,97,'1','1','1','1'),(154,2,113,'1','1','1','1'),(155,2,121,'1','1','1','1'),(156,2,137,'1','1','1','1'),(157,2,143,'1','1','1','1'),(158,2,149,'1','1','1','1'),(159,2,162,'1','1','1','1'),(160,3,1,'-1','-1','-1','-1'),(161,4,1,'-1','-1','-1','-1'),(162,5,1,'-1','-1','-1','-1');
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
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
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
INSERT INTO `companies` VALUES (1,'Jays Cleaners','801 NE 65th Street Ste B.','Seattle','WA','98115','2064535930','ydc2415@hotmail.com','jayscleaners','db4d6425f717606ccde5ac22836d056049a5fba4','2013-10-23 01:25:03','2013-10-23 01:25:03');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deliveries`
--

DROP TABLE IF EXISTS `deliveries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deliveries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `route_name` varchar(50) DEFAULT NULL,
  `day` varchar(25) DEFAULT NULL,
  `limit` int(11) DEFAULT NULL,
  `start_time` varchar(25) DEFAULT NULL,
  `end_time` varchar(25) DEFAULT NULL,
  `zipcode` text,
  `blackout` text,
  `status` int(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deliveries`
--

LOCK TABLES `deliveries` WRITE;
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;
INSERT INTO `deliveries` VALUES (1,1,'Morning Delivery Route','Monday',25,'8:00am','10:00am','[\"98001\",\"98002\",\"98003\"]','[\"2013-10-01 00:00:00\"]',1,'2013-10-01 00:35:21','2013-10-01 04:03:26'),(2,1,'Morning Delivery Route','Tuesday',30,'8:00am','10:00am','[\"98005\",\"98006\",\"98007\",\"98008\",\"98009\"]','[\"2013-10-02 00:00:00\"]',1,'2013-10-01 00:35:21','2013-10-01 00:35:21'),(3,1,'Morning Delivery Route','Wednesday',27,'8:00am','10:00am','[\"98010\",\"98011\",\"98012\",\"98013\",\"98014\"]','[\"2013-10-03 00:00:00\"]',1,'2013-10-01 00:35:21','2013-10-01 00:35:21'),(4,1,'Morning Delivery Route','Thursday',33,'8:30am','10:10am','[\"98016\",\"98017\",\"98018\",\"98019\",\"98020\"]','[\"2013-10-05 00:00:00\"]',1,'2013-10-01 00:35:21','2013-10-01 00:35:21'),(5,1,'Morning Delivery Route','Friday',35,'8:01am','10:15am','[\"98025\",\"98026\",\"98027\",\"98028\",\"98029\"]','[\"2013-10-06 00:00:00\"]',1,'2013-10-01 00:35:21','2013-10-01 00:35:21'),(6,1,'Morning Delivery Route','Saturday',31,'8:00am','10:04am','[\"98026\",\"98027\",\"98028\",\"98029\"]','[\"2013-10-08 00:00:00\"]',1,'2013-10-01 00:35:21','2013-10-01 00:35:21'),(7,1,'Morning Delivery Route','Sunday',25,'8:00am','10:00am','[\"94545\",\"98765\"]','[\"2013-10-25 00:00:00\"]',1,'2013-10-01 00:35:21','2013-10-01 04:08:15'),(15,1,'Nightly Rounds','Monday',25,'7:00pm','9:00pm','[\"98001\",\"98002\",\"98003\",\"98005\"]','[\"2013-10-17 00:00:00\"]',1,'2013-10-08 06:58:32','2013-10-08 06:58:32'),(16,1,'Nightly Rounds','Tuesday',NULL,'','','','',1,'2013-10-08 06:58:32','2013-10-08 06:58:32'),(17,1,'Nightly Rounds','Wednesday',30,'7:00pm','10:00pm','{\"1\":\"98001\"}','[\"2013-10-16 00:00:00\"]',1,'2013-10-08 06:58:32','2013-10-08 08:32:26'),(18,1,'Nightly Rounds','Thursday',NULL,'','','','',1,'2013-10-08 06:58:32','2013-10-08 06:58:32'),(19,1,'Nightly Rounds','Friday',NULL,'','','','',1,'2013-10-08 06:58:32','2013-10-08 06:58:32'),(20,1,'Nightly Rounds','Saturday',NULL,'','','','',1,'2013-10-08 06:58:32','2013-10-08 06:58:32'),(36,1,'Test','Monday',25,'7:00pm','10:00pm','[\"98006\"]','[\"2013-10-31 00:00:00\"]',1,'2013-10-08 08:30:35','2013-10-08 08:31:20'),(37,1,'Test','Tuesday',NULL,'','','','',1,'2013-10-08 08:30:35','2013-10-08 08:30:35'),(38,1,'Test','Wednesday',NULL,'','','','',1,'2013-10-08 08:30:35','2013-10-08 08:30:35'),(39,1,'Test','Thursday',NULL,'','','','',1,'2013-10-08 08:30:35','2013-10-08 08:30:35'),(40,1,'Test','Friday',NULL,'','','','',1,'2013-10-08 08:30:35','2013-10-08 08:30:35'),(41,1,'Test','Saturday',NULL,'','','','',1,'2013-10-08 08:30:35','2013-10-08 08:30:35'),(42,1,'Test','Sunday',NULL,'','','','',1,'2013-10-08 08:30:35','2013-10-08 08:30:35');
/*!40000 ALTER TABLE `deliveries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `discount` decimal(9,2) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounts`
--

LOCK TABLES `discounts` WRITE;
/*!40000 ALTER TABLE `discounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `discounts` ENABLE KEYS */;
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
INSERT INTO `groups` VALUES (1,'Super Administrator','2013-06-24 09:16:33','2013-10-23 00:44:50'),(2,'Administrator','2013-06-24 09:16:41','2013-10-23 00:44:39'),(3,'Manager','2013-06-24 09:16:53','2013-06-24 09:16:53'),(4,'Employee','2013-06-24 09:17:03','2013-06-24 09:17:03'),(5,'Member','2013-06-24 09:17:09','2013-06-24 09:17:09');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventories`
--

LOCK TABLES `inventories` WRITE;
/*!40000 ALTER TABLE `inventories` DISABLE KEYS */;
INSERT INTO `inventories` VALUES (1,1,'Dry Clean','All dry clean items','2013-08-21 11:50:56','2013-08-21 11:50:56'),(2,1,'Laundry','All laundered Items','2013-08-21 11:51:14','2013-08-21 11:51:24'),(3,1,'Household','This is a household item','2013-09-06 02:05:25','2013-09-06 02:05:25');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_items`
--

LOCK TABLES `inventory_items` WRITE;
/*!40000 ALTER TABLE `inventory_items` DISABLE KEYS */;
INSERT INTO `inventory_items` VALUES (1,1,1,'Dry Clean Shirt','Test Dry Clean ','5.50','/img/inventory/shirtsDC_black.png','2013-08-26 22:57:51','2013-08-26 22:57:51'),(2,1,1,'Dress','Test','7.50','/img/inventory/dressShort_pink.png','2013-08-28 01:53:51','2013-08-28 01:53:51'),(3,1,2,'Mens Shirt','Test Description','1.50','/img/inventory/laundryShirt_white.png','2013-09-06 02:05:01','2013-09-06 02:05:01'),(5,1,3,'Tablecloth (Lg)','Large tablecloth','23.56','/img/inventory/tableCloth_blue.png','2013-09-06 02:06:37','2013-09-06 02:06:37');
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
  `items` text,
  `quantity` int(11) DEFAULT NULL,
  `pretax` decimal(11,2) DEFAULT NULL,
  `tax` decimal(11,2) DEFAULT NULL,
  `reward_id` int(11) DEFAULT NULL,
  `discount_id` int(11) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `rack` varchar(11) DEFAULT NULL,
  `memo` text,
  `status` int(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `due_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,1,1,7526,'{\"1\":{\"colors\":[{\"quantity\":\"1\",\"color\":\"red\"},{\"quantity\":\"1\",\"color\":\"white\"}],\"quantity\":\"2\",\"name\":\"Dry Clean Shirt\",\"before_tax\":\"11.00\",\"item_id\":\"1\"},\"2\":{\"colors\":[{\"quantity\":\"1\",\"color\":\"tan\"}],\"quantity\":\"1\",\"name\":\"Dress\",\"before_tax\":\"7.50\",\"item_id\":\"2\"}}',3,'18.50','1.76',NULL,NULL,'20.26',NULL,'test',1,'2013-10-22 22:29:55','2013-10-22 22:29:55','2013-10-24 16:00:00'),(2,2,1,7526,'{\"3\":{\"colors\":[{\"quantity\":\"1\",\"color\":\"green\"},{\"quantity\":\"1\",\"color\":\"red\"},{\"quantity\":\"1\",\"color\":\"yellow\"},{\"quantity\":\"1\",\"color\":\"blue\"}],\"quantity\":\"4\",\"name\":\"Mens Shirt\",\"before_tax\":\"6.00\",\"item_id\":\"3\"}}',4,'6.00','0.57',NULL,NULL,'6.57',NULL,'test',1,'2013-10-22 22:29:55','2013-10-22 22:29:55','2013-10-24 16:00:00'),(3,3,1,7526,'{\"5\":{\"colors\":[{\"quantity\":\"1\",\"color\":\"tan\"},{\"quantity\":\"1\",\"color\":\"blue\"}],\"quantity\":\"2\",\"name\":\"Tablecloth (Lg)\",\"before_tax\":\"47.12\",\"item_id\":\"5\"}}',2,'47.12','4.48',NULL,NULL,'51.60',NULL,'test',1,'2013-10-22 22:29:55','2013-10-22 22:29:55','2013-10-24 16:00:00'),(4,4,1,7557,'{\"1\":{\"colors\":[{\"quantity\":\"1\",\"color\":\"pink\"}],\"quantity\":\"1\",\"name\":\"Dry Clean Shirt\",\"before_tax\":\"5.50\",\"item_id\":\"1\"},\"2\":{\"colors\":[{\"quantity\":\"1\",\"color\":\"tan\"}],\"quantity\":\"1\",\"name\":\"Dress\",\"before_tax\":\"7.50\",\"item_id\":\"2\"}}',2,'13.00','1.24',NULL,NULL,'14.24',NULL,'test',1,'2013-10-22 22:33:02','2013-10-22 22:33:02','2013-10-24 16:00:00'),(5,5,1,7557,'{\"3\":{\"colors\":[{\"quantity\":\"1\",\"color\":\"blue\"},{\"quantity\":\"1\",\"color\":\"tan\"},{\"quantity\":\"1\",\"color\":\"pink\"}],\"quantity\":\"3\",\"name\":\"Mens Shirt\",\"before_tax\":\"4.50\",\"item_id\":\"3\"}}',3,'4.50','0.43',NULL,NULL,'4.93',NULL,'test',1,'2013-10-22 22:33:02','2013-10-22 22:33:02','2013-10-24 16:00:00'),(6,6,1,7557,'{\"5\":{\"colors\":[{\"quantity\":\"1\",\"color\":\"brown\"}],\"quantity\":\"1\",\"name\":\"Tablecloth (Lg)\",\"before_tax\":\"23.56\",\"item_id\":\"5\"}}',1,'23.56','2.24',NULL,NULL,'25.80',NULL,'test',1,'2013-10-22 22:33:02','2013-10-22 22:33:02','2013-10-24 16:00:00');
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
INSERT INTO `menu_items` VALUES (3,'Main Menu',1,'Main Header',1,'icon-th-large','2013-10-02 05:42:30','2013-10-02 05:42:30'),(3,'Setup',1,'Main Header',5,'icon-cog','2013-10-02 05:42:31','2013-10-02 05:42:31'),(3,'Drop Off / Pickup',2,'/invoices/index',3,'NULL','2013-10-02 05:42:31','2013-10-02 05:42:31'),(3,'Rack',2,'/invoices/rack',4,'NULL','2013-10-02 05:42:31','2013-10-02 05:42:31'),(3,'Home',2,'/admins/index',2,'NULL','2013-10-02 05:42:31','2013-10-02 05:42:31'),(3,'Inventory Template',2,'Sub Header',6,'NULL','2013-10-02 05:42:32','2013-10-02 05:42:32'),(3,'View Inventory Groups',3,'/inventories/index',7,'NULL','2013-10-02 05:42:32','2013-10-02 05:42:32'),(3,'Add Inventory Group',3,'/inventories/add',8,'NULL','2013-10-02 05:42:32','2013-10-02 05:42:32'),(3,'Inventory Items Template',2,'Sub Header',9,'NULL','2013-10-02 05:42:32','2013-10-02 05:42:32'),(3,'View Inventory Items',3,'/inventory_items/index',10,'NULL','2013-10-02 05:42:33','2013-10-02 05:42:33'),(3,'Add Inventory Items',3,'/inventory_items/add',11,'NULL','2013-10-02 05:42:33','2013-10-02 05:42:33'),(3,'Taxes Template',2,'Sub Header',12,'NULL','2013-10-02 05:42:33','2013-10-02 05:42:33'),(3,'View Taxes',3,'/taxes/index',13,'NULL','2013-10-02 05:42:33','2013-10-02 05:42:33'),(3,'Add Tax',3,'/taxes/add',14,'NULL','2013-10-02 05:42:34','2013-10-02 05:42:34'),(3,'Menu Template',2,'Sub Header',15,'NULL','2013-10-02 05:42:34','2013-10-02 05:42:34'),(3,'View Menus',3,'/menus/index',16,'NULL','2013-10-02 05:42:34','2013-10-02 05:42:34'),(3,'Create Menu',3,'/menus/add',17,'NULL','2013-10-02 05:42:34','2013-10-02 05:42:34'),(3,'Delivery',1,'Main Header',18,'icon-road','2013-10-02 05:42:35','2013-10-02 05:42:35'),(3,'Delivery Schedule',2,'Sub Header',19,'NULL','2013-10-02 05:42:35','2013-10-02 05:42:35'),(3,'View Schedule',3,'/deliveries/schedule',20,'NULL','2013-10-02 05:42:35','2013-10-02 05:42:35'),(3,'Delivery Setup',2,'Sub Header',21,'NULL','2013-10-02 05:42:35','2013-10-02 05:42:35'),(3,'View Delivery Routes',3,'/deliveries/view',22,'NULL','2013-10-02 05:42:36','2013-10-02 05:42:36'),(3,'New Delivery Setup',3,'/deliveries/add',23,'NULL','2013-10-02 05:42:36','2013-10-02 05:42:36'),(3,'Accounts',1,'Main Header',24,'icon-folder-open','2013-10-02 05:42:36','2013-10-02 05:42:36'),(3,'Customers',1,'Main Header',25,'icon-user','2013-10-02 05:42:37','2013-10-02 05:42:37'),(3,'Customer Template',2,'Sub Header',26,'NULL','2013-10-02 05:42:37','2013-10-02 05:42:37'),(3,'View Customers',3,'/users/index',27,'NULL','2013-10-02 05:42:37','2013-10-02 05:42:37'),(3,'Add New Customer',3,'/users/new_customers',28,'NULL','2013-10-02 05:42:37','2013-10-02 05:42:37'),(3,'Web Page',1,'Main Header',29,'icon-globe','2013-10-02 05:42:37','2013-10-02 05:42:37'),(3,'Page Template',2,'Sub Header',30,'NULL','2013-10-02 05:42:37','2013-10-02 05:42:37'),(3,'View Pages',3,'/pages/view',31,'NULL','2013-10-02 05:42:38','2013-10-02 05:42:38'),(3,'Add Page',3,'/pages/add',32,'NULL','2013-10-02 05:42:38','2013-10-02 05:42:38'),(4,'Delivery',1,'/deliveries/index',1,'NULL','2013-10-08 18:06:05','2013-10-08 18:06:05'),(4,'Company',1,'/companies/index',3,'NULL','2013-10-08 18:06:05','2013-10-08 18:06:05'),(4,'Schedule a delivery',2,'/deliveries/index',2,'NULL','2013-10-08 18:06:05','2013-10-08 18:06:05'),(4,'Cleaning services',2,'/companies/index',6,'NULL','2013-10-08 18:06:05','2013-10-08 18:06:05'),(4,'About us',2,'/companies/index',4,'NULL','2013-10-08 18:06:05','2013-10-08 18:06:05'),(4,'Services',1,'/companies/index',5,'NULL','2013-10-08 18:06:06','2013-10-08 18:06:06');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (3,'Admin','\n			\n			\n			\n			\n			\n			\n			\n			\n			\n			\n			\n			\n\n		<li label=\"Main Menu\" icon=\"icon-th-large\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-th-large\" chosen=\"icon-th-large\"></i> Main Menu - Main Header</span></span><button id=\"removeMenuRow\" name=\"Main Menu\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li class=\"\" style=\"\" label=\"Home\" icon=\"\" url=\"/admins/index\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Home - /admins/index</span></span><button id=\"removeMenuRow\" name=\"Home\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li label=\"Drop Off / Pickup\" icon=\"\" url=\"/invoices/index\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Drop Off / Pickup - /invoices/index</span></span><button id=\"removeMenuRow\" name=\"Drop Off / Pickup\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li label=\"Rack\" icon=\"\" url=\"/invoices/rack\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Rack - /invoices/rack</span></span><button id=\"removeMenuRow\" name=\"Rack\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li label=\"Setup\" icon=\"icon-cog\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-cog\" chosen=\"icon-cog\"></i> Setup - Main Header</span></span><button id=\"removeMenuRow\" name=\"Setup\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li class=\"\" style=\"\" label=\"Inventory Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Inventory Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Inventory Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Inventory Groups\" icon=\"\" url=\"/inventories/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Inventory Groups - /inventories/index</span></span><button id=\"removeMenuRow\" name=\"View Inventory Groups\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Add Inventory Group\" icon=\"\" url=\"/inventories/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add Inventory Group - /inventories/add</span></span><button id=\"removeMenuRow\" name=\"Add Inventory Group\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li class=\"\" style=\"\" label=\"Inventory Items Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Inventory Items Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Inventory Items Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Inventory Items\" icon=\"\" url=\"/inventory_items/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Inventory Items - /inventory_items/index</span></span><button id=\"removeMenuRow\" name=\"View Inventory Items\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Add Inventory Items\" icon=\"\" url=\"/inventory_items/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add Inventory Items - /inventory_items/add</span></span><button id=\"removeMenuRow\" name=\"Add Inventory Items\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li class=\"\" style=\"\" label=\"Taxes Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Taxes Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Taxes Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Taxes\" icon=\"\" url=\"/taxes/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Taxes - /taxes/index</span></span><button id=\"removeMenuRow\" name=\"View Taxes\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Add Tax\" icon=\"\" url=\"/taxes/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add Tax - /taxes/add</span></span><button id=\"removeMenuRow\" name=\"Add Tax\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li class=\"\" style=\"\" label=\"Menu Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Menu Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Menu Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Menus\" icon=\"\" url=\"/menus/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Menus - /menus/index</span></span><button id=\"removeMenuRow\" name=\"View Menus\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Create Menu\" icon=\"\" url=\"/menus/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Create Menu - /menus/add</span></span><button id=\"removeMenuRow\" name=\"Create Menu\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li></ol></li><li label=\"Delivery\" icon=\"icon-road\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-road\" chosen=\"icon-road\"></i> Delivery - Main Header</span></span><button id=\"removeMenuRow\" name=\"Delivery\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li label=\"Delivery Schedule\" icon=\"\" url=\"Sub Header\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Delivery Schedule - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Delivery Schedule\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li label=\"View Schedule\" icon=\"\" url=\"/deliveries/schedule\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Schedule - /deliveries/schedule</span></span><button id=\"removeMenuRow\" name=\"View Schedule\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li label=\"Delivery Setup\" icon=\"\" url=\"Sub Header\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Delivery Setup - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Delivery Setup\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li label=\"View Delivery Routes\" icon=\"\" url=\"/deliveries/view\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Delivery Routes - /deliveries/view</span></span><button id=\"removeMenuRow\" name=\"View Delivery Routes\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li label=\"New Delivery Setup\" icon=\"\" url=\"/deliveries/add\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> New Delivery Setup - /deliveries/add</span></span><button id=\"removeMenuRow\" name=\"New Delivery Setup\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li></ol></li><li label=\"Accounts\" icon=\"icon-folder-open\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-folder-open\" chosen=\"icon-folder-open\"></i> Accounts - Main Header</span></span><button id=\"removeMenuRow\" name=\"Accounts\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li>				<li label=\"Customers\" icon=\"icon-user\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-user\" chosen=\"icon-user\"></i> Customers - Main Header</span></span><button id=\"removeMenuRow\" name=\"Customers\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li class=\"\" style=\"\" label=\"Customer Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Customer Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Customer Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Customers\" icon=\"\" url=\"/users/index\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Customers - /users/index</span></span><button id=\"removeMenuRow\" name=\"View Customers\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li label=\"Add New Customer\" icon=\"\" url=\"/users/new_customers\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add New Customer - /users/new_customers</span></span><button id=\"removeMenuRow\" name=\"Add New Customer\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li></ol></li>						<li label=\"Web Page\" icon=\"icon-globe\" url=\"Main Header\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"icon-globe\" chosen=\"icon-globe\"></i> Web Page - Main Header</span></span><button id=\"removeMenuRow\" name=\"Web Page\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li class=\"\" style=\"\" label=\"Page Template\" icon=\"\" url=\"Sub Header\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Page Template - Sub Header</span></span><button id=\"removeMenuRow\" name=\"Page Template\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"3\"><li class=\"\" style=\"\" label=\"View Pages\" icon=\"\" url=\"/pages/view\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> View Pages - /pages/view</span></span><button id=\"removeMenuRow\" name=\"View Pages\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li><li class=\"\" style=\"\" label=\"Add Page\" icon=\"\" url=\"/pages/add\"><div class=\"btn btn-large btn-block btn btn-info\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Add Page - /pages/add</span></span><button id=\"removeMenuRow\" name=\"Add Page\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li></ol></li>														','2013-07-17 03:11:17','2013-10-02 05:42:29'),(4,'Primary','\n			\n\n		<li label=\"Delivery\" icon=\"\" url=\"/deliveries/index\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Delivery - /deliveries/index</span></span><button id=\"removeMenuRow\" name=\"Delivery\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li label=\"Schedule a delivery\" icon=\"\" url=\"/deliveries/index\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Schedule a delivery - /deliveries/index</span></span><button id=\"removeMenuRow\" name=\"Schedule a delivery\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li>		<li label=\"Company\" icon=\"\" url=\"/companies/index\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Company - /companies/index</span></span><button id=\"removeMenuRow\" name=\"Company\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li label=\"About us\" icon=\"\" url=\"/companies/index\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> About us - /companies/index</span></span><button id=\"removeMenuRow\" name=\"About us\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li><li label=\"Services\" icon=\"\" url=\"/companies/index\"><div class=\"btn btn-large btn-block btn\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Services - /companies/index</span></span><button id=\"removeMenuRow\" name=\"Services\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div><ol tier=\"2\"><li label=\"Cleaning services\" icon=\"\" url=\"/companies/index\" style=\"\" class=\"\"><div class=\"btn btn-large btn-block btn-warning\" style=\"text-align:left;\"><span> <i id=\"icon_move_menu\" class=\"icon-move\"></i><span class=\"divisionUp\"><i class=\"\" chosen=\"\"></i> Cleaning services - /companies/index</span></span><button id=\"removeMenuRow\" name=\"Cleaning services\" style=\"position:absolute;right:75px;\"><i class=\"icon-trash\"></i></button></div></li></ol></li>','2013-10-08 17:42:16','2013-10-08 18:06:04');
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
-- Table structure for table `rewards`
--

DROP TABLE IF EXISTS `rewards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `discount` decimal(6,4) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rewards`
--

LOCK TABLES `rewards` WRITE;
/*!40000 ALTER TABLE `rewards` DISABLE KEYS */;
/*!40000 ALTER TABLE `rewards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `day` varchar(25) DEFAULT NULL,
  `deliver_date` datetime NOT NULL,
  `special_instructions` text,
  `type` varchar(20) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxes`
--

DROP TABLE IF EXISTS `taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `country` varchar(10) DEFAULT NULL,
  `rate` decimal(11,2) DEFAULT NULL,
  `per_basis` varchar(10) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxes`
--

LOCK TABLES `taxes` WRITE;
/*!40000 ALTER TABLE `taxes` DISABLE KEYS */;
INSERT INTO `taxes` VALUES (1,1,'State Tax','USA','9.50','Overall su','2013-09-05 22:57:06','2013-09-05 22:57:06');
/*!40000 ALTER TABLE `taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `pretax` decimal(11,2) DEFAULT NULL,
  `tax` decimal(11,2) DEFAULT NULL,
  `aftertax` decimal(11,2) DEFAULT NULL,
  `discount` decimal(11,2) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `invoices` text,
  `type` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
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
  `company_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` char(40) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_initial` varchar(1) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `contact_address` varchar(150) DEFAULT NULL,
  `contact_suite` varchar(20) DEFAULT NULL,
  `contact_city` varchar(100) DEFAULT NULL,
  `contact_state` varchar(50) DEFAULT NULL,
  `contact_country` varchar(10) DEFAULT NULL,
  `contact_email` varchar(150) DEFAULT NULL,
  `contact_zip` varchar(20) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `special_instructions` text,
  `profile_id` varchar(20) DEFAULT NULL,
  `payment_id` varchar(11) DEFAULT NULL,
  `token` varchar(8) DEFAULT NULL,
  `reward_status` int(1) DEFAULT NULL,
  `reward_points` int(11) DEFAULT NULL,
  `account` int(1) DEFAULT NULL,
  `starch` varchar(10) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7559 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (7524,1,1,'wondollaballa','f7161854aacd9a831dd7fb2d35dc3afc0f6b50ab','onedough83@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'light','2013-08-01 02:08:05','2013-08-01 02:08:05'),(7557,5,1,'wondochoung','f7161854aacd9a831dd7fb2d35dc3afc0f6b50ab',NULL,'Wondo',NULL,'Choung',NULL,'2406 24th ave East',NULL,'seattle','WA',NULL,'onedough83@gmail.com','98001','2342342342','test','21627186','19763828',NULL,NULL,NULL,1,'light','2013-10-22 22:04:21','2013-10-22 22:04:26'),(7558,1,NULL,'ydc2415','44aeddfc5bbf497c0cca0c6bdad206107e202654','ydc2415@hotmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-10-23 01:26:39','2013-10-23 01:26:39');
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

-- Dump completed on 2013-10-24  3:35:22
