<?php
/**
 *   SessionVarTest
 *   php version 7
 *   Works with session
 *
 * @category Session
 * @package  Session
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

namespace Ylva\ProductDb;

use PHPUnit\Framework\TestCase;

/**
 *   SessionVarTest
 *   php version 7
 *   Works with session
 *
 * @category Session
 * @package  Session
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/
class SessionVarTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     *
     * @return void
     */
    public function testCreateObject()
    {
        $sessVar = new SessionVar();
        $this->assertInstanceOf("\Ylva\ProductDb\SessionVar", $sessVar);

        $var = 'test';
        $value = 'testing';
        $res = $sessVar->setValue($var, $value);
        // var_dump($res);
        $this->assertNull($res);

        $res = $sessVar->getValue($var);
        // var_dump($res);
        $this->assertEquals($res, $value);

    }
}
