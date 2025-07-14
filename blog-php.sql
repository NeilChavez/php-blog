-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema blog-php
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema blog-php
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `blog-php` DEFAULT CHARACTER SET utf8mb3 ;
USE `blog-php` ;

-- -----------------------------------------------------
-- Table `blog-php`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog-php`.`categories` (
  `category_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NULL DEFAULT NULL,
  `description` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `blog-php`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog-php`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NULL DEFAULT '@user',
  `avatar` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(150) NULL DEFAULT NULL,
  `password` VARCHAR(60) NULL DEFAULT NULL,
  `role` ENUM('admin', 'author', 'subscriber') NULL DEFAULT 'subscriber',
  `token` TEXT NULL DEFAULT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `blog-php`.`posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog-php`.`posts` (
  `post_id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NULL DEFAULT NULL,
  `feature_image` VARCHAR(255) NULL DEFAULT NULL,
  `content` LONGTEXT NULL DEFAULT NULL,
  `status` ENUM('draft', 'published') NULL DEFAULT 'draft',
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `user_id` INT NOT NULL,
  `slug` VARCHAR(200) NULL,
  PRIMARY KEY (`post_id`, `user_id`),
  INDEX `fk_posts_users_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_posts_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `blog-php`.`users` (`user_id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `blog-php`.`categories_has_posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog-php`.`categories_has_posts` (
  `post_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  PRIMARY KEY (`post_id`, `category_id`),
  INDEX `fk_categories_has_posts_categories1_idx` (`category_id` ASC) VISIBLE,
  CONSTRAINT `fk_categories_has_posts_categories1`
    FOREIGN KEY (`category_id`)
    REFERENCES `blog-php`.`categories` (`category_id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_categories_has_posts_posts1`
    FOREIGN KEY (`post_id`)
    REFERENCES `blog-php`.`posts` (`post_id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `blog-php`.`comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog-php`.`comments` (
  `comment_id` INT NOT NULL AUTO_INCREMENT,
  `content` VARCHAR(255) NULL DEFAULT NULL,
  `status` ENUM('pending', 'approved') NULL DEFAULT 'pending',
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `user_id` INT NOT NULL,
  `post_id` INT NOT NULL,
  PRIMARY KEY (`comment_id`, `user_id`, `post_id`),
  INDEX `fk_comments_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_comments_posts1_idx` (`post_id` ASC) VISIBLE,
  CONSTRAINT `fk_comments_posts1`
    FOREIGN KEY (`post_id`)
    REFERENCES `blog-php`.`posts` (`post_id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_comments_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `blog-php`.`users` (`user_id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `blog-php`.`categories`
-- -----------------------------------------------------
START TRANSACTION;
USE `blog-php`;
INSERT INTO `blog-php`.`categories` (`category_id`, `name`, `description`) VALUES (100, 'Sustainable Energy', 'Nuclear Fusion: 2024 Breakthroughs and Roadblocks');
INSERT INTO `blog-php`.`categories` (`category_id`, `name`, `description`) VALUES (101, 'Neuroscience', 'Study of the nervous system and brain function');
INSERT INTO `blog-php`.`categories` (`category_id`, `name`, `description`) VALUES (102, 'Climate Change', 'Tipping Points in the Climate System');
INSERT INTO `blog-php`.`categories` (`category_id`, `name`, `description`) VALUES (103, 'Astrophysics', 'Study of celestial objects and cosmic phenomena');
INSERT INTO `blog-php`.`categories` (`category_id`, `name`, `description`) VALUES (104, 'Nanomedicine', 'Medical applications of nanotechnology');
INSERT INTO `blog-php`.`categories` (`category_id`, `name`, `description`) VALUES (105, 'Ecological Conservation', 'Biodiversity protection and ecosystem restoration\n');

COMMIT;


-- -----------------------------------------------------
-- Data for table `blog-php`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `blog-php`;
INSERT INTO `blog-php`.`users` (`user_id`, `username`, `avatar`, `email`, `password`, `role`, `token`, `created_at`, `updated_at`) VALUES (100, 'testUser', 'image.jpeg', 'test@test.com', '$2y$10$YCyPp.NY9dQmqqAtQ470AufAPZp68UhZxkk858OW47UNm1IXpGev6', 'admin', '1', NULL, NULL);
INSERT INTO `blog-php`.`users` (`user_id`, `username`, `avatar`, `email`, `password`, `role`, `token`, `created_at`, `updated_at`) VALUES (102, 'Ralph', 'imag.jpeg', 'ralph@test.com', '$2y$10$YCyPp.NY9dQmqqAtQ470AufAPZp68UhZxkk858OW47UNm1IXpGev6', 'author', '1', NULL, NULL);
INSERT INTO `blog-php`.`users` (`user_id`, `username`, `avatar`, `email`, `password`, `role`, `token`, `created_at`, `updated_at`) VALUES (103, 'Sebatian', 'image.jpeg', 'sebastian@test.com', '$2y$10$YCyPp.NY9dQmqqAtQ470AufAPZp68UhZxkk858OW47UNm1IXpGev6', 'author', '1', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `blog-php`.`posts`
-- -----------------------------------------------------
START TRANSACTION;
USE `blog-php`;
INSERT INTO `blog-php`.`posts` (`post_id`, `title`, `feature_image`, `content`, `status`, `created_at`, `updated_at`, `user_id`, `slug`) VALUES (100, 'title', 'image.jpeg', 'content', 'published', NULL, NULL, 100, 'title-slug');

COMMIT;


-- -----------------------------------------------------
-- Data for table `blog-php`.`categories_has_posts`
-- -----------------------------------------------------
START TRANSACTION;
USE `blog-php`;
INSERT INTO `blog-php`.`categories_has_posts` (`post_id`, `category_id`) VALUES (100, 100);

COMMIT;


-- -----------------------------------------------------
-- Data for table `blog-php`.`comments`
-- -----------------------------------------------------
START TRANSACTION;
USE `blog-php`;
INSERT INTO `blog-php`.`comments` (`comment_id`, `content`, `status`, `created_at`, `updated_at`, `user_id`, `post_id`) VALUES (100, 'comment content', 'approved', NULL, NULL, 102, 100);

COMMIT;

