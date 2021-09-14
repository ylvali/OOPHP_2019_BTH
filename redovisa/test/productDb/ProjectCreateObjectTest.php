<?php
/**
 *  Project
 *  php version 7
 *  The project controller
 *
 * @category ProjectController
 * @package  Project
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

namespace Anax\ProductDb;

use PHPUnit\Framework\TestCase;

/**
 *  Project
 *  php version 7
 *  The project controller
 *
 * @category ProjectController
 * @package  Project
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 *
 * @return void;
 **/
class ProjectCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     *
     * @return void
     */
    public function testCreateObject()
    {
        $host = '127.0.0.1';
        $theDb = 'oophp';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\ProductDb\DbBase", $dbBase);

        // Test creating an oject of dbCrud
        $dbCrud = new DbCrud($dbBase);

        // One of the project data
        $projectData = new ProjectData();

        // Test creating a Project object
        $project = new Project($dbCrud, $projectData);

        // Test that the display btns works
        $res2 = $project->displayBtns();
        $this->assertNotNull($res2);

        // Test the reset btn
        // Correct file
        $file = __DIR__.'/../../router/proDb/resetDbSql.php';
        $res3 = $project->reset($file);
        $this->assertTrue($res3);

        // Incorrect file
        $file2 = 'notAFile.php';
        $res4 = $project->reset($file2);
        $this->assertFalse($res4);

        // // Test searching
        // // Existing product
        // $table = 'products';
        // $column = 'id';
        // $searchWord = 'prod1';
        // $res5 = $project->searchDb($table, $column, $searchWord);
        // $this->assertNotNull($res5);

        // // None-Existing product
        // $table2 = 'products';
        // $column2 = 'id';
        // $searchWord2 = 'noneExistant';
        // $res6 = $project->searchDb($table2, $column2, $searchWord2);
        // $this->assertNotNull($res6);

        // Test searching
        // Existing product
        $table3 = 'products';
        $column3 = 'id';
        $searchWord3 = 'prod1';
        $res6 = $project->searchDbArray($table3, $column3, $searchWord3);
        //var_dump($res6);
        $isObj = is_array($res6);
        $this->assertTrue($isObj);

        // Test getting a form
        $table4 = 'products';
        $column4 = 'id';
        $theId = 'prod1';
        $res7 = $project->updateForm($table4, $column4, $theId);
        //var_dump($res7);
        $isString = is_string($res7);
        $this->assertTrue($isString);

        // test updating data
        $table5 = 'products';
        $name = 'testing';
        $year = 2020;
        $id5 = 'prod1';
        $params = array('id' => $id5, 'name' => $name, 'year' => $year);
        $primaryKey = 'id';
        $res8 = $project->updateData($table5, $params, $primaryKey, $id5);
        // var_dump($res8);
        $this->assertNotNull($res8);

        // Test searching multiple columns
        // Existing product
        $table6 = 'products';
        $column = array('id', 'name', 'year');
        $searchWord = '2020';
        $res9 = $project->searchMultipleColumns($table6, $column, $searchWord);
        //var_dump($res9);
        $this->assertNotNull($res9);

        // Test getting add form
        $res10 = $project->getAddForm();
        $this->assertNotNull($res10);

        // Test adding a new item
        $table7 = 'products';
        $paramsAdd = array('id' => 'prod11', 'name'=>'product11', 'year' => 2020);
        $project->createNewItem($table7, $paramsAdd);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties.
     *
     * @return void
     */
    public function testCreateObject2()
    {
        $host = '127.0.0.1';
        $theDb = 'oophp';
        $user = 'user';
        $password = 'pass';
        $dbBase = new DbBase($host, $theDb, $user, $password);
        $this->assertInstanceOf("\Anax\ProductDb\DbBase", $dbBase);

        // Test creating an oject of dbCrud
        $dbCrud = new DbCrud($dbBase);

        // One of the project data
        $projectData = new ProjectData();

        // Test creating a Project object
        $project = new Project($dbCrud, $projectData);

        // Test deleting
        $table8 = 'products';
        $column = 'id';
        $idValue = 'prod1';
        $project->deleteItem($table8, $column, $idValue);

        // // Test to show all data in order
        // $table9 = 'products';
        // $orderBy = 'id';
        // $order = 'DESC';
        // $res10 = $project->showAllDataInOrder($table9, $orderBy, $order);
        // $this->assertNotNull($res10);
        // // var_dump($res10);
        //
        // // Test using offset and limit function
        // $table9 = 'products';
        // $orderBy = 'id';
        // $order = 'DESC';
        // $res10 = $project->showAllDataInOrder($table9, $orderBy, $order);
        // $this->assertNotNull($res10);

        // Test collecting project specific data
        // $res = $project->showAllData();
        // $this->assertNotNull($res);
        // //var_dump($res);

        // Test limit and offset functionality
        $table10 = 'products';
        $rowsPerPage = 2;
        $startAt = 1;
        $res11 = $project->displaySelected($table10, $rowsPerPage, $startAt);
        // var_dump($res11);
        $this->assertNotNull($res11);

        // Test limit and offset + orderby & order functionality
        $table11 = 'products';
        $rowsPerPage = 2;
        $startAt = 0;
        $orderBy = 'id';
        $order = 'DESC';
        $settings = array("orderBy" => "id", "order" => "desc",
            "nrItems" => "4", "nrPages" => "1"); // default
        $res12 = $project->displaySelected(
            $table11,
            $rowsPerPage,
            $startAt,
            $orderBy,
            $order,
            $settings
        );
        // var_dump($res12);
        $this->assertNotNull($res12);

        // Get the nr of pages for one table
        $table12 = 'products';
        $idVar = 'id';
        $nrPerPage = 8;
        $thisPage = 1;
        $settings = null;
        $res12 = $project->getNrPages(
            $idVar,
            $table12,
            $nrPerPage,
            $settings,
            $thisPage
        );

        $table13 = 'products';
        $idVar = 'id';
        $nrPerPage = -1;
        $res13 = $project->getNrPages($idVar, $table13, $nrPerPage);
        $this->assertNotNull($res13);
    }
}
