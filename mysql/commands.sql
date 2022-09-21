CREATE USER 'theroot'@'localhost' IDENTIFIED WITH mysql_native_password AS '***';GRANT ALL PRIVILEGES ON *.* TO 'theroot'@'localhost' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

ufWUEo(2s%2v*Ox8D(q5zv!CLT8%FrkM)wkSNT#*3ZMn*kuw(V7D6)+6))rZewI9


CREATE USER 'theweb'@'localhost' IDENTIFIED WITH mysql_native_password AS '***';GRANT SELECT, INSERT, UPDATE ON *.* TO 'theweb'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

CREATE TABLE `actors` (
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
