CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_modules` AS select `modules`.`last_update` AS `last_update`,`modules`.`name` AS `name`,`modules`.`architecture` AS `architecture`,max(`modules`.`version`) AS `version`,`modules`.`owner` AS `owner`,min(`modules`.`added`) AS `added`,`modules`.`keywords` AS `keywords`,`modules`.`downloads` AS `downloads`,`modules`.`repository` AS `repository` from `modules` group by `modules`.`name`,`modules`.`architecture` order by `modules`.`name`,`modules`.`architecture`;