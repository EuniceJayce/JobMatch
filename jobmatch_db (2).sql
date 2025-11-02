-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2025 at 03:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobmatch_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `date_applied` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `applicant_id`, `cover_letter`, `resume_path`, `date_applied`, `status`) VALUES
(7, 7, 4, 'asdasd', 'uploads/resumes/1761668072_Final-Project-Documenation (1).docx', '2025-10-29 00:14:32', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employers`
--

CREATE TABLE `employers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employers`
--

INSERT INTO `employers` (`id`, `user_id`, `company_name`, `industry`, `contact_no`, `website`, `profile_image`) VALUES
(1, 3, 'Japan International Fashion', 'Fashion', '09123456789', 'https://asianwiki.com/Kento_Yamazaki', 'uploads/1761490012_c5f66b0d-c914-4a44-85ce-ccf9fc056831.jpg'),
(2, 1, 'Wowie International Airport', 'Aircrafts', '09123456455', 'https://dct.edu.ph/', 'uploads/profile_pictures/1761971355_0603b66a7af6ff0bec05.jpg'),
(3, 9, 'Mierae International Fashion', 'Fashion', '09123456789', NULL, NULL),
(4, 14, 'Japan International Fashion', 'Fashion', '09123456789', 'https://dct.edu.ph/', 'uploads/profile_pictures/1762050013_6144bbf63cd0d15d64b9.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `jobseekers`
--

CREATE TABLE `jobseekers` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `cover_letter` text DEFAULT NULL,
  `status` enum('pending','hired','rejected') DEFAULT 'pending',
  `date_applied` datetime DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_id`, `applicant_id`, `resume`, `cover_letter`, `status`, `date_applied`, `created_at`, `updated_at`) VALUES
