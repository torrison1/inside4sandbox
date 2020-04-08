-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Хост: ikiev.mysql.ukraine.com.ua
-- Время создания: Янв 31 2020 г., 17:13
-- Версия сервера: 5.7.16-10-log
-- Версия PHP: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ikiev_inside4`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_users`
--

CREATE TABLE `auth_users` (
  `id` int(16) NOT NULL,
  `email` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(512) NOT NULL,
  `pass_recovery_code` varchar(256) NOT NULL,
  `token` varchar(256) NOT NULL,
  `active` int(1) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `is_verified_email` int(1) NOT NULL,
  `email_verify_code` varchar(256) NOT NULL,
  `is_verified_phone` int(1) NOT NULL,
  `phone_verify_code` varchar(12) NOT NULL,
  `img` varchar(512) NOT NULL,
  `fb_id` int(16) NOT NULL,
  `google_id` int(16) NOT NULL,
  `default_lang` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_users_groups`
--

CREATE TABLE `auth_users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `inside_groups_access`
--

CREATE TABLE `inside_groups_access` (
  `groups_access_rel_id` int(8) NOT NULL DEFAULT '0',
  `group_id` int(8) NOT NULL,
  `module_id` int(4) NOT NULL,
  `module_init` int(1) NOT NULL,
  `module_view` int(1) NOT NULL,
  `module_edit` int(1) NOT NULL,
  `access_code` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `inside_log`
--

CREATE TABLE `inside_log` (
  `log_id` int(16) NOT NULL,
  `log_datetime` int(32) NOT NULL,
  `log_sql` varchar(2048) NOT NULL,
  `log_table` varchar(64) NOT NULL,
  `log_user_id` int(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `inside_modules`
--

CREATE TABLE `inside_modules` (
  `id` int(8) NOT NULL,
  `public_id` varchar(32) NOT NULL,
  `system_name` varchar(64) NOT NULL,
  `icon_class` varchar(32) NOT NULL,
  `name` varchar(256) NOT NULL,
  `desc` varchar(2048) NOT NULL,
  `img` varchar(256) NOT NULL,
  `owner` varchar(32) NOT NULL,
  `type` varchar(32) NOT NULL,
  `main_type` int(4) NOT NULL,
  `issues` varchar(32) NOT NULL,
  `off` int(1) NOT NULL,
  `priority` int(4) NOT NULL,
  `data_json` text NOT NULL,
  `files_json` text NOT NULL,
  `system_elements_json` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `inside_sessions`
--

CREATE TABLE `inside_sessions` (
  `id` int(16) NOT NULL,
  `ip_address` varchar(32) NOT NULL,
  `user_agent` varchar(256) NOT NULL,
  `last_activity` varchar(128) NOT NULL,
  `user_data_encrypted` text NOT NULL,
  `start_time` int(16) NOT NULL,
  `closed` int(1) NOT NULL,
  `end_time` int(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token_encrypted` varchar(512) NOT NULL,
  `risk` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `inside_sessions_actions`
--

CREATE TABLE `inside_sessions_actions` (
  `id` int(32) NOT NULL,
  `session_id` int(16) NOT NULL,
  `time` int(16) NOT NULL,
  `url` varchar(128) NOT NULL,
  `ip_address` varchar(32) NOT NULL,
  `user_agent` varchar(64) NOT NULL,
  `action` varchar(32) NOT NULL,
  `risk` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `inside_top_menu`
--

CREATE TABLE `inside_top_menu` (
  `top_menu_id` int(8) NOT NULL,
  `top_menu_parent_id` int(8) NOT NULL,
  `top_menu_haschild` int(1) NOT NULL,
  `top_menu_name` varchar(64) NOT NULL,
  `top_menu_module_name` varchar(64) NOT NULL,
  `top_menu_url` varchar(128) NOT NULL,
  `top_menu_invisible` int(1) NOT NULL COMMENT '=1 invisible',
  `top_menu_priority` int(3) NOT NULL,
  `top_menu_width` int(8) NOT NULL,
  `top_menu_widthchild` int(8) NOT NULL,
  `top_menu_icon` varchar(64) NOT NULL,
  `top_menu_icon_url` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_banners`
--

CREATE TABLE `it_banners` (
  `banners_id` int(11) NOT NULL,
  `banners_link` varchar(128) NOT NULL,
  `banners_img` varchar(256) NOT NULL,
  `banners_text` varchar(512) NOT NULL,
  `banners_invisible` int(1) NOT NULL,
  `banners_type` int(2) NOT NULL,
  `banners_priority` int(2) NOT NULL,
  `banners_name` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_categories`
--

CREATE TABLE `it_categories` (
  `categories_id` int(11) NOT NULL,
  `categories_name` varchar(128) NOT NULL,
  `categories_alias` varchar(128) NOT NULL,
  `categories_img` varchar(256) NOT NULL,
  `categories_small_img` varchar(256) NOT NULL,
  `categories_desc` varchar(2048) NOT NULL,
  `categories_html` text,
  `categories_landing` int(1) NOT NULL,
  `categories_invisible` int(1) NOT NULL,
  `categories_priority` int(2) NOT NULL,
  `categories_seo_title` varchar(512) NOT NULL,
  `categories_seo_description` varchar(512) NOT NULL,
  `categories_seo_keywords` varchar(512) NOT NULL,
  `categories_pid` int(8) NOT NULL,
  `categories_haschild` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_categories_translate`
--

CREATE TABLE `it_categories_translate` (
  `categories_id` int(8) NOT NULL,
  `categories_name` varchar(128) NOT NULL,
  `categories_alias` varchar(128) NOT NULL,
  `categories_img` varchar(256) NOT NULL,
  `categories_desc` varchar(2048) NOT NULL,
  `categories_html` text NOT NULL,
  `categories_lang_alias` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_comments`
--

CREATE TABLE `it_comments` (
  `comments_id` int(8) NOT NULL,
  `comments_fio` varchar(128) NOT NULL,
  `comments_email` varchar(64) NOT NULL,
  `comments_link` varchar(512) NOT NULL,
  `comments_user_id` int(8) NOT NULL,
  `comments_text` varchar(2048) NOT NULL,
  `comments_date` date NOT NULL,
  `comments_time` varchar(256) NOT NULL,
  `comments_datetime` int(16) NOT NULL,
  `comments_source` varchar(64) NOT NULL,
  `comments_source_id` int(8) NOT NULL,
  `comments_invisible` int(1) NOT NULL,
  `comments_parent_id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_content`
--

CREATE TABLE `it_content` (
  `content_id` int(11) NOT NULL,
  `content_alias` varchar(255) DEFAULT NULL COMMENT 'URL alias',
  `content_priority` int(11) DEFAULT NULL COMMENT 'Sorting rank',
  `content_invisible` int(1) NOT NULL,
  `content_name` varchar(255) DEFAULT NULL,
  `content_user_id` int(8) NOT NULL,
  `content_create_date` date NOT NULL,
  `content_type` int(11) DEFAULT NULL COMMENT 'Content type from $config[''page_cats'']',
  `content_order` int(1) NOT NULL,
  `content_price` int(8) NOT NULL,
  `content_time` int(8) NOT NULL,
  `content_lang` varchar(4) DEFAULT NULL COMMENT 'Content language',
  `content_desc` text COMMENT 'Short description',
  `content_html` text COMMENT 'HTML data',
  `content_img` varchar(45) DEFAULT NULL COMMENT 'Image filename',
  `content_seo_title` varchar(255) NOT NULL COMMENT '1',
  `content_seo_description` varchar(255) NOT NULL COMMENT '1',
  `content_seo_keywords` varchar(255) NOT NULL COMMENT '1',
  `content_gallery` text NOT NULL,
  `content_youtube_link` varchar(256) NOT NULL,
  `content_img_youtube` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_content_translate`
--

CREATE TABLE `it_content_translate` (
  `content_id` int(8) NOT NULL,
  `content_name` varchar(512) NOT NULL,
  `content_desc` varchar(2048) NOT NULL,
  `content_html` text NOT NULL,
  `content_lang_alias` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_menu`
--

CREATE TABLE `it_menu` (
  `menu_id` int(8) NOT NULL,
  `menu_pid` int(8) NOT NULL,
  `menu_haschild` int(1) NOT NULL,
  `menu_name` varchar(256) NOT NULL,
  `menu_url` varchar(256) NOT NULL,
  `menu_invisible` int(1) NOT NULL,
  `menu_priority` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_rel_content_categories`
--

CREATE TABLE `it_rel_content_categories` (
  `content_id` int(8) NOT NULL,
  `category_id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_rel_content_tags`
--

CREATE TABLE `it_rel_content_tags` (
  `content_id` int(8) NOT NULL,
  `tags_id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_requests`
--

CREATE TABLE `it_requests` (
  `requests_id` int(8) NOT NULL,
  `requests_user_contacts` varchar(512) NOT NULL,
  `requests_user_name` varchar(64) NOT NULL,
  `requests_user_email` varchar(64) NOT NULL,
  `requests_user_id` int(8) NOT NULL,
  `requests_user_city` varchar(64) NOT NULL,
  `requests_user_phone` varchar(32) NOT NULL,
  `requests_user_site` varchar(64) NOT NULL,
  `requests_datetime` int(32) NOT NULL,
  `requests_message` varchar(2048) NOT NULL,
  `requests_invisible` int(1) NOT NULL,
  `requests_priority` int(3) NOT NULL,
  `requests_type` int(2) NOT NULL,
  `requests_result` int(2) NOT NULL,
  `requests_url` varchar(512) NOT NULL,
  `requests_name` varchar(256) NOT NULL,
  `requests_virtual_type` int(4) NOT NULL,
  `virtual1` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_tags`
--

CREATE TABLE `it_tags` (
  `tags_id` int(8) NOT NULL,
  `tags_pid` int(8) NOT NULL,
  `tags_haschild` int(1) NOT NULL,
  `tags_invisible` int(1) NOT NULL,
  `tags_name` varchar(64) NOT NULL,
  `tags_desc` varchar(2048) NOT NULL,
  `tags_html` text NOT NULL,
  `tags_landing` int(1) NOT NULL,
  `tags_create_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `lang_names`
--

CREATE TABLE `lang_names` (
  `id` int(4) NOT NULL,
  `lang_alias` varchar(32) NOT NULL,
  `lang_name` varchar(256) NOT NULL,
  `lang_img` varchar(256) NOT NULL,
  `priority` int(4) NOT NULL,
  `off` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `lang_vocabulary`
--

CREATE TABLE `lang_vocabulary` (
  `vocabulary_id` int(8) NOT NULL,
  `vocabulary_name` text NOT NULL,
  `vocabulary_alias` varchar(64) NOT NULL,
  `vocabulary_lang` varchar(8) NOT NULL,
  `vocabulary_type` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `auth_users`
--
ALTER TABLE `auth_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `password` (`password`(333)),
  ADD KEY `pass_recovery_code` (`pass_recovery_code`),
  ADD KEY `email_verify_code` (`email_verify_code`),
  ADD KEY `phone_verify_code` (`phone_verify_code`);

--
-- Индексы таблицы `auth_users_groups`
--
ALTER TABLE `auth_users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Индексы таблицы `inside_log`
--
ALTER TABLE `inside_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Индексы таблицы `inside_modules`
--
ALTER TABLE `inside_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_name` (`system_name`),
  ADD KEY `off` (`off`);

--
-- Индексы таблицы `inside_sessions`
--
ALTER TABLE `inside_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `inside_sessions_actions`
--
ALTER TABLE `inside_sessions_actions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `inside_top_menu`
--
ALTER TABLE `inside_top_menu`
  ADD PRIMARY KEY (`top_menu_id`);

--
-- Индексы таблицы `it_banners`
--
ALTER TABLE `it_banners`
  ADD PRIMARY KEY (`banners_id`);

--
-- Индексы таблицы `it_categories`
--
ALTER TABLE `it_categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Индексы таблицы `it_comments`
--
ALTER TABLE `it_comments`
  ADD PRIMARY KEY (`comments_id`);

--
-- Индексы таблицы `it_content`
--
ALTER TABLE `it_content`
  ADD PRIMARY KEY (`content_id`),
  ADD KEY `fk_nravo_page_nravo_pcat` (`content_type`);

--
-- Индексы таблицы `it_menu`
--
ALTER TABLE `it_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Индексы таблицы `it_requests`
--
ALTER TABLE `it_requests`
  ADD PRIMARY KEY (`requests_id`);

--
-- Индексы таблицы `it_tags`
--
ALTER TABLE `it_tags`
  ADD PRIMARY KEY (`tags_id`);

--
-- Индексы таблицы `lang_names`
--
ALTER TABLE `lang_names`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lang_vocabulary`
--
ALTER TABLE `lang_vocabulary`
  ADD PRIMARY KEY (`vocabulary_id`),
  ADD KEY `vocabulary_lang` (`vocabulary_lang`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `auth_users`
--
ALTER TABLE `auth_users`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `auth_users_groups`
--
ALTER TABLE `auth_users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `inside_log`
--
ALTER TABLE `inside_log`
  MODIFY `log_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `inside_modules`
--
ALTER TABLE `inside_modules`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `inside_sessions`
--
ALTER TABLE `inside_sessions`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `inside_sessions_actions`
--
ALTER TABLE `inside_sessions_actions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `inside_top_menu`
--
ALTER TABLE `inside_top_menu`
  MODIFY `top_menu_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `it_banners`
--
ALTER TABLE `it_banners`
  MODIFY `banners_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `it_categories`
--
ALTER TABLE `it_categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `it_comments`
--
ALTER TABLE `it_comments`
  MODIFY `comments_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `it_content`
--
ALTER TABLE `it_content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `it_menu`
--
ALTER TABLE `it_menu`
  MODIFY `menu_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `it_requests`
--
ALTER TABLE `it_requests`
  MODIFY `requests_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `it_tags`
--
ALTER TABLE `it_tags`
  MODIFY `tags_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `lang_names`
--
ALTER TABLE `lang_names`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `lang_vocabulary`
--
ALTER TABLE `lang_vocabulary`
  MODIFY `vocabulary_id` int(8) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
