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
-- Table structure for table `refund_application_operation`
--

DROP TABLE IF EXISTS `refund_application_operation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_application_operation` (
  `refund_application_operation_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_application_id` int(11) DEFAULT NULL,
  `refund_internal_operational_id` int(11) DEFAULT NULL,
  `access_role` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0: Unverified',
  `refund_status_reason_setting_id` int(11) DEFAULT NULL,
  `narration` varchar(500) DEFAULT NULL,
  `assignee` int(11) DEFAULT NULL,
  `assigned_at` datetime DEFAULT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  `last_verified_by` int(11) DEFAULT NULL,
  `is_current_stage` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1: Current Stage, 0: Not Current Stage',
  `date_verified` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0: InActive, 1: Active',
  PRIMARY KEY (`refund_application_operation_id`),
  KEY `assignedByref3_idfk` (`assigned_by`),
  KEY `createdByref3_idfk` (`created_by`),
  KEY `assigneeref3_idfk` (`assignee`),
  KEY `lastVerifiedByref3_idfk` (`last_verified_by`),
  KEY `refundApplication3_idfk` (`refund_application_id`),
  KEY `refundComment3_idfk` (`refund_status_reason_setting_id`),
  KEY `refundInternalOper3_idfk` (`refund_internal_operational_id`),
  KEY `updatedBy3_idfk` (`updated_by`),
  CONSTRAINT `assignedByref3_idfk` FOREIGN KEY (`assigned_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `assigneeref3_idfk` FOREIGN KEY (`assignee`) REFERENCES `user` (`user_id`),
  CONSTRAINT `createdByref3_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `lastVerifiedByref3_idfk` FOREIGN KEY (`last_verified_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `refundApplication3_idfk` FOREIGN KEY (`refund_application_id`) REFERENCES `refund_application` (`refund_application_id`),
  CONSTRAINT `refundComment3_idfk` FOREIGN KEY (`refund_status_reason_setting_id`) REFERENCES `refund_comment` (`refund_comment_id`),
  CONSTRAINT `refundInternalOper3_idfk` FOREIGN KEY (`refund_internal_operational_id`) REFERENCES `refund_internal_operational_setting` (`refund_internal_operational_id`),
  CONSTRAINT `updatedBy3_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_application_operation`
--

LOCK TABLES `refund_application_operation` WRITE;
/*!40000 ALTER TABLE `refund_application_operation` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_application_operation` ENABLE KEYS */;
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
