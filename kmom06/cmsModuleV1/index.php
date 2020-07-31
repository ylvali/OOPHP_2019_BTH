<?php
/*
*
*   Index page with $_GET nav menu & router
*
*/

namespace Ylva\PhpBase;

// * Scripts *
require __DIR__ . "/config/config.php";
require __DIR__ . "/vendor/autoload.php";

// * Object instantiation *
$db = new DbBase($host, $db, $user, $pass); // Basic db connection
$dbCrud = new DbCrud($db); // SQL preparations for CRuD
$printModule = new CmsPrintModule(); // The printer
$cmsModule = new CmsModule($dbCrud, $printModule); // The cms module
$sendVar = new SendVar(); // $_GET & $_POST variables
$sessVar = new SessionVar(); // $_SESSION control

// * The navbar *
$navBar = "<a href='?route=content'> Content </a>";
$navBar .= "<a href='?route=admin'> Admin </a>";
$navBarSub = '';

// * Variables *
$content = '';
$data = '';

// * The routes *
$route = $sendVar->getValue('route');
$choice = $sendVar->getValue('sub');
$id = $sendVar->getValue('id');
$slug = $sendVar->getValue('see');
$confirm = $sendVar->getValue('confirm');


// * The router v1 *

// Check the tests and add assertions

$view = [];

switch ($route) {

case "content":
        include 'routes/content.php';
    break;

case "admin":
        include 'routes/admin.php';
    break;

case "create":
        include 'routes/create.php';
    break;

case "edit":
        include 'routes/edit.php';
    break;

case "delete":
        include 'routes/delete.php';
    break;

case "form":
        include 'routes/form.php';
    break;

case "full":
        include 'routes/full.php';
    break;

default:
    include 'routes/content.php';
}

// including the view
include 'view.php';
