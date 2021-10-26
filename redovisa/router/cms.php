<?php
/**
 *
 * ProductDb demo
 * Db connection with a productDb
 *
 */

namespace Anax\SimpleCMS;

/**
 *
 * Start productDb
 *
 */
$app->router->add("cms/start", function () use ($app) {

    /*
    *
    *   Db config
    *
    */
    $host = 'blu-ray.student.bth.se:3306';
    // $host = 'localhost';
    $theDb = 'ylsj11';
    // $theDb = 'oophp';
    // $user = 'ylsj11';
    $pass = 'c3wARF3zGpfX';
    $user = 'user';
    $pass = 'pass';


    // --- Basic objects

    // Class for PDO handling & database connection
    // $db = new DbBase($host, $theDb, $user, $pass); // Basic db connection

    // Choose to use the anax app db functionality or the dbBase object
    // If anax is plugged in, it will be chosen.
    $dbAPI = new DbAPI(null, $app); // The API for database

    // Class for simple and effective SQL handling
    $dbCrud = new DbCrud($dbAPI); // SQL preparations for CRuD

    // Anax framework plugin for suoer variables
    $request = new \Anax\Request\Request();

    // Control of supervariables
    $sendVarObj = new SendVar();
    $sessVar = new SessionVar();

    // System controller
    $systemControl = new SystemController($dbCrud, null, $request);

    // Action controller
    $actionController = new ActionController($dbCrud);

    // Project specific : Item and view
    $blog = new Item($dbCrud); // The blog/page
    $filter = new TheTextFilter(); // The text filter
    $blogView = new BlogView($filter); // The view
    $pageView = new PageView($filter);

    // Get the menu, project specific
    // Containing the routes
    $menu = $systemControl->getMenu();

    // The data from POST from the system controller
    // Which post keys to look for?
    $postKeys = array('pageSection', 'theIdVal',
                  'path', 'data', 'title');
    $postRes = $systemControl->postData($postKeys);

    // Set variables from result
    $pageSection = $postRes['pageSection'];
    $theId = $postRes['theIdVal'];

    $viewContent = [];
    $viewContent['test'] = '';


    switch ($pageSection) {
        case "page1":
            // ** Display the page text **
            $table = 'content';
            $resPage = $blog->displayAll($table, null, null, 'type', 'page');

            // Filter, create slug & print
            $htmlPage = $pageView->printHTML($resPage, 'hem');
            $viewContent['test'] .= $htmlPage;

            break;

        case "page2":
            // ** Display the page text **
            $table = 'content';
            $resPage = $blog->displayAll($table, null, null, 'type', 'page');

            // Filter, create slug and print
            $htmlPage = $pageView->printHTML($resPage, 'om');
            $viewContent['test'] .= $htmlPage;

            break;

        case "blog":
            // ** Display the blog **
            $createMenu = "<form action ='' method='post'>
                          <input type='submit' class='btn1'
                           name='pageSection' value='create'>
                          </form>";

            // Set the settings
            $setC = html_entity_decode($systemControl->postData('settings'));
            $settings = $blog->setSettings($setC);

            // Update page nr
            $pageNr = $systemControl->postData('pageNr');
            if ($pageNr) {
                    $settings = $blog->setPageNr($pageNr, $settings);
            }

            // Update nr items
            $nrItems = $systemControl->postData('nrItems');
            if ($nrItems) {
                    $settings = $blog->setNrItems($nrItems, $settings);
            }

            // The nr of pages total calculated
            //  depending on the choice of nr items / page
            $table = 'content';
            $id1 = 'id';
            $column = 'type';
            $id2 = 'post';
            $nrPages = $blog->nrPages($settings->nrItems, $table, $id1, $column, $id2);

            // Get all the data
            $res = $blog->displayAll($table, $settings, null, 'type', 'post');


            // *** Get the view ***

            // The buttons
            $buttons = $blogView->pageButtons($nrPages, $settings->pageNr, $settings);

            // Print the blog view
            $res2 = $blogView->printHTML($res);

            $tableRes = "<div class='presTable'>$res2</div>";

            // *** Print view ***
            $viewContent['test'] .= $createMenu."<hr>";
            $viewContent['test'] .= $tableRes;
            $viewContent['test'] .= $buttons;



            break;

        case "create":
            // ** Get the create form **
            $createForm = $blogView->getCreateForm();

            $viewContent['test'] .= '<br\> <h2> Create new blog item </h2><hr><br\>';

            $viewContent['test'] .= $createForm;

            break;

        case "new":
            //** Get the correct data from POST **
            // $createThis = $systemControl->postData2();

            // Which post keys to look for?
            $postKeys = array('title', 'path', 'data');

            // Extract values. If not found, set to null.
            // $createThis = $systemControl->postArray($postKeys);
            $createThis = $systemControl->postData($postKeys);

            // Which post keys to look for?
            $postKeys = array('bbcode', 'link', 'markdown', 'nl2br');

            // Extract values. If not found, set to null.
            $filters = $systemControl->postData($postKeys);

            // Create a coma separated string
            $stringFilter = $filter->dbFilter($filters);

            // // Get the set filters
            // $stringFilter = $systemControl->filterPostData();

            // Add the filters to the array for creation
            $createThis['filter'] = $stringFilter;

            // Set type
            $createThis['type'] = 'post';

            // Create the slug
            $createThis['slug'] = $filter->slugify($createThis['title']);

            // Create path as null if empty
            if ($createThis['path'] == '') {
                $createThis['path'] = null;
            } 

            // Create a new blog post
            $res = $blog->createOne(null, null, 'content', $createThis);

            $result = "Try again, values are not correct?";
            if ($res) {
                  $result = "New blog created";
            }

            // Control the new values is appropriate to do here
            $viewContent['test'] .= '<br\><br/> <h2> Creating item </h2><hr><br\>';
            $viewContent['test'] .= $result;

            break;

        case "edit":
            // ** Get the edit form **
            $table = 'content';

            $resId = $blog->displayAll($table, null, null, 'id', $theId);

            $editForm = $blogView->getEditForm($theId, $resId);

            $viewContent['test'] .= '<br\> <h2> Edit: '.$theId.' </h2><hr><br\>';

            $viewContent['test'] .= $editForm;

            break;

        case "newEditValues":
              // Control values, now mini version and only the path
            if ($postRes['path']==='') {
                    $postRes['path'] = null;
            }

            // Create the updating arrays
            $columns = array('path', 'title', 'data');
            $newValues = array($postRes['path'], $postRes['title'], $postRes['data']);
            $table = 'content';


            // Do the update
            $editRes = $blog->editOne($theId, $columns, $newValues, $table);

            $result = 'Edit not completed';
            if ($editRes) {
                    $result = 'Edit successful';
            }

            $viewContent['test'] .= '<br/>'.$result;

            break;

        case "soft_delete":
            // Display data from the database
            $table = 'content';
            $resId = $blog->displayAll($table, null, null, 'id', $theId);

            $deleteStatus = $resId[0]->deleted;


            // If a delete, then undo it
            // If no delete, soft delete it
            if ($deleteStatus != null) {
                    $deleted = null;
            }

            if (!$deleteStatus) {
                    $date = new \DateTime();
                    $deleted = $date->format('Y-m-d H:i:s');
            }

            // Update the table
            // Create the updating arrays
            $columns = array('deleted');
            $newValues = array($deleted);
            $table = 'content';

            // Do the update
            $deleteRes = $blog->editOne($theId, $columns, $newValues, $table);


            $viewContent['test'] .= ' <br/> Delete / Undo delete: '.$theId;

            break;


        case "db_delete":
            // Set data for delete
            $column = 'id';
            $table = 'content';

            // Do the delete
            $deleteRes = $blog->deleteOne($column, $theId, $table);

            $result = 'not deleted';
            if ($deleteRes) {
                $result = 'deleted permanently';
            }

            $viewContent['test'] .= ' <br/> Deleted permanently '.$theId;

            break;

        default:
            // ** Display the page text **
            $table = 'content';
            $resPage = $blog->displayAll($table, null, null, 'type', 'page');

            // Filter, create slug & print
            $htmlPage = $pageView->printHTML($resPage, 'hem');
            $viewContent['test'] .= $htmlPage;

            break;
    }

    $theContent = '';
    foreach ($viewContent as $content) {
        $theContent .= $content;
    }


    // Setting the content to send t the view
    $title = "Simple cms";
    $data = [
        "class" => "productDb",
        "gameHeader" => "<h1>CMS</h1>",
        "content" => "
                    <p>Simple cms</p>
                    <p>$menu</p>
                    <p>$theContent</p>"
    ];

    // Adding the view and including the content
    $app->page->add("anax/productDb/productDb", $data);

    // Returning the total
    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 *
 * Edit .
 *
 */
$app->router->add("productDb/edit", function () use ($app) {

    // Setting the content to send to the view
    $title = "product storage demo";
    $data = [
        "class" => "productDb",
        "gameHeader" => "<h1>product storage demo</h1>",
        "content" => 'The values of correct format are updated '.$aLink,
    ];

    // Adding the view and including the content
    $app->page->add("anax/productDb/productDb", $data);

    // Returning the total
    return $app->page->render([
        "title" => $title,
    ]);
});
