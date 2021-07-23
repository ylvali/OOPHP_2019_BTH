-- Delete all from before

DELETE FROM products;
--
-- Add products
--
INSERT INTO products
	(id, name, pic, year)
  VALUES
    ('prod1', 'product1', '../img/lush300px.jpg', '2020'),
	('prod2', 'product2', '../img/lush300px.jpg', '2020'),
	('prod3', 'product3', '../img/lush300px.jpg', '2019'),
	('prod4', 'product4', '../img/lush300px.jpg', '2020'),
	('prod5', 'product5', '../img/lush300px.jpg', '2019'),
	('prod6', 'product6', '../img/lush300px.jpg', '2020'),
	('prod7', 'product7', '../img/lush300px.jpg', '2019'),
	('prod8', 'product8', '../img/lush300px.jpg', '2018'),
	('prod9', 'product9', '../img/lush300px.jpg', '2018'),
	('prod10', 'product10', '../img/lush300px.jpg', '2020')
	;
