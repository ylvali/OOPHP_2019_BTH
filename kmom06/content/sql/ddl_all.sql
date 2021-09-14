--
--
-- DDL : Base table test set up
-- Yso2020
--

SET NAMES 'utf8';

--
-- DROP BASE TABLES
--
DROP TABLE IF EXISTS TheBasePHPTest;
DROP TABLE IF EXISTS TheBaseUsers;


--
-- Create table: phpBase
--
CREATE TABLE TheBasePHPTest
(
    id CHAR(10) NOT NULL,
    name CHAR(10),

    PRIMARY KEY (id)
)ENGINE INNODB
CHARSET utf8
COLLATE utf8_swedish_ci;
;


--
-- Create table: users
--
CREATE TABLE TheBaseUsers
(
    id CHAR(10),
    name CHAR(20),
    pass CHAR(255),

    PRIMARY KEY (id)
)ENGINE INNODB
CHARSET utf8
COLLATE utf8_swedish_ci;
;

-- Ensure UTF8 as chacrter encoding within connection.
SET NAMES utf8;

--
-- Create table for Content
--
DROP TABLE IF EXISTS `content`;
CREATE TABLE `content`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `path` CHAR(120) UNIQUE,
    `slug` CHAR(120) UNIQUE,

    `title` VARCHAR(120) UNIQUE,
    `data` TEXT,
    `type` CHAR(20),
    `filter` VARCHAR(80) DEFAULT NULL,

    -- MySQL version 5.6 and higher
    `published` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    -- MySQL version 5.5 and lower
    -- `published` DATETIME DEFAULT NULL,
    -- `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- `updated` DATETIME DEFAULT NULL, --  ON UPDATE CURRENT_TIMESTAMP,

  `deleted` DATETIME DEFAULT NULL

) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;
