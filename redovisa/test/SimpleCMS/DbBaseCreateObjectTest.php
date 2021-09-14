<?php
/**
 *  DbBase
 *  php version 7
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://www.spektatum.com
 * @phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore"
 **/

namespace Anax\SimpleCMS;

use PHPUnit\Framework\TestCase;

/**
 *  DbBase
 *  php version 7
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://www.spektatum.com
 *
 * @return void
 **/
class DbBaseCreateObjectTest extends TestCase
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
        $theDb = 'TheBasePHPTest';
        $user = 'user';
        $password = 'pass';

        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        $sql = "SELECT * FROM TheBasePHPTest;";
        $res = $dbBase->getData($sql);
        $this->assertNotNull($res);

        // The Id should be 'test1' of the first row.
        $idExpected = 'test1';

        // Get the data from the table
        $idTest = $res[0]->id;

        // Assert equal
        $this->assertEquals($idExpected, $idTest);
    }

    /**
     * Test creating an object with false credentials
     *
     * @return void
     */
    public function testFunctionality2()
    {
        $host = '127.0.0.1';
        $theDb = 'TheBasePHPTestt';
        $user = 'user';
        $password = 'pass';

        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);
    }

    /**
     * Test creating without valid host & db
     *
     * @return void
     */
    public function testEmpty()
    {
        $host = null;
        $theDb = null;
        $user = null;
        $password = null;

        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        $sql = "SELECT * FROM TheBasePHPTest;";
        $res = $dbBase->getData($sql);
        $this->assertFalse($res);
    }
}
