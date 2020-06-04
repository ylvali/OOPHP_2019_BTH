<?php
/**
 *  DbBase
 *  php version 7
 *
 * @category DbConnection
 * @package  ProjectDb
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 * @phpcs:disable PEAR.NamingConventions.ValidFunctionName.PrivateNoUnderscore"
 **/

namespace Anax\ProductDb;

use PDO;
use Exception;

// More info on set up
// https://dbwebb.se/kunskap/kom-igang-med-php-pdo-och-mysql-v2


/**
 *  DbBase
 *  php version 7
 * DbBase is a base for database connection.
 * It uses the PDO to communicate with the database.
 * It is made for inheritance/dependency injection for database connection.
 *
 * Written to be testable without getting the errors from PDO.
 * By setting a test param to true, all the PDO exception errors are tested.
 *
 * @category DbConnection
 * @package  ProjectDb
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

// Disabling phpcs because of private methods needing underscore.
// Which phpmd says is not CamelCase
 // phpcs:disable

class DbBase implements DbBaseInterface
{
    /**
     * The DbBase for PDO - database communication
     *
     * @var object $dbPDO    The database class
     * @var array $dbDetails The connection details
     * @var array $test      Array with booleans for testing
     */

    public $dbPDO; // The database PDO connection
    public $dbDetails; // The database details
    public $test; // The database details
    public $anaxOn; // The database details
    public $theAnaxApp; // The database details


    /**
     * Constructor to initiate db connection
     * using login & DSN details
     *
     * @param string  $host     : host name
     * @param string  $dbName   : database name
     * @param string  $user     : login name
     * @param string  $password : password
     * @param string  $test     : desicions on testing
     * @param boolean $anaxOn   : Plugin to Anax
     * @param object  $anaxApp  : ANAX app object
     */
    public function __construct($host, $dbName, $user, $password, $test=null, $anaxOn=false, $anaxApp=null)
    {
        // Set up for phpunit test
        $this->test['prepare'] = false;
        $this->test['execute'] = false;
        $this->test['fetchAll'] = false;

        if ($test) {
            $this->test = $test;
        }

        // Save connection details
        $this->dbDetails['host']  = $host;
        $this->dbDetails['dbName'] = $dbName;
        $this->dbDetails['user'] = $user;
        $this->dbDetails['password'] = $password;

        // Connect to database
        $dsn = "mysql:dbname=$dbName;host=$host";
        $user = "$user";
        $password = "$password";
        $utf8 = array(PDO::MYSQL_ATTR_INIT_COMMAND
            => 'SET NAMES \'UTF8\''); // utf8 encoding

        try {
            $this->dbPDO = new PDO($dsn, $user, $password, $utf8);
            // Set attribute to decide how
            // the data from the database will be delivered
            $this->dbPDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            //throw $e; // Put on if you want details for the error
            //echo 'Need to fix something: ' . $e->getMessage();
        }

        /// ANAX plugin
        // If anax is plugged in, it will be used.
        if ($anaxOn && $anaxApp) {
            // echo 'anax is on';
            $this->theAnaxApp = $anaxApp;
            $this->theAnaxApp->db->connect();
        }
    }


    /**
     * The getData
     * getData gets the data from the database
     * it works according to the PDO scheme:
     * prepare, execute, fetch
     *
     * @param string $sql   : the sql statement
     * @param array  $param : the sql parameters
     *
     * @return object : $res : the result
     */
    public function getData($sql, $param=[])
    {
        // prepare
        $statementPDO = $this->prepare($sql, $param);

        // execute
        $statementPDO = $this->execute($statementPDO, $sql, $param);

        // fetch all
        $res = $this->fetchAll($statementPDO, $param, $sql);



        /// ANAX
        if ($this->theAnaxApp && $this->anaxOn) {
            $res = $this->theAnaxApp->db->executeFetchAll($sql, $param);
        }

        return $res;
    }


    /**
     * The prepare
     * prepares the data according to PDO system
     * it will use the PDO method 'prepare' to
     * create an object of the PDO Statement Class from the sql
     *
     * @param string : $sql   : the sql statement
     * @param array  : $param : the sql parameters
     *
     * @return object $statementPDO;
     */
    private function prepare($sql, $param)
    {

        // prepare
        $statementPDO = $this->dbPDO->prepare($sql);
        if (!$statementPDO || $this->test['prepare'] == true) {
            $this->statementException($statementPDO, $sql, $param);
        }
        return $statementPDO;
    }


    /**
     * The execute
     * execute the data according to PDO system
     * it will use the PDO method 'execute' to
     * execute the sql statement
     *
     * @param object : $statementPDO : the sql statement object
     * @param string : $sql          : the sql statement object
     * @param array  : $params       : the sql parameters
     *
     * @return object $statementPDO;
     */
    private function execute($statementPDO, $sql, $params)
    {
        // execute
        $status = $statementPDO->execute($params);
        if (!$status || $this->test['execute'] == true) {
            $this->statementException($statementPDO, $sql, $params);
        }
        return $statementPDO;
    }


    /**
     * The fetch
     * execute the data according to PDO system
     * it will use the PDO method 'fetch' to
     * fetch (collect) the data from the sql statement
     *
     * @param object : $statementPDO : the sql statement object
     * @param array  : $param        : the sql parameters
     * @param string : $sql          : the sql statement
     *
     * @return object $statementPDO;
     */
    private function fetchAll($statementPDO, $param, $sql)
    {
        // fetch all
        $res = $statementPDO->fetchAll();
        if ($res === false || $this->test['fetchAll'] == true) {
            $this->statementException($statementPDO, $sql, $param);
        }
        return $res;
    }


    /**
     * The statementException
     * Through exception with detailed message. (by Mos)
     *
     * @param PDOStatement $sth   statement with error
     * @param string       $sql   statement to execute
     * @param array        $param to match ? in statement
     *
     * @return void
     *
     * @throws Exception
     */
    public function statementException($sth, $sql, $param)
    {
        throw new DbBaseException(
            $sth->errorInfo()[2]
            . "<br><br>SQL ("
            . substr_count($sql, "?")
            . " params):<br><pre>$sql</pre><br>PARAMS ("
            . count($param)
            . "):<br><pre>"
            . implode($param, "\n")
            . "</pre>"
            // . ((count(array_filter(array_keys($param), 'is_string')) > 0)
            //     ? "WARNING your params array has keys, should only have values."
            //     : null)
        );
    }
}

// phpcs:enable
