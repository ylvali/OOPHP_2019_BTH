<?php
/**
 *   SystemControllerTest
 *   php version 7
 *   Works with session
 *
 * @category Session
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://www.spektatum.com
 **/

namespace Anax\SimpleCMS;

use PHPUnit\Framework\TestCase;

use Anax as Anax;

/**
 *   SystemCotnrollerTest
 *   php version 7
 *   Works with session
 *
 * @category Session
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://www.spektatum.com
 **/
class DbAPITest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties and functionality.
     *
     * @return void
     */
    public function testFunctionalityANAX()
    {
        $host = '127.0.0.1';
        $theDb = 'theBasePHPTest';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        // Enable to also use $app style to access services
        $di = new Anax\DI\DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $app = $di;
        $di->set("app", $app);

        $dbAPI = new DbAPI(null, $app);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbAPI", $dbAPI);

        // Test creating an oject
        $dbCrud = new DbCrud($dbAPI);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbCrud", $dbCrud);

        // Set up db table
        $table = 'theBasePHPTest';

        // Test writing free SQL texts & control values
        $sql = "SELECT * FROM $table";
        $res = $dbCrud->freeTextSQL(
            $sql
        );

        if ($res) {
            $this->assertTrue(is_array($res));
        }
    }
}
