<?php
/**
 *   Reset
 *   php version 7
 *   Data for resetting the SQL
 *
 * @category DbConnection
 * @package  Products
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 */

$resetSQL = "DROP TABLE IF EXISTS products;
CREATE TABLE products
    (
    id CHAR(10),
    name CHAR(20),
    pic CHAR(250),
    year INT(4),
    PRIMARY KEY (id)
    )
    ENGINE INNODB
    CHARSET utf8
    COLLATE utf8_swedish_ci;";


$resetSQL .=
"DELETE FROM products;
INSERT INTO products (id, name, pic, year)
VALUES ('prodJ', 'print J', '../img/purpleYellowFlo300px.jpg', '2020'),
 ('printA', 'print A', '../img/purpleYellowFlo300px.jpg', '2020'),
 ('printB', 'print B', '../img/purpleYellowFlo300px.jpg', '1919'),
 ('printC', 'print C', '../img/purpleYellowFlo300px.jpg', '2020'),
 ('printD', 'print D', '../img/purpleYellowFlo300px.jpg', '2019'),
 ('printE', 'print E', '../img/purpleYellowFlo300px.jpg', '2020'),
 ('printF', 'print F', '../img/purpleYellowFlo300px.jpg', '2019'),
 ('printG', 'print G', '../img/purpleYellowFlo300px.jpg', '2018'),
 ('printH', 'print H', '../img/purpleYellowFlo300px.jpg', '2018'),
 ('printI', 'print I', '../img/purpleYellowFlo300px.jpg', '2020');
";
