-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: sql312.infinityfree.com
-- Время создания: Апр 05 2026 г., 12:46
-- Версия сервера: 11.4.7-MariaDB
-- Версия PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `if0_41491682_mozambik`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'admin', '$2y$10$oQ5nZKfWQyBVpstys57x3OuM943csYu5ke/73BT4.D7F7lZE8xJv6', '2026-03-27 14:23:09');

-- --------------------------------------------------------

--
-- Структура таблицы `contact_requests`
--

CREATE TABLE `contact_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(190) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` mediumtext NOT NULL,
  `status` varchar(50) DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `contact_requests`
--

INSERT INTO `contact_requests` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'ТЕСТ', 'test@test.ru', '8 999 999 99 99', 'ТЕСТ', 'ТЕСТ ТЕСТ ТЕСТ ТЕСТ', 'done', '2026-03-27 16:08:27'),
(2, 'Маргарита', 'margarita@yandex.ru', '8 800 555 35 35', 'Поиск модели', 'Нужна модель трусов стрингов с бабочкой на попе', 'new', '2026-03-27 16:11:59'),
(3, 'Олег', 'oleg@google.com', '8 999 903 888 82 55', 'Поиск модели', 'Нужна модель колледжа на 3 этажа', 'new', '2026-03-27 16:18:03');

-- --------------------------------------------------------

--
-- Структура таблицы `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `short_description` mediumtext DEFAULT NULL,
  `full_description` longtext DEFAULT NULL,
  `image_main` varchar(255) NOT NULL,
  `file_fbx` varchar(255) DEFAULT NULL,
  `file_obj` varchar(255) DEFAULT NULL,
  `file_blend` varchar(255) DEFAULT NULL,
  `file_3ds` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `file_glb` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `models`
--

INSERT INTO `models` (`id`, `title`, `slug`, `category`, `short_description`, `full_description`, `image_main`, `file_fbx`, `file_obj`, `file_blend`, `file_3ds`, `is_featured`, `created_at`, `file_glb`) VALUES
(1, 'Coca Cola', 'coca-cola', 'Бутылка', 'Реалистичная 3D модель бутылки Coca-Cola с проработанными материалами и деталями. Подходит для рекламных и продуктовых визуализаций.', 'Детализированная 3D модель бутылки Coca-Cola, выполненная с акцентом на реализм и точную передачу материалов. Модель включает проработанное стекло, жидкость внутри, а также фирменную этикетку с корректной текстурой.\r\n\r\nПоддерживаются отражения, прозрачность и физически корректные свойства материалов, что позволяет использовать модель в высококачественных рендерах без дополнительной доработки.\r\n\r\nМодель оптимизирована и подходит для различных задач:\r\n— рекламные визуализации и продуктовые сцены\r\n— презентации и маркетинговые материалы\r\n— использование в 3D проектах и анимации\r\n— наполнение портфолио\r\n\r\nОтличный вариант для дизайнеров и 3D-художников, которым важен быстрый старт и качественный итоговый результат.', 'uploads/models/1774624650-image-15.png', NULL, NULL, NULL, 'uploads/models/1774624352-Bottle Coca-Cola N080710.3ds', 0, '2026-03-27 15:12:32', 'uploads/models/1774687599-file_glb.glb'),
(2, 'Ясень', 'yasen', 'Дерево', 'Реалистичная 3D модель ясеня с проработанной кроной, стволом и естественными пропорциями. Подходит для ландшафтных визуализаций, экстерьеров и природных сцен.', 'Детализированная 3D модель ясеня, выполненная с акцентом на натуральную форму дерева и реалистичный внешний вид. Модель хорошо передаёт характерные особенности ясеня: стройный ствол, объёмную крону и естественную структуру ветвей.\r\n\r\nПодходит для использования в архитектурных и ландшафтных проектах, а также для наполнения уличных и природных сцен. Такая модель помогает сделать визуализацию более живой, естественной и профессиональной.\r\n\r\nМожет использоваться в разных задачах:\r\n— ландшафтные и архитектурные визуализации\r\n— экстерьеры жилых и общественных пространств\r\n— природные сцены и окружение\r\n— презентации, анимации и 3D-проекты для портфолио\r\n\r\nОтличный вариант для дизайнеров, архитекторов и 3D-художников, которым нужна качественная модель дерева для быстрого и удобного добавления в сцену.', 'uploads/models/1774629047-image-16.png', NULL, NULL, NULL, 'uploads/models/1774629047-Tree1.3ds', 0, '2026-03-27 16:30:48', 'uploads/models/1774687392-file_glb.glb'),
(3, 'Сцена трех деревьев', 'scena-treh-derevev', 'Дерево', '3D сцена с тремя деревьями, объединёнными в единую композицию. Подходит для ландшафтных визуализаций, экстерьеров и создания естественного окружения.', 'Готовая 3D сцена с тремя деревьями, расположенными в гармоничной композиции. Модель позволяет быстро добавить в проект реалистичное природное окружение без необходимости самостоятельно расставлять и настраивать отдельные объекты.\r\n\r\nДеревья проработаны с учётом натуральных пропорций и визуального баланса, благодаря чему сцена выглядит цельно и естественно. Отлично подходит для создания уличных и ландшафтных визуализаций, а также для наполнения архитектурных проектов.\r\n\r\nСцена может использоваться в различных задачах:\r\n— ландшафтные и архитектурные визуализации\r\n— экстерьеры зданий и территорий\r\n— природные сцены и окружение\r\n— 3D-проекты, презентации и анимации\r\n\r\nИдеальный вариант для дизайнеров и 3D-художников, которым нужно быстро добавить в сцену готовое природное решение без лишней настройки.', 'uploads/models/1774629313-image-17.png', NULL, NULL, NULL, 'uploads/models/1774629313-Tree1.3ds', 0, '2026-03-27 16:35:13', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Индексы таблицы `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`) USING HASH;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `contact_requests`
--
ALTER TABLE `contact_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
