<?php
/**
 *  DbCrud v.3.1
 *
 * The v.3.1 includes
 *  - the 'selectLimitOffsetWhere'
 *  - the v.3.1 includes the 'search' combined w 'searchExact'
 *
 *  php version 7
 *  Database CRUD - create | read | update | delete
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  CC BY-NC 4.0 https://www.spektatum.com
 * @link     https://creativecommons.org/licenses/by-nc/4.0/
 **/

namespace Anax\SimpleCMS;

use PDO;
use Exception;

/**
 *  DbCrudInterface
 *  php version 7
 *
 * DbCrud is a class for the CRuD commands.
 * Creating a simple access to the database.
 * It uses DbBase via dependency injection and depends on its interface
 * for database connection via PDO.
 *
 * v2 : search branches : searchIncl / searchExact
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT  www.spektatum.com
 * @link     MIT www.spektatum.com
 **/

class DbCrud implements DbCrudInterface
{

    // use DbDetails;

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
        // var_dump($this->dbConnection);
    }

    /**
     * The create
     * Method for creating new item in database
     * Creates a new item from sql
     *
     * @param string $table  : which table to use
     * @param array  $params : (columnName => newValue)
     *
     * @return boolean $res : execution result, true / false
     */
    public function create($table, $params)
    {
        // ** Set the sql **
        // Create a string $sql
        $sql = "INSERT INTO $table ";

        // implode keys of $array...
        $sql .= "(".implode(", ", array_keys($params)).")";

        // get the values as an array
        $params = array_values($params);

        // string with ? for the pdo object
        $nrParams = count($params);
        $sql .= " VALUES (";
        for ($i=0; $i<$nrParams; $i++) {
            $sql .= '?,';
        };

        // remove the last coma
        $sql = rtrim($sql, ",");

        // finish the sql
        $sql .= ");";

        // ** Send to the db **
        try {
            $res = $this->dbConnection->getData($sql, $params);
            $res = true;
        } catch (\Exception $e) {
            // var_dump($e);
            $res = false;
        }
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
        try {
            $res = $this->dbConnection->getData($sql);
        } catch (\Exception $e) {
            $res = '';
        }
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

          $sql .= " WHERE $identifyingVar = ?;";
          $paramsValue[] = $identifyingValue;

        // ** Send to the db **
        try {
              $this->dbConnection->getData($sql, $paramsValue);
              $res = true;
        } catch (\Exception $e) {
              $res = false;
        }

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
     * @return mixed $res     : the result - false on crash, res on delete
     *                                   (true even if no item to delete )
     */
    public function delete($table, $column, $idValue)
    {
        // ** Set up the SQL **
        $sql = "DELETE FROM $table WHERE $column = ?";

        $params = array($idValue);

        // ** Send to the db **
        try {
            $res = $this->dbConnection->getData($sql, $params);
        } catch (\Exception $e) {
            $res = false;
        }
        return $res;
    }


    /**
     * The search
     * Method for searching in database
     * Search for inclusion of the word
     *
     * @param string  $table      : which table to use
     * @param string  $column     : which column to use
     * @param string  $searchWord : which searched word
     * @param boolean $included   : set true for included
     *
     * @return string $res : the result
     */
    public function search($table, $column, $searchWord, $included = null)
    {
        // Set the sql
        $sql = "SELECT * FROM $table WHERE $column LIKE ?";
        if ($included) {
            $searchWord = "%$searchWord%";
        }
        $param = [$searchWord];

        // Get the data
        try {
            $res = $this->dbConnection->getData($sql, $param);
        } catch (\Exception $e) {
            $res = false;
        }
        return $res;
    }

    // /**
    //  * The searchExact
    //  * Method for searching in database
    //  * Search for exact word
    //  *
    //  * @param string $table      : which table to use
    //  * @param string $column     : which column to use
    //  * @param string $searchWord : which searched word
    //  *
    //  * @return string $res : the result
    //  */
    // public function searchExact($table, $column, $searchWord)
    // {
    //     // Set the sql
    //     try {
    //         $sql = "SELECT * FROM $table WHERE $column LIKE ?";
    //         $searchWord = "$searchWord";
    //         $param = [$searchWord];
    //
    //         // Get the data
    //         $res = $this->dbConnection->getData($sql, $param);
    //
    //         return $res;
    //     } catch (\Exception $e) {
    //         $res = false;
    //     }
    //
    //     return $res;
    // }


    /**
     * The freeTextSQL
     * Method for free text sql
     *
     * @param string $sql   : the sql command
     * @param array  $param : the parameters for the sql command, dynamic
     *
     * @return string $res : the result
     */
    public function freeTextSQL($sql, $param = [])
    {
        // Get the data
        try {
            $res = $this->dbConnection->getData($sql, $param);
        } catch (\Exception $e) {
            $res = '';
        }
        return $res;
    }


    // /**
    //  * The reset
    //  * Method for resetting database
    //  *
    //  * @param file $file : the reset file
    //  *
    //  * @return boolean : true if done
    //  */
    // public function reset($file)
    // {
    //     $res = false;
    //     $resetSQL = '';
    //     if (is_file($file)) {
    //         include $file;
    //         $this->freeTextSQL($resetSQL);
    //         $res = true;
    //     }
    //     return $res;
    // }


    /**
     * The countRows
     * Count nr of rows in a table
     *
     * @param string $idVar  : identifying variable
     * @param string $table  : which table to use
     * @param string $column : condition column (where condition)
     * @param string $idVal  : condition id (id for the condition)
     *
     * @return array : res
     */
    public function countRows($idVar, $table, $column = null, $idVal = null)
    {
        $sql = "SELECT COUNT($idVar) AS 'rows' FROM $table";
        $param = [];

        if ($column && $idVal) {
            $sql = "SELECT COUNT($idVar) AS 'rows' FROM $table
                    WHERE $column LIKE ? ";
            $param = [$idVal];
        }

        // Get the data
        try {
            $res = $this->dbConnection->getData($sql, $param);
        } catch (\Exception $e) {
            $res = false;
        }
        return $res;
    }


    /**
     *   The selectLimitOffset
     *   Display only a certain section of rows
     *
     * @param string $table   : the table to display from
     * @param string $limit   : how many items to display
     * @param int    $offset  : nr to start at
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
        try {
            $res = $this->dbConnection->getData($sql);
        } catch (\Exception $e) {
            $res = false;
        }
        return $res;
    }

    /**
     *   The selectLimitOffset
     *   Display only a certain section of rows
     *
     * @param string $table   : the table to display from
     * @param string $limit   : how many items to display
     * @param int    $offset  : nr to start at
     * @param string $column  : column for 'where' control
     * @param string $idVal   : value for id for the 'where' control
     * @param string $orderBy : is set if result should be in order
     * @param string $order   : is set with the order, if any
     *
     * @return array : the result array
     */
    public function selectLimitOffsetWhere(
        $table,
        $limit,
        $offset,
        $column,
        $idVal,
        $orderBy = null,
        $order = null
    ) {
        $sql = "SELECT * FROM $table WHERE $column LIKE ?
         LIMIT $limit OFFSET $offset;";

         $params = [$idVal];

        if ($orderBy && $order) {
            $sql = "SELECT * FROM $table
            WHERE $column LIKE ? ORDER BY";
            $sql .= " $orderBy $order LIMIT $limit OFFSET $offset;";
        }

        // Get the data
        try {
            $res = $this->dbConnection->getData($sql, $params);
        } catch (\Exception $e) {
            $res = false;
        }
        return $res;
    }
}
