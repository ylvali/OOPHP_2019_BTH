<?php
/**
 *  SendVarInterface
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
 *  SendVarInterface
 *  php version 7
 *
 * @category DbConnection
 * @package  SimpleCMS
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

interface SendVarInterface
{

    /**
     * Collects value from $_GET
     *
     * @param string $varName : name of $_GET value
     *
     * @return string $var : the value of $_GET
     */
    public function getValue($varName);
}
