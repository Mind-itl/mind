DROP DATABASE IF EXISTS mind;

CREATE DATABASE mind;
USE mind;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE TABLE IF NOT EXISTS `ads` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IMG_PATH` varchar(60) NOT NULL,
  `LINK` text NOT NULL,
  `FROM_DATE` date NOT NULL,
  `TILL_DATE` date NOT NULL,
  `ALT` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `dutes` (
  `LOGIN` varchar(60) NOT NULL,
  `BLOCK` varchar(60) NOT NULL,
  `DAY` enum('Monday','Friday','Wednesday','Thursday','Tuesday','Saturday') NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
INSERT INTO `dutes` (`LOGIN`, `BLOCK`, `DAY`, `ID`) VALUES
('Салахова А.Р.', '5А', 'Monday', 24),
('Ярикжанов И.Р.', '3А', 'Monday', 23),
('Хащиев Д.И.', '2А', 'Monday', 22),
('Семенов Р.С.', '4А', 'Monday', 21);
CREATE TABLE IF NOT EXISTS `lessons` (
  `CLASS` varchar(60) NOT NULL,
  `WEEKDAY` enum('Monday','Friday','Wednesday','Thursday','Tuesday','Saturday') NOT NULL,
  `NUMBER` int(10) NOT NULL,
  `LESSON` varchar(60) NOT NULL,
  `PLACE` varchar(60) NOT NULL,
  `TEACHER` varchar(20) NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME_FROM` time DEFAULT NULL,
  `TIME_UNTIL` time DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
