<?php
/**
 *  SystemController
 *  Centralized system control v1
 *
 *  Meant to handle the framework functionality
 *  And be a plugin if other frameworks are used.
 *  Type of framework API that will use the framework loaded into a variable.
 *
 *  Project specific with hardcoded data
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
 // phpcs:disable PEAR.NamingConventions.ValidVariableName.PrivateNoUnderscore

/**
 *  SystemController
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

class SystemController
{
    /**
     * SystemController
     *
     * @var object $dbc    The database class
     */

    public $dbC; // The database connection, dbCrud object
    private $varG; // The connection to global variables, $_POST & $_GET
    private $anaxVarG; // The anax connection to global variables, $_POST & $_GET


    /**
     * Constructor to initiate db connection
     * & global variable connection
     *
     * @param object $dbC  : dbCrud database connections
     * @param object $varG : SendVar global variable connection (send variables)
     * @param object $anaxSend : SendVar global variable connection
     */
    public function __construct(
        DbCrudInterface $dbC,
        SendVarInterface $varG = null,
        $anaxVarG = null
    ) {
        $this->dbC = $dbC;
        $this->varG = $varG;
        $this->anaxVarG = $anaxVarG;

        if ($anaxVarG) {
            $anaxVarG->init();
        }
    }



    /**
     * Get menu
     * Delivers the menu
     *
     * @return string $menu : deliver menu
     */
    public function getMenu()
    {
        $menu = "<form action ='' method='post'>
                <input type='submit' class='btn1' name='pageSection' value='blog'>
                <input type='submit' class='btn1' name='pageSection' value='page1'>
                <input type='submit' class='btn1' name='pageSection' value='page2'>
                </form>";

        return $menu;
    }



    /**
     * Get post data
     * Route for array or string
     * Delivers specific data
     *
     * @param array $postData : includes the post. Array or string.
     *
     * @return mixed $postRes : null, string or array (depends on argument nature)
     */
    public function postData($postData)
    {
        // Extract values. If not found, set to null.

        // if array:
        if (is_array($postData)) {
            $postRes = $this->postRoute($postData);
        }

        // if string:
        if (is_string($postData)) {
            $postRes = $this->postRoute2($postData);
        }

        return $postRes;
    }



      /**
       * PostRoute
       * Chooses the way to get a post value
       *
       * @param array $keyArray : array with keys
       *
       * @return array $theArray : array from POST
       */
    private function postRoute($keyArray)
    {
        $postRes = null;

        if (!is_array($keyArray)) {
            return;
        }

        if ($this->varG) {
              $postRes = $this->varG->getPostArray($keyArray);
        }

        if ($this->anaxVarG) {
              $valueArr = [];
            foreach ($keyArray as $instance) {
                $valueArr[$instance] = $this->anaxVarG->getPost($instance);
            }
              $postRes = $valueArr;
        }

        return $postRes;
    }


      /**
       * PostRoute
       * Chooses the way to get a post value
       *
       * @param array $keyArray : array with keys
       *
       * @return array $theArray : array from POST
       */
    private function postRoute2($postData)
    {
        $postRes = null;

        if (!is_string($postData)) {
            return;
        }

        if ($this->varG) {
              $postRes = $this->varG->postValue($postData);
        }

        if ($this->anaxVarG) {
              $postRes = $this->anaxVarG->getPost($postData);
        }

        return $postRes;
    }
}
