-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 23 2016 г., 11:06
-- Версия сервера: 10.1.9-MariaDB
-- Версия PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `spd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `spd_table`
--

CREATE TABLE `spd_table` (
  `id_entry` int(11) NOT NULL,
  `numOrder` int(6) NOT NULL,
  `customer` varchar(100) NOT NULL,
  `tarif` varchar(30) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `netmask` varchar(15) NOT NULL,
  `gateway` varchar(15) NOT NULL,
  `vlan_id` int(4) NOT NULL,
  `customer_port` varchar(30) NOT NULL,
  `termination_point` varchar(30) NOT NULL,
  `subnet` varchar(18) NOT NULL,
  `broadcast` varchar(18) NOT NULL,
  `dt_added` datetime NOT NULL,
  `dt_last_edited` datetime NOT NULL,
  `commentary` varchar(255) NOT NULL,
  `founder` varchar(30) NOT NULL,
  `last_editor` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `spd_table`
--

INSERT INTO `spd_table` (`id_entry`, `numOrder`, `customer`, `tarif`, `ip_address`, `netmask`, `gateway`, `vlan_id`, `customer_port`, `termination_point`, `subnet`, `broadcast`, `dt_added`, `dt_last_edited`, `commentary`, `founder`, `last_editor`) VALUES
(1, 123, 'Яндекс', '100 Мбит/с', '123.134.132.154', '255.255.255.224', '123.134.132.155', 3476, '10.30.16.16 - port 18', '10.30.0.123', '123.134.132.128', '123.134.132.159', '2016-02-18 09:00:00', '2016-02-18 09:31:00', 'Первая тестовая запись', 'Admin', 'Abilis'),
(2, 3245, 'Ростелеком', '99 Мбит/с', '148.32.156.202', '255.255.255.252', '148.32.156.201', 1934, '10.30.18.12 - port 27', '10.30.0.202', '148.32.156.200', '148.32.156.203', '2016-02-18 11:00:00', '2016-02-18 12:00:00', 'Вторая тестовая запись', 'Abilis', 'Admin'),
(3, 846, 'Рога и Копыта, ПАО', '5 Мбит/с', '46.29.77.88', '255.255.255.0', '46.20.77.83', 256, '10.30.18.26 - port 11', '10.30.0.124', '46.29.77.0', '46.29.77.255', '2016-02-18 11:00:00', '2016-02-18 14:00:00', 'Третья тестовая запись', 'Abilis', 'Abilis'),
(4, 123, 'Яндекс вторая точка', '1000 Мбит/с', 'Канал связи', '', '', 0, 'там-то и там-то', '', '', '', '2016-02-22 01:11:00', '0000-00-00 00:00:00', 'Четвертая тестовая запись', 'Anonimous', 'Abilis'),
(5, 333, 'абонент', 'скорость', '123.123.123.123', '255.255.0.0', '123.123.124.254', 3412, '10.30.18.12 - port 1', '10.30.1.1', '', '', '2016-02-22 23:07:00', '0000-00-00 00:00:00', 'Пятая тестовая запись', '', ''),
(6, 0, '', '', '', '', '', 0, '', '', '', '', '2016-02-22 20:20:08', '0000-00-00 00:00:00', '', '', ''),
(7, 0, '', '', '', '', '', 0, '', '', '', '', '2016-02-22 20:20:57', '0000-00-00 00:00:00', '', '', ''),
(8, 0, '', '', '', '', '', 0, '', '', '', '', '2016-02-22 20:21:33', '0000-00-00 00:00:00', '', '', ''),
(9, 0, '', '', '', '', '', 0, '', '', '', '', '2016-02-22 20:25:59', '0000-00-00 00:00:00', '', '', ''),
(10, 0, '', '', '', '', '', 0, '', '', '', '', '2016-02-22 20:26:11', '0000-00-00 00:00:00', '', '', ''),
(11, 0, '', '', '', '', '', 0, '', '', '', '', '2016-02-22 20:26:16', '0000-00-00 00:00:00', '', '', ''),
(12, 0, 'тестовый клиент', '', 'тестовый адрес', '', '', 143, '', '', '', '', '2016-02-22 20:44:42', '0000-00-00 00:00:00', '', '', ''),
(13, 0, 'Эпл', '', 'второй тестовый', '', '', 1231, '', '', '', '', '2016-02-22 20:45:20', '0000-00-00 00:00:00', '', '', ''),
(14, 345, 'Яндекс. Третья точка', 'много', 'канал связи', 'без маски', 'без шлюза', 1717, 'пока неясно', 'пока непонятно', '', '', '2016-02-22 20:58:40', '0000-00-00 00:00:00', 'Вообще хз что это', '', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `spd_table`
--
ALTER TABLE `spd_table`
  ADD PRIMARY KEY (`id_entry`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `spd_table`
--
ALTER TABLE `spd_table`
  MODIFY `id_entry` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
