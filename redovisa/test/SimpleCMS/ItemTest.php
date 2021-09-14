<?php
/**
 *  ItemTest
 *
 * Testing the item class,
 * this one set up for blog & page
 *
 *  php version 7
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://www.spektatum.com
 * @phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore"
 **/

namespace Anax\SimpleCMS;

use PHPUnit\Framework\TestCase;

/**
 *  ItemTest
 *  php version 7
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://www.spektatum.com
 *
 * @return void
 **/
class ItemTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties and functionality.
     *
     * @return void
     */
    public function testFunctionality1()
    {
        $host = '127.0.0.1';
        $theDb = 'oophp';
        $user = 'user';
        $password = 'pass';
        //
        // $user = null;
        // $password = null;

        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        $dbCrud = new DbCrud($dbBase);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbCrud", $dbCrud);

        $blog = new Item($dbCrud);
        $this->assertInstanceOf("\Anax\SimpleCMS\Item", $blog);


        // Tets displaying some items
        // No crash if no db connection
        // Displays according to settings
        $settings = null; // will set automatically

        // Selection of columns where column type matches post
        $table = 'content';
        $res = $blog
            ->displayAll(
                $table,
                $settings,
                null,
                'type',
                'post'
            );

        if ($res) {
            $this->assertTrue(is_array($res));
        }


        // Test wrong settings, no crash
        $setErr = 'arr';
        $resErr = $blog->displayAll($table, $setErr);
        $this->assertFalse($resErr);

        //get nr of pages
        $nrPerPage=2;
        $table = 'content';
        $id1 = 'id';
        $column = 'type';
        $id2 = 'page';
        $res3 = $blog->nrPages($nrPerPage, $table, $id1, $column, $id2);
        if ($res3) {
            $this->assertTrue(is_numeric($res3));
        }

        // test with negative nr
        $nrPerPage=-2;
        $res3Neg = $blog->nrPages($nrPerPage, $table, $id1, $column, $id2);
        if ($res3Neg) {
              $this->assertTrue(is_numeric($res3Neg));
              $this->assertEquals(1, $res3Neg);
        }
    }

    /**
     * Construct object and verify that the object has the expected
     * properties and functionality.
     *
     * @return void
     */
    public function testFunctionality2()
    {
        $host = '127.0.0.1';
        $theDb = 'oophp';
        $user = 'user';
        $password = 'pass';
        //
        // $user = null;
        // $password = null;

        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        $dbCrud = new DbCrud($dbBase);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbCrud", $dbCrud);

        $blog = new Item($dbCrud);
        $this->assertInstanceOf("\Anax\SimpleCMS\Item", $blog);


        // ** Test settings the settings **
        $settings = null;
        $res = $blog->setSettings($settings);
        if ($res) {
            $this->assertTrue(is_object($res));
        }

        $settings = '{"orderBy":"id","order":"desc","nrItems":"2","pageNr":"1"}';
        $res2 = $blog->setSettings($settings);
        if ($res2) {
            $this->assertTrue(is_object($res2));
        }


        // ** Test setting the page nr **
        $pageNr = 1;
        $res3 = $blog->setPageNr($pageNr);
        if ($res3) {
            $this->assertTrue(is_object($res3));
        }
         // error settings and no crash
        $pageNr = 1;
        $settings = 'err';
        $res4 = $blog->setPageNr($pageNr, $settings);
        $this->assertFalse($res4);


        // ** Test setting the nr items **
        $nrItems = 1;
        $res5 = $blog->setNrItems($nrItems);
        if ($res5) {
            $this->assertTrue(is_object($res5));
        }

        // Error with alphabetic input, no crash sets to nr items 2
        $nrItemsErr = 'aaa';
        $res5err = $blog->setNrItems($nrItemsErr);
        if ($res5err) {
            $this->assertTrue(is_object($res5err));
        }

         // error settings and no crash
        $nrItems = 1;
        $settings = 'err';
        $res6 = $blog->setNrItems($pageNr, $settings);
        $this->assertFalse($res6);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties and functionality.
     *
     * @return void
     */
    public function testFunctionality3()
    {
        $host = '127.0.0.1';
        $theDb = 'oophp';
        $user = 'user';
        $password = 'pass';
        //
        // $user = null;
        // $password = null;

        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        $dbCrud = new DbCrud($dbBase);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbCrud", $dbCrud);

        $blog = new Item($dbCrud);
        $this->assertInstanceOf("\Anax\SimpleCMS\Item", $blog);

        // Edit one
        $thaId = 1;
        $newData = array('test','test2');
        $editColumn = array('title','data');
        $table = 'content';
        $res1 = $blog->editOne($thaId, $editColumn, $newData, $table);
        if ($res1) {
            $this->assertTrue($res1);
        }


        // Edit one w err table
        $thaId = 1;
        $newData = array('test');
        $editColumn = array('data');
        $table = 'err';
        $res2 = $blog->editOne($thaId, $newData, $editColumn, $table);
        $this->assertFalse($res2);


        // Create one
        $columns = array('path', 'slug', 'title', 'data', 'type');
        $newData = array('testPath', 'test', 'test title', 't data', 'blog');
        $table = 'content';
        $res3 = $blog->createOne($columns, $newData, $table);
        if ($res3) {
            $this->assertTrue($res3);
        }

        // Search one
        $column = 'path';
        $idVal = 'testPath';
        $table = 'content';
        $res4 = $blog->searchOne($idVal, $column, $table);
        if ($res4) {
            $this->assertTrue(is_array($res4) && !empty($res4));
        }

        // Delete one
        $column = 'path';
        $idVal = 'testPath';
        $table = 'content';
        $res5 = $blog->deleteOne($column, $idVal, $table);
        if ($res5) {
            $this->assertTrue($res5);
        }
    }
}
