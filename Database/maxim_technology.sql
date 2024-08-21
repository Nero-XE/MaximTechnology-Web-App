-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Авг 21 2024 г., 12:53
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `maxim_technology`
--

-- --------------------------------------------------------

--
-- Структура таблицы `candidate_profiles`
--

CREATE TABLE `candidate_profiles` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор анкеты',
  `full_name` text NOT NULL COMMENT 'ФИО кандидата',
  `candidate_status` int(11) DEFAULT NULL COMMENT 'Статус кандидата',
  `edu_org` int(11) DEFAULT NULL COMMENT 'Образовательное учреждение',
  `profile_rejected` int(11) DEFAULT NULL COMMENT 'Отказ по анкете',
  `full_time_practice` int(11) DEFAULT NULL COMMENT 'Очная практика',
  `practice_target` int(11) DEFAULT NULL COMMENT ' Цель практики',
  `moodle_practice` int(11) DEFAULT NULL COMMENT 'Практика Moodle',
  `unit_id` int(11) DEFAULT NULL COMMENT 'Идентификатор отдела',
  `is_employment` int(11) DEFAULT NULL COMMENT 'Трудоустройство',
  `is_payment` int(11) DEFAULT NULL COMMENT 'Привлечение на оплату',
  `email` varchar(255) DEFAULT NULL COMMENT 'Адрес эл. почты',
  `phone_num` varchar(12) DEFAULT NULL COMMENT 'Номер телефона',
  `res_city` int(11) DEFAULT NULL COMMENT 'Город проживания',
  `edu_city` int(11) DEFAULT NULL COMMENT 'Город обучения',
  `study_course` int(11) DEFAULT NULL COMMENT 'Курс обучения',
  `training_direction` text DEFAULT NULL COMMENT 'Направления обучения (подготовки)',
  `stack` text DEFAULT NULL COMMENT 'Стек',
  `softskills` text DEFAULT NULL COMMENT 'Результаты собеседования',
  `receiving_date` date DEFAULT NULL COMMENT 'Дата получения анкеты',
  `commentary` text DEFAULT NULL COMMENT 'Комментарии'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Анкеты кандидатов';

--
-- Дамп данных таблицы `candidate_profiles`
--

INSERT INTO `candidate_profiles` (`id`, `full_name`, `candidate_status`, `edu_org`, `profile_rejected`, `full_time_practice`, `practice_target`, `moodle_practice`, `unit_id`, `is_employment`, `is_payment`, `email`, `phone_num`, `res_city`, `edu_city`, `study_course`, `training_direction`, `stack`, `softskills`, `receiving_date`, `commentary`) VALUES
(1, 'Петров Иван Михайлович', 4, 2, NULL, 1, 3, 1, 1, NULL, NULL, 'ivan.petrov@mail.ru', '+79007005030', 2, 1, 6, 'Разработчик веб и мультимедийных приложений', 'PHP, Yii2, Swift', NULL, '2024-08-23', NULL),
(20, 'Гаврилова Мария Кирилловна', 5, 4, NULL, NULL, 2, NULL, NULL, NULL, NULL, 'gavrilova.mari@mail.ru', '+79997775533', 1, 2, 6, 'Инженер-программист', 'С#, Базы данных', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Структура таблицы `candidate_statuses`
--

CREATE TABLE `candidate_statuses` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор статуса кандидата',
  `status_name` text NOT NULL COMMENT 'Статус кандидата'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Статусы кандидатов';

--
-- Дамп данных таблицы `candidate_statuses`
--

INSERT INTO `candidate_statuses` (`id`, `status_name`) VALUES
(1, 'Трудоустроен в штат'),
(2, 'ГПХ'),
(3, 'СТД'),
(4, 'Проходит практику'),
(5, 'Резерв'),
(6, 'Окончена практика'),
(7, 'Уволен');

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор города',
  `city_name` text NOT NULL COMMENT 'Название города'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Города';

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `city_name`) VALUES
(1, 'Курган'),
(2, 'Екатеринбург'),
(3, 'Санкт-Петербург'),
(4, 'Москва');

-- --------------------------------------------------------

--
-- Структура таблицы `education_organization`
--

CREATE TABLE `education_organization` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор образовательного учреждения',
  `edu_org_name` text NOT NULL COMMENT 'Название образовательного учреждения'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Образовательные учреждения';

--
-- Дамп данных таблицы `education_organization`
--

