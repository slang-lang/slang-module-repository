CREATE TABLE `user_data_github` (
  `identifier` varchar(255) NOT NULL,
  `external_id` varchar(255) NOT NULL COMMENT 'User ID (id)',
  `username` varchar(255) NOT NULL COMMENT 'Username (login)',
  `email` varchar(255) DEFAULT NULL COMMENT 'Email (email)',
  `profile_picture` varchar(1024) DEFAULT NULL COMMENT 'Profile Picture (avatar_url)',
  `create_time` datetime DEFAULT NULL COMMENT 'Account Creation Date (created_at)',
  KEY `user_data_github_users_identifier_fk` (`identifier`),
  CONSTRAINT `user_data_github_users_identifier_fk` FOREIGN KEY (`identifier`) REFERENCES `users` (`identifier`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Github OAuth user data';