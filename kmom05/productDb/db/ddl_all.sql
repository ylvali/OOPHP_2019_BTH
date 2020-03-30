--
--
-- The complete ddl
-- By Ylvali 2019
--

SET NAMES 'utf8';

--
-- DROP BASE TABLES
--
DROP TABLE IF EXISTS test;

--
-- Create table: larare
--
CREATE TABLE test
(
    akronym CHAR(10),

    PRIMARY KEY (akronym)
)ENGINE INNODB
CHARSET utf8
COLLATE utf8_swedish_ci;
;
