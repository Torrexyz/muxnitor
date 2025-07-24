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

CREATE TABLE `catalog`(
  `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `code` VARCHAR(5) NOT NULL,
  `subject` VARCHAR(50) NOT NULL,
  `group` VARCHAR(3) NULL,
  `schedule` VARCHAR(13) NULL,
  `professor` VARCHAR(70) NULL,
  `user` VARCHAR(50) NULL,
  CONSTRAINT `fk__catalog__user`
    FOREIGN KEY (`user`) REFERENCES user(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
);
