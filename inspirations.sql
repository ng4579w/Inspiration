-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2018 at 09:23 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inspirations`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(2) NOT NULL,
  `cat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`) VALUES
(1, 'Category One  '),
(2, 'Category Two'),
(3, 'Category Three'),
(4, 'Category Four');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `com_id` int(11) NOT NULL,
  `idea_id` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `content_text` text NOT NULL,
  `posted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dp_id` int(3) NOT NULL,
  `dp_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dp_id`, `dp_name`) VALUES
(1, 'IT Department'),
(2, 'Computing & Information Systems'),
(3, 'Engineering & Science'),
(4, 'History, Politics & Social Sciences'),
(5, 'Literature, Language & Theatre'),
(6, 'Psychology, Social Work and Counselling'),
(7, 'International Business & Economics');

-- --------------------------------------------------------

--
-- Table structure for table `idea`
--

CREATE TABLE `idea` (
  `idea_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cat_id` int(2) NOT NULL,
  `content_text` text NOT NULL,
  `user_id` int(5) NOT NULL,
  `posted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `idea`
--

INSERT INTO `idea` (`idea_id`, `title`, `cat_id`, `content_text`, `user_id`, `posted_date`) VALUES
(1, 'Example one', 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi condimentum nec sapien nec accumsan. Morbi fringilla sodales venenatis. Nulla a orci sed lorem tincidunt congue finibus eu leo. Aliquam dapibus ligula dui, a gravida lacus aliquam in. Donec luctus in nisl id dignissim. Nam suscipit, libero eu mollis suscipit, libero enim porttitor arcu, ac ullamcorper tellus mi ut orci.', 3, '2018-01-25 12:13:25'),
(2, 'Example two', 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi condimentum nec sapien nec accumsan. Morbi fringilla sodales venenatis. Nulla a orci sed lorem tincidunt congue finibus eu leo. Aliquam dapibus ligula dui, a gravida lacus aliquam in. Donec luctus in nisl id dignissim. Nam suscipit, libero eu mollis suscipit, libero enim porttitor arcu, ac ullamcorper tellus mi ut orci.', 4, '2018-01-24 06:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `department_id` int(3) NOT NULL,
  `user_group_id` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='id';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `department_id`, `user_group_id`) VALUES
(1, 'user3', '$2y$10$79QRpBcXIFOEnARj1oTJ3uOYi2vgBPJIHge61EDi7mfsgwnl24MDe', 'email3@email.com', 4, 2),
(2, 'user4', '$2y$10$i/qB3dQ/PqWuhKSSe3H6B.HSiqSqNbY/dmk9YJQxGpMzuNQKnHuAa', 'email@email.com', 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `user_group_id` int(2) NOT NULL,
  `ug_name` varchar(30) NOT NULL,
  `permission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`user_group_id`, `ug_name`, `permission`) VALUES
(1, 'Academic and support', ''),
(2, 'IT Manager', '{\"admin\":1}'),
(3, 'Quality Assurance Manager', '{\"qam\":1}'),
(4, 'Quality Assurance Coordinator', '{\"qac\":1}');

-- --------------------------------------------------------

--
-- Table structure for table `user_session`
--

CREATE TABLE `user_session` (
  `session_id` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `hash` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vote_info`
--

CREATE TABLE `vote_info` (
  `vote_id` int(11) NOT NULL,
  `idea_id` int(5) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vote_action` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`com_id`),
  ADD UNIQUE KEY `idea_id` (`idea_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dp_id`);

--
-- Indexes for table `idea`
--
ALTER TABLE `idea`
  ADD PRIMARY KEY (`idea_id`),
  ADD KEY `cat_id` (`cat_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`,`user_group_id`),
  ADD KEY `user_group_id` (`user_group_id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`user_group_id`);

--
-- Indexes for table `user_session`
--
ALTER TABLE `user_session`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `vote_info`
--
ALTER TABLE `vote_info`
  ADD PRIMARY KEY (`vote_id`),
  ADD UNIQUE KEY `idea_id` (`idea_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dp_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `idea`
--
ALTER TABLE `idea`
  MODIFY `idea_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `user_group_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_session`
--
ALTER TABLE `user_session`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vote_info`
--
ALTER TABLE `vote_info`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`com_id`) REFERENCES `idea` (`idea_id`);

--
-- Constraints for table `idea`
--
ALTER TABLE `idea`
  ADD CONSTRAINT `idea_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`),
  ADD CONSTRAINT `idea_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`dp_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`user_group_id`) REFERENCES `user_group` (`user_group_id`);

--
-- Constraints for table `user_session`
--
ALTER TABLE `user_session`
  ADD CONSTRAINT `user_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `vote_info`
--
ALTER TABLE `vote_info`
  ADD CONSTRAINT `vote_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `vote_info_ibfk_2` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`idea_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
