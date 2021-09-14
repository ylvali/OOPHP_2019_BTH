<?php
/**
 *   SessionVarTest
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
 *   SessionVarTest
 *   php version 7
 *   Works with session
 *
 * @category Session
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://www.spektatum.com
 **/
class SessionVarTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties and functionality.
     *
     * @return void
     */
    public function testFunctionality()
    {
        $sessVar = new SessionVar();
        $this->assertInstanceOf("\Anax\SimpleCMS\SessionVar", $sessVar);

        // test setting & getting session vars
        $var = 'test';
        $value = 'testing';
        $sessVar->setValue($var, $value);
        $res = $sessVar->getValue($var);
        $this->assertEquals($res, $value);

        // test setting & getting session arrays
        $valArr = array('test2'=>'test2', 'test3' => 'test3');
        $arrName = 'anArr';
        $sessVar->setValueArr($arrName, $valArr);
        $gottenArr = $sessVar->getValueArr($arrName);
        $this->assertEquals($gottenArr, $valArr);

        // test unset var
        $sessVar->unsetVar($var, $value);
        $noVar = $sessVar->setValue($var, $value);
        $this->assertNull($noVar);
    }
}
