-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Хост: ikiev.mysql.ukraine.com.ua
-- Время создания: Июн 11 2020 г., 00:16
-- Версия сервера: 5.7.16-10-log
-- Версия PHP: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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

--
-- Дамп данных таблицы `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'content', 'Content Manager'),
(4, 'admin_demo', 'Admin for Demo');

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

--
-- Дамп данных таблицы `auth_users`
--

INSERT INTO `auth_users` (`id`, `email`, `username`, `password`, `pass_recovery_code`, `token`, `active`, `phone`, `is_verified_email`, `email_verify_code`, `is_verified_phone`, `phone_verify_code`, `img`, `fb_id`, `google_id`, `default_lang`) VALUES
(11, 'torrison1@gmail.com', 'Alex Torrison', 'b988ef37fe801f6bfb00411ec8d231aa', '47adda343f0804fb49407bf2845f9d2d', '', 0, '+380931552970', 1, '', 0, '', '/Uploads/Users/Avatars/11_1580373910_img.jpg', 0, 2147483647, 'en');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_users_groups`
--

CREATE TABLE `auth_users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_users_groups`
--

INSERT INTO `auth_users_groups` (`id`, `user_id`, `group_id`) VALUES
(168, 11, 1),
(169, 19, 4);

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

--
-- Дамп данных таблицы `inside_groups_access`
--

INSERT INTO `inside_groups_access` (`groups_access_rel_id`, `group_id`, `module_id`, `module_init`, `module_view`, `module_edit`, `access_code`) VALUES
(0, 7, 2, 1, 1, 0, ''),
(0, 7, 5, 1, 1, 0, ''),
(0, 7, 79, 1, 1, 0, ''),
(0, 7, 80, 1, 1, 0, ''),
(0, 7, 81, 1, 1, 0, ''),
(0, 7, 4, 1, 1, 0, ''),
(0, 7, 36, 1, 1, 0, ''),
(0, 7, 58, 1, 1, 1, ''),
(0, 7, 62, 1, 1, 1, ''),
(0, 7, 74, 1, 1, 1, ''),
(0, 7, 88, 1, 1, 1, ''),
(0, 7, 89, 1, 1, 1, ''),
(0, 7, 90, 1, 1, 1, ''),
(0, 7, 37, 1, 1, 1, ''),
(0, 7, 3, 1, 1, 1, ''),
(0, 3, 4, 1, 1, 1, ''),
(0, 3, 36, 1, 1, 1, ''),
(0, 3, 40, 1, 1, 1, ''),
(0, 3, 41, 1, 1, 1, ''),
(0, 3, 42, 1, 1, 1, ''),
(0, 3, 60, 1, 1, 1, ''),
(0, 3, 61, 1, 1, 1, ''),
(0, 3, 63, 1, 1, 1, ''),
(0, 3, 37, 1, 1, 1, ''),
(0, 3, 3, 1, 1, 1, ''),
(0, 9, 128, 1, 1, 1, ''),
(0, 9, 102, 1, 1, 1, ''),
(0, 9, 131, 1, 1, 0, ''),
(0, 9, 111, 1, 1, 0, ''),
(0, 9, 130, 1, 1, 0, ''),
(0, 9, 112, 1, 1, 0, ''),
(0, 9, 67, 1, 1, 0, ''),
(0, 9, 4, 1, 1, 0, ''),
(0, 9, 36, 1, 1, 0, ''),
(0, 9, 94, 1, 1, 0, ''),
(0, 9, 99, 1, 1, 0, ''),
(0, 9, 37, 1, 1, 1, ''),
(0, 9, 3, 1, 1, 1, ''),
(0, 2, 37, 1, 1, 0, ''),
(0, 2, 3, 1, 1, 0, ''),
(0, 4, 128, 1, 1, 0, ''),
(0, 4, 2, 1, 1, 0, ''),
(0, 4, 76, 1, 1, 0, ''),
(0, 4, 5, 1, 1, 0, ''),
(0, 4, 7, 1, 1, 0, ''),
(0, 4, 129, 1, 1, 0, ''),
(0, 4, 1, 1, 1, 0, ''),
(0, 4, 79, 1, 1, 0, ''),
(0, 4, 80, 1, 1, 0, ''),
(0, 4, 81, 1, 1, 0, ''),
(0, 4, 4, 1, 1, 0, ''),
(0, 4, 67, 1, 1, 0, ''),
(0, 4, 36, 1, 1, 0, ''),
(0, 4, 57, 1, 1, 0, ''),
(0, 4, 40, 1, 1, 0, ''),
(0, 4, 41, 1, 1, 0, ''),
(0, 4, 42, 1, 1, 0, ''),
(0, 4, 60, 1, 1, 0, ''),
(0, 4, 94, 1, 1, 0, ''),
(0, 4, 119, 1, 1, 0, ''),
(0, 4, 37, 1, 1, 0, ''),
(0, 4, 3, 1, 1, 0, ''),
(0, 1, 128, 1, 1, 1, ''),
(0, 1, 2, 1, 1, 1, ''),
(0, 1, 76, 1, 1, 1, ''),
(0, 1, 5, 1, 1, 1, ''),
(0, 1, 7, 1, 1, 1, ''),
(0, 1, 129, 1, 1, 1, ''),
(0, 1, 1, 1, 1, 1, ''),
(0, 1, 79, 1, 1, 1, ''),
(0, 1, 80, 1, 1, 1, ''),
(0, 1, 81, 1, 1, 1, ''),
(0, 1, 4, 1, 1, 1, ''),
(0, 1, 67, 1, 1, 1, ''),
(0, 1, 36, 1, 1, 1, ''),
(0, 1, 57, 1, 1, 1, ''),
(0, 1, 40, 1, 1, 1, ''),
(0, 1, 41, 1, 1, 1, ''),
(0, 1, 42, 1, 1, 1, ''),
(0, 1, 60, 1, 1, 1, ''),
(0, 1, 94, 1, 1, 1, ''),
(0, 1, 119, 1, 1, 1, ''),
(0, 1, 130, 1, 1, 1, ''),
(0, 1, 37, 1, 1, 1, ''),
(0, 1, 3, 1, 1, 1, '');

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
  `description` varchar(2048) NOT NULL,
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

--
-- Дамп данных таблицы `inside_modules`
--

