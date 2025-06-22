SET GLOBAL time_zone = '-05:00';
CREATE DATABASE muxnitor_utp;
USE muxnitor_utp;

/*<><><><><><><><><><>*/

CREATE TABLE `monitor`(
  `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `folder` VARCHAR(40) UNIQUE NOT NULL,
  `email` VARCHAR(50) UNIQUE NOT NULL,
  `name` VARCHAR(35) NOT NULL
);
