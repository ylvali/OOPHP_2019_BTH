<?php
/*
* Try catching an exception
*
*/

/**
 * The config and the autoloader
 */
include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload.php");


/*
* Initiate the objects
*/
$person = new Person5("MegaMic");
$person->setAge(-42);

$person = new Person5("MegaMic", -42);

/*
* Another way of trying and catching exception
*/
try {
    $person = new Person5("MegaMic");
    $person->setAge(-42);
} catch (PersonAgeException $e) {
    echo "Got exception: " . get_class($e) . "<hr>";
}
