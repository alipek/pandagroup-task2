DROP TABLE IF EXISTS `mockaroo`;
CREATE TABLE `mockaroo`
(
    `id`         INTEGER UNSIGNED auto_increment,
    `first_name` VARCHAR(64)             NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `last_name`  VARCHAR(64)             NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `email`      VARCHAR(255)            NOT NULL,
    `gender`     ENUM ('Female', 'Male') NULL,
    `ip_address` varchar(16)             NULL,
    `country`    VARCHAR(255)            NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDb,
  AUTO_INCREMENT = 0,
  CHARACTER SET 'utf8'
;






