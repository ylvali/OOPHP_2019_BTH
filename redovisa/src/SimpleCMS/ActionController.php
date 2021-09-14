<?php
/**
 *  ActionController
 *  php version 7
 *
 * @category ActionController
 * @package  TheBasePHP
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  CC BY-NC 4.0 https://www.spektatum.com
 * @link     https://creativecommons.org/licenses/by-nc/4.0/
 **/

namespace Anax\SimpleCMS;

use PDO;
use Exception;

// phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore
// phpcs:disable PEAR.NamingConventions.ValidVariableName.PrivateNoUnderscore


/**
 *  ActionController
 *  php version 7
 *
 * The main controller of the objects in the system.
 * Is the API between framework routes and program logic.
 *
 * @category ActionController
 * @package  TheBasePHP
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT yso@spektatum.com
 * @link     MIT yso@spektatum.com
 **/
class ActionController
{
    /**
     * The ActionController with API routes for the system
     *
     * @var object $dbPDO    The database class
     * @var array $dbDetails The connection details
     * @var array $test      Array with booleans for testing
     */

    private $theDb;               // The database connection

    /**
     * Constructor to initiate db connection
     * using login & DSN details
     *
     * @param object $dbCrud : dbCrud interface
     */
    public function __construct(
        DbCrudInterface $dbCrud
    ) {
        // Place incoming object as properties
        $this->theDb = $dbCrud;
    }

    /**
     * RouteTest
     * tests db connection with the base test database
     *
     * @return object : $res : the result
     */
    public function routeTest()
    {
        // test route
        $table = 'theBasePHPTest';
        $orderBy = 'asc';
        $column = 'id';
        $res = $this->theDb->read($table, $column, $orderBy);

        return $res;
    }

    // /**
    //  * DatabaseConnection
    //  * Returns the database connection details
    //  *
    //  * @return object : $res : the result
    //  */
    // public function databaseConnection()
    // {
    //     // test database connection
    //     $res = $this->theDb->connectionDetailsString();
    //
    //     return $res;
    // }
}

// phpcs:enable