INSERT INTO `inside_modules` (`id`, `public_id`, `system_name`, `icon_class`, `name`, `description`, `img`, `owner`, `type`, `main_type`, `issues`, `off`, `priority`, `data_json`, `files_json`, `system_elements_json`) VALUES
(1, '1', 'inside_modules_system', 'glyphicon glyphicon-th', 'Inside Modules System', 'is a modular system for building complex web services. It is necessary because of the complexity and team need a clear understanding of all elements for easy step by step development.\nBelow is a table with all the modules of this system. Press the function button or double-click on a row in the table to open full information about the module.', 'blocks_1.jpg', 'torrison', 'Back-End', 2, '0/1', 0, 28, 'test', '[{\"name\":\"Inside Modules Controller Methods\",\"filename\":\"Inside.php\",\"path\":\"\\/AppControllers\\/Inside.php\",\"type\":\"php\"},{\"name\":\"Modules View\",\"filename\":\"inside_modules.php\",\"path\":\"\\/AppViews\\/inside_admin_template\\/Pages\\/admin_main.php\",\"type\":\"php-view\"},{\"name\":\"Module Info View\",\"filename\":\"inside_module_info.php\",\"path\":\"\\/AppViews\\/inside_admin_template\\/Parts\\/module_info.php\",\"type\":\"php-view\"},{\"name\":\"Inside Modular System\",\"filename\":\"InsideModularSystem.php\",\"path\":\"\\/Inside4\\/InsideTools\\/InsideModularSystem.php\",\"type\":\"php\"},{\"name\":\"Inside Modules Controller\",\"filename\":\"Inside_Modules.php\",\"path\":\"\\/AppControllers\\/Inside_Modules.php\",\"type\":\"php\"}]', '[{\"name\":\"Modules Table in Admin Panel\",\"link\":\"\\/inside\\/admin\"},{\"name\":\"Modules Table\",\"link\":\"\\/inside_AT\\/table\\/inside_modules\"}]'),
(15, 'S1', 'unix_server', 'glyphicon glyphicon-cloud', 'Digital Ocean Unix Server', 'Ubuntu Server with LAMP and common tools', '', 'torrison', 'Sys.Admin', 2, '', 0, 20, '', '', '[{\"name\":\"Digital Ocean Account\",\"link\":\"https:\\/\\/www.digitalocean.com\\/\"},{\"name\":\"Unix Server Manual\",\"link\":\"https:\\/\\/docs.google.com\\/document\\/d\\/1C9codJbH0aEdyvAv15Jbm4m5tTwJeZ2VF9eq2WVA02s\\/edit?usp=sharing\"},{\"name\":\"Users Access Doc (SSH, Keys, Passwords)\",\"link\":\"#\"}]'),
(2, 'M1', 'main_gmail_account', 'glyphicon glyphicon-envelope', 'Gmail Account', 'for convenience, you must use a SEPARATE Gmail account for the project.', 'gmail-logo-5806b2d35f9b5805c2886021.png', 'torrison', 'Main', 2, '', 0, 10, '', '', '[{\"name\":\"Access Document\",\"link\":\"#\"}]'),
(16, 'D1', 'inside_security', 'glyphicon glyphicon-warning-sign', 'Inside Security', 'special system for security and data safety.', '', 'torrison', 'Core', 1, '', 0, 35, '', '[{\"name\":\"Security.php\",\"filename\":\"Security.php\",\"path\":\"\\/Inside4\\/Security\\/Security.php\",\"type\":\"php\"},{\"name\":\"config_default.php\",\"filename\":\"config_default.php\",\"path\":\"config_default.php\",\"type\":\"php\"}]', ''),
(3, 'S2', 'hosting_ukraine', 'glyphicon glyphicon-cloud', 'Hosting Ukraine.com.ua', 'convenient hosting with many features for common web services', 'web-hosting.png', 'torrison', 'Sys.Admin', 2, '', 0, 20, '', '', '[{\"name\":\"Ukraine.com.ua\",\"link\":\"https:\\/\\/www.ukraine.com.ua\\/?page=36784\"},{\"name\":\"Access Document\",\"link\":\"#\"}]'),
(4, '2', 'inside_core', 'glyphicon glyphicon-off', 'Inside Core Commons', 'Core Commons Systems based on PHP and MySQL database', 'copy0_abstract_processing_core_by_freakinlobstah-d7jaly6.png', 'torrison', 'TechPRO', 1, '', 0, 30, '', '[{\"name\":\"Config\",\"filename\":\"config_default.php\",\"path\":\"config_default.php\",\"type\":\"php\"},{\"name\":\"BaseController\",\"filename\":\"BaseController.php\",\"path\":\"\\/Inside4\\/CommonCore\\/BaseController.php\",\"type\":\"php\"},{\"name\":\"Common Functions Helpers\",\"filename\":\"Commons.php\",\"path\":\"\\/Inside4\\/CommonCore\\/Commons.php\",\"type\":\"php\"},{\"name\":\"Sessions System\",\"filename\":\"Sessions.php\",\"path\":\"\\/Inside4\\/CommonCore\\/Sessions.php\",\"type\":\"php\"},{\"name\":\"Database System\",\"filename\":\"Database.php\",\"path\":\"\\/Inside4\\/CommonCore\\/Database.php\",\"type\":\"php\"},{\"name\":\"Input System\",\"filename\":\"Input.php\",\"path\":\"\\/Inside4\\/CommonCore\\/Input.php\",\"type\":\"php\"},{\"name\":\"RenderView System\",\"filename\":\"RenderView.php\",\"path\":\"\\/Inside4\\/CommonCore\\/RenderView.php\",\"type\":\"php\"},{\"name\":\"Response System\",\"filename\":\"Response.php\",\"path\":\"\\/Inside4\\/CommonCore\\/Response.php\",\"type\":\"php\"}]', '[{\"name\":\"PHP 7\",\"link\":\"http:\\/\\/php.net\\/manual\\/en\\/\"},{\"name\":\"MySQL\",\"link\":\"https:\\/\\/dev.mysql.com\\/doc\\/refman\\/8.0\\/en\\/\"},{\"name\":\"In Main Template we use Bootstrap\",\"link\":\"https:\\/\\/getbootstrap.com\\/\"},{\"name\":\"And JQuery\",\"link\":\"https:\\/\\/jquery.com\\/\"},{\"name\":\"Also JQuery.Forms for easy AJAX requests\",\"link\":\"http:\\/\\/malsup.com\\/jquery\\/form\\/\"},{\"name\":\"Also JQuery UI\",\"link\":\"https:\\/\\/jqueryui.com\\/\"}]'),
(5, '5', 'inside_auth', 'glyphicon glyphicon-user', 'Inside Auth', 'basic user and authentication system with modern security components', 'multi-user-accounts.png', 'torrison', 'Back-End', 2, '', 0, 40, '', '[{\"name\":\"Auth Config Settings\",\"filename\":\"config.php\",\"path\":\"config.php\",\"type\":\"php\"},{\"name\":\"Auth Controller\",\"filename\":\"Auth.php \",\"path\":\"\\/AppControllers\\/Auth.php\",\"type\":\"php\"},{\"name\":\"Auth API Controller\",\"filename\":\"Auth_API.php\",\"path\":\"\\/AppControllers\\/Auth_API.php\",\"type\":\"php_view\"},{\"name\":\"Auth System\",\"filename\":\"AuthSystem.php\",\"path\":\"\\/Inside4\\/AuthSystem\\/AuthSystem.php\",\"type\":\"php\"},{\"name\":\"Auth Profile View\",\"filename\":\"auth_profile.php\",\"path\":\"\\/AppViews\\/app_default_template\\/Pages\\/Auth\\/auth_profile.php\",\"type\":\"php_view\"},{\"name\":\"Auth Profile Scripts\",\"filename\":\"auth_profile_footer.php\",\"path\":\"\\/AppViews\\/app_default_template\\/Pages\\/Auth\\/auth_profile_footer.php\",\"type\":\"php_view\"},{\"name\":\"Auth Profile CSS\",\"filename\":\"auth_profile_head.php\",\"path\":\"\\/AppViews\\/app_default_template\\/Pages\\/Auth\\/auth_profile_head.php\",\"type\":\"php_view\"},{\"name\":\"Login Page View\",\"filename\":\"login.php\",\"path\":\"\\/AppViews\\/app_default_template\\/Pages\\/Auth\\/login.php\",\"type\":\"php_view\"},{\"name\":\"Login Page Scripts\",\"filename\":\"login_footer.php\",\"path\":\"\\/AppViews\\/app_default_template\\/Pages\\/Auth\\/login_footer.php\",\"type\":\"php_view\"},{\"name\":\"Login Page CSS\",\"filename\":\"login_head.php\",\"path\":\"\\/AppViews\\/app_default_template\\/Pages\\/Auth\\/login_head.php\",\"type\":\"php_view\"},{\"name\":\"new_password.php\",\"filename\":\"new_password.php\",\"path\":\"\\/AppViews\\/app_default_template\\/Pages\\/Static\\/new_password.php\",\"type\":\"php_view\"}]', '[{\"name\":\"Inside Auth API Manual\",\"link\":\"https:\\/\\/docs.google.com\\/document\\/d\\/1gTXSBeyD7C_Sz8RUcCl8FpI2f5UQ-reUuHWcN5ZKuUw\\/edit?usp=sharing\"},{\"name\":\"Inside Admin : Users\",\"link\":\"\\/inside_AT\\/table\\/users\"},{\"name\":\"Inside Admin : Groups\",\"link\":\"\\/inside_AT\\/table\\/groups\"}]'),
(6, '6', 'inside_admin', 'glyphicon glyphicon-folder-open', 'Inside Admin System', 'system for creating admin. panels, tables, and BackOffice System', 'portfolio_it_dmp.png', 'torrison', 'Back-End', 2, '', 0, 27, '', '[{\"name\":\"Inside Admin Panel Controller\",\"filename\":\"Inside.php\",\"path\":\"\\/AppControllers\\/Inside.php\",\"type\":\"php\"},{\"name\":\"Inside Admin System\",\"filename\":\"InsideAdminSystem.php\",\"path\":\"\\/Inside4\\/InsideAdminSystem\\/InsideAdminSystem.php\",\"type\":\"php\"},{\"name\":\"InsideDatabaseView.php\",\"filename\":\"InsideDatabaseView.php\",\"path\":\"\\/Inside4\\/InsideTools\\/InsideDatabaseView.php\",\"type\":\"php\"},{\"name\":\"InsideProjectFiles.php\",\"filename\":\"InsideProjectFiles.php\",\"path\":\"\\/Inside4\\/InsideTools\\/InsideProjectFiles.php\",\"type\":\"php\"}]', '[{\"name\":\"Inside Admin Main Page\",\"link\":\"\\/inside\\/admin\"},{\"name\":\"Inside Admin : Tree-Menu\",\"link\":\"\\/inside_AT\\/table\\/inside_top_menu\"},{\"name\":\"Inside DataBase View Page\",\"link\":\"\\/inside\\/database\"},{\"name\":\"Inside Project Files Tree List\",\"link\":\"\\/inside\\/projectfiles\"},{\"name\":\"Bootstrap 3\",\"link\":\"https:\\/\\/getbootstrap.com\\/docs\\/3.3\\/components\\/\"}]'),
(7, 'B1', 'inside_template', 'glyphicon glyphicon-picture', 'Inside Template', 'easy design Front-End Template System.', 'mytemplate.jpg', 'torrison', 'Full-Stack', 1, '', 0, 37, '', '[{\"name\":\"Front Main Template\",\"filename\":\"main_template.php\",\"path\":\"\\/AppViews\\/app_default_template\\/main_template.php\",\"type\":\"php\"},{\"name\":\"Core.css\",\"filename\":\"core.css\",\"path\":\"\\/Public\\/AppFront\\/app_default_template\\/css\\/core.css\",\"type\":\"css\"},{\"name\":\"Website System\",\"filename\":\"Website.php\",\"path\":\"\\/Inside4\\/Website\\/Website.php\",\"type\":\"php\"},{\"name\":\"config_default.php\",\"filename\":\"config_default.php\",\"path\":\"config_default.php\",\"type\":\"php\"},{\"name\":\"Page for Some Message Text\",\"filename\":\"message.php\",\"path\":\"\\/AppViews\\/app_default_template\\/Pages\\/Static\\/message.php\",\"type\":\"php\"},{\"name\":\"Page for Some Message Text with Redirect\",\"filename\":\"message_redirect.php\",\"path\":\"\\/AppViews\\/app_default_template\\/Pages\\/Static\\/message_redirect.php\",\"type\":\"php\"}]', '[{\"name\":\"Default Template Example\",\"link\":\"https:\\/\\/inside0demo.ikiev.biz\\/\"}]'),
(8, 'D1', 'inside_main_pages', 'glyphicon glyphicon-film', 'Inside Main Pages', 'web service main pages.', 'main111.png', 'torrison', 'Full-Stack', 3, '', 0, 39, '', '[{\"name\":\"Main.php\",\"filename\":\"Main.php\",\"path\":\"\\/AppControllers\\/Main.php\",\"type\":\"php\"},{\"name\":\"index.php\",\"filename\":\"index.php\",\"path\":\"\\/AppViews\\/app_default_template\\/Pages\\/index.php\",\"type\":\"php\"},{\"name\":\"index_footer.php\",\"filename\":\"index_footer.php\",\"path\":\"\\/AppViews\\/app_default_template\\/Pages\\/index_footer.php\",\"type\":\"php\"},{\"name\":\"privacy.php\",\"filename\":\"privacy.php\",\"path\":\"\\/AppViews\\/app_default_template\\/Pages\\/Static\\/privacy.php\",\"type\":\"php\"}]', ''),
(9, 'A1', 'inside_content_pages', 'glyphicon glyphicon-book', 'Inside Content Pages System', 'content management and visualization system. Used for a blog, service list, or product catalog. It can be improved by filters and other additional components.', 'content.jpg', 'torrison', 'Full-Stack', 3, '', 0, 80, '', '[{\"name\":\"Content Controller (for Blog\\/Content System)\",\"filename\":\"Content.php\",\"path\":\"\\/AppControllers\\/Content.php\",\"type\":\"php\"},{\"name\":\"Info Controller (for Any Data)\",\"filename\":\"Info.php\",\"path\":\"\\/AppControllers\\/Info.php\",\"type\":\"php\"}]', '[{\"name\":\"Admin Table for Content Blog Pages\",\"link\":\"\\/inside\\/table_AT\\/it_content\"},{\"name\":\"Admin Table for Content Categories\",\"link\":\"\\/inside\\/table_AT\\/it_categories\"},{\"name\":\"Admin Table for Content Tags\",\"link\":\"\\/inside\\/table_AT\\/it_tags\"},{\"name\":\"Admin Table for Content Images Gallery\",\"link\":\"\\/inside\\/table_AT\\/it_images\"}]'),
(10, '6.1', 'inside_admin_tree_menu', 'glyphicon glyphicon-th-list', 'Inside Admin : Tree Menu', 'tree menu for easy admin management. panel. An admin joins him. table and system of access rights.', 'inside_menu.png', 'torrison', 'Full-Stack', 2, '', 0, 54, '', '[{\"name\":\"InsideAdminSystem.php\",\"filename\":\"InsideAdminSystem.php\",\"path\":\"\\/Inside4\\/InsideAdminSystem\\/InsideAdminSystem.php\",\"type\":\"php\"}]', '[{\"name\":\"Inside Admin Tree Menu Table\",\"link\":\"\\/inside\\/table\\/inside_top_menu\"},{\"name\":\"Access to Menu elements in Groups\",\"link\":\"\\/inside_AT\\/table\\/auth_groups\"},{\"name\":\"Tree Menu Admin Page\",\"link\":\"\\/inside\\/menu_tree\"}]'),
(11, '6.2', 'inside_admin_auto_tables', 'glyphicon glyphicon-list-alt', 'Inside Admin : Auto Tables', 'system for automatic generation of tables, filters, and input fields. Taken into account many features, as well as the connection of many2many and other complex combinations.', 'admin_at.png', 'torrison', 'Full-Stack', 2, '', 0, 57, '', '[{\"name\":\"Inside_AT.php\",\"filename\":\"Inside_AT.php\",\"path\":\"AppControllers\\/Inside_AT.php\",\"type\":\"php\"},{\"name\":\"inside_add_form.php\",\"filename\":\"inside_add_form.php\",\"path\":\"AppViews\\/inside_admin_template\\/Parts\\/inside_add_form.php\",\"type\":\"php\"},{\"name\":\"inside_edit_form.php\",\"filename\":\"inside_edit_form.php\",\"path\":\"AppViews\\/inside_admin_template\\/Parts\\/inside_edit_form.php\",\"type\":\"php\"},{\"name\":\"inside_filters.php\",\"filename\":\"inside_filters.php\",\"path\":\"AppViews\\/inside_admin_template\\/Parts\\/inside_filters.php\",\"type\":\"php\"},{\"name\":\"inside_form.php\",\"filename\":\"inside_form.php\",\"path\":\"AppViews\\/inside_admin_template\\/Parts\\/inside_form.php\",\"type\":\"php\"},{\"name\":\"inside_menu.php\",\"filename\":\"inside_menu.php\",\"path\":\"AppViews\\/inside_admin_template\\/Parts\\/inside_menu.php\",\"type\":\"php\"},{\"name\":\"inside_table.php\",\"filename\":\"inside_table.php\",\"path\":\"AppViews\\/inside_admin_template\\/Parts\\/inside_table.php\",\"type\":\"php\"},{\"name\":\"interface.php\",\"filename\":\"interface.php\",\"path\":\"AppViews\\/inside_admin_template\\/Pages\\/InsideAutoTables\\/interface.php\",\"type\":\"php\"},{\"name\":\"interface_footer.php\",\"filename\":\"interface_footer.php\",\"path\":\"AppViews\\/inside_admin_template\\/Pages\\/InsideAutoTables\\/interface_footer.php\",\"type\":\"php\"},{\"name\":\"AutoTablesSystem.php\",\"filename\":\"AutoTablesSystem.php\",\"path\":\"Inside4\\/InsideAutoTables\\/AutoTablesSystem.php\",\"type\":\"php\"},{\"name\":\"InsideAutoTables Folder\",\"filename\":\"InsideAutoTables Folder\",\"path\":\"Inside4\\/InsideAutoTables\",\"type\":\"folder\"}]', ''),
(12, 'C1', 'inside_build_basic', 'glyphicon glyphicon-grain', 'Inside 4 Basic Install and Configure', 'information for installing Inside. It contains many ready-made components and modules.', 'inage.jpg', 'torrison', 'Full-Stack', 1, '', 0, 25, '', '', '[{\"name\":\"Demo Web-Site\",\"link\":\"https:\\/\\/inside4sandbox.ikiev.biz\\/\"},{\"name\":\"Project Basis Document\",\"link\":\"https:\\/\\/docs.google.com\\/document\\/d\\/1dVkGkLbZWq459et_Vlt9AwgEDRykJsGzI_Wz7ovxSnk\\/edit?usp=sharing\"},{\"name\":\"Make a Google Drive Folder\",\"link\":\"#\"},{\"name\":\"Make a Project Accounts and Descriptions Document\",\"link\":\"#\"},{\"name\":\"Gil clone code from GitHub\",\"link\":\"https:\\/\\/github.com\\/torrison1\\/inside4sandbox\"},{\"name\":\"Import MySQL DataBase\",\"link\":\"https:\\/\\/github.com\\/torrison1\\/inside4sandbox\\/blob\\/master\\/Inside4\\/DataBaseModel\\/ikiev_inside4.sql\"},{\"name\":\"Make a config.php from config_default.php\",\"link\":\"https:\\/\\/github.com\\/torrison1\\/inside4sandbox\\/blob\\/master\\/config_default.php\"}]'),
(13, 'C1', 'inside_seo', 'glyphicon glyphicon-search', 'Inside SEO', 'set of important elements for SEO.', 'seo.png', 'torrison', 'Full-Stack', 1, '', 0, 38, '', '[{\"name\":\"SEO\",\"filename\":\"SEO.php\",\"path\":\"\\/Inside4\\/SEO\\/SEO.php\",\"type\":\"php\"},{\"name\":\"Robots.txt\",\"filename\":\"robots.txt\",\"path\":\"robots.txt\",\"type\":\"txt\"}]', ''),
(14, '0', 'inside_4_core_structure', 'glyphicon glyphicon-cog', 'Inside 4 Core Structure', 'easy MVC files structure for scale and tech management', '', 'Torrison', 'Core', 1, '', 0, 26, '', '[{\"name\":\"Index.php\",\"filename\":\"Index.php\",\"path\":\"index.php\",\"type\":\"PHP\"},{\"name\":\".gitignore\",\"filename\":\".gitignore\",\"path\":\".gitignore\",\"type\":\"Git\"},{\"name\":\".htaccess\",\"filename\":\".htaccess\",\"path\":\".htaccess\",\"type\":\"Apache\"},{\"name\":\"config_default.php\",\"filename\":\"config_default.php\",\"path\":\"config_default.php\",\"type\":\"PHP\"},{\"name\":\"config.php\",\"filename\":\"config.php\",\"path\":\"config.php\",\"type\":\"PHP\"},{\"name\":\"robots.txt\",\"filename\":\"robots.txt\",\"path\":\"robots.txt\",\"type\":\"SEO\"},{\"name\":\"Globals.php\",\"filename\":\"Globals.php\",\"path\":\"\\/Inside4\\/CommonCore\\/Globals.php\",\"type\":\"PHP\"},{\"name\":\"Routing.php\",\"filename\":\"Routing.php\",\"path\":\"\\/Inside4\\/CommonCore\\/Routing.php\",\"type\":\"PHP\"},{\"name\":\"README\",\"filename\":\"README\",\"path\":\"README\",\"type\":\"Help\"},{\"name\":\"Inside4 App Models\",\"filename\":\"Inside4\",\"path\":\"\\/Inside4\\/\",\"type\":\"PHP\"},{\"name\":\"App Views Folder\",\"filename\":\"AppViews\",\"path\":\"\\/AppViews\\/\",\"type\":\"Folder\"},{\"name\":\"App Controllers Folder\",\"filename\":\"AppControllers\",\"path\":\"\\/AppControllers\\/\",\"type\":\"Folder\"},{\"name\":\"Front-End Public Folder\",\"filename\":\"Public\",\"path\":\"\\/Public\\/\",\"type\":\"Folder\"},{\"name\":\"Uploads Folder\",\"filename\":\"Uploads\",\"path\":\"\\/Uploads\\/\",\"type\":\"Folder\"},{\"name\":\"TMP Stuff\",\"filename\":\"xTMP\",\"path\":\"\\/xTMP\\/\",\"type\":\"Folder\"},{\"name\":\"Manuals Folder\",\"filename\":\"Manuals\",\"path\":\"\\/Manuals\\/\",\"type\":\"Folder\"},{\"name\":\"PWA App Folder\",\"filename\":\"MobileApp\",\"path\":\"\\/MobileApp\\/\",\"type\":\"Folder\"}]', '[{\"name\":\"Github Link\",\"link\":\"https:\\/\\/github.com\\/torrison1\\/inside4sandbox\"},{\"name\":\"Inside 4 DataBase\",\"link\":\"https:\\/\\/inside4sandbox.ikiev.biz\\/inside\\/database\"}]'),
(17, '3', 'inside_text_transalate', 'glyphicon glyphicon-refresh', 'Inside Text Translate System', 'text variables system for manage content and make localisations.', '', 'torrison', 'Core', 1, '', 0, 35, '', '[{\"name\":\"TextsTranslate.php\",\"filename\":\"TextsTranslate.php\",\"path\":\"\\/Inside4\\/TextsTranslate\\/TextsTranslate.php\",\"type\":\"php\"}]', ''),
(18, '7', 'inside_custom_cruds', 'glyphicon glyphicon-th-large', 'Inside Admin : Custom Cruds', 'template for CRUD interfaces building', '', 'torrison', 'Full-Stack', 2, '', 0, 57, '', '[{\"name\":\"Inside_cruds.php\",\"filename\":\"Inside_cruds.php\",\"path\":\"AppControllers\\/Inside_cruds.php\",\"type\":\"php\"},{\"name\":\"InsideAutoTables Folder\",\"filename\":\"InsideAutoTables Folder\",\"path\":\"Inside4\\/InsideAutoTables\",\"type\":\"folder\"},{\"name\":\"AutoTablesSystem.php\",\"filename\":\"AutoTablesSystem.php\",\"path\":\"Inside4\\/InsideAutoTables\\/AutoTablesSystem.php\",\"type\":\"php\"},{\"name\":\"inside_add_form.php\",\"filename\":\"inside_add_form.php\",\"path\":\"AppViews\\/inside_admin_template\\/Pages\\/InsideCruds\\/Requests\\/inside_add_form.php\",\"type\":\"php_view\"},{\"name\":\"inside_edit_form.php\",\"filename\":\"inside_edit_form.php\",\"path\":\"AppViews\\/inside_admin_template\\/Pages\\/InsideCruds\\/Requests\\/inside_edit_form.php\",\"type\":\"php_view\"},{\"name\":\"inside_filters.php\",\"filename\":\"inside_filters.php\",\"path\":\"AppViews\\/inside_admin_template\\/Pages\\/InsideCruds\\/Requests\\/inside_filters.php\",\"type\":\"php_view\"},{\"name\":\"inside_form.php\",\"filename\":\"inside_form.php\",\"path\":\"AppViews\\/inside_admin_template\\/Pages\\/InsideCruds\\/Requests\\/inside_form.php\",\"type\":\"php_view\"},{\"name\":\"inside_table.php\",\"filename\":\"inside_table.php\",\"path\":\"AppViews\\/inside_admin_template\\/Pages\\/InsideCruds\\/Requests\\/inside_table.php\",\"type\":\"php_view\"},{\"name\":\"interface.php\",\"filename\":\"interface.php\",\"path\":\"AppViews\\/inside_admin_template\\/Pages\\/InsideCruds\\/Requests\\/interface.php\",\"type\":\"php_view\"},{\"name\":\"interface_footer.php\",\"filename\":\"interface_footer.php\",\"path\":\"AppViews\\/inside_admin_template\\/Pages\\/InsideCruds\\/Requests\\/interface_footer.php\",\"type\":\"php_view\"}]', '[{\"name\":\"Demo Interface\",\"link\":\"https:\\/\\/inside4sandbox.ikiev.biz\\/Inside_cruds\\/requests\"}]');

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

