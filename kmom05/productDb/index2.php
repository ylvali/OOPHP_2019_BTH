<?php
namespace Ylva\ProductDb;


// ** Scripts **
require __DIR__ . "/config/config.php";
require __DIR__ . "/vendor/autoload.php";


// ** Object instantiation **
$db = new DbBase($host, $db, $user, $pass); // Basic db connection
$dbCrud = new DbCrud($db); // SQL preparations for CRuD
$projectData = new ProjectData(); // Project specific data
$project = new Project($dbCrud, $projectData); // Project operations
$sendVar = new SendVar(); // $_GET & $_POST variables
$sessVar = new SessionVar(); // $_SESSION control


// ** The JSON Obj setting memory **
// REST json obj memory to remember display settings is passed via POST
// and updated via clicks from the user.
// Order by, order, nrItems & nrPages buttons updates the memory.
// The memory is then used to display selected output via the decoded JSON obj.

// Collect incoming JSON memory or create a new one
$settings = html_entity_decode($sendVar->postValue('settings')); // Recieve from POST
if(!$settings) {
    $settings = array("orderBy" => "id", "order" => "desc", "nrItems" => "4", "nrPages" => "1"); // default
} else {
    $settings = json_decode($settings, true); // Decode to array
}


// ** The upating of page output settings **//

// Save previous settings
// to be able to for example detect changes
$previousSettings = $settings;

// Set the settings
// Collecting incoming POST values from the button clicks

/**
 * Set the settings : setSettings
 * If a value is found
 * in the selected $_POST
 * it is set to the settings
 *
 * @param string $variable : represets orderBy / order / nrItems / nrPages
 * @param object $sendVar  : the $_POST & $_GET sendVar initiated class
 * @param array  $settings : the settings variable
 *
 * @return array $settings : the settings variable
 *
 */
function setSettings($variable, $sendVar, $settings) {
    $value = $sendVar->postValue($variable);
    if($value) {
        $settings[$variable] = $value;
    }
    return $settings;
}

$variable = 'orderBy';
$settings = setSettings($variable, $sendVar, $settings);

$variable = 'order';
$settings = setSettings($variable, $sendVar, $settings);

$variable = 'nrItems';
$settings = setSettings($variable, $sendVar, $settings);

$variable = 'nrPages';
$settings = setSettings($variable, $sendVar, $settings);


// If the nr of items to display has been changed,
// the page nr is reset to 1 to not display empty
// product pages (offset without error)
if ($settings['nrItems'] != $previousSettings['nrItems']) {
    $settings['nrPages'] = 1;
}


// Save the settings to the JSON file in the button panel
$btnPanel = $project->displayBtns($settings);

// Set the variables
$orderBy = $settings["orderBy"];
$order = $settings["order"];
$nrItems = $settings["nrItems"];
$nrPages = $settings["nrPages"];


// ** Displaying the data **

/**
*   getSelected
*   Function that loops through the button options
*   If a button has been selected the value is returned
*   @param object $sendObj : object for handling $_POST / $_GET
*   @return string $selected :
*
*/
function getSelected($sendObj){
    $choices = array('add', 'reset', 'search', 'edit', 'delete');
    $selected = null;
    foreach($choices as $choice) {
        $theValue = $sendObj->postValue($choice);
        if($theValue){
            $selected = array($choice, $theValue);
        }
    }
    return $selected;
}

// Get value from button click if any
$option = getSelected($sendVar);
// var_dump($option);

// Case switch displaying correct data
$pageLink = '';
$res = '';
switch ($option[0]) {
    case "add":
        include('btnResponse/add.php');
        break;
    case "reset":
        include('btnResponse/reset.php');
        break;
    case "search":
        include('btnResponse/search.php');
        break;
    case "edit":
        include('btnResponse/edit.php');
        break;
    case "delete":
        include('btnResponse/delete.php');
        break;
    default:
        include('btnResponse/showAll.php');
}

include 'view.php';
