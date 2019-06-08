-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 07 2019 г., 21:08
-- Версия сервера: 5.6.41
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `collaboration`
--
--
-- Структура таблицы `closure_table`
--

CREATE TABLE `closure_table` (
  `parent_id` int(11) NOT NULL COMMENT 'id родительской категории',
  `child_id` int(11) NOT NULL COMMENT 'id потомка',
  `depth` int(11) NOT NULL COMMENT 'глубина вложенности'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с вложенностью категорий';

--
-- Дамп данных таблицы `closure_table`
--

INSERT INTO `closure_table` (`parent_id`, `child_id`, `depth`) VALUES
(1, 1, 0),
(1, 2, 1),
(1, 3, 2),
(1, 8, 3),
(1, 4, 2),
(1, 5, 2),
(1, 6, 2),
(1, 7, 2),
(1, 9, 1),
(1, 10, 1),
(1, 12, 2),
(2, 2, 0),
(2, 3, 1),
(2, 8, 2),
(2, 4, 1),
(2, 5, 1),
(2, 6, 1),
(2, 7, 1),
(3, 3, 0),
(3, 8, 1),
(4, 4, 0),
(5, 5, 0),
(6, 6, 0),
(7, 7, 0),
(9, 9, 0),
(10, 10, 0),
(11, 11, 0),
(11, 13, 1),
(11, 14, 2),
(11, 15, 1),
(12, 12, 0),
(13, 13, 0),
(13, 14, 1),
(14, 14, 0),
(15, 15, 0),
(16, 16, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `t_category`
--

CREATE TABLE `t_category` (
  `category_id` int(11) NOT NULL COMMENT 'id категории',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'родительское id',
  `name_category` varchar(256) NOT NULL COMMENT 'название категории'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица категорий товаров';

--
-- Дамп данных таблицы `t_category`
--

INSERT INTO `t_category` (`category_id`, `parent_id`, `name_category`) VALUES
(1, 0, 'Молочные продукты'),
(2, 1, 'Молоко'),
(3, 2, 'Сыр'),
(4, 2, 'Сычужные сыры'),
(5, 2, 'Твёрдые'),
(6, 2, 'Мягкие'),
(7, 2, 'Рассольные сыры'),
(8, 3, 'Соевый'),
(9, 1, 'Сметана'),
(10, 1, 'Ряженка'),
(11, 0, 'Кондитерские товары'),
(12, 2, 'Конфеты'),
(13, 11, 'Печенье'),
(14, 13, 'Пирожные'),
(15, 11, 'Торты'),
(16, 0, 'Вкусняшки');

-- --------------------------------------------------------

--
-- Структура таблицы `t_product`
--

CREATE TABLE `t_product` (
  `product_id` int(11) NOT NULL COMMENT 'id продукта',
  `product_name` varchar(256) NOT NULL COMMENT 'название продукта',
  `product_price` int(11) NOT NULL COMMENT 'цена продукта',
  `quontity` int(11) NOT NULL COMMENT 'кол-во на складе продукта'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с продуктами';

--
-- Дамп данных таблицы `t_product`
--

INSERT INTO `t_product` (`product_id`, `product_name`, `product_price`, `quontity`) VALUES
(1, 'Продукт1', 12, 0),
(2, 'Продукт2', 13, 0),
(3, 'Продукт3', 45, 0),
(4, 'Продукт4', 77, 0),
(5, 'Продукт5', 44, 0),
(6, 'Продукт6', 456, 0),
(7, 'Продукт7', 9, 0),
(8, 'Продукт8', 90, 0),
(9, 'Продукт9', 9, 0),
(10, 'Продукт10', 8, 0),
(11, 'Продукт11', 6, 0),
(12, 'Продукт12', 6, 0),
(13, 'Продукт13', 6, 0),
(14, 'Продукт14', 3, 0),
(15, 'Продукт15', 7, 0),
(16, 'Продукт16', 7, 0),
(17, 'Продукт17', 7, 0),
(18, 'Продукт18', 0, 0),
(19, 'Продукт19', 7, 0),
(20, 'Продукт20', 7, 0),
(21, 'Продукт21', 6, 0),
(22, 'Продукт22', 6, 0),
(23, 'Продукт23', 6, 0),
(24, 'Продукт24', 6, 0),
(25, 'Продукт25', 67, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `t_product_category`
--

CREATE TABLE `t_product_category` (
  `product_id` int(11) NOT NULL COMMENT 'справочный номер продукта',
  `category_id` int(11) NOT NULL COMMENT 'справочный номер категории'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `t_product_category`
--

INSERT INTO `t_product_category` (`product_id`, `category_id`) VALUES
(1, 1),
(2, 1),
(1, 16),
(2, 3),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(10, 16),
(11, 11),
(12, 12),
(12, 15),
(13, 13),
(13, 14),
(14, 14),
(15, 15),
(17, 15),
(18, 14),
(19, 15),
(20, 14),
(21, 13),
(22, 15),
(23, 13),
(24, 15),
(25, 15);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `t_category`
--
ALTER TABLE `t_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Индексы таблицы `t_product`
--
ALTER TABLE `t_product`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `t_category`
--
ALTER TABLE `t_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id категории', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `t_product`
--
ALTER TABLE `t_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id продукта', AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
