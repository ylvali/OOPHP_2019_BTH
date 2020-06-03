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
	('prod3', 'product3', 'product3.jpg', '2019'),
	('prod4', 'product4', 'product4.jpg', '2020'),
	('prod5', 'product5', 'product5.jpg', '2019'),
	('prod6', 'product6', 'product6.jpg', '2020'),
	('prod7', 'product7', 'product7.jpg', '2019'),
	('prod8', 'product8', 'product8.jpg', '2018'),
	('prod9', 'product9', 'product9.jpg', '2018'),
	('prod10', 'product10', 'product10.jpg', '2020'),
	;