--
-- Дамп данных таблицы `inside_top_menu`
--

INSERT INTO `inside_top_menu` (`top_menu_id`, `top_menu_parent_id`, `top_menu_haschild`, `top_menu_name`, `top_menu_module_name`, `top_menu_url`, `top_menu_invisible`, `top_menu_priority`, `top_menu_width`, `top_menu_widthchild`, `top_menu_icon`, `top_menu_icon_url`) VALUES
(1, 2, 0, 'Groups', 'inside_auth_groups', '/inside_AT/table/auth_groups', 0, 51, 0, 0, '', ''),
(2, 0, 1, 'Settings', 'inside_inside_top_menu', '', 0, 2, 0, 0, 'fa fa-cogs', '/inside_AT/table/inside_top_menu'),
(3, 0, 0, 'LogOut', '', '/auth/logout', 0, 70, 0, 0, 'fa fa-sign-out', '/auth/logout'),
(4, 0, 1, 'Web-Site CMS', 'inside_it_content', '', 0, 4, 0, 0, 'fa fa-file-text-o', '/inside_AT/table/it_content'),
(5, 2, 0, 'Inside-menu', 'inside_inside_top_menu', '/inside_AT/table/inside_top_menu', 0, 1, 0, 0, '', ''),
(7, 2, 0, 'Users', 'inside_users', '/inside_AT/table/auth_users', 0, 2, 0, 0, '', ''),
(36, 4, 0, 'Content', 'inside_it_content', '/inside_AT/table/it_content', 0, -5, 0, 0, '', ''),
(37, 0, 0, 'Exit', 'inside_it_categories', '/', 0, 6, 0, 0, 'fa fa-road', '/'),
(40, 4, 0, 'Categories', 'inside_it_categories', '/inside_AT/table/it_categories', 0, 0, 0, 0, '', ''),
(41, 4, 0, 'Tags', 'inside_it_tags', '/inside_AT/table/it_tags', 0, 4, 0, 0, '', ''),
(42, 4, 0, 'Comments', 'inside_it_comments', '/inside_AT/table/it_comments', 0, 8, 0, 0, '', ''),
(57, 4, 0, 'Menu', 'inside_it_menu', '/inside_AT/table/it_menu', 0, -3, 0, 0, '', ''),
(60, 4, 0, 'Banners', 'inside_it_banners', '/inside_AT/table/it_banners', 0, 11, 0, 0, '', ''),
(67, 4, 0, 'Requests', 'inside_it_requests', '/inside_AT/table/it_requests', 0, -35, 0, 0, '', ''),
(76, 2, 0, 'Inside Log', '', '/inside_AT/table/inside_log', 0, 0, 0, 0, '', ''),
(79, 0, 1, 'Languages', '', '', 0, 4, 0, 0, 'fa fa-book', '/inside_AT/table/wm_vocabulary'),
(80, 79, 0, 'Lang Names', '\n                                                inside_wm_lang ', '/inside_AT/table/wm_lang', 0, 4, 0, 0, '', ''),
(81, 79, 0, 'Vocabulary', 'inside_wm_vocabulary', '/inside_AT/table/wm_vocabulary', 0, 4, 0, 0, '', ''),
(94, 0, 1, 'Advanced', '', '', 0, 5, 0, 0, 'fa fa-tree', '/inside/menu_tree/'),
(119, 94, 0, 'Menu tree', 'menu_tree', '/inside/menu_tree', 0, -1, 0, 0, '', ''),
(128, 0, 0, 'Inside Modules', 'inside_modules', '/inside/admin/', 0, -1, 0, 0, 'fa fa-home', '/inside/admin/'),
(129, 2, 0, 'Inside Modules Table', 'inside_inside_modules', '/inside_AT/table/inside_modules', 0, 3, 0, 0, '', ''),
(130, 94, 0, 'Requests CRUD', 'Inside_cruds_requests', '/Inside_cruds/requests', 0, 1, 0, 0, '', '');

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

