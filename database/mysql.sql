/** create database **/
CREATE DATABASE IF NOT EXISTS `mvc`
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_general_ci;

/** use database **/
USE `mvc`;

/** create users table **/
CREATE TABLE IF NOT EXISTS `users`
(
	`serial` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` BIGINT UNSIGNED NOT NULL UNIQUE,
	`user_name` VARCHAR(20) NOT NULL UNIQUE,
	`user_email` VARCHAR(80) NOT NULL UNIQUE,
	`user_password` CHAR(60) NOT NULL,
	`user_token` CHAR(128) NOT NULL UNIQUE,
	`user_created` DATETIME DEFAULT NOW(),
	`user_updated` TIMESTAMP,  
	PRIMARY KEY (`serial`)
)
	ENGINE innoDB
	DEFAULT CHARACTER SET utf8mb4
	DEFAULT COLLATE utf8mb4_general_ci
	AUTO_INCREMENT 1
;