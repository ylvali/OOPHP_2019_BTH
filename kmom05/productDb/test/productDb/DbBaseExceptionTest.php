<?php
/**
 *  DbBaseTest
 *  php version 7
 *
 * @category DbConnection
 * @package  ProjectDb
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 * @phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore"
 **/

namespace Ylva\ProductDb;

use PHPUnit\Framework\TestCase;

/**
 *  DbBaseTest
 *  php version 7
 *
 * @category DbConnection
 * @package  ProjectDb
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 * @phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore"
 **/
class DbBaseTestException extends TestCase
{
    /**
     * Construct object & test the exception thrown
     *
     * SOLUTION FROM:
     * https://thephp.cc/news/2016/02/questioning-phpunit-best-practices
     *
     * @expectedException \Ylva\ProductDb\DbBaseException
     *
     * Test execute error w nonexistant table
     *
     * @return void
     */
    public function testExpectedExceptionIsRaised()
    {
        $host = '127.0.0.1';
        $theDb = 'oophp';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Ylva\ProductDb\DbBase", $dbBase);

        // Execute with error
        $sql3 = "SELECT * FROM error;";
        $res3 = $dbBase->getData($sql3);
        var_dump($res3);
        $this->assertNotNull($res3);
    }

    /**
     * The testExpectedExceptionIsRaised2
     *
     * @expectedException PDOException
     * Test connection w nonexistant db
     *
     * @return void
     */
    public function testExpectedExceptionIsRaised2()
    {
        // Testing calling db with incorrect database
        $host = '127.0.0.1';
        $theDb = 'error';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Ylva\ProductDb\DbBase", $dbBase);
    }

    /**
     * The testExpectedExceptionIsRaised3
     *
     * @expectedException \Ylva\ProductDb\DbBaseException
     * Test exception of prepare error
     *
     * @return void
     */
    public function testExpectedExceptionIsRaised3()
    {
        $host = '127.0.0.1';
        $theDb = 'oophp';
        $user = 'user';
        $password = 'pass';
        $test = ['prepare' => true, 'execute' => false, 'fetchAll' => false];
        $dbBase = new DbBase($host, $theDb, $user, $password, $test);
        $this->assertInstanceOf("\Ylva\ProductDb\DbBase", $dbBase);

        // Execute
        $sql3 = "SELECT * FROM test;";
        $res3 = $dbBase->getData($sql3);
        var_dump($res3);
        $this->assertNotNull($res3);
    }


    /**
     * The testExpectedExceptionIsRaised4
     *
     * @expectedException \Ylva\ProductDb\DbBaseException
     * Test exception of fetchAll error
     *
     * @return void
     */
    public function testExpectedExceptionIsRaised4()
    {
        $host = '127.0.0.1';
        $theDb = 'oophp';
        $user = 'user';
        $password = 'pass';
        $test = ['prepare' => false, 'execute' => false, 'fetchAll' => true];
        $dbBase = new DbBase($host, $theDb, $user, $password, $test);
        $this->assertInstanceOf("\Ylva\ProductDb\DbBase", $dbBase);

        // Execute
        $sql3 = "SELECT * FROM test;";
        $res3 = $dbBase->getData($sql3);
        var_dump($res3);
        $this->assertNotNull($res3);
    }


    /**
     * The testExpectedExceptionIsRaised5
     *
     * @expectedException \Ylva\ProductDb\DbBaseException
     * Test exception of execute error
     *
     * @return void
     */
    public function testExpectedExceptionIsRaised5()
    {
        $host = '127.0.0.1';
        $theDb = 'oophp';
        $user = 'user';
        $password = 'pass';
        $test = ['prepare' => false, 'execute' => true, 'fetchAll' => false];
        $dbBase = new DbBase($host, $theDb, $user, $password, $test);
        $this->assertInstanceOf("\Ylva\ProductDb\DbBase", $dbBase);

        // Execute
        $sql3 = "SELECT * FROM test;";
        $res3 = $dbBase->getData($sql3);
        var_dump($res3);
        $this->assertNotNull($res3);
    }
}