--
-- Дамп данных таблицы `it_categories`
--

INSERT INTO `it_categories` (`categories_id`, `categories_name`, `categories_alias`, `categories_img`, `categories_small_img`, `categories_desc`, `categories_html`, `categories_landing`, `categories_invisible`, `categories_priority`, `categories_seo_title`, `categories_seo_description`, `categories_seo_keywords`, `categories_pid`, `categories_haschild`) VALUES
(1, 'PM', 'pm', '', '', '<p>Project Management</p>\n', '<p>Project Management</p>\n', 0, 0, 0, '', '', '', 0, 0),
(2, 'Marketing', 'marketing', '', '', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;Marketing&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">Marketing</span></p>\n', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;Marketing&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">Marketing</span></p>\n', 0, 0, 0, '', '', '', 0, 0),
(3, 'Design', 'design', '', '', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;Design&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">Design</span></p>\n', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;Design&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">Design</span></p>\n', 0, 0, 0, '', '', '', 0, 0),
(4, 'Front-End', 'front-end', '', '', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;Design&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">Design</span></p>\n', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;Design&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">Design</span></p>\n', 0, 0, 0, '', '', '', 0, 0),
(5, 'QA / Testing', 'qa-testing', '', '', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\nQA / Testing​</p>\n', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\nQA / Testing​</p>\n', 0, 0, 0, '', '', '', 0, 0),
(6, 'Back-End', 'back-end', '', '', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;Back-End&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">Back-End</span></p>\n', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;Back-End&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">Back-End</span></p>\n', 0, 0, 0, '', '', '', 0, 0),
(7, 'SEO', 'seo', '', '', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;SEO&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">SEO</span></p>\n', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;SEO&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">SEO</span></p>\n', 0, 0, 0, '', '', '', 0, 0),
(8, 'Content', 'content', '', '', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;Content&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">Content</span></p>\n', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;Content&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">Content</span></p>\n', 0, 0, 0, '', '', '', 0, 0),
(9, 'Full-Stack', 'full-stack', '', '', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;Full-Stack&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">Full-Stack</span></p>\n', '<p>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<style type=\"text/css\"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->\n</style>\n<span data-sheets-userformat=\"{&quot;2&quot;:577,&quot;3&quot;:{&quot;1&quot;:0},&quot;9&quot;:1,&quot;12&quot;:0}\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;Full-Stack&quot;}\" style=\"font-size: 10pt; font-family: Arial; text-align: center;\">Full-Stack</span></p>\n', 0, 0, 0, '', '', '', 0, 0);

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

--
-- Дамп данных таблицы `it_categories_translate`
--

INSERT INTO `it_categories_translate` (`categories_id`, `categories_name`, `categories_alias`, `categories_img`, `categories_desc`, `categories_html`, `categories_lang_alias`) VALUES
(9, 'Фул-стек', '', '', '', '', 'ua'),
(9, 'EN', '', '', '', '', 'en');

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

--
-- Дамп данных таблицы `it_comments`
--

INSERT INTO `it_comments` (`comments_id`, `comments_fio`, `comments_email`, `comments_link`, `comments_user_id`, `comments_text`, `comments_date`, `comments_time`, `comments_datetime`, `comments_source`, `comments_source_id`, `comments_invisible`, `comments_parent_id`) VALUES
(1, '', '', 'http://test.ikiev.biz/content/al/test', 37, 'Test', '0000-00-00', '', 1567512883, '1', 21, 1, 0),
(2, '', '', '//info/page/test1', 11, 'test', '0000-00-00', '', 1588693039, '1', 8, 1, 0);

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

--
-- Дамп данных таблицы `it_content`
--

INSERT INTO `it_content` (`content_id`, `content_alias`, `content_priority`, `content_invisible`, `content_name`, `content_user_id`, `content_create_date`, `content_type`, `content_order`, `content_price`, `content_time`, `content_lang`, `content_desc`, `content_html`, `content_img`, `content_seo_title`, `content_seo_description`, `content_seo_keywords`, `content_gallery`, `content_youtube_link`, `content_img_youtube`) VALUES
(8, 'test1', 1, 0, '111', 0, '2017-03-19', 1, 0, 0, 0, NULL, '<p>Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание</p>\n', '<p>text</p>\n', 'copy0_lcs-interior-1.png', '', '', '', '[]', '', ''),
(21, 'test', 0, 0, 'Inside0 MAIN Install Manual and System Description', 0, '2017-03-22', 1, 0, 0, 0, NULL, '<p>Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание&nbsp;Краткое описание</p>\n', '<p dir=\"ltr\"><span id=\"docs-internal-guid-99af78d4-7fff-7465-5f8f-f3b569c112a2\">Второй контроллер аутентификации - это /application/controllers/</span>auth_api.php в нем сосредоточены основные функции и этот же контроллер используется для аутентификации по API. Методы работают по принципу RESTful API - принимают GET,POST запросы и отдают JSON ответы. Основные методы этого контроллера:</p>\n\n<ul style=\"list-style-type:disc;\">\n	<li dir=\"ltr\">\n	<p dir=\"ltr\"><span id=\"docs-internal-guid-99af78d4-7fff-7465-5f8f-f3b569c112a2\">check_login() - метод логина через email и пароль</span></p>\n	</li>\n	<li dir=\"ltr\">\n	<p dir=\"ltr\"><span id=\"docs-internal-guid-99af78d4-7fff-7465-5f8f-f3b569c112a2\">fb_oauth_link() - метод который генерирует ссылку для входе через facebook</span></p>\n	</li>\n	<li dir=\"ltr\">\n	<p dir=\"ltr\"><span id=\"docs-internal-guid-99af78d4-7fff-7465-5f8f-f3b569c112a2\">check_social_login() - сложный метод входа через fb или google</span></p>\n	</li>\n	<li dir=\"ltr\">\n	<p dir=\"ltr\"><span id=\"docs-internal-guid-99af78d4-7fff-7465-5f8f-f3b569c112a2\">check_reg() - метод регистрации через email и пароль</span></p>\n	</li>\n	<li dir=\"ltr\">\n	<p dir=\"ltr\"><span id=\"docs-internal-guid-99af78d4-7fff-7465-5f8f-f3b569c112a2\">check_recovery() - восстановление пароля</span></p>\n	</li>\n	<li dir=\"ltr\">\n	<p dir=\"ltr\"><span id=\"docs-internal-guid-99af78d4-7fff-7465-5f8f-f3b569c112a2\">update_user_data() - обновление личных данных</span></p>\n	</li>\n	<li dir=\"ltr\">\n	<p dir=\"ltr\"><span id=\"docs-internal-guid-99af78d4-7fff-7465-5f8f-f3b569c112a2\">change_password() - смена пароля</span></p>\n	</li>\n	<li dir=\"ltr\">\n	<p dir=\"ltr\"><span id=\"docs-internal-guid-99af78d4-7fff-7465-5f8f-f3b569c112a2\">phone_verification() - верификация телефона</span></p>\n	</li>\n	<li dir=\"ltr\">\n	<p dir=\"ltr\"><span id=\"docs-internal-guid-99af78d4-7fff-7465-5f8f-f3b569c112a2\">email_verification() - верификация email</span></p>\n	</li>\n	<li dir=\"ltr\">\n	<p dir=\"ltr\"><span id=\"docs-internal-guid-99af78d4-7fff-7465-5f8f-f3b569c112a2\">check_phone_verification_code() - проверка кода верификации телефона</span></p>\n	</li>\n</ul>\n', '231231.jpeg', '', '', '', '[\"us_navy_090720-n-9985w-018_staff_members_of_the_distributed_training_center,_atlantic_participate_in_the_fleet_synthetic_training_event_operation_bold_spectrum.jpg\",\"lcs-interior-1.png\",\"123344.jpg\"]', '', 'copy0_fun11.jpg');

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

--
-- Дамп данных таблицы `it_content_translate`
--

INSERT INTO `it_content_translate` (`content_id`, `content_name`, `content_desc`, `content_html`, `content_lang_alias`) VALUES
(21, 'klkj', '', '', 'ru');

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

--
-- Дамп данных таблицы `it_rel_content_categories`
--

INSERT INTO `it_rel_content_categories` (`content_id`, `category_id`) VALUES
(21, 1),
(8, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `it_rel_content_tags`
--

CREATE TABLE `it_rel_content_tags` (
  `content_id` int(8) NOT NULL,
  `tags_id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `it_rel_content_tags`
--

INSERT INTO `it_rel_content_tags` (`content_id`, `tags_id`) VALUES
(21, 1),
(8, 1);

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

--
-- Дамп данных таблицы `it_requests`
--

INSERT INTO `it_requests` (`requests_id`, `requests_user_contacts`, `requests_user_name`, `requests_user_email`, `requests_user_id`, `requests_user_city`, `requests_user_phone`, `requests_user_site`, `requests_datetime`, `requests_message`, `requests_invisible`, `requests_priority`, `requests_type`, `requests_result`, `requests_url`, `requests_name`, `requests_virtual_type`, `virtual1`) VALUES
(27, '', '', '', 0, '', '', '', -10800, '', 0, 22, 1, 1, '', 'dasdsad111', 0, 0),
(25, '11122ddaaa', '', '', 0, '', '', '', 1590048665, '', 0, 0, 1, 1, '', '111', 0, 0),
(24, 'zz', '', '', 11, '', '', '', 1581457568, 'aa   &lt;br&gt;    &#x28;From : Main Page Order &#x29;', 0, 0, 1, 1, '', '', 0, 0),
(23, '22', '', '', 11, '', '', '', 1581457429, '33   &lt;br&gt;    &#x28;From : Main Page Order &#x29;', 0, 0, 1, 1, '', '', 0, 0),
(26, '', '', '', 0, '', '', '', -21600, '', 0, 2, 1, 1, '', 'dasdasd1111zzzz', 0, 0),
(22, '11', '', '', 11, '', '', '', 1581457423, '22   &lt;br&gt;    &#x28;From : Main Page Order &#x29;', 0, 0, 1, 1, '', '', 0, 0);

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

--
-- Дамп данных таблицы `it_tags`
--

INSERT INTO `it_tags` (`tags_id`, `tags_pid`, `tags_haschild`, `tags_invisible`, `tags_name`, `tags_desc`, `tags_html`, `tags_landing`, `tags_create_time`) VALUES
(1, 0, 0, 0, 'test', 'Test', 'Test', 0, '2018-03-28 15:35:34');

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

--
-- Дамп данных таблицы `lang_names`
--

INSERT INTO `lang_names` (`id`, `lang_alias`, `lang_name`, `lang_img`, `priority`, `off`) VALUES
(1, 'en', 'English', '', 0, 0),
(2, 'ru', 'Russian', '', 0, 0),
(3, 'ua', 'Ukraine', '', 0, 0);

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
-- Дамп данных таблицы `lang_vocabulary`
--

INSERT INTO `lang_vocabulary` (`vocabulary_id`, `vocabulary_name`, `vocabulary_alias`, `vocabulary_lang`, `vocabulary_type`) VALUES
(1, 'Сохранить', 'save_data', 'ru', 0),
(2, 'Save data', 'save_data', 'en', 0),
(3, 'Номер телефона', 'phone_number', 'ru', 0),
(4, 'Доп. информация', 'about_info', 'ru', 0),
(20, 'Язык', 'language', 'ru', 0),
(21, 'Мова', 'language', 'ua', 0),
(22, 'Language', 'language', 'en', 0),
(7, 'Сменить Email или Пароль', 'pass_email_change', 'ru', 0),
(8, 'Ваш пароль', 'current_password', 'ru', 0),
(9, 'Новый пароль', 'new_password', 'ru', 0),
(10, 'Новый пароль еще раз', 'repeat_new_password', 'ru', 0),
(11, 'Обновить', 'update', 'ru', 0),
(23, 'Russian', 'lang_ru', 'en', 0),
(24, 'Російська', 'lang_ru', 'ua', 0),
(25, 'Русский', 'lang_ru', 'ru', 0),
(26, 'Ukrainian', 'lang_ua', 'en', 0),
(16, 'Данные сохранены!', 'data_saved', 'ru', 0),
(27, 'Українська', 'lang_ua', 'ua', 0),
(28, 'Украинский', 'lang_ua', 'ru', 0),
(29, 'English', 'lang_en', 'en', 0),
(30, 'Англійська', 'lang_en', 'ua', 0),
(31, 'Английский', 'lang_en', 'ru', 0),
(32, 'My Profile', 'my_profile', 'en', 0),
(33, 'Личный кабинет', 'my_profile', 'ru', 0),
(34, 'Вход / Регистрация', 'login_reg_top', 'ru', 0),
(35, 'Login / Sing Up', 'login_reg_top', 'en', 0),
(36, 'Change email or password', 'pass_email_change', 'en', 3),
(37, 'Сменить email или пароль', 'pass_email_change', 'ru', 3),
(38, 'Ваш пароль', 'current_password', 'ru', 3),
(39, 'Сurrent password', 'current_password', 'en', 3),
(40, 'New password', 'new_password', 'en', 3),
(41, 'Новый пароль', 'new_password', 'ru', 3),
(42, 'New password again', 'repeat_new_password', 'en', 3),
(43, 'Новый пароль еще раз', 'repeat_new_password', 'ru', 3),
(44, 'Сохранить изменения', 'save_changes', 'ru', 3),
(45, 'Save changes', 'save_changes', 'en', 3),
(222, 'з 2006 року у IT та бізнесі', 'copy_footer_line', 'ua', 2),
(76, 'Login to system', 'login_h1', 'en', 3),
(77, 'Вход в личный кабинет', 'login_h1', 'ru', 3),
(78, 'Password', 'password', 'en', 3),
(223, 'from 2006 in IT and eCommerce', 'copy_footer_line', 'en', 2),
(224, 'с 2006 года в IT и маркетинге', 'copy_footer_line', 'ru', 2),
(225, 'Усі права захищені', 'all_r_reserved', 'ua', 2),
(226, 'All rights reserved', 'all_r_reserved', 'en', 2),
(227, 'Все права защищены', 'all_r_reserved', 'ru', 2),
(231, 'У нас можна замовити аналіз рынку, розробку веб-сайта, програмування стартапу, та інші IT та Digital послуги.', 'main_page_h2', 'ua', 2),
(232, 'У нас можно заказать анализ рынка, разработку веб-сайта, программирование стартапа, и другие IT и Digital услуги.', 'main_page_h2', 'ru', 2),
(233, 'You can order market analysis, website development, make your startup, and purchase other IT and Digital services.', 'main_page_h2', 'en', 2),
(234, 'from', 'from', 'en', 2),
(235, 'от', 'from', 'ru', 2),
(236, 'від', 'from', 'ua', 2),
(237, 'Всего', 'total', 'ru', 2),
(238, 'Усього', 'total', 'ua', 2),
(239, 'Total', 'total', 'en', 2),
(240, 'Веб-сайт', 'website', 'ua', 2),
(241, 'Веб-сайт', 'website', 'ru', 2),
(242, 'Web-site', 'website', 'en', 2),
(243, 'Alexandr Torrison', 'company_ceo', 'ua', 2),
(244, 'Alexandr Torrison', 'company_ceo', 'ru', 2),
(245, 'Alex Torrison, CEO', 'company_ceo', 'en', 2),
(246, 'Я менеджер и разработчик большинства проектов Digital-Outsourcing. В 2009 году перешел в IT бизнес из торговли товарами и услугами. Хорошо понимаю клиентов и их ожидания в разработке и автоматизации.', 'ceo_pitch', 'ru', 2),
(247, 'I am the manager and developer of most Digital-Outsourcing projects. In 2009, I have gone to IT business from goods and services trading. I have well understanding of the client&#8217;s expectations in the development and business process automatization.', 'ceo_pitch', 'en', 2),
(79, 'Пароль', 'password', 'ru', 3),
(80, 'Forget password', 'forget_password', 'en', 3),
(81, 'Забыли пароль', 'forget_password', 'ru', 3),
(82, 'Войти', 'login_btn', 'ru', 3),
(83, 'Sign In', 'login_btn', 'en', 3),
(84, 'Восстановление пароля', 'pass_recovery_h1', 'ru', 3),
(85, 'Password recovery', 'pass_recovery_h1', 'en', 3),
(86, 'Отмена', 'cancel', 'ru', 3),
(87, 'Cancel', 'cancel', 'en', 3),
(88, 'Send instructions', 'send_instructions', 'en', 3),
(89, 'Выслать инструкции', 'send_instructions', 'ru', 3),
(198, 'Home', 'main_page', 'en', 1),
(199, 'Главная', 'main_page', 'ru', 0),
(200, 'Головна', 'main_page', 'ua', 0),
(201, 'Послуги', 'services', 'ua', 0),
(202, 'Услуги', 'services', 'ru', 0),
(203, 'Services', 'services', 'en', 1),
(204, 'Portfolio', 'portfolio', 'en', 1),
(205, 'Портфоліо', 'portfolio', 'ua', 0),
(94, 'No data for your request!', 'search_no_data', 'en', 4),
(95, 'По вашему запросу нет данных!', 'search_no_data', 'ru', 4),
(96, 'Быстрый поиск', 'fast_search_placeholder_short', 'ru', 4),
(97, 'Quick search', 'fast_search_placeholder_short', 'en', 4),
(206, 'Портфолио', 'portfolio', 'ru', 0),
(207, 'Інформація', 'info', 'ua', 1),
(208, 'Информация', 'info', 'ru', 1),
(209, 'Info', 'info', 'en', 1),
(100, 'Update', 'update', 'ru', 0),
(210, 'Бібліотека', 'library', 'ua', 1),
(211, 'Библиотека', 'library', 'ru', 1),
(212, 'Library', 'library', 'en', 1),
(213, 'Контакты', 'contacts', 'ru', 1),
(214, 'Contacts', 'contacts', 'en', 1),
(215, 'Контакти', 'contacts', 'ua', 1),
(216, 'Website, Front-End, Back-End, API, Startups, Web-Services Development, and Custom IT Web-services Support and Management.', 'footer_mini_text', 'en', 2),
(217, 'Заказать сайт, Front-End, Back-End, API, стартапы, разработка веб-сервисов, поддержка и управление проектами, IT услуги.', 'footer_mini_text', 'ru', 2),
(218, 'Замовити сайт, Front-End, Back-End, API, веб-сервіси, підтримка та управління проектами, IT-послуги.', 'footer_mini_text', 'ua', 2),
(219, 'Заказать сайт, Front-End, Back-End, API, стартапы, разработка веб-сервисов, поддержка и управление проектами, IT услуги.', 'footer_mini_text', 'ru', 2),
(113, 'Description', 'description', 'en', 4),
(114, 'Описание', 'description', 'ru', 4),
(115, 'Название', 'obj_name', 'ru', 4),
(116, 'Object name', 'obj_name', 'en', 4),
(117, 'Редактировать объект', 'edit_object', 'ru', 4),
(118, 'Edit object', 'edit_object', 'en', 4),
(119, 'Вид связи', 'rel_type', 'ru', 4),
(120, 'Relation type', 'rel_type', 'en', 4),
(220, 'Website, Front-End, Back-End, API, Startups, Web-Services Development, and Custom IT Web-services Support and Management.', 'footer_mini_text', 'en', 2),
(127, 'Add object', 'add_btn', 'en', 4),
(128, 'Добавить', 'add_btn', 'ru', 4),
(221, 'Замовити сайт, Front-End, Back-End, API, веб-сервіси, підтримка та управління проектами, IT-послуги.', 'footer_mini_text', 'ua', 2),
(131, 'Delete', 'delete', 'en', 4),
(132, 'Удалить', 'delete', 'ru', 4),
(133, 'Редактировать', 'edit_toggle_btn', 'ru', 4),
(134, 'Edit information', 'edit_toggle_btn', 'en', 4),
(183, 'Система для створення веб-сервісів Inside0', 'main_page_h1', 'ua', 2),
(137, 'Добавить новый объект', 'add_new_object', 'ru', 4),
(138, 'Add new object', 'add_new_object', 'en', 4),
(184, 'Система для создания веб-сервисов Inside0', 'main_page_h1', 'ru', 2),
(185, 'Inside is the \"box\" for web-development', 'main_page_h1', 'en', 2),
(186, 'Over 5 years of experience in one box. 3 times faster and 3 times cheaper development. Simple code.', 'main_page_h2', 'en', 2),
(187, 'Більше 5 років досвіду в одній системі. У 3 рази швидша і в 3 рази дешевша розробка. Простий код.', 'main_page_h2', 'ua', 2),
(148, 'Available to me and the performer', 'access_1', 'en', 0),
(188, 'Более 5 лет опыта в одной коробке. В 3 раза быстрее и в 3 раза дешевле разработка. Простой код.', 'main_page_h2', 'ru', 2),
(189, 'Задати питання?', 'ask_question', 'ua', 2),
(190, 'Задать вопрос?', 'ask_question', 'ru', 2),
(191, 'Ask a question?', 'ask_question', 'en', 2),
(192, 'Зробити замовлення', 'order_now_btn', 'ua', 2),
(193, 'Онлайн заказ!', 'order_now_btn', 'ru', 2),
(194, 'Make an order NOW!', 'order_now_btn', 'en', 2),
(195, 'Мой кабинет', 'my_profile', 'ru', 2),
(196, 'My Profile', 'my_profile', 'en', 2),
(197, 'Мій кабінет', 'my_profile', 'ua', 2),
(170, 'Verify email', 'verify_email', 'en', 0),
(171, 'Верифицировать email', 'verify_email', 'ru', 0),
(172, 'Change password', 'change_password', 'en', 0),
(173, 'Изменить пароль', 'change_password', 'ru', 0),
(174, 'Verify phone', 'verify_phone', 'en', 0),
(175, 'Верифицировать телефон', 'verify_phone', 'ru', 0),
(176, 'Change phone/email', 'phone_email_change', 'en', 0),
(177, 'Изменить телефон/email', 'phone_email_change', 'ru', 0),
(178, 'Загрузка...', 'loading', 'ru', 1),
(179, 'Телефон НЕ указан!', 'no_phone', 'ru', 1),
(180, 'Данный телефон содержит ошибки', 'phone_not_valid', 'ru', 0),
(181, 'Данный Email содержит ошибки или уже используется', 'email_not_valid', 'ru', 0),
(182, 'Верифицирован!', 'verified', 'ru', 0),
(248, 'Я менеджер та розробник більшості проектів Digital-Outsourcing. У 2009 році перейшов у IT бізнес із торгівлі товарами та послугами. Добре розумію клієнтів та їх очікування у розробці і автоматизації.', 'ceo_pitch', 'ua', 2),
(249, 'Чому вигідно працювати з нами?', 'why_good_work_with_us', 'ua', 2),
(250, 'Почему выгодно работать с нами?', 'why_good_work_with_us', 'ru', 2),
(251, 'The advantages of our team', 'why_good_work_with_us', 'en', 2),
(252, '<li>Free IT consulting (1-2 hours)</li>\n<li>We have special stable software solutions</li>\n<li>We fundamentally research every element of your business</li>\n<li>Flexible payment terms, possibility of postpay by stages</li>\n<li>Simple program code, database and technical documents</li>\n<li>Our systems are easily to scale</li>\n<li>Low prices for services, such as PHP dev - from $10 / h</li>', 'why_good_work_with_us_list', 'en', 2),
(253, '<li>Безкоштовна IT консультація перед початком робіт (до 2-х годин)</li>\n<li>Ми використовуємо власні готові програмні рішення</li>\n<li>Ми фундаментально підходимо до кожного елементу вашого бізнесу</li>\n<li>Гнучкі умови оплати, можливість постоплати етапами</li>\n<li>Простий програмний код, база даних та технічні документи</li>\n<li>Наші системи легко розширювати та редагувати</li>\n<li>Низькі ціни за IT послуги, наприклад PHP коштує від 10$ / год</li>', 'why_good_work_with_us_list', 'ua', 2),
(254, '<li>Бесплатная IT консультация перед началом работ (до 2-х часов)</li>\n<li>Мы используем собственные готовые программные решения</li>\n<li>Мы фундаментально подходим к каждому элементу вашего бизнеса</li>\n<li>Гибкие условия оплаты, возможность постоплаты этапами</li>\n<li>Простой программный код, база данных и технические документы</li>\n<li>Наши системы легко расширяемы с удобной структурой</li>\n<li>Низкие цены за услуги, например PHP dev - from 10$/h</li>', 'why_good_work_with_us_list', 'ru', 2),
(255, 'Система Inside0', 'service_1', 'ua', 2),
(256, 'Система Inside0', 'service_1', 'ru', 2),
(257, 'Inside0 System', 'service_1', 'en', 2),
(258, 'Сайт на Inside0', 'service_2', 'ru', 2),
(259, ' Web-Site with Inside!', 'service_2', 'en', 2),
(260, 'Сайт на Inside0', 'service_2', 'ua', 2),
(261, 'міс', 'mo', 'ua', 2),
(262, 'mo', 'mo', 'en', 2),
(263, 'мес', 'mo', 'ru', 2),
(264, 'Наші контакти', 'сontact_us', 'ua', 2),
(265, 'Contact us', 'сontact_us', 'en', 2),
(266, 'Отправить запрос', 'сontact_us', 'ru', 2),
(267, 'Унікальний проект', 'service_3', 'ua', 2),
(268, 'Уникальный стартап', 'service_3', 'ru', 2),
(269, 'Custom Project', 'service_3', 'en', 2),
(270, '<li>Низькі ціни</li>\n<li>Адмін панель</li>\n<li>Готовий дизайн</li>\n<li>Легка CMS</li>\n<li>Каталог інформації</li>', 'service_1_list', 'ua', 2),
(361, 'История создания Inside0', 'info_block_title', 'ru', 2),
(271, '<li>Low costs</li>\n<li>Inside Admin Panel</li>\n<li>Free template</li>\n<li>Easy CMS</li>\n<li>Blog System</li>', 'service_1_list', 'en', 2),
(272, '<li>Низкие цены</li>\n<li>Админ панель</li>\n<li>Готовый дизайн</li>\n<li>Легкая CMS</li>\n<li>Каталог информации</li>', 'service_1_list', 'ru', 2),
(273, '<li>Inside Admin Panel</li>\n<li>Landing Page</li>\n<li>Онлайн каталог</li>\n<li>Сторінка товару</li>\n<li>Блог та статті</li>', 'service_2_list', 'ua', 2),
(274, '<li>Inside Admin Panel</li>\n<li>Landing Page</li>\n<li>Онлайн каталог</li>\n<li>Страница товара</li>\n<li>Блог и статьи</li>', 'service_2_list', 'ru', 2),
(275, '<li>Inside Admin Panel</li>\n<li>Special MAIN Page</li>\n<li>Catalog List</li>\n<li>Product Page</li>\n<li>Blog System</li>', 'service_2_list', 'en', 2),
(276, '<li> Розширена адмін. панель </li>\n<li> Дизайн та UI/UX</li>\n<li> Велика база даних</li>\n<li> PHP програмування </li>\n<li> API система </li>', 'service_3_list', 'ua', 2),
(277, '<li>Расширяемая админ. панель</li>\n<li>Дизайн и UI/UX</li>\n<li>Сложная база данных</li>\n<li>PHP программирование</li>\n<li>API система</li>\n', 'service_3_list', 'ru', 2),
(278, '<li>Inside Admin Panel</li>\n<li>Professional CMS</li>\n<li>Full-stack Development</li>\n<li>API System Core</li>\n<li>Special Solutions</li>', 'service_3_list', 'en', 2),
(279, '1. Коли почалася робота над продуктом?', 'new_1_title', 'ua', 2),
(280, '1. Когда началась работа над продуктом?', 'new_1_title', 'ru', 2),
(281, '1. When did the Inside found?', 'new_1_title', 'en', 2),
(282, 'Далі', 'more_info', 'ua', 2),
(283, 'Подробнее', 'more_info', 'ru', 2),
(284, 'More info', 'more_info', 'en', 2),
(285, '1. Без опису бізнес процесів ускладнюється його розвиток та автоматизація', 'new_1_title', 'ua', 2),
(286, '1. Без описания бизнес процессов усложняется его развитие и автоматизация', 'new_1_title', 'ru', 2),
(287, '1. Business Processes like a core in any business!', 'new_1_title', 'en', 2),
(288, 'The first version was created for the Flower.net.ua perfumery store in 2007 at Perl.', 'new_1_description', 'en', 2),
(289, 'Перша версія була створена для магазину парфумерії Flower.net.ua у 2007 році на Perl.', 'new_1_description', 'ua', 2),
(360, 'Історія створення Inside системи', 'info_block_title', 'ua', 2),
(290, 'Первая версия была создана для магазина парфюмерии Flower.net.ua в 2007 году на Perl.', 'new_1_description', 'ru', 2),
(291, '2. Навіщо знадобилося стільки років створювати Inside0?', 'new_2_title', 'ua', 2),
(292, '2. Зачем понадобилось столько лет создавать Inside0?', 'new_2_title', 'ru', 2),
(293, '2. Why did it take so many years to create Inside0?', 'new_2_title', 'en', 2),
(294, '3. Куди далі?', 'new_3_title', 'ua', 2),
(295, '3. Куда дальше?', 'new_3_title', 'ru', 2),
(296, '3. What plans do we have?', 'new_3_title', 'en', 2),
(297, 'Every year there was doubt and it seemed that the ideal solution for creating web services must enter the market, but new CMS and frameworks were always upset by their complexity and inconvenience of programming.\nThus, the system was a worthy alternative and, over time, got better and better.', 'new_2_description', 'en', 2),
(298, 'Каждый год было сомнение и казалось, что вот-вот на рынок выйдет идеальное решение для создания веб-сервисов, но всегда новые CMS и сборки огорчали своей сложностью и неудобством программирования.\nТаким образом система была достойной альтернативой и со временем становилась все лучше и лучше.', 'new_2_description', 'ru', 2),
(299, 'Щороку були сумніви та здавалося, що ось-ось на ринок вийде ідеальне рішення для створення веб-сервісів, але завжди нові CMS та збірки засмучували своєю складністю та незручністю програмування.\nТаким чином система була гідною альтернативою і з часом ставала все краще і краще.', 'new_2_description', 'ua', 2),
(300, 'We are currently preparing an advertising campaign and, after the first stage of sales, we plan to invest in the buildup version of CodeIgniter 3 and try to collaborate with the CodeIgniter Community in Canada.', 'new_3_description', 'en', 2),
(367, 'Name', 'name', 'en', 2),
(368, 'Ім’я', 'name', 'ua', 2),
(301, 'Зараз ми готуємо рекламну кампанію і після першого етапу продажу плануємо вкласти зароблені кошти у збірку версії на CodeIgniter 3 та спробувати співпрацювати з ком&#8217;юніті CodeIgniter у Канаді.', 'new_3_description', 'ua', 2),
(364, 'Contacts us', 'contact_us_h3', 'en', 2),
(365, 'Напишите нам', 'contact_us_h3', 'ru', 2),
(366, 'Имя', 'name', 'ru', 2),
(302, 'Сейчас мы готовим рекламную кампанию и после первого этапа продаж планируем вложить заработанные средства в сборку версии на CodeIgniter 3 и пробовать сотрудничать с комьюнити CodeIgniter в Канаде.', 'new_3_description', 'ru', 2),
(363, 'Напишіть нам', 'contact_us_h3', 'ua', 2),
(303, 'Ціни на деякі послуги та технології на основі Inside0', 'price_list_title', 'ua', 2),
(304, 'Цены на некоторые услуги и технологии на базе Inside0', 'price_list_title', 'ru', 2),
(305, 'Popular Inside0 solutions price-list', 'price_list_title', 'en', 2),
(306, 'ТОП-проекти з портфоліо', 'last_portfolio_projects', 'ua', 2),
(307, 'Last portfolio projects', 'last_portfolio_projects', 'en', 2),
(308, 'ТОП-проекты из портфолио', 'last_portfolio_projects', 'ru', 2),
(309, '(Ссылка на страницу портфолио)', 'last_portfolio_projects_link', 'ru', 2),
(310, '(Посилання на сторінку портфоліо)', 'last_portfolio_projects_link', 'ua', 2),
(311, '(Click here for show full portfolio projects list)', 'last_portfolio_projects_link', 'en', 2),
(312, 'Українська IT компанія Digital Outsourcing', 'seo_title_main_page', 'ua', 2),
(313, 'IT компания Digital Outsourcing', 'seo_title_main_page', 'ru', 2),
(314, 'Digital IT Outsourcing company', 'seo_title_main_page', 'en', 2),
(315, 'Digital marketing and IT outsourcing company, web professionals, freelancers, php development, project management services', 'seo_description_main_page', 'en', 2),
(316, 'Замовлення IT послуг, Digital маркетинг, ІТ аутсорсінг, веб-розробка, студія веб-сайтів.', 'seo_description_main_page', 'ua', 2),
(317, 'Заказать разработку IT проектов, \"диджитал\" маркетинг, IT аутсорсинг, веб-разработка, студия веб-сайтов.', 'seo_description_main_page', 'ru', 2),
(318, 'Закрыть', 'close', 'ru', 2),
(359, 'Close', 'close', 'en', 2),
(321, 'Ім&#8217;я та контакти (Email, Телефон, Skype):', 'request_form_label_1', 'ua', 2),
(322, 'Name and contacts (Email, Phone, Skype):', 'request_form_label_1', 'en', 2),
(323, 'Имя и контакты (Email, Телефон, Skype):', 'request_form_label_1', 'ru', 2),
(324, 'Повідомлення', 'message', 'ua', 2),
(325, 'Message', 'message', 'en', 2),
(326, 'Сообщение', 'message', 'ru', 2),
(327, 'Спасибо, мы свяжемся с вами позже!', 'thx_text_1', 'ru', 2),
(328, 'Thank you, we will contact you soon!', 'thx_text_1', 'en', 2),
(329, 'Дякую, ми зв&#8217;яжемося з вами пізніше!', 'thx_text_1', 'ua', 2),
(330, 'Оновити форму', 'refresh_form', 'ua', 2),
(331, 'Refresh form', 'refresh_form', 'en', 2),
(332, 'Обновить форму', 'refresh_form', 'ru', 2),
(333, 'Отправить', 'send_message', 'ru', 2),
(334, 'Send message', 'send_message', 'en', 2),
(335, 'Відправити', 'send_message', 'ua', 2),
(336, '<h2 class=\"featurette-heading\">Веб-студия и разработка сайтов от Digital-Outsourcing</h2>\n        <p>\n            И 500 символов текста сюда. И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n        </p>\n        <h2>\n            У нас вы можете заказать мобильное приложение недорого\n        </h2>\n        <p>\n            И 500 символов текста сюда. И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n        </p>\n\n        <h2>\n            Также мы делаем описание бизнес процессов для бизнеса\n        </h2>\n        <p>\n            И 500 символов текста сюда. И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n        </p>', 'seo_text_bottom', 'ua', 2),
(337, '<h2 class=\"featurette-heading\">Inside 4 from Digital-Outsourcing</h2>\n        <p>\n            Text text text text. Text text text text. Text text text text. Text text text text. Text text text text. Text text text text. Text text text text. \n        </p>\n        <h2>\n            Easy MVC Basis and Framework\n        </h2>\n        <p>\n            Text text text text. Text text text text. Text text text text. Text text text text. Text text text text. Text text text text. Text text text text. \n        </p>\n\n        <h2>\n            Readymade solution for any Web System\n        </h2>\n        <p>\n            Text text text text. Text text text text. Text text text text. Text text text text. Text text text text. Text text text text. Text text text text. \n        </p>', 'seo_text_bottom', 'en', 2),
(421, 'PWA App', 'pwa_app', 'en', 1),
(338, '<h2 class=\"featurette-heading\">Лучший движок для разработки веб сайтов</h2>\n        <p>\n            И 500 символов текста сюда. И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n        </p>\n        <h2>\n            Inside0 - это PHP фреймворк CodeIgniter с дополнениями\n        </h2>\n        <p>\n            И 500 символов текста сюда. И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n        </p>\n\n        <h2>\n            Готовая сборка для программирование - это лучшая CMS для сайта\n        </h2>\n        <p>\n            И 500 символов текста сюда. И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n            И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.И 500 символов текста сюда.\n        </p>', 'seo_text_bottom', 'ru', 2),
(339, 'Категория', 'category1', 'ru', 2),
(340, 'Категорія', 'category1', 'ua', 2),
(341, 'Category', 'category1', 'en', 2),
(342, 'Найменування', 'e_name1', 'ua', 2),
(343, 'Service Name', 'e_name1', 'en', 2),
(344, 'Наименование', 'e_name1', 'ru', 2),
(345, 'Ціна', 'price1', 'ua', 2),
(346, 'Price', 'price1', 'en', 2),
(347, 'Цена', 'price1', 'ru', 2),
(348, 'Час', 'time1', 'ua', 2),
(349, 'Время', 'time1', 'ru', 2),
(350, 'Time', 'time1', 'en', 2),
(351, '[дней]', 'days', 'ru', 2),
(352, 'days', 'days', 'en', 2),
(353, '[днів]', 'days', 'ua', 2),
(354, '[час]', 'hours', 'ru', 2),
(355, 'hours', 'hours', 'en', 2),
(356, '[год]', 'hours', 'ua', 2),
(358, 'Закрити', 'close', 'ua', 2),
(362, 'The history about Inside System', 'info_block_title', 'en', 2),
(369, 'Телефон', 'phone', 'ua', 2),
(370, 'Phone', 'phone', 'en', 2),
(371, 'Телефон', 'phone', 'ru', 2),
(372, 'Наши контакты', 'our_contacts', 'ru', 2),
(373, 'Our contacts', 'our_contacts', 'en', 2),
(374, 'Наші контакти', 'our_contacts', 'ua', 2),
(375, 'Наш телефон', 'our_phone', 'ua', 2),
(376, 'Our phone', 'our_phone', 'en', 2),
(377, 'Наш телефон', 'our_phone', 'ru', 2),
(378, '+38 (093) 155-29-70 - Александр', 'manager_phone', 'ru', 2),
(379, '+38 (093) 155-29-70 - Alexandr', 'manager_phone', 'en', 2),
(380, '+38 (093) 155-29-70 - Олександр', 'manager_phone', 'ua', 2),
(381, 'Email', 'our_email', 'en', 2),
(382, 'Наш email', 'our_email', 'ua', 2),
(383, 'Наш email', 'our_email', 'ru', 2),
(384, 'Наш адрес: <span>Мы находимся в БЦ Парус</span>', 'our_address', 'ru', 2),
(385, 'Address: <span> BC \"Parus\"</span>', 'our_address', 'en', 2),
(386, 'Наша адреса: <span>Ми знаходимось у БЦ Парус</span>', 'our_address', 'ua', 2),
(387, 'Worktime: 14:00-17:00 UTC +2', 'office_time', 'en', 2),
(388, 'Час для зустрічі в офісі:14:00-17:00<br>(можемо приїхати до вам у гості)', 'office_time', 'ua', 2),
(389, 'Время для встреч в офисе:14:00-17:00<br>(можем приехать к вам в офис)', 'office_time', 'ru', 2),
(390, 'Ваше повідомлення збережено!', 'message_saved', 'ua', 2),
(391, 'Message saved!', 'message_saved', 'en', 2),
(392, 'Ваше сообщение сохранено!', 'message_saved', 'ru', 2),
(393, 'Введіть адресу електронної пошти', 'enter_email_here', 'ua', 3),
(394, 'Введите адрес электронной почты', 'enter_email_here', 'ru', 3),
(395, 'Enter your email', 'enter_email_here', 'en', 3),
(396, 'Зареєструватися', 'sign_up', 'ua', 3),
(397, 'Зарегистрироваться', 'sign_up', 'ru', 3),
(398, 'Sign Up', 'sign_up', 'en', 3),
(399, 'An email will be sent to your email address with instructions for changing your password.', 'pass_recovery_mess', 'en', 3),
(400, 'На адресу вашої електронної пошти буде надіслано лист з інструкцією по зміні пароля', 'pass_recovery_mess', 'ua', 3),
(401, 'На адрес вашей электронной почты будет выслано письмо с инструкцией по смене пароля', 'pass_recovery_mess', 'ru', 3),
(402, 'Увійти за допомогою', 'login_with', 'ua', 3),
(403, 'Войти с помощью', 'login_with', 'ru', 3),
(404, 'Login with', 'login_with', 'en', 3),
(405, 'Personal data', 'personal_data', 'en', 3),
(406, 'Личный данные', 'personal_data', 'ru', 3),
(407, 'Особисті дані', 'personal_data', 'ua', 3),
(417, 'Your Best Offer!', 'your_best_offer', 'en', 2),
(418, 'Ваше лучшее предложение!', 'your_best_offer', 'ru', 2),
(419, 'Information about something to motivate customers immediately make an online order or register to get a promotional code. This information must be short and interesting. Also, it can be some kind of short story or fun fairy tale with magic and dragons :)\n<br><br>\nDiscount: -10%\n<br>\nOr some kind of present!', 'sale_info', 'en', 2),
(420, 'Информация о акции для мотивации клиентов сразу-же оставить онлайн заказ или зарегистрироваться в личном кабинете и получить промо-код!\n                    <br><br>\n                    Это может дать скидку: -10%\n                    <br>\n                    Или какой-то подарок!', 'sale_info', 'ru', 2);

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
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `auth_users`
--
ALTER TABLE `auth_users`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `auth_users_groups`
--
ALTER TABLE `auth_users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT для таблицы `inside_log`
--
ALTER TABLE `inside_log`
  MODIFY `log_id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT для таблицы `inside_modules`
--
ALTER TABLE `inside_modules`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `inside_sessions`
--
ALTER TABLE `inside_sessions`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT для таблицы `inside_sessions_actions`
--
ALTER TABLE `inside_sessions_actions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5931;

--
-- AUTO_INCREMENT для таблицы `inside_top_menu`
--
ALTER TABLE `inside_top_menu`
  MODIFY `top_menu_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT для таблицы `it_banners`
--
ALTER TABLE `it_banners`
  MODIFY `banners_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `it_categories`
--
ALTER TABLE `it_categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `it_comments`
--
ALTER TABLE `it_comments`
  MODIFY `comments_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `it_content`
--
ALTER TABLE `it_content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `it_menu`
--
ALTER TABLE `it_menu`
  MODIFY `menu_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `it_requests`
--
ALTER TABLE `it_requests`
  MODIFY `requests_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `it_tags`
--
ALTER TABLE `it_tags`
  MODIFY `tags_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `lang_names`
--
ALTER TABLE `lang_names`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `lang_vocabulary`
--
ALTER TABLE `lang_vocabulary`
  MODIFY `vocabulary_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
