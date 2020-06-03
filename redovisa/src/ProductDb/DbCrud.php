<?php
/**
 *  DbCrud
 *  php version 7
 *  Database - create | read | update | delete
 *
 * @category DbConnection
 * @package  ProjectDb
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

namespace Anax\ProductDb;

use PDO;
use Exception;

/**
 *  DbCrudInterface
 *  php version 7
 *
 * DbCrud is a class for the CRuD commands.
 * It uses DbBase via dependency injection and depends on its interface
 * for database connection via PDO.
 *
 * To be updated with more security like htmlentities?
 *
 * @category DbConnection
 * @package  ProjectDb
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

class DbCrud implements DbCrudInterface
{
    /**
     * The connection to db
     *
     * @var object $dbConnection The DbBase class
     */
    public $dbConnection; // The database PDO connection from DbBase


    /**
     * The constructor
     * Constructor to initiate db connection
     *
     * @param object $dbI : the dbBase class interface
     */
    public function __construct(DbBaseInterface $dbI)
    {
        // Save database connection as property
        $this->dbConnection = $dbI;
    }

    /**
     * The create
     * Method for creating new item in database
     * Creates a new item from sql
     *
     * @param string $table  : which table to use
     * @param array  $params : (columnName => newValue)
     *
     * @return string $res : the result returned
     */
    public function create($table, $params)
    {
        // ** Set the sql **
        $sql = "INSERT INTO $table ";
        // $paramNr = count($params);

        // implode keys of $array...
        $sql .= " (`".implode("`, `", array_keys($params))."`)";

        // implode values of $array...
        $sql .= " VALUES ('".implode("', '", $params)."'); ";

        // Security
        $sql = htmlentities($sql);

        // var_dump($sql);

        // ** Send to the db **
         $res = $this->dbConnection->getData($sql);

         return $res;
    }


    /**
     * The read
     * Method for reading database
     * If order is given, the result will be based on it.
     *
     * @param string $table   : which table to use
     * @param string $orderBy : which column
     * @param string $order   : ASC/DESC
     *
     * @return string $res : the result returned
     */
    public function read($table, $orderBy = null, $order = null)
    {
        // Set the sql
        $sql = "SELECT * FROM $table";
        if ($orderBy && $order) {
            $sql = "SELECT * FROM $table ORDER BY $orderBy $order";
        }

        // Get the data
        $res = $this->dbConnection->getData($sql);

        return $res;
    }


    // /**
    //  * The readInOrder
    //  * Method for reading database in specific order
    //  * SELECT * FROM $table ORDER BY $orderBy $order;
    //  *
    //  * @param string $table   : which table to use
    //  * @param string $orderBy : which column
    //  * @param string $order   : ASC/DESC
    //  *
    //  * @return string $res : the result
    //  */
    // public function readInOrder($table, $orderBy, $order)
    // {
    //     // Set the sql
    //     $sql = "SELECT * FROM $table ORDER BY $orderBy $order";
    //
    //     // Get the data
    //     $res = $this->dbConnection->getData($sql);
    //
    //     return $res;
    // }


    /**
     * The update
     * Method for updating database
     * Creates an sql from params in
     * an associative array & identifying variable and value
     * array = (columnName => newValue)
     *
     * @param string $table            : which table to use
     * @param string $params           : (columnName => newValue)
     * @param string $identifyingVar   : identifying variable
     * @param string $identifyingValue : identifying value
     *
     * @return string $res : the result
     */
    public function update($table, $params, $identifyingVar, $identifyingValue)
    {
        // ** Set the sql **
        $sql = "UPDATE $table SET ";
        $paramsValue = [];

        foreach ($params as $key => $value) {
            $sql .= "$key = ?,";
            array_push($paramsValue, $value);
        } // Loop the params and create a sql string for each & save the value

        $sql = rtrim($sql, ","); // remove last coma

        $sql .= " WHERE $identifyingVar = '$identifyingValue';";

        // ** Send to the db **
        $res = $this->dbConnection->getData($sql, $paramsValue);

        return $res;
    }


    /**
     * The delete
     * Method for deleting product from database
     * Creates an sql from the arguments
     *
     * @param string $table   : which table to use
     * @param string $column  : which column
     * @param string $idValue : identifying value of what will be deleted
     *
     * @return string $res : the result
     */
    public function delete($table, $column, $idValue)
    {
        // ** Set up the SQL **
        $sql = "DELETE FROM $table WHERE $column = '$idValue'";

        // ** Send to the db **
        $res = $this->dbConnection->getData($sql);

        return $res;
    }


    /**
     * The search
     * Method for searching in database
     *
     * @param string $table      : which table to use
     * @param string $column     : which column to use
     * @param string $searchWord : which searched word
     *
     * @return string $res : the result
     */
    public function search($table, $column, $searchWord)
    {
        // Set the sql
        $sql = "SELECT * FROM $table WHERE $column LIKE ?";
        $searchWord = "%$searchWord%";
        $param = [$searchWord];

        // Get the data
        $res = $this->dbConnection->getData($sql, $param);

        return $res;
    }


    /**
     * The freeTextSQL
     * Method for free text sql
     *
     * @param string $sql : the sql to use
     *
     * @return string $res : the result
     */
    public function freeTextSQL($sql)
    {
        // Get the data
        $res = $this->dbConnection->getData($sql);

        return $res;
    }


    /**
     * The reset
     * Method for resetting database
     *
     * @param file $file : the reset file
     *
     * @return boolean : true if done
     */
    public function reset($file)
    {
        $res = false;
        $resetSQL = '';
        if (is_file($file)) {
            include $file;
            $this->freeTextSQL($resetSQL);
            $res = true;
        }
        return $res;
    }


    /**
     * The countRows
     * Count nr of rows in a table
     *
     * @param string $idVar : identifying variable
     * @param string $table : which table to use
     *
     * @return array : res
     */
    public function countRows($idVar, $table)
    {
        $sql = "SELECT COUNT($idVar) AS 'rows' FROM $table";

        // Get the data
        $res = $this->dbConnection->getData($sql);

        return $res;
    }


    /**
     *   The selectLimitOffset
     *   Display only a certain section of rows
     *
     * @param string $table   : the table to display from
     * @param string $limit   : how many per page
     * @param int    $offset  : how many per page
     * @param string $orderBy : is set if result should be in order
     * @param string $order   : is set with the order, if any
     *
     * @return array : the result array
     */
    public function selectLimitOffset(
        $table,
        $limit,
        $offset,
        $orderBy = null,
        $order = null
    ) {
        $sql = "SELECT * FROM $table LIMIT $limit OFFSET $offset;";

        if ($orderBy && $order) {
            $sql = "SELECT * FROM $table ORDER BY";
            $sql .= " $orderBy $order LIMIT $limit OFFSET $offset;";
        }

        // Get the data
        $res = $this->dbConnection->getData($sql);

        return $res;
    }
}
