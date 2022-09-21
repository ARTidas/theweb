CREATE TABLE `theweb`.`actors` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(45) COLLATE utf8_general_ci DEFAULT NULL,
 `name_plural` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
 `description` text COLLATE utf8_general_ci DEFAULT NULL,
 `is_active` tinyint(4) NOT NULL,
 `created_at` datetime NOT NULL,
 `updated_at` datetime NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `name_UNIQUE` (`name`),
 UNIQUE KEY `name_plural_UNIQUE` (`name_plural`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
