CREATE TABLE `tasks` (
    `id` int(11) NOT NULL,
    `todoTitle` varchar(200) COLLATE utf8_bin NOT NULL,
    `todoDescription` text COLLATE utf8_bin NOT NULL,
    `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

ALTER TABLE `tasks` ADD UNIQUE KEY `id` (`id`);

ALTER TABLE tasks MODIFY id INT NOT NULL AUTO_INCREMENT;