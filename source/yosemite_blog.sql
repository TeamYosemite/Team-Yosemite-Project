-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 
-- Версия на сървъра: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yosemite_blog`
--
CREATE DATABASE IF NOT EXISTS `yosemite_blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `yosemite_blog`;

-- --------------------------------------------------------

--
-- Структура на таблица `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_content` text NOT NULL,
  `comment_dateCreated` int(11) NOT NULL,
  `comment_postId` int(11) NOT NULL,
  `comment_name` varchar(32) NOT NULL,
  `comment_email` varchar(100) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comment_postId` (`comment_postId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура на таблица `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(50) NOT NULL,
  `post_description` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_author` varchar(11) NOT NULL,
  `post_dateCreated` int(15) NOT NULL,
  `post_timesSeen` int(11) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Схема на данните от таблица `posts`
--

INSERT INTO `posts` (`post_id`, `post_title`, `post_description`, `post_content`, `post_author`, `post_dateCreated`, `post_timesSeen`) VALUES
(6, 'asd', 'dsa', 'dsaas', '17', 1418582485, 17),
(7, 'asdsd', 'dsa', 'dsaas', '17', 1418582485, 17),
(8, '123213', 'dsa', 'dsaas', '17', 1418582285, 17),
(9, 'asaasdg', 'dsa', 'dsaas', '17', 1418582485, 17),
(10, 'asasfasgasgd', 'dsa', 'dsaas', '17', 1418583485, 17),
(11, 'asdfasf', 'dsa', 'dsaas', '17', 1418582485, 17),
(12, 'aghagdhagdh', 'dsa', 'dsaas', '17', 1418582638, 17),
(13, 'adghagdh', 'dsa', 'dsaas', '17', 1418582485, 17),
(14, 'adhgdhadgh', 'dsa', 'dsaas', '17', 1418572485, 17),
(15, 'adghadghagdh', 'dsa', 'dsaas', '17', 1419582485, 17),
(16, 'aghdghagdh', 'dsa', 'dsaas', '17', 1418582485, 17),
(17, 'ahdghagdh', 'dsa', 'dsaas', '17', 1418552485, 26),
(18, 'ahgdagdhagh', 'dsa', 'dsaas', '17', 1418582485, 17),
(19, 'aghaghagh', 'dsa', 'dsaas', '17', 1418582445, 17),
(20, 'tawtwawqt', 'dsa', 'dsaas', '17', 1414582485, 17),
(21, 'last', 'asdasd', 'asdsad', '7', 1418582638, 1),
(22, 'antracit', 'asdasdas', 'asdadadasd', '14', 1418583730, 17);

-- --------------------------------------------------------

--
-- Структура на таблица `posts_tags`
--

DROP TABLE IF EXISTS `posts_tags`;
CREATE TABLE IF NOT EXISTS `posts_tags` (
  `tag_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- РЕЛАЦИИ ЗА ТАБЛИЦА `posts_tags`:
--   `post_id`
--       `posts` -> `post_id`
--   `tag_id`
--       `tags` -> `tag_id`
--

-- --------------------------------------------------------

--
-- Структура на таблица `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(32) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(11) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`) VALUES
(1, 'test', '098f6bcd4621d373cade4e832627b4f6');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
