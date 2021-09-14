<?php
/**
 *  DbAPI
 *  php version 7
 *
 *  API for connecting to database
 *  Can support different modules / frameworks for database connection
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
 // phpcs:disable PEAR.NamingConventions.ValidVariableName.PrivateNoUnderscore

/**
 *  DbAPI
 *  php version 7
 *
 *  Create a port for connecting to a database
 *  Can use different database modules for connection
 *  This class will serve as an adaptor
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  MIT yso@spektatum.com
 * @link     MIT yso@spektatum.com
 **/

class DbAPI implements DbBaseInterface
{
    /**
     * DbAPI
     *
     * @var object $dbc    The database class
     */

    private $dbBase; // The database connection, dbBase object
    private $anax; // The anax object


    /**
     * Constructor to initiate db connection
     * & global variable connection
     *
     * @param object $dbBase : dbCrud database connections
     * @param object $anax   : the anax connection
     */
    public function __construct(
        DbBaseInterface $dbBase = null,
        $anax = null
    ) {
        $this->dbBase = $dbBase;

        if ($anax) {
            $this->anax = $anax;
            $this->anax->db->connect();
        }
    }



    /**
     * Get menu
     * Delivers the menu
     *
     * @param string $sql   : the sql statement
     * @param array  $param : the sql parameters
     *
     * @return object : $res : the result
     */
    public function getData($sql, $param = [])
    {
        $data = null;


        if ($this->dbBase) {
            $data = $this->dbBase->getData($sql, $param);
        }

        if ($this->anax) {
            $data = $this->anax->db->executeFetchAll($sql, $param);
        }

        return $data;
    }
}
