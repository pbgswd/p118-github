/*!999999\- enable the sandbox mode */ 
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `access_level_constants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_level_constants` (
  `access_level` varchar(255) NOT NULL,
  `display` varchar(255) NOT NULL,
  UNIQUE KEY `access_level_constants_access_level_unique` (`access_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `activity` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `agreement_organization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agreement_organization` (
  `agreement_id` bigint(20) unsigned NOT NULL,
  `organization_id` bigint(20) unsigned NOT NULL,
  KEY `agreement_organization_agreement_id_index` (`agreement_id`),
  KEY `agreement_organization_organization_id_index` (`organization_id`),
  CONSTRAINT `agreement_organization_agreement_id_foreign` FOREIGN KEY (`agreement_id`) REFERENCES `agreements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `agreement_organization_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `agreement_venue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agreement_venue` (
  `agreement_id` bigint(20) unsigned NOT NULL,
  `venue_id` bigint(20) unsigned NOT NULL,
  KEY `agreement_venue_agreement_id_index` (`agreement_id`),
  KEY `agreement_venue_venue_id_index` (`venue_id`),
  CONSTRAINT `agreement_venue_agreement_id_foreign` FOREIGN KEY (`agreement_id`) REFERENCES `agreements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `agreement_venue_venue_id_foreign` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `agreements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agreements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `access_level` varchar(255) NOT NULL DEFAULT 'members',
  `live` tinyint(1) NOT NULL DEFAULT 1,
  `from` date NOT NULL,
  `until` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agreements_user_id_foreign` (`user_id`),
  KEY `agreements_access_level_foreign` (`access_level`),
  CONSTRAINT `agreements_access_level_foreign` FOREIGN KEY (`access_level`) REFERENCES `access_level_constants` (`access_level`),
  CONSTRAINT `agreements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_agreement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_agreement` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `agreement_id` bigint(20) unsigned NOT NULL,
  KEY `attachment_agreement_attachment_id_index` (`attachment_id`),
  KEY `attachment_agreement_agreement_id_index` (`agreement_id`),
  CONSTRAINT `attachment_agreement_agreement_id_foreign` FOREIGN KEY (`agreement_id`) REFERENCES `agreements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachment_agreement_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_bylaw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_bylaw` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `bylaw_id` bigint(20) unsigned NOT NULL,
  KEY `attachment_bylaw_attachment_id_index` (`attachment_id`),
  KEY `attachment_bylaw_bylaw_id_index` (`bylaw_id`),
  CONSTRAINT `attachment_bylaw_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachment_bylaw_bylaw_id_foreign` FOREIGN KEY (`bylaw_id`) REFERENCES `bylaws` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_committee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_committee` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `committee_id` bigint(20) unsigned NOT NULL,
  KEY `attachment_committee_attachment_id_index` (`attachment_id`),
  KEY `attachment_committee_committee_id_index` (`committee_id`),
  CONSTRAINT `attachment_committee_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachment_committee_committee_id_foreign` FOREIGN KEY (`committee_id`) REFERENCES `committees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_committee_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_committee_post` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `committee_post_id` bigint(20) unsigned NOT NULL,
  KEY `attachment_committee_post_attachment_id_index` (`attachment_id`),
  KEY `attachment_committee_post_committee_post_id_index` (`committee_post_id`),
  CONSTRAINT `attachment_committee_post_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachment_committee_post_committee_post_id_foreign` FOREIGN KEY (`committee_post_id`) REFERENCES `committee_posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_employment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_employment` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `employment_id` bigint(20) unsigned NOT NULL,
  KEY `attachment_employment_attachment_id_index` (`attachment_id`),
  KEY `attachment_employment_employment_id_index` (`employment_id`),
  CONSTRAINT `attachment_employment_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachment_employment_employment_id_foreign` FOREIGN KEY (`employment_id`) REFERENCES `employment` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_meeting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_meeting` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `meeting_id` bigint(20) unsigned NOT NULL,
  KEY `attachments_meeting_attachment_id_index` (`attachment_id`),
  KEY `attachments_meeting_meeting_id_index` (`meeting_id`),
  CONSTRAINT `attachments_meeting_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachments_meeting_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_message` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `message_id` bigint(20) unsigned NOT NULL,
  KEY `attachment_message_attachment_id_index` (`attachment_id`),
  KEY `attachment_message_message_id_index` (`message_id`),
  CONSTRAINT `attachment_message_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachment_message_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_organization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_organization` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `organization_id` bigint(20) unsigned NOT NULL,
  KEY `attachment_organization_attachment_id_index` (`attachment_id`),
  KEY `attachment_organization_organization_id_index` (`organization_id`),
  CONSTRAINT `attachment_organization_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachment_organization_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_page` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `page_id` bigint(20) unsigned NOT NULL,
  KEY `attachment_page_attachment_id_index` (`attachment_id`),
  KEY `attachment_page_page_id_index` (`page_id`),
  CONSTRAINT `attachment_page_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachment_page_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_policies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_policies` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `policy_id` bigint(20) unsigned NOT NULL,
  KEY `attachment_policies_attachment_id_index` (`attachment_id`),
  KEY `attachment_policies_policy_id_index` (`policy_id`),
  CONSTRAINT `attachment_policies_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachment_policies_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `policies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_post` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL,
  KEY `attachment_post_attachment_id_index` (`attachment_id`),
  KEY `attachment_post_post_id_index` (`post_id`),
  CONSTRAINT `attachment_post_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachment_post_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_topic` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `topic_id` bigint(20) unsigned NOT NULL,
  KEY `attachment_topic_attachment_id_index` (`attachment_id`),
  KEY `attachment_topic_topic_id_index` (`topic_id`),
  CONSTRAINT `attachment_topic_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachment_topic_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachment_venue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment_venue` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `venue_id` bigint(20) unsigned NOT NULL,
  KEY `attachment_venue_attachment_id_index` (`attachment_id`),
  KEY `attachment_venue_venue_id_index` (`venue_id`),
  CONSTRAINT `attachment_venue_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attachment_venue_venue_id_foreign` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `description` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `access_level` varchar(255) NOT NULL DEFAULT 'members',
  `subfolder` varchar(255) NOT NULL DEFAULT 'public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attachments_user_id_foreign` (`user_id`),
  KEY `attachments_access_level_foreign` (`access_level`),
  CONSTRAINT `attachments_access_level_foreign` FOREIGN KEY (`access_level`) REFERENCES `access_level_constants` (`access_level`),
  CONSTRAINT `attachments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bylaws`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bylaws` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `access_level` varchar(255) NOT NULL DEFAULT 'members',
  `live` tinyint(1) NOT NULL DEFAULT 1,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bylaws_user_id_foreign` (`user_id`),
  KEY `bylaws_access_level_foreign` (`access_level`),
  CONSTRAINT `bylaws_access_level_foreign` FOREIGN KEY (`access_level`) REFERENCES `access_level_constants` (`access_level`),
  CONSTRAINT `bylaws_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `carousels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carousels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `caption` varchar(255) NOT NULL,
  `caption2` varchar(255) DEFAULT NULL,
  `align` varchar(255) DEFAULT NULL,
  `text_color` varchar(255) DEFAULT NULL,
  `text_outline_color` varchar(255) DEFAULT NULL,
  `live` tinyint(1) NOT NULL DEFAULT 1,
  `order` varchar(255) DEFAULT NULL,
  `image_2000` varchar(255) DEFAULT NULL,
  `file_2000` varchar(255) DEFAULT NULL,
  `image_1400` varchar(255) DEFAULT NULL,
  `file_1400` varchar(255) DEFAULT NULL,
  `image_800` varchar(255) DEFAULT NULL,
  `file_800` varchar(255) DEFAULT NULL,
  `image_600` varchar(255) DEFAULT NULL,
  `file_600` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carousels_user_id_foreign` (`user_id`),
  CONSTRAINT `carousels_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `committee_post_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `committee_post_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `committee_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `content` text NOT NULL,
  `live` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `committee_posts_comments_committee_id_foreign` (`committee_id`),
  KEY `committee_posts_comments_user_id_foreign` (`user_id`),
  KEY `committee_posts_comments_post_id_foreign` (`post_id`),
  CONSTRAINT `committee_posts_comments_committee_id_foreign` FOREIGN KEY (`committee_id`) REFERENCES `committees` (`id`),
  CONSTRAINT `committee_posts_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `committee_posts` (`id`),
  CONSTRAINT `committee_posts_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `committee_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `committee_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `committee_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `live` tinyint(1) NOT NULL DEFAULT 1,
  `sticky` tinyint(1) NOT NULL DEFAULT 0,
  `allow_comments` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `committee_posts_title_unique` (`title`),
  UNIQUE KEY `committee_posts_slug_unique` (`slug`),
  KEY `committee_posts_committee_id_foreign` (`committee_id`),
  KEY `committee_posts_user_id_foreign` (`user_id`),
  CONSTRAINT `committee_posts_committee_id_foreign` FOREIGN KEY (`committee_id`) REFERENCES `committees` (`id`),
  CONSTRAINT `committee_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `committee_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `committee_user` (
  `committee_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  KEY `users_committees_pivot_committee_id_foreign` (`committee_id`),
  KEY `users_committees_pivot_user_id_foreign` (`user_id`),
  CONSTRAINT `users_committees_pivot_committee_id_foreign` FOREIGN KEY (`committee_id`) REFERENCES `committees` (`id`),
  CONSTRAINT `users_committees_pivot_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `committees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `committees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `live` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `committees_name_unique` (`name`),
  UNIQUE KEY `committees_slug_unique` (`slug`),
  KEY `committees_user_id_foreign` (`user_id`),
  CONSTRAINT `committees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `email_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_queue` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sender` varchar(255) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `attachments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `employment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `live` tinyint(1) NOT NULL DEFAULT 1,
  `deadline` datetime DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employment_user_id_foreign` (`user_id`),
  CONSTRAINT `employment_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `executive_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `executive_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `executive_id` bigint(20) unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `current` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `executive_user_user_id_foreign` (`user_id`),
  KEY `executive_user_executive_id_foreign` (`executive_id`),
  CONSTRAINT `executive_user_executive_id_foreign` FOREIGN KEY (`executive_id`) REFERENCES `executives` (`id`),
  CONSTRAINT `executive_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `executives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `executives` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) DEFAULT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faqs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `faq_topic` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `live` tinyint(1) NOT NULL DEFAULT 1,
  `access_level` varchar(255) NOT NULL DEFAULT 'members',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faqs_faq_topic_unique` (`faq_topic`),
  UNIQUE KEY `faqs_slug_unique` (`slug`),
  KEY `faqs_user_id_foreign` (`user_id`),
  CONSTRAINT `faqs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `faqs_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faqs_data` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `faq_id` bigint(20) unsigned NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(11) NOT NULL,
  `access_level` varchar(255) NOT NULL DEFAULT 'members',
  `live` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faqs_data_faq_id_foreign` (`faq_id`),
  CONSTRAINT `faqs_data_faq_id_foreign` FOREIGN KEY (`faq_id`) REFERENCES `faqs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `features` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `access_level` varchar(255) DEFAULT 'public',
  `live` tinyint(4) NOT NULL DEFAULT 0,
  `front_page` tinyint(1) NOT NULL DEFAULT 0,
  `landing_page` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `import_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `import_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `membership_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `invite_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invite_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `membership_type` varchar(255) NOT NULL DEFAULT 'Member',
  `role` varchar(255) NOT NULL DEFAULT 'member',
  `user_id` bigint(20) unsigned NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invite_users_user_id_foreign` (`user_id`),
  CONSTRAINT `invite_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meetings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `live` tinyint(1) NOT NULL DEFAULT 1,
  `date` datetime DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meetings_user_id_foreign` (`user_id`),
  CONSTRAINT `meetings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `memberships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memberships` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `membership_type` varchar(255) NOT NULL DEFAULT 'Member',
  `membership_date` date DEFAULT NULL,
  `membership_expires` date DEFAULT NULL,
  `seniority_number` int(10) unsigned DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `memberships_user_id_foreign` (`user_id`),
  CONSTRAINT `memberships_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `memoriams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memoriams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `live` tinyint(1) NOT NULL DEFAULT 1,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `memoriams_user_id_foreign` (`user_id`),
  CONSTRAINT `memoriams_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `message_frequency_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_frequency_preferences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `preference` varchar(255) NOT NULL DEFAULT 'now',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `message_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_metadata` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `source_id` int(11) DEFAULT NULL,
  `source_slug` varchar(255) DEFAULT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `source_type_name` varchar(255) DEFAULT NULL,
  `source_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `message_selections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_selections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `message_sending`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_sending` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `send_priority` varchar(255) NOT NULL DEFAULT 'normal',
  `send_status_now` varchar(255) DEFAULT 'no',
  `send_status_daily` varchar(255) DEFAULT 'no',
  `send_status_weekly` varchar(255) DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `messages_subject_unique` (`subject`),
  UNIQUE KEY `messages_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organizations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `access_level` varchar(255) DEFAULT 'members',
  `live` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organizations_name_unique` (`name`),
  UNIQUE KEY `organizations_slug_unique` (`slug`),
  KEY `organizations_user_id_foreign` (`user_id`),
  KEY `organizations_access_level_foreign` (`access_level`),
  CONSTRAINT `organizations_access_level_foreign` FOREIGN KEY (`access_level`) REFERENCES `access_level_constants` (`access_level`),
  CONSTRAINT `organizations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `page_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_topic` (
  `topic_id` bigint(20) unsigned NOT NULL,
  `page_id` bigint(20) unsigned NOT NULL,
  KEY `page_topic_topic_id_foreign` (`topic_id`),
  KEY `page_topic_page_id_foreign` (`page_id`),
  CONSTRAINT `page_topic_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`),
  CONSTRAINT `page_topic_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `access_level` varchar(255) DEFAULT NULL,
  `live` tinyint(1) NOT NULL,
  `front_page` tinyint(1) NOT NULL,
  `landing_page` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_title_unique` (`title`),
  UNIQUE KEY `pages_slug_unique` (`slug`),
  KEY `pages_user_id_foreign` (`user_id`),
  KEY `pages_access_level_foreign` (`access_level`),
  CONSTRAINT `pages_access_level_foreign` FOREIGN KEY (`access_level`) REFERENCES `access_level_constants` (`access_level`),
  CONSTRAINT `pages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `phone_numbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phone_numbers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `label` varchar(20) DEFAULT NULL,
  `primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `phone_numbers_user_id_foreign` (`user_id`),
  CONSTRAINT `phone_numbers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `policies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `policies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `live` tinyint(1) NOT NULL DEFAULT 1,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `policies_user_id_foreign` (`user_id`),
  CONSTRAINT `policies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `post_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_topic` (
  `topic_id` bigint(20) unsigned NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL,
  KEY `post_topic_topic_id_foreign` (`topic_id`),
  KEY `post_topic_post_id_foreign` (`post_id`),
  CONSTRAINT `post_topic_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `post_topic_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `access_level` varchar(255) DEFAULT NULL,
  `live` tinyint(1) NOT NULL,
  `front_page` tinyint(1) NOT NULL,
  `landing_page` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_title_unique` (`title`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_user_id_foreign` (`user_id`),
  KEY `posts_access_level_foreign` (`access_level`),
  CONSTRAINT `posts_access_level_foreign` FOREIGN KEY (`access_level`) REFERENCES `access_level_constants` (`access_level`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `proofreader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proofreader` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_link` varchar(255) NOT NULL,
  `pub_link` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content_type` varchar(255) NOT NULL,
  `content_title` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `proofread_at` datetime DEFAULT NULL,
  `content_updated_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `proofreader_admin_link_unique` (`admin_link`),
  UNIQUE KEY `proofreader_pub_link_unique` (`pub_link`),
  UNIQUE KEY `proofreader_title_unique` (`title`),
  KEY `proofreader_user_id_foreign` (`user_id`),
  CONSTRAINT `proofreader_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `qrcodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qrcodes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `qrtype` varchar(255) NOT NULL,
  `qrdata` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tagging_tag_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tagging_tag_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(125) NOT NULL,
  `name` varchar(125) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tagging_tag_groups_slug_index` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tagging_tagged`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tagging_tagged` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taggable_id` int(10) unsigned NOT NULL,
  `taggable_type` varchar(125) NOT NULL,
  `tag_name` varchar(125) NOT NULL,
  `tag_slug` varchar(125) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tagging_tagged_taggable_id_index` (`taggable_id`),
  KEY `tagging_tagged_taggable_type_index` (`taggable_type`),
  KEY `tagging_tagged_tag_slug_index` (`tag_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tagging_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tagging_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_group_id` int(10) unsigned DEFAULT NULL,
  `slug` varchar(125) NOT NULL,
  `name` varchar(125) NOT NULL,
  `suggest` tinyint(1) NOT NULL DEFAULT 0,
  `count` int(10) unsigned NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tagging_tags_slug_index` (`slug`),
  KEY `tagging_tags_tag_group_id_foreign` (`tag_group_id`),
  CONSTRAINT `tagging_tags_tag_group_id_foreign` FOREIGN KEY (`tag_group_id`) REFERENCES `tagging_tag_groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telescope_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries` (
  `sequence` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `family_hash` varchar(255) DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sequence`),
  UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  KEY `telescope_entries_batch_id_index` (`batch_id`),
  KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`),
  KEY `telescope_entries_family_hash_index` (`family_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telescope_entries_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) NOT NULL,
  `tag` varchar(255) NOT NULL,
  KEY `telescope_entries_tags_entry_uuid_tag_index` (`entry_uuid`,`tag`),
  KEY `telescope_entries_tags_tag_index` (`tag`),
  CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telescope_monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `access_level` varchar(255) NOT NULL DEFAULT 'members',
  `live` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `sort_order` int(10) unsigned NOT NULL,
  `front_page` tinyint(1) NOT NULL DEFAULT 0,
  `landing_page` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `topics_name_unique` (`name`),
  UNIQUE KEY `topics_safe_name_unique` (`slug`),
  KEY `topics_user_id_foreign` (`user_id`),
  KEY `topics_access_level_foreign` (`access_level`),
  CONSTRAINT `topics_access_level_foreign` FOREIGN KEY (`access_level`) REFERENCES `access_level_constants` (`access_level`),
  CONSTRAINT `topics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_banned` tinyint(4) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_info` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `show_profile` tinyint(1) NOT NULL DEFAULT 0,
  `show_picture` tinyint(1) NOT NULL DEFAULT 0,
  `share_email` tinyint(1) NOT NULL DEFAULT 0,
  `share_phone` tinyint(1) NOT NULL DEFAULT 0,
  `file_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_info_user_id_foreign` (`user_id`),
  CONSTRAINT `users_info_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `venues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venues` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `access_level` varchar(255) DEFAULT NULL,
  `live` tinyint(1) NOT NULL,
  `admin_notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `venues_slug_unique` (`slug`),
  KEY `venues_user_id_foreign` (`user_id`),
  KEY `venues_access_level_foreign` (`access_level`),
  CONSTRAINT `venues_access_level_foreign` FOREIGN KEY (`access_level`) REFERENCES `access_level_constants` (`access_level`),
  CONSTRAINT `venues_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*!999999\- enable the sandbox mode */ 
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2019_03_18_143208_create_topics_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2019_03_25_083736_update_topics_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2019_03_26_014200_create_sessions_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2018_08_08_100000_create_telescope_entries_table',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2019_04_01_025748_update_topics_columns',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2019_04_01_065401_update_topic_column_scope',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2019_04_10_234053_create_permission_tables',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2014_01_07_073615_create_tagged_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2014_01_07_073615_create_tags_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2016_06_29_073615_create_tag_groups_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2016_06_29_073615_update_tags_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2019_04_16_014351_create_pages_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2019_05_22_090736_users_phone',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2019_05_22_085522_user_info',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2019_05_22_090722_users_address',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2019_05_22_092813_users_membership',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2019_06_03_021943_add_user_to_pages',13);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2019_06_03_072153_add_user_to_topics',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2019_06_04_205659_alter_users_info',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2019_06_04_211232_alter_memberships',16);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2019_06_06_204333_create_attachments_table',17);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2019_08_19_000000_create_failed_jobs_table',17);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2019_09_10_075444_create_venues_table',17);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2019_10_24_062043_create_page_topic_pivot_table',18);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2019_10_25_021307_create_posts_table',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2019_10_25_021338_create_posts_topic_pivot_table',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2019_10_25_065951_create_page_posts_pivot_table',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2019_11_06_011237_update_attachments_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2019_11_13_052622_update_venues_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2019_11_13_090953_update_users_info_table',22);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2019_11_16_075308_add_preference_columns_to_users_info_table',23);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2019_11_18_002749_create_committees_table',24);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (54,'2019_11_21_024726_create_users_committees_pivot_table',24);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (55,'2019_11_26_004818_update_users_committees_pivot_table',25);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (56,'2019_11_26_004840_update_committees_table',25);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (57,'2019_11_26_025351_delete_page_post',26);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (58,'2019_11_29_225554_update_commttee_user',27);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (62,'2019_12_03_224246_remove_image_columns',28);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (63,'2019_12_04_002933_create_committee_posts_table',29);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (64,'2019_12_04_003434_create_committe_posts_comments_table',29);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (65,'2019_12_13_005615_create_table_organizations',30);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (72,'2020_01_08_045020_create_meetings_table',31);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (73,'2020_01_08_051731_create_meeting_attachments_table',31);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (74,'2020_01_21_071359_create_attachment_meeting_table',32);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (75,'2020_01_21_083237_add_file_column_to_attachments_table',33);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (76,'2020_01_28_033918_add_description_subfolder_to_attachments_table',34);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (77,'2020_01_29_030750_drop_meeting_attachments_table',35);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (78,'2020_01_29_032225_create_employment_table',36);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (79,'2020_01_29_221711_create_attachment_employment_table',36);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (84,'2020_02_29_021436_create_invite_users_table',37);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (86,'2020_02_21_001608_create_agreements_table',38);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (87,'2020_03_10_004803_create_attachment_agreement_table',39);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (88,'2020_03_10_013428_create_bylaws_table',40);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (89,'2020_03_10_013444_create_attachment_bylaw_table',40);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (90,'2020_03_20_021806_create_attachment_page_table',41);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (91,'2020_03_20_043146_create_attachment_post_table',42);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (92,'2020_03_20_065717_create_attachment_topic_table',43);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (93,'2020_03_26_120000_create_access_level_constants_table',44);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (94,'2020_04_04_012725_add_access_level_to_attachments_table',45);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (95,'2020_04_09_225311_update_url_col_in_organizations_table',46);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (96,'2020_04_10_195025_create_agreement_venue_table',47);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (97,'2020_04_10_195602_create_agreement_organization_table',47);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (98,'2020_04_14_034144_add_message_to_invite_users_table',48);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (99,'2020_05_06_210415_remove_allowcomments_committees_table',49);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (102,'2020_05_11_200637_create_policies_table',50);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (103,'2020_05_11_200936_create_attachment_policies_table',50);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (105,'2020_05_15_043305_create_executives_table',51);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (106,'2020_06_04_205657_create_executives_users_table',51);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (107,'2020_06_04_210341_insert_into_executives_table',51);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (108,'2020_06_18_203215_update_agreements_in_attachments_table',52);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (109,'2020_10_31_013506_alter_membership_table',53);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (110,'2020_11_10_223245_alter_invite_users_table',53);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (111,'2021_01_19_045842_add_uuid_to_failed_jobs_table',54);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (112,'2021_01_23_004656_alter_phone_table_allow_phone_null',55);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (113,'2021_02_01_212429_alter_posts_table_stickies',56);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (114,'2021_02_02_072114_alter_pages_table_stickies',57);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (115,'2021_02_02_082606_alter_topics_table_stickies',58);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (116,'2021_02_04_003801_create_attachment_committee_table',59);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (117,'2021_02_04_021348_alter_committees_table_add_banner',59);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (118,'2021_02_08_065013_alter_employment_table_timestamp',60);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (119,'2021_02_08_081241_alter_meetings_table_timestamp',60);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (120,'2021_02_10_223621_create_features_table',61);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (121,'2021_02_15_001350_attachment_committee_post',62);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (122,'2021_02_15_073634_insert_trustee_into_executives_table',63);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (123,'2021_02_19_002656_alter_table_venues',64);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (124,'2021_02_19_074210_alter_table_organizations',65);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (125,'2021_02_19_233611_create_memoriams_table',66);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (126,'2021_02_25_051947_alter_tables_add_live_feature_front',67);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (127,'2021_02_25_084457_alter_table_features_add_access_level',67);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (128,'2021_02_26_074012_create_attachment_organization_table',68);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (129,'2021_02_26_080519_create_attachment_venue_table',69);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (130,'2021_03_02_051330_create_proofreader_table',70);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (131,'2021_03_16_190639_create_jobs_table',71);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (132,'2021_05_02_114106_create_import_users_table',72);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (133,'2020_03_13_083515_add_description_to_tags_table',73);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (134,'2022_04_20_223834_add_banned_until_to_users_table',73);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (135,'2023_05_16_183812_create_qrcodes_table',74);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (136,'2023_06_06_180258_create_carousel_table',74);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (137,'2023_06_13_001833_create_faqs_table',74);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (138,'2023_06_13_001940_create_faqs_data_table',74);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (139,'2023_12_12_164241_update_qrcodes_table',75);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (142,'2023_12_19_145802_alter_table_carousels',76);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (143,'2024_02_15_174645_create_messages_table',77);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (144,'2024_02_20_155923_attachment_message',77);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (145,'2024_02_21_114141_create_message_frequency_preferences',77);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (146,'2024_02_21_115818_create_message_selections',77);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (147,'2024_03_19_152055_create_email_queue',77);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (148,'2024_03_25_213156_create_message_sending_table',77);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (149,'2024_03_25_215341_create_message_metadata_table',77);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (150,'2024_06_22_000000_rename_password_resets_table',77);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (151,'2024_09_09_194814_alter_table_users_add_deleted_at',78);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (152,'2024_09_10_130036_alter_table_committee_posts_add_author_name',79);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (153,'2024_09_11_193313_create_table_activity_log',80);
