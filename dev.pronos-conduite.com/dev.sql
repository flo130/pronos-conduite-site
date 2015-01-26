SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `pronos-conduite` ;
CREATE SCHEMA IF NOT EXISTS `pronos-conduite` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `pronos-conduite` ;

-- -----------------------------------------------------
-- Table `pronos-conduite`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`user` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `mail` VARCHAR(200) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `group` INT NULL,
  `role` VARCHAR(45) NULL,
  `image` VARCHAR(200) NULL,
  `notification_not_seen` VARCHAR(45) NULL,
  `alert_not_seen` VARCHAR(45) NULL,
  `creation` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`user_stat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`user_stat` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`user_stat` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nb_prono_vic` INT NULL,
  `nb_prono_nul` INT NULL,
  `nb_prono_def` INT NULL,
  `nb_prono_ok_match` INT NULL,
  `nb_prono_ok_score` INT NULL,
  `nb_prono_ko` INT NULL,
  `id_user` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`role` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`role` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`group` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`group` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `creation_date` DATETIME NOT NULL,
  `created_by` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`notification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`notification` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`notification` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_type` INT NOT NULL COMMENT 'id du paris, du commentaire...',
  `type` VARCHAR(45) NOT NULL COMMENT 'qu\'est-ce c\'est ? une notif de paris, de commentaire ?...',
  `date` DATETIME NOT NULL,
  `action` VARCHAR(45) NOT NULL COMMENT 'mise à jour d\'un commentaire\najout, suppression... \nex : défférence entre ajout d\'un bet et mise à jour d\'un bet',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`comment` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`comment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_type` INT NOT NULL COMMENT 'id du paris, id de la notifs...',
  `type` VARCHAR(45) NOT NULL COMMENT 'qu\'est-ce qu\'on commente : un paris, des stats, un commentaire lui-meme... ',
  `content` VARCHAR(200) NULL,
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`trip`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`trip` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`trip` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_match` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`bet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`bet` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`bet` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_match` INT NOT NULL,
  `score_one` INT NOT NULL,
  `score_two` INT NOT NULL,
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`litige`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`litige` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`litige` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content` VARCHAR(200) NOT NULL,
  `date` DATETIME NOT NULL,
  `date_start` DATETIME NOT NULL,
  `date_end` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`litige_result`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`litige_result` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`litige_result` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_litige` INT NOT NULL,
  `id_user` INT NOT NULL,
  `result` VARCHAR(45) NOT NULL,
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`match`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`match` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`match` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_med` INT NOT NULL,
  `team_one` INT NOT NULL,
  `team_two` INT NOT NULL,
  `score_team_one` INT NULL DEFAULT NULL,
  `score_team_two` INT NULL DEFAULT NULL,
  `cote_team_one` DOUBLE NULL DEFAULT NULL,
  `cote_team_two` DOUBLE NULL DEFAULT NULL,
  `cote_nul` DOUBLE NULL DEFAULT NULL,
  `date` DATETIME NOT NULL,
  `status` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`newsletter_subscibtion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`newsletter_subscibtion` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`newsletter_subscibtion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idnewsletter_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`alert`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`alert` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`alert` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(200) NULL,
  `date` DATETIME NOT NULL,
  `satut` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idalert_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`team`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`team` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`team` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_med` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pronos-conduite`.`user_connection_history`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pronos-conduite`.`user_connection_history` ;

CREATE TABLE IF NOT EXISTS `pronos-conduite`.`user_connection_history` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `login` DATETIME NULL,
  `logout` DATETIME NULL,
  `ip` VARCHAR(45) NULL,
  `browser` VARCHAR(100) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
