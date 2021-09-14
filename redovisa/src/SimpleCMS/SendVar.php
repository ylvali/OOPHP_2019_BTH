<?php
/**
 *   SendVar v3.1
 *   Works with the superglobal variables $_GET & $_POST
 *
 *   V3.1 includes getPostArray($posts) (Updated: 2021-08)
 *   php version 7
 *
 * @category SendVarV1
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  CC BY-NC 4.0 https://www.spektatum.com
 * @link     https://creativecommons.org/licenses/by-nc/4.0/
 **/

namespace Anax\SimpleCMS;

use Exception;

/**
 * SendVar V1 collects incoming $_GET & $_POST variables.
 * Security with trim, htmlentities & strip_tags
 *
 * @category                SendVar
 * @package                 SendVar
 * @author                  Ylva Sjölin <yso@spektatum.com>
 * @license                 MIT licence
 * @link                    MIT licence https://www.spektatum.com
 * @SuppressWarnings(PHPMD) Suppressed the warning
 * The direct use of $_GET / $_POST causes a warning
 **/

class SendVar implements SendVarInterface
{
    /**
     * Constructor to initiate
     */
    public function __construct()
    {
    }


    /**
     * Collects value from $_GET
     *
     * @param string $varName : name of $_GET value
     *
     * @return string $var : the value of $_GET
     */
    public function getValue($varName)
    {
        $var = isset($_GET[$varName]) ? $_GET[$varName] : null;
        if ($var) {
            $var = htmlentities(strip_tags(trim($var)));
        }

        return $var;
    }


    /**
     * Sets value to $_GET
     *
     * @param string $varName  : name of $_GET value
     * @param string $varValue : $_GET value
     *
     * @return void
     */
    public function setGetValue($varName, $varValue)
    {
        $value = htmlentities($varValue);
        $_GET[$varName] = $varValue;
    }


    /**
     * Collects value from $_POST
     *
     * @param string $varName : name of $_POST value
     *
     * @return string $var : the value of $_POST
     */
    public function postValue($varName)
    {
        $var = isset($_POST[$varName]) ? $_POST[$varName] : null;
        if ($var) {
            $var = htmlentities(strip_tags(trim($var)));
        }

        return $var;
    }


    /**
     * Sets value to $_POST
     *
     * @param string $varName  : name of $_POST value
     * @param string $varValue : $_POST value
     *
     * @return void
     */
    public function setPostValue($varName, $varValue)
    {
        $value = htmlentities($varValue);
        $_POST[$varName] = $varValue;
    }


    /**
     * Get the named values from $_POST
     * Return an array with data
     *
     * @param array $postKeys : the full $_POST
     *
     * @return array $postArr : assosiative array, names & values
     */
    public function getPostArray($postKeys)
    {
        $postArr = [];
        foreach ($postKeys as $key) {
            // if ($this->postValue($key)) {
            //     $postArr[$key] = $this->postValue($key);
            // }
            $postArr[$key] = $this->postValue($key);
        }

        return $postArr;
    }
}
