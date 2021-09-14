<?php
/**
 *  DbBaseTest
 *  php version 7
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://wwww.spektatum.com
 * @phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore"
 **/

namespace Anax\SimpleCMS;

use PHPUnit\Framework\TestCase;

/**
 *  DbBaseTest
 *  php version 7
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://www.spektatum.com
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
     * @expectedException \Anax\SimpleCMS\DbBaseException
     *
     * Test execute error w nonexistant table
     *
     * @return void
     */
    public function testExpectedExceptionIsRaised()
    {
        $host = '127.0.0.1';
        $theDb = 'TheBasePHPTest';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        // Execute with error
        $sql1 = "SELECT * FROM error;";
        $dbBase->getData($sql1);
    }

    /**
     * The testExpectedExceptionIsRaised3
     *
     * @expectedException \Anax\SimpleCMS\DbBaseException
     * Test exception of prepare error
     *
     * @return void
     */
    public function testExpectedExceptionIsRaised3()
    {
        $host = '127.0.0.1';
        $theDb = 'TheBasePHPTest';
        $user = 'user';
        $password = 'pass';
        $test = ['prepare' => true, 'execute' => false, 'fetchAll' => false];
        $dbBase = new DbBase($host, $theDb, $user, $password, $test);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        // Execute
        $sql2 = "SELECT * FROM TheBasePHPTest;";
        $dbBase->getData($sql2);
    }


    /**
     * The testExpectedExceptionIsRaised4
     *
     * @expectedException \Anax\SimpleCMS\DbBaseException
     * Test exception of fetchAll error
     *
     * @return void
     */
    public function testExpectedExceptionIsRaised4()
    {
        $host = '127.0.0.1';
        $theDb = 'TheBasePHPTest';
        $user = 'user';
        $password = 'pass';
        $test = ['prepare' => false, 'execute' => false, 'fetchAll' => true];
        $dbBase = new DbBase($host, $theDb, $user, $password, $test);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        // Execute
        $sql3 = "SELECT * FROM TheBasePHPTest;";
        $dbBase->getData($sql3);
    }


    /**
     * The testExpectedExceptionIsRaised5
     *
     * @expectedException \Anax\SimpleCMS\DbBaseException
     * Test exception of execute error
     *
     * @return void
     */
    public function testExpectedExceptionIsRaised5()
    {
        $host = '127.0.0.1';
        $theDb = 'TheBasePHPTest';
        $user = 'user';
        $password = 'pass';
        $test = ['prepare' => false, 'execute' => true, 'fetchAll' => false];
        $dbBase = new DbBase($host, $theDb, $user, $password, $test);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        // Execute
        $sql4 = "SELECT * FROM TheBasePHPTest;";
        $dbBase->getData($sql4);
    }
}
