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
-- Table structure for table `refund_claimant_attachment`
--

DROP TABLE IF EXISTS `refund_claimant_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_claimant_attachment` (
  `refund_claimant_attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_application_id` int(11) DEFAULT NULL,
  `attachment_definition_id` int(11) DEFAULT NULL,
  `attachment_path` varchar(500) DEFAULT NULL,
  `verification_status` int(11) NOT NULL DEFAULT '0' COMMENT '0: Unverified',
  `refund_comment_id` int(11) DEFAULT NULL,
  `other_description` varchar(500) DEFAULT NULL,
  `last_verified_by` int(11) DEFAULT NULL,
  `last_verified_at` datetime DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1: Active, 0: InActive',
  PRIMARY KEY (`refund_claimant_attachment_id`),
  KEY `attachmentDefiniRef5_idfk` (`attachment_definition_id`),
  KEY `verifiedBy5_idfk` (`last_verified_by`),
  KEY `refundApplication5_idfk` (`refund_application_id`),
  KEY `refundComment5_idfk` (`refund_comment_id`),
  CONSTRAINT `attachmentDefiniRef5_idfk` FOREIGN KEY (`attachment_definition_id`) REFERENCES `attachment_definition` (`attachment_definition_id`),
  CONSTRAINT `refundApplication5_idfk` FOREIGN KEY (`refund_application_id`) REFERENCES `refund_application` (`refund_application_id`),
  CONSTRAINT `refundComment5_idfk` FOREIGN KEY (`refund_comment_id`) REFERENCES `refund_comment` (`refund_comment_id`),
  CONSTRAINT `verifiedBy5_idfk` FOREIGN KEY (`last_verified_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_claimant_attachment`
--

LOCK TABLES `refund_claimant_attachment` WRITE;
/*!40000 ALTER TABLE `refund_claimant_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_claimant_attachment` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-06 17:23:04
