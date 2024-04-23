-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: recipe_food
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.22.04.1

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
-- Table structure for table `admin_menu`
--

DROP TABLE IF EXISTS `admin_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_menu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_menu`
--

LOCK TABLES `admin_menu` WRITE;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` VALUES (1,0,1,'Dashboard','icon-chart-bar','/',NULL,NULL,NULL),(2,0,2,'Admin','icon-server','',NULL,NULL,NULL),(3,2,3,'Users','icon-users','auth/users',NULL,NULL,NULL),(4,2,4,'Roles','icon-user','auth/roles',NULL,NULL,NULL),(5,2,5,'Permission','icon-ban','auth/permissions',NULL,NULL,NULL),(6,2,6,'Menu','icon-bars','auth/menu',NULL,NULL,NULL),(7,2,7,'Operation log','icon-history','auth/logs',NULL,NULL,NULL),(8,0,7,'Helpers','icon-cogs','',NULL,'2024-04-20 12:53:49','2024-04-20 12:53:49'),(9,8,8,'Scaffold','icon-keyboard','helpers/scaffold',NULL,'2024-04-20 12:53:49','2024-04-20 12:53:49'),(10,8,9,'Database terminal','icon-database','helpers/terminal/database',NULL,'2024-04-20 12:53:49','2024-04-20 12:53:49'),(11,8,10,'Laravel artisan','icon-terminal','helpers/terminal/artisan',NULL,'2024-04-20 12:53:49','2024-04-20 12:53:49'),(12,8,11,'Routes','icon-list-alt','helpers/routes',NULL,'2024-04-20 12:53:49','2024-04-20 12:53:49'),(13,0,11,'Recipes','icon-file','recipes',NULL,'2024-04-20 12:54:27','2024-04-20 12:54:27'),(14,0,11,'Users','icon-file','users',NULL,'2024-04-21 14:47:03','2024-04-21 14:47:03');
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_operation_log`
--

DROP TABLE IF EXISTS `admin_operation_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_operation_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_operation_log_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_operation_log`
--

