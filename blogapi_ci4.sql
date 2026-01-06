-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jan 05, 2026 at 01:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blogapi_ci4`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-01-01-000001', 'CreatePostsCategory', 'default', 'App', 1767252853, 0),
(2, '2026-01-01-000002', 'CreatePosts', 'default', 'App', 1767252853, 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `pid` int(11) NOT NULL,
  `p_title` varchar(255) NOT NULL,
  `p_descr` text DEFAULT NULL,
  `cat_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`pid`, `p_title`, `p_descr`, `cat_id`, `created_at`, `updated_at`) VALUES
(1, 'How Tiny Habits Lead to Big Changes', 'A practical guide to building sustainable routines by focusing on small, repeatable actions. Includes examples, a 21-day starter plan and tips for tracking progress.', 1, '2025-12-30 16:36:16', '2025-12-31 08:07:56'),
(2, 'A Beginner’s Guide to Ethical AI in Daily Life', 'Demystifies AI ethics for non-experts with plain-language explanations, real-world scenarios, and quick steps to use AI responsibly at work and home.', 2, '2025-12-30 16:36:16', '2025-12-30 16:36:16'),
(3, 'Unlocking Your Inner Critic\'s Power', 'Discover how to reframe self-doubt as a tool for growth, with journaling prompts, mindset shifts from psychology research, and real-life stories of transformation.', 1, '2025-12-30 23:25:00', '2025-12-30 23:25:00'),
(5, 'Benefits of waking up at 5am', 'Waking up at 5 a.m. can lead to a more structured, productive, and less stressful day by providing quiet time for personal activities before responsibilities begin.', 1, '2026-01-01 13:43:47', '2026-01-01 13:43:47'),
(7, 'ODIs without Rohit & Virat?', 'ODIs without Ro-Ko? A tough future ahead — BCCI sounds alarm on post Rohit Sharma & Virat Kohli.', 3, '2026-01-01 23:35:13', '2026-01-01 18:08:48'),
(8, 'New Intel Core Ultra CPUs on the way', 'Intel reportedly ready to announce three new Core Ultra desktop CPUs at CES 2026 from January 6-9. Alongside these desktop processors, Intel is also set to introduce its next laptop chip line, known as Core Ultra Series 3, based on the Panther Lake architecture – the mobile line-up was leaked back in October...', 2, '2026-01-05 17:46:05', '2026-01-05 12:23:24'),
(9, 'India team announced for ICC Men\'s T20 World Cup 2026', 'Suryakumar Yadav will lead India as they seek to become the first side to win back-to-back ICC Men\'s T20 World Cups.', 3, '2026-01-05 17:50:16', '2026-01-05 12:21:44');

-- --------------------------------------------------------

--
-- Table structure for table `posts_category`
--

CREATE TABLE `posts_category` (
  `cid` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts_category`
--

INSERT INTO `posts_category` (`cid`, `cat_name`) VALUES
(1, 'Personal Development'),
(2, 'Technology'),
(3, 'Sports');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `fk_post_cid` (`cat_id`);

--
-- Indexes for table `posts_category`
--
ALTER TABLE `posts_category`
  ADD PRIMARY KEY (`cid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts_category`
--
ALTER TABLE `posts_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_post_cid` FOREIGN KEY (`cat_id`) REFERENCES `posts_category` (`cid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
