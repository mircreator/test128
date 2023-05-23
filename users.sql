/* базаданных пользователей */
CREATE TABLE `users` (
    `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'уникальный идентификатор пользователя',
    `id_tg` bigint NOT NULL DEFAULT '0' COMMENT 'идентификатор пользователя в телеграм',
    `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'имя пользователя',
    `auth_key` char(64) NOT NULL DEFAULT '' COMMENT 'уникальный ключ авторизации',
    `auth_tg` char(64) NOT NULL DEFAULT '' COMMENT 'уникальный ключ авторизации через телеграм',
    PRIMARY KEY (`id`),
    KEY (`id_tg`),
    KEY (`auth_key`),
    KEY (`auth_tg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;