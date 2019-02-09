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
  `trustee_phone_number` varchar(20) DEFAULT NULL,
  `trustee_email` varchar(20) DEFAULT NULL,
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
  CONSTRAINT `refundVerifcationFram_idfk` FOREIGN KEY (`refund_verification_framework_id`) REFERENCES `refund_verification_framework` (`refund_verification_framework_id`),
  CONSTRAINT `updateByRef_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_application`
--

LOCK TABLES `refund_application` WRITE;
/*!40000 ALTER TABLE `refund_application` DISABLE KEYS */;
INSERT INTO `refund_application` VALUES (1,1,'1549617539',NULL,1,1,'Telesphory','Juma','Seveline','0765342521','telesphory@gmail.com',NULL,0,NULL,NULL,NULL,NULL,NULL,1,NULL,'2019-02-08 12:18:59',NULL,'2019-02-08 12:18:59',NULL,1,1),(2,2,'1549619552',NULL,1,1,'gdbdbd','hfhfbf','hdhnf','076412345','telesphory@gmail.com',NULL,0,NULL,NULL,NULL,NULL,NULL,1,NULL,'2019-02-08 12:52:32',NULL,'2019-02-08 12:52:32',NULL,1,1),(3,3,'1549621557',NULL,1,1,'dgdfgr','fdgfhgf','trhrth','0765341234','telesphory@gmail.com',NULL,0,NULL,NULL,NULL,NULL,NULL,1,NULL,'2019-02-08 13:25:57',NULL,'2019-02-08 13:25:57',NULL,1,1),(4,4,'1549621766',NULL,1,1,'rgreg','dfgfhbf','rgrg','078634535321','telesphory@gmail.com',NULL,0,NULL,NULL,NULL,NULL,NULL,1,NULL,'2019-02-08 13:29:26',NULL,'2019-02-08 13:29:26',NULL,1,1),(5,5,'1549636561',NULL,1,1,'drger','erge','ergeg','0786453436','telesphory@gmail.com',NULL,0,NULL,NULL,NULL,NULL,NULL,1,NULL,'2019-02-08 17:36:01',NULL,'2019-02-08 17:36:01',NULL,1,1),(6,6,'1549636825',NULL,1,1,'veve','dvrtbtr','errvev','0876352532','telesphory@gmail.com',NULL,0,NULL,NULL,NULL,NULL,NULL,1,NULL,'2019-02-08 17:40:25',NULL,'2019-02-08 17:40:25',NULL,1,1),(7,7,'1549645253',NULL,1,1,'Telesphory','Buberwa','Seveline','07653435353','telesphory@gmail.com',NULL,0,NULL,NULL,NULL,NULL,NULL,1,NULL,'2019-02-08 20:00:53',NULL,'2019-02-08 20:00:53',NULL,1,1),(8,8,'1549682261',NULL,1,1,'Amza','Salum','Kamwela','0765423142','telesphory@gmail.com',NULL,0,NULL,NULL,NULL,NULL,NULL,1,NULL,'2019-02-09 06:17:41',NULL,'2019-02-09 06:17:41',NULL,1,1);
/*!40000 ALTER TABLE `refund_application` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Table structure for table `refund_application_operation_letter`
--

DROP TABLE IF EXISTS `refund_application_operation_letter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_application_operation_letter` (
  `refund_application_operation_letter_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_application_operation_id` int(11) DEFAULT NULL,
  `letter_number` varchar(100) DEFAULT NULL,
  `refund_letter_format_id` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`refund_application_operation_letter_id`),
  KEY `refApplOper_idfk` (`refund_application_operation_id`),
  KEY `refLetterFormt_idfk` (`refund_letter_format_id`),
  KEY `createdBy16_idfk` (`created_by`),
  KEY `updatedBy16_idfk` (`updated_by`),
  CONSTRAINT `createdBy16_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `refApplOper_idfk` FOREIGN KEY (`refund_application_operation_id`) REFERENCES `refund_application_operation` (`refund_application_operation_id`),
  CONSTRAINT `refLetterFormt_idfk` FOREIGN KEY (`refund_letter_format_id`) REFERENCES `refund_letter_format` (`refund_letter_format_id`),
  CONSTRAINT `updatedBy16_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_application_operation_letter`
--

LOCK TABLES `refund_application_operation_letter` WRITE;
/*!40000 ALTER TABLE `refund_application_operation_letter` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_application_operation_letter` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Table structure for table `refund_claimant`
--

DROP TABLE IF EXISTS `refund_claimant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_claimant` (
  `refund_claimant_id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `middlename` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `sex` char(1) NOT NULL COMMENT 'M-Male, F-Female',
  `phone_number` varchar(50) DEFAULT NULL,
  `f4indexno` varchar(200) DEFAULT NULL,
  `f4_completion_year` int(11) DEFAULT NULL,
  `necta_firstname` varchar(45) DEFAULT NULL,
  `necta_middlename` varchar(45) DEFAULT NULL,
  `necta_surname` varchar(45) DEFAULT NULL,
  `necta_sex` char(1) DEFAULT NULL COMMENT 'M-Male, F-Female',
  `necta_details_confirmed` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1: Not confirmed, 2: Confirmed',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`refund_claimant_id`),
  KEY `applicantRef4_idfk` (`applicant_id`),
  KEY `createdByref4_idfk` (`created_by`),
  KEY `updatedBy4_idfk` (`updated_by`),
  CONSTRAINT `applicantRef4_idfk` FOREIGN KEY (`applicant_id`) REFERENCES `applicant` (`applicant_id`),
  CONSTRAINT `createdByref4_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `updatedBy4_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_claimant`
--

LOCK TABLES `refund_claimant` WRITE;
/*!40000 ALTER TABLE `refund_claimant` DISABLE KEYS */;
INSERT INTO `refund_claimant` VALUES (1,NULL,'Telesphory','Juma','Seveline','','0765342521',NULL,NULL,NULL,NULL,NULL,NULL,1,'2019-02-08 12:18:59',NULL,'2019-02-08 12:18:59',NULL),(2,NULL,'gdbdbd','hfhfbf','hdhnf','','076412345','XDCF.WESDF.EEEEE',2003,'ERCFRCR','SDCFXDSSDF','RVRVRV',NULL,1,'2019-02-08 12:52:32',NULL,'2019-02-08 12:52:32',NULL),(3,NULL,'dgdfgr','fdgfhgf','trhrth','','0765341234',NULL,NULL,NULL,NULL,NULL,NULL,1,'2019-02-08 13:25:57',NULL,'2019-02-08 13:25:57',NULL),(4,NULL,'rgreg','dfgfhbf','rgrg','','078634535321','wsedxcfvgg',2005,'Telesphory','Elias','Seveline',NULL,1,'2019-02-08 13:29:26',NULL,'2019-02-08 13:29:26',NULL),(5,NULL,'drger','erge','ergeg','','0786453436',NULL,NULL,NULL,NULL,NULL,NULL,1,'2019-02-08 17:36:01',NULL,'2019-02-08 17:36:01',NULL),(6,NULL,'veve','dvrtbtr','errvev','','0876352532','SWE78.238.9IWS',1982,'efefef','efefef','evfewfvw',NULL,1,'2019-02-08 17:40:25',NULL,'2019-02-08 17:40:25',NULL),(7,NULL,'Telesphory','Buberwa','Seveline','','07653435353','ytiutyiu',1983,'tyiti','tuftur','rurue',NULL,1,'2019-02-08 20:00:53',NULL,'2019-02-08 20:00:53',NULL),(8,NULL,'Amza','Salum','Kamwela','','0765423142','SDCFV.RRE',2003,'Amza','Salum','Kamwela',NULL,1,'2019-02-09 06:17:41',NULL,'2019-02-09 06:17:41',NULL);
/*!40000 ALTER TABLE `refund_claimant` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Table structure for table `refund_claimant_education_history`
--

DROP TABLE IF EXISTS `refund_claimant_education_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_claimant_education_history` (
  `refund_education_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_application_id` int(11) DEFAULT NULL,
  `study_level` int(11) DEFAULT NULL,
  `program_id` int(11) DEFAULT NULL,
  `institution_id` int(11) DEFAULT NULL,
  `entry_year` int(11) DEFAULT NULL,
  `completion_year` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0: InAActive, 1: Active',
  PRIMARY KEY (`refund_education_history_id`),
  KEY `createdByref7_idfk` (`created_by`),
  KEY `learningInstituit7_idfk` (`institution_id`),
  KEY `updatedBy7_idfk` (`updated_by`),
  KEY `programmeref7_idfk` (`program_id`),
  CONSTRAINT `createdByref7_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `learningInstituit7_idfk` FOREIGN KEY (`institution_id`) REFERENCES `learning_institution` (`learning_institution_id`),
  CONSTRAINT `programmeref7_idfk` FOREIGN KEY (`program_id`) REFERENCES `programme` (`programme_id`),
  CONSTRAINT `updatedBy7_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_claimant_education_history`
--

LOCK TABLES `refund_claimant_education_history` WRITE;
/*!40000 ALTER TABLE `refund_claimant_education_history` DISABLE KEYS */;
INSERT INTO `refund_claimant_education_history` VALUES (1,6,1,316,1,43333,667778,NULL,NULL,NULL,NULL,1),(2,6,2,8,3,4334,8976,NULL,NULL,NULL,NULL,1),(3,7,1,23,1,43333,667778,NULL,NULL,NULL,NULL,1),(4,7,2,20,3,4334,6572,NULL,NULL,NULL,NULL,1),(5,8,1,25,3,43333,667778,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `refund_claimant_education_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_claimant_employment`
--

DROP TABLE IF EXISTS `refund_claimant_employment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_claimant_employment` (
  `refund_claimant_employment_id` int(11) NOT NULL AUTO_INCREMENT,
  `employer_name` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `refund_claimant_id` int(11) DEFAULT NULL,
  `refund_application_id` int(11) DEFAULT NULL,
  `employee_id` varchar(100) DEFAULT NULL,
  `matching_status` varchar(200) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`refund_claimant_employment_id`),
  KEY `refundApp14_idfk` (`refund_application_id`),
  KEY `refundClaimant14_idfk` (`refund_claimant_id`),
  KEY `createdByef14` (`created_by`),
  KEY `updatedByef14_idfk` (`updated_by`),
  CONSTRAINT `createdByef14` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `refundApp14_idfk` FOREIGN KEY (`refund_application_id`) REFERENCES `refund_application` (`refund_application_id`),
  CONSTRAINT `refundClaimant14_idfk` FOREIGN KEY (`refund_claimant_id`) REFERENCES `refund_claimant` (`refund_claimant_id`),
  CONSTRAINT `updatedByef14_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_claimant_employment`
--

LOCK TABLES `refund_claimant_employment` WRITE;
/*!40000 ALTER TABLE `refund_claimant_employment` DISABLE KEYS */;
INSERT INTO `refund_claimant_employment` VALUES (1,'rehrthr','0000-00-00','0000-00-00',NULL,8,'rthrthr',NULL,NULL,NULL,NULL,NULL),(2,'weferg','0000-00-00','0000-00-00',NULL,8,'rgreg',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `refund_claimant_employment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_comment`
--

DROP TABLE IF EXISTS `refund_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_comment` (
  `refund_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `attachment_definition_id` int(11) DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1: Active, 0: InActive',
  PRIMARY KEY (`refund_comment_id`),
  KEY `attachmentDefiniRef6_idfk` (`attachment_definition_id`),
  KEY `createdBy6_idfk` (`created_by`),
  KEY `updatedBy6_idfk` (`updated_by`),
  CONSTRAINT `attachmentDefiniRef6_idfk` FOREIGN KEY (`attachment_definition_id`) REFERENCES `attachment_definition` (`attachment_definition_id`),
  CONSTRAINT `createdBy6_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `updatedBy6_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_comment`
--

LOCK TABLES `refund_comment` WRITE;
/*!40000 ALTER TABLE `refund_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_contact_person`
--

DROP TABLE IF EXISTS `refund_contact_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_contact_person` (
  `refund_contact_person_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_application_id` int(11) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `middlename` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email_address` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`refund_contact_person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_contact_person`
--

LOCK TABLES `refund_contact_person` WRITE;
/*!40000 ALTER TABLE `refund_contact_person` DISABLE KEYS */;
INSERT INTO `refund_contact_person` VALUES (1,7,'Telesphory','Buberwa','Seveline','2019-02-08 20:00:53','2019-02-08 20:00:53','07653435353','telesphory@gmail.com'),(2,8,'Amza','Salum','Kamwela','2019-02-09 06:17:41','2019-02-09 06:17:41','0765423142','telesphory@gmail.com');
/*!40000 ALTER TABLE `refund_contact_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_internal_operational_setting`
--

DROP TABLE IF EXISTS `refund_internal_operational_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_internal_operational_setting` (
  `refund_internal_operational_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `access_role_master` varchar(100) DEFAULT NULL,
  `access_role_child` varchar(100) DEFAULT NULL,
  `flow_order_list` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1: Active, 0: InActive',
  PRIMARY KEY (`refund_internal_operational_id`),
  KEY `createdByRef2_idfk` (`created_by`),
  KEY `updatedByRef2_idfk` (`updated_by`),
  CONSTRAINT `createdByRef2_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `updatedByRef2_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_internal_operational_setting`
--

LOCK TABLES `refund_internal_operational_setting` WRITE;
/*!40000 ALTER TABLE `refund_internal_operational_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_internal_operational_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_letter_format`
--

DROP TABLE IF EXISTS `refund_letter_format`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_letter_format` (
  `refund_letter_format_id` int(11) NOT NULL AUTO_INCREMENT,
  `letter_name` varchar(200) DEFAULT NULL,
  `header` varchar(200) DEFAULT NULL,
  `footer` varchar(200) DEFAULT NULL,
  `letter_heading` varchar(50) DEFAULT NULL,
  `letter_body` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0: InAActive, 1: Active',
  PRIMARY KEY (`refund_letter_format_id`),
  KEY `createdByref8_idfk` (`created_by`),
  KEY `updatedByref8_idfk` (`updated_by`),
  CONSTRAINT `createdByref8_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `updatedByref8_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_letter_format`
--

LOCK TABLES `refund_letter_format` WRITE;
/*!40000 ALTER TABLE `refund_letter_format` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_letter_format` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_status_reason_setting`
--

DROP TABLE IF EXISTS `refund_status_reason_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_status_reason_setting` (
  `refund_status_reason_setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) DEFAULT NULL,
  `reason` varchar(200) DEFAULT NULL,
  `category` tinyint(2) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`refund_status_reason_setting_id`),
  KEY `createdByref15_idfk` (`created_by`),
  KEY `updatedByref15_idfk` (`updated_by`),
  CONSTRAINT `createdByref15_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `updatedByref15_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_status_reason_setting`
--

LOCK TABLES `refund_status_reason_setting` WRITE;
/*!40000 ALTER TABLE `refund_status_reason_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_status_reason_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_type`
--

DROP TABLE IF EXISTS `refund_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_type` (
  `refund_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1: Active, 0: InActive',
  PRIMARY KEY (`refund_type_id`),
  KEY `createdBy8_idfk` (`created_by`),
  KEY `updatedBy8_idfk` (`updated_by`),
  CONSTRAINT `createdBy8_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `updatedBy8_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_type`
--

LOCK TABLES `refund_type` WRITE;
/*!40000 ALTER TABLE `refund_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_verification_framework`
--

DROP TABLE IF EXISTS `refund_verification_framework`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_verification_framework` (
  `refund_verification_framework_id` int(11) NOT NULL AUTO_INCREMENT,
  `verification_framework_title` varchar(100) DEFAULT NULL,
  `verification_framework_desc` varchar(100) DEFAULT NULL,
  `verification_framework_stage` varchar(100) DEFAULT NULL,
  `support_document` varchar(100) DEFAULT NULL,
  `refund_type_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `confirmed_by` int(11) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0: InActive, 1: Active',
  PRIMARY KEY (`refund_verification_framework_id`),
  KEY `confirmedBy9_idfk` (`confirmed_by`),
  KEY `createdBy9_idfk` (`created_by`),
  KEY `refundType9_idfk` (`refund_type_id`),
  KEY `updatedBy9_idfk` (`updated_by`),
  CONSTRAINT `confirmedBy9_idfk` FOREIGN KEY (`confirmed_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `createdBy9_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `refundType9_idfk` FOREIGN KEY (`refund_type_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `updatedBy9_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_verification_framework`
--

LOCK TABLES `refund_verification_framework` WRITE;
/*!40000 ALTER TABLE `refund_verification_framework` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_verification_framework` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Table structure for table `refund_verification_status`
--

DROP TABLE IF EXISTS `refund_verification_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_verification_status` (
  `refund_verification_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1: Active, 0: InActive',
  PRIMARY KEY (`refund_verification_status_id`),
  KEY `createdBy11_idfk` (`created_by`),
  KEY `updatedBy11_idfk` (`updated_by`),
  CONSTRAINT `createdBy11_idfk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  CONSTRAINT `updatedBy11_idfk` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_verification_status`
--

LOCK TABLES `refund_verification_status` WRITE;
/*!40000 ALTER TABLE `refund_verification_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_verification_status` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-09 11:26:11
