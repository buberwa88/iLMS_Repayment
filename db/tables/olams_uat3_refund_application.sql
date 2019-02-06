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
-- Table structure for table `refund_application`
--

DROP TABLE IF EXISTS `refund_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_application` (
  `refund_application_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_claimant_id` int(11) DEFAULT NULL,
  `application_number` varchar(50) DEFAULT NULL,
  `refund_claimant_amount` decimal(38,2) DEFAULT NULL,
  `finaccial_year_id` int(11) DEFAULT NULL,
  `academic_year_id` int(11) DEFAULT NULL,
  `trustee_firstname` varchar(45) DEFAULT NULL,
  `trustee_midlename` varchar(45) DEFAULT NULL,
  `trustee_surname` varchar(45) DEFAULT NULL,
  `trustee_sex` char(1) DEFAULT NULL COMMENT 'M-Male, F-Female',
  `current_status` tinyint(2) DEFAULT '0' COMMENT '0: Unverified',
  `refund_verification_framework_id` int(11) DEFAULT NULL,
  `check_number` varchar(50) DEFAULT NULL,
  `bank_account_number` varchar(50) DEFAULT NULL,
  `bank_account_name` varchar(100) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `refund_type_id` int(11) DEFAULT NULL,
  `liquidation_letter_number` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0: InActive, 1: Active',
  `submitted` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1: Not Submitted, 2: Submitted but not Confirmed, 3: Submitted and Confirmed, 4: Attempted',
  PRIMARY KEY (`refund_application_id`),
  KEY `academicYear_idfk` (`academic_year_id`),
  KEY `bankref_idfk` (`bank_id`),
  KEY `createdByref_idfk` (`created_by`),
  KEY `financialYearref_idfk` (`finaccial_year_id`),
  KEY `refundClaimant_idfk` (`refund_claimant_id`),
  KEY `refundType_idfk` (`refund_type_id`),
  KEY `refundVerifcationFram_idfk` (`refund_verification_framework_id`),
  KEY `updateByRef_idfk` (`updated_by`),
  CONSTRAINT `academicYear_idfk` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_year` (`academic_year_id`),
  CONSTRAINT `bankref_idfk` FOREIGN KEY (`bank_id`) REFERENCES `bank` (`bank_id`),
  CONSTRAINT `createdByref_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `financialYearref_idfk` FOREIGN KEY (`finaccial_year_id`) REFERENCES `financial_year` (`financial_year_id`),
  CONSTRAINT `refundClaimant_idfk` FOREIGN KEY (`refund_claimant_id`) REFERENCES `refund_claimant` (`refund_claimant_id`),
  CONSTRAINT `refundType_idfk` FOREIGN KEY (`refund_type_id`) REFERENCES `refund_type` (`refund_type_id`),
  CONSTRAINT `refundVerifcationFram_idfk` FOREIGN KEY (`refund_verification_framework_id`) REFERENCES `refund_verification_framework` (`refund_verification_framework_id`),
  CONSTRAINT `updateByRef_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_application`
--

LOCK TABLES `refund_application` WRITE;
/*!40000 ALTER TABLE `refund_application` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_application` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-06 17:23:02
