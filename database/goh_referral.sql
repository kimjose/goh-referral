-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: goh_referral
-- ------------------------------------------------------
-- Server version	8.0.32-0ubuntu0.22.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `user_categories`
--

DROP TABLE IF EXISTS `user_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '',
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_categories`
--

LOCK TABLES `user_categories` WRITE;
/*!40000 ALTER TABLE `user_categories` DISABLE KEYS */;
INSERT INTO `user_categories` VALUES (1,'System Admin','System Admin',NULL,'2023-04-11 07:41:52','2023-04-11 07:41:52');
/*!40000 ALTER TABLE `user_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_tokens`
--

DROP TABLE IF EXISTS `user_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `access_token` varchar(500) NOT NULL,
  `refresh_token` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_tokens`
--

LOCK TABLES `user_tokens` WRITE;
/*!40000 ALTER TABLE `user_tokens` DISABLE KEYS */;
INSERT INTO `user_tokens` VALUES (2,1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJpbmZpbml0b3BzIiwiaWF0IjoxNjgxMjEyNjA5LCJleHAiOjE2ODEyMTI3ODksImRhdGEiOnsiaWQiOjF9fQ.YVEmY8qwZx-9d14UYntMUTWWHPBDD0dMEreD1mZm6AwA6Ls4MYzI3HOZHWfUXqtC8ruBomBU_0qs8doVSRJSUjAshD-8PbrRdXAmL4Fsvwihv9QyVHNd7pvawyPCDrc6jnfKfF5sySuKHqENzdIHkyxECxMW4TmHEX59uZXrPCs32NsFTfQ0oZVRQY4x3BkHkp3dsd2IA8MEKLFusZMZo_0vBydC_ivUH4fSceSXKoV_3YA6PKY3kVlWxpzZ19VgLoeRw7U7O-7ufLBfaKANDIdjGh3Xie_kIP5ngeb2L0KzUS3V7Gs4ZPAISyF_rZKdBVD5zdJxSN-ICHIJObjeGA','eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJpbmZpbml0b3BzIiwiaWF0IjoxNjgxMjEyNjA5LCJleHAiOjE2ODEyMTI3ODksImRhdGEiOnsiaWQiOjF9fQ.YVEmY8qwZx-9d14UYntMUTWWHPBDD0dMEreD1mZm6AwA6Ls4MYzI3HOZHWfUXqtC8ruBomBU_0qs8doVSRJSUjAshD-8PbrRdXAmL4Fsvwihv9QyVHNd7pvawyPCDrc6jnfKfF5sySuKHqENzdIHkyxECxMW4TmHEX59uZXrPCs32NsFTfQ0oZVRQY4x3BkHkp3dsd2IA8MEKLFusZMZo_0vBydC_ivUH4fSceSXKoV_3YA6PKY3kVlWxpzZ19VgLoeRw7U7O-7ufLBfaKANDIdjGh3Xie_kIP5ngeb2L0KzUS3V7Gs4ZPAISyF_rZKdBVD5zdJxSN-ICHIJObjeGA','2023-04-11 11:30:09','2023-04-11 11:30:09'),(3,1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJpbmZpbml0b3BzIiwiaWF0IjoxNjgxMjEyNzI3LCJleHAiOjE2ODEyMTI5MDcsImRhdGEiOnsiaWQiOjF9fQ.l9vuGbyOFg-KnLL7EhNR9jUlNmmJwy9J7fCqnPnlsvWFaSJ2LrYW6UpmfghDMuy-6FVmhvIPfdH7ZRRzPKoXHerwis-4HaoQSm4aAJkTU2LLmTgajaiDaRKjec6ASubodTW1s4mTMOeHoMY-8EZw7LGb3iAwHMV5VgfpxDhVKOskhPYxkQlq5zPP1DYNzoSIvbsJFEGIJMqMgOBIVEcxeJrqhtFlfsQtpVCBD36ukbpnGN1QsaAAX_YyIHSCN96j5sHHP75_lqCr57VIAFcU9NF2JnRtJ0Z7V09e-ZGIskgfHukayh4zidUOlPDqAqOOU7G4Gu8b-Dm5SGSfb91y_Q','eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJpbmZpbml0b3BzIiwiaWF0IjoxNjgxMjEyNzI3LCJleHAiOjE2ODEyMTI5MDcsImRhdGEiOnsiaWQiOjF9fQ.l9vuGbyOFg-KnLL7EhNR9jUlNmmJwy9J7fCqnPnlsvWFaSJ2LrYW6UpmfghDMuy-6FVmhvIPfdH7ZRRzPKoXHerwis-4HaoQSm4aAJkTU2LLmTgajaiDaRKjec6ASubodTW1s4mTMOeHoMY-8EZw7LGb3iAwHMV5VgfpxDhVKOskhPYxkQlq5zPP1DYNzoSIvbsJFEGIJMqMgOBIVEcxeJrqhtFlfsQtpVCBD36ukbpnGN1QsaAAX_YyIHSCN96j5sHHP75_lqCr57VIAFcU9NF2JnRtJ0Z7V09e-ZGIskgfHukayh4zidUOlPDqAqOOU7G4Gu8b-Dm5SGSfb91y_Q','2023-04-11 11:32:07','2023-04-11 11:32:07'),(4,1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJpbmZpbml0b3BzIiwiaWF0IjoxNjgxMjE0NjMzLCJleHAiOjE2ODEyMTQ4MTMsImRhdGEiOnsiaWQiOjF9fQ.jpop9hdYpm6Al-YFQ8fcqfDyShI6w7dfWMlXj4caOzJTZYxjxW2CeIw16GYzJ7Ina9MX1e5x8V4sh9-s4ApBaibDugz2V-6zkF6HcR0Tu35342a5-YKr4L3j_Rfm7ry0jg8C_p_9K2erbxmeo4VJnrjnrL5UL3ArNwY9-rS0g0KOx-0Xckt97IfjPBt0stbZE-49QGnLeHA4hi9sXtLL7TSKBOTpGtqw1I5ekB4iM2ETZj1hMumeHDJHA3DnblxDa-QG5Fs6DTM_lxBKNziO655aSRsFQ5rReHkeQotrs16BBTPG1VFP8MESHfd4yn1W0herb67mly8HMRzh3Om2Xg','eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJpbmZpbml0b3BzIiwiaWF0IjoxNjgxMjE0NjMzLCJleHAiOjE2ODEyMTQ4MTMsImRhdGEiOnsiaWQiOjF9fQ.jpop9hdYpm6Al-YFQ8fcqfDyShI6w7dfWMlXj4caOzJTZYxjxW2CeIw16GYzJ7Ina9MX1e5x8V4sh9-s4ApBaibDugz2V-6zkF6HcR0Tu35342a5-YKr4L3j_Rfm7ry0jg8C_p_9K2erbxmeo4VJnrjnrL5UL3ArNwY9-rS0g0KOx-0Xckt97IfjPBt0stbZE-49QGnLeHA4hi9sXtLL7TSKBOTpGtqw1I5ekB4iM2ETZj1hMumeHDJHA3DnblxDa-QG5Fs6DTM_lxBKNziO655aSRsFQ5rReHkeQotrs16BBTPG1VFP8MESHfd4yn1W0herb67mly8HMRzh3Om2Xg','2023-04-11 12:03:53','2023-04-11 12:03:53'),(5,1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJpbmZpbml0b3BzIiwiaWF0IjoxNjgxMjE1MTgzLCJleHAiOjE2ODEyMTUzNjMsImRhdGEiOnsiaWQiOjF9fQ.Wh9DdJP8-tx70RxlvB8LMUUmcx9mScwBO0Y562krEmrmLJh9I2jWeKrf6qkh7da9vbb08TxfuZpD1wpFcOXyWQ90jBWC1vTKfO7A-oJUs_7bBvjX8edrUkZrvFktLsPymkXl-vUUCvcvNWG4jWenrZGQe6PrkNHvG1IOjsCZWAtKcpoO2_tIrTVUCbbb6QiK7imCjM47puUrwdguOtj-tw_6jdtu_nDjDP56cGsDm-wbQIPwH1GMgsBxFqD1ufPvuwDIocKWIVk0VxJW1DaeeMx3z8LmO1jrlwNuOUNfIB7dE5hufd_aFDwaHghFjs_aVlk30spyCuCsj3RzCZ0HKQ','eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJpbmZpbml0b3BzIiwiaWF0IjoxNjgxMjE1MTgzLCJleHAiOjE2ODEyMTUzNjMsImRhdGEiOnsiaWQiOjF9fQ.Wh9DdJP8-tx70RxlvB8LMUUmcx9mScwBO0Y562krEmrmLJh9I2jWeKrf6qkh7da9vbb08TxfuZpD1wpFcOXyWQ90jBWC1vTKfO7A-oJUs_7bBvjX8edrUkZrvFktLsPymkXl-vUUCvcvNWG4jWenrZGQe6PrkNHvG1IOjsCZWAtKcpoO2_tIrTVUCbbb6QiK7imCjM47puUrwdguOtj-tw_6jdtu_nDjDP56cGsDm-wbQIPwH1GMgsBxFqD1ufPvuwDIocKWIVk0VxJW1DaeeMx3z8LmO1jrlwNuOUNfIB7dE5hufd_aFDwaHghFjs_aVlk30spyCuCsj3RzCZ0HKQ','2023-04-11 12:13:03','2023-04-11 12:13:03'),(6,1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJpbmZpbml0b3BzIiwiaWF0IjoxNjgxMjE3NTE5LCJleHAiOjE2ODEyMTc2OTksImRhdGEiOnsiaWQiOjF9fQ.EUwNYz6kvt9V99Fszq_Z1Uvhyp1EGsUFxNu9SlTYsjW562L9YunarHZi6R1oYTDXSkZ73JES0UlxVLg0TOuSmPr5RB_howG7uGsJ31ShFhymG3ca9g_Li-N23phQ9Jlo_q6L3W-1mU3xkxdgLGO3ur6Y5df_q9LyYLhmOTWnjc3clSjAAmIuQLP7Aww2cRfo7abpDqC3q_DBK2Q1XCXOEireDhoUZDG-lG2DwUn-raPXSfYY18_rOAJ7QZ1LnnZ2nBaxzArHStm_ctrBRI5qRAUGcOPXpXaDyGqCVbIgLykNRabRODY565xWoaDlt7FWgvEzbOLAL1p9S7LM6Esl6Q','eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJpbmZpbml0b3BzIiwiaWF0IjoxNjgxMjE3OTAyLCJleHAiOjE2ODEyMTgwODIsImRhdGEiOnsiaWQiOjF9fQ.o7z8Cru7VzU1v3e2bow2etbrlyFxvMA03NeA28pULLgQ0rx-A9l_HtjSA10T2aYMj6m67vNpNBZh-8SQIJAPRUXcDXeMq0pRrgeRKxtZgxk67ay2rrdKcj1tfyRxGfRgR08HpE9yjUSluK7KUir9R6dgxUiUAQfmOvg6-HYbpWE3QCZU03XIpCoJdE8ZR_3IkLXGZ-5WuVOqqmzObqyne_jR_DX8D8obkDQRR2cMufjG-i_GPjG4XO6nbznS7r7kpbdLjb1LoqolNsd_uKepNKcu8ezdJJl6viNby9N8NCkJMQDQ2pfY_FYhDoKaZvovEQEuTfN9QY_uzii_IUucug','2023-04-11 12:51:59','2023-04-11 12:58:22');
/*!40000 ALTER TABLE `user_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone_number` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `middle_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `unique_email` (`email`) USING BTREE,
  KEY `index_email` (`email`) USING BTREE,
  KEY `fk_user_creator` (`created_by`) USING BTREE,
  KEY `fk_user_category` (`category_id`) USING BTREE,
  CONSTRAINT `fk_user_category` FOREIGN KEY (`category_id`) REFERENCES `user_categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'admin@admin.com','0717845485','Admin','Admin','Adminp','$2y$10$FeAFgsM/eSsNLnftpZ7keeVFCzww3zUGr/6V7UhRbyesS0k1/q7M.','2023-04-11 00:51:59',NULL,'2023-04-11 07:43:03','2023-04-11 12:51:59');
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

-- Dump completed on 2023-04-11 17:35:59