INSERT INTO `lessons` (`CLASS`, `WEEKDAY`, `NUMBER`, `LESSON`, `PLACE`, `TEACHER`, `ID`, `TIME_FROM`, `TIME_UNTIL`) VALUES
('10-4', 'Tuesday', 6, 'Математика', '310', '', 14, '12:35:00', '13:15:00'),
('10-4', 'Tuesday', 5, 'Физ-ра', 'Спортзал', '', 13, '11:40:00', '12:20:00'),
('10-4', 'Tuesday', 4, 'Математика', '310', '', 12, '10:50:00', '11:30:00'),
('10-4', 'Tuesday', 3, 'Английский язык', '309, 310', '', 11, '09:40:00', '10:20:00'),
('10-4', 'Tuesday', 2, 'Информатика', '233', '', 10, '08:50:00', '09:30:00'),
('10-4', 'Tuesday', 1, 'Информатика', '233', '', 9, '08:00:00', '08:40:00');
CREATE TABLE IF NOT EXISTS `lots` (
  `NAME` varchar(60) NOT NULL,
  `MIN_POINTS` int(11) NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SOLD` tinyint(1) NOT NULL DEFAULT '0',
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `music` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PERFORMER` varchar(60) NOT NULL,
  `TITLE` varchar(60) NOT NULL,
  `LOGIN` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
INSERT INTO `music` (`ID`, `PERFORMER`, `TITLE`, `LOGIN`) VALUES
(33, 'Янур', 'Песня для моей души', '1627'),
(24, 'Баста', 'Сансара', '0000'),
(21, 'Justin Timberlake', 'Say Something', '0000'),
(20, 'Imagine Dragons', 'Natural', '0000'),
(28, 'Филипп Киркоров', 'Цвет настроения Синий', '1627'),
(30, 'Выпускники ', 'Гимн Лицея', '1113');
CREATE TABLE IF NOT EXISTS `music_votes` (
  `LOGIN` varchar(60) NOT NULL,
  `ID` int(11) NOT NULL,
  PRIMARY KEY (`LOGIN`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `music_votes` (`LOGIN`, `ID`) VALUES
('8201', 24),
('4111', 20),
('1113', 20),
('5333', 20),
('0000', 24),
('7254', 21),
('3021', 21),
('6990', 20),
('3573', 20),
('6846', 24),
('3243', 24);
CREATE TABLE IF NOT EXISTS `notifications` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TO_USER` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `FROM_USER` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `MESSAGE` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `READED` tinyint(1) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `POINTS` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=287 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `passwords` (
  `LOGIN` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ENTER_LOGIN` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `HASH` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ROLE` enum('teacher','student') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`LOGIN`),
  UNIQUE KEY `ENTER_LOGIN` (`ENTER_LOGIN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `passwords` (`LOGIN`, `ENTER_LOGIN`, `HASH`, `ROLE`) VALUES
('0000', 'thamitov', '2f958d31692446b667822e002539b644', 'teacher'),
('3243', 'pomah3', '2f958d31692446b667822e002539b644', 'student'),
('4077', 'emitasova', '2f958d31692446b667822e002539b644', 'teacher');
CREATE TABLE IF NOT EXISTS `students` (
  `GIVEN_NAME` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `FATHER_NAME` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `FAMILY_NAME` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `CLASS_NUM` int(11) NOT NULL,
  `CLASS_LIT` int(11) NOT NULL,
  `BIRTHDAY` date DEFAULT NULL,
  `LOGIN` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`LOGIN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `students` (`GIVEN_NAME`, `FATHER_NAME`, `FAMILY_NAME`, `CLASS_NUM`, `CLASS_LIT`, `BIRTHDAY`, `LOGIN`, `EMAIL`) VALUES
('Роман', 'Сергеевич', 'Семенов', 10, 4, NULL, '3243', '3908441@gmail.com');
CREATE TABLE IF NOT EXISTS `student_status` (
  `LOGIN` varchar(60) NOT NULL,
  `STATUS` enum('болеет','на сборах','семейное','неизвестно','здесь') NOT NULL,
  `DATA` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`LOGIN`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `student_status` (`LOGIN`, `STATUS`, `DATA`) VALUES
('6654', 'здесь', '2018-12-03 07:51:03'),
('6846', 'неизвестно', '2018-11-19 07:57:55'),
('1113', 'неизвестно', '2018-11-19 07:57:53'),
('2478', 'неизвестно', '2018-11-19 07:57:54'),
('3021', 'неизвестно', '2018-11-19 07:57:52'),
('7876', 'неизвестно', '2018-11-19 07:57:51'),
('8417', 'неизвестно', '2018-11-19 07:57:51'),
('3129', 'неизвестно', '2018-11-19 07:57:50'),
('3573', 'неизвестно', '2018-11-19 07:57:49'),
('4082', 'неизвестно', '2018-11-19 07:57:48'),
('6990', 'неизвестно', '2018-11-19 07:57:47'),
('3464', 'неизвестно', '2018-11-19 07:57:45'),
('3244', 'неизвестно', '2018-11-19 07:57:46'),
('0775', 'неизвестно', '2018-11-19 07:57:43'),
('1627', 'неизвестно', '2018-11-19 07:57:42'),
('9868', 'здесь', '2018-12-03 07:51:13'),
('2103', 'здесь', '2018-12-03 07:51:16'),
('5114', 'здесь', '2018-12-03 07:52:26'),
('6745', 'здесь', '2018-12-03 07:52:31'),
('7539', 'здесь', '2018-12-03 07:52:27'),
('5333', 'здесь', '2018-12-03 07:52:30'),
('3243', 'здесь', '2018-12-03 07:52:29'),
('3877', 'здесь', '2018-12-03 08:15:18'),
('2910', 'здесь', '2018-12-03 07:51:48'),
('8201', 'здесь', '2018-12-03 07:51:49'),
('4111', 'здесь', '2018-12-03 07:51:44'),
('2465', 'здесь', '2018-12-03 07:51:39'),
('7254', 'здесь', '2018-12-03 07:51:42');
CREATE TABLE IF NOT EXISTS `teachers` (
  `GIVEN_NAME` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `FAMILY_NAME` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `FATHER_NAME` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `LOGIN` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `BIRTHDAY` date DEFAULT NULL,
  `EMAIL` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`LOGIN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `teachers` (`GIVEN_NAME`, `FAMILY_NAME`, `FATHER_NAME`, `LOGIN`, `BIRTHDAY`, `EMAIL`) VALUES
('Талгат', 'Хамитов', 'Рашидович', '0000', NULL, NULL),
('Наталья', 'Салахова', 'Олеговна', '0380', NULL, NULL),
('Резеда', 'Гарифова', 'Вакифовна', '2588', NULL, NULL),
('Роберт', 'Абзалов', 'Альбертович', '3515', NULL, NULL),
('Елена', 'Митясова ', 'Анатольевна', '4077', NULL, NULL),
('Екатерина', 'Массарова ', 'Олеговна', '7019', NULL, NULL),
('Артем', 'Чапурин', 'Игоревич', '7323', NULL, NULL);
CREATE TABLE IF NOT EXISTS `teacher_roles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `LOGIN` varchar(60) NOT NULL,
  `ROLE` enum('classruk','vospit','diric','zam','admin','predmet') NOT NULL,
  `ARG` varchar(60) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
INSERT INTO `teacher_roles` (`ID`, `LOGIN`, `ROLE`, `ARG`) VALUES
(3, '0000', 'vospit', '10-4'),
(37, '0000', 'zam', ''),
(36, '3515', 'predmet', ''),
(35, '3515', 'classruk', '10-6'),
(34, '7323', 'predmet', ''),
(33, '7323', 'classruk', '10-5'),
(32, '4077', 'predmet', ''),
(31, '4077', 'classruk', '10-4'),
(30, '2588', 'predmet', ''),
(29, '2588', 'classruk', '10-3'),
(28, '7019', 'predmet', ''),
(27, '7019', 'classruk', '10-2'),
(26, '0380', 'predmet', ''),
(25, '0380', 'classruk', '10-1');
CREATE TABLE IF NOT EXISTS `transactions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FROM_LOGIN` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TO_LOGIN` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `POINTS` int(11) NOT NULL,
  `CAUSE` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `votes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `LOGIN` varchar(60) NOT NULL,
  `VOTING_ID` int(11) NOT NULL,
  `VARIANT_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `votings` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` text NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `TILL_DATE` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `votings`
--

INSERT INTO `votings` (`ID`, `TITLE`, `DESCRIPTION`, `TILL_DATE`) VALUES
(24, 'Твикс', 'А какую палочку выберешь ты?', '0000-00-00');

CREATE TABLE IF NOT EXISTS `voting_variants` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `VOTING_ID` int(11) NOT NULL,
  `VARIANT_ID` int(11) NOT NULL,
  `TITLE` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `voting_variants`
--

INSERT INTO `voting_variants` (`ID`, `VOTING_ID`, `VARIANT_ID`, `TITLE`) VALUES
(30, 24, 4, 'Правую'),
(29, 24, 2, 'Левую');

--
-- Структура таблицы `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(60) NOT NULL,
  `PATH` varchar(60) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`ID`, `TITLE`, `PATH`) VALUES
(1, 'ПС-001, 07.12.18', 'ps001.pdf'),
(2, 'Положение о Совете лицеистов', 'soviet.docx');

CREATE TABLE IF NOT EXISTS `questions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `LOGIN` varchar(60) NOT NULL,
  `QUESTION` text NOT NULL,
  `ANSWER` text,
  `ANSWERER_LOGIN` varchar(60) DEFAULT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`ID`, `LOGIN`, `QUESTION`, `ANSWER`, `ANSWERER_LOGIN`, `TIME`) VALUES
(7, '0000', 'GHbdtn\r\n\r\n', NULL, NULL, '2018-12-13 06:51:45'),
(6, '3243', 'Нужоны скомейки', 'Не буит', '0000', '2018-12-11 14:45:55'),
(12, '0000', 'GHbdtn\r\n\r\n', NULL, NULL, '2018-12-13 07:06:46'),
(13, '0000', 'GHbdtn\r\n\r\n', NULL, NULL, '2018-12-13 07:06:50'),
(14, '0000', 'GHbdtn\r\n\r\n', NULL, NULL, '2018-12-13 07:06:52'),
(11, '0000', 'GHbdtn\r\n\r\n', NULL, NULL, '2018-12-13 07:06:36'),
(15, '0000', 'ЭЩкете', NULL, NULL, '2018-12-13 07:48:26');
