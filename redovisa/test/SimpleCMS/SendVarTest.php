<?php
/**
 *   SendVar Test
 *   Works with the superglobal variables $_GET & $_POST
 *
 *   V3.1 includes getPostArray($posts) (Updated: 2021-08)
 *   php version 7
 *
 * @category SendVar
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://wwww.spektatum.com
 **/

namespace Anax\SimpleCMS;

use PHPUnit\Framework\TestCase;

/**
 *   SendVar
 *   Send variables
 *   Works with the superglobal variables $_GET & $_POST
 *   php version 7
 *
 * @category SendVar
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     https://Www.spektatum.com
 **/
class SendVarTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties and functionality
     *
     * Test methods for set & get
     *
     * @return void
     */
    public function testFunctionality()
    {
        $sendVar = new SendVar();
        $this->assertInstanceOf("\Anax\SimpleCMS\SendVar", $sendVar);

        // Test getting an empty value : $_GET
        $test = 'test2';
        $res = $sendVar->getValue($test);
        $this->assertNull($res);

        // Test setting a value and then getting it : $_GET
        $sendVar->setGetValue($test, $test);
        $res2 = $sendVar->getValue($test);
        $this->assertEquals($res2, $test);

        // Test getting an empty value : $_POST
        $res3 = $sendVar->postValue($test);
        $this->assertNull($res3);

        // Test setting a value and then getting it : $_POST
        $sendVar->setPostValue($test, $test);
        $res4 = $sendVar->postValue($test);
        $this->assertEquals($res4, $test);

        // Test settings another value and get both as an array
        $sendVar->setPostValue('test3', 'testing');
        $postKeys = array('test2', 'test3', 'empty');
        $postArr = $sendVar->getPostArray($postKeys);
        if ($postArr) {
            $this->assertTrue(is_array($postArr));
        }
    }
}
