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
class ActionControllerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties and functionality.
     *
     * @return void
     */
    public function testFunctionality()
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

        $actionController = new ActionController($dbCrud);
        $this->assertInstanceOf("\Anax\SimpleCMS\ActionController", $actionController);

        $thisTest = $actionController->routeTest();
        if ($thisTest) {
            $this->assertTrue(is_array($thisTest));
        }
    }
}
