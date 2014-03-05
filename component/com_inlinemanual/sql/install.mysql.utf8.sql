CREATE TABLE `#__inlinemanual_topics` (
  `id` INT(11) NOT NULL DEFAULT '0' COMMENT 'The topic id.',
  `title` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Title of the topic.',
  `description` LONGTEXT NOT NULL COMMENT 'Description of the topic.',
  `steps` LONGTEXT NOT NULL COMMENT 'Topic steps.',
  `timestamp` INT(11) DEFAULT NULL COMMENT 'Timestamp.',
  `status` INT(11) NOT NULL DEFAULT '1' COMMENT 'Boolean indicating whether the topic is enabled.',
  `version` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Version of the topic.',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Stores the individual topics imported from INM portal.';
