<?php
/**
 *   CmsModule
 *  php version 7
 *
 * @category  CmsModule
 * @package   PhpBase
 * @author    Ylva Sjölin <yso@spektatum.com>
 * @license   free to use
 * @link      none
 * @phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore"
 **/

namespace Ylva\PhpBase;

use PHPUnit\Framework\TestCase;

/**
 *   CmsModule
 *  php version 7
 *
 * @category  CmsModule
 * @package   PhpBase
 * @author    Ylva Sjölin <yso@spektatum.com>
 * @license   free to use
 * @link      none
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

        // This test could be done with a preset test database
        // to make sure all values are correct


        // ** PAGE **
        // Test reading the data
        $tableName = 'page';
        $thePage = $cmsModule->readPage($tableName);

        // Test updating the data
        $params = array('title'=> 'newTitle');
        $idVar = 'id';
        $idVal = 3;
        $newPage = $cmsModule->updateBlog($tableName, $params, $idVar, $idVal);


        // ** BLOG **
        $tableName = 'blog';

        // Test creating new post
        $params = array('path'=>'test', 'slug'=>'test', 'title'=>'test', 'data'=>'test');
        $theBlog = $cmsModule->createBlog($tableName, $params);

        // Test reading the data
        $theBlog = $cmsModule->readBlog($tableName);

        //Test updating the data
        $params = array('title'=> 'newTitle');
        $idVar = 'id';
        $idVal = 3;
        $newPage = $cmsModule->updateBlog($tableName, $params, $idVar, $idVal);

    }
}
