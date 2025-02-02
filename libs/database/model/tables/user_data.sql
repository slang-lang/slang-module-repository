CREATE TABLE `user_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `send_login_notifications` tinyint(1) NOT NULL DEFAULT 0,
  `send_mail_notifications` tinyint(1) NOT NULL DEFAULT 0,
  `api_key` varchar(256) DEFAULT NULL,
  `language` varchar(4) NOT NULL DEFAULT 'DE',
  PRIMARY KEY (`id`),
  KEY `user_data_users_identifier_fk` (`identifier`),
  CONSTRAINT `user_data_users_identifier_fk` FOREIGN KEY (`identifier`) REFERENCES `users` (`identifier`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;