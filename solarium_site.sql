-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 02 2023 г., 08:55
-- Версия сервера: 5.6.51
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `solarium_site`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `login` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`id`, `login`, `passwd`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Структура таблицы `good_table`
--

CREATE TABLE `good_table` (
  `id` int(11) NOT NULL,
  `title` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `good_table`
--

INSERT INTO `good_table` (`id`, `title`, `description`, `is_visible`) VALUES
(40, 'Лучшие балконы!!!', 'trytuyi', 1),
(41, 'Лучшие балконы 2', 'ret46587ouio', 1),
(42, 'Лучшие балконы 3', '657utyiuyiu', 1),
(43, 'Лучшие балконы на свете', 'Лучшие балконы на свете', 1),
(44, 'Лучшие балконы 4', 'Лучшие балконы 4', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `photo_table`
--

CREATE TABLE `photo_table` (
  `id` int(11) NOT NULL,
  `goodId` int(11) DEFAULT NULL,
  `path_to_photo` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `photo_table`
--

INSERT INTO `photo_table` (`id`, `goodId`, `path_to_photo`, `status`) VALUES
(63, 40, '../resources/2022-05-11 21-22-30.JPG', 1),
(64, 40, '../resources/2022-05-11 21-22-31.JPG', 0),
(65, 40, '../resources/2022-05-11 21-22-32.JPG', 0),
(66, 40, '../resources/2022-05-11 21-22-33.JPG', 0),
(67, 41, '../resources/1673787961383.jpg', 1),
(68, 41, '../resources/1673787961405.jpg', 1),
(69, 41, '../resources/1673787961418.jpg', 1),
(70, 42, '../resources/IMG-20220511-WA0014.jpg', 1),
(71, 42, '../resources/IMG-20220511-WA0015.jpg', 1),
(72, 42, '../resources/IMG-20220511-WA0016.jpg', 1),
(73, 42, '../resources/IMG-20220511-WA0017.jpg', 1),
(74, 42, '../resources/IMG-20220528-WA0005.jpg', 1),
(75, 42, '../resources/IMG-20220528-WA0006.jpg', 1),
(76, 42, '../resources/IMG-20220528-WA0007.jpg', 1),
(77, 40, '../resources/2022-05-10 14-32-59.JPG', 0),
(78, 43, '../resources/1673787533525.jpg', 1),
(79, 43, '../resources/1673787533549.jpg', 1),
(80, 44, '../resources/IMG-20220722-WA0007.jpg', 1),
(81, 44, '../resources/IMG-20220722-WA0008.jpg', 1),
(82, 44, '../resources/IMG-20220722-WA0009.jpg', 1),
(83, 40, '../resources/2022-05-10 14-32-53.JPG', 0),
(84, 40, '../resources/2022-05-10 14-32-59.JPG', 1),
(85, 40, '../resources/1673787533525.jpg', 1),
(86, 40, '../resources/1673787533549.jpg', 0),
(87, 40, '../resources/1673787533577.jpg', 0),
(88, 40, '../resources/1673787533549.jpg', 0),
(89, 40, '../resources/1673787533577.jpg', 0),
(90, 40, '../resources/1673787533600.jpg', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `good_table`
--
ALTER TABLE `good_table`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `photo_table`
--
ALTER TABLE `photo_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goodId` (`goodId`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `good_table`
--
ALTER TABLE `good_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT для таблицы `photo_table`
--
ALTER TABLE `photo_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `photo_table`
--
ALTER TABLE `photo_table`
  ADD CONSTRAINT `photo_table_ibfk_1` FOREIGN KEY (`goodId`) REFERENCES `good_table` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
