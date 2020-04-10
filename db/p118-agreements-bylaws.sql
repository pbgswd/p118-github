-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Mar 10, 2020 at 06:47 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS=0;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `p118`
--

-- --------------------------------------------------------

--
-- Table structure for table `agreements`
--

DROP TABLE IF EXISTS `agreements`;
CREATE TABLE `agreements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `access_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'members',
  `live` tinyint(1) NOT NULL DEFAULT '1',
  `from` date NOT NULL,
  `until` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agreements`
--

INSERT INTO `agreements` (`id`, `user_id`, `title`, `description`, `access_level`, `live`, `from`, `until`, `created_at`, `updated_at`) VALUES
(1, 1, 'Arts Club Theatre 2016 - 2020 (ACT)', 'Arts Club Theatre 2016 - 2020 (ACT)', 'members', 1, '2016-09-01', '2020-08-31', '2020-03-10 01:06:57', '2020-03-10 01:06:57'),
(3, 1, 'Abbotsford Entertainment Centre 2017 - 2019', 'Abbotsford Entertainment Centre 2017 - 2019', 'members', 1, '2016-03-01', '2019-02-28', '2020-03-10 01:10:11', '2020-03-10 01:10:11'),
(4, 1, 'Ballet BC 2016 - 2019', 'Ballet BC 2016 - 2019', 'members', 1, '2013-07-01', '2016-06-30', '2020-03-10 01:10:12', '2020-03-10 01:10:12'),
(5, 1, 'Ballet BC 2019 - 2021 Memo of Agreement', 'Ballet BC 2019 - 2021 Memo of Agreement', 'members', 1, '2019-07-01', '2022-06-30', '2020-03-10 01:10:13', '2020-03-10 01:10:13'),
(6, 1, 'COV Collective Agreement 2016 - 2019', 'COV Collective Agreement 2016 - 2019', 'members', 1, '2016-01-01', '2019-12-31', '2020-03-10 01:10:22', '2020-03-10 01:10:22'),
(7, 1, 'COV Orpheum Annex agreement', 'COV Orpheum Annex agreement', 'members', 1, '2011-06-09', '2022-01-01', '2020-03-10 01:10:23', '2020-03-10 01:10:23'),
(8, 1, 'Fringe 2017 - 2019', 'Fringe 2017 - 2019', 'members', 1, '2017-01-01', '2019-12-31', '2020-03-10 01:10:24', '2020-03-10 01:10:24'),
(9, 1, 'Global Spectrum agreement  2019 - 2023', '<p>Global Spectrum agreement 2019 - 2023</p>', 'members', 1, '2019-03-01', '2023-02-28', '2020-03-10 01:10:27', '2020-03-10 05:39:19'),
(10, 1, 'Live Nation Canada 2017 - 2020', 'Live Nation Canada 2017 - 2020', 'members', 1, '2017-07-01', '2020-06-30', '2020-03-10 01:10:28', '2020-03-10 01:10:28'),
(11, 1, 'Master Casual Agreement', 'Master Casual Agreement', 'members', 1, '2011-07-01', '2014-06-30', '2020-03-10 01:10:28', '2020-03-10 01:10:28'),
(12, 1, 'Pacific National Exhibition agreement (PNE) 2014 - 2016', 'Pacific National Exhibition agreement (PNE) 2014 - 2016', 'members', 1, '2014-01-01', '2016-12-31', '2020-03-10 01:10:29', '2020-03-10 01:10:29'),
(13, 1, 'Richmond Gateway Theatre 2019 - 2021', 'Richmond Gateway Theatre 2019 - 2021', 'members', 1, '2019-01-01', '2021-12-31', '2020-03-10 01:10:31', '2020-03-10 01:10:31'),
(14, 1, 'Theatre Under The Stars (TUTS) 2018 - 2021', 'Theatre Under The Stars (TUTS) 2018 - 2021', 'members', 1, '2018-01-01', '2021-12-31', '2020-03-10 01:10:32', '2020-03-10 01:10:32'),
(15, 1, 'Vancouver East Cultural Centre - FOH Agreement 2019 - 2021', 'Vancouver East Cultural Centre - FOH Agreement 2019 - 2021', 'members', 1, '2017-06-01', '2021-05-31', '2020-03-10 01:10:34', '2020-03-10 01:10:34'),
(16, 1, 'Vancouver East Cultural Centre Stage Agreements 2019 - 2021', 'Vancouver East Cultural Centre Stage Agreements 2019 - 2021', 'members', 1, '2017-06-01', '2021-05-31', '2020-03-10 01:10:35', '2020-03-10 01:10:35'),
(17, 1, 'Vancouver Opera Association (VOA) 2016 - 2018', 'Vancouver Opera Association (VOA) 2016 - 2018', 'members', 1, '2016-07-01', '2018-06-30', '2020-03-10 01:10:36', '2020-03-10 01:10:36'),
(18, 1, 'Vancouver Opera Association (VOA) 2018 - 2019 Memo of Agreement', 'Vancouver Opera Association (VOA) 2018 - 2019 Memo of Agreement', 'members', 1, '2018-07-01', '2019-06-30', '2020-03-10 01:10:37', '2020-03-10 01:10:37'),
(19, 1, 'Vancouver Symphony Society (VSS) -   2018 - 2022', 'Vancouver Symphony Society (VSS) -   2018 - 2022', 'members', 1, '2018-07-01', '2022-06-30', '2020-03-10 01:10:38', '2020-03-10 01:10:38'),
(20, 1, 'Vancouver Symphony Society (VSS) 2018 - 2022 Memo of Agreement', 'Vancouver Symphony Society (VSS) 2018 - 2022 Memo of Agreement', 'members', 1, '2018-07-01', '2022-06-30', '2020-03-10 01:10:40', '2020-03-10 01:10:40'),
(22, 1, 'Abbotsford Entertainment Centre MOS 2017', 'Abbotsford Entertainment Centre MOS 2017', 'members', 1, '2016-03-01', '2019-02-28', '2020-03-10 01:10:42', '2020-03-10 01:10:42'),
(24, 1, 'COV Collective Agreement 2012-2015', 'COV Collective Agreement 2012-2015', 'members', 1, '2012-01-01', '2015-12-31', '2020-03-10 01:10:44', '2020-03-10 01:10:44'),
(26, 1, 'Fringe', 'Fringe', 'members', 1, '2007-01-01', '2009-12-31', '2020-03-10 01:10:46', '2020-03-10 01:10:46'),
(27, 1, 'Global Spectrum agreement 2016-2019', 'Global Spectrum agreement 2016-2019', 'members', 1, '2016-03-01', '2019-02-28', '2020-03-10 01:10:50', '2020-03-10 01:10:50'),
(31, 1, 'Richmond Gateway Theatre 2016-2018', 'Richmond Gateway Theatre 2016-2018', 'members', 1, '2016-01-01', '2018-12-31', '2020-03-10 01:10:54', '2020-03-10 01:10:54'),
(32, 1, 'Vancouver East Cultural Centre - FOH Agreement 2012 - 2017', 'Vancouver East Cultural Centre - FOH Agreement 2012 - 2017', 'members', 1, '2012-03-01', '2017-05-31', '2020-03-10 01:10:55', '2020-03-10 01:10:55'),
(33, 1, 'Vancouver East Cultural Centre Stage Agreements 2012-2017', 'Vancouver East Cultural Centre Stage Agreements 2012-2017', 'members', 1, '2012-06-01', '2017-05-31', '2020-03-10 01:10:56', '2020-03-10 01:10:56'),
(34, 1, 'Vancouver Opera Association (VOA) 2016-2018', 'Vancouver Opera Association (VOA) 2016-2018', 'members', 1, '2016-07-01', '2018-06-30', '2020-03-10 01:10:57', '2020-03-10 01:10:57'),
(35, 1, 'Vancouver Symphony Society (VSS) -  2014-2018', 'Vancouver Symphony Society (VSS) -  2014-2018', 'members', 1, '2014-07-01', '2018-06-30', '2020-03-10 01:10:58', '2020-03-10 01:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE `attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '1',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subfolder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `user_id`, `description`, `file_name`, `file`, `subfolder`, `created_at`, `updated_at`) VALUES
(46, 1, NULL, 'Ab2.jpg', 'XJp6Ck56hik8fpX7zjeYMXFYYKk6sv1HLisfFe19.jpeg', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(47, 1, NULL, 'Abbotsford 2017 Estimate Blank.xltx', 'JsSwFhrP2irPzSSLtNJZ5gymJIvnxWdwvzyssGpw.xlsx', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(48, 1, NULL, 'Annex 408.galileoProject', 'Lk7K7Wxjvldf11jF4BsmbX3ILwUpyi6WkF3NHy7j.bin', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(49, 1, NULL, 'bacon1.jpg', 'u11dvmJC1iW4BzRqd7yvM3cCLZIzxRZoxvqqvwgB.jpeg', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(50, 1, NULL, 'bacon2.jpg', 'WKcntGXdCR2srsJH4Wxx0QllOpJIYWL3IVYlaI0T.jpeg', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(51, 1, NULL, 'bacon3.jpg', 'nA5lYTPMWgFft8z1E9EQK40UkeGOXP5LMmkYKcvA.jpeg', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(55, 1, NULL, 'Counterweight Rigging System Manual for Vancouver Playhouse Theatre.pdf', 'II6BTnoHBdt9mUnkWUHthXPYoE2jM4xeUFzMCmEk.pdf', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(56, 1, NULL, 'Filling out a Stage Carpenters Report.pdf', 'd923kK7iAAkRPdQbixeowFBYTtYrIxRxIU571O2z.pdf', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(57, 1, NULL, 'Ion_L1_Workbook_v2.3.0_revA.pdf', 'amLojPeRVgMZz0AQF9t5lYSTo2H5DzkOK93r8gXu.pdf', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(58, 1, NULL, 'Malkin Bowl 2017 Blank Estimate.xltx', 'zpqbwaZZU7cyq4T2wW4XsFV21S85hSuuNVEjlBOK.xlsx', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(59, 1, NULL, 'Marks_Discount_Card_2019_signed.pdf', 'UaZY3k83Ci29KcN6vToD7VI7CDqq4UwIvXiRHaOL.pdf', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(60, 1, NULL, 'Master 2017 Blank Estimate.xltx', 'KRwfumlouOMl8eOmSvOPrbL7ehV4HNunLv6ZOsId.xlsx', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(61, 1, NULL, 'Orpheum Annex Audio  Patch.pdf', 'ljAiRzfPrkVoODx8IxKhM3zJG6pbqqiXHuLlmRx3.pdf', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(62, 1, NULL, 'ORPHEUM FLOW CHART CURRENT.pdf', 'BeUlNB52GfL4WzKzW25ldm0uR0gICEN0ezFcQ51F.pdf', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(63, 1, NULL, 'Orpheum LX Circuits 2016v5.pdf', '73BqoBoTaLH5colmWH9HrBXcQ6haqvuqLEA9Gz1D.pdf', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(64, 1, NULL, 'ORPHEUM PATCH FIELD.pdf', 'C1qSFjlyyJ96UXbna5OLSIDBHmjSDdjRDNiEK2yW.pdf', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(65, 1, NULL, 'playhouseorientation0608.pdf', 'SB8AEg1SgOx8WWPP1cnTEctqVKz50W6cEX68HRtF.pdf', 'public', '2020-01-24 04:44:09', '2020-01-24 04:44:09'),
(66, 1, NULL, 'PROGRAM SOUND.pdf', 'eG9HRi4xizd5O29cOho0tWmLoQs9Z7FHjzW2pRGc.pdf', 'public', '2020-01-24 04:44:46', '2020-01-24 04:44:46'),
(67, 1, NULL, 'Pyatt hall procedures.pdf', '4eQNTFBZLRW2RTBh0t7kKJPhGTMbA1WaVUn0J7Sz.pdf', 'public', '2020-01-24 04:44:46', '2020-01-24 04:44:46'),
(68, 1, NULL, 'QET08.jpg', 'jEQAIyhmtIWcsSz3tZzBqKCyVx1rG6DAJ5sLzCyI.jpeg', 'public', '2020-01-24 04:44:46', '2020-01-24 04:44:46'),
(69, 1, NULL, 'QET SMOKE BYPASS.pdf', '3DcpKU0nOGoAObqIRIDMWvsQvAD7VkE52XDiKtSE.pdf', 'public', '2020-01-24 04:44:46', '2020-01-24 04:44:46'),
(70, 1, NULL, 'SET QUAD.pdf', '0QKySDp7d4fUP9riLsJQYMRQNPFbP28xT4zEMVtK.pdf', 'public', '2020-01-24 04:44:46', '2020-01-24 04:44:46'),
(71, 1, NULL, 'soundorphceilingpatch.pdf', 'U6aBeqhDBHsu35dbCDopJ9awByfsnuw4mdysLZDi.pdf', 'public', '2020-01-24 04:44:46', '2020-01-24 04:44:46'),
(72, 1, NULL, 'Stanley-Theatre.jpg', 'DYlT3lebanC7qBoWNSk2zzF3G9MuY9jtzGM5V33O.jpeg', 'public', '2020-01-24 04:44:46', '2020-01-24 04:44:46'),
(73, 1, NULL, 'VIDEO SCHEMATIC.pdf', 'y6We8dkafuwZuFY3Yo4VSwVCI4UtUCwnHwrjmfXk.pdf', 'public', '2020-01-24 04:44:47', '2020-01-24 04:44:47'),
(74, 1, NULL, 'VIDEO START UP.pdf', '7JSgiBS1bYhplEHnBol5EZ26srznPvHXh6BmgbEM.pdf', 'public', '2020-01-24 04:44:47', '2020-01-24 04:44:47'),
(75, 1, NULL, 'Visio-ORPHEUM ARCHITECTURAL SPEAKER DISTANCES.pdf', 'MCrrKyNqhCBYcCHCzFEtryvt6WF4f88JMKwjyN6u.pdf', 'public', '2020-01-24 04:44:47', '2020-01-24 04:44:47'),
(76, 1, NULL, 'Visio-PROJ SCREEN SIZE.pdf', 'ekotxopT2ksh5LBBzCHYv5mESPknoypP2PEewSPx.pdf', 'public', '2020-01-24 04:44:47', '2020-01-24 04:44:47'),
(77, 1, NULL, 'When patching the sound for video recording.pdf', 'AMTMTGngeGNHtoMzQZvpAg4Uf6qBJEjcEOYFcvlu.pdf', 'public', '2020-01-24 04:44:47', '2020-01-24 04:44:47'),
(83, 1, 'October 21, 2019 Minutes of General Membership Meeting', 'MinutesGM_10212019.pdf', 'MinutesGM_10212019.pdf', 'meetings', '2020-01-14 09:42:27', '2020-01-14 09:42:27'),
(84, 1, 'October 15, 2019 Minutes of Executive Board Meeting', 'MinutesEXEC_101519.pdf', 'MinutesEXEC_101519.pdf', 'meetings', '2020-01-14 09:42:27', '2020-01-14 09:42:27'),
(85, 1, 'September 25, 2019 Minutes of General Membership Meeting', 'MinutesGM_092519.pdf', 'MinutesGM_092519.pdf', 'meetings', '2020-01-14 09:42:27', '2020-01-14 09:42:27'),
(86, 1, 'September 18, 2019 Minutes of Executive Board Meeting', 'MinutesEXEC091819.pdf', 'MinutesEXEC091819.pdf', 'meetings', '2020-01-14 09:42:27', '2020-01-14 09:42:27'),
(87, 1, 'August 12, 2019 Minutes of Executive Board Meeting', 'MinutesEXEC_081219.pdf', 'MinutesEXEC_081219.pdf', 'meetings', '2020-01-14 09:42:27', '2020-01-14 09:42:27'),
(88, 1, 'July 29, 2019 Minutes of General Membership Meeting', 'MinutesGM_072919.pdf', 'MinutesGM_072919.pdf', 'meetings', '2020-01-14 09:42:27', '2020-01-14 09:42:27'),
(89, 1, 'July 15, 2019 Minutes of Executive Board Meeting', 'MinutesEXEC_07152019.pdf', 'MinutesEXEC_07152019.pdf', 'meetings', '2020-01-14 09:42:27', '2020-01-14 09:42:27'),
(90, 1, 'May 29, 2019 Minutes of General Membership Meeting', 'MinutesGM_052919.pdf', 'MinutesGM_052919.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(91, 1, 'June 26, 2019 Minutes of Special General Membership Meeting', 'MinutesGM_Special_062619.pdf', 'MinutesGM_Special_062619.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(92, 1, 'June 26, 2019 Minutes of General Membership Meeting', 'MinutesGM_062619.pdf', 'MinutesGM_062619.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(93, 1, 'June 11, 2019 Minutes of Executive Board Meeting', 'MinutesEXEC_061119.pdf', 'MinutesEXEC_061119.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(94, 1, 'May 14, 2019 Minutes of Executive Board Meeting', 'MinutesEXEC_051419.pdf', 'MinutesEXEC_051419.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(95, 1, 'April 29, 2019 Minutes of General Membership Meeting', 'MinutesGM_042919.pdf', 'MinutesGM_042919.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(96, 1, 'April 12, 2019 Minutes of Executive Board Meeting', 'MinutesEXEC_041219.pdf', 'MinutesEXEC_041219.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(97, 1, 'March 25, 2019 Minutes of Executive Board Meeting', 'MinutesEXEC_032519.pdf', 'MinutesEXEC_032519.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(98, 1, 'March 14, 2019 Minutes of General Membership  Meeting', 'MinutesGM_031419.pdf', 'MinutesGM_031419.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(99, 1, 'February 20, 2019 Minutes of Executive Board Meeting', 'MinutesEXEC_022019.pdf', 'MinutesEXEC_022019.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(100, 1, 'January 30, 2019 Minutes of General Membership  Meeting', 'MinutesGM_013019.pdf', 'MinutesGM_013019.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(101, 1, 'January 12, 2019 Minutes of Executive Board Meeting', 'MinutesEXEC_011219.pdf', 'MinutesEXEC_011219.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(102, 1, 'December 27, 2018 Minutes of General Membership  Meeting', 'MinutesGM_12272018.pdf', 'MinutesGM_12272018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(103, 1, 'December 11, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_121118.pdf', 'MinutesEXEC_121118.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(104, 1, 'November 26, 2018 Minutes of General Membership  Meeting', 'MinutesGM_112618.pdf', 'MinutesGM_112618.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(105, 1, 'October  30, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_10302018.pdf', 'MinutesEXEC_10302018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(106, 1, 'October 19, 2018 Minutes of General Membership  Meeting', 'MinutesGM_10192018.pdf', 'MinutesGM_10192018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(107, 1, 'October  5, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_10052018.pdf', 'MinutesEXEC_10052018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(108, 1, 'September 17, 2018 Minutes of General Membership  Meeting', 'MinutesGM_09172018.pdf', 'MinutesGM_09172018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(109, 1, 'September 1, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_09012018.pdf', 'MinutesEXEC_09012018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(110, 1, 'August 16, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_08162018.pdf', 'MinutesEXEC_08162018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(111, 1, 'August 2, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_08022018.pdf', 'MinutesEXEC_08022018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(112, 1, 'July 18, 2018 Minutes of General Membership Meeting', 'MinutesGM_07182018.pdf', 'MinutesGM_07182018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(113, 1, 'July 17, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_07172018.pdf', 'MinutesEXEC_07172018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(114, 1, 'June 26, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_06212018.pdf', 'MinutesEXEC_06212018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(115, 1, 'June 13, 2018 Minutes of General Membership Meeting', 'MinutesGM_06132018.pdf', 'MinutesGM_06132018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(116, 1, 'May 22, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_05222018.pdf', 'MinutesEXEC_05222018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(117, 1, 'April 30, 2018 Minutes of General Membership Meeting', 'MinutesGM_04302018.pdf', 'MinutesGM_04302018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(118, 1, 'April 16, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_041618.pdf', 'MinutesEXEC_041618.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(119, 1, 'March 16, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_031618.pdf', 'MinutesEXEC_031618.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(120, 1, 'February 25, 2018 Minutes of General Membership Meeting', 'MinutesGM_022518.pdf', 'MinutesGM_022518.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(121, 1, 'February 2, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_02022018.pdf', 'MinutesEXEC_02022018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(122, 1, 'January 26, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_01262018.pdf', 'MinutesEXEC_01262018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(123, 1, 'January 25, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_01252018.pdf', 'MinutesEXEC_01252018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(124, 1, 'January 8, 2018 Minutes of Executive Board Meeting', 'MinutesEXEC_01082018.pdf', 'MinutesEXEC_01082018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(125, 1, 'December 18, 2017 Minutes of General Membership Meeting', 'MinutesGM_12182018.pdf', 'MinutesGM_12182018.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(126, 1, 'November 20, 2017 Minutes of Executive Board Meeting', 'MinutesEXEC_11202017.pdf', 'MinutesEXEC_11202017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(127, 1, 'October 29, 2017 Minutes of General Membership Meeting', 'MinutesGM_10292017.pdf', 'MinutesGM_10292017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(128, 1, 'October 17, 2017 Minutes of Executive Board Meeting', 'MinutesEXEC_10172017.pdf', 'MinutesEXEC_10172017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(129, 1, 'September 24, 2017 Minutes of General Membership Meeting', 'MinutesGM_09242017.pdf', 'MinutesGM_09242017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(130, 1, 'September 16, 2017 Minutes of Special Executive Meeting', 'MinutesSPECEX_09162017.pdf', 'MinutesSPECEX_09162017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(131, 1, 'September 9, 2017 Minutes of Executive Board Meeting', 'MinutesEXEC_09092017.pdf', 'MinutesEXEC_09092017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(132, 1, 'August 18, 2017 Minutes of Executive Board Meeting', 'MinutesEXEC_08182017.pdf', 'MinutesEXEC_08182017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(133, 1, 'July 19, 2017 Minutes of General Membership Meeting', 'MinutesGM_07192017.pdf', 'MinutesGM_07192017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(134, 1, 'June 25, 2017 Minutes of General Membership Meeting', 'MinutesGM_06252017.pdf', 'MinutesGM_06252017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(135, 1, 'May 18, 2017 Minutes of General Membership Meeting', 'MinutesGM_05182017.pdf', 'MinutesGM_05182017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(136, 1, 'May 17, 2017 Minutes of Executive Board Meeting', 'MinutesEXEC_05172017.pdf', 'MinutesEXEC_05172017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(137, 1, 'April 27, 2017 Minutes of Executive Board Meeting', 'MinutesEXEC_04272017.pdf', 'MinutesEXEC_04272017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(138, 1, 'March 26, 2017 Minutes of General Membership Meeting', 'MinutesGM_03262017.pdf', 'MinutesGM_03262017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(139, 1, 'March 18, 2017 Minutes of Executive Board Meeting', 'MinutesEXEC_03182017.pdf', 'MinutesEXEC_03182017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(140, 1, 'February 26, 2017 Minutes of General Membership Meeting', 'MinutesGM_02262017.pdf', 'MinutesGM_02262017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(141, 1, 'February 5, 2017 Minutes of Executive Board Meeting', 'MinutesEXEC_02052017.pdf', 'MinutesEXEC_02052017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(142, 1, 'January 22, 2017 Minutes of General Membership Meeting', 'MinutesGM_01222017.pdf', 'MinutesGM_01222017.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(143, 1, 'January 15, 2017 Minutes of Executive Board Meeting', 'MinutesEXEC_011517.pdf', 'MinutesEXEC_011517.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(144, 1, 'January 7, 2017 Minutes of Executive Board Meeting', 'MinutesEXEC_010717.pdf', 'MinutesEXEC_010717.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(145, 1, 'December 29, 2016 Minutes of Executive Board Meeting', 'MinutesGM_12292016.pdf', 'MinutesGM_12292016.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(146, 1, 'December 8, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_12082016.pdf', 'MinutesEXEC_12082016.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(147, 1, 'November 29, 2016 Minutes of General Membership Meeting', 'MinutesGM_11292016.pdf', 'MinutesGM_11292016.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(148, 1, 'November 7, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_11072016.pdf', 'MinutesEXEC_11072016.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(149, 1, 'October 25, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_10252016.pdf', 'MinutesEXEC_10252016.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(150, 1, 'October 11, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_10112016.pdf', 'MinutesEXEC_10112016.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(151, 1, 'September 29, 2016 Minutes of General Membership Meeting', 'MinutesGM_09292016.pdf', 'MinutesGM_09292016.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(152, 1, 'August 29, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_082916.pdf', 'MinutesEXEC_082916.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(153, 1, 'July 14, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_07142016.pdf', 'MinutesEXEC_07142016.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(154, 1, 'June 27, 2016 Minutes of General Membership Meeting', 'MinutesGM_06272016.pdf', 'MinutesGM_06272016.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(155, 1, 'June 10, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_06102016.pdf', 'MinutesEXEC_06102016.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(156, 1, 'May 16, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_05162016.pdf', 'MinutesEXEC_05162016.pdf', 'meetings', '2020-01-14 09:42:28', '2020-01-14 09:42:28'),
(157, 1, 'May 16, 2016 Minutes of General Membership Meeting', 'MinutesGM_05162016.pdf', 'MinutesGM_05162016.pdf', 'meetings', '2020-01-14 09:42:29', '2020-01-14 09:42:29'),
(158, 1, 'April 30, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_04302016.pdf', 'MinutesEXEC_04302016.pdf', 'meetings', '2020-01-14 09:42:29', '2020-01-14 09:42:29'),
(159, 1, 'April 8, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_04112016.pdf', 'MinutesEXEC_04112016.pdf', 'meetings', '2020-01-14 09:42:29', '2020-01-14 09:42:29'),
(160, 1, 'March 30, 2016 Minutes of General Membership Meeting', 'MinutesGM_03302016.pdf', 'MinutesGM_03302016.pdf', 'meetings', '2020-01-14 09:42:29', '2020-01-14 09:42:29'),
(161, 1, 'March 8, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_03082016.pdf', 'MinutesEXEC_03082016.pdf', 'meetings', '2020-01-14 09:42:29', '2020-01-14 09:42:29'),
(162, 1, 'February 26, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_02262016.pdf', 'MinutesEXEC_02262016.pdf', 'meetings', '2020-01-14 09:42:29', '2020-01-14 09:42:29'),
(163, 1, 'February 26, 2016 Minutes of General Membership Meeting', 'MinutesGM_02262016.pdf', 'MinutesGM_02262016.pdf', 'meetings', '2020-01-14 09:42:29', '2020-01-14 09:42:29'),
(164, 1, 'February 22, 2016 Minutes of Special General Membership Meeting', 'MinutesSPEC_02222016.pdf', 'MinutesSPEC_02222016.pdf', 'meetings', '2020-01-14 09:42:29', '2020-01-14 09:42:29'),
(165, 1, 'February 3, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_02032016.pdf', 'MinutesEXEC_02032016.pdf', 'meetings', '2020-01-14 09:42:29', '2020-01-14 09:42:29'),
(166, 1, 'January 14, 2016 Minutes of General Membership Meeting', 'MinutesGM_01142016.pdf', 'MinutesGM_01142016.pdf', 'meetings', '2020-01-14 09:42:29', '2020-01-14 09:42:29'),
(167, 1, 'January 9, 2016 Minutes of Executive Board Meeting', 'MinutesEXEC_01092016.pdf', 'MinutesEXEC_01092016.pdf', 'meetings', '2020-01-14 09:42:29', '2020-01-14 09:42:29'),
(168, 1, 'December 2019 Notice of General Meeting', 'NOM December 2019.pdf', 'NOM December 2019.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(169, 1, 'November 2019 Notice of General Meeting', 'NOM November 2019.pdf', 'NOM November 2019.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(170, 1, 'September 2019 Notice of General Meeting', 'NOM September 2019.pdf', 'NOM September 2019.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(171, 1, 'July 2019 Notice of General Meeting', 'NOM July 2019.pdf', 'NOM July 2019.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(172, 1, 'June 2019 Notice of General Meeting', 'NOM June 2019.pdf', 'NOM June 2019.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(173, 1, 'January 2019 Notice of General Meeting', 'NOM January 2019.pdf', 'NOM January 2019.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(174, 1, 'December 2018 Notice of General Meeting', 'NOM December 2018.pdf', 'NOM December 2018.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(175, 1, 'November 2018 Notice of General Meeting', 'NOM November 2018.pdf', 'NOM November 2018.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(176, 1, 'October 2018 Notice of General Meeting', 'NOM October 2018.pdf', 'NOM October 2018.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(177, 1, 'September 2018 Notice of General Meeting', 'NOM September 2018.pdf', 'NOM September 2018.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(178, 1, 'July 2018 Notice of General Meeting', 'NOM July 2018.pdf', 'NOM July 2018.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(179, 1, 'June 2018 Notice of General Meeting', 'NOM June 2018.pdf', 'NOM June 2018.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(180, 1, 'April 2018 Notice of General Meeting', 'NOM April 2018.pdf', 'NOM April 2018.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(181, 1, 'March 2018 Notice of March General Meeting and Special General Meeting', 'NOM March 2018.pdf', 'NOM March 2018.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(182, 1, 'February 2018 Addendum Notice of General Meeting', 'Addendum Feb 2018 NOM.pdf', 'Addendum Feb 2018 NOM.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(183, 1, 'February 2018 Notice of General Meeting', 'NOM February 2018.pdf', 'NOM February 2018.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(184, 1, 'October 2017 Notice of General Meeting', 'NOM October 2017.pdf', 'NOM October 2017.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(185, 1, 'September 2017 Notice of General Meeting', 'NOM September 2017.pdf', 'NOM September 2017.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(186, 1, 'July 2017 Notice of General Meeting', 'NOM July 2017.pdf', 'NOM July 2017.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(187, 1, 'June 2017 Notice of General Meeting', 'NOM June 2017.pdf', 'NOM June 2017.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(188, 1, 'May 2017 Notice of General Meeting', 'NOM May 18, 2017 GM.pdf', 'NOM May 18, 2017 GM.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(189, 1, 'March 2017 Notice of General Meeting', 'NOM March 2017.pdf', 'NOM March 2017.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(190, 1, 'February 2017 Notice of General Meeting', 'NOM February 2017.pdf', 'NOM February 2017.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(191, 1, 'January 2017 Notice of General Meeting', 'NOM January 2017.pdf', 'NOM January 2017.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(192, 1, 'December 2016 Notice of General Meeting', 'NOM Dec 2016.pdf', 'NOM Dec 2016.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(193, 1, 'November 2016 Notice of General Meeting', 'NOM November 2016.pdf', 'NOM November 2016.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(194, 1, 'October 2016 Notice of General Meeting', 'NOM October 2016.pdf', 'NOM October 2016.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(195, 1, 'September 2016 Notice of General Meeting', 'NOM September 2016.pdf', 'NOM September 2016.pdf', 'meetings', '2020-01-14 09:43:43', '2020-01-14 09:43:43'),
(196, 1, '28 July 2016 Notice of General Meeting', 'July 2016 NOM.pdf', 'July 2016 NOM.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(197, 1, '27 June 2016 Notice of General Meeting', 'June 2016 NOM.pdf', 'June 2016 NOM.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(198, 1, '16 May 2016 - Notice of General Meeting Amended', 'Supplemental NOM May 2016.pdf', 'Supplemental NOM May 2016.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(199, 1, '16 May 2016 Notice of General Meeting Notice of General Meeting', 'NOM May 2016.pdf', 'NOM May 2016.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(200, 1, '30 March 2016 Notice of General Meeting', 'NOM March 2016.pdf', 'NOM March 2016.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(201, 1, '26 February 2016 Notice of General Meeting', 'NOM February 2016.pdf', 'NOM February 2016.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(202, 1, '22 February 2016 Special Notice of General Meeting', 'NOM February 2016.pdf', 'NOM February 2016.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(203, 1, '14 January 2016 Notice of General Meeting', 'January 14, 2016 NOM.pdf', 'January 14, 2016 NOM.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(204, 1, '30 December 2015 Notice of General Meeting', 'December 2015 Notice of General Meeting.pdf', 'December 2015 Notice of General Meeting.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(205, 1, '30 November 2015 Notice of General Meeting', 'November 2015 Notice of General Meeting.pdf', 'November 2015 Notice of General Meeting.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(206, 1, '26 October 2015 Notice of General Meeting', 'notice26oct15.pdf', 'notice26oct15.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(207, 1, '24 August 2015 Notice of General Meeting', 'notice24aug15.pdf', 'notice24aug15.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(208, 1, '21 July 2015 Notice of General Meeting', 'notice21jul15.pdf', 'notice21jul15.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(209, 1, '29 May 2015 Notice of General Meeting', 'notice29may15.pdf', 'notice29may15.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(210, 1, '27 April 2015 Notice of General Meeting', 'notice27apr15.pdf', 'notice27apr15.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(211, 1, '27 March 2015 Notice of General Meeting', 'notice27mar15.pdf', 'notice27mar15.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(212, 1, '28 February 2015 Notice of General Meeting', 'notice28feb15.pdf', 'notice28feb15.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(213, 1, '24 January 2015 Notice of General Meeting', 'notice24jan15.pdf', 'notice24jan15.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(214, 1, '30 December 2014 Notice of General Meeting', 'notice30dec14.pdf', 'notice30dec14.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(215, 1, '28 November 2014 Notice of General Meeting', 'notice28nov14.pdf', 'notice28nov14.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(216, 1, '24 October 2014 Notice of General Meeting', 'notice24oct14.pdf', 'notice24oct14.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(217, 1, '27 September 2014 Notice of General Meeting', 'notice27sep14.pdf', 'notice27sep14.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(218, 1, '31 May 2014 Notice of General Meeting', 'notice31may14.pdf', 'notice31may14.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(219, 1, '26 April 2014 Notice of General Meeting', 'notice26apr14.pdf', 'notice26apr14.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(220, 1, '29 March 2014 Notice of General Meeting', 'notice29mar14.pdf', 'notice29mar14.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(221, 1, '28 February 2014 Notice of General Meeting', 'notice28feb14.pdf', 'notice28feb14.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(222, 1, '29 January 2014 Notice of General Meeting', 'notice29jan14and salaries.pdf', 'notice29jan14and salaries.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(223, 1, '30 December 2013 Notice of General Meeting', 'notice30dec13.pdf', 'notice30dec13.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(224, 1, '29 November 2013 Notice of General Meeting', 'notice29nov13.pdf', 'notice29nov13.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(225, 1, '30 October 2013 Notice of General Meeting', 'notice30oct13.pdf', 'notice30oct13.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(226, 1, '27 September 2013 Notice of General Meeting', 'notice27sep13.pdf', 'notice27sep13.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(227, 1, '12 July 2013 Notice of General Meeting', 'notice12jul13.pdf', 'notice12jul13.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(228, 1, '27 May 2013 Notice of General Meeting', 'notice27may13.pdf', 'notice27may13.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(229, 1, '18 March 2013 Notice of General Meeting', 'notice18mar13.pdf', 'notice18mar13.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(230, 1, '21 February 2013 Notice of General Meeting', 'notice21feb13.pdf', 'notice21feb13.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(231, 1, '17 January 2013 Notice of General Meeting', 'notice17jan13.pdf', 'notice17jan13.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(232, 1, '20 December 2012 Notice of General Meeting', 'notice20dec12.pdf', 'notice20dec12.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(233, 1, '15 November 2012 Notice of General Meeting', 'notice15nov12.pdf', 'notice15nov12.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(234, 1, '01 October 2012 October Meetings Notice of General Meeting', 'Notice of meetings Oct 2012.pdf', 'Notice of meetings Oct 2012.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(235, 1, '13 July 2012 Notice of General Meeting', 'notice13jul12.pdf', 'notice13jul12.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(236, 1, '27 June 2012 Notice of General Meeting', 'notice27jun12.pdf', 'notice27jun12.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(237, 1, '24 April 2012 (Special) Notice of General Meeting', 'notice24apr01may2012.pdf', 'notice24apr01may2012.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(238, 1, '27 March 2012 Notice of General Meeting', 'notice27mar12.pdf', 'notice27mar12.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(239, 1, '31 January 2012 Notice of General Meeting', 'notice31jan12.pdf', 'notice31jan12.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(240, 1, '30 November 2011 Notice of General Meeting', 'notice30nov11.pdf', 'notice30nov11.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(241, 1, '7 November 2011 Notice of General Meeting', 'notice07nov11.pdf', 'notice07nov11.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(242, 1, '29 September 2011 Notice of General Meeting', 'notice29sep11.pdf', 'notice29sep11.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(243, 1, '29 March 2011 Notice of General Meeting', 'notice29mar11.pdf', 'notice29mar11.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(244, 1, '22 February 2011 Notice of General Meeting', 'notice22feb11.pdf', 'notice22feb11.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(245, 1, '25 January 2011 Notice of General Meeting', 'notice25jan11.pdf', 'notice25jan11.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(246, 1, '06 January 2011 (Special) Notice of General Meeting', 'notice06jan11.pdf', 'notice06jan11.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(247, 1, '14 December 2010 Notice of General Meeting', 'notice14dec10.pdf', 'notice14dec10.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(248, 1, '12 November 2010 Notice of General Meeting', 'notice12nov10.pdf', 'notice12nov10.pdf', 'meetings', '2020-01-14 09:44:03', '2020-01-14 09:44:03'),
(249, 1, '17 October 2010 Notice of General Meeting', 'notice17oct10.pdf', 'notice17oct10.pdf', 'meetings', '2020-01-14 09:44:04', '2020-01-14 09:44:04'),
(250, 1, '27 September 2010 Notice of General Meeting', 'notice27sep10.pdf', 'notice27sep10.pdf', 'meetings', '2020-01-14 09:44:04', '2020-01-14 09:44:04'),
(251, 1, '19 August 2010 Notice of General Meeting', 'notice19aug10.pdf', 'notice19aug10.pdf', 'meetings', '2020-01-14 09:44:04', '2020-01-14 09:44:04'),
(252, 1, '29 June 2010 Notice of General Meeting', 'notice29jun10.pdf', 'notice29jun10.pdf', 'meetings', '2020-01-14 09:44:04', '2020-01-14 09:44:04'),
(253, 1, '30 March 2010 Notice of General Meeting', 'notice30mar10.pdf', 'notice30mar10.pdf', 'meetings', '2020-01-14 09:44:04', '2020-01-14 09:44:04'),
(254, 1, '28 February 2010 Notice of General Meeting', 'notice30feb10.pdf', 'notice30feb10.pdf', 'meetings', '2020-01-14 09:44:04', '2020-01-14 09:44:04'),
(255, 1, '', 'NOM October 2019.pdf', 'mAdr4pOyIWBGco2ymc77xCURK5XW7uMP5lowPPaA.pdf', 'meetings', '2020-01-29 02:30:15', '2020-01-29 02:36:32'),
(256, 1, '', 'NOM May 2019.pdf', 'QVXB0Eg9CX3tAUQsrDILsyziF9B9sK5XpFXWJfee.pdf', 'meetings', '2020-01-29 02:31:52', '2020-01-29 02:37:14'),
(257, 1, 'March 2019 Notice of General Meeting.', 'NOM March 2019.pdf', 'C2WswjDWzEs85EqRtkT6J0d7O80KE94joZI4dAJJ.pdf', 'meetings', '2020-01-29 02:32:34', '2020-01-29 02:32:45'),
(258, 1, NULL, 'notice17jan13.pdf', 'WtphLFINiAL1T1ut9ivdueJQ9Ut2SOrGUEhUnk6w.pdf', 'meetings', '2020-01-29 02:47:52', '2020-01-29 02:47:52'),
(259, 1, NULL, 'notice17jan13.pdf', 'DcQjZtH6LHHL5g3UmAvu7H7mbNPjLepQqFJvrBo1.pdf', 'meetings', '2020-01-29 02:47:52', '2020-01-29 02:47:52'),
(260, 1, 'October 2016 Special Meeting - C&B Committee Report', 'CB Committee Report October 12 2016.pdf', 'ZYJfuMtMxtp48k0b36koAkSoTKir3H9W0jr8CVwK.pdf', 'meetings', '2020-01-29 02:50:25', '2020-01-29 02:50:30'),
(269, 1, 'Job Posting - Arts Club - Stagehand - Open Until Filled', 'ACTC Job Posting - Stagehand.pdf', 'fce107edf2e646cc33942016f94ac48f.pdf', 'employment', '2020-01-30 08:53:15', '2020-01-30 08:53:15'),
(270, 1, 'ONGOING: IATSE Local 118 Dispatcher Job Posting', 'Dispatch_job_posting_v02.pdf', 'fc88f1dc504d7c336ed6f5733ea2fbed.pdf', 'employment', '2020-01-30 08:53:15', '2020-01-30 08:53:15'),
(271, 1, 'Job Posting - Arts Club - Production Assistant - Open Until Filled', 'ACTC Job Posting - Production Assistant.pdf', 'a77d21f24cb40743d17856240b6b6b24.pdf', 'employment', '2020-01-30 08:53:16', '2020-01-30 08:53:16'),
(272, 1, 'The Cultch - Venue Technician', 'THE CULTCH IS HIRING Venue Technician 2020.pdf', '91a01dcd0d1d7ea448f3a6a372706316.pdf', 'employment', '2020-01-30 08:53:16', '2020-01-30 08:53:16'),
(273, 1, 'Job Posting - Arts Club - Head Electrician', 'ACTC.Job Posting.pdf', 'bc2c16877270882e9255ddb2af8c1f71.pdf', 'employment', '2020-01-30 08:53:17', '2020-01-30 08:53:17'),
(274, 1, 'Job Posting - The Cultch - Technical Director', 'The Cultch is hiring Technical Director.pdf', 'a8d2bcec31d0dfd2f34d8beb9e26a987.pdf', 'employment', '2020-01-30 08:53:18', '2020-01-30 08:53:18'),
(275, 1, 'Box Office Attendant - The Cultch', 'Culth.BOA.JD.pdf', 'e4f3677079683629422fd664ba72f2ca.pdf', 'employment', '2020-01-30 08:53:18', '2020-01-30 08:53:18'),
(276, 1, 'PTR Rental Technician - Arts Club', 'RentalTechnician.pdf', '8e33a6ccba5efa5ca4d69369b15fe94e.pdf', 'employment', '2020-01-30 08:53:19', '2020-01-30 08:53:19'),
(277, 1, 'Job Posting - Arts Club - Head Rental Technician', 'Job Posting Head Rental Technician - PTR.pdf', '60f7363ff5df9b86d961c92ea5033376.pdf', 'employment', '2020-01-30 08:53:19', '2020-01-30 08:53:19'),
(278, 1, 'Job Posting - Arts Club - 2nd Stage Carpenter', 'Job Posting 2nd Carpenter PTR.PDF', '39193d587b706670fbb837d8b8b4e336.pdf', 'employment', '2020-01-30 08:53:20', '2020-01-30 08:53:20'),
(279, 1, 'Job Posting - Arts Club - Stage Carpenter- Granville Island Stage', 'Job Posting - Stage Carpenter- Granville Island Stage.pdf', 'bf2c58b5773affcea98aa7a3de23b1ff.pdf', 'employment', '2020-01-30 08:53:20', '2020-01-30 08:53:20'),
(280, 1, 'Job Posting - VOA -Production Head of Hair', 'VOA_HeadofHair Posting_2018.pdf', '1988128217d51b5c7a75b80635dbf809.pdf', 'employment', '2020-01-30 08:53:21', '2020-01-30 08:53:21'),
(281, 1, 'NEW: Job Posting - ArtsClub - Granville Island Stage Carpenter (Carpenter/Dresser)', 'Stage Carpenter-Dresser - Granville Island Stage.pdf', '555bedee97b0643f6ff1760e86ed788d.pdf', 'employment', '2020-01-30 08:53:21', '2020-01-30 08:53:21'),
(282, 1, 'NEW: Job Posting - The Cultch - Box Office Assistant (part-time) and Box Office Assistant (casual)', 'The Cultch - Job Postings.pdf', 'c2ba4d653eadbff821682e78532aa4c9.pdf', 'employment', '2020-01-30 08:53:22', '2020-01-30 08:53:22'),
(283, 1, 'NEW: Job Posting - Arts Club Theatre - Stitcher &ndash; Production Costume Shop', 'Stitcher - Job Posting.pdf', '8e46cb8bbfec684cbf1591b29803d743.pdf', 'employment', '2020-01-30 08:53:23', '2020-01-30 08:53:23'),
(284, 1, 'NEW: Job Posting - ILWA Canada - Union Organizer', 'ILWA Canada Job Posting.pdf', 'ae00226e402b1be5a967c6d1ef705c7c.pdf', 'employment', '2020-01-30 08:53:23', '2020-01-30 08:53:23'),
(285, 1, 'NEW: Job Posting - BC Federation of Labour - 2 Full-time OHS Facilitator Coordinators, 1 Term OHS Facilitator Coordinator', 'BCFed Job Postings.pdf', 'e0c6e98788b68319865b0c08ff920b04.pdf', 'employment', '2020-01-30 08:53:24', '2020-01-30 08:53:24'),
(286, 1, 'NEW: Job Posting - Chan Centre for Performing Arts - Head Stage Carpenter', 'head stage tech job description July 5, 2018 UBCHR post.pdf', '1846d3bb4b78123d43aaa40691b3f08a.pdf', 'employment', '2020-01-30 08:53:24', '2020-01-30 08:53:24'),
(287, 1, 'NEW: Job Posting - The Cultch - Venue Technician', 'THE CULTCH IS HIRING Venue Technician.pdf', '07ab059951d7aa4bab0e7dcf3af064cd.pdf', 'employment', '2020-01-30 08:53:25', '2020-01-30 08:53:25'),
(288, 1, 'NEW: Job Posting - Kidd Pivot Wardrobe', 'Job Posting - Kidd Pivot Wardrobe.pdf', '903750504d8b66062537ecb90673f5cd.pdf', 'employment', '2020-01-30 08:53:25', '2020-01-30 08:53:25'),
(289, 1, 'Job Posting - Cultch FOHS casual 2017-18 season', 'Job Posting - Cultch FOHS casual 2017-18 season.pdf', 'c71c452b4c76fbde039815420a98ef56.pdf', 'employment', '2020-01-30 08:53:26', '2020-01-30 08:53:26'),
(290, 1, 'Job Posting - Cultch BOA casual 2017-18 season', 'Job Posting - Cultch BOA casual 2017-18 season.pdf', 'c37fff2a93ba1addc54b0026665b1912.pdf', 'employment', '2020-01-30 08:53:27', '2020-01-30 08:53:27'),
(291, 1, 'Job Posting - Gateway Head Sound', 'Job Posting - Gateway Head Sound Jan 2018.pdf', '91c6213d2f0e2779cc3d77f90123982c.pdf', 'employment', '2020-01-30 08:53:27', '2020-01-30 08:53:27'),
(292, 1, 'Job Posting - Cultch Venue Technician', 'Job Posting - Cultch Venue Tech 17-18.pdf', '36ab2cd149a6b3dacf11b09478731e9d.pdf', 'employment', '2020-01-30 08:53:28', '2020-01-30 08:53:28'),
(293, 1, 'Job Posting - ACT 2nd Electrician 2018', 'Job Posting - ACT 2nd Electrician 2018.pdf', '2b97bc9235a5454861a3dd4c01e289ed.pdf', 'employment', '2020-01-30 08:53:29', '2020-01-30 08:53:29'),
(294, 1, 'Job Posting - ACT - Theatre Rental Tech', 'Job Posting - ACT - Theatre Rental Tech Nov  14 2017.pdf', '1e863f01831d3c89aafa4482737fffe6.pdf', 'employment', '2020-01-30 08:53:29', '2020-01-30 08:53:29'),
(295, 1, 'Job Posting - ACT Head Dresser 2017', 'Job Posting - ACT Head Dresser 2017.pdf', '81ea067e2f1c6a1ab9b84c028e33169d.pdf', 'employment', '2020-01-30 08:53:30', '2020-01-30 08:53:30'),
(296, 1, 'Job Posting - ACT - Head of Sound Oct 2017', 'Job Posting - ACT - Head of Sound Oct 2017.pdf', '59f11c6bf60cbd81aefd0584c5f2dfb1.pdf', 'employment', '2020-01-30 08:53:30', '2020-01-30 08:53:30'),
(297, 1, 'Job Posting - ACT: Assistant Sound Oct 2017', 'Assistant Sound Arts Club Theatre Company September 2017.pdf', '316b562e7ad7e207a0b4cd96f378650f.pdf', 'employment', '2020-01-30 08:53:31', '2020-01-30 08:53:31'),
(298, 1, 'Job Posting - VSO - BC Tour Sept/Oct 2017', 'VSO - 2017 BC Tour Brief.pdf', 'b7d7352c11e6d1e6946d285057c8482a.pdf', 'employment', '2020-01-30 08:53:32', '2020-01-30 08:53:32'),
(299, 1, 'Job Posting - The Cultch Rentals ATD 2017-2018 Season', 'Job Posting - Cultch Rentals ATD_17-18season_August2017.pdf', '3ae08003b254efb9e9571933a62020b1.pdf', 'employment', '2020-01-30 08:53:32', '2020-01-30 08:53:32'),
(300, 1, 'Job Posting - The Cultch Venue Technician', 'Job Posting - Cultch Venue Technician_17-18season_August2017.pdf', '3a6a22d03dd855c9cccb899320261aa8.pdf', 'employment', '2020-01-30 08:53:33', '2020-01-30 08:53:33'),
(301, 1, 'Job Posting - ACT - Stanley Head Electrician', 'Job Posting - ACT - Head Electrician SIAS May 31 2017.pdf', '98ec749e7c8111d4243915e407d43c0b.pdf', 'employment', '2020-01-30 08:53:34', '2020-01-30 08:53:34'),
(302, 1, 'Job Posting - ACT - 2nd Stage Carpenter', 'Job Posting - ACT - 2nd Stage Carpenter.pdf', '9cb5eb87d45d3e0c9b2046390ba24e26.pdf', 'employment', '2020-01-30 08:53:34', '2020-01-30 08:53:34'),
(303, 1, 'Job Posting - ACT - Theatre Rental Tech', 'Job Posting ACT Theatre Rental Tech March 2017.pdf', '167e0ff5b8b88351a5713a6b805ae476.pdf', 'employment', '2020-01-30 08:53:35', '2020-01-30 08:53:35'),
(304, 1, 'ACT - 2nd Stage Carpenter', 'Job Posting - ACT - 2nd Stage Carpenter March 2017.pdf', '168d91374f52a156b8a0b8e32d260287.pdf', 'employment', '2020-01-30 08:53:35', '2020-01-30 08:53:35'),
(305, 1, 'ACT - Production Assistant', 'Job Posting - ACT - Production Assistant Jan 2017.pdf', '2dd90fca19bb864801d4724bb95025fd.pdf', 'employment', '2020-01-30 08:53:36', '2020-01-30 08:53:36'),
(306, 1, 'ACT - 2nd Electrician', 'Job Posting - ACT - 2nd Electrician 2017.pdf', '4d304df549a3093bb433e259f24569d6.pdf', 'employment', '2020-01-30 08:53:36', '2020-01-30 08:53:36'),
(307, 1, 'Stage Carpenter Stanley Stage', 'Job Posting - Stage Carpenter Stanley Stage.pdf', '4db7db1790c82d3b26a1ef87c4d22638.pdf', 'employment', '2020-01-30 08:53:37', '2020-01-30 08:53:37'),
(308, 1, 'Arts Club - Theatre Rental Technician', 'Job Posting - ACT - Theatre Rental Technician.pdf', '539c35604092c6c24d05c0cdf6e789c6.pdf', 'employment', '2020-01-30 08:53:38', '2020-01-30 08:53:38'),
(309, 1, 'Head Electrician - Stanley Theatre', 'Job Posting Head Electrician Stanley Theatre.pdf', '91b61231bc92f4428709c4556fe29e55.pdf', 'employment', '2020-01-30 08:53:38', '2020-01-30 08:53:38'),
(310, 1, 'IATSE Local 118 Office Bookkeeper Job Posting', 'Job Posting for Office Bookkeeper.pdf', '7e04828c5edd659d063a938e41a8456b.pdf', 'employment', '2020-01-30 08:53:39', '2020-01-30 08:53:39'),
(311, 1, 'Gateway Theatre Head Sound (Seasonal) job posting', 'Head of Sound-Gateway-job posting-2016.pdf', '4ede8442edb4a686bde93573987da970.pdf', 'employment', '2020-01-30 08:53:39', '2020-01-30 08:53:39'),
(312, 1, 'Vancouver Civic Theatres Head Sound', 'Civic Theatres Head Sound job posting.pdf', 'b84c5a2603d4b8fbb519b65d64431dcd.pdf', 'employment', '2020-01-30 08:53:40', '2020-01-30 08:53:40'),
(313, 1, 'Gateway Theatre Head Carp (Seasonal) job posting', 'Head Carpenter 2016 - Gateway Theatre.pdf', 'be1f08a7976ace37829543e2a36c9b33.pdf', 'employment', '2020-01-30 08:53:40', '2020-01-30 08:53:40'),
(314, 1, 'Gateway Theatre Head LX (Seasonal) job posting', 'Head LX 2016 - Gateway Theatre.pdf', '69c40626c90b35100c602d7383d40d6f.pdf', 'employment', '2020-01-30 08:53:41', '2020-01-30 08:53:41'),
(315, 1, 'RGT House Tech job posting', '2016 GT House Tech posting - July 19-2016.pdf', '4a693b3b0b3c10ff4295349f6737ccd0.pdf', 'employment', '2020-01-30 08:53:41', '2020-01-30 08:53:41'),
(316, 1, 'ACT Temporary Head Sound Job Posting', 'Head of Sound Arts Club Theatre Company Leave of Absence.pdf', 'f8a615b054f0277cc2a872bc6475ed08.pdf', 'employment', '2020-01-30 08:53:42', '2020-01-30 08:53:42'),
(317, 1, 'ACT Assistant Sound Job Posting', 'ACT Assistant Sound Job Posting 052616.pdf', '1fe1657e3ccb8a024be8f73681f93ae7.pdf', 'employment', '2020-01-30 08:53:42', '2020-01-30 08:53:42'),
(318, 1, 'RGT Job Posting - Tech Coordinator &amp; Props Design', 'RGT Job Posting - Tech Coordinator & Props Design.pdf', '29c6389c719ca751a1769dd7d1d5fe44.pdf', 'employment', '2020-01-30 08:53:42', '2020-01-30 08:53:42'),
(319, 1, 'VECC Production Electrician Job Posting 2016-17 Season', 'VECC Production Electrician Job Posting 2016-17 Season.pdf', '69935965667ce01f65aeb425cbace6bb.pdf', 'employment', '2020-01-30 08:53:43', '2020-01-30 08:53:43'),
(320, 1, 'Gateway Theatre House Tech Job Posting', '2015 GT House Tech IATSE Jan14-2016.pdf', '8820ae72c988603a2f51a5b6f777267c.pdf', 'employment', '2020-01-30 08:53:44', '2020-01-30 08:53:44'),
(321, 1, 'Arts Club Theatre - Head Dresser Job Posting', 'ACT Head Dresser Job Posting 2016.pdf', 'ec90becba2c4ad536e190000a8614157.pdf', 'employment', '2020-01-30 08:53:44', '2020-01-30 08:53:44'),
(332, 1, 'The Cultch - Box Office Attendant', 'The-Cultch-is-hiring-Box-Office-Attendant-casual-November-2019.pdf', 'pi1JwhrO8aEpB56XK41lEC3rS3EbYqH2KdrsanOL.pdf', 'employment', '2020-01-30 09:25:49', '2020-01-30 09:26:10'),
(333, 1, 'Richmond Gateway Theatre - Technical Director', 'Technical Director.pdf', 'Kyz5zyLtUR0z4ZEcthFye985IsMSXt1RYONtFIgJ.pdf', 'employment', '2020-01-30 09:28:08', '2020-01-30 09:28:15'),
(334, 1, NULL, 'uswork07.pdf', 'YE1ppyxJzBmr52SkgxpbS146lGSeyYmZDzoNwYEh.pdf', 'public', '2020-01-31 01:50:41', '2020-01-31 01:50:41'),
(335, 1, NULL, 'IATSE891.jpg', 'DIHtEnBDle1FBBsgROMvOLGZnRQQV3hyic6DrGo4.jpeg', 'employment', '2020-02-02 08:57:01', '2020-02-02 08:57:01'),
(336, 1, NULL, 'ACTC Job Posting - Goldcorp Stage Tech.pdf', '8HN8ASeECgvmERloMKEFmSvjFkyYIqIyy8Tgvmhm.pdf', 'employment', '2020-02-03 20:01:46', '2020-02-03 20:01:46'),
(337, 1, 'Arts Club Theatre 2016 - 2020 (ACT)', 'ACTC CBA 2016 - 2020.PDF', '59da9ec0c057138a4b5ce4b779cd7e34.pdf', 'agreements', '2020-03-10 01:06:57', '2020-03-10 01:06:57'),
(339, 1, 'Abbotsford Entertainment Centre 2017 - 2019', 'Abbotsford Entertainment Centre 2017 - 2019.pdf', '2d84e4046b744704ad1599e3f4628e2e.pdf', 'agreements', '2020-03-10 01:10:11', '2020-03-10 01:10:11'),
(340, 1, 'Ballet BC 2016 - 2019', 'Ballet BC_2016-2019.pdf', '1a18d040db712cff56c3a90c8e8dc7ab.pdf', 'agreements', '2020-03-10 01:10:12', '2020-03-10 01:10:12'),
(341, 1, 'Ballet BC 2019 - 2021 Memo of Agreement', 'BalletBC.MOA.2019-2021.pdf', '619072e6c6ca77d34d101f6172bf67d1.pdf', 'agreements', '2020-03-10 01:10:13', '2020-03-10 01:10:13'),
(342, 1, 'COV Collective Agreement 2016 - 2019', 'City of Vancouver 2016 - 2019.pdf', 'c74b77cadbcb607a1f74ed61e57541d0.pdf', 'agreements', '2020-03-10 01:10:22', '2020-03-10 01:10:22'),
(343, 1, 'COV Orpheum Annex agreement', 'COV Orpheum Annex agreement 121011.pdf', '8fd9d6a049dbfd56ea15a6b32fdc15d1.pdf', 'agreements', '2020-03-10 01:10:23', '2020-03-10 01:10:23'),
(344, 1, 'Fringe 2017 - 2019', 'Fringe 2017 - 2019.pdf', '54df8b7d942c948b7ae95863eaa2ad21.pdf', 'agreements', '2020-03-10 01:10:24', '2020-03-10 01:10:24'),
(345, 1, 'Global Spectrum agreement  2019 - 2023', 'Global Spectrum Agreement 2019 - 2023.pdf', 'd0a2992a5ee3f1d1c2daf0c222dde2c1.pdf', 'agreements', '2020-03-10 01:10:27', '2020-03-10 01:10:27'),
(346, 1, 'Live Nation Canada 2017 - 2020', 'Live Nation Canada Master 2017 - 2020.pdf', 'b09603e33f49f16f6727ed653ee00179.pdf', 'agreements', '2020-03-10 01:10:28', '2020-03-10 01:10:28'),
(347, 1, 'Master Casual Agreement', 'Master Casual Agreement 2011 - 2014.pdf', '4620529666f82cf226651713d7906252.pdf', 'agreements', '2020-03-10 01:10:28', '2020-03-10 01:10:28'),
(348, 1, 'Pacific National Exhibition agreement (PNE) 2014 - 2016', 'PNE- 2014-2016.pdf', '90e6044f62be8d669c2881b51e1a712a.pdf', 'agreements', '2020-03-10 01:10:29', '2020-03-10 01:10:29'),
(349, 1, 'Richmond Gateway Theatre 2019 - 2021', 'RGT - 2019 - 2021.pdf', '9e263fb44bb4182296eea5dc1020d3f8.pdf', 'agreements', '2020-03-10 01:10:31', '2020-03-10 01:10:31'),
(350, 1, 'Theatre Under The Stars (TUTS) 2018 - 2021', 'TUTS - 2018-2021 FINAL.pdf', '087bf9894bc58147019755f9c3291e06.pdf', 'agreements', '2020-03-10 01:10:32', '2020-03-10 01:10:32'),
(351, 1, 'Vancouver East Cultural Centre - FOH Agreement 2019 - 2021', 'VECC.FOH.2019-2021.pdf', 'd743747009f4dc6ea60a59b55fac252c.pdf', 'agreements', '2020-03-10 01:10:34', '2020-03-10 01:10:34'),
(352, 1, 'Vancouver East Cultural Centre Stage Agreements 2019 - 2021', 'VECC.Stage.2019-2021.pdf', '3db127f2c7b4e4ca2847ecbd7f9103d3.pdf', 'agreements', '2020-03-10 01:10:35', '2020-03-10 01:10:35'),
(353, 1, 'Vancouver Opera Association (VOA) 2016 - 2018', 'VOA 2016-2018.pdf', 'c6bd71e356a73836c1b8f1257dc38e13.pdf', 'agreements', '2020-03-10 01:10:36', '2020-03-10 01:10:36'),
(354, 1, 'Vancouver Opera Association (VOA) 2018 - 2019 Memo of Agreement', 'VOA.MOA.2018-2019.pdf', '7bc06f261da9d0c2b5a007be7006bed3.pdf', 'agreements', '2020-03-10 01:10:37', '2020-03-10 01:10:37'),
(355, 1, 'Vancouver Symphony Society (VSS) -   2018 - 2022', 'VSS 2018-2022.pdf', 'df11abc43e39457e6bb8050baca4e982.pdf', 'agreements', '2020-03-10 01:10:38', '2020-03-10 01:10:38'),
(356, 1, 'Vancouver Symphony Society (VSS) 2018 - 2022 Memo of Agreement', 'VSO.MOA.2018-2022.pdf', '2d7fe3cefd301be9d537653d63f22d51.pdf', 'agreements', '2020-03-10 01:10:40', '2020-03-10 01:10:40'),
(358, 1, 'Abbotsford Entertainment Centre MOS 2017', 'AESC MOS 2017.pdf', '9f15362d951c5b7d61864340b042f6ee.pdf', 'agreements', '2020-03-10 01:10:42', '2020-03-10 01:10:42'),
(360, 1, 'COV Collective Agreement 2012-2015', 'COV Collective Agreement 2012 - 2015.pdf', '1912d1e4f5d05461442f9c29c41ad8d4.pdf', 'agreements', '2020-03-10 01:10:44', '2020-03-10 01:10:44'),
(362, 1, 'Fringe', 'Fringe 2007-2009 - in negotiations.pdf', 'd602690e116a47d96df9e85157b15812.pdf', 'agreements', '2020-03-10 01:10:46', '2020-03-10 01:10:46'),
(363, 1, 'Global Spectrum agreement 2016-2019', 'Global Spectrum Agreement 2016-2019.pdf', '36ec733bd717bce34445f7809c77c3e3.pdf', 'agreements', '2020-03-10 01:10:50', '2020-03-10 01:10:50');
INSERT INTO `attachments` (`id`, `user_id`, `description`, `file_name`, `file`, `subfolder`, `created_at`, `updated_at`) VALUES
(367, 1, 'Richmond Gateway Theatre 2016-2018', 'RGT - COLLECTIVE AGREEMENT 2016 - 2018.pdf', '3db616818410d74be176d3ce0f3d7e97.pdf', 'agreements', '2020-03-10 01:10:54', '2020-03-10 01:10:54'),
(368, 1, 'Vancouver East Cultural Centre - FOH Agreement 2012 - 2017', 'VECCFOH2012-2017.pdf', '1c1c94020e0f2d7703faf2dc17d03bb0.pdf', 'agreements', '2020-03-10 01:10:55', '2020-03-10 01:10:55'),
(369, 1, 'Vancouver East Cultural Centre Stage Agreements 2012-2017', 'VECCStage2012-2017.pdf', '5f36fd3039957203b7661198621b73f6.pdf', 'agreements', '2020-03-10 01:10:56', '2020-03-10 01:10:56'),
(370, 1, 'Vancouver Opera Association (VOA) 2016-2018', 'VOA 2016-2018.pdf', '1523a0f720f767ba71e483db00af6870.pdf', 'agreements', '2020-03-10 01:10:57', '2020-03-10 01:10:57'),
(371, 1, 'Vancouver Symphony Society (VSS) -  2014-2018', 'VSS 2014-2018.pdf', 'fadcf753fbcba4ec590a282ae3c54e3c.pdf', 'agreements', '2020-03-10 01:10:58', '2020-03-10 01:10:58'),
(398, 1, 'Constitution and By-Laws October 23, 2019', 'Constitution and By-Laws October 23, 2019.pdf', 'f694c926a215da5899977203cd021a80.pdf', 'bylaws', '2020-03-10 09:20:42', '2020-03-10 09:20:42'),
(399, 1, 'C&B Amendment Proposals June 2019', 'C&B.Amendment.Proposals.June.2019.pdf', '5ef11542458650dd14bad661cde232bd.pdf', 'bylaws', '2020-03-10 09:20:43', '2020-03-10 09:20:43'),
(400, 1, 'Constitution and By-Laws June 27, 2018', 'Constitution and By-Laws June 27, 2018.pdf', 'b6d1b7ca28aabc97976134cbda432bd9.pdf', 'bylaws', '2020-03-10 09:20:44', '2020-03-10 09:20:44'),
(401, 1, 'Constitution and By-Laws Committee Report March 2018', 'March 2018 CB Ctte SGM Report.pdf', '13c9748d8efc0130c952a87d69832dae.pdf', 'bylaws', '2020-03-10 09:20:45', '2020-03-10 09:20:45'),
(402, 1, 'Constitution and By-Laws August 1, 2017', 'Constitution and By-Laws August 1, 2017.pdf', '7ee205a689b53835b5f5103ae7916d1c.pdf', 'bylaws', '2020-03-10 09:20:45', '2020-03-10 09:20:45'),
(403, 1, 'Constitution and By-Laws Committee Report Oct 12, 2016', 'CB Committee Report October 12 2016.pdf', 'fcc9f7ae1df65c77deb668b82e0abc3c.pdf', 'bylaws', '2020-03-10 09:20:46', '2020-03-10 09:20:46'),
(404, 1, 'Constitution and By-Laws 2015 Website Version rev 13 Oct 2015', 'Constitution and By-Laws 2015 Website Version rev 13oct2015.pdf', '8c2848c9796e3ddae993cf16883f97ac.pdf', 'bylaws', '2020-03-10 09:20:46', '2020-03-10 09:20:46'),
(405, 1, 'Constitution and By-Laws Committee Report to the Membership June 16, 2015', 'C&B Committee Report (Typo Corrected) June 16, 2015.pdf', 'b01a9cf3cc8f4462ffd22541582b8f00.pdf', 'bylaws', '2020-03-10 09:20:47', '2020-03-10 09:20:47'),
(406, 1, 'Constitution and By-Laws amendments oct 2014', 'CandB ammendments oct 2014.pdf', 'c86d9ee10979868fa483489e9afc1bc7.pdf', 'bylaws', '2020-03-10 09:20:47', '2020-03-10 09:20:47'),
(407, 1, 'Constitution and By-Laws Committee Report May 2013', 'Constitution and By-Laws Committee Report May 2013.pdf', 'd2ebf0a6f1f5d12d8179c6b68ef1b603.pdf', 'bylaws', '2020-03-10 09:20:48', '2020-03-10 09:20:48'),
(408, 1, 'Constitution and By-Laws 2013', 'Constitution and By-Laws 2013.pdf', 'ac784cbc01c4829143e9cc8ffe0858e2.pdf', 'bylaws', '2020-03-10 09:20:49', '2020-03-10 09:20:49'),
(409, 1, 'Constitution and By-Laws 2012', 'Constitution and By-Laws 2012.pdf', '51d04d5b2ee7d107097313c9b6221a59.pdf', 'bylaws', '2020-03-10 09:20:49', '2020-03-10 09:20:49');

-- --------------------------------------------------------

--
-- Table structure for table `attachment_agreement`
--

DROP TABLE IF EXISTS `attachment_agreement`;
CREATE TABLE `attachment_agreement` (
  `attachment_id` bigint(20) UNSIGNED NOT NULL,
  `agreement_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attachment_agreement`
--

INSERT INTO `attachment_agreement` (`attachment_id`, `agreement_id`) VALUES
(337, 1),
(339, 3),
(340, 4),
(341, 5),
(342, 6),
(343, 7),
(344, 8),
(345, 9),
(346, 10),
(347, 11),
(348, 12),
(349, 13),
(350, 14),
(351, 15),
(352, 16),
(353, 17),
(354, 18),
(355, 19),
(356, 20),
(358, 22),
(360, 24),
(362, 26),
(363, 27),
(367, 31),
(368, 32),
(369, 33),
(370, 34),
(371, 35);

-- --------------------------------------------------------

--
-- Table structure for table `attachment_bylaw`
--

DROP TABLE IF EXISTS `attachment_bylaw`;
CREATE TABLE `attachment_bylaw` (
  `attachment_id` bigint(20) UNSIGNED NOT NULL,
  `bylaw_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attachment_bylaw`
--

INSERT INTO `attachment_bylaw` (`attachment_id`, `bylaw_id`) VALUES
(398, 1),
(399, 2),
(400, 3),
(401, 4),
(402, 5),
(403, 6),
(404, 7),
(405, 8),
(406, 9),
(407, 10),
(408, 11),
(409, 12);

-- --------------------------------------------------------

--
-- Table structure for table `bylaws`
--

DROP TABLE IF EXISTS `bylaws`;
CREATE TABLE `bylaws` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `access_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'members',
  `live` tinyint(1) NOT NULL DEFAULT '1',
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bylaws`
--

INSERT INTO `bylaws` (`id`, `user_id`, `title`, `description`, `access_level`, `live`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Constitution and By-Laws October 23, 2019', 'Constitution and By-Laws October 23, 2019', 'members', 1, '2019-10-23', '2020-03-10 09:20:42', '2020-03-10 09:20:42'),
(2, 1, 'C&B Amendment Proposals June 2019', 'C&B Amendment Proposals June 2019', 'members', 1, '2019-06-13', '2020-03-10 09:20:43', '2020-03-10 09:20:43'),
(3, 1, 'Constitution and By-Laws June 27, 2018', 'Constitution and By-Laws June 27, 2018', 'members', 1, '2018-06-27', '2020-03-10 09:20:44', '2020-03-10 09:20:44'),
(4, 1, 'Constitution and By-Laws Committee Report March 2018', 'Constitution and By-Laws Committee Report March 2018', 'members', 1, '2018-03-01', '2020-03-10 09:20:44', '2020-03-10 09:20:44'),
(5, 1, 'Constitution and By-Laws August 1, 2017', 'Constitution and By-Laws August 1, 2017', 'members', 1, '2017-08-01', '2020-03-10 09:20:45', '2020-03-10 09:20:45'),
(6, 1, 'Constitution and By-Laws Committee Report Oct 12, 2016', 'Constitution and By-Laws Committee Report Oct 12, 2016', 'members', 1, '2016-10-12', '2020-03-10 09:20:46', '2020-03-10 09:20:46'),
(7, 1, 'Constitution and By-Laws 2015 Website Version rev 13 Oct 2015', 'Constitution and By-Laws 2015 Website Version rev 13 Oct 2015', 'members', 1, '2015-10-13', '2020-03-10 09:20:46', '2020-03-10 09:20:46'),
(8, 1, 'Constitution and By-Laws Committee Report to the Membership June 16, 2015', 'Constitution and By-Laws Committee Report to the Membership June 16, 2015', 'members', 1, '2015-06-16', '2020-03-10 09:20:47', '2020-03-10 09:20:47'),
(9, 1, 'Constitution and By-Laws amendments oct 2014', 'Constitution and By-Laws amendments oct 2014', 'members', 1, '2014-10-02', '2020-03-10 09:20:47', '2020-03-10 09:20:47'),
(10, 1, 'Constitution and By-Laws Committee Report May 2013', 'Constitution and By-Laws Committee Report May 2013', 'members', 1, '2013-05-01', '2020-03-10 09:20:48', '2020-03-10 09:20:48'),
(11, 1, 'Constitution and By-Laws 2013', 'Constitution and By-Laws 2013', 'members', 1, '2013-07-30', '2020-03-10 09:20:49', '2020-03-10 09:20:49'),
(12, 1, 'Constitution and By-Laws 2012', 'Constitution and By-Laws 2012', 'members', 1, '2012-05-04', '2020-03-10 09:20:49', '2020-03-10 09:20:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_03_18_143208_create_topics_table', 2),
(5, '2019_03_25_083736_update_topics_table', 3),
(6, '2019_03_26_014200_create_sessions_table', 4),
(7, '2018_08_08_100000_create_telescope_entries_table', 5),
(8, '2019_04_01_025748_update_topics_columns', 6),
(9, '2019_04_01_065401_update_topic_column_scope', 6),
(10, '2019_04_10_234053_create_permission_tables', 7),
(11, '2014_01_07_073615_create_tagged_table', 8),
(12, '2014_01_07_073615_create_tags_table', 8),
(13, '2016_06_29_073615_create_tag_groups_table', 8),
(14, '2016_06_29_073615_update_tags_table', 8),
(15, '2019_04_16_014351_create_pages_table', 9),
(16, '2019_05_22_090736_users_phone', 10),
(17, '2019_05_22_085522_user_info', 11),
(18, '2019_05_22_090722_users_address', 12),
(19, '2019_05_22_092813_users_membership', 12),
(20, '2019_06_03_021943_add_user_to_pages', 13),
(21, '2019_06_03_072153_add_user_to_topics', 14),
(22, '2019_06_04_205659_alter_users_info', 15),
(23, '2019_06_04_211232_alter_memberships', 16),
(24, '2019_06_06_204333_create_attachments_table', 17),
(25, '2019_08_19_000000_create_failed_jobs_table', 17),
(26, '2019_09_10_075444_create_venues_table', 17),
(27, '2019_10_24_062043_create_page_topic_pivot_table', 18),
(38, '2019_10_25_021307_create_posts_table', 19),
(39, '2019_10_25_021338_create_posts_topic_pivot_table', 19),
(40, '2019_10_25_065951_create_page_posts_pivot_table', 19),
(42, '2019_11_06_011237_update_attachments_table', 20),
(44, '2019_11_13_052622_update_venues_table', 21),
(46, '2019_11_13_090953_update_users_info_table', 22),
(47, '2019_11_16_075308_add_preference_columns_to_users_info_table', 23),
(53, '2019_11_18_002749_create_committees_table', 24),
(54, '2019_11_21_024726_create_users_committees_pivot_table', 24),
(55, '2019_11_26_004818_update_users_committees_pivot_table', 25),
(56, '2019_11_26_004840_update_committees_table', 25),
(57, '2019_11_26_025351_delete_page_post', 26),
(58, '2019_11_29_225554_update_commttee_user', 27),
(62, '2019_12_03_224246_remove_image_columns', 28),
(63, '2019_12_04_002933_create_committee_posts_table', 29),
(64, '2019_12_04_003434_create_committe_posts_comments_table', 29),
(65, '2019_12_13_005615_create_table_organizations', 30),
(72, '2020_01_08_045020_create_meetings_table', 31),
(73, '2020_01_08_051731_create_meeting_attachments_table', 31),
(74, '2020_01_21_071359_create_attachment_meeting_table', 32),
(75, '2020_01_21_083237_add_file_column_to_attachments_table', 33),
(76, '2020_01_28_033918_add_description_subfolder_to_attachments_table', 34),
(77, '2020_01_29_030750_drop_meeting_attachments_table', 35),
(78, '2020_01_29_032225_create_employment_table', 36),
(79, '2020_01_29_221711_create_attachment_employment_table', 36),
(84, '2020_02_29_021436_create_invite_users_table', 37),
(86, '2020_02_21_001608_create_agreements_table', 38),
(87, '2020_03_10_004803_create_attachment_agreement_table', 39),
(88, '2020_03_10_013428_create_bylaws_table', 40),
(89, '2020_03_10_013444_create_attachment_bylaw_table', 40);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agreements`
--
ALTER TABLE `agreements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agreements_user_id_foreign` (`user_id`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_user_id_foreign` (`user_id`);

--
-- Indexes for table `attachment_agreement`
--
ALTER TABLE `attachment_agreement`
  ADD KEY `attachment_agreement_attachment_id_index` (`attachment_id`),
  ADD KEY `attachment_agreement_agreement_id_index` (`agreement_id`);

--
-- Indexes for table `attachment_bylaw`
--
ALTER TABLE `attachment_bylaw`
  ADD KEY `attachment_bylaw_attachment_id_index` (`attachment_id`),
  ADD KEY `attachment_bylaw_bylaw_id_index` (`bylaw_id`);

--
-- Indexes for table `bylaws`
--
ALTER TABLE `bylaws`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bylaws_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agreements`
--
ALTER TABLE `agreements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=410;

--
-- AUTO_INCREMENT for table `bylaws`
--
ALTER TABLE `bylaws`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agreements`
--
ALTER TABLE `agreements`
  ADD CONSTRAINT `agreements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `attachment_agreement`
--
ALTER TABLE `attachment_agreement`
  ADD CONSTRAINT `attachment_agreement_agreement_id_foreign` FOREIGN KEY (`agreement_id`) REFERENCES `agreements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attachment_agreement_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attachment_bylaw`
--
ALTER TABLE `attachment_bylaw`
  ADD CONSTRAINT `attachment_bylaw_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attachment_bylaw_bylaw_id_foreign` FOREIGN KEY (`bylaw_id`) REFERENCES `bylaws` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bylaws`
--
ALTER TABLE `bylaws`
  ADD CONSTRAINT `bylaws_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
