<?php
namespace Ylva\ProductDb;

require __DIR__ . "/config/config.php";
require __DIR__ . "/vendor/autoload.php";
//require __DIR__ . "/src/Example/Database.php";

// sessionDestroy();

// PuT THIS IN A SETuP fILE
$host = '127.0.0.1';
$db = 'oophp';
$user = 'user';
$pass = 'pass';

$db = new DbBase($host, $db, $user, $pass);
$dbCrud = new DbCrud($db);
$projectData = new ProjectData();
$project = new Project($dbCrud, $projectData);
$sendVar = new SendVar();
$sessVar = new SessionVar();


// ** The JSON array with settings **
$settings = html_entity_decode($sendVar->postValue('order'));

// If not recieved, create one
if(!$orderingVals) {
    $settings = array("orderBy" => "id", "order" => "desc", "nrItems" => "4");
}
// var_dump($orderingVals);

$jsonObj = json_decode($setting, true);

var_dump($jsonObj["orderBy"]);

$btnPanel = $project->displayBtns($orderingVals);

// Collect the SESSION variables
// ** Collect GET values & set to SESSION **
// CREATE FuNCTION TO DO THIS CALCuLATION
$orderByVar = 'orderby';
$orderBy = $sendVar->postValue($orderByVar);
if($orderBy) {
    var_dump($orderBy);
    $sessVar->setValue($orderByVar, $orderBy);
}

$orderVar = 'order';
$order = $sendVar->getValue($orderVar);
if($order) {
    $sessVar->setValue($orderVar, $order);
}

$nrItemsVar = 'nrItems';
$nrItems = $sendVar->getValue($nrItemsVar);
//$nrItems = isset($nrItems) ? $nrItems : 4; //Default is 4 items per page
if($nrItems) {
    $sessVar->setValue($nrItemsVar, $nrItems);
}

$nrPagesVar = 'nrPages';
$nrPages = $sendVar->getValue($nrPagesVar);


$orderBy = $sessVar->getValue($orderByVar);
$order = $sessVar->getValue($orderVar);
$nrItems = $sessVar->getValue($nrItemsVar);
$search = 'search';
$searchRes = $sessVar->getValue($search);



// CHANGE TO CASE SWITCH
//$nrPages = null;
if ($searchRes) {
    $res = html_entity_decode($searchRes);
    $sessVar->setValue($search, null);
    $pageLink = null;
    $btnPanel = "<a href=''> Show all </a>";
} else {
    // ** Security Control of values**

    // * nrItems *
    // Should be set & numeric
    if(!isset($nrItems) || !is_numeric($nrItems)) {
        $nrItems = 4;
    }

    // * nrPages *
    // Should be set and positive
    if(!isset($nrPages) || $nrPages < 0){
        $nrPages = 1;
    }

    // * orderBy & order *
    // Should be certain strings
    $columns = ["id", "name", "year"];
    $orders = ["asc", "desc"];

    if($orderBy && $order) {
        if (!(in_array($orderBy, $columns) && in_array($order, $orders))) {
             // die("Not valid input for sorting.");
            // $res = "Not valid sorting variables";
            $orderBy = null;
            $order = null;
        }
    };

    // ** Calculation **

    // Calculate the nr of pages
    $idVar = 'id';
    $table = 'products';
    $pageLink = $project->getNrPages($idVar, $table, $nrItems);

    // CALCuLATE OFFSET VALuE
    $startAt = (intval($nrPages) - 1) * intval($nrItems);

    // ** Final result **
    $res = $project->displaySelected($table, $nrItems, $startAt, $orderBy, $order);
}

include 'view.php';