INSERT INTO `education_organization` (`id`, `edu_org_name`) VALUES
(1, 'ГПБОУ “КТК”'),
(2, 'КГУ'),
(3, 'СПбГУ'),
(4, 'УрФУ');

-- --------------------------------------------------------

--
-- Структура таблицы `mails`
--

CREATE TABLE `mails` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор письма',
  `profile_id` int(11) NOT NULL COMMENT 'Идентификатор получателя письма',
  `mail_type` int(11) NOT NULL COMMENT 'Идентификатор типа письма',
  `send_date` date NOT NULL COMMENT 'Дата отправки письма'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Письма';

--
-- Дамп данных таблицы `mails`
--

INSERT INTO `mails` (`id`, `profile_id`, `mail_type`, `send_date`) VALUES
(1, 1, 2, '2024-08-15'),
(2, 1, 3, '2024-08-20'),
(4, 20, 3, '2024-08-20'),
(6, 20, 2, '2024-08-21'),
(7, 20, 1, '2024-08-29');

-- --------------------------------------------------------

--
-- Структура таблицы `mail_type`
--

CREATE TABLE `mail_type` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор типа',
  `type_name` text NOT NULL COMMENT 'Название типа'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Типы писем';

--
-- Дамп данных таблицы `mail_type`
--

INSERT INTO `mail_type` (`id`, `type_name`) VALUES
(1, 'Отказ'),
(2, 'Напоминание о заданиях'),
(3, 'Фидбэк');

-- --------------------------------------------------------

--
-- Структура таблицы `moodle`
--

CREATE TABLE `moodle` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор профиля Moodle',
  `profile_id` int(11) NOT NULL COMMENT 'Идентификатор кандидата',
  `moodle_goal` int(11) DEFAULT NULL COMMENT 'Цель практики в Moodle',
  `testing_time` int(11) DEFAULT NULL COMMENT 'Сроки тестирования',
  `tasks_deadline` int(11) DEFAULT NULL COMMENT 'Сроки выполнения',
  `common_tests` int(11) DEFAULT NULL COMMENT 'Стандартные тесты',
  `web_tests` int(11) DEFAULT NULL COMMENT 'Тесты для Web-разработчика',
  `moodle_reject` int(11) DEFAULT NULL COMMENT 'Отказ по Moodle',
  `moodle_status` int(11) DEFAULT NULL COMMENT 'Статус Moodle',
  `tasks` int(11) DEFAULT NULL COMMENT 'Задания',
  `id_mail` int(11) DEFAULT NULL COMMENT 'Письма',
  `moodle_profile_link` text DEFAULT NULL COMMENT 'Ссылка на Moodle'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Moodle профили';

--
-- Дамп данных таблицы `moodle`
--

