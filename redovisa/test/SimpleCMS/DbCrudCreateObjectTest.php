<?php
/**
 *  DbCrud :::: v.3.1
 *
 * The v.3.1 includes
 *  - the 'selectLimitOffsetWhere'
 *  - the v.3.1 includes the 'search' combined w 'searchExact'
 *
 *  php version 7
 *  Database CRUD
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://www.spektatum.com
 **/

namespace Anax\SimpleCMS;

use PHPUnit\Framework\TestCase;

/**
 *  DbCrud
 *  php version 7
 *  Database - create | read | update | delete
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://www.spektatum.com
 **/
class DbCrudCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties and functionality.
     *
     * @return void
     */
    public function testFunctionality1()
    {
        $host = '127.0.0.1';
        $theDb = 'theBasePHPTest';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        $dbAPI = new DbAPI($dbBase);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbAPI", $dbAPI);

        // Test creating an oject
        $dbCrud = new DbCrud($dbAPI);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbCrud", $dbCrud);

        // Set up db table
        $table = 'theBasePHPTest';
        $errTable = 'errorTable';

        // Test create function & control new values w search
        $params = ['id'=>'prod12', 'name'=>'product12'];
        $test = $dbCrud->create($table, $params);
        $this->assertNotNull($test);

        // Test searching the new values
        $theId = 'prod12';
        $column = 'id';
        $res1 = $dbCrud->search($table, $column, $theId);
        $name = $res1[0]->name;
        $this->assertEquals($name, 'product12');

        $theId = 'prod12';
        $column = 'id';
        $incl = true;
        $res1Exact = $dbCrud->search($table, $column, $theId, $incl);
        $name = $res1Exact[0]->name;
        $this->assertEquals($name, 'product12');

        // Test create with error values
        $params = ['err'=>'err', 'err2'=>'err'];
        $errtest = $dbCrud->create($table, $params);
        $this->assertFalse($errtest);

        // Test searching with error value
        $theId = 'prod12';
        $column = 'id';
        $errorSearch = $dbCrud->search($errTable, $column, $theId);
        $this->assertFalse($errorSearch);

        $theId = 'prod12';
        $column = 'id';
        $incl = true;
        $errorSearchExact = $dbCrud->search($errTable, $column, $theId, $incl);
        $this->assertFalse($errorSearchExact);

        // Test update function & control new values
        $params = ['id'=>'prod1', 'name'=>'product1'];
        $identifyingVar = 'id';
        $identifyingValue = 'prod12';
        $res2 = $dbCrud->update($table, $params, $identifyingVar, $identifyingValue);
        $this->assertNotNull($res2);

        $theId = 'prod1';
        $column = 'id';
        $res3 = $dbCrud->search($table, $column, $theId);
        $nameUpdated = $res3[0]->name;
        $this->assertEquals($nameUpdated, 'product1');

        // Test update with error values
        $params = ['err'=>'err', 'err2'=>'err'];
        $identifyingVar = 'id';
        $identifyingValue = 'prod12';
        $errUpdate = $dbCrud->
        update($table, $params, $identifyingVar, $identifyingValue);
        $this->assertFalse($errUpdate);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties functionality.
     *
     * @return void
     */
    public function testFunctionality2()
    {
        $host = '127.0.0.1';
        $theDb = 'theBasePHPTest';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);
        // Test creating an oject
        $dbCrud = new DbCrud($dbBase);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbCrud", $dbCrud);
        // Set up db table
        $table = 'theBasePHPTest';
        $errTable = 'errorTable';
        // Test reading
        $orderBy = 'asc';
        $column = 'id';
        $res4 = $dbCrud->read($table, $column, $orderBy);
        $this->assertNotNull($res4);
        $this->assertTrue(is_array($res4));
        // Err table
        $res5 = $dbCrud->read($errTable, $column, $orderBy);
        $this->assertEmpty($res5);

        // Test counting the rows
        $idVar = 'id';
        $res6 = $dbCrud->countRows($idVar, $table);
        $isNr = is_numeric(floatval($res6));
        $this->assertTrue($isNr);
        $nrRowsExpected = 3;
        $nrRowsResult = floatval($res6[0]->rows);
        $this->assertEquals($nrRowsExpected, $nrRowsResult);
        // Test counting the rows
        $idVar = 'id';
        $column = 'id';
        $idVal = 'test2';
        $res6select = $dbCrud->countRows($idVar, $table, $column, $idVal);
        $isNr = is_numeric(floatval($res6select[0]->rows));
        $this->assertTrue($isNr);
        $this->assertEquals($res6select[0]->rows, 1);
        // Test counting the rows error table
        $idVar = 'id';
        $res6Err = $dbCrud->countRows($idVar, $errTable);
        $this->assertFalse($res6Err);
        // Test select limit offset
        $limit = 1;
        $offset = 2;
        $res7 = $dbCrud->selectLimitOffset(
            $table,
            $limit,
            $offset,
            $column,
            $orderBy
        );
        $this->assertNotEmpty($res7);
        $theId = $res7[0]->id;
        $expectedId = 'test2';
        $this->assertEquals($expectedId, $theId);
        // Err table & exception
        $res7error = $dbCrud->selectLimitOffset(
            $errTable,
            $limit,
            $offset,
            $column,
            $orderBy
        );
        $this->assertFalse($res7error);
        // Test select limit offset where
        $limit = 5;
        $offset = 0;
        $column = 'id';
        $idVal = 'test2';
        $order = 'asc';
        $resNew = $dbCrud->selectLimitOffsetWhere(
            $table,
            $limit,
            $offset,
            $column,
            $idVal,
            $column,
            $order
        );
        if ($resNew) {
            $this->assertNotEmpty($resNew);
            $theId = $resNew[0]->id;
            $expectedId = 'test2';
            $this->assertEquals($expectedId, $theId);
        }
        // Err table & exception
        $resNewError = $dbCrud->selectLimitOffsetWhere(
            $errTable,
            $limit,
            $offset,
            $column,
            $idVal
        );
        $this->assertFalse($resNewError);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties functionality.
     *
     * @return void
     */
    public function testFunctionality3()
    {
        $host = '127.0.0.1';
        $theDb = 'theBasePHPTest';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        // Test creating an oject
        $dbCrud = new DbCrud($dbBase);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbCrud", $dbCrud);

        // Set up db table
        $table = 'theBasePHPTest';
        $errTable = 'errorTable';

        $orderBy = 'asc';
        $column = 'id';

        // Test writing free SQL texts & control values
        $sql = "SELECT * FROM $table";
        $res8 = $dbCrud->freeTextSQL(
            $sql
        );
        $this->assertNotEmpty($res8);
        $testRes = $dbCrud->read($table, $column, $orderBy);
        $this->assertEquals($testRes, $res8);
        // Test writing free SQL with param
        $sql = "SELECT * FROM $table WHERE id = ?";
        $theId = 'test1';
        $theParam = [$theId];
        $res8half = $dbCrud->freeTextSQL($sql, $theParam);
        $this->assertNotEmpty($res8half);
        $theId = $res8half[0]->id;
        $expectedId = 'test1';
        $this->assertEquals($theId, $expectedId);
        // Test err table freetext
        $sql = "SELECT * FROM $errTable";
        $res9 = $dbCrud->freeTextSQL(
            $sql
        );
        $this->assertEmpty($res9);

        // Test delete non existant value
        $value = 'errrr';
        $res10 = $dbCrud->delete($table, $column, $value);
        if ($res10) {
            $this->assertTrue(empty($res10));
        }
        // Test delete non existant table
        $value = 'errrr';
        $res11 = $dbCrud->delete($errTable, $column, $value);
        $this->assertFalse($res11);
        // Test delete existant & control values
        $value = 'prod1';
        $res8 = $dbCrud->delete($table, $column, $value);
        $theId = 'prod1';
        $column = 'id';
        $res2 = $dbCrud->search($table, $column, $theId);
        $this->assertEmpty($res2);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties functionality.
     *
     * @return void
     */
    public function testDbDetails()
    {
        $host = '127.0.0.1';
        $theDb = 'theBasePHPTest';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        // Test creating an oject
        $dbCrud = new DbCrud($dbBase);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbCrud", $dbCrud);
    }
}
