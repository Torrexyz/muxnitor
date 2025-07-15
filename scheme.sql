SET GLOBAL time_zone = '-05:00';
CREATE DATABASE muxnitor;
USE muxnitor_utp;

/*<><><><><><><><><><>*/

CREATE TABLE `user`(
  `table` INT UNIQUE AUTO_INCREMENT NOT NULL,
  `id` VARCHAR(50) PRIMARY KEY NOT NULL,
  `folder` VARCHAR(50) UNIQUE NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `prefix` ENUM('FI') NOT NULL,
  `lastsess` DATETIME NOT NULL DEFAULT NOW()
);
