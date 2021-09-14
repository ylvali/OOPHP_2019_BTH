<?php
/**
 *  DbCrudInterface
 *  php version 7
 *  The interface for dbCrud
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  CC BY-NC 4.0 https://www.spektatum.com
 * @link     https://creativecommons.org/licenses/by-nc/4.0/
 **/

 namespace Anax\SimpleCMS;

/**
 *  DbCrudInterface
 *  php version 7
 * DbBaseInterface is the interface for the db connection class DbBase.
 *
 * @category Dbconnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT https://www.spektatum.com
 * @link     MIT https://www.spektatum.com
 **/

interface DbCrudInterface
{
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
    public function create($table, $params);

    /**
     * The read
     * Method for reading database
     *
     * @param string $table : which table to use
     *
     * @return string $res : the result returned
     */
    public function read($table);

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
    public function update($table, $params, $identifyingVar, $identifyingValue);
}
