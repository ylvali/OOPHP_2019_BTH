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
class BlogPageTest extends TestCase
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
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        $dbCrud = new DbCrud($dbBase);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbCrud", $dbCrud);

        $blog = new Item($dbCrud);
        $this->assertInstanceOf("\Anax\SimpleCMS\Item", $blog);

        $filter = new TheTextFilter();
        $this->assertInstanceOf("\Anax\SimpleCMS\TheTextFilter", $filter);

        $blogView = new BlogView($filter);
        $this->assertInstanceOf("\Anax\SimpleCMS\BlogView", $blogView);

        $pageView = new PageView($filter);
        $this->assertInstanceOf("\Anax\SimpleCMS\PageView", $pageView);

        // Tets displaying some items
        $settings = null; // will set automatically

        // Selection of columns where column type matches post
        $table = 'content';
        $res = $blog
            ->displayAll($table, $settings, null, 'type', 'post');

        if ($res) {
            $this->assertTrue(is_array($res));
        }

        // Selection of columns where column type matches page
        $table = 'content';
        $resPage = $blog
            ->displayAll($table, $settings, null, 'type', 'page');
        if ($resPage) {
            $this->assertTrue(is_array($resPage));
        }

        // Test wrong settings, no crash
        $setErr = 'arr';
        $resErr = $blog->displayAll($table, $setErr);
        $this->assertFalse($resErr);


        // Get edit form
        $editForm = $blogView->getEditForm(1, $resPage);
        if ($editForm) {
            $this->assertTrue(is_string($editForm));
        }

        // Err result
        $editFormErr = $blogView->getEditForm(1, 'err');
        $this->assertFalse($editFormErr);

        //print html post
        $res2 = $blogView->printHTML($res);
        if ($res2) {
            $this->assertTrue(is_string($res2));
        }

        //print html page
        $pageRes = $pageView->printHTML($resPage, 'om');
        if ($pageRes) {
            $this->assertTrue(is_string($pageRes));
        }

        //test error result pdo obj
        $resErr = 'err';
        $resE = $blogView->printHTML($resErr);
        $this->assertFalse($resE);

        $err2 = 'err2';
        $resE2 = $pageView->printHTML(null, $err2);
        $this->assertNull($resE2);

        $pageResErr = $pageView->printHTML('errr', 'om');
        $this->assertFalse($pageResErr);
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
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbBase", $dbBase);

        $dbCrud = new DbCrud($dbBase);
        $this->assertInstanceOf("\Anax\SimpleCMS\DbCrud", $dbCrud);

        $blog = new Item($dbCrud);
        $this->assertInstanceOf("\Anax\SimpleCMS\Item", $blog);

        $filter = new TheTextFilter();
        $this->assertInstanceOf("\Anax\SimpleCMS\TheTextFilter", $filter);

        $blogView = new BlogView($filter);
        $this->assertInstanceOf("\Anax\SimpleCMS\BlogView", $blogView);

        $pageView = new PageView($filter);
        $this->assertInstanceOf("\Anax\SimpleCMS\PageView", $pageView);

        // Page buttons
        $nrPages = 6;
        $thisPage = 2;
        $res4 = $blogView
          ->pageButtons($nrPages, $thisPage);
        if ($res4) {
            $this->assertTrue(is_string($res4));
        }

        // Page buttons error settings
        $nrPages = 6;
        $thisPage = 2;
        $settings = 'err';
        $res5 = $blogView
          ->pageButtons($nrPages, $thisPage, $settings);
        if ($res5) {
            $this->assertTrue(is_string($res5));
        }

        // Get the blog view
        $form = $blogView->getCreateForm();
        if ($form) {
            $this->assertTrue(is_string($form));
        }
    }
}
