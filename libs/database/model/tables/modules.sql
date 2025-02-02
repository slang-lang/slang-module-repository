CREATE TABLE `modules` (
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(80) NOT NULL,
  `architecture` varchar(32) NOT NULL,
  `version` varchar(32) NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `added` timestamp NOT NULL DEFAULT current_timestamp(),
  `keywords` varchar(1024) DEFAULT NULL,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `repository` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`name`,`architecture`,`version`),
  KEY `modules_users_FK` (`owner`),
  CONSTRAINT `modules_users_FK` FOREIGN KEY (`owner`) REFERENCES `users` (`identifier`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;