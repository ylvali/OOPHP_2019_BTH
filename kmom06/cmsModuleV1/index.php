<?php
/*
*
*   Index page with $_GET nav menu & router
*
*/
namespace Ylva\PhpBase;

// ** Scripts **
require __DIR__ . "/config/config.php";
require __DIR__ . "/vendor/autoload.php";

// ** Object instantiation **
$db = new DbBase($host, $db, $user, $pass); // Basic db connection
$dbCrud = new DbCrud($db); // SQL preparations for CRuD
$printModule = new CmsPrintModule(); // The printer
$cmsModule = new CmsModule($dbCrud, $printModule); // The cms module
$sendVar = new SendVar(); // $_GET & $_POST variables
$sessVar = new SessionVar(); // $_SESSION control

// ** The navbar **
$navBar = "<a href='?route=content'> Content </a>";
$navBar .= "<a href='?route=admin'> Admin </a>";
$navBarSub = '';
$content = '';
$data = '';

$route = $sendVar->getValue('route');
$choice = $sendVar->getValue('sub');
$id = $sendVar->getValue('id');
$slug = $sendVar->getValue('see');
$confirm = $sendVar->getValue('confirm');


// ** The router v1 **

// ADD special views to an array with content depending on route

// MAKE SuRE all OuTpuT is properly filtered

// Check the tests and add assertions

// Put on text filtering for the input


switch ($route) {

case "content":
    $navBarSub = "<a href='?route=content&&sub=page'> Page </a>";
    $navBarSub .= "<a href='?route=content&&sub=blog'> Blog </a>";
    if ($choice) {

        if($choice == 'blog') {
            $content = $cmsModule->read($choice, $choice);
        } else {
            // Display only one, nr 1
            $id = 1;
            $optionRef = 'page'; // printer ref
            $column = 'id';
            $exactVal = true; // Search exact value
            $content = $cmsModule->search($choice, $column, $id, $exactVal, $optionRef);
        }

        // $content = $cmsModule->read($choice, $choice); // Table name & reference
        // render the content to the view
    }
    break;

case "admin":
    $navBarSub = "<a href='?route=admin&&sub=page'> Page </a>";
    $navBarSub .= "<a href='?route=admin&&sub=blog'> Blog </a>";
    if ($choice) {
        if($choice == 'blog') {
            // Display blog with edit / delete options
            $content = "<a href='?route=create&&sub=blog'> Create new </a>";
            $content .= 'blog admin';
            $optionRef = 'blogAdmin'; // reference for the printer
            $content .= $cmsModule->read($choice, $optionRef);
            // Plus the option to create a new post

        } else {
            // The only option is to edit the page,
            // so this route redirects to the edit section.
            header("Location:?route=edit&&sub=page");
            $content = 'page admin';
        }
    }
    // enter the content to the view
    break;

case "create":
    // $navBarSub .= "<a href='?route=create&&sub=blog'> Blog </a>";
    if ($choice == 'blog') {
        // Get the correct data
        // render the content to the view
        $formAction = "?route=create&&sub=form";
        $content = $cmsModule->createForm($formAction);
    }

    if ($choice == 'form') {
        // Get the values from $_POST
        $content = 'create item';

        // Incoming post data
        $postData = array('title', 'data');

        // Get the corresponding post values
        $params = $sendVar->postValue($postData);
        $params['slug'] = $cmsModule->slugify($params['title']); //slug

        $optionRef = 'noPrint'; // for the printer
        $column = 'slug';
        $table = 'blog';
        $exactVal = true; // Search exact value
        $slug = $params['slug'];
        $empty = $cmsModule->isEmpty($table, $column, $slug, $exactVal, $optionRef);

        if ($empty) {
            $cmsModule->create($table, $params);
            $content = 'The update is completed.';
        } else {
            $content = 'The title is in use.';
        }
    }

    break;

case "edit":
    // $navBarSub = "<a href='?route=edit&&sub=page'> Page </a>";
    // $navBarSub .= "<a href='?route=edit&&sub=blog&&id=$id'> Blog </a>";
    if ($choice) {

        if ($choice == 'blog') {

            // Display the form for that id
            if($id) {
                $content .= ' ID: '.$id;
                // Display the form for that id
                $optionRef = 'theForm';
                $column = 'id';
                $exactVal = true; // Search exact value
                $content .= $cmsModule->search($choice, $column, $id, $exactVal, $optionRef);
                $content .= "<a href='?route=delete&&sub=blog&&id=$id'> Delete </a>";
            }

        } else {
            // ONLY EDITS FIRST ONE
            // Display the form for that id
                $id = 1;
                $content .= ' ID: '.$id;
                // Display the form for that id
                $optionRef = 'theForm';
                $column = 'id';
                $exactVal = true; // Search exact value
                $content .= $cmsModule->search($choice, $column, $id, $exactVal, $optionRef);
            }
        }
    break;

case "delete":
    // $navBarSub .= "<a href='?route=delete&&sub=blog&&id=$id'> Blog </a>";
    if ($choice) {
        if($choice == 'blog') {

            // Delete that id
            if ($id) {

                $content = "Are you sure?";
                $content .= "<a href='?route=delete&&sub=blog&&id=$id&&confirm=yes'> Yes </a>";

                // Avoid errors with confirming the delete
                if ($confirm) {
                    $column = 'id';
                    $cmsModule->softDelete($choice, $column, $id);

                    $content = 'blog deleted';
                }
            }

        } else {
            // Display the edit page
            $content = 'delete page';
        }
    }
    break;

case "form":
    // $navBarSub .= "<a href='?route=form&&sub=blog";
    if ($choice) {
        if ($choice == 'blog') {
            // Should update the database with the correct values from $_POST
            // Table, column name & new value

            // Incoming post data
            $postData = array('id', 'title', 'data');

            // Get the corresponding post values
            $params = $sendVar->postValue($postData);
            $idVar = 'id';
            $idVal = $params[$idVar];

            $cmsModule->update($choice, $params, $idVar, $idVal);

            $content = 'The changes to the blog are done';
            };

        if ($choice == 'page') {
            // Should update the database with the correct values from $_POST
            // Table, column name & new value

            // Incoming post data
            $postData = array('id', 'title', 'data');

            // Get the corresponding post values
            $params = $sendVar->postValue($postData);
            $idVar = 'id';
            $idVal = $params[$idVar];

            $cmsModule->update($choice, $params, $idVar, $idVal);

            $content = 'The changes to the page are done';
        }
    }
    break;

    case "full":
    // Display the full page through a slug
    if ($slug) {
        $optionRef = 'blog';
        $column = 'slug';
        $table = 'blog';
        $exactVal = true; // Search exact value
        $content = $cmsModule->search($table, $column, $slug, $exactVal, $optionRef);
    }
    break;

default:
    echo 'def';
}

// The view : add this to an array for printing?
// As an object that returns the correct data? associative array
// echo $navBar;
// echo $navBarSub;
// echo $choice;
// echo $content;

include 'view.php';