INSERT INTO `moodle` (`id`, `profile_id`, `moodle_goal`, `testing_time`, `tasks_deadline`, `common_tests`, `web_tests`, `moodle_reject`, `moodle_status`, `tasks`, `id_mail`, `moodle_profile_link`) VALUES
(1, 1, 1, 1, 1, NULL, NULL, NULL, 6, NULL, NULL, 'https://moodle.org'),
(2, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `moodle_goal`
--

CREATE TABLE `moodle_goal` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор цели',
  `goal_type` text NOT NULL COMMENT 'Тип цели'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Цели практики Moodle';

--
-- Дамп данных таблицы `moodle_goal`
--

INSERT INTO `moodle_goal` (`id`, `goal_type`) VALUES
(1, 'Практика'),
(2, 'Стажировка');

-- --------------------------------------------------------

--
-- Структура таблицы `moodle_statuses`
--

CREATE TABLE `moodle_statuses` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор статуса',
  `status_name` text NOT NULL COMMENT 'Статус Moodle'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Статусы Moodle';

--
-- Дамп данных таблицы `moodle_statuses`
--

INSERT INTO `moodle_statuses` (`id`, `status_name`) VALUES
(1, 'Не зарегистрировался'),
(2, 'Не выполнил тесты'),
(3, 'Не набрал минимум'),
(4, 'Не выполнил задания'),
(5, 'В процессе выполнения'),
(6, 'Выполнил задания');

-- --------------------------------------------------------

--
-- Структура таблицы `moodle_tasks_deadline`
--

CREATE TABLE `moodle_tasks_deadline` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор сроков',
  `date_start` date NOT NULL COMMENT 'Дата начала выполнения заданий',
  `date_end` date NOT NULL COMMENT 'Дата окончания выполнения заданий'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Сроки выполнения заданий';

--
-- Дамп данных таблицы `moodle_tasks_deadline`
--

INSERT INTO `moodle_tasks_deadline` (`id`, `date_start`, `date_end`) VALUES
(1, '2024-08-08', '2024-08-31');

-- --------------------------------------------------------

--
-- Структура таблицы `moodle_testing_time`
--

CREATE TABLE `moodle_testing_time` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор сроков',
  `date_start` date NOT NULL COMMENT 'Дата начала тестирования',
  `date_end` date NOT NULL COMMENT 'Дата окончания тестирования'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Сроки тестирования';

--
-- Дамп данных таблицы `moodle_testing_time`
--

INSERT INTO `moodle_testing_time` (`id`, `date_start`, `date_end`) VALUES
(1, '2024-08-06', '2024-08-31');

-- --------------------------------------------------------

--
-- Структура таблицы `practice_dates`
--

CREATE TABLE `practice_dates` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор практики',
  `user_id` int(11) NOT NULL COMMENT 'ИД анкеты',
  `date_start` date NOT NULL COMMENT 'Дата начала практики',
  `date_end` date NOT NULL COMMENT 'Дата конца практики'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Таблица с датами практик';

--
-- Дамп данных таблицы `practice_dates`
--

INSERT INTO `practice_dates` (`id`, `user_id`, `date_start`, `date_end`) VALUES
(1, 1, '2024-05-01', '2024-05-31'),
(2, 1, '2024-08-01', '2024-08-31'),
(4, 20, '2024-08-01', '2024-08-28');

-- --------------------------------------------------------

--
-- Структура таблицы `practice_goal`
--

CREATE TABLE `practice_goal` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор цели	',
  `goal_type` text NOT NULL COMMENT 'Тип цели'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Цели практики кандидата';

--
-- Дамп данных таблицы `practice_goal`
--

INSERT INTO `practice_goal` (`id`, `goal_type`) VALUES
(1, 'Практика'),
(2, 'Стажировка'),
(3, 'Практика с перспективой стажировки');

-- --------------------------------------------------------

--
-- Структура таблицы `profiles_status_dates`
--

CREATE TABLE `profiles_status_dates` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор дат',
  `user_id` int(11) NOT NULL COMMENT 'ИД анкеты',
  `received_date` date NOT NULL COMMENT 'Дата получения анкеты',
  `rejection_date` date DEFAULT NULL COMMENT 'Дата отклонения анкеты'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Таблица даты получения и отказа анкет';

--
-- Дамп данных таблицы `profiles_status_dates`
--

INSERT INTO `profiles_status_dates` (`id`, `user_id`, `received_date`, `rejection_date`) VALUES
(1, 1, '2024-04-27', '2024-06-10'),
(3, 1, '2024-07-25', NULL),
(19, 20, '2024-08-20', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `study_courses`
--

CREATE TABLE `study_courses` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор курса',
  `course_name` text NOT NULL COMMENT 'Название курса'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Курсы';

--
-- Дамп данных таблицы `study_courses`
--

INSERT INTO `study_courses` (`id`, `course_name`) VALUES
(1, '1 курс'),
(2, '2 курс'),
(3, '3 курс'),
(4, '4 курс'),
(5, '5 курс'),
(6, 'Окончил/а обучение');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор заданий',
  `profile_id` int(11) NOT NULL COMMENT 'Идентификатор пользователя',
  `c_sharp` int(11) DEFAULT NULL COMMENT 'Задания по C#',
  `db` int(11) DEFAULT NULL COMMENT 'Задания по базам данных',
  `network_admin` int(11) DEFAULT NULL COMMENT 'Задания по сетевому администрированию',
  `kotlin` int(11) DEFAULT NULL COMMENT 'Задания по Kotlin',
  `swift` int(11) DEFAULT NULL COMMENT 'Задания по Swift',
  `python` int(11) DEFAULT NULL COMMENT 'Задания по Python'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Результаты выполнения заданий';

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `profile_id`, `c_sharp`, `db`, `network_admin`, `kotlin`, `swift`, `python`) VALUES
(1, 1, 1, 1, NULL, NULL, NULL, NULL),
(2, 20, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор результатов теста',
  `profile_id` int(11) NOT NULL COMMENT 'Идентификатор профиля',
  `db` int(11) DEFAULT 0 COMMENT 'Тестирование по базам данных',
  `c_sharp` int(11) DEFAULT 0 COMMENT 'Тестирование по C#',
  `java` int(11) DEFAULT 0 COMMENT 'Тестирование по Java',
  `swift` int(11) DEFAULT 0 COMMENT 'Тестирование по Swift',
  `network_admin` int(11) DEFAULT 0 COMMENT 'Тестирование по Сетевому администрированию',
  `kotlin` int(11) DEFAULT 0 COMMENT 'Тестирование по Kotlin',
  `python` int(11) DEFAULT 0 COMMENT 'Тестирование по Python',
  `ver_num` int(11) DEFAULT 0 COMMENT 'Вербальный и числовой тест'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Результаты тестирования';

--
-- Дамп данных таблицы `tests`
--

INSERT INTO `tests` (`id`, `profile_id`, `db`, `c_sharp`, `java`, `swift`, `network_admin`, `kotlin`, `python`, `ver_num`) VALUES
(1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 1),
(3, 20, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tests_web`
--

CREATE TABLE `tests_web` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор теста',
  `profile_id` int(11) NOT NULL COMMENT 'Идентификатор профиля',
  `common` int(11) DEFAULT NULL COMMENT 'Общее тестирование',
  `js` int(11) DEFAULT NULL COMMENT 'Тестирование по JS',
  `php` int(11) DEFAULT NULL COMMENT 'Тестирование по PHP',
  `vue` int(11) DEFAULT NULL COMMENT 'Тестирование по Vue.js'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Результаты тестирования Web';

--
-- Дамп данных таблицы `tests_web`
--

INSERT INTO `tests_web` (`id`, `profile_id`, `common`, `js`, `php`, `vue`) VALUES
(1, 1, 1, 1, 1, NULL),
(3, 20, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор отдела',
  `unit_name` text NOT NULL COMMENT 'Название отдела',
  `leader_id` int(11) NOT NULL COMMENT 'Идентификатор руководителя'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Таблица с отделами';

--
-- Дамп данных таблицы `units`
--

INSERT INTO `units` (`id`, `unit_name`, `leader_id`) VALUES
(1, 'Web-разработка', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `units_leaders`
--

CREATE TABLE `units_leaders` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор руководителя',
  `full_name` text NOT NULL COMMENT 'ФИО руководителя'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Таблица с руководителями отделов';

--
-- Дамп данных таблицы `units_leaders`
--

INSERT INTO `units_leaders` (`id`, `full_name`) VALUES
(1, 'Грачев Владимир Станиславович');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор пользователя',
  `login` varchar(32) NOT NULL COMMENT 'Логин пользователя',
  `password` varchar(255) NOT NULL COMMENT 'Пароль пользователя'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Пользователи с возможностью редактирования БД';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(1, 'admin', '$2a$12$nn1ijF00fBOJ/MPE0wBvWueW0NHphUMRUgd8j7Zgxe.AOqRXxuuX6');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `candidate_profiles`
--
ALTER TABLE `candidate_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_status` (`candidate_status`),
  ADD KEY `education_organization` (`edu_org`),
  ADD KEY `city` (`res_city`),
  ADD KEY `study_course` (`study_course`),
  ADD KEY `candidate_profiles_ibfk_7` (`edu_city`),
  ADD KEY `candidate_profiles_ibfk_8` (`practice_target`),
  ADD KEY `candidate_profiles_ibfk_9` (`unit_id`);

--
-- Индексы таблицы `candidate_statuses`
--
ALTER TABLE `candidate_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `education_organization`
--
ALTER TABLE `education_organization`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`mail_type`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Индексы таблицы `mail_type`
--
ALTER TABLE `mail_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `moodle`
--
ALTER TABLE `moodle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `moodle_goal` (`moodle_goal`),
  ADD KEY `testing_time` (`testing_time`),
  ADD KEY `tasks_deadline` (`tasks_deadline`),
  ADD KEY `moodle_status` (`moodle_status`),
  ADD KEY `common_tests` (`common_tests`),
  ADD KEY `web_tests` (`web_tests`),
  ADD KEY `tasks` (`tasks`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Индексы таблицы `moodle_goal`
--
ALTER TABLE `moodle_goal`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `moodle_statuses`
--
ALTER TABLE `moodle_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `moodle_tasks_deadline`
--
ALTER TABLE `moodle_tasks_deadline`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `moodle_testing_time`
--
ALTER TABLE `moodle_testing_time`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `practice_dates`
--
ALTER TABLE `practice_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `practice_dates_ibfk_1` (`user_id`);

--
-- Индексы таблицы `practice_goal`
--
ALTER TABLE `practice_goal`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `profiles_status_dates`
--
ALTER TABLE `profiles_status_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_status_dates_ibfk_1` (`user_id`);

--
-- Индексы таблицы `study_courses`
--
ALTER TABLE `study_courses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_ibfk_1` (`profile_id`);

--
-- Индексы таблицы `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tests_ibfk_1` (`profile_id`);

--
-- Индексы таблицы `tests_web`
--
ALTER TABLE `tests_web`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tests_web_ibfk_1` (`profile_id`);

--
-- Индексы таблицы `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leader_id` (`leader_id`);

--
-- Индексы таблицы `units_leaders`
--
ALTER TABLE `units_leaders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `candidate_profiles`
--
ALTER TABLE `candidate_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор анкеты', AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `candidate_statuses`
--
ALTER TABLE `candidate_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор статуса кандидата', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор города', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `education_organization`
--
ALTER TABLE `education_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор образовательного учреждения', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор письма', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `mail_type`
--
ALTER TABLE `mail_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор типа', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `moodle`
--
ALTER TABLE `moodle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор профиля Moodle', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `moodle_goal`
--
ALTER TABLE `moodle_goal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор цели', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `moodle_statuses`
--
ALTER TABLE `moodle_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор статуса', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `moodle_tasks_deadline`
--
ALTER TABLE `moodle_tasks_deadline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор сроков', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `moodle_testing_time`
--
ALTER TABLE `moodle_testing_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор сроков', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `practice_dates`
--
ALTER TABLE `practice_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор практики', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `practice_goal`
--
ALTER TABLE `practice_goal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор цели	', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `profiles_status_dates`
--
ALTER TABLE `profiles_status_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор дат', AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `study_courses`
--
ALTER TABLE `study_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор курса', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор заданий', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор результатов теста', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `tests_web`
--
ALTER TABLE `tests_web`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор теста', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор отдела', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `units_leaders`
--
ALTER TABLE `units_leaders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор руководителя', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор пользователя', AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `candidate_profiles`
--
ALTER TABLE `candidate_profiles`
  ADD CONSTRAINT `candidate_profiles_ibfk_1` FOREIGN KEY (`candidate_status`) REFERENCES `candidate_statuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `candidate_profiles_ibfk_2` FOREIGN KEY (`edu_org`) REFERENCES `education_organization` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `candidate_profiles_ibfk_5` FOREIGN KEY (`study_course`) REFERENCES `study_courses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `candidate_profiles_ibfk_6` FOREIGN KEY (`res_city`) REFERENCES `cities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `candidate_profiles_ibfk_7` FOREIGN KEY (`edu_city`) REFERENCES `cities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `candidate_profiles_ibfk_8` FOREIGN KEY (`practice_target`) REFERENCES `practice_goal` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `candidate_profiles_ibfk_9` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `mails`
--
ALTER TABLE `mails`
  ADD CONSTRAINT `mails_ibfk_1` FOREIGN KEY (`mail_type`) REFERENCES `mail_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mails_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `moodle`
--
ALTER TABLE `moodle`
  ADD CONSTRAINT `moodle_ibfk_2` FOREIGN KEY (`moodle_goal`) REFERENCES `moodle_goal` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `moodle_ibfk_3` FOREIGN KEY (`testing_time`) REFERENCES `moodle_testing_time` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `moodle_ibfk_4` FOREIGN KEY (`tasks_deadline`) REFERENCES `moodle_tasks_deadline` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `moodle_ibfk_5` FOREIGN KEY (`moodle_status`) REFERENCES `moodle_statuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `moodle_ibfk_6` FOREIGN KEY (`common_tests`) REFERENCES `tests` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `moodle_ibfk_7` FOREIGN KEY (`web_tests`) REFERENCES `tests_web` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `moodle_ibfk_8` FOREIGN KEY (`tasks`) REFERENCES `tasks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `moodle_ibfk_9` FOREIGN KEY (`profile_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `practice_dates`
--
ALTER TABLE `practice_dates`
  ADD CONSTRAINT `practice_dates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `profiles_status_dates`
--
ALTER TABLE `profiles_status_dates`
  ADD CONSTRAINT `profiles_status_dates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tests_web`
--
ALTER TABLE `tests_web`
  ADD CONSTRAINT `tests_web_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_ibfk_1` FOREIGN KEY (`leader_id`) REFERENCES `units_leaders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
