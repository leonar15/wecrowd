CREATE DATABASE IF NOT EXISTS `wecrowd`;
USE `wecrowd`;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `roles` (`id`, `name`, `description`)
  VALUES
    (1, 'login', 'Login privileges, granted after account confirmation'),
    (2, 'admin', 'Administrative user, has access to everything.')
;

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY  (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL,
  `logins` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `last_login` int(10) UNSIGNED,
  `created` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Unix timestamp',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `created` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Unix timestamp',
  `expires` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Unix timestamp',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`),
  KEY `expires` (`expires`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `campaigns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name`varchar(255) NOT NULL,
  `last_name`varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `campaign_name` varchar(255),
  `description` text,
  `image` varchar(255) NOT NULL DEFAULT '',
  `wepay_access_token` text,
  `wepay_account_id` bigint(20) DEFAULT NULL,
  `account_type` int(3) default 0,
  `state` varchar(255) DEFAULT 'pending',
  `default_donation` int(11) DEFAULT NULL,
  `total_goal` int(11) DEFAULT NULL,
  `total_raised` int(11) DEFAULT NULL,
  `currency` char(3) NOT NULL DEFAULT 'XXX',
  `created` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Unix timestamp',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
