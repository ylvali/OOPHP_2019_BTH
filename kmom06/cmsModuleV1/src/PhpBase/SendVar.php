<?php
/**
 *   SendVar
 *   Works with the superglobal variables $_GET & $_POST
 *   php version 7
 *   Works with session
 *
 * @category SendVar
 * @package  PhpBase
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

namespace Ylva\PhpBase;
use Exception;

/**
 * SendVar collects incoming $_GET & $_POST variables.
 * Security with trim, htmlentities & strip_tags
 *
 * @category                SendVar
 * @package                 PhpBase
 * @author                  Ylva Sjölin <yso@spektatum.com>
 * @license                 free to use
 * @link                    none
 * @SuppressWarnings(PHPMD) Suppressed the warning
 * The direct use of $_GET / $_POST causes a warning
 **/

class SendVar
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


}
