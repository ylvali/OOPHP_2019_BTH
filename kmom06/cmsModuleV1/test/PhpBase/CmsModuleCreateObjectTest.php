<?php
/**
 *   CmsModule
 *  php version 7
 *
 * @category CmsModule
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 * @phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore"
 **/

namespace Ylva\PhpBase;

use PHPUnit\Framework\TestCase;

/**
 *  CmsModuleTest
 *  php version 7
 *
 * @category CmsModule
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 *
 * @return void
 **/
class  CmsModuleCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     *
     * @return void
     */
    public function testCreateObjectNoArguments()
    {
        $host = '127.0.0.1';
        $theDb = 'oophp';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Ylva\PhpBase\DbBase", $dbBase);
        $dbCrud = new DbCrud($dbBase);
        $this->assertInstanceOf("\Ylva\PhpBase\DbCrud", $dbCrud);
        $printModule = new CmsPrintModule();
        $this->assertInstanceOf("\Ylva\PhpBase\CmsPrintModule", $printModule);
        $cmsModule = new CmsModule($dbCrud, $printModule);
        $this->assertInstanceOf("\Ylva\PhpBase\CmsModule", $cmsModule);

        // Testing the CRuD functionality of CmsModule
        // A blog will be created, read, updated & deleted

        // ** CREATE **
        // Test create blog
        $params1 = array('path'=>'test13',
            'slug'=>'test13', 'title'=>'test13', 'data'=>'test13');
        $ref1 = 'blog';
        $blogTable = 'blog';
        $res1 = $cmsModule->create($blogTable, $params1, $ref1);

        // Test create page
        $params1 = array('title'=>'test5', 'data'=>'test5');
        $ref2 = 'page';
        $pageTable = 'page';
        $res1 = $cmsModule->create($pageTable, $params1, $ref2);

        // Test create form
        $action = 'theAction';
        $cmsModule->createForm($action);

        // Test slugify
        // $testSlug = "test test";
        // $slug = $cmsModule->slugify($testSlug);
        // $theS = "test-test";
        // $this->assertEquals($theS, $testSlug);

        // ** READ **
        // Test read blog
        $cmsModule->read($blogTable, $ref1);

        // Test with different print options
        $ref3 = "blogAdmin";
        $theBlogAdmin = $cmsModule->read($blogTable, $ref3);

        $ref4 = "theForm";
        $theBlogAdmin = $cmsModule->read($blogTable, $ref4);

        $ref4 = "noPrint";
        $noPrint = $cmsModule->read($blogTable, $ref4);

        // No reference print (no printing option)
        $ref4 = null;
        $noPrint = $cmsModule->read($blogTable, $ref4);

        // Test read one
        $column = 'id';
        $searchValue = 1;
        $ref3 = 'editBlog';
        $exactVal = true;
        $cmsModule
            ->search($blogTable, $column, $searchValue, $ref3, $exactVal = true);
        $notEmpty = $cmsModule
            ->isEmpty($blogTable, $column, $searchValue, $ref3, $exactVal = true);
        $this->assertFalse($notEmpty);

        // Test read page
        $cmsModule->read($pageTable, $ref2);


        // ** uPDATE **
        // Test update blog
        $params2 = array('slug'=> 'newSlug10');
        $idVar = 'title';
        $idVal = 'test13';
        $res2 = $cmsModule->update($blogTable, $params2, $idVar, $idVal, $ref1);

        // Test update page
        $params3 = array('data'=> 'newData');
        $idVar2 = 'title';
        $idVal2 = 'test6';
        $res2 = $cmsModule->update($pageTable, $params3, $idVar2, $idVal2, $ref2);

        // ** DELETE **
        $column1 = 'title';
        $idTitle = 'test13';
        $res2 = $cmsModule->delete($blogTable, $column1, $idTitle);

        $column2 = 'title';
        $idTitle2 = 'test5';
        $res2 = $cmsModule->delete($pageTable, $column2, $idTitle2);
    }
}
