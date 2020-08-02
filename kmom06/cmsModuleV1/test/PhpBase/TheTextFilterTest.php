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
 * @category TheTextFilter
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 *
 * @return void
 **/
class TheTextFilterObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     *
     * @return void
     */
    public function testCreateObjectNoArguments()
    {

        $txtFilter = new TheTextFilter();
        $this
        ->assertInstanceOf("\Ylva\PhpBase\TheTextFilter", $txtFilter);

        // Testing all of the filters
        $txt = "#title bar \n https://test.com [b] yes [/b]";
        $filter = array('link','bbcode', 'markdown', 'nl2br');
        $parsed = $txtFilter->parse($txt, $filter);
        var_dump($parsed);

        // Testing no filter
        $txt = "#title bar \n https://test.com [b] yes [/b]";
        $filter = array('test');
        $parsed = $txtFilter->parse($txt, $filter);
        $this->assertEquals($parsed, $txt);

    }
}
