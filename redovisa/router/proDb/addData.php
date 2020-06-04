<?php
/**
 *   Add data
 *   php version 7
 *   Sets up database request from certain variables.
 *
 * @category DbConnection
 * @package  Products
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

namespace Ylva\ProductDb;

require __DIR__ . "/../config/config.php";
require __DIR__ . "/../vendor/autoload.php";

$db = new DbBase($host, $db, $user, $pass);
$dbCrud = new DbCrud($db);
$projectData = new ProjectData();
$project = new Project($dbCrud, $projectData);
$sendVar = new SendVar();

// Collect the post variables
$id = $sendVar->postValue('id');
$name = $sendVar->postValue('name');
$year = $sendVar->postValue('year');

// Check if id already exists
$table = 'products';
$column = 'id';
$res = $dbCrud->search($table, $column, $id);

// If values are correct add new item
if (empty($res) && is_numeric($year)) {
    $pic = 'placeholder.jpg';
    $params = array('id'=>$id, 'name'=>$name, 'pic'=>$pic, 'year'=>$year);
    $table = 'products';

    $project->createNewItem($table, $params);
}

 header('Location:../index.php');