LOCK TABLES `admin_operation_log` WRITE;
/*!40000 ALTER TABLE `admin_operation_log` DISABLE KEYS */;
INSERT INTO `admin_operation_log` VALUES (1,1,'admin','GET','192.168.56.1','[]','2024-04-20 12:53:57','2024-04-20 12:53:57'),(2,1,'admin/helpers/scaffold','GET','192.168.56.1','[]','2024-04-20 12:54:01','2024-04-20 12:54:01'),(3,1,'admin/helpers/scaffold','POST','192.168.56.1','{\"table_name\":\"recipes\",\"model_name\":\"App\\\\Models\\\\Recipe\",\"controller_name\":\"App\\\\Admin\\\\Controllers\\\\RecipeController\",\"create\":[\"controller\",\"menu_item\"],\"fields\":[{\"name\":null,\"type\":\"string\",\"nullable\":\"on\",\"key\":null,\"default\":null,\"comment\":null}],\"timestamps\":\"on\",\"primary_key\":\"id\",\"_token\":\"0JugLHKfLvaNhhhdd2OkgVaLDdCm4YHyHP0Md2Nq\"}','2024-04-20 12:54:27','2024-04-20 12:54:27'),(4,1,'admin/helpers/scaffold','GET','192.168.56.1','[]','2024-04-20 12:54:27','2024-04-20 12:54:27'),(5,1,'admin/helpers/scaffold','GET','192.168.56.1','[]','2024-04-20 12:54:30','2024-04-20 12:54:30'),(6,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-20 12:54:31','2024-04-20 12:54:31'),(7,1,'admin/recipes/2/edit','GET','192.168.56.1','[]','2024-04-20 12:54:33','2024-04-20 12:54:33'),(8,1,'admin/recipes/2','PUT','192.168.56.1','{\"creator_id\":\"1\",\"title\":\"Spaghetti Carbonara\",\"category_id\":\"2\",\"description\":\"Delicious and creamy spaghetti carbonara with crispy bacon.\",\"image_id\":\"2\",\"preparationTime\":\"30\",\"comment\":\"Serve immediately for best taste.\",\"totalLikes\":\"0\",\"avrgRating\":\"0.0\",\"isActive\":\"1\",\"search_terms\":null,\"_token\":\"0JugLHKfLvaNhhhdd2OkgVaLDdCm4YHyHP0Md2Nq\",\"_method\":\"PUT\"}','2024-04-20 12:54:36','2024-04-20 12:54:36'),(9,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-20 12:54:36','2024-04-20 12:54:36'),(10,1,'admin','GET','192.168.56.1','[]','2024-04-20 14:11:22','2024-04-20 14:11:22'),(11,1,'admin','GET','192.168.56.1','[]','2024-04-20 17:12:15','2024-04-20 17:12:15'),(12,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-20 17:12:18','2024-04-20 17:12:18'),(13,1,'admin/recipes/3/edit','GET','192.168.56.1','[]','2024-04-20 17:12:21','2024-04-20 17:12:21'),(14,1,'admin/recipes/3','PUT','192.168.56.1','{\"creator_id\":\"8\",\"title\":\"Classic Chocolate Chip Cookies\",\"category_id\":\"3\",\"description\":\"Crispy on the edges and chewy in the middle, these classic chocolate chip cookies are a favorite for all ages.\",\"image_id\":\"10\",\"preparationTime\":\"35\",\"comment\":\"enjoy !!\",\"totalLikes\":\"0\",\"avrgRating\":\"0.0\",\"isActive\":\"1\",\"search_terms\":null,\"_token\":\"jMGXJzLtQOco731U6y0LQ8cIALe8sIaVGxMVRh6u\",\"_method\":\"PUT\"}','2024-04-20 17:12:24','2024-04-20 17:12:24'),(15,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-20 17:12:24','2024-04-20 17:12:24'),(16,1,'admin','GET','192.168.56.1','[]','2024-04-21 14:46:03','2024-04-21 14:46:03'),(17,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 14:46:06','2024-04-21 14:46:06'),(18,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 14:46:35','2024-04-21 14:46:35'),(19,1,'admin/helpers/scaffold','GET','192.168.56.1','[]','2024-04-21 14:46:46','2024-04-21 14:46:46'),(20,1,'admin/helpers/scaffold','POST','192.168.56.1','{\"table_name\":\"users\",\"model_name\":\"App\\\\Models\\\\User\",\"controller_name\":\"App\\\\Admin\\\\Controllers\\\\UserController\",\"create\":[\"controller\",\"menu_item\"],\"fields\":[{\"name\":null,\"type\":\"string\",\"nullable\":\"on\",\"key\":null,\"default\":null,\"comment\":null}],\"timestamps\":\"on\",\"primary_key\":\"id\",\"_token\":\"m53MDOHH2SyEryhxN56sjvwwCpsGHhjXEx385OOV\"}','2024-04-21 14:47:03','2024-04-21 14:47:03'),(21,1,'admin/helpers/scaffold','GET','192.168.56.1','[]','2024-04-21 14:47:03','2024-04-21 14:47:03'),(22,1,'admin/helpers/scaffold','GET','192.168.56.1','[]','2024-04-21 14:47:06','2024-04-21 14:47:06'),(23,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 14:47:07','2024-04-21 14:47:07'),(24,1,'admin/users','GET','192.168.56.1','{\"id\":\"2\"}','2024-04-21 14:47:40','2024-04-21 14:47:40'),(25,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 14:47:41','2024-04-21 14:47:41'),(26,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 14:49:04','2024-04-21 14:49:04'),(27,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 14:50:17','2024-04-21 14:50:17'),(28,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"creator_id\":\"1\",\"search_terms\":null}','2024-04-21 14:50:29','2024-04-21 14:50:29'),(29,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"creator_id\":\"1\",\"search_terms\":null}','2024-04-21 14:51:02','2024-04-21 14:51:02'),(30,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"name\":\"Anna Miller\",\"search_terms\":null}','2024-04-21 14:51:05','2024-04-21 14:51:05'),(31,1,'admin/users/1/edit','GET','192.168.56.1','[]','2024-04-21 14:51:10','2024-04-21 14:51:10'),(32,1,'admin/users/1','PUT','192.168.56.1','{\"name\":\"Anna Miller\",\"email\":\"anna.miller@example.com\",\"email_verified_at\":\"2024-04-21 14:51:10\",\"password\":null,\"username\":\"annaskitchen\",\"bio\":\"Food blogger and recipe creator. Passionate about cooking and baking delicious dishes for family and friends.\",\"image_id\":\"1\",\"isVerified\":\"1\",\"search_terms\":null,\"_token\":\"m53MDOHH2SyEryhxN56sjvwwCpsGHhjXEx385OOV\",\"_method\":\"PUT\"}','2024-04-21 14:51:15','2024-04-21 14:51:15'),(33,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 14:51:15','2024-04-21 14:51:15'),(34,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 14:51:22','2024-04-21 14:51:22'),(35,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 14:51:24','2024-04-21 14:51:24'),(36,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 14:51:44','2024-04-21 14:51:44'),(37,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 14:52:18','2024-04-21 14:52:18'),(38,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 14:52:19','2024-04-21 14:52:19'),(39,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"name\":null,\"search_terms\":null,\"isVerified\":\"1\"}','2024-04-21 14:52:23','2024-04-21 14:52:23'),(40,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"name\":null,\"search_terms\":null,\"isVerified\":\"0\"}','2024-04-21 14:52:27','2024-04-21 14:52:27'),(41,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 14:52:30','2024-04-21 14:52:30'),(42,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 14:52:41','2024-04-21 14:52:41'),(43,1,'admin/recipes','GET','192.168.56.1','{\"id\":null,\"category_id\":\"1\",\"search_terms\":null,\"creator_id\":null,\"isActive\":null}','2024-04-21 14:52:55','2024-04-21 14:52:55'),(44,1,'admin/recipes','GET','192.168.56.1','{\"id\":null,\"category_id\":\"2\",\"search_terms\":null,\"creator_id\":null,\"isActive\":null}','2024-04-21 14:52:58','2024-04-21 14:52:58'),(45,1,'admin/recipes','GET','192.168.56.1','{\"id\":null,\"category_id\":\"2\",\"search_terms\":null,\"creator_id\":null,\"isActive\":null}','2024-04-21 14:58:13','2024-04-21 14:58:13'),(46,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 14:58:18','2024-04-21 14:58:18'),(47,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 14:58:21','2024-04-21 14:58:21'),(48,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 14:58:23','2024-04-21 14:58:23'),(49,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 14:58:24','2024-04-21 14:58:24'),(50,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 14:59:54','2024-04-21 14:59:54'),(51,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 14:59:57','2024-04-21 14:59:57'),(52,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 15:00:04','2024-04-21 15:00:04'),(53,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 15:05:18','2024-04-21 15:05:18'),(54,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 15:05:19','2024-04-21 15:05:19'),(55,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 15:05:21','2024-04-21 15:05:21'),(56,1,'admin/recipes/2/edit','GET','192.168.56.1','[]','2024-04-21 15:05:26','2024-04-21 15:05:26'),(57,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 15:05:29','2024-04-21 15:05:29'),(58,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 15:05:52','2024-04-21 15:05:52'),(59,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:05:56','2024-04-21 15:05:56'),(60,1,'admin/users/1','GET','192.168.56.1','[]','2024-04-21 15:05:57','2024-04-21 15:05:57'),(61,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:06:06','2024-04-21 15:06:06'),(62,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 15:06:26','2024-04-21 15:06:26'),(63,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:06:27','2024-04-21 15:06:27'),(64,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:06:27','2024-04-21 15:06:27'),(65,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:06:29','2024-04-21 15:06:29'),(66,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:07:36','2024-04-21 15:07:36'),(67,1,'admin/users/2','GET','192.168.56.1','[]','2024-04-21 15:07:38','2024-04-21 15:07:38'),(68,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:07:41','2024-04-21 15:07:41'),(69,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 15:07:48','2024-04-21 15:07:48'),(70,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 15:07:51','2024-04-21 15:07:51'),(71,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 15:09:02','2024-04-21 15:09:02'),(72,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:09:04','2024-04-21 15:09:04'),(73,1,'admin/users/1','GET','192.168.56.1','[]','2024-04-21 15:09:06','2024-04-21 15:09:06'),(74,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 15:09:07','2024-04-21 15:09:07'),(75,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 15:09:08','2024-04-21 15:09:08'),(76,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 15:10:08','2024-04-21 15:10:08'),(77,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:10:09','2024-04-21 15:10:09'),(78,1,'admin/users/1','GET','192.168.56.1','[]','2024-04-21 15:10:11','2024-04-21 15:10:11'),(79,1,'admin/users/1','GET','192.168.56.1','[]','2024-04-21 15:10:22','2024-04-21 15:10:22'),(80,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:10:24','2024-04-21 15:10:24'),(81,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 15:10:24','2024-04-21 15:10:24'),(82,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 15:10:25','2024-04-21 15:10:25'),(83,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 15:11:59','2024-04-21 15:11:59'),(84,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 15:12:00','2024-04-21 15:12:00'),(85,1,'admin/recipes/2/edit','GET','192.168.56.1','[]','2024-04-21 15:12:24','2024-04-21 15:12:24'),(86,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 15:12:28','2024-04-21 15:12:28'),(87,1,'admin/recipes/2','GET','192.168.56.1','[]','2024-04-21 15:12:29','2024-04-21 15:12:29'),(88,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:12:34','2024-04-21 15:12:34'),(89,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"name\":null,\"search_terms\":null,\"isVerified\":\"1\"}','2024-04-21 15:12:38','2024-04-21 15:12:38'),(90,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"name\":null,\"search_terms\":null,\"isVerified\":\"0\"}','2024-04-21 15:12:40','2024-04-21 15:12:40'),(91,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"name\":\"Anna Miller\",\"search_terms\":null,\"isVerified\":\"0\"}','2024-04-21 15:12:41','2024-04-21 15:12:41'),(92,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"name\":\"Tom Jenkins\",\"search_terms\":null,\"isVerified\":\"0\"}','2024-04-21 15:12:45','2024-04-21 15:12:45'),(93,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"name\":\"Anna Miller\",\"search_terms\":null,\"isVerified\":\"0\"}','2024-04-21 15:12:48','2024-04-21 15:12:48'),(94,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"name\":\"Tom Jenkins\",\"search_terms\":null,\"isVerified\":\"0\"}','2024-04-21 15:12:53','2024-04-21 15:12:53'),(95,1,'admin/recipes','GET','192.168.56.1','[]','2024-04-21 15:12:57','2024-04-21 15:12:57'),(96,1,'admin/recipes','GET','192.168.56.1','{\"id\":null,\"category_id\":null,\"search_terms\":null,\"creator_id\":\"2\",\"isActive\":null}','2024-04-21 15:13:02','2024-04-21 15:13:02'),(97,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:13:05','2024-04-21 15:13:05'),(98,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"name\":\"Anna Miller\",\"search_terms\":null,\"isVerified\":null}','2024-04-21 15:13:09','2024-04-21 15:13:09'),(99,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"name\":\"Tom Jenkins\",\"search_terms\":null,\"isVerified\":null}','2024-04-21 15:13:13','2024-04-21 15:13:13'),(100,1,'admin/users','GET','192.168.56.1','{\"id\":null,\"name\":\"Tom Jenkins\",\"search_terms\":null,\"isVerified\":null}','2024-04-21 15:13:19','2024-04-21 15:13:19'),(101,1,'admin/users','GET','192.168.56.1','[]','2024-04-21 15:13:20','2024-04-21 15:13:20');
/*!40000 ALTER TABLE `admin_operation_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_permissions`
--

DROP TABLE IF EXISTS `admin_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_permissions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_name_unique` (`name`),
  UNIQUE KEY `admin_permissions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_permissions`
--

LOCK TABLES `admin_permissions` WRITE;
/*!40000 ALTER TABLE `admin_permissions` DISABLE KEYS */;
INSERT INTO `admin_permissions` VALUES (1,'All permission','*','','*',NULL,NULL),(2,'Dashboard','dashboard','GET','/',NULL,NULL),(3,'Login','auth.login','','/auth/login\r\n/auth/logout',NULL,NULL),(4,'User setting','auth.setting','GET,PUT','/auth/setting',NULL,NULL),(5,'Auth management','auth.management','','/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs',NULL,NULL),(6,'Admin helpers','ext.helpers','','/helpers/*','2024-04-20 12:53:49','2024-04-20 12:53:49');
/*!40000 ALTER TABLE `admin_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role_menu`
--

DROP TABLE IF EXISTS `admin_role_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_role_menu` (
  `role_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role_menu`
--

LOCK TABLES `admin_role_menu` WRITE;
/*!40000 ALTER TABLE `admin_role_menu` DISABLE KEYS */;
INSERT INTO `admin_role_menu` VALUES (1,2,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role_permissions`
--

DROP TABLE IF EXISTS `admin_role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_role_permissions` (
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role_permissions`
--

LOCK TABLES `admin_role_permissions` WRITE;
/*!40000 ALTER TABLE `admin_role_permissions` DISABLE KEYS */;
INSERT INTO `admin_role_permissions` VALUES (1,1,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role_users`
--

DROP TABLE IF EXISTS `admin_role_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_role_users` (
  `role_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role_users`
--

LOCK TABLES `admin_role_users` WRITE;
/*!40000 ALTER TABLE `admin_role_users` DISABLE KEYS */;
INSERT INTO `admin_role_users` VALUES (1,1,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_roles`
--

DROP TABLE IF EXISTS `admin_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_name_unique` (`name`),
  UNIQUE KEY `admin_roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_roles`
--

LOCK TABLES `admin_roles` WRITE;
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
INSERT INTO `admin_roles` VALUES (1,'Administrator','administrator','2024-04-20 12:53:30','2024-04-20 12:53:30');
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_user_permissions`
--

DROP TABLE IF EXISTS `admin_user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_user_permissions` (
  `user_id` int NOT NULL,
  `permission_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_user_permissions`
--

LOCK TABLES `admin_user_permissions` WRITE;
/*!40000 ALTER TABLE `admin_user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$12$jtQBLd7kD5nFT1ODbwSGbepCgfM8Y6qxGsWPSACjePXoJDPrfUR7q','Administrator',NULL,NULL,'2024-04-20 12:53:30','2024-04-20 12:53:30');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryImage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Appetizers','https://www.themealdb.com//images//category//starter.png','2024-04-20 12:50:51','2024-04-20 12:50:51'),(2,'Breakfast','https://www.themealdb.com//images//media//meals//xvsurr1511719182.jpg','2024-04-20 12:50:51','2024-04-20 12:50:51'),(3,'Drink','https://www.themealdb.com//images//media//meals//rvtvuw1511190488.jpg','2024-04-20 12:50:51','2024-04-20 12:50:51'),(4,'Dinner','https://www.themealdb.com//images//media//meals//qstyvs1505931190.jpg','2024-04-20 12:50:51','2024-04-20 12:50:51'),(5,'Lunch','https://www.themealdb.com//images//media//meals//syqypv1486981727.jpg','2024-04-20 12:50:51','2024-04-20 12:50:51'),(6,'Dessert','https://www.themealdb.com//images//media//meals//wxywrq1468235067.jpg','2024-04-20 12:50:51','2024-04-20 12:50:51');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_recipe_id_foreign` (`recipe_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  CONSTRAINT `comments_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,2,2,'wooww so yummyy !!','2024-04-20 14:29:08','2024-04-20 14:29:08');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dietary`
--

DROP TABLE IF EXISTS `dietary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dietary` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dietary_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dietary`
--

LOCK TABLES `dietary` WRITE;
/*!40000 ALTER TABLE `dietary` DISABLE KEYS */;
INSERT INTO `dietary` VALUES (1,'Gluten-Free',NULL,NULL),(2,'Vegetarian',NULL,NULL),(3,'Vegan',NULL,NULL),(4,'Paleo',NULL,NULL),(5,'Keto',NULL,NULL),(6,'Low-Carb',NULL,NULL),(7,'Dairy-Free',NULL,NULL),(8,'Nut-Free',NULL,NULL),(9,'Sugar-Free',NULL,NULL),(10,'Low-FODMAP',NULL,NULL),(11,'Whole30',NULL,NULL),(12,'Flexitarian',NULL,NULL),(13,'Pescatarian',NULL,NULL),(14,'Halal',NULL,NULL),(15,'Kosher',NULL,NULL);
/*!40000 ALTER TABLE `dietary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorite`
--

DROP TABLE IF EXISTS `favorite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorite` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `recipe_id` bigint unsigned NOT NULL,
  `isFavorite` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `favorite_user_id_foreign` (`user_id`),
  KEY `favorite_recipe_id_foreign` (`recipe_id`),
  CONSTRAINT `favorite_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favorite_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorite`
--

LOCK TABLES `favorite` WRITE;
/*!40000 ALTER TABLE `favorite` DISABLE KEYS */;
/*!40000 ALTER TABLE `favorite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `follows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` bigint unsigned NOT NULL,
  `followed_id` bigint unsigned NOT NULL,
  `isFollowed` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `follows_follower_id_followed_id_unique` (`follower_id`,`followed_id`),
  KEY `follows_followed_id_foreign` (`followed_id`),
  CONSTRAINT `follows_followed_id_foreign` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `follows_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'images/1713615929.jpg',NULL,'2024-04-20 12:25:29','2024-04-20 12:25:29'),(2,'images/1713617535.jpg',NULL,'2024-04-20 12:52:15','2024-04-20 12:52:15'),(3,'images/1713617706.jpg',NULL,'2024-04-20 12:55:06','2024-04-20 12:55:06'),(4,'images/2UCagOZNoBLhkgvUBY94Wu5V6jI52aLOQTKVko1I.jpg',NULL,'2024-04-20 14:32:59','2024-04-20 14:32:59'),(5,'images/n1tB3cqDeu5cgpygIbPws8sDeKFH0g6gSI1CxX8x.png',NULL,'2024-04-20 14:33:52','2024-04-20 14:33:52'),(6,'images/dsO5YPayV86dx44ZTnOkQWZqoE0NVQ4JteieVLsd.jpg',NULL,'2024-04-20 14:43:54','2024-04-20 14:43:54'),(7,'images/1713632950.jpg',NULL,'2024-04-20 17:09:10','2024-04-20 17:09:10'),(8,'images/1713633046.jpg',NULL,'2024-04-20 17:10:46','2024-04-20 17:10:46'),(9,'images/1713633093.jpg',NULL,'2024-04-20 17:11:33','2024-04-20 17:11:33'),(10,'images/1713633114.jpg',NULL,'2024-04-20 17:11:54','2024-04-20 17:11:54');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` bigint unsigned NOT NULL,
  `ingredientName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `measurementUnit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ingredients_recipe_id_foreign` (`recipe_id`),
  CONSTRAINT `ingredients_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredients`
--

LOCK TABLES `ingredients` WRITE;
/*!40000 ALTER TABLE `ingredients` DISABLE KEYS */;
INSERT INTO `ingredients` VALUES (7,2,'spaghetti','400 grams','2024-04-20 12:52:17','2024-04-20 12:52:17'),(8,2,'bacon','200 grams','2024-04-20 12:52:17','2024-04-20 12:52:17'),(9,2,'eggs','3','2024-04-20 12:52:17','2024-04-20 12:52:17'),(10,2,'Parmesan cheese','100 grams','2024-04-20 12:52:17','2024-04-20 12:52:17'),(11,2,'black pepper','1 teaspoon','2024-04-20 12:52:17','2024-04-20 12:52:17'),(12,2,'salt','to taste','2024-04-20 12:52:17','2024-04-20 12:52:17');
/*!40000 ALTER TABLE `ingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `recipe_id` bigint unsigned NOT NULL,
  `isLiked` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `likes_user_id_foreign` (`user_id`),
  KEY `likes_recipe_id_foreign` (`recipe_id`),
  CONSTRAINT `likes_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (1,2,2,1,'2024-04-20 13:45:53','2024-04-20 13:45:53');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_100000_create_password_reset_tokens_table',1),(2,'2016_01_04_173148_create_admin_tables',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2024_02_06_105139_create_images_table',1),(6,'2024_02_06_105140_create_users_table',1),(7,'2024_02_06_105202_create_categories_table',1),(8,'2024_02_06_105202_create_dietary_table',1),(9,'2024_02_06_105210_create_recipes_table',1),(10,'2024_02_06_105215_create_ingredients_table',1),(11,'2024_02_06_105223_create_steps_table',1),(12,'2024_02_06_105229_create_comments_table',1),(13,'2024_02_15_184913_create_rapports_table',1),(14,'2024_04_08_085141_create_favorite_table',1),(15,'2024_04_09_072308_create_ratings_table',1),(16,'2024_04_09_072447_create_likes_table',1),(17,'2024_04_09_103947_create_notifications_table',1),(18,'2024_04_09_181430_create_follows_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `source_user_id` bigint unsigned NOT NULL,
  `destination_user_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_source_user_id_foreign` (`source_user_id`),
  KEY `notifications_destination_user_id_foreign` (`destination_user_id`),
  CONSTRAINT `notifications_destination_user_id_foreign` FOREIGN KEY (`destination_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notifications_source_user_id_foreign` FOREIGN KEY (`source_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,2,1,'User Tom Jenkins liked your recipe \"Spaghetti Carbonara\".',1,'2024-04-20 13:45:54','2024-04-20 17:08:08'),(2,2,1,'User Tom Jenkins commented on your recipe \"Spaghetti Carbonara\": wooww so yummyy !!',1,'2024-04-20 14:29:08','2024-04-20 17:08:24');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (3,'App\\Models\\User',2,'api_token','646fc994979b0d4fbc28339ecc6ed0ff5f2aa5ed1d6229e16107ee09d84e25f4','[\"*\"]','2024-04-20 14:50:17',NULL,'2024-04-20 12:55:02','2024-04-20 14:50:17'),(7,'App\\Models\\User',1,'api_token','5f326af46b9472d68a0a45f94e922c1367fa14d4499c8d77aef45a40267bb2c0','[\"*\"]','2024-04-20 13:12:51',NULL,'2024-04-20 13:12:48','2024-04-20 13:12:51'),(8,'App\\Models\\User',1,'api_token','f3b9b258d23a1a8b41875eff70dfba0918790c9453c3b3a8337bd347d2e9ab27','[\"*\"]','2024-04-20 13:13:38',NULL,'2024-04-20 13:13:36','2024-04-20 13:13:38'),(9,'App\\Models\\User',1,'api_token','9bf3a18f885bd385233cfd534991ecfab1275a0cd09920141b325ad86babd720','[\"*\"]','2024-04-20 13:24:52',NULL,'2024-04-20 13:21:26','2024-04-20 13:24:52'),(10,'App\\Models\\User',1,'api_token','39fc9a6b3cd0d79338272d8fbe1deea64732ea554fef9f00ae1cbb0b217caa2b','[\"*\"]',NULL,NULL,'2024-04-20 13:26:26','2024-04-20 13:26:26'),(11,'App\\Models\\User',1,'api_token','b7abab9d238c3d343d2f3ac375cfd03164b08810637c90d65b6e4c046da1aaaf','[\"*\"]',NULL,NULL,'2024-04-20 13:28:11','2024-04-20 13:28:11'),(12,'App\\Models\\User',1,'api_token','7412e7173a38e3e22e41a60f7c891ad6133020f630d423333a2eb81a35ad1c0a','[\"*\"]',NULL,NULL,'2024-04-20 13:28:14','2024-04-20 13:28:14'),(13,'App\\Models\\User',1,'api_token','cc3faf4cc549166bddc4c2f35216a4cc022989ce8941fd219476a79ae3143132','[\"*\"]',NULL,NULL,'2024-04-20 13:28:35','2024-04-20 13:28:35'),(14,'App\\Models\\User',1,'api_token','5974a8025a0e24e8a57dcf265e7970f0762e62ff44c6ef761c9ff9dfc67d314d','[\"*\"]',NULL,NULL,'2024-04-20 13:28:37','2024-04-20 13:28:37'),(15,'App\\Models\\User',1,'api_token','954c88e5bf023e0004a6b9042d16423609034f6955d893929402d103b8035b44','[\"*\"]',NULL,NULL,'2024-04-20 13:28:40','2024-04-20 13:28:40'),(16,'App\\Models\\User',1,'api_token','8929d79a2f07089a76029a63f6fc0ce986c35cca73a146feea9a1c932af9f6cf','[\"*\"]',NULL,NULL,'2024-04-20 13:30:18','2024-04-20 13:30:18'),(17,'App\\Models\\User',1,'api_token','700deeec6fcb0120a09100387ae9bebc4a72a237fffb845997b62478b5c29ccb','[\"*\"]',NULL,NULL,'2024-04-20 13:30:48','2024-04-20 13:30:48'),(18,'App\\Models\\User',1,'api_token','d73211c34fd2962390819fa3b3f84b836f092bc60b153815e80643bb7b480e58','[\"*\"]',NULL,NULL,'2024-04-20 13:31:05','2024-04-20 13:31:05'),(19,'App\\Models\\User',1,'api_token','6284d9d89c63ee54a01569d68fa490504c86cb31bc09ba7cd84ee08649ef8fed','[\"*\"]',NULL,NULL,'2024-04-20 13:31:17','2024-04-20 13:31:17'),(20,'App\\Models\\User',1,'api_token','489b89dba96e91ae1a21cd6b44fd6c2c58559439b19fffb7f8dd05cc6f2eca8c','[\"*\"]',NULL,NULL,'2024-04-20 13:31:19','2024-04-20 13:31:19'),(21,'App\\Models\\User',1,'api_token','d9d9660901f308adf7276e72b963e84562ee7b79626b1eb8dabd2432a713e003','[\"*\"]',NULL,NULL,'2024-04-20 13:31:26','2024-04-20 13:31:26'),(22,'App\\Models\\User',1,'api_token','f666798ca9e5a2d14f7603ce3dd917c1edaebfa16b4663e1fdce54bd00e0ec76','[\"*\"]',NULL,NULL,'2024-04-20 13:32:47','2024-04-20 13:32:47'),(23,'App\\Models\\User',1,'api_token','45e5ef0107b9dc8a8f4ca2a3f035a873547cc812d88e6ade0fef2c37815ac828','[\"*\"]',NULL,NULL,'2024-04-20 13:33:04','2024-04-20 13:33:04'),(24,'App\\Models\\User',1,'api_token','d99674d3582502f50b40becde6e0f9d35d0c891755ca6018914c626d2a6a7375','[\"*\"]',NULL,NULL,'2024-04-20 13:33:37','2024-04-20 13:33:37'),(25,'App\\Models\\User',1,'api_token','18cc3feaca2306727d92bc89b4db54ac811320d9617c8b12cf8e34c821b7e582','[\"*\"]','2024-04-20 13:40:37',NULL,'2024-04-20 13:34:32','2024-04-20 13:40:37'),(26,'App\\Models\\User',1,'api_token','e7ba6034d64a7514f2c84251368864d5d9f79c2eb21852a71e75d66fd6c48147','[\"*\"]','2024-04-20 13:56:51',NULL,'2024-04-20 13:41:27','2024-04-20 13:56:51'),(27,'App\\Models\\User',2,'api_token','d46d70a28a8dc79eaa468426db62e0be7c3ec0c3e71a4d39dff6f3fa735cea8d','[\"*\"]','2024-04-20 14:29:08',NULL,'2024-04-20 13:45:23','2024-04-20 14:29:08'),(28,'App\\Models\\User',1,'api_token','02c42b6827af1e612bcdb26c076b6a2eea91e1e506ec39100880aba5f8a83914','[\"*\"]','2024-04-20 13:59:44',NULL,'2024-04-20 13:57:39','2024-04-20 13:59:44'),(29,'App\\Models\\User',1,'api_token','71e1833118b0df0b3b1e5da3812dfbafe387a2c4ded4f5d6a1fbfacd0406c002','[\"*\"]','2024-04-20 14:01:48',NULL,'2024-04-20 14:00:25','2024-04-20 14:01:48'),(30,'App\\Models\\User',1,'api_token','c5903cd5c3bd70d3c4b5ee6babf8c46070766b5e300f98ece38cb63741991792','[\"*\"]','2024-04-20 14:19:53',NULL,'2024-04-20 14:05:36','2024-04-20 14:19:53'),(31,'App\\Models\\User',1,'api_token','ce6dfe0a78e22bb9701e163dd37449a35d53cb22f655282c0b15b8f316ebcd26','[\"*\"]','2024-04-20 14:21:29',NULL,'2024-04-20 14:20:17','2024-04-20 14:21:29'),(32,'App\\Models\\User',1,'api_token','00351b9eb99a9dd72014a98627511ae86f32f05011dbfaf2b7ad7390f861ebfe','[\"*\"]','2024-04-20 14:22:53',NULL,'2024-04-20 14:22:12','2024-04-20 14:22:53'),(33,'App\\Models\\User',1,'api_token','b8918516ee62f89a2ff2fe7f236e76bcb59af11b85c998dd6737686865ff2f43','[\"*\"]','2024-04-20 14:26:14',NULL,'2024-04-20 14:23:52','2024-04-20 14:26:14'),(34,'App\\Models\\User',1,'api_token','46326dc63a4fcdafef391a0591fe45e2badea55fc41adc1bbd64d51ab248755d','[\"*\"]','2024-04-20 14:32:04',NULL,'2024-04-20 14:27:06','2024-04-20 14:32:04'),(35,'App\\Models\\User',3,'api_token','04b0d95e9b8ff6f5cd0ecebfc5f34bfacd6ff9c4446f8272d97b14c42ee72fef','[\"*\"]','2024-04-20 14:31:37',NULL,'2024-04-20 14:30:52','2024-04-20 14:31:37'),(36,'App\\Models\\User',2,'api_token','1e6811d4c703c3b2e74d5a99d6e4e027a84cb33ebd0c241aa157b264dd1b2096','[\"*\"]',NULL,NULL,'2024-04-20 14:31:57','2024-04-20 14:31:57'),(37,'App\\Models\\User',4,'api_token','ea7dd88ae01409487e4a1300d3f2286dbc9fbdc6e49425a6ea408bf3ae21a321','[\"*\"]','2024-04-20 14:40:51',NULL,'2024-04-20 14:32:42','2024-04-20 14:40:51'),(38,'App\\Models\\User',1,'api_token','4ac66403a2f22be25d43e05f7e105376b7ededcc17802a9300097a7509dbe709','[\"*\"]','2024-04-20 14:42:17',NULL,'2024-04-20 14:42:09','2024-04-20 14:42:17'),(39,'App\\Models\\User',5,'api_token','cc96f31e31537995c5ae01c7d8a24cc4bb042e9cb760205544cc26d6704a3be1','[\"*\"]','2024-04-20 14:45:51',NULL,'2024-04-20 14:43:40','2024-04-20 14:45:51'),(40,'App\\Models\\User',1,'api_token','f25f570ecc3829584b01d084e961722e04a1eba563e89ac8da2db2a55a651c38','[\"*\"]','2024-04-20 14:45:31',NULL,'2024-04-20 14:44:56','2024-04-20 14:45:31'),(41,'App\\Models\\User',1,'api_token','7c04a84500b8d2b760c427fc295605c84f22697f3db3e06c6ea4f7a6aa2c5578','[\"*\"]','2024-04-20 15:04:09',NULL,'2024-04-20 14:54:33','2024-04-20 15:04:09'),(42,'App\\Models\\User',1,'api_token','56365695cde0cc2601a15741a0e4cdf7bfd964d4973fca8da065650a031a43f9','[\"*\"]',NULL,NULL,'2024-04-20 15:07:00','2024-04-20 15:07:00'),(43,'App\\Models\\User',1,'api_token','b37d8b1b81abf832bf2a43092b341d6d64d64ab8df59cb1580059fe9048ce729','[\"*\"]',NULL,NULL,'2024-04-20 15:08:36','2024-04-20 15:08:36'),(44,'App\\Models\\User',1,'api_token','4c40ffa307fdb7ec28dd98fcca4df8307974dd5883ca75ae115b5863bb162017','[\"*\"]','2024-04-20 15:26:21',NULL,'2024-04-20 15:10:11','2024-04-20 15:26:21'),(45,'App\\Models\\User',1,'api_token','842582b67dfe30674655b51103f166c24c2cbcfa40e37f68c3f5d3bbd9d026f2','[\"*\"]',NULL,NULL,'2024-04-20 15:26:35','2024-04-20 15:26:35'),(46,'App\\Models\\User',1,'api_token','0b772d420265f9e5d2179fd73ee751b24a716c9295481339a5116b392bfb2abc','[\"*\"]',NULL,NULL,'2024-04-20 15:26:55','2024-04-20 15:26:55'),(47,'App\\Models\\User',1,'api_token','6953dc5f3dfff33c09fd158ff2fece7639e06352216285b96d02e1406ac91301','[\"*\"]','2024-04-20 15:40:12',NULL,'2024-04-20 15:27:34','2024-04-20 15:40:12'),(48,'App\\Models\\User',1,'api_token','ea54b0cbf895635f3e009a2e47d6a6877f6b1e5155451f2769e3f1a4d0c64930','[\"*\"]','2024-04-20 15:40:33',NULL,'2024-04-20 15:40:23','2024-04-20 15:40:33'),(49,'App\\Models\\User',1,'api_token','db183a51c0c10ef0c29ec531820210a60940d0dc34e83370f43e8d8cf559f3fa','[\"*\"]','2024-04-20 15:42:33',NULL,'2024-04-20 15:40:43','2024-04-20 15:42:33'),(50,'App\\Models\\User',1,'api_token','8126d0cbef1e753b4cfbb6391b2805eac35bf3bb105dfb570372886a841d622f','[\"*\"]','2024-04-20 15:44:26',NULL,'2024-04-20 15:42:44','2024-04-20 15:44:26'),(51,'App\\Models\\User',1,'api_token','27d2fb1de9b3319ba6cc03b32a0d6367f36879f4ae287b1c7ab8c5e385b59bf1','[\"*\"]','2024-04-20 15:45:38',NULL,'2024-04-20 15:45:18','2024-04-20 15:45:38'),(52,'App\\Models\\User',1,'api_token','595823695600a1e5ed441984078536bd1953807e0086d0be548ac81b4debd69c','[\"*\"]','2024-04-20 15:45:54',NULL,'2024-04-20 15:45:47','2024-04-20 15:45:54'),(53,'App\\Models\\User',1,'api_token','623d7c4106b2f46b10543c3c248876cb205783062488fbaba5c87ae979f1427e','[\"*\"]','2024-04-20 15:48:03',NULL,'2024-04-20 15:46:06','2024-04-20 15:48:03'),(54,'App\\Models\\User',1,'api_token','9519d7751ec619c70dafc052bd0008ab7c56fff7f561e20b0805d4dedbcc7d01','[\"*\"]','2024-04-20 15:49:42',NULL,'2024-04-20 15:48:13','2024-04-20 15:49:42'),(55,'App\\Models\\User',1,'api_token','e90c14706859136b1ad7994ca7f0ba5437c75cb6218c3c11216edff065c13513','[\"*\"]','2024-04-20 15:50:27',NULL,'2024-04-20 15:50:12','2024-04-20 15:50:27'),(56,'App\\Models\\User',1,'api_token','1f6ed93197bfe2647a3cd2b4f86528181361c1d778f3e1434a56da5185bccb0c','[\"*\"]','2024-04-20 15:55:49',NULL,'2024-04-20 15:50:53','2024-04-20 15:55:49'),(57,'App\\Models\\User',1,'api_token','d398ad69da32cb73969524f916fcc4bacc36f53993105bf6b9dcc1d0a909a1f2','[\"*\"]','2024-04-20 15:56:09',NULL,'2024-04-20 15:56:07','2024-04-20 15:56:09'),(58,'App\\Models\\User',1,'api_token','f7da546bf847dc2c1eebe82cfbc388c8ae282e288412880f64fc0467f8dcaab7','[\"*\"]','2024-04-20 15:56:32',NULL,'2024-04-20 15:56:17','2024-04-20 15:56:32'),(59,'App\\Models\\User',2,'api_token','f028e04442acbd00f8f404cd8e40e7efdbe9fbe3fc413765d35af74197b6f794','[\"*\"]','2024-04-20 15:58:04',NULL,'2024-04-20 15:57:57','2024-04-20 15:58:04'),(60,'App\\Models\\User',1,'api_token','0f6bbd28b5702129861c7b96679dfc51ec30c249fbcfbc928c5a545ee93dd2a8','[\"*\"]','2024-04-20 17:07:31',NULL,'2024-04-20 17:07:16','2024-04-20 17:07:31'),(61,'App\\Models\\User',1,'api_token','9367e775b6fb926eab4c72cb96029d8ba28b041279b19d92c90589062f4e1ae0','[\"*\"]','2024-04-20 17:08:36',NULL,'2024-04-20 17:07:44','2024-04-20 17:08:36'),(62,'App\\Models\\User',6,'api_token','9fa9c357166984ec1bd679582ea3454921deaa5190083bdb654805e41091799d','[\"*\"]','2024-04-20 17:10:01',NULL,'2024-04-20 17:08:52','2024-04-20 17:10:01'),(63,'App\\Models\\User',7,'api_token','af3cc63364987597bf8d7c3ac1e5444bf22776f505b8ae00f752a336c1b5ac86','[\"*\"]','2024-04-20 17:11:12',NULL,'2024-04-20 17:10:18','2024-04-20 17:11:12'),(64,'App\\Models\\User',8,'api_token','d13049440771817de7b0f8b8bbf98e70b899122699b02190c880abbcf175a1db','[\"*\"]','2024-04-20 17:14:41',NULL,'2024-04-20 17:11:26','2024-04-20 17:14:41'),(65,'App\\Models\\User',1,'api_token','fb0ec10535b4c51e3f66ee1cadb6f9564291e8f73357eca861ac36f47e0f3b0a','[\"*\"]','2024-04-20 17:14:18',NULL,'2024-04-20 17:13:15','2024-04-20 17:14:18'),(66,'App\\Models\\User',8,'api_token','86076c16ff6e227be73625869bcf5f2e3a8e791e1d2663eaf7a718d619c54cac','[\"*\"]','2024-04-20 17:15:01',NULL,'2024-04-20 17:14:54','2024-04-20 17:15:01');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rapports`
--

DROP TABLE IF EXISTS `rapports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rapports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `creator_id` bigint unsigned DEFAULT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rapports_creator_id_foreign` (`creator_id`),
  KEY `rapports_category_id_foreign` (`category_id`),
  CONSTRAINT `rapports_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rapports_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rapports`
--

LOCK TABLES `rapports` WRITE;
/*!40000 ALTER TABLE `rapports` DISABLE KEYS */;
/*!40000 ALTER TABLE `rapports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `recipe_id` bigint unsigned NOT NULL,
  `rating` int unsigned NOT NULL,
  `isRated` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ratings_user_id_foreign` (`user_id`),
  KEY `ratings_recipe_id_foreign` (`recipe_id`),
  CONSTRAINT `ratings_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratings`
--

LOCK TABLES `ratings` WRITE;
/*!40000 ALTER TABLE `ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipes`
--

DROP TABLE IF EXISTS `recipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recipes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `creator_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `dietary_id` bigint unsigned NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_id` bigint unsigned DEFAULT NULL,
  `preparationTime` int NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `totalLikes` int unsigned NOT NULL DEFAULT '0',
  `avrgRating` decimal(3,1) NOT NULL DEFAULT '0.0',
  `isActive` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recipes_creator_id_foreign` (`creator_id`),
  KEY `recipes_category_id_foreign` (`category_id`),
  KEY `recipes_dietary_id_foreign` (`dietary_id`),
  KEY `recipes_image_id_foreign` (`image_id`),
  CONSTRAINT `recipes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recipes_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recipes_dietary_id_foreign` FOREIGN KEY (`dietary_id`) REFERENCES `dietary` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recipes_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipes`
--

LOCK TABLES `recipes` WRITE;
/*!40000 ALTER TABLE `recipes` DISABLE KEYS */;
INSERT INTO `recipes` VALUES (2,1,'Spaghetti Carbonara',2,5,'Delicious and creamy spaghetti carbonara with crispy bacon.',2,30,'Serve immediately for best taste.',1,0.0,1,'2024-04-20 12:52:00','2024-04-20 13:45:54');
/*!40000 ALTER TABLE `recipes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `steps`
--

DROP TABLE IF EXISTS `steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `steps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` bigint unsigned NOT NULL,
  `stepDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `steps_recipe_id_foreign` (`recipe_id`),
  CONSTRAINT `steps_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `steps`
--

LOCK TABLES `steps` WRITE;
/*!40000 ALTER TABLE `steps` DISABLE KEYS */;
INSERT INTO `steps` VALUES (7,2,'Boil the spaghetti in salted water until al dente.','2024-04-20 12:52:17','2024-04-20 12:52:17'),(8,2,'In a separate pan, fry the bacon until crispy.','2024-04-20 12:52:17','2024-04-20 12:52:17'),(9,2,'In a bowl, whisk together the eggs, grated Parmesan cheese, and black pepper.','2024-04-20 12:52:17','2024-04-20 12:52:17'),(10,2,'Drain the spaghetti and add it to the pan with the bacon.','2024-04-20 12:52:17','2024-04-20 12:52:17'),(11,2,'Remove from heat and quickly stir in the egg mixture to coat the spaghetti.','2024-04-20 12:52:17','2024-04-20 12:52:17'),(12,2,'Season with salt to taste and serve immediately.','2024-04-20 12:52:17','2024-04-20 12:52:17');
/*!40000 ALTER TABLE `steps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_id` bigint unsigned DEFAULT NULL,
  `totalFollowers` int unsigned NOT NULL DEFAULT '0',
  `isVerified` tinyint(1) NOT NULL DEFAULT '0',
  `isNotificationActive` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_image_id_foreign` (`image_id`),
  CONSTRAINT `users_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Anna Miller','anna.miller@example.com','2024-04-21 14:51:10',NULL,'annaskitchen','Food blogger and recipe creator. Passionate about cooking and baking delicious dishes for family and friends.',1,0,1,1,NULL,'2024-04-20 12:25:02','2024-04-21 14:51:15'),(2,'Tom Jenkins','tom.jenkins@example.com',NULL,'$2y$12$wmaKeOArt4yTCouQAbAiDe5GLPc0meW1aKJNZAZEfSRdCe6VBfOMa','tomchef101','Professional chef with a love for experimenting with flavors and creating unique recipes.',3,0,0,1,NULL,'2024-04-20 12:55:02','2024-04-20 15:58:01');
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

-- Dump completed on 2024-04-21 15:17:39
