-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 13 2021 г., 22:15
-- Версия сервера: 5.7.33
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `minitwitter`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `commentId` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `postId` int(11) DEFAULT NULL,
  `content` text,
  `createdTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`commentId`, `userId`, `postId`, `content`, `createdTime`) VALUES
(1, 1, 20, 'Я новый школьнник', '2020-04-05 22:13:40'),
(2, 1, 20, 'dsdsd', '2020-04-05 22:17:38'),
(3, 1, 20, 'sccsc', '2020-04-05 22:18:50'),
(9, 1, 20, 'А тереь работай', '2020-04-06 01:52:50'),
(12, 2, 17, 'Ха-ха лох!!!', '2020-04-11 20:24:35'),
(15, 1, 22, 'Lutii srach', '2020-05-25 18:32:31'),
(16, 1, 22, 'Ты говно', '2020-09-21 12:07:52'),
(17, 1, 22, 'каакамеп', '2021-04-20 23:55:14'),
(18, 1, 33, 'Приветули\r\n', '2021-04-21 00:05:58'),
(19, 2, 20, 'Привет', '2021-04-21 00:06:47'),
(20, 2, 22, 'Привет\r\n', '2021-04-21 00:07:00'),
(21, 1, 35, 'вывыфв', '2021-04-21 00:21:31'),
(22, 2, 22, 'Не ну парни', '2021-06-05 15:00:02'),
(23, 1, 17, 'Ты лох!', '2021-06-05 15:02:03'),
(24, 2, 22, 'НУ блять парни не ругайтесь', '2021-06-05 16:40:12');

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE `likes` (
  `likeId` int(11) NOT NULL,
  `postId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `likes`
--

INSERT INTO `likes` (`likeId`, `postId`, `userId`) VALUES
(19, 20, 1),
(22, 22, 2),
(23, 20, 2),
(27, 22, 5),
(29, 22, 1),
(30, 23, 1),
(32, 20, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `content` text,
  `countLike` int(11) DEFAULT '0',
  `createdTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`postId`, `userId`, `content`, `countLike`, `createdTime`) VALUES
(17, 1, 'Ну что черти, папа дома', 0, '2020-04-02 13:13:13'),
(20, 1, 'Я новый школьник', 3, '2020-04-05 22:06:54'),
(22, 2, 'Что?', 3, '2020-04-11 12:03:45'),
(23, 1, 'А дима лох))', 1, '2020-04-12 13:50:55'),
(24, 1, 'Ля ля ля', 0, '2020-04-12 13:53:05'),
(33, 1, 'Оно работает\r\n', 0, '2020-09-21 12:08:26'),
(34, 1, 'Пацаны сегодня на марш!!!!', 0, '2020-09-21 12:09:26'),
(35, 1, 'ууакпер', 0, '2021-04-20 23:55:42'),
(36, 6, 'Сидим и учим PHP', 0, '2021-07-13 22:10:40');

-- --------------------------------------------------------

--
-- Структура таблицы `subsribes`
--

CREATE TABLE `subsribes` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `subscriberId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subsribes`
--

INSERT INTO `subsribes` (`id`, `userId`, `subscriberId`) VALUES
(14, 1, 4),
(15, 1, 3),
(29, 2, 5),
(30, 2, 1),
(31, 6, 5),
(32, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Firstname` varchar(20) NOT NULL,
  `Sername` varchar(20) NOT NULL,
  `Register_date` date NOT NULL,
  `Birthday_date` date NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `avatar_path` varchar(40) DEFAULT 'avatar.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `Firstname`, `Sername`, `Register_date`, `Birthday_date`, `Email`, `Password`, `avatar_path`) VALUES
(1, 'Dmitry', 'Antonovich', '2020-03-28', '2020-03-04', 'dima.antonovich.1999@gmail.com', '1111', 'boss.jpg'),
(2, 'Eugen', 'Nalib', '2020-04-11', '2020-05-06', 'ror@gmail.com', '2222', 'aFw2_vUiSEc.jpg'),
(3, 'Roma', 'Angl', '2020-04-11', '2020-04-01', 'roma@tut.by', '5555', 'avatar.jpg'),
(4, 'Mat', 'Mat', '2020-04-12', '1996-03-14', 'ulala@joji.joj', '7777', 'avatar.jpg'),
(5, 'Hik', 'Huk', '2020-04-13', '2020-04-01', 'robot@pop.by', '9999', 'wee.jpg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `user_comments_fk` (`userId`),
  ADD KEY `post_comment_fk` (`postId`);

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likeId`),
  ADD KEY `post_like_fk` (`postId`),
  ADD KEY `user_like_fk` (`userId`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postId`),
  ADD KEY `posts_users_fk` (`userId`);

--
-- Индексы таблицы `subsribes`
--
ALTER TABLE `subsribes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `subscriberId` (`subscriberId`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `likes`
--
ALTER TABLE `likes`
  MODIFY `likeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `subsribes`
--
ALTER TABLE `subsribes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `post_comment_fk` FOREIGN KEY (`postId`) REFERENCES `posts` (`postId`),
  ADD CONSTRAINT `user_comments_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `post_like_fk` FOREIGN KEY (`postId`) REFERENCES `posts` (`postId`),
  ADD CONSTRAINT `user_like_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_users_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `subsribes`
--
ALTER TABLE `subsribes`
  ADD CONSTRAINT `subsribes_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `subsribes_ibfk_2` FOREIGN KEY (`subscriberId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
