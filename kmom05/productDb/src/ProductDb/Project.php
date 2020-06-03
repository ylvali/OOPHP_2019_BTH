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
namespace Ylva\ProductDb;
use Exception;

/**
 *   Project
 *   php version 7
 *   Project is a class that handles project data related to a database.
 *   It depends on the interfaces for DbCrud & ProjectData
 *
 * @category ProjectController
 * @package  Project
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/
class Project
{
    /**
     * Project is a controller handling a project
     *
     * @var object $dbConnection   The DbCrud class
     * @var object $projectData    The ProjectData class
     */

    public $dbConnection; // The database PDO connection from DbCrud
    public $projectData; // The project specific data

    /**
     * Constructor to initiate db connection
     *
     * @param object $theDb   - the dbCrud class interface
     * @param object $proData - the proect class interface
     */
    public function __construct(
        DbCrudInterface $theDb, ProjectDataInterface $proData
    ) {
        // Save database connection as property
        $this->dbConnection = $theDb;

        // Get the project data
        $this->projectData = $proData;
    }


    // /**
    //  * Method for showing all table data
    //  *
    //  * @return string $tableString - the resulting string table
    //  */
    // public function showAllData()
    // {
    //     // Get the data
    //     $table = 'products';
    //     $res = $this->dbConnection->read($table);
    //
    //     // Create the presentable table from the data
    //     $tableString = $this->projectData->getStringTable($res);
    //
    //     return $tableString;
    // }


    // /**
    //  * Method for showing all table data in specific order
    //  *
    //  * @param string $table   - which table to use
    //  * @param string $orderBy - which column to use
    //  * @param string $order   - desc / asc
    //  *
    //  * @return string $res - the resulting string table
    //  */
    // public function showAllDataInOrder($table, $orderBy, $order)
    // {
    //     // Get the data
    //     // $table = 'products';
    //     $res = $this->dbConnection->readInOrder($table, $orderBy, $order);
    //
    //     // Create the presentable table from the data
    //     $tableString = $this->projectData->getStringTable($res);
    //
    //     return $tableString;
    // }


    /**
     * The createNewItem
     * Method for creating a new item
     * Displays a form of the result
     *
     * @param string $table  - which table to use
     * @param array  $params - which table to use
     *
     * @return void
     */
    public function createNewItem($table, $params)
    {
        // Create new item
        $this->dbConnection->create($table, $params);
        //var_dump($res);
    }


    /**
     * The deleteItem
     * Method for deleting an item
     * Displays a form of the result
     *
     * @param string $table   - which table to use
     * @param string $column  - which column
     * @param string $idValue - which column
     *
     * @return void
     */
    public function deleteItem($table, $column, $idValue)
    {
        // Create new item
        $this->dbConnection->delete($table, $column, $idValue);
    }


    /**
     * The displayBtns
     * Method for displaying btn panel for the project
     *
     * @param $settings - json memory of display settings
     *
     * @return string $res - the resulting btn table
     */
    public function displayBtns($settings = null)
    {
        return $this->projectData->getBtnPanel($settings);
    }


    /**
     * The reset
     * Method for resetting the database
     * Loads reset SQL from db/reset.php
     *
     * @param file $file : the file with sql
     *
     * @return boolean : true if done
     */
    public function reset($file)
    {
        $res = $this->dbConnection->reset($file);
        return $res;
    }

    //
    // /**
    //  * The searchDb
    //  * Method for searching the database
    //  * Creates a presentable string table
    //  *
    //  * @param string $table      - which table?
    //  * @param string $column     - which column?
    //  * @param string $searchWord - which searchWord?
    //  *
    //  * @return string $res - table containing the result in specific way
    //  */
    // public function searchDb($table, $column, $searchWord)
    // {
    //     $res = $this->dbConnection->search($table, $column, $searchWord);
    //
    //     // Create table from the result
    //     $tableString = $this->projectData->getStringTable($res);
    //
    //     return $tableString;
    // }


    /**
     * The searchMultipleColumns
     * Method for searching multiple columns in the database
     * Creates a presentable string table via trait
     *
     * @param string $table      - which table?
     * @param array  $column     - which column?
     * @param string $searchWord - which searchWord?
     *
     * @return string $res - table containing the result in specific way
     */
    public function searchMultipleColumns($table, array $column, $searchWord)
    {
        $resArray = [];
        foreach ($column as $thisColumn) {
            $theRes = $this->dbConnection->search($table, $thisColumn, $searchWord);
            if (!empty($theRes)) {
                if (!in_array($theRes, $resArray)) { // eliminate duplicates
                    array_push($resArray, $theRes);
                }
            }
        }
        //var_dump($resArray);

        // Create string table from the result
        $stringTables = "";
        foreach ($resArray as $result) {
            $settings = null;
            $stringTables .= $this->projectData
                ->getStringTableNoEdit($result, $settings);
        }

        return $stringTables;
    }


    /**
     * The searchDbArray
     * Method for searching the database
     * Returns object with result
     *
     * @param string $table      - which table?
     * @param string $column     - which column?
     * @param string $searchWord - which searchWord?
     *
     * @return object $res - table containing the result in specific way
     */
    public function searchDbArray($table, $column, $searchWord)
    {
        $res = $this->dbConnection->search($table, $column, $searchWord);

        return $res;
    }


    /**
     * The updateForm
     * Method for getting an edit form from id
     * uses the trait for printing options
     *
     * @param string $table      - which table?
     * @param string $column     - which column?
     * @param string $searchWord - which searchWord?
     *
     * @return object $res - table containing the result in specific way
     */
    public function updateForm($table, $column, $searchWord)
    {
        $res = $this->searchDbArray($table, $column, $searchWord);

        $form = $this->projectData->getEditForm($res);

        return $form;
    }


    /**
     * The getAddForm
     * Method for getting an add form
     * uses the trait for printing
     *
     * @return string $addForm - form for adding
     */
    public function getAddForm()
    {
        $form = $this->projectData->getAddForm();
        return $form;
    }


    /**
     * The getNrPages
     * Method for calculating nr of pages
     *
     * @param $idVar     - identifying variable to use
     * @param $table     - which sql table is used
     * @param $nrPerPage - how many per page?
     * @param $settings  - settings for display
     * @param $thisPage  - nr of currently displayed page
     *
     * @return string $link - link for nr pages
     */
    public function getNrPages($idVar, $table, $nrPerPage,
        $settings = null, $thisPage = null
    ) {
        $maxValue = $this->dbConnection->countRows($idVar, $table);
        $nrRows = floatval($maxValue[0]->rows);
        $nrPages = round($nrRows/$nrPerPage);
        // var_dump($nrPages);
        if ($nrPages <= 0) {
            $nrPages = 1;
        }
        // var_dump($nrPages);

        $settings = json_encode($settings);
        $pages = "<form action='' method='post'>";
        $pages .= "<input type='hidden' name='settings' value=$settings>";
        for ($i=0; $i<$nrPages; $i++) {
            $aNr = $i + 1;
            // $pages .= "<a href=?nrPages=$nr>| $nr |</a>";

            // Set the btn class style
            $class = 'btn1';
            if ($aNr == $thisPage) {
                $class = 'btn1Selected';
            }

            // Create the btn
            $pages .= "<button type=submit class='$class' name='nrPages'";
            $pages .= " value=$aNr> $aNr </button>";
        }
        $pages .= "</form>";

        // var_dump($pages);
        // var_dump($nrPages);

        return $pages;
    }


    /**
     * The updateData
     * The data update method
     *
     * @param string $table  - which table?
     * @param array  $params - array(columnName => newValue)
     * @param string $idVar  - identifying variable
     * @param string $idVal  - identifying value
     *
     * @return string $res - table containing the updated values
     */
    public function updateData($table, $params, $idVar, $idVal)
    {
        // update the form
        $this->dbConnection->update($table, $params, $idVar, $idVal);

        // get the updated values
        $res = $this->searchDbArray($table, $idVar, $idVal);

        // Create table from the result
        $tableString = $this->projectData->getStringTableNoEdit($res);

        return $tableString;
    }


    /**
     * - displaySelected -
     * Displays a selected section from the database.
     * The user decides from options how many per page should be displayed.
     *
     * @param string $table    - which table to use
     * @param int    $rows     - how many rows
     * @param int    $start    - which item nr to start at
     * @param string $orderBy  - set if there should be an order
     * @param string $order    - ASC/DESC if any
     * @param string $settings - settings memory
     *
     * @return $res - The result from the database to display
     */
    public function displaySelected(
        $table, $rows, $start,
        $orderBy = null, $order = null,
        $settings = null
    ) {
        $res = $this->dbConnection
            ->selectLimitOffset($table, $rows, $start, $orderBy, $order);
        // var_dump($res);

        $stringTable = $this->projectData
            ->getStringTable($res, $settings);

        return $stringTable;
    }
}
