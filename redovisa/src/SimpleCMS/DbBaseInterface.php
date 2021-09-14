<?php
/**
 *  DbBaseInterface
 *  php version 7
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
 *  DbBaseInterface
 * DbBaseInterface is the interface for the db connection class DbBase.
 *  php version 7
 *
 * @category DbConnection
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

interface DbBaseInterface
{
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
    public function getData($sql, $param = []);
    //
    // /**
    //  * The statementException
    //  * Through exception with detailed message. (by Mos)
    //  *
    //  * @param PDOStatement $sth   statement with error
    //  * @param string       $sql   statement to execute
    //  * @param array        $param to match ? in statement
    //  *
    //  * @return void
    //  *
    //  * @throws Exception
    //  */
    // public function statementException($sth, $sql, $param);
}
