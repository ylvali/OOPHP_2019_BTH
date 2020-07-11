<?php
/**
 *   SendVar
 *   Works with the superglobal variables $_GET & $_POST
 *   php version 7
 *   Works with session
 *
 * @category SendVar
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

namespace Ylva\PhpBase;

use PHPUnit\Framework\TestCase;

/**
 *   SendVar
 *   Works with the superglobal variables $_GET & $_POST
 *   php version 7
 *   Works with session
 *
 * @category SendVar
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/
class SendVarTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     *
     * @return void
     */
    public function testCreateObject()
    {
        $sendVar = new SendVar();
        $this->assertInstanceOf("\Ylva\PhpBase\SendVar", $sendVar);

        // Test getting an empty value : $_GET
        $test = 'test';
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
    }

}
