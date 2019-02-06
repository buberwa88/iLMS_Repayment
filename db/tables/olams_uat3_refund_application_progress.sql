-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: olams_uat3
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.25-MariaDB

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
-- Table structure for table `refund_application_progress`
--

DROP TABLE IF EXISTS `refund_application_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_application_progress` (
  `refund_application_progress_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_application_id` int(11) DEFAULT NULL,
  `refund_application_operation_id` int(11) DEFAULT NULL,
  `refund_status_reason_setting_id` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`refund_application_progress_id`),
  KEY `refApplication_idfk` (`refund_application_id`),
  KEY `refApplicationOprt_idfk` (`refund_application_operation_id`),
  KEY `refStatusReasSetting_idfk` (`refund_status_reason_setting_id`),
  KEY `createdBy17_idfk` (`created_by`),
  KEY `updatedBy17_idfk` (`updated_by`),
  CONSTRAINT `createdBy17_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `refApplicationOprt_idfk` FOREIGN KEY (`refund_application_operation_id`) REFERENCES `refund_application_operation` (`refund_application_operation_id`),
  CONSTRAINT `refApplication_idfk` FOREIGN KEY (`refund_application_id`) REFERENCES `refund_application` (`refund_application_id`),
  CONSTRAINT `refStatusReasSetting_idfk` FOREIGN KEY (`refund_status_reason_setting_id`) REFERENCES `refund_status_reason_setting` (`refund_status_reason_setting_id`),
  CONSTRAINT `updatedBy17_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_application_progress`
--

LOCK TABLES `refund_application_progress` WRITE;
/*!40000 ALTER TABLE `refund_application_progress` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_application_progress` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-06 17:23:03
