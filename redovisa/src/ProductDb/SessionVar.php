<?php
/**
 *   SessionVar
 *   php version 7
 *   Works with session
 *
 * @category Session
 * @package  Session
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/

namespace Anax\ProductDb;

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
        $_SESSION[$varName] = $value;
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
