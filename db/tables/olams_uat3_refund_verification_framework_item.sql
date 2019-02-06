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
-- Table structure for table `refund_verification_framework_item`
--

DROP TABLE IF EXISTS `refund_verification_framework_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_verification_framework_item` (
  `refund_verification_framework_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_verification_framework_id` int(11) DEFAULT NULL,
  `attachment_definition_id` int(11) DEFAULT NULL,
  `verification_prompt` varchar(200) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1: Mandatory, 2: Optional',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `last_updated_at` datetime DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1: Active, 0: InActive',
  PRIMARY KEY (`refund_verification_framework_item_id`),
  KEY `attachmentDefin10_idfk` (`attachment_definition_id`),
  KEY `createdBy10_idfk` (`created_by`),
  KEY `lastUpdatedBy10_idfk` (`last_updated_by`),
  KEY `refundVerificationFram10_idfk` (`refund_verification_framework_id`),
  CONSTRAINT `attachmentDefin10_idfk` FOREIGN KEY (`attachment_definition_id`) REFERENCES `attachment_definition` (`attachment_definition_id`),
  CONSTRAINT `createdBy10_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `lastUpdatedBy10_idfk` FOREIGN KEY (`last_updated_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `refundVerificationFram10_idfk` FOREIGN KEY (`refund_verification_framework_id`) REFERENCES `refund_verification_framework` (`refund_verification_framework_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_verification_framework_item`
--

LOCK TABLES `refund_verification_framework_item` WRITE;
/*!40000 ALTER TABLE `refund_verification_framework_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_verification_framework_item` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-06 17:22:59
