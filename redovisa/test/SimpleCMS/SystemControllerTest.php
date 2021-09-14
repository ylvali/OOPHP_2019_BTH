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

use Anax as Anax;

use Anax\Request as Request;

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
class SystemControllerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties and functionality.
     *
     * @return void
     */
    public function testFunctionality()
    {
        $sendVar = new SendVar();
        $this->assertInstanceOf("\Anax\SimpleCMS\SendVar", $sendVar);

        $sendVar->setPostValue('testA', 'test');
        $sendVar->setPostValue('path', 'one');

        $host = '127.0.0.1';
        $theDb = 'theBasePHPTest';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        $dbCrud = new DbCrud($dbBase);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbCrud", $dbCrud);

        $sysC = new SystemController($dbCrud, $sendVar);
        $this->assertInstanceOf("\Anax\SimpleCMS\SystemController", $sysC);

        $menu = $sysC->getMenu();
        if ($menu) {
            $this->assertTrue(is_string($menu));
        }

        $postKeys = array('title', 'path', 'data');
        $postArr = $sysC->postData($postKeys);
        if ($postArr) {
            $this->assertTrue(is_array($postArr));
        }

        $postData = 'testA';
        $postString = $sysC->postData($postData);
        if ($postString) {
            $this->assertTrue(is_string($postString));
        }
    }


    /**
     * Construct object and verify that the object has the expected
     * properties and functionality.
     *
     * @return void
     */
    public function testFunctionalityAnax()
    {
        $sendVar = new SendVar();
        $this->assertInstanceOf("\Anax\SimpleCMS\SendVar", $sendVar);

        // Enable to also use $app style to access services
        // Were are all the files?
        $di = new Anax\DI\DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $app = $di;
        $di->set("app", $app);

        // Anax framework plugin for suoer variables
        $request = new Request\Request();

        $dbAPI = new DbAPI(null, $app);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbAPI", $dbAPI);

        $dbCrud = new DbCrud($dbAPI);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbCrud", $dbCrud);

        $sysC = new SystemController($dbCrud, null, $request);
        $this->assertInstanceOf("\Anax\SimpleCMS\SystemController", $sysC);

        $postKeys = array('title', 'path', 'data');
        $postArr = $sysC->postData($postKeys);
        if ($postArr) {
            $this->assertTrue(is_array($postArr));
        }

        $postData = 'test';
        $postString = $sysC->postData($postData);
        if ($postString) {
            $this->assertTrue(is_string($postString));
        }
    }
}
