--
--
-- The complete ddl
-- By Ylvali 2019
--

SET NAMES 'utf8';


DROP TABLE IF EXISTS products;

--
-- Create table: products
--
CREATE TABLE products
(
    id CHAR(10),
    name CHAR(20),
    pic CHAR(20),
    year INT(4),

    PRIMARY KEY (id)
)ENGINE INNODB
CHARSET utf8
COLLATE utf8_swedish_ci;
;

-- Delete all from before

DELETE FROM products;
--
-- Add products
--
INSERT INTO products
	(id, name, pic, year)
  VALUES
    ('prod1', 'product1', 'product1.jpg', '2020'),
	('prod2', 'product2', 'product2.jpg', '2020'),
	('prod3', 'product3', 'product3.jpg', '1919'),
	;
