<?php
/**
 *  DbCrud
 *  php version 7
 *  Database - create | read | update | delete
 *
 * @category DbConnection
 * @package  ProjectDb
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

namespace Ylva\ProductDb;

use PHPUnit\Framework\TestCase;

/**
 *  DbCrud
 *  php version 7
 *  Database - create | read | update | delete
 *
 * @category DbConnection
 * @package  ProjectDb
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/
class DbCrudCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     *
     * @return void
     */
    public function testCreateObject()
    {
        $host = '127.0.0.1';
        $theDb = 'oophp';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Ylva\ProductDb\DbBase", $dbBase);

        // Test creating an oject
        $dbCrud = new DbCrud($dbBase);

        // Table to use
        $table = 'products';

        // Test reading an existing table
        // $table = 'products';
        $res = $dbCrud->read($table);
        $this->assertNotNull($res);

        // Test free text sql
        $sql = 'SELECT * FROM products';
        $res2 = $dbCrud->freeTextSQL($sql);
        $this->assertNotNull($res2);
        //var_dump($res2);

        // Test search function
        // $table = 'products';
        $column = 'id';
        $name = 'prod11';
        $res3 = $dbCrud->search($table, $column, $name);
        //var_dump($res3);
        $this->assertNotNull($res3);

        // Test update function
        // $table = 'products';
        $params = ['id'=>'prod1', 'name'=>'test4', 'year'=>'2020'];
        $identifyingVar = 'id';
        $identifyingValue = 'prod1';
        $res4 = $dbCrud->update($table, $params, $identifyingVar, $identifyingValue);
        $this->assertNotNull($res4);

        // Test create function
        // $table = 'products';
        $params = ['id'=>'prod12', 'name'=>'product12', 'year'=>'2020'];
        $res5 = $dbCrud->create($table, $params);
        $this->assertNotNull($res5);

        // Test delete function
        // $table = 'products';
        $column2 = 'id';
        $value = 'prod12';
        $res6 = $dbCrud->delete($table, $column2, $value);
        $this->assertNotNull($res6);

        // Assert that item is removed
        $column = 'id';
        $name = 'prod12';
        $res7 = $dbCrud->search($table, $column, $name);
        var_dump($res7);
        $notThere = empty($res7);
        $this->assertTrue($notThere);

        // // Test the ordering functionality
        // $orderBy = 'id';
        // $order = 'DESC';
        // $res = $dbCrud->readInOrder($table, $orderBy, $order);
        // // var_dump($res);
        // $this->assertNotNull($res);

        // Test counting the rows
        $idVar = 'id';
        $res = $dbCrud->countRows($idVar, $table);
        // $isNr = is_numeric($res);
        $this->assertNotNull($res);
        // var_dump($res);

        // Test select limit offset
        $limit = 2;
        $offset = 1;
        $res = $dbCrud->selectLimitOffset($table, $limit, $offset);
        // var_dump($res);

        // Test select limit offset with orderBy and order
        $limit = 2;
        $offset = 0;
        $orderBy = 'id';
        $order = 'DESC';
        $res = $dbCrud->selectLimitOffset($table, $limit, $offset, $orderBy, $order);
        // var_dump($res);
    }
}
