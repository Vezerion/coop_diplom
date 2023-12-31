-- MySQL Script generated by MySQL Workbench
-- Sat Jun 24 20:33:49 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema j-5cloud
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema j-5cloud
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `j-5cloud` DEFAULT CHARACTER SET utf8 ;
USE `j-5cloud` ;

-- -----------------------------------------------------
-- Table `j-5cloud`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `j-5cloud`.`user` (
  `user_id` BIGINT NOT NULL,
  `login` VARCHAR(128) NOT NULL,
  `userpass` VARCHAR(128) NOT NULL,
  `email` VARCHAR(128) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `j-5cloud`.`dir`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `j-5cloud`.`dir` (
  `dir_id` VARCHAR(128) NOT NULL,
  `date_of_create` VARCHAR(128) NULL,
  PRIMARY KEY (`dir_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `j-5cloud`.`user_has_files`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `j-5cloud`.`user_has_files` (
  `user_id` BIGINT NOT NULL,
  `dir_id` VARCHAR(128) NOT NULL,
  INDEX `fk_user_has_files_files1_idx` (`dir_id` ASC) VISIBLE,
  CONSTRAINT `fk_user_has_files_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `j-5cloud`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_files_files1`
    FOREIGN KEY (`dir_id`)
    REFERENCES `j-5cloud`.`dir` (`dir_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `j-5cloud`.`profile`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `j-5cloud`.`profile` (
  `username` VARCHAR(128) NULL,
  `name` VARCHAR(128) NULL,
  `surname` VARCHAR(128) NULL,
  `date_of_birth` DATETIME NULL,
  `country` VARCHAR(128) NULL,
  `city` VARCHAR(128) NULL,
  `phone` VARCHAR(128) NULL,
  `date_of_create` VARCHAR(128) NULL,
  `user_id` BIGINT NOT NULL,
  INDEX `fk_profile_user1_idx` (`user_id` ASC) VISIBLE,
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_profile_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `j-5cloud`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `j-5cloud`.`storage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `j-5cloud`.`storage` (
  `dirname` VARCHAR(128) NULL,
  `filename` VARCHAR(128) NULL,
  `filesize` INT NULL,
  `type` VARCHAR(128) NULL,
  `date_of_upload` VARCHAR(128) NULL,
  `path` VARCHAR(128) NULL,
  `dir_ID` VARCHAR(128) NOT NULL,
  INDEX `fk_storage_files1_idx` (`dir_ID` ASC) VISIBLE,
  CONSTRAINT `fk_storage_files1`
    FOREIGN KEY (`dir_ID`)
    REFERENCES `j-5cloud`.`dir` (`dir_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `j-5cloud`.`feedback`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `j-5cloud`.`feedback` (
  `user_id` BIGINT NOT NULL,
  `feedback_msg` VARCHAR(512) NULL,
  `tech_prob_msg` VARCHAR(512) NULL,
  `date_of_create` DATETIME NULL,
  `feed_token` INT NOT NULL AUTO_INCREMENT,
  INDEX `fk_feedback_user1_idx` (`user_id` ASC) VISIBLE,
  PRIMARY KEY (`feed_token`),
  CONSTRAINT `fk_feedback_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `j-5cloud`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
