<?php
/**
 *  Item
 *  Item handler : customizable for different types of items
 *  Items in a database
 *
 *  Works with DbCrud
 *
 *  Php version 7
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  CC BY-NC 4.0 https://www.spektatum.com
 * @link     https://creativecommons.org/licenses/by-nc/4.0/
 * @phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore"
 **/

namespace Anax\SimpleCMS;

use PDO;
use Exception;
use PDOException;

// Disabling phpcs because of private methods needing underscore.
// Which phpmd says is not CamelCase
 // phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore

/**
 *  Item
 *  php version 7
 *  Create a Item from the database
 *  Built in functionality for displaying and controlling the display
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT yso@spektatum.com
 * @link     MIT yso@spektatum.com
 **/

class Item
{
    /**
     * Item
     *
     * @var object $dbc    The database class
     */

    public $dbC; // The database connection, dbCrud object

    /**
     * Constructor to initiate db connection
     * using login & DSN details
     *
     * @param object $dbC : dbCrud database connections
     */
    public function __construct(DbCrudInterface $dbC)
    {
        $this->dbC = $dbC;
    }

    /**
     * Display all blogs
     *
     * @param string $table    : the db table
     * @param string $settings : the settings for display
     * @param int    $startAt  : the item to start at
     * @param string $where    : the column where selection be set
     * @param string $idVal    : the identifying value
     *
     * @return object $pdo
     */
    public function displayAll(
        $table,
        $settings = null,
        $startAt = null,
        $where = null,
        $idVal = null
    ) {

        // Set the settings if none
        if (!$settings) {
            $settings = $this->setSettings();
        }

        // Try to collect settings
        try {
            $thePage = $settings->pageNr;
            $nrItems = $settings->nrItems;
        } catch (\Exception $e) {
              return false;
        }

        // Calculate the offset value (nr to start at)
        if (!$startAt) {
            $startAt = (intval($thePage) - 1) * intval($nrItems);
        }

        // Get data selection
        return $this->dbC->selectLimitOffsetWhere(
            $table,
            $nrItems,
            $startAt,
            $where,
            $idVal
        );
    }


    /**
     * Create one
     * Array with column names
     * Combine with column with data
     * Or insert the finished params associative array (column name => the data)
     *
     * @param array  $columnNames : the name of the column
     * @param string $newData     : the new data (for combining)
     * @param string $table       : the db table (for combining)
     * @param string $params      : the completed params array (name=>value)
     *
     * @return object $pdo
     */
    public function createOne(
        $columnNames,
        $newData,
        $table,
        $params = null
    ) {
        // Combine arrays if no params given
        if (!$params) {
            $params = array_combine($columnNames, $newData);
        }

        return $this->dbC->create(
            $table,
            $params
        );
    }


    /**
     * Delete one
     *
     * @param array  $columnName : the name of the column
     * @param string $theId      : the id for deleting
     * @param string $table      : the db table
     *
     * @return object $pdo
     */
    public function deleteOne(
        $columnName,
        $theId,
        $table
    ) {

        return $this->dbC->delete(
            $table,
            $columnName,
            $theId
        );
    }


    /**
     * Edit one
     * Array with column names that should be updated.
     * Combine with the new data in column form.
     *
     * @param int    $theId       : the id / other identifying value
     * @param array  $columnNames : the column names
     * @param array  $newData     : the new data
     * @param string $table       : the db table
     * @param string $columnId    : the column - find the id value
     *
     * @return object $pdo
     */
    public function editOne(
        $theId,
        $columnNames,
        $newData,
        $table,
        $columnId = 'id'
    ) {
        // The params for updating
        // $params = array($editThisColumn => $newData);

        // Combine arrays
        $params = array_combine($columnNames, $newData);

        return $this->dbC->update(
            $table,
            $params,
            $columnId,
            $theId
        );
    }


    /**
     * Search one
     *
     * @param int    $idVal  : the identifying value
     * @param string $column : which column?
     * @param string $table  : the db table
     *
     * @return object $pdo
     */
    public function searchOne(
        $idVal,
        $column,
        $table
    ) {
        return $this->dbC->search(
            $table,
            $column,
            $idVal
        );
    }


    /**
     * Get nr pages
     *
     * @param int    $nrPerPage : the nr of posts
     * @param string $table     : the table
     * @param string $theId     : the id to count
     * @param string $column    : the condition where column if any
     * @param string $select    : the id for selecting
     *
     * @return object $pdo
     */
    public function nrPages($nrPerPage, $table, $theId, $column = null, $select = null)
    {

        $totalNr = $this->dbC->countRows(
            $theId,
            $table,
            $column,
            $select
        );

        $nrRows = floatval($totalNr[0]->rows);

        $nrPages = ceil($nrRows/$nrPerPage);

        if ($nrPages <= 0) {
            $nrPages = 1;
        }

        return $nrPages;
    }


    /**
     * Set display settings
     * Using a JSON memeory
     * If no setting, a new one is created
     *
     * @param string $settings : the set up for the display
     *
     * @return object $STD object
     */
    public function setSettings($settings = null)
    {
        if ($settings) {
            // Here can be the control of settings : advance later
            $settings = json_decode($settings); // Decode to STD object
        }

        if (!$settings) {
            $settings = '{"orderBy":"id","order":"desc","nrItems":"2","pageNr":"1"}';
            $settings = json_decode($settings); // Decode to STD object
        }

        return $settings;
    }


    /**
     * Set page nr and update settings
     *
     * @param int    $pageNr   : the pageNr
     * @param string $settings : the set up for the display
     *
     * @return object $pdo
     */
    public function setPageNr($pageNr = null, $settings = null)
    {
        if (!$settings) {
            $settings = $this->setSettings();
        }

        // Try updating the settings
        try {
            $settings->pageNr = $pageNr;
            if (!$pageNr || $pageNr < 0 || !is_numeric($pageNr)) {
                $settings->pageNr = 1;
            }
        } catch (\Exception $e) {
            return false;
        }

        return $settings;
    }



    /**
     * Set page nr and update settings
     *
     * @param int    $nrItems  : the nr of items
     * @param string $settings : the set up for the display
     *
     * @return object $pdo
     */
    public function setNrItems($nrItems = null, $settings = null)
    {
        if (!$settings) {
            $settings = $this->setSettings();
        }

        // Try updating the settings
        try {
            if (!$nrItems || $nrItems < 0 || !is_numeric($nrItems)) {
                $nrItems = 2;
            }
            $settings->nrItems = $nrItems;
            $settings->pageNr = 1;
        } catch (\Exception $e) {
            return false;
        }

        return $settings;
    }
}
