<?php
/**
 *
 * ProductDb demo
 * Db connection with a productDb
 *
 */

namespace Anax\ProductDb;

/**
 *
 * Start productDb
 *
 */
$app->router->add("productDb/start", function () use ($app) {

    /*
    *
    *   Db config
    *
    */
    // $host = 'blu-ray.student.bth.se:3306';
    $host = 'localhost';
    // $db = 'ylsj11';
    $db = 'oophp';
    // $user = 'ylsj11';
    // $pass = 'c3wARF3zGpfX';
    $user = 'user';
    $pass = 'pass';
    $test = null; // testing mode off
    $anaxPlugin = true; // anax framework plugin
    $anaxApp = $app; // anax app object, framework plugin

    // ** Object instantiation **
    $db = new DbBase($host, $db, $user, $pass, $test, $anaxPlugin, $anaxApp); // Basic db connection + anax framework plugin
    $dbCrud = new DbCrud($db); // SQL preparations for CRuD
    $projectData = new ProjectData(); // Project specific data
    $project = new Project($dbCrud, $projectData); // Project operations

    $request = new \Anax\Request\Request();
    $request->init();
    $sendVar = new SendVar($request); // $_GET & $_POST variables + anax framework plugin
    // $sessVar = new SessionVar(); // $_SESSION control


    // ** The JSON Obj setting memory **
    // REST json obj memory for display settings via POST
    // updated via ui.
    // Order by, order, nrItems & nrPages buttons updates the memory.
    // The memory is then used to display selected output via the decoded JSON obj.

    // Collect incoming JSON memory or create a new one
    $settings = html_entity_decode($sendVar->postValue('settings')); // Recieve from POST
    if (!$settings) {
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
    function setSettings($variable, $sendVar, $settings)
    {
        $value = $sendVar->postValue($variable);
        if ($value) {
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
    // product pages (no offset without error)
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
    function getSelected($sendObj)
    {
        $choices = array('add', 'reset', 'search', 'edit', 'delete');
        $selected = null;
        foreach ($choices as $choice) {
            $theValue = $sendObj->postValue($choice);
            if ($theValue) {
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
            include('proDb/add.php');
            break;
        case "reset":
            include('proDb/reset.php');
            break;
        case "search":
            include('proDb/search.php');
            break;
        case "edit":
            include('proDb/edit.php');
            break;
        case "delete":
            include('proDb/delete.php');
            break;
        default:
            include('proDb/showAll.php');
    }

     // The ne of the page
     $pageNr = '';
    if ($nrPages) {
          $pageNr = 'Page nr: '.$nrPages;
    }

    // Setting the content to send t the view
    $title = "product storage demo";
    $data = [
        "class" => "productDb",
        "gameHeader" => "<h1>product storage demo</h1>",
        "content" => "
                    <p>$btnPanel</p>
                    <p>$res</p>
                    <p>$pageLink</p>
                    <p>$pageNr</p>"
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

    /*
    *
    *   Db config
    *
    */
    $host = 'blu-ray.student.bth.se:3306';
    $db = 'ylsj11';
    $user = 'ylsj11';
    $pass = 'c3wARF3zGpfX';

    // Anax
    $anaxPlugin = true; // anax framework plugin
    $anaxApp = $app; // anax app object, framework plugin

    // Set up
    $db = new DbBase($host, $db, $user, $pass, $anaxPlugin, $anaxApp); // anax framework plugin
    $dbCrud = new DbCrud($db);
    $projectData = new ProjectData();
    $project = new Project($dbCrud, $projectData);

    $request = new \Anax\Request\Request();
    $request->init();
    $sendVar = new SendVar($anaxPlugin, $request); // anax framework plugin

    /**
    *  Collect the incoming values and send to db
    */
    $id = $sendVar->postValue('id');
    $name = $sendVar->postValue('name');
    $year = $sendVar->postValue('year');

    $year = is_numeric($year)? $year : null;
    $params = array('id' => $id, 'name' => $name, 'year' => $year);

    $res = $project->updateData('products', $params, 'id', $id);


     // Link for returning to the main page
     $aLink = "<a href='start' class='btn1'> Ok </a>";


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


/**
 *
 * Add .
 *
 */
$app->router->add("productDb/add", function () use ($app) {

    /*
    *
    *   Db config
    *
    */
    $host = 'blu-ray.student.bth.se:3306';
    $db = 'ylsj11';
    $user = 'ylsj11';
    $pass = 'c3wARF3zGpfX';

    // Anax
    $anaxPlugin = true; // anax framework plugin
    $anaxApp = $app; // anax app object, framework plugin

    $db = new DbBase($host, $db, $user, $pass, $anaxPlugin, $anaxApp); // anax framework plugin
    $dbCrud = new DbCrud($db);
    $projectData = new ProjectData();
    $project = new Project($dbCrud, $projectData);

    $request = new \Anax\Request\Request();
    $request->init();
    $sendVar = new SendVar($anaxPlugin, $request); // anax framework plugin

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
        $pic = '../img/purpleYellowFlo300px.jpg';
        $params = array('id'=>$id, 'name'=>$name, 'pic'=>$pic, 'year'=>$year);
        $table = 'products';

        $project->createNewItem($table, $params);
    }

     // Link for returning to the main page
     $aLink = "<a href='start' class='btn1'> Ok </a>";

    // Setting the content to send to the view
    $title = "product storage demo";
    $data = [
        "class" => "productDb",
        "gameHeader" => "
                        <h1>productDb</h1>",
        "content" => 'Values added if in correct format '.$aLink,
    ];

    // Adding the view and including the content
    $app->page->add("anax/productDb/productDb", $data);

    // Returning the total
    return $app->page->render([
        "title" => $title,
    ]);
});