(3, 6, 4, '1761801689_b82f52d1e15d548a3c35.docx', 'asdasdasd', 'rejected', '2025-10-30 13:21:29', '2025-10-31 00:16:23', '2025-11-01 01:19:42'),
(4, 7, 4, '1761802785_f822ae9b2d9a67f5a453.docx', 'asdasd', 'hired', '2025-10-30 13:39:45', '2025-10-31 00:16:23', '2025-11-01 11:44:07'),
(5, 3, 4, '1761802802_ba2a7aed18a5541a7872.docx', 'asdasd', 'pending', '2025-10-30 13:40:02', '2025-10-31 00:16:23', '2025-10-31 00:16:23'),
(8, 7, 1, '1761804443_ad3120110b8166f1babf.docx', 'asdasd', 'pending', '2025-10-30 14:07:23', '2025-10-31 00:16:23', '2025-10-31 00:16:23'),
(9, 3, 1, '1761804492_25cd80e3048a69d1e93e.docx', 'asdasd', 'pending', '2025-10-30 14:08:12', '2025-10-31 00:16:23', '2025-10-31 00:16:23'),
(10, 6, 1, '1761804509_eb15d2957f509a031947.docx', 'asdasd', 'pending', '2025-10-30 14:08:29', '2025-10-31 00:16:23', '2025-10-31 00:16:23'),
(14, 7, 2, NULL, NULL, 'pending', '2025-10-30 16:51:49', '2025-10-31 00:16:23', '2025-10-31 00:16:23'),
(19, 7, 3, '1761815568_ae1ab83c686abaeea1e7.docx', 'asdasd', 'pending', '2025-10-30 17:12:48', '2025-10-31 00:16:23', '2025-10-31 00:16:23'),
(20, 6, 3, '1761815579_a1738077a2f212b9c1e1.docx', 'asdasd', 'pending', '2025-10-30 17:12:59', '2025-10-31 00:16:23', '2025-10-31 00:16:23'),
(21, 3, 3, '1761815585_0a6c800982d3ac42a620.docx', 'asdasd', 'pending', '2025-10-30 17:13:05', '2025-10-31 00:16:23', '2025-10-31 00:16:23'),
(27, 7, 10, '1761819839_e82709221bfc561b6398.docx', 'hey so can we uhm', 'hired', '2025-10-30 18:23:59', '2025-10-31 00:16:23', '2025-11-01 01:12:34'),
(32, 12, 4, '1761839905_6fe8febfa49a3ac719d0.docx', 'hey', 'hired', '2025-10-30 23:58:25', '2025-10-31 00:16:23', '2025-11-02 10:30:05'),
(33, 14, 4, '1761840156_4637f4f04c5947e56448.docx', 'hey hey', 'pending', '2025-10-31 00:02:36', '2025-10-31 00:16:23', '2025-10-31 00:16:23'),
(34, 13, 4, '1761840270_3f2b50c9c4ffaa64162c.docx', 'wow', 'rejected', '2025-10-31 00:04:30', '2025-10-31 00:16:23', '2025-10-31 00:53:02'),
(35, 16, 4, '1761841032_dd8d5f822b8b4b973fed.docx', 'asdasd', 'pending', '2025-10-31 00:17:12', '2025-10-31 00:17:12', '2025-10-31 00:17:12'),
(36, 15, 4, '1761841188_b3b2952f9de1a431bc00.docx', 'heysdf', 'pending', '2025-10-31 00:19:48', '2025-10-31 00:19:48', '2025-10-31 00:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `job_posts`
--

CREATE TABLE `job_posts` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `job_type` enum('Full-Time','Part-Time','Gig') NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `work_type` varchar(100) DEFAULT NULL,
  `date_posted` datetime DEFAULT current_timestamp(),
  `salary_range` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_posts`
--

INSERT INTO `job_posts` (`id`, `employer_id`, `title`, `job_type`, `company_name`, `description`, `requirements`, `work_type`, `date_posted`, `salary_range`) VALUES
(3, 3, 'Magtataho', 'Full-Time', '', 'dapat pogi', NULL, NULL, '2025-10-28 15:59:10', '10'),
(6, 1, 'Designer', 'Part-Time', 'Wowie International Airport ', 'wow wow wow', NULL, NULL, '2025-10-28 22:04:17', '200000'),
(7, 1, 'Software Engineerneer', 'Full-Time', 'Wowie International Airport', 'Bachelor’s degree in Computer Science, Information Technology, or related field\r\n\r\nAt least 2 years of experience in web development\r\n\r\nProficient in HTML, CSS, JavaScript, and PHP\r\n\r\nKnowledge of database systems such as MySQL\r\n\r\nStrong problem-solving and communication skills\r\n\r\nAbility to work independently and meet deadlines\r\n\r\nAttention to detail and willingness to learn new technologies', NULL, NULL, '2025-10-29 00:00:54', '200000 - 400000'),
(12, 1, 'Willie Dancer', 'Gig', 'Wowie International Airport ', 'sayw lang', NULL, NULL, '2025-10-30 15:57:55', '10'),
(13, 1, 'Dancer sa The Voice Kid', 'Gig', 'Wowie International Airport ', 'basta blind audition ', NULL, NULL, '2025-10-30 16:01:38', '2300'),
(14, 1, 'Taga salo ng mga luha ko', 'Full-Time', 'Wowie International Airport ', 'basta maging panyo ka', NULL, NULL, '2025-10-30 16:02:01', '200000'),
(15, 1, 'Patapim', 'Part-Time', 'Wowie International Airport ', 'asdasd', NULL, NULL, '2025-10-30 16:12:45', '200000 - 400000'),
(16, 1, 'Cruk cruk', 'Full-Time', 'Wowie International Airport ', 'asdasdsdarw', NULL, NULL, '2025-10-30 16:12:58', '2300'),
(17, 14, 'Japanese Model', 'Full-Time', '', 'dapat sexy', NULL, NULL, '2025-11-02 02:20:45', '20000'),
(18, 1, 'Taga sampay', 'Gig', 'Wowie International Airport', 'uwu', NULL, NULL, '2025-11-02 02:29:16', '50000');

-- --------------------------------------------------------

--
-- Table structure for table `job_seekers`
--

CREATE TABLE `job_seekers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_seekers`
--

INSERT INTO `job_seekers` (`id`, `user_id`, `full_name`, `age`, `gender`, `contact_no`, `profile_picture`, `resume_path`) VALUES
(1, 4, NULL, 21, 'Female', '09123456744', 'uploads/profile_pictures/1761841831_b1594d4c3d1ed9d4fd89.jpg', 'uploads/resumes/1761841844_f54f513bb0730bb2353c.pdf'),
(3, 10, NULL, 21, 'Female', '09123456780', 'uploads/profile_pictures/1761824701_17df0926dc03e9e21802.jpg', NULL),
(4, 4, NULL, 21, 'Female', '09123456745', '/public/uploads/profile_pics/1761820147_ba11cdbfe68215f5ec93.jpg', 'uploads/resumes/1761841241_188f322164eb21f6e0c0.pdf'),
(5, 13, NULL, 99, 'Female', '09123456780', 'uploads/profile_pictures/1762049945_af5ed5c3784ab2742598.jpg', 'uploads/resumes/1762049953_7459b6efa655bf56b874.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date_sent` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `job_id`, `sender_id`, `receiver_id`, `message`, `date_sent`) VALUES
(1, 2, 1, 4, 'yes galing tangina', '2025-10-28 18:02:02'),
(2, 2, 1, 4, 'yes galing tangina', '2025-10-28 18:02:38'),
(3, 5, 1, 4, 'yes galing mo tangina', '2025-10-28 18:08:31'),
(4, 5, 1, 4, 'che!', '2025-10-28 21:59:08'),
(5, 7, 1, 4, 'galing mo', '2025-10-29 00:15:21'),
(6, 6, 1, 4, 'hey', '2025-11-01 03:55:07'),
(7, 6, 1, 4, 'hey hey', '2025-11-01 04:02:20'),
(8, 6, 1, 4, 'hey so umm sorry we already have someone for the position', '2025-11-01 04:05:44'),
(9, 6, 1, 6, 'congrats you are hired', '2025-11-01 05:33:43'),
(10, 12, 1, 4, 'galing galing', '2025-11-02 02:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('employer','job_seeker') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$UZFLOsLNU0qdoFQBhMSfrOwOvKHWIn7QekqHFGk0G/Oq4qz7dHXYq', 'employer', '2025-10-26 12:08:30'),
(2, 'staff', 'staff@gmail.com', '$2y$10$jEQGeUNU2DQ2ikkwXtg6Tu2DgCvei9jn0qMagGmJo7s3matTNKWdG', 'employer', '2025-10-26 12:10:46'),
(3, 'Kento Yamazaki', 'yamaken@gmail.com', '$2y$10$kQMkQXsw5E0lSTyim54pAOR7Rj4k0HbGA5/koK47.cSDW6eDVWKtO', 'employer', '2025-10-26 13:02:50'),
(4, 'Casey Pangilinan Dellamas', 'casey@gmail.com', '$2y$10$xT4d44FfsQKwB9AohuQ2H.kYHeVFoed.hLUQ02CAvaP01iAICNh7C', 'job_seeker', '2025-10-26 13:04:14'),
(9, 'Yuzuha Usagi', 'usagi@gmail.com', '$2y$10$yLRs4AGZpUcyvKj84jeSkOeJAuW5Ec/YRXsOMif0cOAOFGlF8yPe6', 'employer', '2025-10-29 12:32:12'),
(10, 'jayce', 'jayce@gmail.com', '$2y$10$ZSNVm3arb6LllR7THDK8P.tkUygRERnJXCNmixTqc1FK0TKnx3b4u', 'job_seeker', '2025-10-29 14:07:36'),
(13, 'Eunice Jayce De Vero', 'eun@gmail.com', '$2y$10$nsX3Tw8MLjFG21UmHTSyYOjSG9eYwnM9w2JHtHdU7ewn6lPlGw1JG', 'job_seeker', '2025-11-02 02:18:50'),
(14, 'Eunice Jayce De Vero', 'eunice@gmail.com', '$2y$10$TVQrHsU8VFTDqwcU7yvxwe4trxiI5FSDkVc5CQVxS2hGa8I196ctG', 'employer', '2025-11-02 02:20:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicant_id` (`applicant_id`),
  ADD KEY `fk_app_job` (`job_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employers`
--
ALTER TABLE `employers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jobseekers`
--
ALTER TABLE `jobseekers`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_applications_ibfk_1` (`job_id`),
  ADD KEY `job_applications_ibfk_2` (`applicant_id`);

--
-- Indexes for table `job_posts`
--
ALTER TABLE `job_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Indexes for table `job_seekers`
--
ALTER TABLE `job_seekers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employers`
--
ALTER TABLE `employers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobseekers`
--
ALTER TABLE `jobseekers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `job_posts`
--
ALTER TABLE `job_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `job_seekers`
--
ALTER TABLE `job_seekers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`applicant_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_app_job` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employers`
--
ALTER TABLE `employers`
  ADD CONSTRAINT `employers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_ibfk_2` FOREIGN KEY (`applicant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_seekers`
--
ALTER TABLE `job_seekers`
  ADD CONSTRAINT `job_seekers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
