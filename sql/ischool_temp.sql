-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2021 at 08:21 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ischool_temp`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `source_id` int(11) NOT NULL,
  `date_time_did` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_extension` varchar(255) NOT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `last_date_time_online` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `middle_name`, `last_name`, `gender`, `birthday`, `email`, `email_extension`, `mobile_number`, `username`, `password`, `profile_picture`, `last_date_time_online`) VALUES
(1, 'Desiree Anne', 'Sardido', 'Flores', 'Female', '1998-06-05', 'desiree', 'gmail.com', '09085285670', 'desiree_flores', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/20170130173105.jpg', '2017-07-27 17:55:05');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_time_posted` datetime NOT NULL,
  `version` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_comments`
--

CREATE TABLE `announcement_comments` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `date_time_commented` datetime NOT NULL,
  `version` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_comment_likes`
--

CREATE TABLE `announcement_comment_likes` (
  `id` int(11) NOT NULL,
  `announcement_comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_likes`
--

CREATE TABLE `announcement_likes` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_replies`
--

CREATE TABLE `announcement_replies` (
  `id` int(11) NOT NULL,
  `announcement_comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `date_time_replied` datetime NOT NULL,
  `version` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_reply_likes`
--

CREATE TABLE `announcement_reply_likes` (
  `id` int(11) NOT NULL,
  `announcement_reply_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `date_time_created` datetime NOT NULL,
  `date_time_published` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `version` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submissions`
--

CREATE TABLE `assignment_submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `date_time_assigned` datetime DEFAULT NULL,
  `date_time_submitted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `backpack`
--

CREATE TABLE `backpack` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `date_time_added` datetime NOT NULL,
  `version` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `classrooms`
--

CREATE TABLE `classrooms` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `date_time_created` datetime NOT NULL,
  `is_review_open` tinyint(1) NOT NULL DEFAULT 0,
  `date_end` date NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `classrooms_reviews`
--

CREATE TABLE `classrooms_reviews` (
  `id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `rate_1` varchar(3) NOT NULL,
  `rate_2` varchar(3) NOT NULL,
  `rate_3` varchar(3) NOT NULL,
  `rate_4` varchar(3) NOT NULL,
  `rate_5` varchar(3) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `rate` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `classroom_student_designation`
--

CREATE TABLE `classroom_student_designation` (
  `id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `pending` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group_chats`
--

CREATE TABLE `group_chats` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_time_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group_chat_members`
--

CREATE TABLE `group_chat_members` (
  `id` int(11) NOT NULL,
  `group_chat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group_chat_messages`
--

CREATE TABLE `group_chat_messages` (
  `id` int(11) NOT NULL,
  `group_chat_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `other_id` int(11) NOT NULL,
  `is_sender` tinyint(1) NOT NULL DEFAULT 0,
  `value` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_time_sent` datetime NOT NULL,
  `date_time_received` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_in_history`
--

CREATE TABLE `log_in_history` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `date_time_log_in` datetime NOT NULL,
  `date_time_log_out` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `date_time_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materials_reviews`
--

CREATE TABLE `materials_reviews` (
  `id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `rate_1` varchar(3) NOT NULL,
  `rate_2` varchar(3) NOT NULL,
  `rate_3` varchar(3) NOT NULL,
  `rate_4` varchar(3) NOT NULL,
  `rate_5` varchar(3) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `rate` varchar(3) NOT NULL,
  `anonymous` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `other_id` int(11) NOT NULL,
  `is_sender` tinyint(1) NOT NULL,
  `value` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_time_sent` datetime NOT NULL,
  `date_time_received` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `caption` longtext NOT NULL,
  `date_time_posted` datetime NOT NULL,
  `version` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `doer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `source_id` int(11) NOT NULL,
  `date_time_did` datetime NOT NULL,
  `received` tinyint(1) NOT NULL DEFAULT 0,
  `seen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `type_id` int(11) NOT NULL,
  `duration_id` int(11) NOT NULL,
  `quiz_all` tinyint(1) NOT NULL DEFAULT 1,
  `date_time_created` datetime NOT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `date_time_published` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `version` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_durations`
--

CREATE TABLE `quiz_durations` (
  `id` int(11) NOT NULL,
  `time` time NOT NULL,
  `value` varchar(255) NOT NULL,
  `seconds` int(11) NOT NULL DEFAULT 60
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_durations`
--

INSERT INTO `quiz_durations` (`id`, `time`, `value`, `seconds`) VALUES
(1, '00:15:00', '15 mins', 900),
(2, '00:20:00', '20 mins', 1200),
(3, '00:25:00', '25 mins', 1500),
(4, '00:30:00', '30 mins', 1800),
(5, '00:45:00', '45 mins', 2700),
(6, '01:00:00', '1 hr', 3600);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question_choices`
--

CREATE TABLE `quiz_question_choices` (
  `id` int(11) NOT NULL,
  `quiz_question_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `correct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_submissions`
--

CREATE TABLE `quiz_submissions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `date_time_assigned` datetime DEFAULT NULL,
  `date_time_took` datetime DEFAULT NULL,
  `date_time_done` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_types`
--

CREATE TABLE `quiz_types` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_types`
--

INSERT INTO `quiz_types` (`id`, `value`) VALUES
(1, 'Multiple Choice'),
(2, 'True/False'),
(3, 'Identification');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_extension` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `last_date_time_online` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `type`, `first_name`, `middle_name`, `last_name`, `gender`, `birthday`, `email`, `email_extension`, `mobile_number`, `username`, `password`, `profile_picture`, `last_date_time_online`) VALUES
(1, 'Student', 'Jamel', 'Natalio', 'Cagampang', 'Male', '1997-10-25', 'cagampang', 'yahoo.com', '091230696889', 'painlover25', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/120170921124404.jpg', '2021-01-09 15:15:25'),
(2, 'Student', 'Zeah Mae', 'Galve', 'Colarat', 'Female', '2017-08-31', 'zeyuuuuh', 'yahoo.com', '09123069689', 'zeyuuuuh', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/220170921124727.jpg', '2020-12-29 15:31:24'),
(3, 'Student', 'Desiree Anne', 'Sardido', 'Flores', 'Female', '1998-06-05', 'desiree', 'gmail.com', '09085285670', 'desiree_flores', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/20170130173105.jpg', '2017-10-04 16:08:00'),
(4, 'Student', 'Kenneth', 'Baldado', 'Ybanez', 'Male', '1997-06-13', 'hyperfire13', '', NULL, 'kenneth', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/20170130174118.jpg', '2017-09-20 01:54:20'),
(5, 'Student', 'Ian Jasper', 'Rebana', 'Benito', 'Male', '1997-03-03', 'ian', '', NULL, 'ian_jasper', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/20170131020813.jpg', '2017-10-02 15:49:03'),
(6, 'Student', 'Marry Joy', 'Palomar', 'Udto', 'Female', '1997-09-09', 'udto', '', NULL, 'marry_joy', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/20170205162914.jpg', '2017-10-02 15:54:54'),
(7, 'Teacher', 'Noreen', 'M', 'Arcangel', 'Female', '1997-10-25', 'noreen', 'gmail.com', NULL, 'noreen', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/noreen.jpg', '2020-12-26 23:37:36'),
(8, 'Teacher', 'Randy', 'Reyes', 'Otero', 'Male', '1990-10-25', 'randy_otero', 'gmail.com', '09306192586', 'randy_otero', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/820170921122344.jpg', '2021-01-03 20:48:13'),
(9, 'Student', 'Christine', 'Ubando', 'Danos', 'Female', NULL, NULL, NULL, NULL, 'christine', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/christine.jpg', '2017-10-02 16:06:25'),
(10, 'Student', 'James Albert', 'San Juan', 'Salva', 'Male', NULL, NULL, NULL, NULL, 'albert', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/albert.jpg', '2017-10-02 16:15:10'),
(11, 'Student', 'Alexie', 'Gapasinao', 'Ceromines', 'Female', NULL, NULL, NULL, NULL, 'alexie', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/alexie.jpg', '2017-10-02 15:57:48'),
(12, 'Student', 'Anthony', 'Jaluag', 'Alegado', 'Male', NULL, NULL, NULL, NULL, 'anthony', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/anthony.jpg', '2017-10-02 15:42:34'),
(13, 'Student', 'Christian', 'Villabesa', 'Belarde', 'Male', NULL, NULL, NULL, NULL, 'belarde', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/belarde.jpg', '2017-10-02 15:46:36'),
(14, 'Student', 'Christine Nicole', 'Carillo', 'Carillo', 'Female', NULL, NULL, NULL, NULL, 'carillo', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/carillo.jpg', '2017-10-02 16:18:12'),
(15, 'Student', 'Caroline', 'Gascon', 'Gascon', 'Female', NULL, NULL, NULL, NULL, 'caroline', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/caroline.jpg', '2017-10-02 16:53:25'),
(16, 'Teacher', 'Racquel', 'cortez', 'Cortez', 'Female', NULL, NULL, NULL, NULL, 'racquel', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/cortez.jpg', '2017-09-23 07:28:56'),
(17, 'Student', 'Danica', 'Lacbayo', 'Lacbayo', 'Female', NULL, NULL, NULL, NULL, 'danica', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/danica.jpg', '2017-10-02 15:46:14'),
(18, 'Student', 'Daryl Ena', 'Isidoro', 'Rufila', 'Female', NULL, NULL, NULL, NULL, 'daryl_ena', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/daryl.jpg', '2017-10-02 16:03:23'),
(19, 'Student', 'Alvin', 'Cortez', 'Dreo', 'Male', NULL, NULL, NULL, NULL, 'alvin_dreo', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/dreo.jpg', '2017-10-02 16:17:16'),
(20, 'Student', 'Maria Elena', 'Navarroza', 'Navarroza', 'Female', NULL, NULL, NULL, NULL, 'navarroza', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/elena.jpg', '2017-09-13 03:31:41'),
(21, 'Student', 'Jamie Anne', 'Sumpay', 'Garchitorena', 'Female', NULL, NULL, NULL, NULL, 'jamie_anne', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/jamie.jpg', '2017-09-13 03:32:20'),
(22, 'Student', 'Jeraldine', 'Reyes', 'Reyes', 'Female', NULL, NULL, NULL, NULL, 'jeraldine', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/jeraldine.jpg', '2017-10-02 15:57:11'),
(23, 'Student', 'Jessa', 'Zacarias', 'Zacarias', 'Female', NULL, NULL, NULL, NULL, 'zacarias', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/jessa.jpg', '2017-09-13 03:33:21'),
(24, 'Student', 'Jo Ann Michellin', 'Cruz', 'Cruz', 'Female', NULL, NULL, NULL, NULL, 'joann_michellin', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/joann.jpg', '2017-10-02 16:03:03'),
(25, 'Student', 'Jonas', 'Milante', 'Pastorpide', 'Male', NULL, NULL, NULL, NULL, 'pastorpide', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/jonas.jpg', '2017-09-13 03:34:52'),
(26, 'Student', 'John Karlo', 'Pena', 'Dela Pena', 'Male', NULL, NULL, NULL, NULL, 'john_karlo', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/karlo.jpg', '2017-10-02 16:16:12'),
(27, 'Student', 'Kathleen', 'Magnampo', 'Tandoc', 'Female', NULL, NULL, NULL, NULL, 'kathleen', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/kate.jpg', '2017-10-02 15:52:51'),
(28, 'Student', 'Khrisna Joy', 'Ocampo', 'Saavedra', 'Female', NULL, NULL, NULL, NULL, 'khrisna', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/khrisna.jpg', '2017-09-13 03:36:56'),
(29, 'Student', 'Kimberly Shane', 'Gico', 'Gico', 'Female', NULL, NULL, NULL, NULL, 'kimberly', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/kim.jpg', '2017-09-13 03:37:27'),
(30, 'Student', 'Klarinda', 'Pangan', 'Pangan', 'Female', NULL, NULL, NULL, NULL, 'klarinda', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/klarinda.jpg', '2017-09-13 03:37:57'),
(31, 'Student', 'Lyka', 'Alayo', 'Estrellanes', 'Female', NULL, NULL, NULL, NULL, 'lykiekookie', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/lyka.jpg', '2017-09-13 03:38:44'),
(32, 'Student', 'Mariz', 'Abello', 'Abello', 'Female', NULL, NULL, NULL, NULL, 'abello', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/mariz.jpg', '2017-10-02 15:42:49'),
(33, 'Student', 'Marvin', 'Giganto', 'Wong', 'Male', NULL, NULL, NULL, NULL, 'marvin', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/marvin.jpg', '2017-09-13 19:14:22'),
(34, 'Student', 'Mathew', 'Ferrera', 'Ramirez', 'Male', NULL, NULL, NULL, NULL, 'mathew', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/mathew.jpg', '2017-09-13 03:40:42'),
(35, 'Student', 'Michelle', 'Abarientos', 'Villadolid', 'Female', NULL, NULL, NULL, NULL, 'michelle', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/michelle.jpg', '2017-10-02 16:00:37'),
(36, 'Student', 'John Carlo', 'Oliver', 'Oliver', 'Male', NULL, NULL, NULL, NULL, 'oliver', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/oliver.jpg', '2017-10-02 15:49:35'),
(37, 'Student', 'John Patrick', 'Requillas', 'Requillas', 'Male', NULL, NULL, NULL, NULL, 'patrick', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/patrick.jpg', '2017-10-02 15:39:54'),
(38, 'Student', 'Remiel', 'Fernandez', 'Marvida', 'Male', NULL, NULL, NULL, NULL, 'remiel', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/rem.jpg', '2017-09-13 03:43:39'),
(39, 'Teacher', 'Riegie', 'Dy', 'Tan', 'Male', NULL, NULL, NULL, NULL, 'riegie', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/riegietan.jpg', '2017-10-04 15:25:04'),
(40, 'Student', 'Rosejyn', 'Gimoto', 'Gimoto', 'Female', NULL, NULL, NULL, NULL, 'rosejyn', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/rosejyn.jpg', '2017-09-13 03:44:33'),
(41, 'Student', 'Mary Joy', 'Dreu', 'Sale', 'Female', NULL, NULL, NULL, NULL, 'mary_joy', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/sale.jpg', '2017-09-13 03:45:11'),
(42, 'Student', 'Seiji', 'Bitare', 'Bitare', 'Male', NULL, NULL, NULL, NULL, 'bitare', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/seiji.jpg', '2017-09-13 03:45:49'),
(43, 'Student', 'Shenalyn', 'Dismar', 'Dismar', 'Female', NULL, NULL, NULL, NULL, 'shenalyn', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/shenalyn.jpg', '2017-09-13 03:46:15'),
(44, 'Student', 'Zacarias', 'Paclibar', 'Paclibar', 'Male', NULL, NULL, NULL, NULL, 'paclibar', 'e10adc3949ba59abbe56e057f20f883e', 'pictures/profile_pictures/zacarias.jpg', '2017-09-13 03:46:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement_comments`
--
ALTER TABLE `announcement_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement_comment_likes`
--
ALTER TABLE `announcement_comment_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement_likes`
--
ALTER TABLE `announcement_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement_replies`
--
ALTER TABLE `announcement_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement_reply_likes`
--
ALTER TABLE `announcement_reply_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `backpack`
--
ALTER TABLE `backpack`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `classrooms` ADD FULLTEXT KEY `class` (`class`,`subject`);

--
-- Indexes for table `classrooms_reviews`
--
ALTER TABLE `classrooms_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classroom_student_designation`
--
ALTER TABLE `classroom_student_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_chats`
--
ALTER TABLE `group_chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_chat_members`
--
ALTER TABLE `group_chat_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_chat_messages`
--
ALTER TABLE `group_chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_in_history`
--
ALTER TABLE `log_in_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials_reviews`
--
ALTER TABLE `materials_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_durations`
--
ALTER TABLE `quiz_durations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_question_choices`
--
ALTER TABLE `quiz_question_choices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_types`
--
ALTER TABLE `quiz_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `users` ADD FULLTEXT KEY `first_name` (`first_name`,`middle_name`,`last_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement_comments`
--
ALTER TABLE `announcement_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement_comment_likes`
--
ALTER TABLE `announcement_comment_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement_likes`
--
ALTER TABLE `announcement_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement_replies`
--
ALTER TABLE `announcement_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement_reply_likes`
--
ALTER TABLE `announcement_reply_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignment_submissions`
--
ALTER TABLE `assignment_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `backpack`
--
ALTER TABLE `backpack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classrooms_reviews`
--
ALTER TABLE `classrooms_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classroom_student_designation`
--
ALTER TABLE `classroom_student_designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_chats`
--
ALTER TABLE `group_chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_chat_members`
--
ALTER TABLE `group_chat_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_chat_messages`
--
ALTER TABLE `group_chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_in_history`
--
ALTER TABLE `log_in_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials_reviews`
--
ALTER TABLE `materials_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_durations`
--
ALTER TABLE `quiz_durations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_question_choices`
--
ALTER TABLE `quiz_question_choices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_types`
--
ALTER TABLE `quiz_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
