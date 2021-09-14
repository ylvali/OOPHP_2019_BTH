<?php
/**
 *   SessionVar
 *   php version 7
 *   Works with session
 *
 * @category Session
 * @package  Session
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  CC BY-NC 4.0 https://www.spektatum.com
 * @link     https://creativecommons.org/licenses/by-nc/4.0/
 **/

namespace Anax\SimpleCMS;

use Exception;

/**
 *   SessionVar
 *   php version 7
 *   Works with session
 *
 * @category                Session
 * @package                 Session
 * @author                  Ylva Sjölin <yso@spektatum.com>
 * @license                 free to use
 * @link                    none
 * @SuppressWarnings(PHPMD) Suppressed the warning
 * because the direct use of $_SESSION causes error
 **/

class SessionVar
{

    /**
     * Constructor to initiate
     */
    public function __construct()
    {
    }

    /**
     * Get value
     * Collects value from $_SESSION
     *
     * @param string $varName : name of $_SESSION value
     *
     * @return string $var : the value of $_SESSION
     */
    public function getValue($varName)
    {
        $var = isset($_SESSION[$varName]) ?
        filter_var(htmlentities($_SESSION[$varName])) : null;

        return $var;
    }

    /**
     * Get value array
     * Collects value from $_SESSION
     *
     * @param string $varName : array name of $_SESSION value
     *
     * @return string $var   : the values of $_SESSION
     */
    public function getValueArr($varName)
    {
        $var = isset($_SESSION[$varName]) ?
        $_SESSION[$varName] : null;
        // filter_var(htmlentities($_SESSION[$varName])) : null;

        // Run each data post with htmlentities
        if ($var) {
            foreach ($var as $key => $value) {
                $value = htmlentities($value);
            }
            unset($value);
        }

        return $var;
    }

    /**
     * Set value
     * Sets a value to $_SESSION
     *
     * @param string $varName : name of $_SESSION var
     * @param string $value   : name of $_SESSION value
     *
     * @return void
     */
    public function setValue($varName, $value)
    {
        $_SESSION[$varName] = htmlentities($value);
    }

    /**
     * Set valueArr
     * Sets a value to $_SESSION
     *
     * @param array $varName  : name of $_SESSION var
     * @param array $valueArr : name of $_SESSION value
     *
     * @return void
     */
    public function setValueArr($varName, array $valueArr)
    {
        // Run each data post with htmlentities
        if ($valueArr) {
            foreach ($valueArr as $key => $value) {
                $value = htmlentities($value);
            }
            unset($value);
        }
        $_SESSION[$varName] = $valueArr;
    }

    /**
     * The unsetVar
     * remove a value from $_SESSION
     *
     * @param string $varName : name of $_SESSION var
     *
     * @return void
     */
    public function unsetVar($varName)
    {
        unset($_SESSION[$varName]);
    }

    // /**
    //  * Destroy a session, the session must be started.
    //  * Function from dbwebb
    //  *
    //  * @return void
    //  */
    // public function sessionDestroy()
    // {
    //     // Unset all of the session variables.
    //     $_SESSION = [];
    //
    //     // If it's desired to kill the session, also delete the session cookie.
    //     // Note: This will destroy the session, and not just the session data!
    //     if (ini_get("session.use_cookies")) {
    //         $params = session_get_cookie_params();
    //         setcookie(
    //             session_name(),
    //             '',
    //             time() - 42000,
    //             $params["path"],
    //             $params["domain"],
    //             $params["secure"],
    //             $params["httponly"]
    //         );
    //     }
    //
    //     // Finally, destroy the session.
    //     session_destroy();
    // }
}
