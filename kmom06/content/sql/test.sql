
USE ;
--
-- Test that the tables have been created
--
SELECT * FROM TheBasePHPTest;

SELECT * FROM TheBaseUsers;

SELECT * FROM content;

SELECT * FROM TheBasePHPTest WHERE id LIKE 'test1' ORDER BY id ASC LIMIT 5 OFFSET 0;