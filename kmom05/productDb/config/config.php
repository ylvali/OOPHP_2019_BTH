<?php
/**
 *   Config
 *   Sets up config
 *   php version 7
 *
 * @category DbConnection
 * @package  Products
 * @author   Ylva Sjölin <yso@spektatum.com>
 * @license  free to use
 * @link     none
 **/


/*
 * Set the error reporting.
 */
error_reporting(-1);              // Report all type of errors
ini_set("display_errors", 1);     // Display all errors


/*
 * Default exception handler.
 */
set_exception_handler(
    function ($e) {
         echo "Uncaught exception: <p>"
        . $e->getMessage()
        . "</p><p>Code: "
        . $e->getCode()
        . "</p><pre>"
        . $e->getTraceAsString()
        . "</pre>";
    }
);


/*
 *
 * Details for connecting to the database.
 *
 */

$databaseConfig = [
    "dsn"      => "mysql:host=127.0.0.1;dbname=oophp;",
    "login"    => "user",
    "password" => "pass",
    "options"  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
];


/*
*
*   SQL reset file
*
*/

$sqlResetFile = __DIR__.'/../db/reset.php';


/*
*
*   SESSION
*   Disabled because phpmd request that it should be kept in an object
*   because it accesses super-global var $_SESSION
*/

// Start the named session,
// the name is based on the path to this file.
$name = preg_replace("/[^a-z\d]/i", "", __DIR__);
session_name($name);
session_start();

// /*
//  * Destroy a session, the session must be started.
//  *
//  * @return void
//  */
// function sessionDestroy()
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


/*
*
*   Db config
*
*/
$host = '127.0.0.1';
$db = 'oophp';
$user = 'user';
$pass = 'pass';
