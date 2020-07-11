-- Ensure UTF8 as chacrter encoding within connection.
SET NAMES utf8;

--
-- Create table for Landing page
--
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,

    `title` VARCHAR(120),
    `data` TEXT,
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
