<?php
/**
 *   Edit data
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

/**
*  Collect the incoming values and send to db
*/
$id = $sendVar->postValue('id');
$name = $sendVar->postValue('name');
$year = $sendVar->postValue('year');

$year = is_numeric($year)? $year : null;
$params = array('id' => $id, 'name' => $name, 'year' => $year);

$res = $project->updateData('products', $params, 'id', $id);

/**
*  Return to index.php
*/
header('Location:../index.php');
