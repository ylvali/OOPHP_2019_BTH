<?php
/**
 *  DbBase
 *  php version 7
 *
 * @category DbConnection
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 * @phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore"
 **/

namespace Ylva\PhpBase;

use PHPUnit\Framework\TestCase;

/**
 *  DbBase
 *  php version 7
 *
 * @category DbConnection
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 *
 * @return void
 **/
class DbBaseCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     *
     * @return void
     */
    public function testCreateObjectNoArguments()
    {
        $host = '127.0.0.1';
        $theDb = 'oophp';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Ylva\PhpBase\DbBase", $dbBase);

        $sql = "SELECT * FROM test;";
        $res = $dbBase->getData($sql);
        $this->assertNotNull($res);

        $sql = "UPDATE products SET id = ?, name = ?, year = ? WHERE id = 'prod1';";
        $params = array('prod1', 'test3', 2020);
        $res = $dbBase->getData($sql, $params);
        //var_dump($res);
        $this->assertNotNull($res);
    }
}
