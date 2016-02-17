-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 17 2016 г., 21:13
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
  `df_last_edited` datetime NOT NULL,
  `commentary` varchar(255) NOT NULL,
  `founder` varchar(30) NOT NULL,
  `last_editor` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  MODIFY `id_entry` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
