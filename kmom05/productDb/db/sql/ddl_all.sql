--
--
-- The complete ddl
-- By Ylvali 2019
--

SET NAMES 'utf8';

--
-- DROP BASE TABLES
--
DROP TABLE IF EXISTS products;

--
-- Create table: products
--
CREATE TABLE products
(
    id CHAR(10),
    name CHAR(20),
    pic CHAR(50),
    year INT(4),

    PRIMARY KEY (id)
)ENGINE INNODB
CHARSET utf8
COLLATE utf8_swedish_ci;
;
