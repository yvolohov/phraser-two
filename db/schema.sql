CREATE TABLE IF NOT EXISTS `phrases` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
  `phrase` VARCHAR(255) NOT NULL,
  `category_id` INT(11) DEFAULT 0 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`phrase`),
  KEY (`category_id`)
) ENGINE = InnoDB, CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `tests` (
  `phrase_id` INT(11) UNSIGNED NOT NULL,
  `passages_cnt` INT(11) UNSIGNED DEFAULT 0 NOT NULL,
  `first_passage` datetime DEFAULT '1970-01-01 00:00:00' NOT NULL,
  `last_passage` datetime DEFAULT '1970-01-01 00:00:00' NOT NULL,
  PRIMARY KEY (`phrase_id`)
) ENGINE = InnoDB, CHARACTER SET = utf8;
