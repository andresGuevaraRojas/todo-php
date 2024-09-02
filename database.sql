CREATE DATABASE todo_list;

USE todo_list;

CREATE TABLE `todo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('PENDING','IN_PROGRESS','DONE') NOT NULL,
  PRIMARY KEY (`id`)
);