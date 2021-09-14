<?php
/**
 *  TextFilter
 *  php version 7
 *
 * Origin:
 * https://dbwebb.se/coachen/
 * skriv-for-webben-med-markdown-och-formattera-till-html-med-php-v2
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Yso Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 * @phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore"
 **/

namespace Anax\SimpleCMS;

use PHPUnit\Framework\TestCase;

/**
 *  TetxFilter
 *  php version 7
 *
 * @category TheTextFilter
 * @package  SimpleCMS
 * @author   Yso Sjölin <yso@spektatum.com>
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
        $this->assertInstanceOf("\Anax\SimpleCMS\TheTextFilter", $txtFilter);

        // Testing all of the filters
        $txt = "#title bar \n https://test.com [b] yes [/b]";
        $filter = array('link','bbcode', 'markdown', 'nl2br');
        $parsed = $txtFilter->parse($txt, $filter);
        // var_dump($parsed);

        // Testing no filter
        $txt = "#title bar \n https://test.com [b] yes [/b]";
        $filter = array('test');
        $parsed = $txtFilter->parse($txt, $filter);
        $this->assertEquals($parsed, $txt);

        // Test to slugify
        $str = 'test to slug';
        $slugify = $txtFilter->slugify($str);
        $expected = 'test-to-slug';
        $this->assertEquals($expected, $slugify);

        // Test to get string filter values for the db
        $filterArr = array('bbcode', 'markdown');
        $dbFilter = $txtFilter->dbFilter($filterArr);
        $expected = 'bbcode,markdown';
        $this->assertEquals($expected, $dbFilter);
    }
}
